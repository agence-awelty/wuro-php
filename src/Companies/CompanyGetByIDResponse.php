<?php

declare(strict_types=1);

namespace Wuro\Companies;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type CompanyShape from \Wuro\Companies\Company
 *
 * @phpstan-type CompanyGetByIDResponseShape = array{
 *   company?: null|Company|CompanyShape
 * }
 */
final class CompanyGetByIDResponse implements BaseModel
{
    /** @use SdkModel<CompanyGetByIDResponseShape> */
    use SdkModel;

    #[Optional]
    public ?Company $company;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Company|CompanyShape|null $company
     */
    public static function with(Company|array|null $company = null): self
    {
        $self = new self;

        null !== $company && $self['company'] = $company;

        return $self;
    }

    /**
     * @param Company|CompanyShape $company
     */
    public function withCompany(Company|array $company): self
    {
        $self = clone $this;
        $self['company'] = $company;

        return $self;
    }
}
