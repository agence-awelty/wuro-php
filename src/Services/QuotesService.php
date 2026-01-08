<?php

declare(strict_types=1);

namespace Wuro\Services;

use Wuro\Client;
use Wuro\Core\Exceptions\APIException;
use Wuro\Core\Util;
use Wuro\Quotes\Line\QuoteLine;
use Wuro\Quotes\QuoteCreateParams\State;
use Wuro\Quotes\QuoteCreateParams\Type;
use Wuro\Quotes\QuoteDeleteResponse;
use Wuro\Quotes\QuoteGetLogsResponse;
use Wuro\Quotes\QuoteGetResponse;
use Wuro\Quotes\QuoteGetStatsResponse;
use Wuro\Quotes\QuoteListResponse;
use Wuro\Quotes\QuoteNewAdvanceInvoiceResponse;
use Wuro\Quotes\QuoteNewInvoiceFromQuoteResponse;
use Wuro\Quotes\QuoteNewInvoiceResponse;
use Wuro\Quotes\QuoteNewPackageResponse;
use Wuro\Quotes\QuoteNewProformaInvoiceResponse;
use Wuro\Quotes\QuoteNewPurchaseOrderResponse;
use Wuro\Quotes\QuoteNewResponse;
use Wuro\Quotes\QuoteUpdateResponse;
use Wuro\RequestOptions;
use Wuro\ServiceContracts\QuotesContract;
use Wuro\Services\Quotes\LineService;

/**
 * @phpstan-import-type QuoteLineShape from \Wuro\Quotes\QuoteCreateParams\QuoteLine as QuoteLineShape1
 * @phpstan-import-type QuoteLineShape from \Wuro\Quotes\Line\QuoteLine
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
final class QuotesService implements QuotesContract
{
    /**
     * @api
     */
    public QuotesRawService $raw;

    /**
     * @api
     */
    public LineService $line;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new QuotesRawService($client);
        $this->line = new LineService($client);
    }

    /**
     * @api
     *
     * Crée un nouveau devis.
     *
     * **Numérotation automatique:**
     * - Si l'état est 'pending', 'waiting', 'accepted', 'refused', 'invoiced' ou 'canceled', un numéro est automatiquement attribué
     * - Le créateur (positionCreator) et l'assigné (positionAssigned) sont automatiquement définis
     *
     * **Types de documents:**
     * - `quote`: Devis standard
     * - `proforma`: Facture proforma
     * - `bdc`: Bon de commande
     *
     * **Calculs automatiques:**
     * - Les totaux HT, TVA et TTC sont calculés automatiquement
     *
     * **Événement déclenché:** CREATE_QUOTE
     *
     * @param string $client ID du client
     * @param string $clientName Nom du client (si pas de client référencé)
     * @param \DateTimeInterface $date Date du devis (défaut = maintenant)
     * @param \DateTimeInterface $expiryDate Date de validité
     * @param list<\Wuro\Quotes\QuoteCreateParams\QuoteLine|QuoteLineShape1> $quoteLines Lignes du devis
     * @param State|value-of<State> $state État initial
     * @param string $title Titre/objet du devis
     * @param Type|value-of<Type> $type Type de document
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        ?string $client = null,
        ?string $clientAddress = null,
        ?string $clientCity = null,
        string $clientCountry = 'France',
        ?string $clientEmail = null,
        ?string $clientName = null,
        ?string $clientZipCode = null,
        ?\DateTimeInterface $date = null,
        ?\DateTimeInterface $expiryDate = null,
        ?array $quoteLines = null,
        State|string $state = 'draft',
        ?string $title = null,
        Type|string $type = 'quote',
        RequestOptions|array|null $requestOptions = null,
    ): QuoteNewResponse {
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
                'expiryDate' => $expiryDate,
                'quoteLines' => $quoteLines,
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
     * Récupère les détails complets d'un devis spécifique.
     *
     * **Réponse enrichie:**
     * - Inclut les liens `pdf_link` et `html_link` pour accéder aux documents
     *
     * @param string $uid ID du devis
     * @param string $populate Champs à peupler (ex. "client,documentModel")
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $uid,
        ?string $populate = null,
        RequestOptions|array|null $requestOptions = null,
    ): QuoteGetResponse {
        $params = Util::removeNulls(['populate' => $populate]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($uid, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Met à jour un devis existant.
     *
     * **Numérotation automatique:**
     * - Si le devis passe de 'draft' à un état validé (pending, waiting, accepted, etc.), un numéro est automatiquement attribué
     * - La date est mise à jour automatiquement lors de la numérotation
     *
     * **Événement déclenché:** UPDATE_QUOTE
     *
     * @param string $client ID du client
     * @param \DateTimeInterface $date Date du devis
     * @param \DateTimeInterface $expiryDate Date de validité
     * @param list<QuoteLine|QuoteLineShape> $quoteLines
     * @param \Wuro\Quotes\QuoteUpdateParams\State|value-of<\Wuro\Quotes\QuoteUpdateParams\State> $state État du devis
     * @param string $title Titre/objet du devis
     * @param \Wuro\Quotes\QuoteUpdateParams\Type|value-of<\Wuro\Quotes\QuoteUpdateParams\Type> $type
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        ?string $client = null,
        ?string $clientAddress = null,
        ?string $clientCity = null,
        ?string $clientCountry = null,
        ?string $clientEmail = null,
        ?string $clientName = null,
        ?string $clientZipCode = null,
        ?\DateTimeInterface $date = null,
        ?\DateTimeInterface $expiryDate = null,
        ?array $quoteLines = null,
        \Wuro\Quotes\QuoteUpdateParams\State|string|null $state = null,
        ?string $title = null,
        \Wuro\Quotes\QuoteUpdateParams\Type|string|null $type = null,
        RequestOptions|array|null $requestOptions = null,
    ): QuoteUpdateResponse {
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
                'expiryDate' => $expiryDate,
                'quoteLines' => $quoteLines,
                'state' => $state,
                'title' => $title,
                'type' => $type,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($uid, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Récupère la liste des devis avec pagination, tri et filtres.
     *
     * **Filtres disponibles:**
     * - `state`: État du devis (draft, pending, waiting, accepted, refused, invoiced, canceled, inactive)
     * - `type`: Type de document (quote, proforma, bdc)
     * - `client`: ID du client
     * - `minDate` / `maxDate`: Plage de dates
     * - `number`: Numéro du devis
     * - `search`: Recherche textuelle
     *
     * **Réponse:**
     * - `quotes`: Liste des devis
     * - `total`: Nombre total de devis correspondants
     * - `skip` et `limit`: Paramètres de pagination
     *
     * @param string $client Filtre par ID du client
     * @param int $limit Nombre maximum de devis à retourner
     * @param \DateTimeInterface $maxDate Date maximum
     * @param \DateTimeInterface $minDate Date minimum
     * @param int $skip Nombre de devis à ignorer (pagination)
     * @param string $sort Champ de tri et direction (ex. "date:-1")
     * @param \Wuro\Quotes\QuoteListParams\State|value-of<\Wuro\Quotes\QuoteListParams\State> $state Filtre par état du devis
     * @param \Wuro\Quotes\QuoteListParams\Type|value-of<\Wuro\Quotes\QuoteListParams\Type> $type Filtre par type de document
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        ?string $client = null,
        int $limit = 20,
        ?\DateTimeInterface $maxDate = null,
        ?\DateTimeInterface $minDate = null,
        int $skip = 0,
        ?string $sort = null,
        \Wuro\Quotes\QuoteListParams\State|string|null $state = null,
        \Wuro\Quotes\QuoteListParams\Type|string|null $type = null,
        RequestOptions|array|null $requestOptions = null,
    ): QuoteListResponse {
        $params = Util::removeNulls(
            [
                'client' => $client,
                'limit' => $limit,
                'maxDate' => $maxDate,
                'minDate' => $minDate,
                'skip' => $skip,
                'sort' => $sort,
                'state' => $state,
                'type' => $type,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Supprime (désactive) un devis.
     *
     * **Comportement:**
     * - L'état passe à 'inactive' (soft delete)
     * - Déclenche un événement DELETE_QUOTE
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): QuoteDeleteResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($uid, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Génère une facture d'acompte à partir d'un devis.
     *
     * **Options:**
     * - Spécifier un montant ou un pourcentage de l'acompte
     * - L'acompte est lié au devis d'origine
     *
     * @param string $uid ID du devis
     * @param float $amount Montant de l'acompte
     * @param float $percentage Pourcentage de l'acompte
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function createAdvanceInvoice(
        string $uid,
        ?float $amount = null,
        ?float $percentage = null,
        RequestOptions|array|null $requestOptions = null,
    ): QuoteNewAdvanceInvoiceResponse {
        $params = Util::removeNulls(
            ['amount' => $amount, 'percentage' => $percentage]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->createAdvanceInvoice($uid, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Génère un bon de livraison à partir d'un devis.
     *
     * Le bon de livraison reprend les lignes du devis.
     *
     * @param string $uid ID du devis
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function createDeliveryReceipt(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): mixed {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->createDeliveryReceipt($uid, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Transforme un devis en facture.
     *
     * **Comportement:**
     * - Crée une facture reprenant toutes les informations du devis
     * - Le devis passe à l'état 'invoiced'
     * - La facture est créée avec numérotation automatique
     *
     * @param string $uid ID du devis
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function createInvoice(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): QuoteNewInvoiceResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->createInvoice($uid, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Génère une facture de solde à partir d'un devis.
     *
     * **Comportement:**
     * - Crée une facture reprenant les lignes du devis
     * - Déduit les acomptes déjà facturés
     * - Le devis passe à l'état 'invoiced'
     *
     * @param string $uid ID du devis
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function createInvoiceFromQuote(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): QuoteNewInvoiceFromQuoteResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->createInvoiceFromQuote($uid, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Génère une archive ZIP contenant les PDFs de plusieurs devis.
     *
     * **Comportement:**
     * - Si le nombre de devis > seuil configuré ou `DEFERRED=true`, l'archive est générée en arrière-plan
     * - Un objet Package est créé pour suivre la progression
     * - Une fois terminé, l'archive est téléchargeable via GET /package/{uid}/download
     *
     * @param list<string> $quotesID Liste des IDs de devis à inclure
     * @param bool $deferred Forcer le mode différé
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function createPackage(
        array $quotesID,
        ?bool $deferred = null,
        RequestOptions|array|null $requestOptions = null,
    ): QuoteNewPackageResponse {
        $params = Util::removeNulls(
            ['quotesID' => $quotesID, 'deferred' => $deferred]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->createPackage(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Génère une facture proforma à partir d'un devis.
     *
     * La proforma est une facture sans valeur comptable utilisée comme document préliminaire.
     *
     * @param string $uid ID du devis
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function createProformaInvoice(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): QuoteNewProformaInvoiceResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->createProformaInvoice($uid, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Transforme un devis en bon de commande (BDC).
     *
     * Le bon de commande est un document confirmant la commande avant facturation.
     *
     * @param string $uid ID du devis
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function createPurchaseOrder(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): QuoteNewPurchaseOrderResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->createPurchaseOrder($uid, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Génère et retourne le contenu HTML d'un devis.
     *
     * **Utilisation:**
     * - Prévisualisation dans un navigateur
     * - Intégration dans une iframe
     * - Base pour la génération PDF
     *
     * **Format de réponse:**
     * - Type MIME: text/html
     * - HTML complet avec styles CSS intégrés
     *
     * @param string $uid Identifiant unique du devis
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function generateHTML(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): string {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->generateHTML($uid, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Génère et retourne le fichier PDF d'un devis.
     *
     * **Comportement:**
     * - Utilise le modèle de document configuré pour l'entreprise
     * - Le PDF inclut toutes les informations du devis (client, lignes, totaux)
     * - Le rendu est optimisé pour l'impression
     *
     * **Format de réponse:**
     * - Type MIME: application/pdf
     * - Le fichier est retourné en téléchargement direct
     *
     * @param string $uid Identifiant unique du devis
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function generatePdf(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): string {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->generatePdf($uid, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Génère et retourne le fichier PDF d'un devis en utilisant le moteur de rendu Chromium.
     *
     * **Différences avec /pdf:**
     * - Rendu plus fidèle aux navigateurs modernes
     * - Meilleure gestion des polices et des styles CSS complexes
     * - Temps de génération légèrement plus long
     *
     * **Utilisation recommandée:**
     * - Documents avec mise en page complexe
     * - Besoin d'un rendu identique au navigateur
     *
     * @param string $uid Identifiant unique du devis
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function generatePdfChromium(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): string {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->generatePdfChromium($uid, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Récupère les logs d'actions effectuées sur tous les devis.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function getLogs(
        int $limit = 20,
        int $skip = 0,
        RequestOptions|array|null $requestOptions = null,
    ): QuoteGetLogsResponse {
        $params = Util::removeNulls(['limit' => $limit, 'skip' => $skip]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->getLogs(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Calcule et retourne des statistiques agrégées sur les devis.
     *
     * **Statistiques retournées:**
     * - Totaux HT/TTC par état
     * - Montants min/max
     * - Répartition par type de devis
     *
     * Utilise les mêmes filtres que GET /quotes.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function getStats(
        ?\DateTimeInterface $maxDate = null,
        ?\DateTimeInterface $minDate = null,
        ?string $state = null,
        RequestOptions|array|null $requestOptions = null,
    ): QuoteGetStatsResponse {
        $params = Util::removeNulls(
            ['maxDate' => $maxDate, 'minDate' => $minDate, 'state' => $state]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->getStats(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Récupère l'historique des actions sur un devis spécifique.
     *
     * @param string $uid ID du devis
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveLogs(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): mixed {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveLogs($uid, requestOptions: $requestOptions);

        return $response->parse();
    }
}
