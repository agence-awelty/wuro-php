<?php

declare(strict_types=1);

namespace Wuro\PurchaseCategories;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Attributes\Required;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Concerns\SdkParams;
use Wuro\Core\Contracts\BaseModel;

/**
 * Crée une nouvelle catégorie pour organiser les achats/dépenses.
 *
 * **Exemples de catégories:**
 * - Fournitures de bureau
 * - Services externes
 * - Frais de déplacement
 * - Abonnements
 *
 * **Champs requis:**
 * - `name` : Nom de la catégorie
 *
 * **Événement déclenché:** CREATE_PURCHASE_CATEGORY
 *
 * @see Wuro\Services\PurchaseCategoriesService::create()
 *
 * @phpstan-type PurchaseCategoryCreateParamsShape = array{
 *   name: string, company?: string|null
 * }
 */
final class PurchaseCategoryCreateParams implements BaseModel
{
    /** @use SdkModel<PurchaseCategoryCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Nom de la catégorie.
     */
    #[Required]
    public string $name;

    /**
     * ID de l'entreprise (optionnel, défaut = entreprise courante).
     */
    #[Optional]
    public ?string $company;

    /**
     * `new PurchaseCategoryCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PurchaseCategoryCreateParams::with(name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PurchaseCategoryCreateParams)->withName(...)
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
    public static function with(string $name, ?string $company = null): self
    {
        $self = new self;

        $self['name'] = $name;

        null !== $company && $self['company'] = $company;

        return $self;
    }

    /**
     * Nom de la catégorie.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * ID de l'entreprise (optionnel, défaut = entreprise courante).
     */
    public function withCompany(string $company): self
    {
        $self = clone $this;
        $self['company'] = $company;

        return $self;
    }
}
