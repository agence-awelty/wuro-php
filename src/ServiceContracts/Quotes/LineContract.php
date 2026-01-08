<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts\Quotes;

use Wuro\Core\Exceptions\APIException;
use Wuro\Quotes\Line\LineAddParams\Type;
use Wuro\Quotes\Line\LineAddResponse;
use Wuro\Quotes\Line\LineUpdateResponse;
use Wuro\Quotes\Line\Quote;
use Wuro\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
interface LineContract
{
    /**
     * @api
     *
     * @param string $lineUuid Path param: Identifiant unique de la ligne à modifier
     * @param string $uid Path param: Identifiant unique du devis
     * @param string $description Body param: Description détaillée
     * @param float $discount Body param: Remise en pourcentage
     * @param float $priceHt Body param: Prix unitaire HT
     * @param float $quantity Body param: Quantité
     * @param string $reference Body param: Référence produit
     * @param string $title Body param: Titre de la ligne
     * @param float $tvaRate Body param: Taux de TVA (ex. 20 pour 20%)
     * @param string $unit Body param: Unité de mesure (pièce, heure, kg, etc.)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $lineUuid,
        string $uid,
        ?string $description = null,
        ?float $discount = null,
        ?float $priceHt = null,
        ?float $quantity = null,
        ?string $reference = null,
        ?string $title = null,
        ?float $tvaRate = null,
        ?string $unit = null,
        RequestOptions|array|null $requestOptions = null,
    ): LineUpdateResponse;

    /**
     * @api
     *
     * @param string $lineUuid Identifiant unique de la ligne à supprimer
     * @param string $uid Identifiant unique du devis
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $lineUuid,
        string $uid,
        RequestOptions|array|null $requestOptions = null,
    ): Quote;

    /**
     * @api
     *
     * @param string $uid ID du devis
     * @param string $_id Unique identifier for the line
     * @param string $description Description of the line
     * @param float $priceHt Price without tax
     * @param float $quantity Quantity
     * @param string $reference Reference of the product
     * @param string $title Title of the line
     * @param float $totalHt Total amount without tax
     * @param float $totalTtc Total amount with tax
     * @param float $tvaRate VAT rate
     * @param Type|value-of<Type> $type Type of the line
     * @param string $unit Unit of measurement
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function add(
        string $uid,
        ?string $_id = null,
        ?string $description = null,
        float $priceHt = 0,
        float $quantity = 1,
        ?string $reference = null,
        ?string $title = null,
        float $totalHt = 0,
        float $totalTtc = 0,
        ?float $tvaRate = null,
        Type|string $type = 'product',
        ?string $unit = null,
        RequestOptions|array|null $requestOptions = null,
    ): LineAddResponse;
}
