<?php

declare(strict_types=1);

namespace Wuro\Clients\Client;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-type StatsShape = array{
 *   nbDeliveryReceipts?: int|null,
 *   nbFiles?: int|null,
 *   nbInvoices?: int|null,
 *   nbNotes?: int|null,
 *   nbPurchases?: int|null,
 *   nbQuotes?: int|null,
 *   nbReminders?: int|null,
 * }
 */
final class Stats implements BaseModel
{
    /** @use SdkModel<StatsShape> */
    use SdkModel;

    #[Optional]
    public ?int $nbDeliveryReceipts;

    #[Optional]
    public ?int $nbFiles;

    #[Optional]
    public ?int $nbInvoices;

    #[Optional]
    public ?int $nbNotes;

    #[Optional]
    public ?int $nbPurchases;

    #[Optional]
    public ?int $nbQuotes;

    #[Optional]
    public ?int $nbReminders;

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
        ?int $nbDeliveryReceipts = null,
        ?int $nbFiles = null,
        ?int $nbInvoices = null,
        ?int $nbNotes = null,
        ?int $nbPurchases = null,
        ?int $nbQuotes = null,
        ?int $nbReminders = null,
    ): self {
        $self = new self;

        null !== $nbDeliveryReceipts && $self['nbDeliveryReceipts'] = $nbDeliveryReceipts;
        null !== $nbFiles && $self['nbFiles'] = $nbFiles;
        null !== $nbInvoices && $self['nbInvoices'] = $nbInvoices;
        null !== $nbNotes && $self['nbNotes'] = $nbNotes;
        null !== $nbPurchases && $self['nbPurchases'] = $nbPurchases;
        null !== $nbQuotes && $self['nbQuotes'] = $nbQuotes;
        null !== $nbReminders && $self['nbReminders'] = $nbReminders;

        return $self;
    }

    public function withNbDeliveryReceipts(int $nbDeliveryReceipts): self
    {
        $self = clone $this;
        $self['nbDeliveryReceipts'] = $nbDeliveryReceipts;

        return $self;
    }

    public function withNbFiles(int $nbFiles): self
    {
        $self = clone $this;
        $self['nbFiles'] = $nbFiles;

        return $self;
    }

    public function withNbInvoices(int $nbInvoices): self
    {
        $self = clone $this;
        $self['nbInvoices'] = $nbInvoices;

        return $self;
    }

    public function withNbNotes(int $nbNotes): self
    {
        $self = clone $this;
        $self['nbNotes'] = $nbNotes;

        return $self;
    }

    public function withNbPurchases(int $nbPurchases): self
    {
        $self = clone $this;
        $self['nbPurchases'] = $nbPurchases;

        return $self;
    }

    public function withNbQuotes(int $nbQuotes): self
    {
        $self = clone $this;
        $self['nbQuotes'] = $nbQuotes;

        return $self;
    }

    public function withNbReminders(int $nbReminders): self
    {
        $self = clone $this;
        $self['nbReminders'] = $nbReminders;

        return $self;
    }
}
