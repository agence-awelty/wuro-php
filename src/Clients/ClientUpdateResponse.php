<?php

declare(strict_types=1);

namespace Wuro\Clients;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type ClientShape from \Wuro\Clients\Client
 *
 * @phpstan-type ClientUpdateResponseShape = array{
 *   updatedClient?: null|Client|ClientShape
 * }
 */
final class ClientUpdateResponse implements BaseModel
{
    /** @use SdkModel<ClientUpdateResponseShape> */
    use SdkModel;

    #[Optional]
    public ?Client $updatedClient;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Client|ClientShape|null $updatedClient
     */
    public static function with(Client|array|null $updatedClient = null): self
    {
        $self = new self;

        null !== $updatedClient && $self['updatedClient'] = $updatedClient;

        return $self;
    }

    /**
     * @param Client|ClientShape $updatedClient
     */
    public function withUpdatedClient(Client|array $updatedClient): self
    {
        $self = clone $this;
        $self['updatedClient'] = $updatedClient;

        return $self;
    }
}
