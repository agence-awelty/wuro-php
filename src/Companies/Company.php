<?php

declare(strict_types=1);

namespace Wuro\Companies;

use Wuro\Companies\Company\Address;
use Wuro\Companies\Company\Mobile;
use Wuro\Companies\Company\Phone;
use Wuro\Companies\Company\State;
use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type AddressShape from \Wuro\Companies\Company\Address
 * @phpstan-import-type MobileShape from \Wuro\Companies\Company\Mobile
 * @phpstan-import-type PhoneShape from \Wuro\Companies\Company\Phone
 *
 * @phpstan-type CompanyShape = array{
 *   _id?: string|null,
 *   addresses?: list<AddressShape>|null,
 *   cgv?: string|null,
 *   cgvLink?: string|null,
 *   cgvWuro?: bool|null,
 *   commercialCourt?: string|null,
 *   companyIncludeCgv?: bool|null,
 *   companyIncludeCgvPhysical?: bool|null,
 *   companyType?: string|null,
 *   companyTypeName?: string|null,
 *   createdAt?: \DateTimeInterface|null,
 *   domain?: string|null,
 *   email?: string|null,
 *   emailExpeditor?: string|null,
 *   logo?: string|null,
 *   mobiles?: list<MobileShape>|null,
 *   nafApe?: string|null,
 *   name?: string|null,
 *   nic?: string|null,
 *   numRcs?: string|null,
 *   numTradeDirectory?: string|null,
 *   paymentDelayDefault?: float|null,
 *   phones?: list<PhoneShape>|null,
 *   rateLatePenalties?: float|null,
 *   shareCapital?: float|null,
 *   siren?: string|null,
 *   siret?: string|null,
 *   state?: null|State|value-of<State>,
 *   tvaNumber?: string|null,
 *   updatedAt?: \DateTimeInterface|null,
 *   url?: string|null,
 *   validityDelayDefault?: float|null,
 *   website?: string|null,
 * }
 */
final class Company implements BaseModel
{
    /** @use SdkModel<CompanyShape> */
    use SdkModel;

    /**
     * Unique identifier for the company.
     */
    #[Optional]
    public ?string $_id;

    /**
     * List of company addresses.
     *
     * @var list<Address>|null $addresses
     */
    #[Optional(list: Address::class)]
    public ?array $addresses;

    /**
     * Terms and conditions text.
     */
    #[Optional]
    public ?string $cgv;

    /**
     * Link to terms and conditions.
     */
    #[Optional('cgv_link')]
    public ?string $cgvLink;

    /**
     * Whether to use Wuro's terms and conditions.
     */
    #[Optional('cgv_wuro')]
    public ?bool $cgvWuro;

    /**
     * Commercial court.
     */
    #[Optional('commercial_court')]
    public ?string $commercialCourt;

    /**
     * Whether to include terms and conditions in documents.
     */
    #[Optional('company_include_cgv')]
    public ?bool $companyIncludeCgv;

    /**
     * Whether to include physical terms and conditions in documents.
     */
    #[Optional('company_include_cgv_physical')]
    public ?bool $companyIncludeCgvPhysical;

    /**
     * Reference to company type.
     */
    #[Optional('company_type')]
    public ?string $companyType;

    /**
     * Name of the company type.
     */
    #[Optional('company_type_name')]
    public ?string $companyTypeName;

    /**
     * Date when the company was created.
     */
    #[Optional]
    public ?\DateTimeInterface $createdAt;

    /**
     * Company domain.
     */
    #[Optional]
    public ?string $domain;

    /**
     * Company email.
     */
    #[Optional]
    public ?string $email;

    /**
     * Email used as sender for communications.
     */
    #[Optional]
    public ?string $emailExpeditor;

    /**
     * URL to company logo.
     */
    #[Optional]
    public ?string $logo;

    /**
     * List of company mobile numbers.
     *
     * @var list<Mobile>|null $mobiles
     */
    #[Optional(list: Mobile::class)]
    public ?array $mobiles;

    /**
     * NAF/APE code.
     */
    #[Optional('naf_ape')]
    public ?string $nafApe;

    /**
     * Name of the company.
     */
    #[Optional]
    public ?string $name;

    /**
     * NIC code.
     */
    #[Optional]
    public ?string $nic;

    /**
     * RCS registration number.
     */
    #[Optional('num_rcs')]
    public ?string $numRcs;

    /**
     * Trade directory number.
     */
    #[Optional('num_trade_directory')]
    public ?string $numTradeDirectory;

    /**
     * Default payment delay in days.
     */
    #[Optional('payment_delay_default')]
    public ?float $paymentDelayDefault;

    /**
     * List of company phone numbers.
     *
     * @var list<Phone>|null $phones
     */
    #[Optional(list: Phone::class)]
    public ?array $phones;

    /**
     * Late payment penalty rate.
     */
    #[Optional('rate_late_penalties')]
    public ?float $rateLatePenalties;

    /**
     * Share capital amount.
     */
    #[Optional('share_capital')]
    public ?float $shareCapital;

    /**
     * SIREN number.
     */
    #[Optional]
    public ?string $siren;

    /**
     * SIRET number.
     */
    #[Optional]
    public ?string $siret;

    /**
     * State of the company.
     *
     * @var value-of<State>|null $state
     */
    #[Optional(enum: State::class)]
    public ?string $state;

    /**
     * VAT number.
     */
    #[Optional('tva_number')]
    public ?string $tvaNumber;

    /**
     * Date when the company was last updated.
     */
    #[Optional]
    public ?\DateTimeInterface $updatedAt;

    /**
     * Unique URL identifier for the company.
     */
    #[Optional]
    public ?string $url;

    /**
     * Default validity delay for quotes in days.
     */
    #[Optional('validity_delay_default')]
    public ?float $validityDelayDefault;

    /**
     * Company website URL.
     */
    #[Optional]
    public ?string $website;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<AddressShape>|null $addresses
     * @param list<MobileShape>|null $mobiles
     * @param list<PhoneShape>|null $phones
     * @param State|value-of<State>|null $state
     */
    public static function with(
        ?string $_id = null,
        ?array $addresses = null,
        ?string $cgv = null,
        ?string $cgvLink = null,
        ?bool $cgvWuro = null,
        ?string $commercialCourt = null,
        ?bool $companyIncludeCgv = null,
        ?bool $companyIncludeCgvPhysical = null,
        ?string $companyType = null,
        ?string $companyTypeName = null,
        ?\DateTimeInterface $createdAt = null,
        ?string $domain = null,
        ?string $email = null,
        ?string $emailExpeditor = null,
        ?string $logo = null,
        ?array $mobiles = null,
        ?string $nafApe = null,
        ?string $name = null,
        ?string $nic = null,
        ?string $numRcs = null,
        ?string $numTradeDirectory = null,
        ?float $paymentDelayDefault = null,
        ?array $phones = null,
        ?float $rateLatePenalties = null,
        ?float $shareCapital = null,
        ?string $siren = null,
        ?string $siret = null,
        State|string|null $state = null,
        ?string $tvaNumber = null,
        ?\DateTimeInterface $updatedAt = null,
        ?string $url = null,
        ?float $validityDelayDefault = null,
        ?string $website = null,
    ): self {
        $self = new self;

        null !== $_id && $self['_id'] = $_id;
        null !== $addresses && $self['addresses'] = $addresses;
        null !== $cgv && $self['cgv'] = $cgv;
        null !== $cgvLink && $self['cgvLink'] = $cgvLink;
        null !== $cgvWuro && $self['cgvWuro'] = $cgvWuro;
        null !== $commercialCourt && $self['commercialCourt'] = $commercialCourt;
        null !== $companyIncludeCgv && $self['companyIncludeCgv'] = $companyIncludeCgv;
        null !== $companyIncludeCgvPhysical && $self['companyIncludeCgvPhysical'] = $companyIncludeCgvPhysical;
        null !== $companyType && $self['companyType'] = $companyType;
        null !== $companyTypeName && $self['companyTypeName'] = $companyTypeName;
        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $domain && $self['domain'] = $domain;
        null !== $email && $self['email'] = $email;
        null !== $emailExpeditor && $self['emailExpeditor'] = $emailExpeditor;
        null !== $logo && $self['logo'] = $logo;
        null !== $mobiles && $self['mobiles'] = $mobiles;
        null !== $nafApe && $self['nafApe'] = $nafApe;
        null !== $name && $self['name'] = $name;
        null !== $nic && $self['nic'] = $nic;
        null !== $numRcs && $self['numRcs'] = $numRcs;
        null !== $numTradeDirectory && $self['numTradeDirectory'] = $numTradeDirectory;
        null !== $paymentDelayDefault && $self['paymentDelayDefault'] = $paymentDelayDefault;
        null !== $phones && $self['phones'] = $phones;
        null !== $rateLatePenalties && $self['rateLatePenalties'] = $rateLatePenalties;
        null !== $shareCapital && $self['shareCapital'] = $shareCapital;
        null !== $siren && $self['siren'] = $siren;
        null !== $siret && $self['siret'] = $siret;
        null !== $state && $self['state'] = $state;
        null !== $tvaNumber && $self['tvaNumber'] = $tvaNumber;
        null !== $updatedAt && $self['updatedAt'] = $updatedAt;
        null !== $url && $self['url'] = $url;
        null !== $validityDelayDefault && $self['validityDelayDefault'] = $validityDelayDefault;
        null !== $website && $self['website'] = $website;

        return $self;
    }

    /**
     * Unique identifier for the company.
     */
    public function withID(string $_id): self
    {
        $self = clone $this;
        $self['_id'] = $_id;

        return $self;
    }

    /**
     * List of company addresses.
     *
     * @param list<AddressShape> $addresses
     */
    public function withAddresses(array $addresses): self
    {
        $self = clone $this;
        $self['addresses'] = $addresses;

        return $self;
    }

    /**
     * Terms and conditions text.
     */
    public function withCgv(string $cgv): self
    {
        $self = clone $this;
        $self['cgv'] = $cgv;

        return $self;
    }

    /**
     * Link to terms and conditions.
     */
    public function withCgvLink(string $cgvLink): self
    {
        $self = clone $this;
        $self['cgvLink'] = $cgvLink;

        return $self;
    }

    /**
     * Whether to use Wuro's terms and conditions.
     */
    public function withCgvWuro(bool $cgvWuro): self
    {
        $self = clone $this;
        $self['cgvWuro'] = $cgvWuro;

        return $self;
    }

    /**
     * Commercial court.
     */
    public function withCommercialCourt(string $commercialCourt): self
    {
        $self = clone $this;
        $self['commercialCourt'] = $commercialCourt;

        return $self;
    }

    /**
     * Whether to include terms and conditions in documents.
     */
    public function withCompanyIncludeCgv(bool $companyIncludeCgv): self
    {
        $self = clone $this;
        $self['companyIncludeCgv'] = $companyIncludeCgv;

        return $self;
    }

    /**
     * Whether to include physical terms and conditions in documents.
     */
    public function withCompanyIncludeCgvPhysical(
        bool $companyIncludeCgvPhysical
    ): self {
        $self = clone $this;
        $self['companyIncludeCgvPhysical'] = $companyIncludeCgvPhysical;

        return $self;
    }

    /**
     * Reference to company type.
     */
    public function withCompanyType(string $companyType): self
    {
        $self = clone $this;
        $self['companyType'] = $companyType;

        return $self;
    }

    /**
     * Name of the company type.
     */
    public function withCompanyTypeName(string $companyTypeName): self
    {
        $self = clone $this;
        $self['companyTypeName'] = $companyTypeName;

        return $self;
    }

    /**
     * Date when the company was created.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * Company domain.
     */
    public function withDomain(string $domain): self
    {
        $self = clone $this;
        $self['domain'] = $domain;

        return $self;
    }

    /**
     * Company email.
     */
    public function withEmail(string $email): self
    {
        $self = clone $this;
        $self['email'] = $email;

        return $self;
    }

    /**
     * Email used as sender for communications.
     */
    public function withEmailExpeditor(string $emailExpeditor): self
    {
        $self = clone $this;
        $self['emailExpeditor'] = $emailExpeditor;

        return $self;
    }

    /**
     * URL to company logo.
     */
    public function withLogo(string $logo): self
    {
        $self = clone $this;
        $self['logo'] = $logo;

        return $self;
    }

    /**
     * List of company mobile numbers.
     *
     * @param list<MobileShape> $mobiles
     */
    public function withMobiles(array $mobiles): self
    {
        $self = clone $this;
        $self['mobiles'] = $mobiles;

        return $self;
    }

    /**
     * NAF/APE code.
     */
    public function withNafApe(string $nafApe): self
    {
        $self = clone $this;
        $self['nafApe'] = $nafApe;

        return $self;
    }

    /**
     * Name of the company.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * NIC code.
     */
    public function withNic(string $nic): self
    {
        $self = clone $this;
        $self['nic'] = $nic;

        return $self;
    }

    /**
     * RCS registration number.
     */
    public function withNumRcs(string $numRcs): self
    {
        $self = clone $this;
        $self['numRcs'] = $numRcs;

        return $self;
    }

    /**
     * Trade directory number.
     */
    public function withNumTradeDirectory(string $numTradeDirectory): self
    {
        $self = clone $this;
        $self['numTradeDirectory'] = $numTradeDirectory;

        return $self;
    }

    /**
     * Default payment delay in days.
     */
    public function withPaymentDelayDefault(float $paymentDelayDefault): self
    {
        $self = clone $this;
        $self['paymentDelayDefault'] = $paymentDelayDefault;

        return $self;
    }

    /**
     * List of company phone numbers.
     *
     * @param list<PhoneShape> $phones
     */
    public function withPhones(array $phones): self
    {
        $self = clone $this;
        $self['phones'] = $phones;

        return $self;
    }

    /**
     * Late payment penalty rate.
     */
    public function withRateLatePenalties(float $rateLatePenalties): self
    {
        $self = clone $this;
        $self['rateLatePenalties'] = $rateLatePenalties;

        return $self;
    }

    /**
     * Share capital amount.
     */
    public function withShareCapital(float $shareCapital): self
    {
        $self = clone $this;
        $self['shareCapital'] = $shareCapital;

        return $self;
    }

    /**
     * SIREN number.
     */
    public function withSiren(string $siren): self
    {
        $self = clone $this;
        $self['siren'] = $siren;

        return $self;
    }

    /**
     * SIRET number.
     */
    public function withSiret(string $siret): self
    {
        $self = clone $this;
        $self['siret'] = $siret;

        return $self;
    }

    /**
     * State of the company.
     *
     * @param State|value-of<State> $state
     */
    public function withState(State|string $state): self
    {
        $self = clone $this;
        $self['state'] = $state;

        return $self;
    }

    /**
     * VAT number.
     */
    public function withTvaNumber(string $tvaNumber): self
    {
        $self = clone $this;
        $self['tvaNumber'] = $tvaNumber;

        return $self;
    }

    /**
     * Date when the company was last updated.
     */
    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * Unique URL identifier for the company.
     */
    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }

    /**
     * Default validity delay for quotes in days.
     */
    public function withValidityDelayDefault(float $validityDelayDefault): self
    {
        $self = clone $this;
        $self['validityDelayDefault'] = $validityDelayDefault;

        return $self;
    }

    /**
     * Company website URL.
     */
    public function withWebsite(string $website): self
    {
        $self = clone $this;
        $self['website'] = $website;

        return $self;
    }
}
