<?php

declare(strict_types=1);

namespace Wuro;

use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Wuro\Core\BaseClient;
use Wuro\Core\Util;
use Wuro\Services\AbsencesService;
use Wuro\Services\AbsenceTypesService;
use Wuro\Services\AuthService;
use Wuro\Services\ClientsService;
use Wuro\Services\CompaniesService;
use Wuro\Services\CompanyMailsService;
use Wuro\Services\DeliveryReceiptsService;
use Wuro\Services\ExportService;
use Wuro\Services\InvoiceFileService;
use Wuro\Services\InvoicesService;
use Wuro\Services\OrderService;
use Wuro\Services\PaymentMethodsService;
use Wuro\Services\ProductCategoriesService;
use Wuro\Services\ProductsService;
use Wuro\Services\ProductUnitsService;
use Wuro\Services\PurchaseCategoriesService;
use Wuro\Services\PurchaseFileService;
use Wuro\Services\PurchasesService;
use Wuro\Services\QuotesService;
use Wuro\Services\StatisticsService;
use Wuro\Services\UsersService;

/**
 * @phpstan-import-type NormalizedRequest from \Wuro\Core\BaseClient
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
class Client extends BaseClient
{
    public string $appID;

    public string $appSecret;

    /**
     * @api
     */
    public InvoiceFileService $invoiceFile;

    /**
     * @api
     */
    public OrderService $order;

    /**
     * @api
     */
    public StatisticsService $statistics;

    /**
     * @api
     */
    public ExportService $export;

    /**
     * @api
     */
    public CompanyMailsService $companyMails;

    /**
     * @api
     */
    public ProductUnitsService $productUnits;

    /**
     * @api
     */
    public PurchaseFileService $purchaseFile;

    /**
     * @api
     */
    public InvoicesService $invoices;

    /**
     * @api
     */
    public QuotesService $quotes;

    /**
     * @api
     */
    public PaymentMethodsService $paymentMethods;

    /**
     * @api
     */
    public DeliveryReceiptsService $deliveryReceipts;

    /**
     * @api
     */
    public AbsenceTypesService $absenceTypes;

    /**
     * @api
     */
    public AbsencesService $absences;

    /**
     * @api
     */
    public CompaniesService $companies;

    /**
     * @api
     */
    public ClientsService $clients;

    /**
     * @api
     */
    public ProductsService $products;

    /**
     * @api
     */
    public ProductCategoriesService $productCategories;

    /**
     * @api
     */
    public PurchasesService $purchases;

    /**
     * @api
     */
    public PurchaseCategoriesService $purchaseCategories;

    /**
     * @api
     */
    public UsersService $users;

    /**
     * @api
     */
    public AuthService $auth;

    public function __construct(
        ?string $appID = null,
        ?string $appSecret = null,
        ?string $baseUrl = null
    ) {
        $this->appID = (string) ($appID ?? getenv('WURO_APP_ID'));
        $this->appSecret = (string) ($appSecret ?? getenv('WURO_APP_SECRET'));

        $baseUrl ??= getenv('WURO_BASE_URL') ?: 'https://wuro.pro/api/v3.2';

        $options = RequestOptions::with(
            uriFactory: Psr17FactoryDiscovery::findUriFactory(),
            streamFactory: Psr17FactoryDiscovery::findStreamFactory(),
            requestFactory: Psr17FactoryDiscovery::findRequestFactory(),
            transporter: Psr18ClientDiscovery::find(),
        );

        parent::__construct(
            headers: [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'User-Agent' => sprintf('wuro/PHP %s', VERSION),
                'X-Stainless-Lang' => 'php',
                'X-Stainless-Package-Version' => '0.0.1',
                'X-Stainless-Arch' => Util::machtype(),
                'X-Stainless-OS' => Util::ostype(),
                'X-Stainless-Runtime' => php_sapi_name(),
                'X-Stainless-Runtime-Version' => phpversion(),
            ],
            baseUrl: $baseUrl,
            options: $options
        );

        $this->invoiceFile = new InvoiceFileService($this);
        $this->order = new OrderService($this);
        $this->statistics = new StatisticsService($this);
        $this->export = new ExportService($this);
        $this->companyMails = new CompanyMailsService($this);
        $this->productUnits = new ProductUnitsService($this);
        $this->purchaseFile = new PurchaseFileService($this);
        $this->invoices = new InvoicesService($this);
        $this->quotes = new QuotesService($this);
        $this->paymentMethods = new PaymentMethodsService($this);
        $this->deliveryReceipts = new DeliveryReceiptsService($this);
        $this->absenceTypes = new AbsenceTypesService($this);
        $this->absences = new AbsencesService($this);
        $this->companies = new CompaniesService($this);
        $this->clients = new ClientsService($this);
        $this->products = new ProductsService($this);
        $this->productCategories = new ProductCategoriesService($this);
        $this->purchases = new PurchasesService($this);
        $this->purchaseCategories = new PurchaseCategoriesService($this);
        $this->users = new UsersService($this);
        $this->auth = new AuthService($this);
    }

    /** @return array<string,string> */
    protected function authHeaders(): array
    {
        return [...$this->appIDAuth(), ...$this->appSecretAuth()];
    }

    /** @return array<string,string> */
    protected function appIDAuth(): array
    {
        return $this->appID ? ['X-APP-ID' => $this->appID] : [];
    }

    /** @return array<string,string> */
    protected function appSecretAuth(): array
    {
        return $this->appSecret ? ['X-APP-SECRET' => $this->appSecret] : [];
    }

    /**
     * @internal
     *
     * @param string|list<string> $path
     * @param array<string,mixed> $query
     * @param array<string,string|int|list<string|int>|null> $headers
     * @param RequestOpts|null $opts
     *
     * @return array{NormalizedRequest, RequestOptions}
     */
    protected function buildRequest(
        string $method,
        string|array $path,
        array $query,
        array $headers,
        mixed $body,
        RequestOptions|array|null $opts,
    ): array {
        return parent::buildRequest(
            method: $method,
            path: $path,
            query: $query,
            headers: [...$this->authHeaders(), ...$headers],
            body: $body,
            opts: $opts,
        );
    }
}
