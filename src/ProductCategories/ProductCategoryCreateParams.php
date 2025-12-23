<?php

declare(strict_types=1);

namespace Wuro\ProductCategories;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Attributes\Required;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Concerns\SdkParams;
use Wuro\Core\Contracts\BaseModel;

/**
 * Crée une nouvelle catégorie pour organiser les produits.
 *
 * **Champs requis:**
 * - `name` : Nom de la catégorie
 *
 * **Événement déclenché:** CREATE_PRODUCT_CATEGORY
 *
 * @see Wuro\Services\ProductCategoriesService::create()
 *
 * @phpstan-type ProductCategoryCreateParamsShape = array{
 *   name: string, company?: string|null
 * }
 */
final class ProductCategoryCreateParams implements BaseModel
{
    /** @use SdkModel<ProductCategoryCreateParamsShape> */
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
     * `new ProductCategoryCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ProductCategoryCreateParams::with(name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ProductCategoryCreateParams)->withName(...)
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
