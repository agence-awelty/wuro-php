<?php

declare(strict_types=1);

namespace Wuro\Products\Product;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-type FileShape = array{
 *   id?: string|null,
 *   filename?: string|null,
 *   mime?: string|null,
 *   size?: float|null,
 *   url?: string|null,
 * }
 */
final class File implements BaseModel
{
    /** @use SdkModel<FileShape> */
    use SdkModel;

    #[Optional]
    public ?string $id;

    #[Optional]
    public ?string $filename;

    #[Optional]
    public ?string $mime;

    #[Optional]
    public ?float $size;

    #[Optional]
    public ?string $url;

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
        ?string $id = null,
        ?string $filename = null,
        ?string $mime = null,
        ?float $size = null,
        ?string $url = null,
    ): self {
        $self = new self;

        null !== $id && $self['id'] = $id;
        null !== $filename && $self['filename'] = $filename;
        null !== $mime && $self['mime'] = $mime;
        null !== $size && $self['size'] = $size;
        null !== $url && $self['url'] = $url;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withFilename(string $filename): self
    {
        $self = clone $this;
        $self['filename'] = $filename;

        return $self;
    }

    public function withMime(string $mime): self
    {
        $self = clone $this;
        $self['mime'] = $mime;

        return $self;
    }

    public function withSize(float $size): self
    {
        $self = clone $this;
        $self['size'] = $size;

        return $self;
    }

    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }
}
