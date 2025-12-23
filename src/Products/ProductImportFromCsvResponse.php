<?php

declare(strict_types=1);

namespace Wuro\Products;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-type ProductImportFromCsvResponseShape = array{
 *   created?: int|null, errors?: list<mixed>|null, updated?: int|null
 * }
 */
final class ProductImportFromCsvResponse implements BaseModel
{
    /** @use SdkModel<ProductImportFromCsvResponseShape> */
    use SdkModel;

    /**
     * Nombre de produits créés.
     */
    #[Optional]
    public ?int $created;

    /**
     * Liste des erreurs rencontrées.
     *
     * @var list<mixed>|null $errors
     */
    #[Optional(list: 'mixed')]
    public ?array $errors;

    /**
     * Nombre de produits mis à jour.
     */
    #[Optional]
    public ?int $updated;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<mixed>|null $errors
     */
    public static function with(
        ?int $created = null,
        ?array $errors = null,
        ?int $updated = null
    ): self {
        $self = new self;

        null !== $created && $self['created'] = $created;
        null !== $errors && $self['errors'] = $errors;
        null !== $updated && $self['updated'] = $updated;

        return $self;
    }

    /**
     * Nombre de produits créés.
     */
    public function withCreated(int $created): self
    {
        $self = clone $this;
        $self['created'] = $created;

        return $self;
    }

    /**
     * Liste des erreurs rencontrées.
     *
     * @param list<mixed> $errors
     */
    public function withErrors(array $errors): self
    {
        $self = clone $this;
        $self['errors'] = $errors;

        return $self;
    }

    /**
     * Nombre de produits mis à jour.
     */
    public function withUpdated(int $updated): self
    {
        $self = clone $this;
        $self['updated'] = $updated;

        return $self;
    }
}
