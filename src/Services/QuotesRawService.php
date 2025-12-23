<?php

declare(strict_types=1);

namespace Wuro\Services;

use Wuro\Client;
use Wuro\Core\Contracts\BaseResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\Quotes\Line\QuoteLine;
use Wuro\Quotes\QuoteCreateAdvanceInvoiceParams;
use Wuro\Quotes\QuoteCreatePackageParams;
use Wuro\Quotes\QuoteCreateParams;
use Wuro\Quotes\QuoteCreateParams\QuoteLine\Type;
use Wuro\Quotes\QuoteCreateParams\State;
use Wuro\Quotes\QuoteDeleteResponse;
use Wuro\Quotes\QuoteGetLogsParams;
use Wuro\Quotes\QuoteGetLogsResponse;
use Wuro\Quotes\QuoteGetResponse;
use Wuro\Quotes\QuoteGetStatsParams;
use Wuro\Quotes\QuoteGetStatsResponse;
use Wuro\Quotes\QuoteListParams;
use Wuro\Quotes\QuoteListResponse;
use Wuro\Quotes\QuoteNewAdvanceInvoiceResponse;
use Wuro\Quotes\QuoteNewInvoiceFromQuoteResponse;
use Wuro\Quotes\QuoteNewInvoiceResponse;
use Wuro\Quotes\QuoteNewPackageResponse;
use Wuro\Quotes\QuoteNewProformaInvoiceResponse;
use Wuro\Quotes\QuoteNewPurchaseOrderResponse;
use Wuro\Quotes\QuoteNewResponse;
use Wuro\Quotes\QuoteRetrieveParams;
use Wuro\Quotes\QuoteUpdateParams;
use Wuro\Quotes\QuoteUpdateResponse;
use Wuro\RequestOptions;
use Wuro\ServiceContracts\QuotesRawContract;

final class QuotesRawService implements QuotesRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

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
     * @param array{
     *   client?: string,
     *   clientAddress?: string,
     *   clientCity?: string,
     *   clientCountry?: string,
     *   clientEmail?: string,
     *   clientName?: string,
     *   clientZipCode?: string,
     *   date?: string|\DateTimeInterface,
     *   expiryDate?: string|\DateTimeInterface,
     *   quoteLines?: list<array{
     *     description?: string,
     *     discount?: float,
     *     priceHt?: float,
     *     product?: string,
     *     quantity?: float,
     *     reference?: string,
     *     title?: string,
     *     tvaRate?: float,
     *     type?: 'product'|'header'|'subtotal'|'globalDiscount'|Type,
     *     unit?: string,
     *   }>,
     *   state?: 'draft'|'pending'|'waiting'|'accepted'|'refused'|State,
     *   title?: string,
     *   type?: 'quote'|'proforma'|'bdc'|QuoteCreateParams\Type,
     * }|QuoteCreateParams $params
     *
     * @return BaseResponse<QuoteNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|QuoteCreateParams $params,
        ?RequestOptions $requestOptions = null
    ): BaseResponse {
        [$parsed, $options] = QuoteCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'quote',
            body: (object) $parsed,
            options: $options,
            convert: QuoteNewResponse::class,
        );
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
     * @param array{populate?: string}|QuoteRetrieveParams $params
     *
     * @return BaseResponse<QuoteGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $uid,
        array|QuoteRetrieveParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = QuoteRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['quote/%1$s', $uid],
            query: $parsed,
            options: $options,
            convert: QuoteGetResponse::class,
        );
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
     * @param array{
     *   client?: string,
     *   clientAddress?: string,
     *   clientCity?: string,
     *   clientCountry?: string,
     *   clientEmail?: string,
     *   clientName?: string,
     *   clientZipCode?: string,
     *   date?: string|\DateTimeInterface,
     *   expiryDate?: string|\DateTimeInterface,
     *   quoteLines?: list<array{
     *     _id?: string,
     *     description?: string,
     *     priceHt?: float,
     *     quantity?: float,
     *     reference?: string,
     *     title?: string,
     *     totalHt?: float,
     *     totalTtc?: float,
     *     tvaRate?: float,
     *     type?: 'product'|'header'|'subtotal'|'globalDiscount'|QuoteLine\Type,
     *     unit?: string,
     *   }|QuoteLine>,
     *   state?: 'draft'|'pending'|'waiting'|'accepted'|'refused'|'invoiced'|'canceled'|QuoteUpdateParams\State,
     *   title?: string,
     *   type?: 'quote'|'proforma'|'bdc'|QuoteUpdateParams\Type,
     * }|QuoteUpdateParams $params
     *
     * @return BaseResponse<QuoteUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        array|QuoteUpdateParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = QuoteUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'patch',
            path: ['quote/%1$s', $uid],
            body: (object) $parsed,
            options: $options,
            convert: QuoteUpdateResponse::class,
        );
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
     * @param array{
     *   client?: string,
     *   limit?: int,
     *   maxDate?: string|\DateTimeInterface,
     *   minDate?: string|\DateTimeInterface,
     *   skip?: int,
     *   sort?: string,
     *   state?: value-of<QuoteListParams\State>,
     *   type?: 'quote'|'proforma'|'bdc'|QuoteListParams\Type,
     * }|QuoteListParams $params
     *
     * @return BaseResponse<QuoteListResponse>
     *
     * @throws APIException
     */
    public function list(
        array|QuoteListParams $params,
        ?RequestOptions $requestOptions = null
    ): BaseResponse {
        [$parsed, $options] = QuoteListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'quotes',
            query: $parsed,
            options: $options,
            convert: QuoteListResponse::class,
        );
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
     * @return BaseResponse<QuoteDeleteResponse>
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
            path: ['quote/%1$s', $uid],
            options: $requestOptions,
            convert: QuoteDeleteResponse::class,
        );
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
     * @param array{
     *   amount?: float, percentage?: float
     * }|QuoteCreateAdvanceInvoiceParams $params
     *
     * @return BaseResponse<QuoteNewAdvanceInvoiceResponse>
     *
     * @throws APIException
     */
    public function createAdvanceInvoice(
        string $uid,
        array|QuoteCreateAdvanceInvoiceParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = QuoteCreateAdvanceInvoiceParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['quote/%1$s/advance', $uid],
            body: (object) $parsed,
            options: $options,
            convert: QuoteNewAdvanceInvoiceResponse::class,
        );
    }

    /**
     * @api
     *
     * Génère un bon de livraison à partir d'un devis.
     *
     * Le bon de livraison reprend les lignes du devis.
     *
     * @param string $uid ID du devis
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function createDeliveryReceipt(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['quote/%1$s/delivery-receipt', $uid],
            options: $requestOptions,
            convert: null,
        );
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
     *
     * @return BaseResponse<QuoteNewInvoiceResponse>
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
            path: ['quote/%1$s/invoice', $uid],
            options: $requestOptions,
            convert: QuoteNewInvoiceResponse::class,
        );
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
     *
     * @return BaseResponse<QuoteNewInvoiceFromQuoteResponse>
     *
     * @throws APIException
     */
    public function createInvoiceFromQuote(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['quote/%1$s/sold', $uid],
            options: $requestOptions,
            convert: QuoteNewInvoiceFromQuoteResponse::class,
        );
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
     * @param array{
     *   quotesID: list<string>, deferred?: bool
     * }|QuoteCreatePackageParams $params
     *
     * @return BaseResponse<QuoteNewPackageResponse>
     *
     * @throws APIException
     */
    public function createPackage(
        array|QuoteCreatePackageParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = QuoteCreatePackageParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'quotes/package',
            body: (object) $parsed,
            options: $options,
            convert: QuoteNewPackageResponse::class,
        );
    }

    /**
     * @api
     *
     * Génère une facture proforma à partir d'un devis.
     *
     * La proforma est une facture sans valeur comptable utilisée comme document préliminaire.
     *
     * @param string $uid ID du devis
     *
     * @return BaseResponse<QuoteNewProformaInvoiceResponse>
     *
     * @throws APIException
     */
    public function createProformaInvoice(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['quote/%1$s/proforma', $uid],
            options: $requestOptions,
            convert: QuoteNewProformaInvoiceResponse::class,
        );
    }

    /**
     * @api
     *
     * Transforme un devis en bon de commande (BDC).
     *
     * Le bon de commande est un document confirmant la commande avant facturation.
     *
     * @param string $uid ID du devis
     *
     * @return BaseResponse<QuoteNewPurchaseOrderResponse>
     *
     * @throws APIException
     */
    public function createPurchaseOrder(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['quote/%1$s/bdc', $uid],
            options: $requestOptions,
            convert: QuoteNewPurchaseOrderResponse::class,
        );
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
     *
     * @return BaseResponse<string>
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
            path: ['quote/%1$s/html', $uid],
            headers: ['Accept' => 'text/html'],
            options: $requestOptions,
            convert: 'string',
        );
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
     *
     * @return BaseResponse<string>
     *
     * @throws APIException
     */
    public function generatePdf(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['quote/%1$s/pdf', $uid],
            headers: ['Accept' => 'application/pdf'],
            options: $requestOptions,
            convert: 'string',
        );
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
     *
     * @return BaseResponse<string>
     *
     * @throws APIException
     */
    public function generatePdfChromium(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['quote/%1$s/pdf-chromium', $uid],
            headers: ['Accept' => 'application/pdf'],
            options: $requestOptions,
            convert: 'string',
        );
    }

    /**
     * @api
     *
     * Récupère les logs d'actions effectuées sur tous les devis.
     *
     * @param array{limit?: int, skip?: int}|QuoteGetLogsParams $params
     *
     * @return BaseResponse<QuoteGetLogsResponse>
     *
     * @throws APIException
     */
    public function getLogs(
        array|QuoteGetLogsParams $params,
        ?RequestOptions $requestOptions = null
    ): BaseResponse {
        [$parsed, $options] = QuoteGetLogsParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'quotes/logs',
            query: $parsed,
            options: $options,
            convert: QuoteGetLogsResponse::class,
        );
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
     * @param array{
     *   maxDate?: string|\DateTimeInterface,
     *   minDate?: string|\DateTimeInterface,
     *   state?: string,
     * }|QuoteGetStatsParams $params
     *
     * @return BaseResponse<QuoteGetStatsResponse>
     *
     * @throws APIException
     */
    public function getStats(
        array|QuoteGetStatsParams $params,
        ?RequestOptions $requestOptions = null
    ): BaseResponse {
        [$parsed, $options] = QuoteGetStatsParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'quotes/stats',
            query: $parsed,
            options: $options,
            convert: QuoteGetStatsResponse::class,
        );
    }

    /**
     * @api
     *
     * Récupère l'historique des actions sur un devis spécifique.
     *
     * @param string $uid ID du devis
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function retrieveLogs(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['quote/%1$s/logs', $uid],
            options: $requestOptions,
            convert: null,
        );
    }
}
