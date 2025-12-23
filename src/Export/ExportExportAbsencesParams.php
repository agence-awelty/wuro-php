<?php

declare(strict_types=1);

namespace Wuro\Export;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Concerns\SdkParams;
use Wuro\Core\Contracts\BaseModel;

/**
 * Export absences.
 *
 * @see Wuro\Services\ExportService::exportAbsences()
 *
 * @phpstan-type ExportExportAbsencesParamsShape = array{
 *   company?: string|null, filters?: mixed
 * }
 */
final class ExportExportAbsencesParams implements BaseModel
{
    /** @use SdkModel<ExportExportAbsencesParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Reference to the company.
     */
    #[Optional]
    public ?string $company;

    /**
     * Filters to apply to the export.
     */
    #[Optional]
    public mixed $filters;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(
        ?string $company = null,
        mixed $filters = null
    ): self {
        $self = new self;

        null !== $company && $self['company'] = $company;
        null !== $filters && $self['filters'] = $filters;

        return $self;
    }

    /**
     * Reference to the company.
     */
    public function withCompany(string $company): self
    {
        $self = clone $this;
        $self['company'] = $company;

        return $self;
    }

    /**
     * Filters to apply to the export.
     */
    public function withFilters(mixed $filters): self
    {
        $self = clone $this;
        $self['filters'] = $filters;

        return $self;
    }
}
