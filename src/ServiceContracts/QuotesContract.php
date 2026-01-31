<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts;

use Wuro\Core\Exceptions\APIException;
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

/**
 * @phpstan-import-type QuoteLineShape from \Wuro\Quotes\QuoteCreateParams\QuoteLine as QuoteLineShape1
 * @phpstan-import-type QuoteLineShape from \Wuro\Quotes\Line\QuoteLine
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
interface QuotesContract
{
    /**
     * @api
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
    ): QuoteNewResponse;

    /**
     * @api
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
    ): QuoteGetResponse;

    /**
     * @api
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
    ): QuoteUpdateResponse;

    /**
     * @api
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
    ): QuoteListResponse;

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
    ): QuoteDeleteResponse;

    /**
     * @api
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
    ): QuoteNewAdvanceInvoiceResponse;

    /**
     * @api
     *
     * @param string $uid ID du devis
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
     * @param string $uid ID du devis
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function createInvoice(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): QuoteNewInvoiceResponse;

    /**
     * @api
     *
     * @param string $uid ID du devis
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function createInvoiceFromQuote(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): QuoteNewInvoiceFromQuoteResponse;

    /**
     * @api
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
    ): QuoteNewPackageResponse;

    /**
     * @api
     *
     * @param string $uid ID du devis
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function createProformaInvoice(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): QuoteNewProformaInvoiceResponse;

    /**
     * @api
     *
     * @param string $uid ID du devis
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function createPurchaseOrder(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): QuoteNewPurchaseOrderResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du devis
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function generateHTML(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): string;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du devis
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function generatePdf(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): string;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du devis
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function generatePdfChromium(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): string;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function getLogs(
        int $limit = 20,
        int $skip = 0,
        RequestOptions|array|null $requestOptions = null,
    ): QuoteGetLogsResponse;

    /**
     * @api
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
    ): QuoteGetStatsResponse;

    /**
     * @api
     *
     * @param string $uid ID du devis
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveLogs(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): mixed;
}
