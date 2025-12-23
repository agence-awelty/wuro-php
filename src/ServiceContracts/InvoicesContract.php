<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts;

use Wuro\Core\Exceptions\APIException;
use Wuro\Invoices\InvoiceCreateParams\InvoiceLine\Type;
use Wuro\Invoices\InvoiceCreateParams\State;
use Wuro\Invoices\InvoiceGetLogsResponse;
use Wuro\Invoices\InvoiceGetResponse;
use Wuro\Invoices\InvoiceGetStatsResponse;
use Wuro\Invoices\InvoiceGetTurnoverResponse;
use Wuro\Invoices\InvoiceListPaymentsResponse;
use Wuro\Invoices\InvoiceListResponse;
use Wuro\Invoices\InvoiceListWaitingPaymentsResponse;
use Wuro\Invoices\InvoiceNewCreditResponse;
use Wuro\Invoices\InvoiceNewPackageResponse;
use Wuro\Invoices\InvoiceNewResponse;
use Wuro\Invoices\InvoiceRecordPaymentResponse;
use Wuro\Invoices\InvoiceSendEmailParams\Action;
use Wuro\Invoices\InvoiceSendEmailResponse;
use Wuro\Invoices\InvoiceUpdateResponse;
use Wuro\Invoices\Line\InvoiceLine;
use Wuro\RequestOptions;

interface InvoicesContract
{
    /**
     * @api
     *
     * @param string $client ID du client
     * @param string $clientEmail Email pour l'envoi de la facture
     * @param string $clientName Nom du client (si pas de client référencé)
     * @param string|\DateTimeInterface $date Date de la facture (défaut = maintenant)
     * @param list<array{
     *   description?: string,
     *   discount?: float,
     *   priceHt?: float,
     *   product?: string,
     *   quantity?: float,
     *   reference?: string,
     *   title?: string,
     *   tvaRate?: float,
     *   type?: 'product'|'header'|'subtotal'|'globalDiscount'|Type,
     *   unit?: string,
     * }> $invoiceLines Lignes de la facture
     * @param string|\DateTimeInterface $paymentExpiryDate Date d'échéance (calculée automatiquement si non fournie)
     * @param 'draft'|'waiting'|'paid'|'notpaid'|'late'|State $state État initial (draft = brouillon sans numéro)
     * @param string $title Titre/objet de la facture
     * @param 'invoice'|'invoice_credit'|'external'|'external_credit'|'proforma'|'advance'|\Wuro\Invoices\InvoiceCreateParams\Type $type
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
        string|\DateTimeInterface|null $date = null,
        ?array $invoiceLines = null,
        string|\DateTimeInterface|null $paymentExpiryDate = null,
        string|State $state = 'draft',
        ?string $title = null,
        string|\Wuro\Invoices\InvoiceCreateParams\Type $type = 'invoice',
        ?RequestOptions $requestOptions = null,
    ): InvoiceNewResponse;

    /**
     * @api
     *
     * @param string $uid ID de la facture
     * @param string $populate Champs à peupler (ex. "client,positionCreator")
     *
     * @throws APIException
     */
    public function retrieve(
        string $uid,
        ?string $populate = null,
        ?RequestOptions $requestOptions = null,
    ): InvoiceGetResponse;

    /**
     * @api
     *
     * @param string $client ID du client
     * @param string $clientAddress Adresse du client
     * @param string $clientName Nom du client
     * @param string|\DateTimeInterface $date Date de la facture
     * @param list<array{
     *   _id?: string,
     *   description?: string,
     *   priceHt?: float,
     *   quantity?: float,
     *   reference?: string,
     *   title?: string,
     *   totalHt?: float,
     *   totalTtc?: float,
     *   tvaRate?: float,
     *   type?: 'product'|'header'|'subtotal'|'globalDiscount'|InvoiceLine\Type,
     *   unit?: string,
     * }|InvoiceLine> $invoiceLines Lignes de la facture
     * @param string|\DateTimeInterface $paymentExpiryDate Date d'échéance de paiement
     * @param 'draft'|'waiting'|'paid'|'notpaid'|'late'|\Wuro\Invoices\InvoiceUpdateParams\State $state État de la facture
     * @param string $title Titre/objet de la facture
     * @param 'invoice'|'invoice_credit'|'external'|'external_credit'|'proforma'|'advance'|\Wuro\Invoices\InvoiceUpdateParams\Type $type Type de facture
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
        string|\DateTimeInterface|null $date = null,
        ?array $invoiceLines = null,
        string|\DateTimeInterface|null $paymentExpiryDate = null,
        string|\Wuro\Invoices\InvoiceUpdateParams\State|null $state = null,
        ?string $title = null,
        string|\Wuro\Invoices\InvoiceUpdateParams\Type|null $type = null,
        ?RequestOptions $requestOptions = null,
    ): InvoiceUpdateResponse;

    /**
     * @api
     *
     * @param string $client Filtre par ID du client
     * @param int $limit Nombre maximum de factures à retourner
     * @param string|\DateTimeInterface $maxDate Date maximum (ISO 8601)
     * @param string|\DateTimeInterface $minDate Date minimum (ISO 8601)
     * @param string $number Numéro de facture (recherche exacte)
     * @param string $search Recherche textuelle dans les factures
     * @param int $skip Nombre de factures à ignorer (pagination)
     * @param string $sort Champ de tri et direction (ex. "date:-1" pour tri décroissant par date)
     * @param 'draft'|'waiting'|'paid'|'notpaid'|'late'|'inactive'|\Wuro\Invoices\InvoiceListParams\State $state Filtre par état de la facture
     * @param 'invoice'|'invoice_credit'|'external'|'external_credit'|'proforma'|'advance'|\Wuro\Invoices\InvoiceListParams\Type $type Filtre par type de facture
     *
     * @throws APIException
     */
    public function list(
        ?string $client = null,
        int $limit = 20,
        string|\DateTimeInterface|null $maxDate = null,
        string|\DateTimeInterface|null $minDate = null,
        ?string $number = null,
        ?string $search = null,
        int $skip = 0,
        ?string $sort = null,
        string|\Wuro\Invoices\InvoiceListParams\State|null $state = null,
        string|\Wuro\Invoices\InvoiceListParams\Type|null $type = null,
        ?RequestOptions $requestOptions = null,
    ): InvoiceListResponse;

    /**
     * @api
     *
     * @throws APIException
     */
    public function delete(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): mixed;

    /**
     * @api
     *
     * @param string $uid ID de la facture d'origine
     *
     * @throws APIException
     */
    public function createCredit(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): InvoiceNewCreditResponse;

    /**
     * @api
     *
     * @param string $uid ID de la facture
     *
     * @throws APIException
     */
    public function createDeliveryReceipt(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): mixed;

    /**
     * @api
     *
     * @param list<string> $invoicesID Liste des IDs de factures à inclure
     * @param bool $deferred Forcer le mode différé (génération en arrière-plan)
     *
     * @throws APIException
     */
    public function createPackage(
        array $invoicesID,
        ?bool $deferred = null,
        ?RequestOptions $requestOptions = null,
    ): InvoiceNewPackageResponse;

    /**
     * @api
     *
     * @param string $invoice Filtre par ID de facture
     *
     * @throws APIException
     */
    public function getLogs(
        ?string $invoice = null,
        int $limit = 20,
        int $skip = 0,
        ?RequestOptions $requestOptions = null,
    ): InvoiceGetLogsResponse;

    /**
     * @api
     *
     * @param string $state Filtre par état
     *
     * @throws APIException
     */
    public function getStats(
        string|\DateTimeInterface|null $maxDate = null,
        string|\DateTimeInterface|null $minDate = null,
        ?string $state = null,
        ?RequestOptions $requestOptions = null,
    ): InvoiceGetStatsResponse;

    /**
     * @api
     *
     * @param string|\DateTimeInterface $maxDate Date de fin de la période
     * @param string|\DateTimeInterface $minDate Date de début de la période
     *
     * @throws APIException
     */
    public function getTurnover(
        string|\DateTimeInterface|null $maxDate = null,
        string|\DateTimeInterface|null $minDate = null,
        ?RequestOptions $requestOptions = null,
    ): InvoiceGetTurnoverResponse;

    /**
     * @api
     *
     * @param string|\DateTimeInterface $maxDate Date maximum du paiement
     * @param string|\DateTimeInterface $minDate Date minimum du paiement
     * @param string $mode ID du mode de paiement
     *
     * @throws APIException
     */
    public function listPayments(
        ?int $limit = null,
        string|\DateTimeInterface|null $maxDate = null,
        string|\DateTimeInterface|null $minDate = null,
        ?string $mode = null,
        ?int $skip = null,
        ?RequestOptions $requestOptions = null,
    ): InvoiceListPaymentsResponse;

    /**
     * @api
     *
     * @param list<'waiting'|'late'|\Wuro\Invoices\InvoiceListWaitingPaymentsParams\State> $state Filtre par état (par défaut waiting et late)
     *
     * @throws APIException
     */
    public function listWaitingPayments(
        ?int $limit = null,
        ?int $skip = null,
        ?array $state = null,
        ?RequestOptions $requestOptions = null,
    ): InvoiceListWaitingPaymentsResponse;

    /**
     * @api
     *
     * @param string $uid ID de la facture
     * @param float $amount Montant du paiement
     * @param string $mode ID du mode de paiement (PaymentMethod)
     *
     * @throws APIException
     */
    public function recordPayment(
        string $uid,
        float $amount,
        string $mode,
        ?RequestOptions $requestOptions = null,
    ): InvoiceRecordPaymentResponse;

    /**
     * @api
     *
     * @param string $uid ID de la facture
     *
     * @throws APIException
     */
    public function retrieveLogs(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): mixed;

    /**
     * @api
     *
     * @param string $uid ID de la facture
     * @param 'send_invoice'|'dunning_invoice'|Action $action Type d'envoi (envoi ou relance)
     * @param string $content Contenu personnalisé
     * @param string $copyto Email en copie
     * @param bool $joinPdf Joindre le PDF en pièce jointe
     * @param string $replyTo Email pour les réponses
     * @param string $subject Objet personnalisé
     * @param string $to Email du destinataire (défaut = email du client)
     *
     * @throws APIException
     */
    public function sendEmail(
        string $uid,
        string|Action $action = 'send_invoice',
        ?string $content = null,
        ?string $copyto = null,
        bool $joinPdf = false,
        ?string $replyTo = null,
        ?string $subject = null,
        ?string $to = null,
        ?RequestOptions $requestOptions = null,
    ): InvoiceSendEmailResponse;
}
