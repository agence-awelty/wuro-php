<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts\Products;

use Wuro\Core\Exceptions\APIException;
use Wuro\Products\Variant\VariantCreateParams\Stock;
use Wuro\RequestOptions;

/**
 * @phpstan-import-type StockShape from \Wuro\Products\Variant\VariantCreateParams\Stock
 * @phpstan-import-type StockShape from \Wuro\Products\Variant\VariantUpdateParams\Stock as StockShape1
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
interface VariantContract
{
    /**
     * @api
     *
     * @param string $uid Identifiant unique du produit parent
     * @param Stock|StockShape $stock
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $uid,
        ?float $buyingPrice = null,
        ?string $name = null,
        mixed $options = null,
        ?float $priceHt = null,
        ?string $reference = null,
        ?string $sku = null,
        Stock|array|null $stock = null,
        ?float $tvaRate = null,
        RequestOptions|array|null $requestOptions = null,
    ): mixed;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de la variante
     * @param string $productID Identifiant unique du produit parent
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $uid,
        string $productID,
        RequestOptions|array|null $requestOptions = null,
    ): mixed;

    /**
     * @api
     *
     * @param string $uid Path param: Identifiant unique de la variante
     * @param string $productID Path param: Identifiant unique du produit parent
     * @param float $buyingPrice Body param
     * @param string $name Body param
     * @param mixed $options Body param
     * @param float $priceHt Body param
     * @param string $reference Body param
     * @param string $sku Body param
     * @param \Wuro\Products\Variant\VariantUpdateParams\Stock|StockShape1 $stock Body param
     * @param float $tvaRate Body param
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        string $productID,
        ?float $buyingPrice = null,
        ?string $name = null,
        mixed $options = null,
        ?float $priceHt = null,
        ?string $reference = null,
        ?string $sku = null,
        \Wuro\Products\Variant\VariantUpdateParams\Stock|array|null $stock = null,
        ?float $tvaRate = null,
        RequestOptions|array|null $requestOptions = null,
    ): mixed;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): mixed;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de la variante
     * @param string $productID Identifiant unique du produit parent
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $uid,
        string $productID,
        RequestOptions|array|null $requestOptions = null,
    ): mixed;
}
