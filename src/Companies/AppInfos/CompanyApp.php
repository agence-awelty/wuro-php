<?php

declare(strict_types=1);

namespace Wuro\Companies\AppInfos;

use Wuro\Companies\AppInfos\CompanyApp\DomainVerify;
use Wuro\Companies\AppInfos\CompanyApp\Options;
use Wuro\Companies\AppInfos\CompanyApp\StripeCustomerID;
use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type OptionsShape from \Wuro\Companies\AppInfos\CompanyApp\Options
 * @phpstan-import-type StripeCustomerIDShape from \Wuro\Companies\AppInfos\CompanyApp\StripeCustomerID
 *
 * @phpstan-type CompanyAppShape = array{
 *   _id?: string|null,
 *   company?: string|null,
 *   containerID?: string|null,
 *   containerPrivateID?: string|null,
 *   containerPrivateSize?: float|null,
 *   containerSize?: float|null,
 *   createdAt?: \DateTimeInterface|null,
 *   domainVerify?: null|DomainVerify|value-of<DomainVerify>,
 *   nbCreatedInvoices?: float|null,
 *   nbCreatedQuotes?: float|null,
 *   nbCreatedReceipts?: float|null,
 *   nbMailsSent?: float|null,
 *   options?: null|Options|OptionsShape,
 *   stripeCustomerID?: null|StripeCustomerID|StripeCustomerIDShape,
 *   subscribedSince?: \DateTimeInterface|null,
 *   updatedAt?: \DateTimeInterface|null,
 *   versionPackActive?: string|null,
 *   versions?: list<string>|null,
 * }
 */
final class CompanyApp implements BaseModel
{
    /** @use SdkModel<CompanyAppShape> */
    use SdkModel;

    /**
     * Unique identifier for the company app.
     */
    #[Optional]
    public ?string $_id;

    /**
     * Reference to the company.
     */
    #[Optional]
    public ?string $company;

    /**
     * Container ID for storage.
     */
    #[Optional('containerId')]
    public ?string $containerID;

    /**
     * Private container ID for storage.
     */
    #[Optional('containerPrivateId')]
    public ?string $containerPrivateID;

    /**
     * Size of the private container.
     */
    #[Optional]
    public ?float $containerPrivateSize;

    /**
     * Size of the container.
     */
    #[Optional]
    public ?float $containerSize;

    /**
     * Date when the company app was created.
     */
    #[Optional]
    public ?\DateTimeInterface $createdAt;

    /**
     * Domain verification status.
     *
     * @var value-of<DomainVerify>|null $domainVerify
     */
    #[Optional(enum: DomainVerify::class)]
    public ?string $domainVerify;

    /**
     * Number of invoices created.
     */
    #[Optional]
    public ?float $nbCreatedInvoices;

    /**
     * Number of quotes created.
     */
    #[Optional]
    public ?float $nbCreatedQuotes;

    /**
     * Number of receipts created.
     */
    #[Optional]
    public ?float $nbCreatedReceipts;

    /**
     * Number of emails sent.
     */
    #[Optional]
    public ?float $nbMailsSent;

    /**
     * Company options.
     */
    #[Optional]
    public ?Options $options;

    #[Optional('stripeCustomerId')]
    public ?StripeCustomerID $stripeCustomerID;

    /**
     * Date when the company subscribed.
     */
    #[Optional]
    public ?\DateTimeInterface $subscribedSince;

    /**
     * Date when the company app was last updated.
     */
    #[Optional]
    public ?\DateTimeInterface $updatedAt;

    /**
     * Reference to active version pack.
     */
    #[Optional]
    public ?string $versionPackActive;

    /**
     * List of version references.
     *
     * @var list<string>|null $versions
     */
    #[Optional(list: 'string')]
    public ?array $versions;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param DomainVerify|value-of<DomainVerify>|null $domainVerify
     * @param Options|OptionsShape|null $options
     * @param StripeCustomerID|StripeCustomerIDShape|null $stripeCustomerID
     * @param list<string>|null $versions
     */
    public static function with(
        ?string $_id = null,
        ?string $company = null,
        ?string $containerID = null,
        ?string $containerPrivateID = null,
        ?float $containerPrivateSize = null,
        ?float $containerSize = null,
        ?\DateTimeInterface $createdAt = null,
        DomainVerify|string|null $domainVerify = null,
        ?float $nbCreatedInvoices = null,
        ?float $nbCreatedQuotes = null,
        ?float $nbCreatedReceipts = null,
        ?float $nbMailsSent = null,
        Options|array|null $options = null,
        StripeCustomerID|array|null $stripeCustomerID = null,
        ?\DateTimeInterface $subscribedSince = null,
        ?\DateTimeInterface $updatedAt = null,
        ?string $versionPackActive = null,
        ?array $versions = null,
    ): self {
        $self = new self;

        null !== $_id && $self['_id'] = $_id;
        null !== $company && $self['company'] = $company;
        null !== $containerID && $self['containerID'] = $containerID;
        null !== $containerPrivateID && $self['containerPrivateID'] = $containerPrivateID;
        null !== $containerPrivateSize && $self['containerPrivateSize'] = $containerPrivateSize;
        null !== $containerSize && $self['containerSize'] = $containerSize;
        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $domainVerify && $self['domainVerify'] = $domainVerify;
        null !== $nbCreatedInvoices && $self['nbCreatedInvoices'] = $nbCreatedInvoices;
        null !== $nbCreatedQuotes && $self['nbCreatedQuotes'] = $nbCreatedQuotes;
        null !== $nbCreatedReceipts && $self['nbCreatedReceipts'] = $nbCreatedReceipts;
        null !== $nbMailsSent && $self['nbMailsSent'] = $nbMailsSent;
        null !== $options && $self['options'] = $options;
        null !== $stripeCustomerID && $self['stripeCustomerID'] = $stripeCustomerID;
        null !== $subscribedSince && $self['subscribedSince'] = $subscribedSince;
        null !== $updatedAt && $self['updatedAt'] = $updatedAt;
        null !== $versionPackActive && $self['versionPackActive'] = $versionPackActive;
        null !== $versions && $self['versions'] = $versions;

        return $self;
    }

    /**
     * Unique identifier for the company app.
     */
    public function withID(string $_id): self
    {
        $self = clone $this;
        $self['_id'] = $_id;

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
     * Container ID for storage.
     */
    public function withContainerID(string $containerID): self
    {
        $self = clone $this;
        $self['containerID'] = $containerID;

        return $self;
    }

    /**
     * Private container ID for storage.
     */
    public function withContainerPrivateID(string $containerPrivateID): self
    {
        $self = clone $this;
        $self['containerPrivateID'] = $containerPrivateID;

        return $self;
    }

    /**
     * Size of the private container.
     */
    public function withContainerPrivateSize(float $containerPrivateSize): self
    {
        $self = clone $this;
        $self['containerPrivateSize'] = $containerPrivateSize;

        return $self;
    }

    /**
     * Size of the container.
     */
    public function withContainerSize(float $containerSize): self
    {
        $self = clone $this;
        $self['containerSize'] = $containerSize;

        return $self;
    }

    /**
     * Date when the company app was created.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * Domain verification status.
     *
     * @param DomainVerify|value-of<DomainVerify> $domainVerify
     */
    public function withDomainVerify(DomainVerify|string $domainVerify): self
    {
        $self = clone $this;
        $self['domainVerify'] = $domainVerify;

        return $self;
    }

    /**
     * Number of invoices created.
     */
    public function withNbCreatedInvoices(float $nbCreatedInvoices): self
    {
        $self = clone $this;
        $self['nbCreatedInvoices'] = $nbCreatedInvoices;

        return $self;
    }

    /**
     * Number of quotes created.
     */
    public function withNbCreatedQuotes(float $nbCreatedQuotes): self
    {
        $self = clone $this;
        $self['nbCreatedQuotes'] = $nbCreatedQuotes;

        return $self;
    }

    /**
     * Number of receipts created.
     */
    public function withNbCreatedReceipts(float $nbCreatedReceipts): self
    {
        $self = clone $this;
        $self['nbCreatedReceipts'] = $nbCreatedReceipts;

        return $self;
    }

    /**
     * Number of emails sent.
     */
    public function withNbMailsSent(float $nbMailsSent): self
    {
        $self = clone $this;
        $self['nbMailsSent'] = $nbMailsSent;

        return $self;
    }

    /**
     * Company options.
     *
     * @param Options|OptionsShape $options
     */
    public function withOptions(Options|array $options): self
    {
        $self = clone $this;
        $self['options'] = $options;

        return $self;
    }

    /**
     * @param StripeCustomerID|StripeCustomerIDShape $stripeCustomerID
     */
    public function withStripeCustomerID(
        StripeCustomerID|array $stripeCustomerID
    ): self {
        $self = clone $this;
        $self['stripeCustomerID'] = $stripeCustomerID;

        return $self;
    }

    /**
     * Date when the company subscribed.
     */
    public function withSubscribedSince(
        \DateTimeInterface $subscribedSince
    ): self {
        $self = clone $this;
        $self['subscribedSince'] = $subscribedSince;

        return $self;
    }

    /**
     * Date when the company app was last updated.
     */
    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * Reference to active version pack.
     */
    public function withVersionPackActive(string $versionPackActive): self
    {
        $self = clone $this;
        $self['versionPackActive'] = $versionPackActive;

        return $self;
    }

    /**
     * List of version references.
     *
     * @param list<string> $versions
     */
    public function withVersions(array $versions): self
    {
        $self = clone $this;
        $self['versions'] = $versions;

        return $self;
    }
}
