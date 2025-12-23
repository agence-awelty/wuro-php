<?php

declare(strict_types=1);

namespace Wuro\Services;

use Wuro\Client;
use Wuro\Core\Contracts\BaseResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\Invoices\InvoiceCreatePackageParams;
use Wuro\Invoices\InvoiceCreateParams;
use Wuro\Invoices\InvoiceCreateParams\InvoiceLine\Type;
use Wuro\Invoices\InvoiceCreateParams\State;
use Wuro\Invoices\InvoiceGetLogsParams;
use Wuro\Invoices\InvoiceGetLogsResponse;
use Wuro\Invoices\InvoiceGetResponse;
use Wuro\Invoices\InvoiceGetStatsParams;
use Wuro\Invoices\InvoiceGetStatsResponse;
use Wuro\Invoices\InvoiceGetTurnoverParams;
use Wuro\Invoices\InvoiceGetTurnoverResponse;
use Wuro\Invoices\InvoiceListParams;
use Wuro\Invoices\InvoiceListPaymentsParams;
use Wuro\Invoices\InvoiceListPaymentsResponse;
use Wuro\Invoices\InvoiceListResponse;
use Wuro\Invoices\InvoiceListWaitingPaymentsParams;
use Wuro\Invoices\InvoiceListWaitingPaymentsResponse;
use Wuro\Invoices\InvoiceNewCreditResponse;
use Wuro\Invoices\InvoiceNewPackageResponse;
use Wuro\Invoices\InvoiceNewResponse;
use Wuro\Invoices\InvoiceRecordPaymentParams;
use Wuro\Invoices\InvoiceRecordPaymentResponse;
use Wuro\Invoices\InvoiceRetrieveParams;
use Wuro\Invoices\InvoiceSendEmailParams;
use Wuro\Invoices\InvoiceSendEmailParams\Action;
use Wuro\Invoices\InvoiceSendEmailResponse;
use Wuro\Invoices\InvoiceUpdateParams;
use Wuro\Invoices\InvoiceUpdateResponse;
use Wuro\Invoices\Line\InvoiceLine;
use Wuro\RequestOptions;
use Wuro\ServiceContracts\InvoicesRawContract;

final class InvoicesRawService implements InvoicesRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Crée une nouvelle facture.
     *
     * **Numérotation automatique:**
     * - Si l'état est 'waiting', 'paid', 'notpaid' ou 'late', un numéro est automatiquement attribué
     * - Le système verrouille la numérotation pendant l'attribution pour éviter les doublons
     * - Un numéro d'enregistrement FEC (numberRecord) est aussi généré
     *
     * **Types de factures:**
     * - `invoice`: Facture standard
     * - `invoice_credit`: Avoir
     * - `external`: Facture externe (client fournisseur)
     * - `external_credit`: Avoir externe
     * - `proforma`: Facture proforma
     * - `advance`: Acompte
     *
     * **Calculs automatiques:**
     * - Les totaux HT, TVA et TTC sont calculés automatiquement
     * - Les réductions globales sont appliquées
     * - La date d'échéance est calculée selon les paramètres de l'entreprise
     *
     * **Événements déclenchés:**
     * - CREATE_INVOICE
     * - Mise à jour du stock si nécessaire
     *
     * **Réponse:**
     * - Inclut les liens `pdf_link` et `html_link` pour accéder aux documents
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
     *   invoiceLines?: list<array{
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
     *   paymentExpiryDate?: string|\DateTimeInterface,
     *   state?: 'draft'|'waiting'|'paid'|'notpaid'|'late'|State,
     *   title?: string,
     *   type?: 'invoice'|'invoice_credit'|'external'|'external_credit'|'proforma'|'advance'|InvoiceCreateParams\Type,
     * }|InvoiceCreateParams $params
     *
     * @return BaseResponse<InvoiceNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|InvoiceCreateParams $params,
        ?RequestOptions $requestOptions = null
    ): BaseResponse {
        [$parsed, $options] = InvoiceCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'invoice',
            body: (object) $parsed,
            options: $options,
            convert: InvoiceNewResponse::class,
        );
    }

    /**
     * @api
     *
     * Récupère les détails complets d'une facture spécifique.
     *
     * Inclut toutes les informations: client, lignes, paiements, etc.
     *
     * @param string $uid ID de la facture
     * @param array{populate?: string}|InvoiceRetrieveParams $params
     *
     * @return BaseResponse<InvoiceGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $uid,
        array|InvoiceRetrieveParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = InvoiceRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['invoice/%1$s', $uid],
            query: $parsed,
            options: $options,
            convert: InvoiceGetResponse::class,
        );
    }

    /**
     * @api
     *
     * Met à jour une facture existante.
     *
     * **Numérotation automatique:**
     * - Si la facture passe de 'draft' à un état validé (waiting, paid, etc.), un numéro est automatiquement attribué
     * - Le numéro est verrouillé pendant l'attribution pour éviter les doublons
     * - Un numéro d'enregistrement FEC (numberRecord) est aussi généré
     *
     * **Restrictions:**
     * - Une facture numérotée ne peut pas revenir en brouillon
     * - Certaines modifications sont interdites sur les factures validées
     *
     * **Événements déclenchés:**
     * - Mise à jour du stock si nécessaire
     * - Logs de numérotation
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
     *   invoiceLines?: list<array{
     *     _id?: string,
     *     description?: string,
     *     priceHt?: float,
     *     quantity?: float,
     *     reference?: string,
     *     title?: string,
     *     totalHt?: float,
     *     totalTtc?: float,
     *     tvaRate?: float,
     *     type?: 'product'|'header'|'subtotal'|'globalDiscount'|InvoiceLine\Type,
     *     unit?: string,
     *   }|InvoiceLine>,
     *   paymentExpiryDate?: string|\DateTimeInterface,
     *   state?: 'draft'|'waiting'|'paid'|'notpaid'|'late'|InvoiceUpdateParams\State,
     *   title?: string,
     *   type?: 'invoice'|'invoice_credit'|'external'|'external_credit'|'proforma'|'advance'|InvoiceUpdateParams\Type,
     * }|InvoiceUpdateParams $params
     *
     * @return BaseResponse<InvoiceUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        array|InvoiceUpdateParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = InvoiceUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'patch',
            path: ['invoice/%1$s', $uid],
            body: (object) $parsed,
            options: $options,
            convert: InvoiceUpdateResponse::class,
        );
    }

    /**
     * @api
     *
     * Récupère la liste des factures avec pagination, tri et filtres avancés.
     *
     * **Filtres disponibles:**
     * - `state`: État de la facture (draft, waiting, paid, notpaid, late, inactive)
     * - `type`: Type de facture (invoice, invoice_credit, external, external_credit, proforma, advance)
     * - `client`: ID du client
     * - `minDate` / `maxDate`: Plage de dates
     * - `number`: Numéro de facture
     * - `search`: Recherche textuelle
     *
     * **Réponse:**
     * - `invoices`: Liste des factures
     * - `total`: Nombre total de factures correspondantes
     * - `skip` et `limit`: Paramètres de pagination
     *
     * @param array{
     *   client?: string,
     *   limit?: int,
     *   maxDate?: string|\DateTimeInterface,
     *   minDate?: string|\DateTimeInterface,
     *   number?: string,
     *   search?: string,
     *   skip?: int,
     *   sort?: string,
     *   state?: 'draft'|'waiting'|'paid'|'notpaid'|'late'|'inactive'|InvoiceListParams\State,
     *   type?: 'invoice'|'invoice_credit'|'external'|'external_credit'|'proforma'|'advance'|InvoiceListParams\Type,
     * }|InvoiceListParams $params
     *
     * @return BaseResponse<InvoiceListResponse>
     *
     * @throws APIException
     */
    public function list(
        array|InvoiceListParams $params,
        ?RequestOptions $requestOptions = null
    ): BaseResponse {
        [$parsed, $options] = InvoiceListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'invoices',
            query: $parsed,
            options: $options,
            convert: InvoiceListResponse::class,
        );
    }

    /**
     * @api
     *
     * Supprime (désactive) une facture.
     *
     * **Restrictions:**
     * - Seules les factures en brouillon non numérotées peuvent être supprimées
     * - Une facture avec un numéro ou un numberRecord ne peut pas être supprimée
     * - L'état passe à 'inactive' (soft delete)
     *
     * **Événement déclenché:** DELETE_INVOICE
     *
     * @return BaseResponse<mixed>
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
            path: ['invoice/%1$s', $uid],
            options: $requestOptions,
            convert: null,
        );
    }

    /**
     * @api
     *
     * Crée un avoir (facture d'avoir) lié à une facture existante.
     *
     * L'avoir reprend les informations de la facture d'origine avec des montants négatifs.
     *
     * @param string $uid ID de la facture d'origine
     *
     * @return BaseResponse<InvoiceNewCreditResponse>
     *
     * @throws APIException
     */
    public function createCredit(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['invoice/%1$s/credit', $uid],
            options: $requestOptions,
            convert: InvoiceNewCreditResponse::class,
        );
    }

    /**
     * @api
     *
     * Génère un bon de livraison (Receipt) à partir d'une facture.
     *
     * Le bon de livraison reprend les lignes de la facture.
     *
     * @param string $uid ID de la facture
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
            path: ['invoice/%1$s/delivery-receipt', $uid],
            options: $requestOptions,
            convert: null,
        );
    }

    /**
     * @api
     *
     * Génère une archive ZIP contenant les PDFs de plusieurs factures.
     *
     * **Comportement:**
     * - Si le nombre de factures > seuil configuré ou `DEFERRED=true`, l'archive est générée en arrière-plan
     * - Un objet Package est créé pour suivre la progression
     * - Une fois terminé, l'archive est téléchargeable via GET /package/{uid}/download
     *
     * **Mode différé:**
     * - Retourne immédiatement avec `newPackage` et un message
     * - Le package passe par les états: created → finished (ou error)
     *
     * @param array{
     *   invoicesID: list<string>, deferred?: bool
     * }|InvoiceCreatePackageParams $params
     *
     * @return BaseResponse<InvoiceNewPackageResponse>
     *
     * @throws APIException
     */
    public function createPackage(
        array|InvoiceCreatePackageParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = InvoiceCreatePackageParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'invoices/package',
            body: (object) $parsed,
            options: $options,
            convert: InvoiceNewPackageResponse::class,
        );
    }

    /**
     * @api
     *
     * Récupère les logs d'actions effectuées sur les factures (création, modification, envoi, etc.).
     *
     * Utile pour l'audit et le suivi des modifications.
     *
     * @param array{
     *   invoice?: string, limit?: int, skip?: int
     * }|InvoiceGetLogsParams $params
     *
     * @return BaseResponse<InvoiceGetLogsResponse>
     *
     * @throws APIException
     */
    public function getLogs(
        array|InvoiceGetLogsParams $params,
        ?RequestOptions $requestOptions = null
    ): BaseResponse {
        [$parsed, $options] = InvoiceGetLogsParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'invoices/logs',
            query: $parsed,
            options: $options,
            convert: InvoiceGetLogsResponse::class,
        );
    }

    /**
     * @api
     *
     * Calcule et retourne des statistiques agrégées sur les factures.
     *
     * **Statistiques retournées:**
     * - Totaux HT/TTC par état
     * - Montants min/max
     * - Répartition par type de facture
     *
     * Utilise les mêmes filtres que GET /invoices (state, type, client, dates, etc.)
     *
     * @param array{
     *   maxDate?: string|\DateTimeInterface,
     *   minDate?: string|\DateTimeInterface,
     *   state?: string,
     * }|InvoiceGetStatsParams $params
     *
     * @return BaseResponse<InvoiceGetStatsResponse>
     *
     * @throws APIException
     */
    public function getStats(
        array|InvoiceGetStatsParams $params,
        ?RequestOptions $requestOptions = null
    ): BaseResponse {
        [$parsed, $options] = InvoiceGetStatsParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'invoices/stats',
            query: $parsed,
            options: $options,
            convert: InvoiceGetStatsResponse::class,
        );
    }

    /**
     * @api
     *
     * Calcule le chiffre d'affaires sur une période donnée.
     *
     * Basé sur les factures validées (état waiting, paid, late, notpaid).
     * Exclut les avoirs et proformas.
     *
     * @param array{
     *   maxDate?: string|\DateTimeInterface, minDate?: string|\DateTimeInterface
     * }|InvoiceGetTurnoverParams $params
     *
     * @return BaseResponse<InvoiceGetTurnoverResponse>
     *
     * @throws APIException
     */
    public function getTurnover(
        array|InvoiceGetTurnoverParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = InvoiceGetTurnoverParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'invoices/turnover',
            query: $parsed,
            options: $options,
            convert: InvoiceGetTurnoverResponse::class,
        );
    }

    /**
     * @api
     *
     * Récupère la liste des paiements enregistrés sur les factures.
     *
     * **Filtres spécifiques aux paiements:**
     * - `minDate` / `maxDate` / `date`: Date du paiement
     * - `amount`: Montant du paiement
     * - `method_name`: Nom du mode de paiement
     * - `mode`: ID du mode de paiement
     *
     * **Réponse agrégée:**
     * - `payments`: Liste des paiements avec informations de la facture associée
     * - `count`: Nombre total de paiements
     * - `total`: Somme des montants
     * - `average`: Moyenne des montants
     *
     * @param array{
     *   limit?: int,
     *   maxDate?: string|\DateTimeInterface,
     *   minDate?: string|\DateTimeInterface,
     *   mode?: string,
     *   skip?: int,
     * }|InvoiceListPaymentsParams $params
     *
     * @return BaseResponse<InvoiceListPaymentsResponse>
     *
     * @throws APIException
     */
    public function listPayments(
        array|InvoiceListPaymentsParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = InvoiceListPaymentsParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'invoices/payments',
            query: $parsed,
            options: $options,
            convert: InvoiceListPaymentsResponse::class,
        );
    }

    /**
     * @api
     *
     * Récupère les factures qui sont en attente de paiement (état waiting ou late).
     *
     * **Réponse:**
     * - `invoices`: Liste des factures en attente
     * - `total`: Nombre de factures
     * - `totalAmount`: Somme des montants restant à payer (total_nettopay)
     *
     * @param array{
     *   limit?: int,
     *   skip?: int,
     *   state?: list<'waiting'|'late'|InvoiceListWaitingPaymentsParams\State>,
     * }|InvoiceListWaitingPaymentsParams $params
     *
     * @return BaseResponse<InvoiceListWaitingPaymentsResponse>
     *
     * @throws APIException
     */
    public function listWaitingPayments(
        array|InvoiceListWaitingPaymentsParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = InvoiceListWaitingPaymentsParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'invoices/payments-waiting',
            query: $parsed,
            options: $options,
            convert: InvoiceListWaitingPaymentsResponse::class,
        );
    }

    /**
     * @api
     *
     * Enregistre un paiement sur une facture en attente.
     *
     * **Restrictions:**
     * - La facture doit être en état 'waiting'
     * - Le mode de paiement doit exister et être actif
     *
     * **Comportement:**
     * - Le paiement est ajouté à la liste `payments` de la facture
     * - Le `total_nettopay` (reste à payer) est recalculé
     * - Si le montant couvre le total, l'état passe à 'paid'
     * - La `payment_date` est mise à jour
     *
     * **Événement déclenché:** PAYMENT_INVOICE
     *
     * @param string $uid ID de la facture
     * @param array{amount: float, mode: string}|InvoiceRecordPaymentParams $params
     *
     * @return BaseResponse<InvoiceRecordPaymentResponse>
     *
     * @throws APIException
     */
    public function recordPayment(
        string $uid,
        array|InvoiceRecordPaymentParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = InvoiceRecordPaymentParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['invoice/%1$s/payment', $uid],
            body: (object) $parsed,
            options: $options,
            convert: InvoiceRecordPaymentResponse::class,
        );
    }

    /**
     * @api
     *
     * Récupère l'historique des actions sur une facture spécifique.
     *
     * Inclut: création, modifications, numérotations, envois par email, etc.
     *
     * @param string $uid ID de la facture
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
            path: ['invoice/%1$s/logs', $uid],
            options: $requestOptions,
            convert: null,
        );
    }

    /**
     * @api
     *
     * Envoie la facture par email au client.
     *
     * **Restrictions:**
     * - La facture ne doit pas être en brouillon
     *
     * **Personnalisation:**
     * - Utilise les modèles d'email configurés dans l'entreprise
     * - Variables disponibles: [lien-html], [lien-pdf], [facture-numero], [facture-date], [contact-nom], etc.
     *
     * **Options:**
     * - `action`: 'send_invoice' (envoi standard) ou 'dunning_invoice' (relance)
     * - `joinPdf`: true pour joindre le PDF en pièce jointe
     * - Possibilité de personnaliser subject, content, to, copyto, replyTo
     *
     * @param string $uid ID de la facture
     * @param array{
     *   action?: 'send_invoice'|'dunning_invoice'|Action,
     *   content?: string,
     *   copyto?: string,
     *   joinPdf?: bool,
     *   replyTo?: string,
     *   subject?: string,
     *   to?: string,
     * }|InvoiceSendEmailParams $params
     *
     * @return BaseResponse<InvoiceSendEmailResponse>
     *
     * @throws APIException
     */
    public function sendEmail(
        string $uid,
        array|InvoiceSendEmailParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = InvoiceSendEmailParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['invoice/%1$s/mail', $uid],
            body: (object) $parsed,
            options: $options,
            convert: InvoiceSendEmailResponse::class,
        );
    }
}
