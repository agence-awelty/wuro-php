<?php

declare(strict_types=1);

namespace Wuro\DeliveryReceipts;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;
use Wuro\DeliveryReceipts\DeliveryReceiptGenerateHTMLResponse\Metadata;

/**
 * @phpstan-import-type MetadataShape from \Wuro\DeliveryReceipts\DeliveryReceiptGenerateHTMLResponse\Metadata
 *
 * @phpstan-type DeliveryReceiptGenerateHTMLResponseShape = array{
 *   metadata?: null|Metadata|MetadataShape, template?: string|null
 * }
 */
final class DeliveryReceiptGenerateHTMLResponse implements BaseModel
{
    /** @use SdkModel<DeliveryReceiptGenerateHTMLResponseShape> */
    use SdkModel;

    /**
     * Informations clés du bon.
     */
    #[Optional]
    public ?Metadata $metadata;

    /**
     * Rendu HTML complet du bon de livraison.
     */
    #[Optional]
    public ?string $template;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Metadata|MetadataShape|null $metadata
     */
    public static function with(
        Metadata|array|null $metadata = null,
        ?string $template = null
    ): self {
        $self = new self;

        null !== $metadata && $self['metadata'] = $metadata;
        null !== $template && $self['template'] = $template;

        return $self;
    }

    /**
     * Informations clés du bon.
     *
     * @param Metadata|MetadataShape $metadata
     */
    public function withMetadata(Metadata|array $metadata): self
    {
        $self = clone $this;
        $self['metadata'] = $metadata;

        return $self;
    }

    /**
     * Rendu HTML complet du bon de livraison.
     */
    public function withTemplate(string $template): self
    {
        $self = clone $this;
        $self['template'] = $template;

        return $self;
    }
}
