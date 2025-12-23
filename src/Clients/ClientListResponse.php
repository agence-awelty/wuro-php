<?php

declare(strict_types=1);

namespace Wuro\Clients;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type ClientShape from \Wuro\Clients\Client
 *
 * @phpstan-type ClientListResponseShape = array{
 *   clients?: list<ClientShape>|null,
 *   limit?: int|null,
 *   skip?: int|null,
 *   total?: int|null,
 * }
 */
final class ClientListResponse implements BaseModel
{
    /** @use SdkModel<ClientListResponseShape> */
    use SdkModel;

    /**
     * Tableau des clients.
     *
     * @var list<Client>|null $clients
     */
    #[Optional(list: Client::class)]
    public ?array $clients;

    /**
     * Limite utilisée.
     */
    #[Optional]
    public ?int $limit;

    /**
     * Offset utilisé.
     */
    #[Optional]
    public ?int $skip;

    /**
     * Nombre total de clients.
     */
    #[Optional]
    public ?int $total;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<ClientShape>|null $clients
     */
    public static function with(
        ?array $clients = null,
        ?int $limit = null,
        ?int $skip = null,
        ?int $total = null,
    ): self {
        $self = new self;

        null !== $clients && $self['clients'] = $clients;
        null !== $limit && $self['limit'] = $limit;
        null !== $skip && $self['skip'] = $skip;
        null !== $total && $self['total'] = $total;

        return $self;
    }

    /**
     * Tableau des clients.
     *
     * @param list<ClientShape> $clients
     */
    public function withClients(array $clients): self
    {
        $self = clone $this;
        $self['clients'] = $clients;

        return $self;
    }

    /**
     * Limite utilisée.
     */
    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * Offset utilisé.
     */
    public function withSkip(int $skip): self
    {
        $self = clone $this;
        $self['skip'] = $skip;

        return $self;
    }

    /**
     * Nombre total de clients.
     */
    public function withTotal(int $total): self
    {
        $self = clone $this;
        $self['total'] = $total;

        return $self;
    }
}
