<?php

declare(strict_types=1);

namespace Wuro\Clients;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type ClientShape from \Wuro\Clients\Client
 *
 * @phpstan-type ClientNewResponseShape = array{
 *   newClient?: null|Client|ClientShape
 * }
 */
final class ClientNewResponse implements BaseModel
{
    /** @use SdkModel<ClientNewResponseShape> */
    use SdkModel;

    #[Optional]
    public ?Client $newClient;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Client|ClientShape|null $newClient
     */
    public static function with(Client|array|null $newClient = null): self
    {
        $self = new self;

        null !== $newClient && $self['newClient'] = $newClient;

        return $self;
    }

    /**
     * @param Client|ClientShape $newClient
     */
    public function withNewClient(Client|array $newClient): self
    {
        $self = clone $this;
        $self['newClient'] = $newClient;

        return $self;
    }
}
