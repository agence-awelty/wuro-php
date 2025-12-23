<?php

declare(strict_types=1);

namespace Wuro\Companies;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type CompanyShape from \Wuro\Companies\Company
 *
 * @phpstan-type CompanyUpdateResponseShape = array{
 *   updatedCompany?: null|Company|CompanyShape
 * }
 */
final class CompanyUpdateResponse implements BaseModel
{
    /** @use SdkModel<CompanyUpdateResponseShape> */
    use SdkModel;

    #[Optional]
    public ?Company $updatedCompany;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Company|CompanyShape|null $updatedCompany
     */
    public static function with(Company|array|null $updatedCompany = null): self
    {
        $self = new self;

        null !== $updatedCompany && $self['updatedCompany'] = $updatedCompany;

        return $self;
    }

    /**
     * @param Company|CompanyShape $updatedCompany
     */
    public function withUpdatedCompany(Company|array $updatedCompany): self
    {
        $self = clone $this;
        $self['updatedCompany'] = $updatedCompany;

        return $self;
    }
}
