<?php

declare(strict_types=1);

namespace Wuro\Clients;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type ClientShape from \Wuro\Clients\Client
 *
 * @phpstan-type ClientMergeResponseShape = array{
 *   client?: null|Client|ClientShape, documentsTransferred?: int|null
 * }
 */
final class ClientMergeResponse implements BaseModel
{
    /** @use SdkModel<ClientMergeResponseShape> */
    use SdkModel;

    #[Optional]
    public ?Client $client;

    /**
     * Nombre de documents transférés.
     */
    #[Optional]
    public ?int $documentsTransferred;

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
    public static function with(
        Client|array|null $client = null,
        ?int $documentsTransferred = null
    ): self {
        $self = new self;

        null !== $client && $self['client'] = $client;
        null !== $documentsTransferred && $self['documentsTransferred'] = $documentsTransferred;

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

    /**
     * Nombre de documents transférés.
     */
    public function withDocumentsTransferred(int $documentsTransferred): self
    {
        $self = clone $this;
        $self['documentsTransferred'] = $documentsTransferred;

        return $self;
    }
}
