<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts;

use Wuro\Core\Exceptions\APIException;
use Wuro\Invoices\InvoiceCreateParams\State;
use Wuro\Invoices\InvoiceCreateParams\Type;
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

/**
 * @phpstan-import-type InvoiceLineShape from \Wuro\Invoices\InvoiceCreateParams\InvoiceLine as InvoiceLineShape1
 * @phpstan-import-type InvoiceLineShape from \Wuro\Invoices\Line\InvoiceLine
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
interface InvoicesContract
{
    /**
     * @api
     *
     * @param string $client ID du client
     * @param string $clientEmail Email pour l'envoi de la facture
     * @param string $clientName Nom du client (si pas de client référencé)
     * @param \DateTimeInterface $date Date de la facture (défaut = maintenant)
     * @param list<\Wuro\Invoices\InvoiceCreateParams\InvoiceLine|InvoiceLineShape1> $invoiceLines Lignes de la facture
     * @param \DateTimeInterface $paymentExpiryDate Date d'échéance (calculée automatiquement si non fournie)
     * @param State|value-of<State> $state État initial (draft = brouillon sans numéro)
     * @param string $title Titre/objet de la facture
     * @param Type|value-of<Type> $type
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
        ?array $invoiceLines = null,
        ?\DateTimeInterface $paymentExpiryDate = null,
        State|string $state = 'draft',
        ?string $title = null,
        Type|string $type = 'invoice',
        RequestOptions|array|null $requestOptions = null,
    ): InvoiceNewResponse;

    /**
     * @api
     *
     * @param string $uid ID de la facture
     * @param string $populate Champs à peupler (ex. "client,positionCreator")
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $uid,
        ?string $populate = null,
        RequestOptions|array|null $requestOptions = null,
    ): InvoiceGetResponse;

    /**
     * @api
     *
     * @param string $client ID du client
     * @param string $clientAddress Adresse du client
     * @param string $clientName Nom du client
     * @param \DateTimeInterface $date Date de la facture
     * @param list<InvoiceLine|InvoiceLineShape> $invoiceLines Lignes de la facture
     * @param \DateTimeInterface $paymentExpiryDate Date d'échéance de paiement
     * @param \Wuro\Invoices\InvoiceUpdateParams\State|value-of<\Wuro\Invoices\InvoiceUpdateParams\State> $state État de la facture
     * @param string $title Titre/objet de la facture
     * @param \Wuro\Invoices\InvoiceUpdateParams\Type|value-of<\Wuro\Invoices\InvoiceUpdateParams\Type> $type Type de facture
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
        ?array $invoiceLines = null,
        ?\DateTimeInterface $paymentExpiryDate = null,
        \Wuro\Invoices\InvoiceUpdateParams\State|string|null $state = null,
        ?string $title = null,
        \Wuro\Invoices\InvoiceUpdateParams\Type|string|null $type = null,
        RequestOptions|array|null $requestOptions = null,
    ): InvoiceUpdateResponse;

    /**
     * @api
     *
     * @param string $client Filtre par ID du client
     * @param int $limit Nombre maximum de factures à retourner
     * @param \DateTimeInterface $maxDate Date maximum (ISO 8601)
     * @param \DateTimeInterface $minDate Date minimum (ISO 8601)
     * @param string $number Numéro de facture (recherche exacte)
     * @param string $search Recherche textuelle dans les factures
     * @param int $skip Nombre de factures à ignorer (pagination)
     * @param string $sort Champ de tri et direction (ex. "date:-1" pour tri décroissant par date)
     * @param \Wuro\Invoices\InvoiceListParams\State|value-of<\Wuro\Invoices\InvoiceListParams\State> $state Filtre par état de la facture
     * @param \Wuro\Invoices\InvoiceListParams\Type|value-of<\Wuro\Invoices\InvoiceListParams\Type> $type Filtre par type de facture
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        ?string $client = null,
        int $limit = 20,
        ?\DateTimeInterface $maxDate = null,
        ?\DateTimeInterface $minDate = null,
        ?string $number = null,
        ?string $search = null,
        int $skip = 0,
        ?string $sort = null,
        \Wuro\Invoices\InvoiceListParams\State|string|null $state = null,
        \Wuro\Invoices\InvoiceListParams\Type|string|null $type = null,
        RequestOptions|array|null $requestOptions = null,
    ): InvoiceListResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): mixed;

    /**
     * @api
     *
     * @param string $uid ID de la facture d'origine
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function createCredit(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): InvoiceNewCreditResponse;

    /**
     * @api
     *
     * @param string $uid ID de la facture
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function createDeliveryReceipt(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): mixed;

    /**
     * @api
     *
     * @param list<string> $invoicesID Liste des IDs de factures à inclure
     * @param bool $deferred Forcer le mode différé (génération en arrière-plan)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function createPackage(
        array $invoicesID,
        ?bool $deferred = null,
        RequestOptions|array|null $requestOptions = null,
    ): InvoiceNewPackageResponse;

    /**
     * @api
     *
     * @param string $invoice Filtre par ID de facture
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function getLogs(
        ?string $invoice = null,
        int $limit = 20,
        int $skip = 0,
        RequestOptions|array|null $requestOptions = null,
    ): InvoiceGetLogsResponse;

    /**
     * @api
     *
     * @param string $state Filtre par état
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function getStats(
        ?\DateTimeInterface $maxDate = null,
        ?\DateTimeInterface $minDate = null,
        ?string $state = null,
        RequestOptions|array|null $requestOptions = null,
    ): InvoiceGetStatsResponse;

    /**
     * @api
     *
     * @param \DateTimeInterface $maxDate Date de fin de la période
     * @param \DateTimeInterface $minDate Date de début de la période
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function getTurnover(
        ?\DateTimeInterface $maxDate = null,
        ?\DateTimeInterface $minDate = null,
        RequestOptions|array|null $requestOptions = null,
    ): InvoiceGetTurnoverResponse;

    /**
     * @api
     *
     * @param \DateTimeInterface $maxDate Date maximum du paiement
     * @param \DateTimeInterface $minDate Date minimum du paiement
     * @param string $mode ID du mode de paiement
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function listPayments(
        ?int $limit = null,
        ?\DateTimeInterface $maxDate = null,
        ?\DateTimeInterface $minDate = null,
        ?string $mode = null,
        ?int $skip = null,
        RequestOptions|array|null $requestOptions = null,
    ): InvoiceListPaymentsResponse;

    /**
     * @api
     *
     * @param list<\Wuro\Invoices\InvoiceListWaitingPaymentsParams\State|value-of<\Wuro\Invoices\InvoiceListWaitingPaymentsParams\State>> $state Filtre par état (par défaut waiting et late)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function listWaitingPayments(
        ?int $limit = null,
        ?int $skip = null,
        ?array $state = null,
        RequestOptions|array|null $requestOptions = null,
    ): InvoiceListWaitingPaymentsResponse;

    /**
     * @api
     *
     * @param string $uid ID de la facture
     * @param float $amount Montant du paiement
     * @param string $mode ID du mode de paiement (PaymentMethod)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function recordPayment(
        string $uid,
        float $amount,
        string $mode,
        RequestOptions|array|null $requestOptions = null,
    ): InvoiceRecordPaymentResponse;

    /**
     * @api
     *
     * @param string $uid ID de la facture
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveLogs(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): mixed;

    /**
     * @api
     *
     * @param string $uid ID de la facture
     * @param Action|value-of<Action> $action Type d'envoi (envoi ou relance)
     * @param string $content Contenu personnalisé
     * @param string $copyto Email en copie
     * @param bool $joinPdf Joindre le PDF en pièce jointe
     * @param string $replyTo Email pour les réponses
     * @param string $subject Objet personnalisé
     * @param string $to Email du destinataire (défaut = email du client)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function sendEmail(
        string $uid,
        Action|string $action = 'send_invoice',
        ?string $content = null,
        ?string $copyto = null,
        bool $joinPdf = false,
        ?string $replyTo = null,
        ?string $subject = null,
        ?string $to = null,
        RequestOptions|array|null $requestOptions = null,
    ): InvoiceSendEmailResponse;
}
