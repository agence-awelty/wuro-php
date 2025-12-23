<?php

declare(strict_types=1);

namespace Wuro\Quotes;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Concerns\SdkParams;
use Wuro\Core\Contracts\BaseModel;

/**
 * Récupère les logs d'actions effectuées sur tous les devis.
 *
 * @see Wuro\Services\QuotesService::getLogs()
 *
 * @phpstan-type QuoteGetLogsParamsShape = array{limit?: int|null, skip?: int|null}
 */
final class QuoteGetLogsParams implements BaseModel
{
    /** @use SdkModel<QuoteGetLogsParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Optional]
    public ?int $limit;

    #[Optional]
    public ?int $skip;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?int $limit = null, ?int $skip = null): self
    {
        $self = new self;

        null !== $limit && $self['limit'] = $limit;
        null !== $skip && $self['skip'] = $skip;

        return $self;
    }

    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    public function withSkip(int $skip): self
    {
        $self = clone $this;
        $self['skip'] = $skip;

        return $self;
    }
}
