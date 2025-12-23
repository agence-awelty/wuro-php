<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts;

use Wuro\Core\Exceptions\APIException;
use Wuro\Quotes\Line\QuoteLine;
use Wuro\Quotes\QuoteCreateParams\QuoteLine\Type;
use Wuro\Quotes\QuoteCreateParams\State;
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

interface QuotesContract
{
    /**
     * @api
     *
     * @param string $client ID du client
     * @param string $clientName Nom du client (si pas de client référencé)
     * @param string|\DateTimeInterface $date Date du devis (défaut = maintenant)
     * @param string|\DateTimeInterface $expiryDate Date de validité
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
     * }> $quoteLines Lignes du devis
     * @param 'draft'|'pending'|'waiting'|'accepted'|'refused'|State $state État initial
     * @param string $title Titre/objet du devis
     * @param 'quote'|'proforma'|'bdc'|\Wuro\Quotes\QuoteCreateParams\Type $type Type de document
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
        string|\DateTimeInterface|null $expiryDate = null,
        ?array $quoteLines = null,
        string|State $state = 'draft',
        ?string $title = null,
        string|\Wuro\Quotes\QuoteCreateParams\Type $type = 'quote',
        ?RequestOptions $requestOptions = null,
    ): QuoteNewResponse;

    /**
     * @api
     *
     * @param string $uid ID du devis
     * @param string $populate Champs à peupler (ex. "client,documentModel")
     *
     * @throws APIException
     */
    public function retrieve(
        string $uid,
        ?string $populate = null,
        ?RequestOptions $requestOptions = null,
    ): QuoteGetResponse;

    /**
     * @api
     *
     * @param string $client ID du client
     * @param string|\DateTimeInterface $date Date du devis
     * @param string|\DateTimeInterface $expiryDate Date de validité
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
     *   type?: 'product'|'header'|'subtotal'|'globalDiscount'|QuoteLine\Type,
     *   unit?: string,
     * }|QuoteLine> $quoteLines
     * @param 'draft'|'pending'|'waiting'|'accepted'|'refused'|'invoiced'|'canceled'|\Wuro\Quotes\QuoteUpdateParams\State $state État du devis
     * @param string $title Titre/objet du devis
     * @param 'quote'|'proforma'|'bdc'|\Wuro\Quotes\QuoteUpdateParams\Type $type
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
        string|\DateTimeInterface|null $expiryDate = null,
        ?array $quoteLines = null,
        string|\Wuro\Quotes\QuoteUpdateParams\State|null $state = null,
        ?string $title = null,
        string|\Wuro\Quotes\QuoteUpdateParams\Type|null $type = null,
        ?RequestOptions $requestOptions = null,
    ): QuoteUpdateResponse;

    /**
     * @api
     *
     * @param string $client Filtre par ID du client
     * @param int $limit Nombre maximum de devis à retourner
     * @param string|\DateTimeInterface $maxDate Date maximum
     * @param string|\DateTimeInterface $minDate Date minimum
     * @param int $skip Nombre de devis à ignorer (pagination)
     * @param string $sort Champ de tri et direction (ex. "date:-1")
     * @param 'draft'|'pending'|'waiting'|'accepted'|'refused'|'invoiced'|'canceled'|'inactive'|\Wuro\Quotes\QuoteListParams\State $state Filtre par état du devis
     * @param 'quote'|'proforma'|'bdc'|\Wuro\Quotes\QuoteListParams\Type $type Filtre par type de document
     *
     * @throws APIException
     */
    public function list(
        ?string $client = null,
        int $limit = 20,
        string|\DateTimeInterface|null $maxDate = null,
        string|\DateTimeInterface|null $minDate = null,
        int $skip = 0,
        ?string $sort = null,
        string|\Wuro\Quotes\QuoteListParams\State|null $state = null,
        string|\Wuro\Quotes\QuoteListParams\Type|null $type = null,
        ?RequestOptions $requestOptions = null,
    ): QuoteListResponse;

    /**
     * @api
     *
     * @throws APIException
     */
    public function delete(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): QuoteDeleteResponse;

    /**
     * @api
     *
     * @param string $uid ID du devis
     * @param float $amount Montant de l'acompte
     * @param float $percentage Pourcentage de l'acompte
     *
     * @throws APIException
     */
    public function createAdvanceInvoice(
        string $uid,
        ?float $amount = null,
        ?float $percentage = null,
        ?RequestOptions $requestOptions = null,
    ): QuoteNewAdvanceInvoiceResponse;

    /**
     * @api
     *
     * @param string $uid ID du devis
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
     * @param string $uid ID du devis
     *
     * @throws APIException
     */
    public function createInvoice(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): QuoteNewInvoiceResponse;

    /**
     * @api
     *
     * @param string $uid ID du devis
     *
     * @throws APIException
     */
    public function createInvoiceFromQuote(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): QuoteNewInvoiceFromQuoteResponse;

    /**
     * @api
     *
     * @param list<string> $quotesID Liste des IDs de devis à inclure
     * @param bool $deferred Forcer le mode différé
     *
     * @throws APIException
     */
    public function createPackage(
        array $quotesID,
        ?bool $deferred = null,
        ?RequestOptions $requestOptions = null,
    ): QuoteNewPackageResponse;

    /**
     * @api
     *
     * @param string $uid ID du devis
     *
     * @throws APIException
     */
    public function createProformaInvoice(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): QuoteNewProformaInvoiceResponse;

    /**
     * @api
     *
     * @param string $uid ID du devis
     *
     * @throws APIException
     */
    public function createPurchaseOrder(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): QuoteNewPurchaseOrderResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du devis
     *
     * @throws APIException
     */
    public function generateHTML(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): string;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du devis
     *
     * @throws APIException
     */
    public function generatePdf(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): string;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du devis
     *
     * @throws APIException
     */
    public function generatePdfChromium(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): string;

    /**
     * @api
     *
     * @throws APIException
     */
    public function getLogs(
        int $limit = 20,
        int $skip = 0,
        ?RequestOptions $requestOptions = null
    ): QuoteGetLogsResponse;

    /**
     * @api
     *
     * @throws APIException
     */
    public function getStats(
        string|\DateTimeInterface|null $maxDate = null,
        string|\DateTimeInterface|null $minDate = null,
        ?string $state = null,
        ?RequestOptions $requestOptions = null,
    ): QuoteGetStatsResponse;

    /**
     * @api
     *
     * @param string $uid ID du devis
     *
     * @throws APIException
     */
    public function retrieveLogs(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): mixed;
}
