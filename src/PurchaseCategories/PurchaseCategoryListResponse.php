<?php

declare(strict_types=1);

namespace Wuro\PurchaseCategories;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;
use Wuro\PurchaseCategories\PurchaseCategoryListResponse\Data;

/**
 * @phpstan-import-type DataShape from \Wuro\PurchaseCategories\PurchaseCategoryListResponse\Data
 *
 * @phpstan-type PurchaseCategoryListResponseShape = array{
 *   count?: int|null, data?: list<Data|DataShape>|null
 * }
 */
final class PurchaseCategoryListResponse implements BaseModel
{
    /** @use SdkModel<PurchaseCategoryListResponseShape> */
    use SdkModel;

    /**
     * Nombre total de catégories.
     */
    #[Optional]
    public ?int $count;

    /** @var list<Data>|null $data */
    #[Optional(list: Data::class)]
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
     * @param list<Data|DataShape>|null $data
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
     * @param list<Data|DataShape> $data
     */
    public function withData(array $data): self
    {
        $self = clone $this;
        $self['data'] = $data;

        return $self;
    }
}
