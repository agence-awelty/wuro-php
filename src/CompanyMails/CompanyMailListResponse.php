<?php

declare(strict_types=1);

namespace Wuro\CompanyMails;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-type CompanyMailListResponseShape = array{emails?: list<string>|null}
 */
final class CompanyMailListResponse implements BaseModel
{
    /** @use SdkModel<CompanyMailListResponseShape> */
    use SdkModel;

    /** @var list<string>|null $emails */
    #[Optional(list: 'string')]
    public ?array $emails;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<string>|null $emails
     */
    public static function with(?array $emails = null): self
    {
        $self = new self;

        null !== $emails && $self['emails'] = $emails;

        return $self;
    }

    /**
     * @param list<string> $emails
     */
    public function withEmails(array $emails): self
    {
        $self = clone $this;
        $self['emails'] = $emails;

        return $self;
    }
}
