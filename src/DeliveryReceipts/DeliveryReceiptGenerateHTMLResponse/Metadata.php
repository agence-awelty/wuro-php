<?php

declare(strict_types=1);

namespace Wuro\DeliveryReceipts\DeliveryReceiptGenerateHTMLResponse;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * Informations clés du bon.
 *
 * @phpstan-type MetadataShape = array{
 *   _id?: string|null,
 *   clientName?: string|null,
 *   date?: \DateTimeInterface|null,
 *   number?: string|null,
 * }
 */
final class Metadata implements BaseModel
{
    /** @use SdkModel<MetadataShape> */
    use SdkModel;

    #[Optional]
    public ?string $_id;

    #[Optional('client_name')]
    public ?string $clientName;

    #[Optional]
    public ?\DateTimeInterface $date;

    #[Optional]
    public ?string $number;

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
        ?string $_id = null,
        ?string $clientName = null,
        ?\DateTimeInterface $date = null,
        ?string $number = null,
    ): self {
        $self = new self;

        null !== $_id && $self['_id'] = $_id;
        null !== $clientName && $self['clientName'] = $clientName;
        null !== $date && $self['date'] = $date;
        null !== $number && $self['number'] = $number;

        return $self;
    }

    public function withID(string $_id): self
    {
        $self = clone $this;
        $self['_id'] = $_id;

        return $self;
    }

    public function withClientName(string $clientName): self
    {
        $self = clone $this;
        $self['clientName'] = $clientName;

        return $self;
    }

    public function withDate(\DateTimeInterface $date): self
    {
        $self = clone $this;
        $self['date'] = $date;

        return $self;
    }

    public function withNumber(string $number): self
    {
        $self = clone $this;
        $self['number'] = $number;

        return $self;
    }
}
