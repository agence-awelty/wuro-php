<?php

declare(strict_types=1);

namespace Wuro\Services;

use Wuro\Client;
use Wuro\Core\Exceptions\APIException;
use Wuro\Core\Util;
use Wuro\DeliveryReceipts\DeliveryReceiptCreateParams\Line\Type;
use Wuro\DeliveryReceipts\DeliveryReceiptCreateParams\State;
use Wuro\DeliveryReceipts\DeliveryReceiptDeleteResponse;
use Wuro\DeliveryReceipts\DeliveryReceiptGenerateHTMLResponse;
use Wuro\DeliveryReceipts\DeliveryReceiptGetResponse;
use Wuro\DeliveryReceipts\DeliveryReceiptListResponse;
use Wuro\DeliveryReceipts\DeliveryReceiptNewInvoiceResponse;
use Wuro\DeliveryReceipts\DeliveryReceiptNewResponse;
use Wuro\DeliveryReceipts\DeliveryReceiptUpdateResponse;
use Wuro\RequestOptions;
use Wuro\ServiceContracts\DeliveryReceiptsContract;

final class DeliveryReceiptsService implements DeliveryReceiptsContract
{
    /**
     * @api
     */
    public DeliveryReceiptsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new DeliveryReceiptsRawService($client);
    }

    /**
     * @api
     *
     * Crée un nouveau bon de livraison.
     *
     * ## Numérotation automatique
     *
     * Le numéro est attribué automatiquement lorsque le bon passe en état validé
     * (waiting, shipped, delivered). Un bon en brouillon (draft) n'a pas de numéro.
     *
     * ## Structure des lignes
     *
     * Les lignes peuvent être de deux types :
     * - **product** : Ligne produit avec quantité, référence, poids
     * - **header** : Ligne de séparation/titre pour organiser le bon
     *
     * ## Lien avec devis/facture
     *
     * Vous pouvez créer un bon de livraison depuis un devis via `/quote/{uid}/delivery-receipt`
     * ou depuis une facture via `/invoice/{uid}/delivery-receipt`.
     *
     * ## Événement déclenché
     *
     * Un événement `CREATE_RECEIPT` est émis après la création.
     *
     * @param string $client Référence du client (obligatoire)
     * @param string $clientAddress Adresse de livraison
     * @param string $clientCity Ville de livraison
     * @param string $clientCountry Pays de livraison
     * @param string $clientEmail Email du client (pour envoi du bon)
     * @param string $clientName Nom du client (copié du client si non fourni)
     * @param string $clientZipCode Code postal
     * @param string|\DateTimeInterface $date Date du bon (par défaut aujourd'hui)
     * @param list<array{
     *   description?: string,
     *   order?: int,
     *   quantity?: float,
     *   reference?: string,
     *   title?: string,
     *   type?: 'product'|'header'|Type,
     *   weight?: float,
     * }> $lines Lignes du bon de livraison
     * @param string|\DateTimeInterface $shippingDate Date d'expédition prévue
     * @param 'draft'|'waiting'|'shipped'|'delivered'|State $state État initial du bon
     * @param string $title Description courte ou libellé du bon
     * @param 'delivery'|\Wuro\DeliveryReceipts\DeliveryReceiptCreateParams\Type $type Type de document (delivery par défaut)
     *
     * @throws APIException
     */
    public function create(
        string $client,
        ?string $clientAddress = null,
        ?string $clientCity = null,
        string $clientCountry = 'France',
        ?string $clientEmail = null,
        ?string $clientName = null,
        ?string $clientZipCode = null,
        string|\DateTimeInterface|null $date = null,
        ?array $lines = null,
        string|\DateTimeInterface|null $shippingDate = null,
        string|State $state = 'draft',
        ?string $title = null,
        string|\Wuro\DeliveryReceipts\DeliveryReceiptCreateParams\Type $type = 'delivery',
        ?RequestOptions $requestOptions = null,
    ): DeliveryReceiptNewResponse {
        $params = Util::removeNulls(
            [
                'client' => $client,
                'clientAddress' => $clientAddress,
                'clientCity' => $clientCity,
                'clientCountry' => $clientCountry,
                'clientEmail' => $clientEmail,
                'clientName' => $clientName,
                'clientZipCode' => $clientZipCode,
                'date' => $date,
                'lines' => $lines,
                'shippingDate' => $shippingDate,
                'state' => $state,
                'title' => $title,
                'type' => $type,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Récupère les informations détaillées d'un bon de livraison par son identifiant.
     *
     * Les informations retournées incluent :
     * - Les informations client (nom, adresse, email, etc.)
     * - Les lignes du bon (produits, quantités, poids)
     * - L'état actuel du bon (brouillon, en attente, expédié, livré, etc.)
     * - Les dates importantes (création, expédition)
     * - Les liens vers le PDF et la version HTML
     *
     * @param string $uid Identifiant unique du bon de livraison
     * @param string $populate Relations à inclure (ex. "client", "documentModel")
     *
     * @throws APIException
     */
    public function retrieve(
        string $uid,
        ?string $populate = null,
        ?RequestOptions $requestOptions = null
    ): DeliveryReceiptGetResponse {
        $params = Util::removeNulls(['populate' => $populate]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($uid, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Met à jour un bon de livraison existant.
     *
     * ## Gestion de la numérotation
     *
     * Si le bon passe à un état "validé" (waiting, shipped, delivered) et n'a pas encore de numéro,
     * un numéro officiel est automatiquement attribué via le système de numérotation.
     *
     * ## États disponibles
     *
     * - **draft** : Brouillon (modifiable librement)
     * - **waiting** : En attente d'expédition
     * - **shipped** : Expédié
     * - **delivered** : Livré
     * - **refused** : Refusé par le client
     * - **canceled** : Annulé
     * - **inactive** : Supprimé (soft delete)
     *
     * ## Événement déclenché
     *
     * Un événement `UPDATE_RECEIPT` est émis après la mise à jour.
     *
     * @param string $uid Identifiant unique du bon de livraison
     * @param string $clientAddress Adresse du client
     * @param string $clientCity Ville du client
     * @param string $clientCountry Pays du client
     * @param string $clientEmail Email du client
     * @param string $clientName Nom du client
     * @param string $clientZipCode Code postal du client
     * @param string|\DateTimeInterface $date Date du bon de livraison
     * @param list<array{
     *   description?: string,
     *   quantity?: float,
     *   reference?: string,
     *   title?: string,
     *   weight?: float,
     * }> $lines Lignes du bon de livraison
     * @param string|\DateTimeInterface $shippingDate Date d'expédition
     * @param 'draft'|'waiting'|'shipped'|'delivered'|'refused'|'canceled'|'inactive'|\Wuro\DeliveryReceipts\DeliveryReceiptUpdateParams\State $state État du bon de livraison :
     * - **draft** : Brouillon
     * - **waiting** : En attente d'expédition
     * - **shipped** : Expédié
     * - **delivered** : Livré
     * - **refused** : Refusé
     * - **canceled** : Annulé
     * @param string $title Description courte ou libellé du bon
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        ?string $clientAddress = null,
        ?string $clientCity = null,
        ?string $clientCountry = null,
        ?string $clientEmail = null,
        ?string $clientName = null,
        ?string $clientZipCode = null,
        string|\DateTimeInterface|null $date = null,
        ?array $lines = null,
        string|\DateTimeInterface|null $shippingDate = null,
        string|\Wuro\DeliveryReceipts\DeliveryReceiptUpdateParams\State|null $state = null,
        ?string $title = null,
        ?RequestOptions $requestOptions = null,
    ): DeliveryReceiptUpdateResponse {
        $params = Util::removeNulls(
            [
                'clientAddress' => $clientAddress,
                'clientCity' => $clientCity,
                'clientCountry' => $clientCountry,
                'clientEmail' => $clientEmail,
                'clientName' => $clientName,
                'clientZipCode' => $clientZipCode,
                'date' => $date,
                'lines' => $lines,
                'shippingDate' => $shippingDate,
                'state' => $state,
                'title' => $title,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($uid, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Récupère la liste des bons de livraison avec pagination, tri et filtres.
     *
     * **Filtres disponibles:**
     * - `state`: État du bon de livraison
     * - `client`: ID du client
     * - `minDate` / `maxDate`: Plage de dates
     *
     * **Réponse:**
     * - `receipts`: Liste des bons de livraison
     * - `total`: Nombre total
     * - `skip` et `limit`: Paramètres de pagination
     *
     * @param string $client Filtre par ID du client
     * @param int $limit Nombre maximum de bons à retourner
     * @param int $skip Nombre de bons à ignorer (pagination)
     * @param string $sort Champ de tri et direction
     * @param 'draft'|'waiting'|'shipped'|'delivered'|'refused'|'canceled'|'inactive'|\Wuro\DeliveryReceipts\DeliveryReceiptListParams\State $state Filtre par état
     *
     * @throws APIException
     */
    public function list(
        ?string $client = null,
        int $limit = 20,
        int $skip = 0,
        ?string $sort = null,
        string|\Wuro\DeliveryReceipts\DeliveryReceiptListParams\State|null $state = null,
        ?RequestOptions $requestOptions = null,
    ): DeliveryReceiptListResponse {
        $params = Util::removeNulls(
            [
                'client' => $client,
                'limit' => $limit,
                'skip' => $skip,
                'sort' => $sort,
                'state' => $state,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Supprime un bon de livraison (soft delete).
     *
     * Le bon passe en état "inactive" et n'est plus visible dans les listes standards.
     *
     * ## Événement déclenché
     *
     * Un événement `DELETE_RECEIPT` est émis après la suppression.
     *
     * @param string $uid Identifiant unique du bon de livraison
     *
     * @throws APIException
     */
    public function delete(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): DeliveryReceiptDeleteResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($uid, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Transforme un bon de livraison en facture.
     *
     * ## Processus de transformation
     *
     * Cette route crée une nouvelle facture en copiant les informations du bon de livraison :
     * - Informations client (nom, adresse, etc.)
     * - Lignes du bon (produits, quantités)
     *
     * ## Cas d'usage
     *
     * Utile pour facturer après livraison :
     * 1. Créer un devis
     * 2. Créer un bon de livraison depuis le devis
     * 3. Livrer au client
     * 4. Créer la facture depuis le bon de livraison
     *
     * ## Événement déclenché
     *
     * Un événement `CREATE_INVOICE` est émis après la création de la facture.
     *
     * @param string $uid Identifiant unique du bon de livraison source
     *
     * @throws APIException
     */
    public function createInvoice(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): DeliveryReceiptNewInvoiceResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->createInvoice($uid, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Génère et retourne le rendu HTML du bon de livraison.
     *
     * Cette route est utile pour :
     * - Prévisualiser le bon avant génération PDF
     * - Intégrer le contenu dans une page web
     * - Personnaliser l'affichage
     *
     * ## Réponse
     *
     * La réponse inclut :
     * - **template** : Le HTML complet du bon de livraison
     * - **metadata** : Les informations clés du bon (client, numéro, dates, etc.)
     *
     * @param string $uid Identifiant unique du bon de livraison
     *
     * @throws APIException
     */
    public function generateHTML(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): DeliveryReceiptGenerateHTMLResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->generateHTML($uid, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Génère et retourne le PDF du bon de livraison.
     *
     * Le PDF est généré à partir du modèle de document configuré pour l'entreprise
     * et inclut toutes les informations du bon : client, lignes, dates, etc.
     *
     * ## Paramètres de téléchargement
     *
     * - Par défaut, le PDF s'affiche dans le navigateur (inline)
     * - Utilisez `force_download=true` pour forcer le téléchargement
     *
     * ## Format de sortie
     *
     * - Content-Type: application/pdf
     * - Content-Disposition: filename={numero_bon}.pdf
     *
     * @param string $uid Identifiant unique du bon de livraison
     * @param bool $forceDownload Si true, force le téléchargement du fichier au lieu de l'afficher
     *
     * @throws APIException
     */
    public function generatePdf(
        string $uid,
        bool $forceDownload = false,
        ?RequestOptions $requestOptions = null,
    ): string {
        $params = Util::removeNulls(['forceDownload' => $forceDownload]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->generatePdf($uid, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
