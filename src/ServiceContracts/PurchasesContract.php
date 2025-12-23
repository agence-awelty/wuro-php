<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts;

use Wuro\Core\Exceptions\APIException;
use Wuro\Purchases\PurchaseCreateParams\State;
use Wuro\Purchases\PurchaseCreateParams\Type;
use Wuro\Purchases\PurchaseDeleteResponse;
use Wuro\Purchases\PurchaseGetResponse;
use Wuro\Purchases\PurchaseListResponse;
use Wuro\Purchases\PurchaseNewCreditResponse;
use Wuro\Purchases\PurchaseNewResponse;
use Wuro\Purchases\PurchaseUpdateResponse;
use Wuro\RequestOptions;

interface PurchasesContract
{
    /**
     * @api
     *
     * @param list<string> $categories
     * @param list<array{
     *   title?: string,
     *   totalHt?: float,
     *   totalTtc?: float,
     *   totalTva?: float,
     *   tvaRate?: float,
     *   type?: string,
     * }> $lines
     * @param list<array{
     *   amount?: float, date?: string|\DateTimeInterface, mode?: string
     * }> $payments
     * @param 'draft'|'waiting'|'paid'|'to_pay'|'notpaid'|State $state
     * @param 'purchase'|'purchase_credit'|Type $type
     *
     * @throws APIException
     */
    public function create(
        ?string $analyticalCode = null,
        ?array $categories = null,
        ?string $currency = null,
        string|\DateTimeInterface|null $date = null,
        ?string $invoiceNumber = null,
        ?array $lines = null,
        string|\DateTimeInterface|null $paymentDate = null,
        string|\DateTimeInterface|null $paymentExpiryDate = null,
        ?array $payments = null,
        string|State|null $state = null,
        ?string $supplier = null,
        ?string $supplierCode = null,
        ?string $supplierName = null,
        ?bool $supplierReverseCharge = null,
        ?string $supplierTvaNumber = null,
        ?float $totalHt = null,
        ?float $totalTtc = null,
        ?float $totalTva = null,
        string|Type|null $type = null,
        ?RequestOptions $requestOptions = null,
    ): PurchaseNewResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de l'achat
     * @param string $populate Relations à inclure (ex. "supplier")
     *
     * @throws APIException
     */
    public function retrieve(
        string $uid,
        ?string $populate = null,
        ?RequestOptions $requestOptions = null,
    ): PurchaseGetResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de l'achat
     * @param list<string> $categories
     * @param list<array{
     *   title?: string,
     *   totalHt?: float,
     *   totalTtc?: float,
     *   totalTva?: float,
     *   tvaRate?: float,
     *   type?: string,
     * }> $lines
     * @param list<array{
     *   amount?: float, date?: string|\DateTimeInterface, mode?: string
     * }> $payments
     * @param 'draft'|'waiting'|'paid'|'to_pay'|'notpaid'|\Wuro\Purchases\PurchaseUpdateParams\State $state
     * @param 'purchase'|'purchase_credit'|\Wuro\Purchases\PurchaseUpdateParams\Type $type
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        ?string $analyticalCode = null,
        ?array $categories = null,
        ?string $currency = null,
        string|\DateTimeInterface|null $date = null,
        ?string $invoiceNumber = null,
        ?array $lines = null,
        string|\DateTimeInterface|null $paymentDate = null,
        string|\DateTimeInterface|null $paymentExpiryDate = null,
        ?array $payments = null,
        string|\Wuro\Purchases\PurchaseUpdateParams\State|null $state = null,
        ?string $supplier = null,
        ?string $supplierCode = null,
        ?string $supplierName = null,
        ?bool $supplierReverseCharge = null,
        ?string $supplierTvaNumber = null,
        ?float $totalHt = null,
        ?float $totalTtc = null,
        ?float $totalTva = null,
        string|\Wuro\Purchases\PurchaseUpdateParams\Type|null $type = null,
        ?RequestOptions $requestOptions = null,
    ): PurchaseUpdateResponse;

    /**
     * @api
     *
     * @param int $limit Nombre maximum d'achats à retourner
     * @param int $skip Nombre d'achats à ignorer (pagination)
     * @param string $sort Champ et direction de tri (ex. "date:-1" pour les plus récents)
     * @param 'draft'|'waiting'|'paid'|'to_pay'|'notpaid'|'inactive'|\Wuro\Purchases\PurchaseListParams\State $state Filtrer par état de l'achat
     * @param string $supplier Filtrer par fournisseur (ID du fournisseur)
     *
     * @throws APIException
     */
    public function list(
        int $limit = 20,
        int $skip = 0,
        ?string $sort = null,
        string|\Wuro\Purchases\PurchaseListParams\State|null $state = null,
        ?string $supplier = null,
        ?RequestOptions $requestOptions = null,
    ): PurchaseListResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de l'achat
     *
     * @throws APIException
     */
    public function delete(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): PurchaseDeleteResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de l'achat d'origine
     *
     * @throws APIException
     */
    public function createCredit(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): PurchaseNewCreditResponse;

    /**
     * @api
     *
     * @throws APIException
     */
    public function getStats(?RequestOptions $requestOptions = null): mixed;
}
