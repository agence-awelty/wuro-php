<?php

declare(strict_types=1);

namespace Wuro\Companies;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-type CompanyGetCgvResponseShape = array{
 *   cgv?: string|null, cgvLink?: string|null, cgvWuro?: bool|null
 * }
 */
final class CompanyGetCgvResponse implements BaseModel
{
    /** @use SdkModel<CompanyGetCgvResponseShape> */
    use SdkModel;

    /**
     * Texte des conditions générales de vente.
     */
    #[Optional]
    public ?string $cgv;

    /**
     * Lien vers le document des CGV.
     */
    #[Optional('cgv_link')]
    public ?string $cgvLink;

    /**
     * Utiliser les CGV par défaut de Wuro.
     */
    #[Optional('cgv_wuro')]
    public ?bool $cgvWuro;

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
        ?string $cgv = null,
        ?string $cgvLink = null,
        ?bool $cgvWuro = null
    ): self {
        $self = new self;

        null !== $cgv && $self['cgv'] = $cgv;
        null !== $cgvLink && $self['cgvLink'] = $cgvLink;
        null !== $cgvWuro && $self['cgvWuro'] = $cgvWuro;

        return $self;
    }

    /**
     * Texte des conditions générales de vente.
     */
    public function withCgv(string $cgv): self
    {
        $self = clone $this;
        $self['cgv'] = $cgv;

        return $self;
    }

    /**
     * Lien vers le document des CGV.
     */
    public function withCgvLink(string $cgvLink): self
    {
        $self = clone $this;
        $self['cgvLink'] = $cgvLink;

        return $self;
    }

    /**
     * Utiliser les CGV par défaut de Wuro.
     */
    public function withCgvWuro(bool $cgvWuro): self
    {
        $self = clone $this;
        $self['cgvWuro'] = $cgvWuro;

        return $self;
    }
}
