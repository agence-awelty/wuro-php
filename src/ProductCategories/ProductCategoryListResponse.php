<?php

declare(strict_types=1);

namespace Wuro\ProductCategories;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type ProductCategoryShape from \Wuro\ProductCategories\ProductCategory
 *
 * @phpstan-type ProductCategoryListResponseShape = array{
 *   count?: int|null, data?: list<ProductCategoryShape>|null
 * }
 */
final class ProductCategoryListResponse implements BaseModel
{
    /** @use SdkModel<ProductCategoryListResponseShape> */
    use SdkModel;

    /**
     * Nombre total de catégories.
     */
    #[Optional]
    public ?int $count;

    /** @var list<ProductCategory>|null $data */
    #[Optional(list: ProductCategory::class)]
    public ?array $data;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<ProductCategoryShape>|null $data
     */
    public static function with(?int $count = null, ?array $data = null): self
    {
        $self = new self;

        null !== $count && $self['count'] = $count;
        null !== $data && $self['data'] = $data;

        return $self;
    }

    /**
     * Nombre total de catégories.
     */
    public function withCount(int $count): self
    {
        $self = clone $this;
        $self['count'] = $count;

        return $self;
    }

    /**
     * @param list<ProductCategoryShape> $data
     */
    public function withData(array $data): self
    {
        $self = clone $this;
        $self['data'] = $data;

        return $self;
    }
}
