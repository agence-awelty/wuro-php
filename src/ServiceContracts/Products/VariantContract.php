<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts\Products;

use Wuro\Core\Exceptions\APIException;
use Wuro\RequestOptions;

interface VariantContract
{
    /**
     * @api
     *
     * @param string $uid Identifiant unique du produit parent
     * @param array{nbAlert?: float, nbMin?: float, nbStock?: float} $stock
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
        ?array $stock = null,
        ?float $tvaRate = null,
        ?RequestOptions $requestOptions = null,
    ): mixed;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de la variante
     * @param string $productID Identifiant unique du produit parent
     *
     * @throws APIException
     */
    public function retrieve(
        string $uid,
        string $productID,
        ?RequestOptions $requestOptions = null
    ): mixed;

    /**
     * @api
     *
     * @param string $uid Path param: Identifiant unique de la variante
     * @param string $productID Path param: Identifiant unique du produit parent
     * @param float $buyingPrice Body param:
     * @param string $name Body param:
     * @param mixed $options Body param:
     * @param float $priceHt Body param:
     * @param string $reference Body param:
     * @param string $sku Body param:
     * @param array{
     *   nbAlert?: float, nbMin?: float, nbStock?: float
     * } $stock Body param:
     * @param float $tvaRate Body param:
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
        ?array $stock = null,
        ?float $tvaRate = null,
        ?RequestOptions $requestOptions = null,
    ): mixed;

    /**
     * @api
     *
     * @throws APIException
     */
    public function list(?RequestOptions $requestOptions = null): mixed;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de la variante
     * @param string $productID Identifiant unique du produit parent
     *
     * @throws APIException
     */
    public function delete(
        string $uid,
        string $productID,
        ?RequestOptions $requestOptions = null
    ): mixed;
}
