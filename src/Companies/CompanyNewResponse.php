<?php

declare(strict_types=1);

namespace Wuro\Companies;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type CompanyShape from \Wuro\Companies\Company
 *
 * @phpstan-type CompanyNewResponseShape = array{
 *   application?: mixed, newCompany?: null|Company|CompanyShape
 * }
 */
final class CompanyNewResponse implements BaseModel
{
    /** @use SdkModel<CompanyNewResponseShape> */
    use SdkModel;

    /**
     * Application d'accès créée (si créée via une app).
     */
    #[Optional]
    public mixed $application;

    #[Optional]
    public ?Company $newCompany;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Company|CompanyShape|null $newCompany
     */
    public static function with(
        mixed $application = null,
        Company|array|null $newCompany = null
    ): self {
        $self = new self;

        null !== $application && $self['application'] = $application;
        null !== $newCompany && $self['newCompany'] = $newCompany;

        return $self;
    }

    /**
     * Application d'accès créée (si créée via une app).
     */
    public function withApplication(mixed $application): self
    {
        $self = clone $this;
        $self['application'] = $application;

        return $self;
    }

    /**
     * @param Company|CompanyShape $newCompany
     */
    public function withNewCompany(Company|array $newCompany): self
    {
        $self = clone $this;
        $self['newCompany'] = $newCompany;

        return $self;
    }
}
