<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts;

use Wuro\Core\Exceptions\APIException;
use Wuro\Purchases\PurchaseCreateParams\Line;
use Wuro\Purchases\PurchaseCreateParams\Payment;
use Wuro\Purchases\PurchaseCreateParams\State;
use Wuro\Purchases\PurchaseCreateParams\Type;
use Wuro\Purchases\PurchaseDeleteResponse;
use Wuro\Purchases\PurchaseGetResponse;
use Wuro\Purchases\PurchaseListResponse;
use Wuro\Purchases\PurchaseNewCreditResponse;
use Wuro\Purchases\PurchaseNewResponse;
use Wuro\Purchases\PurchaseUpdateResponse;
use Wuro\RequestOptions;

/**
 * @phpstan-import-type LineShape from \Wuro\Purchases\PurchaseCreateParams\Line
 * @phpstan-import-type PaymentShape from \Wuro\Purchases\PurchaseCreateParams\Payment
 * @phpstan-import-type LineShape from \Wuro\Purchases\PurchaseUpdateParams\Line as LineShape1
 * @phpstan-import-type PaymentShape from \Wuro\Purchases\PurchaseUpdateParams\Payment as PaymentShape1
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
interface PurchasesContract
{
    /**
     * @api
     *
     * @param list<string> $categories
     * @param list<Line|LineShape> $lines
     * @param list<Payment|PaymentShape> $payments
     * @param State|value-of<State> $state
     * @param Type|value-of<Type> $type
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        ?string $analyticalCode = null,
        ?array $categories = null,
        ?string $currency = null,
        ?\DateTimeInterface $date = null,
        ?string $invoiceNumber = null,
        ?array $lines = null,
        ?\DateTimeInterface $paymentDate = null,
        ?\DateTimeInterface $paymentExpiryDate = null,
        ?array $payments = null,
        State|string|null $state = null,
        ?string $supplier = null,
        ?string $supplierCode = null,
        ?string $supplierName = null,
        ?bool $supplierReverseCharge = null,
        ?string $supplierTvaNumber = null,
        ?float $totalHt = null,
        ?float $totalTtc = null,
        ?float $totalTva = null,
        Type|string|null $type = null,
        RequestOptions|array|null $requestOptions = null,
    ): PurchaseNewResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de l'achat
     * @param string $populate Relations à inclure (ex. "supplier")
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $uid,
        ?string $populate = null,
        RequestOptions|array|null $requestOptions = null,
    ): PurchaseGetResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de l'achat
     * @param list<string> $categories
     * @param list<\Wuro\Purchases\PurchaseUpdateParams\Line|LineShape1> $lines
     * @param list<\Wuro\Purchases\PurchaseUpdateParams\Payment|PaymentShape1> $payments
     * @param \Wuro\Purchases\PurchaseUpdateParams\State|value-of<\Wuro\Purchases\PurchaseUpdateParams\State> $state
     * @param \Wuro\Purchases\PurchaseUpdateParams\Type|value-of<\Wuro\Purchases\PurchaseUpdateParams\Type> $type
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        ?string $analyticalCode = null,
        ?array $categories = null,
        ?string $currency = null,
        ?\DateTimeInterface $date = null,
        ?string $invoiceNumber = null,
        ?array $lines = null,
        ?\DateTimeInterface $paymentDate = null,
        ?\DateTimeInterface $paymentExpiryDate = null,
        ?array $payments = null,
        \Wuro\Purchases\PurchaseUpdateParams\State|string|null $state = null,
        ?string $supplier = null,
        ?string $supplierCode = null,
        ?string $supplierName = null,
        ?bool $supplierReverseCharge = null,
        ?string $supplierTvaNumber = null,
        ?float $totalHt = null,
        ?float $totalTtc = null,
        ?float $totalTva = null,
        \Wuro\Purchases\PurchaseUpdateParams\Type|string|null $type = null,
        RequestOptions|array|null $requestOptions = null,
    ): PurchaseUpdateResponse;

    /**
     * @api
     *
     * @param int $limit Nombre maximum d'achats à retourner
     * @param int $skip Nombre d'achats à ignorer (pagination)
     * @param string $sort Champ et direction de tri (ex. "date:-1" pour les plus récents)
     * @param \Wuro\Purchases\PurchaseListParams\State|value-of<\Wuro\Purchases\PurchaseListParams\State> $state Filtrer par état de l'achat
     * @param string $supplier Filtrer par fournisseur (ID du fournisseur)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        int $limit = 20,
        int $skip = 0,
        ?string $sort = null,
        \Wuro\Purchases\PurchaseListParams\State|string|null $state = null,
        ?string $supplier = null,
        RequestOptions|array|null $requestOptions = null,
    ): PurchaseListResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de l'achat
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): PurchaseDeleteResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de l'achat d'origine
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function createCredit(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): PurchaseNewCreditResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function getStats(
        RequestOptions|array|null $requestOptions = null
    ): mixed;
}
