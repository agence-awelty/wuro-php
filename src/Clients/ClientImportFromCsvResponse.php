<?php

declare(strict_types=1);

namespace Wuro\Clients;

use Wuro\Clients\ClientImportFromCsvResponse\Error;
use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type ErrorShape from \Wuro\Clients\ClientImportFromCsvResponse\Error
 *
 * @phpstan-type ClientImportFromCsvResponseShape = array{
 *   created?: int|null, errors?: list<ErrorShape>|null, updated?: int|null
 * }
 */
final class ClientImportFromCsvResponse implements BaseModel
{
    /** @use SdkModel<ClientImportFromCsvResponseShape> */
    use SdkModel;

    /**
     * Nombre de clients créés.
     */
    #[Optional]
    public ?int $created;

    /**
     * Liste des erreurs rencontrées.
     *
     * @var list<Error>|null $errors
     */
    #[Optional(list: Error::class)]
    public ?array $errors;

    /**
     * Nombre de clients mis à jour.
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
     * @param list<ErrorShape>|null $errors
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
     * Nombre de clients créés.
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
     * @param list<ErrorShape> $errors
     */
    public function withErrors(array $errors): self
    {
        $self = clone $this;
        $self['errors'] = $errors;

        return $self;
    }

    /**
     * Nombre de clients mis à jour.
     */
    public function withUpdated(int $updated): self
    {
        $self = clone $this;
        $self['updated'] = $updated;

        return $self;
    }
}
