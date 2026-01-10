<?php

declare(strict_types=1);

namespace Wuro\Companies;

use Wuro\Companies\CompanyCreateParams\Address;
use Wuro\Core\Attributes\Optional;
use Wuro\Core\Attributes\Required;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Concerns\SdkParams;
use Wuro\Core\Contracts\BaseModel;

/**
 * Crée une nouvelle entreprise.
 *
 * **Comportement:**
 * - L'URL est rendue unique automatiquement si elle existe déjà
 * - Un CompanyApp est créé automatiquement avec des options par défaut
 * - Si créée via une application, une Application d'accès est automatiquement générée
 *
 * **Restrictions:**
 * - Ne peut pas être créée depuis une version API
 *
 * **Événement déclenché:** CREATE_COMPANY
 *
 * @see Wuro\Services\CompaniesService::create()
 *
 * @phpstan-import-type AddressShape from \Wuro\Companies\CompanyCreateParams\Address
 *
 * @phpstan-type CompanyCreateParamsShape = array{
 *   name: string,
 *   url: string,
 *   addresses?: list<Address|AddressShape>|null,
 *   commercialCourt?: string|null,
 *   companyType?: string|null,
 *   email?: string|null,
 *   nafApe?: string|null,
 *   nic?: string|null,
 *   numRcs?: string|null,
 *   numTradeDirectory?: string|null,
 *   shareCapital?: float|null,
 *   siren?: string|null,
 *   siret?: string|null,
 *   tvaNumber?: string|null,
 *   website?: string|null,
 * }
 */
final class CompanyCreateParams implements BaseModel
{
    /** @use SdkModel<CompanyCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Nom de l'entreprise (obligatoire).
     */
    #[Required]
    public string $name;

    /**
     * URL unique pour l'entreprise (obligatoire).
     */
    #[Required]
    public string $url;

    /** @var list<Address>|null $addresses */
    #[Optional(list: Address::class)]
    public ?array $addresses;

    /**
     * Tribunal de commerce.
     */
    #[Optional('commercial_court')]
    public ?string $commercialCourt;

    /**
     * ID du type d'entreprise (SARL, SAS, etc.).
     */
    #[Optional('company_type')]
    public ?string $companyType;

    /**
     * Email principal de l'entreprise.
     */
    #[Optional]
    public ?string $email;

    /**
     * Code NAF/APE.
     */
    #[Optional('naf_ape')]
    public ?string $nafApe;

    /**
     * Code NIC.
     */
    #[Optional]
    public ?string $nic;

    /**
     * Numéro d'inscription au RCS.
     */
    #[Optional('num_rcs')]
    public ?string $numRcs;

    /**
     * Numéro au répertoire des métiers.
     */
    #[Optional('num_trade_directory')]
    public ?string $numTradeDirectory;

    /**
     * Capital social.
     */
    #[Optional('share_capital')]
    public ?float $shareCapital;

    /**
     * Numéro SIREN (9 chiffres).
     */
    #[Optional]
    public ?string $siren;

    /**
     * Numéro SIRET (14 chiffres).
     */
    #[Optional]
    public ?string $siret;

    /**
     * Numéro de TVA intracommunautaire.
     */
    #[Optional('tva_number')]
    public ?string $tvaNumber;

    /**
     * Site web de l'entreprise.
     */
    #[Optional]
    public ?string $website;

    /**
     * `new CompanyCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CompanyCreateParams::with(name: ..., url: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CompanyCreateParams)->withName(...)->withURL(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<Address|AddressShape>|null $addresses
     */
    public static function with(
        string $name,
        string $url,
        ?array $addresses = null,
        ?string $commercialCourt = null,
        ?string $companyType = null,
        ?string $email = null,
        ?string $nafApe = null,
        ?string $nic = null,
        ?string $numRcs = null,
        ?string $numTradeDirectory = null,
        ?float $shareCapital = null,
        ?string $siren = null,
        ?string $siret = null,
        ?string $tvaNumber = null,
        ?string $website = null,
    ): self {
        $self = new self;

        $self['name'] = $name;
        $self['url'] = $url;

        null !== $addresses && $self['addresses'] = $addresses;
        null !== $commercialCourt && $self['commercialCourt'] = $commercialCourt;
        null !== $companyType && $self['companyType'] = $companyType;
        null !== $email && $self['email'] = $email;
        null !== $nafApe && $self['nafApe'] = $nafApe;
        null !== $nic && $self['nic'] = $nic;
        null !== $numRcs && $self['numRcs'] = $numRcs;
        null !== $numTradeDirectory && $self['numTradeDirectory'] = $numTradeDirectory;
        null !== $shareCapital && $self['shareCapital'] = $shareCapital;
        null !== $siren && $self['siren'] = $siren;
        null !== $siret && $self['siret'] = $siret;
        null !== $tvaNumber && $self['tvaNumber'] = $tvaNumber;
        null !== $website && $self['website'] = $website;

        return $self;
    }

    /**
     * Nom de l'entreprise (obligatoire).
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * URL unique pour l'entreprise (obligatoire).
     */
    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }

    /**
     * @param list<Address|AddressShape> $addresses
     */
    public function withAddresses(array $addresses): self
    {
        $self = clone $this;
        $self['addresses'] = $addresses;

        return $self;
    }

    /**
     * Tribunal de commerce.
     */
    public function withCommercialCourt(string $commercialCourt): self
    {
        $self = clone $this;
        $self['commercialCourt'] = $commercialCourt;

        return $self;
    }

    /**
     * ID du type d'entreprise (SARL, SAS, etc.).
     */
    public function withCompanyType(string $companyType): self
    {
        $self = clone $this;
        $self['companyType'] = $companyType;

        return $self;
    }

    /**
     * Email principal de l'entreprise.
     */
    public function withEmail(string $email): self
    {
        $self = clone $this;
        $self['email'] = $email;

        return $self;
    }

    /**
     * Code NAF/APE.
     */
    public function withNafApe(string $nafApe): self
    {
        $self = clone $this;
        $self['nafApe'] = $nafApe;

        return $self;
    }

    /**
     * Code NIC.
     */
    public function withNic(string $nic): self
    {
        $self = clone $this;
        $self['nic'] = $nic;

        return $self;
    }

    /**
     * Numéro d'inscription au RCS.
     */
    public function withNumRcs(string $numRcs): self
    {
        $self = clone $this;
        $self['numRcs'] = $numRcs;

        return $self;
    }

    /**
     * Numéro au répertoire des métiers.
     */
    public function withNumTradeDirectory(string $numTradeDirectory): self
    {
        $self = clone $this;
        $self['numTradeDirectory'] = $numTradeDirectory;

        return $self;
    }

    /**
     * Capital social.
     */
    public function withShareCapital(float $shareCapital): self
    {
        $self = clone $this;
        $self['shareCapital'] = $shareCapital;

        return $self;
    }

    /**
     * Numéro SIREN (9 chiffres).
     */
    public function withSiren(string $siren): self
    {
        $self = clone $this;
        $self['siren'] = $siren;

        return $self;
    }

    /**
     * Numéro SIRET (14 chiffres).
     */
    public function withSiret(string $siret): self
    {
        $self = clone $this;
        $self['siret'] = $siret;

        return $self;
    }

    /**
     * Numéro de TVA intracommunautaire.
     */
    public function withTvaNumber(string $tvaNumber): self
    {
        $self = clone $this;
        $self['tvaNumber'] = $tvaNumber;

        return $self;
    }

    /**
     * Site web de l'entreprise.
     */
    public function withWebsite(string $website): self
    {
        $self = clone $this;
        $self['website'] = $website;

        return $self;
    }
}
