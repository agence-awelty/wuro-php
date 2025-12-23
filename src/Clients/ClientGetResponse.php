<?php

declare(strict_types=1);

namespace Wuro\Clients;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type ClientShape from \Wuro\Clients\Client
 *
 * @phpstan-type ClientGetResponseShape = array{client?: null|Client|ClientShape}
 */
final class ClientGetResponse implements BaseModel
{
    /** @use SdkModel<ClientGetResponseShape> */
    use SdkModel;

    #[Optional]
    public ?Client $client;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Client|ClientShape|null $client
     */
    public static function with(Client|array|null $client = null): self
    {
        $self = new self;

        null !== $client && $self['client'] = $client;

        return $self;
    }

    /**
     * @param Client|ClientShape $client
     */
    public function withClient(Client|array $client): self
    {
        $self = clone $this;
        $self['client'] = $client;

        return $self;
    }
}
