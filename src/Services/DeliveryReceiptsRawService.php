<?php

declare(strict_types=1);

namespace Wuro\Services;

use Wuro\Client;
use Wuro\Core\Contracts\BaseResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\Core\Util;
use Wuro\DeliveryReceipts\DeliveryReceiptCreateParams;
use Wuro\DeliveryReceipts\DeliveryReceiptCreateParams\Line\Type;
use Wuro\DeliveryReceipts\DeliveryReceiptCreateParams\State;
use Wuro\DeliveryReceipts\DeliveryReceiptDeleteResponse;
use Wuro\DeliveryReceipts\DeliveryReceiptGenerateHTMLResponse;
use Wuro\DeliveryReceipts\DeliveryReceiptGeneratePdfParams;
use Wuro\DeliveryReceipts\DeliveryReceiptGetResponse;
use Wuro\DeliveryReceipts\DeliveryReceiptListParams;
use Wuro\DeliveryReceipts\DeliveryReceiptListResponse;
use Wuro\DeliveryReceipts\DeliveryReceiptNewInvoiceResponse;
use Wuro\DeliveryReceipts\DeliveryReceiptNewResponse;
use Wuro\DeliveryReceipts\DeliveryReceiptRetrieveParams;
use Wuro\DeliveryReceipts\DeliveryReceiptUpdateParams;
use Wuro\DeliveryReceipts\DeliveryReceiptUpdateResponse;
use Wuro\RequestOptions;
use Wuro\ServiceContracts\DeliveryReceiptsRawContract;

final class DeliveryReceiptsRawService implements DeliveryReceiptsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

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
     * @param array{
     *   client: string,
     *   clientAddress?: string,
     *   clientCity?: string,
     *   clientCountry?: string,
     *   clientEmail?: string,
     *   clientName?: string,
     *   clientZipCode?: string,
     *   date?: string|\DateTimeInterface,
     *   lines?: list<array{
     *     description?: string,
     *     order?: int,
     *     quantity?: float,
     *     reference?: string,
     *     title?: string,
     *     type?: 'product'|'header'|Type,
     *     weight?: float,
     *   }>,
     *   shippingDate?: string|\DateTimeInterface,
     *   state?: 'draft'|'waiting'|'shipped'|'delivered'|State,
     *   title?: string,
     *   type?: 'delivery'|DeliveryReceiptCreateParams\Type,
     * }|DeliveryReceiptCreateParams $params
     *
     * @return BaseResponse<DeliveryReceiptNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|DeliveryReceiptCreateParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = DeliveryReceiptCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'delivery-receipt',
            body: (object) $parsed,
            options: $options,
            convert: DeliveryReceiptNewResponse::class,
        );
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
     * @param array{populate?: string}|DeliveryReceiptRetrieveParams $params
     *
     * @return BaseResponse<DeliveryReceiptGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $uid,
        array|DeliveryReceiptRetrieveParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = DeliveryReceiptRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['delivery-receipt/%1$s', $uid],
            query: $parsed,
            options: $options,
            convert: DeliveryReceiptGetResponse::class,
        );
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
     * @param array{
     *   clientAddress?: string,
     *   clientCity?: string,
     *   clientCountry?: string,
     *   clientEmail?: string,
     *   clientName?: string,
     *   clientZipCode?: string,
     *   date?: string|\DateTimeInterface,
     *   lines?: list<array{
     *     description?: string,
     *     quantity?: float,
     *     reference?: string,
     *     title?: string,
     *     weight?: float,
     *   }>,
     *   shippingDate?: string|\DateTimeInterface,
     *   state?: 'draft'|'waiting'|'shipped'|'delivered'|'refused'|'canceled'|'inactive'|DeliveryReceiptUpdateParams\State,
     *   title?: string,
     * }|DeliveryReceiptUpdateParams $params
     *
     * @return BaseResponse<DeliveryReceiptUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        array|DeliveryReceiptUpdateParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = DeliveryReceiptUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'patch',
            path: ['delivery-receipt/%1$s', $uid],
            body: (object) $parsed,
            options: $options,
            convert: DeliveryReceiptUpdateResponse::class,
        );
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
     * @param array{
     *   client?: string,
     *   limit?: int,
     *   skip?: int,
     *   sort?: string,
     *   state?: 'draft'|'waiting'|'shipped'|'delivered'|'refused'|'canceled'|'inactive'|DeliveryReceiptListParams\State,
     * }|DeliveryReceiptListParams $params
     *
     * @return BaseResponse<DeliveryReceiptListResponse>
     *
     * @throws APIException
     */
    public function list(
        array|DeliveryReceiptListParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = DeliveryReceiptListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'delivery-receipts',
            query: $parsed,
            options: $options,
            convert: DeliveryReceiptListResponse::class,
        );
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
     * @return BaseResponse<DeliveryReceiptDeleteResponse>
     *
     * @throws APIException
     */
    public function delete(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['delivery-receipt/%1$s', $uid],
            options: $requestOptions,
            convert: DeliveryReceiptDeleteResponse::class,
        );
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
     * @return BaseResponse<DeliveryReceiptNewInvoiceResponse>
     *
     * @throws APIException
     */
    public function createInvoice(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['delivery-receipt/%1$s/invoice', $uid],
            options: $requestOptions,
            convert: DeliveryReceiptNewInvoiceResponse::class,
        );
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
     * @return BaseResponse<DeliveryReceiptGenerateHTMLResponse>
     *
     * @throws APIException
     */
    public function generateHTML(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['delivery-receipt/%1$s/html', $uid],
            options: $requestOptions,
            convert: DeliveryReceiptGenerateHTMLResponse::class,
        );
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
     * @param array{forceDownload?: bool}|DeliveryReceiptGeneratePdfParams $params
     *
     * @return BaseResponse<string>
     *
     * @throws APIException
     */
    public function generatePdf(
        string $uid,
        array|DeliveryReceiptGeneratePdfParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = DeliveryReceiptGeneratePdfParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['delivery-receipt/%1$s/pdf', $uid],
            query: Util::array_transform_keys(
                $parsed,
                ['forceDownload' => 'force_download']
            ),
            headers: ['Accept' => 'application/pdf'],
            options: $options,
            convert: 'string',
        );
    }
}
