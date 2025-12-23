<?php

declare(strict_types=1);

namespace Wuro\Invoices\Line;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Attributes\Required;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Concerns\SdkParams;
use Wuro\Core\Contracts\BaseModel;

/**
 * Met à jour une ligne existante d'une facture.
 *
 * **Restrictions:**
 * - La facture ne doit pas être numérotée (en brouillon uniquement)
 * - Une facture validée ne peut pas être modifiée
 *
 * **Comportement:**
 * - Les totaux de la facture sont automatiquement recalculés après modification
 * - Seuls les champs fournis sont modifiés (mise à jour partielle)
 *
 * **Types de lignes:**
 * - **product** : Ligne produit standard avec prix et quantité
 * - **header** : Ligne de titre/séparation
 * - **subtotal** : Sous-total automatique
 * - **globalDiscount** : Remise globale
 *
 * **Événement déclenché:** UPDATE_INVOICE
 *
 * @see Wuro\Services\Invoices\LineService::update()
 *
 * @phpstan-type LineUpdateParamsShape = array{
 *   uid: string,
 *   description?: string|null,
 *   discount?: float|null,
 *   priceHt?: float|null,
 *   quantity?: float|null,
 *   reference?: string|null,
 *   title?: string|null,
 *   tvaRate?: float|null,
 *   unit?: string|null,
 * }
 */
final class LineUpdateParams implements BaseModel
{
    /** @use SdkModel<LineUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $uid;

    /**
     * Description détaillée.
     */
    #[Optional]
    public ?string $description;

    /**
     * Remise en pourcentage.
     */
    #[Optional]
    public ?float $discount;

    /**
     * Prix unitaire HT.
     */
    #[Optional('price_ht')]
    public ?float $priceHt;

    /**
     * Quantité.
     */
    #[Optional]
    public ?float $quantity;

    /**
     * Référence produit.
     */
    #[Optional]
    public ?string $reference;

    /**
     * Titre de la ligne.
     */
    #[Optional]
    public ?string $title;

    /**
     * Taux de TVA (ex. 20 pour 20%).
     */
    #[Optional('tva_rate')]
    public ?float $tvaRate;

    /**
     * Unité de mesure (pièce, heure, kg, etc.).
     */
    #[Optional]
    public ?string $unit;

    /**
     * `new LineUpdateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * LineUpdateParams::with(uid: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new LineUpdateParams)->withUid(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(
        string $uid,
        ?string $description = null,
        ?float $discount = null,
        ?float $priceHt = null,
        ?float $quantity = null,
        ?string $reference = null,
        ?string $title = null,
        ?float $tvaRate = null,
        ?string $unit = null,
    ): self {
        $self = new self;

        $self['uid'] = $uid;

        null !== $description && $self['description'] = $description;
        null !== $discount && $self['discount'] = $discount;
        null !== $priceHt && $self['priceHt'] = $priceHt;
        null !== $quantity && $self['quantity'] = $quantity;
        null !== $reference && $self['reference'] = $reference;
        null !== $title && $self['title'] = $title;
        null !== $tvaRate && $self['tvaRate'] = $tvaRate;
        null !== $unit && $self['unit'] = $unit;

        return $self;
    }

    public function withUid(string $uid): self
    {
        $self = clone $this;
        $self['uid'] = $uid;

        return $self;
    }

    /**
     * Description détaillée.
     */
    public function withDescription(string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * Remise en pourcentage.
     */
    public function withDiscount(float $discount): self
    {
        $self = clone $this;
        $self['discount'] = $discount;

        return $self;
    }

    /**
     * Prix unitaire HT.
     */
    public function withPriceHt(float $priceHt): self
    {
        $self = clone $this;
        $self['priceHt'] = $priceHt;

        return $self;
    }

    /**
     * Quantité.
     */
    public function withQuantity(float $quantity): self
    {
        $self = clone $this;
        $self['quantity'] = $quantity;

        return $self;
    }

    /**
     * Référence produit.
     */
    public function withReference(string $reference): self
    {
        $self = clone $this;
        $self['reference'] = $reference;

        return $self;
    }

    /**
     * Titre de la ligne.
     */
    public function withTitle(string $title): self
    {
        $self = clone $this;
        $self['title'] = $title;

        return $self;
    }

    /**
     * Taux de TVA (ex. 20 pour 20%).
     */
    public function withTvaRate(float $tvaRate): self
    {
        $self = clone $this;
        $self['tvaRate'] = $tvaRate;

        return $self;
    }

    /**
     * Unité de mesure (pièce, heure, kg, etc.).
     */
    public function withUnit(string $unit): self
    {
        $self = clone $this;
        $self['unit'] = $unit;

        return $self;
    }
}
