<?php

declare(strict_types=1);

namespace Wuro\Companies\AppInfos\CompanyApp;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * Company options.
 *
 * @phpstan-type OptionsShape = array{api?: bool|null, fec?: bool|null}
 */
final class Options implements BaseModel
{
    /** @use SdkModel<OptionsShape> */
    use SdkModel;

    /**
     * Whether API access is enabled.
     */
    #[Optional]
    public ?bool $api;

    /**
     * Whether FEC export is enabled.
     */
    #[Optional]
    public ?bool $fec;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?bool $api = null, ?bool $fec = null): self
    {
        $self = new self;

        null !== $api && $self['api'] = $api;
        null !== $fec && $self['fec'] = $fec;

        return $self;
    }

    /**
     * Whether API access is enabled.
     */
    public function withAPI(bool $api): self
    {
        $self = clone $this;
        $self['api'] = $api;

        return $self;
    }

    /**
     * Whether FEC export is enabled.
     */
    public function withFec(bool $fec): self
    {
        $self = clone $this;
        $self['fec'] = $fec;

        return $self;
    }
}
