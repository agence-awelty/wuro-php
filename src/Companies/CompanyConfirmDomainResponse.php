<?php

declare(strict_types=1);

namespace Wuro\Companies;

use Wuro\Companies\AppInfos\CompanyApp;
use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type CompanyShape from \Wuro\Companies\Company
 * @phpstan-import-type CompanyAppShape from \Wuro\Companies\AppInfos\CompanyApp
 *
 * @phpstan-type CompanyConfirmDomainResponseShape = array{
 *   company?: null|Company|CompanyShape,
 *   companyApp?: null|CompanyApp|CompanyAppShape,
 * }
 */
final class CompanyConfirmDomainResponse implements BaseModel
{
    /** @use SdkModel<CompanyConfirmDomainResponseShape> */
    use SdkModel;

    #[Optional]
    public ?Company $company;

    #[Optional]
    public ?CompanyApp $companyApp;

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
     * @param CompanyApp|CompanyAppShape|null $companyApp
     */
    public static function with(
        Company|array|null $company = null,
        CompanyApp|array|null $companyApp = null
    ): self {
        $self = new self;

        null !== $company && $self['company'] = $company;
        null !== $companyApp && $self['companyApp'] = $companyApp;

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

    /**
     * @param CompanyApp|CompanyAppShape $companyApp
     */
    public function withCompanyApp(CompanyApp|array $companyApp): self
    {
        $self = clone $this;
        $self['companyApp'] = $companyApp;

        return $self;
    }
}
