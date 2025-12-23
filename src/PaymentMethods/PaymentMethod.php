<?php

declare(strict_types=1);

namespace Wuro\PaymentMethods;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Contracts\BaseModel;
use Wuro\PaymentMethods\PaymentMethod\State;
use Wuro\PaymentMethods\PaymentMethod\Tag;

/**
 * @phpstan-type PaymentMethodShape = array{
 *   _id?: string|null,
 *   company?: string|null,
 *   default?: bool|null,
 *   isTest?: bool|null,
 *   modality?: string|null,
 *   name?: string|null,
 *   nbInvoices?: int|null,
 *   nbQuotes?: int|null,
 *   public?: string|null,
 *   rang?: string|null,
 *   secret?: string|null,
 *   site?: string|null,
 *   state?: null|State|value-of<State>,
 *   tag?: null|Tag|value-of<Tag>,
 * }
 */
final class PaymentMethod implements BaseModel
{
    /** @use SdkModel<PaymentMethodShape> */
    use SdkModel;

    /**
     * Unique identifier for the payment method.
     */
    #[Optional]
    public ?string $_id;

    /**
     * Reference to the company.
     */
    #[Optional]
    public ?string $company;

    /**
     * Whether this is the default payment method.
     */
    #[Optional]
    public ?bool $default;

    /**
     * Whether this is a test payment method.
     */
    #[Optional]
    public ?bool $isTest;

    /**
     * Additional information about the payment method.
     */
    #[Optional]
    public ?string $modality;

    /**
     * Name of the payment method.
     */
    #[Optional]
    public ?string $name;

    /**
     * Number of invoices using this payment method.
     */
    #[Optional]
    public ?int $nbInvoices;

    /**
     * Number of quotes using this payment method.
     */
    #[Optional]
    public ?int $nbQuotes;

    /**
     * Public information.
     */
    #[Optional]
    public ?string $public;

    /**
     * Paybox specific field.
     */
    #[Optional]
    public ?string $rang;

    /**
     * Secret information.
     */
    #[Optional]
    public ?string $secret;

    /**
     * Paybox specific field.
     */
    #[Optional]
    public ?string $site;

    /**
     * State of the payment method.
     *
     * @var value-of<State>|null $state
     */
    #[Optional(enum: State::class)]
    public ?string $state;

    /**
     * Type of payment method.
     *
     * @var value-of<Tag>|null $tag
     */
    #[Optional(enum: Tag::class)]
    public ?string $tag;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param State|value-of<State>|null $state
     * @param Tag|value-of<Tag>|null $tag
     */
    public static function with(
        ?string $_id = null,
        ?string $company = null,
        ?bool $default = null,
        ?bool $isTest = null,
        ?string $modality = null,
        ?string $name = null,
        ?int $nbInvoices = null,
        ?int $nbQuotes = null,
        ?string $public = null,
        ?string $rang = null,
        ?string $secret = null,
        ?string $site = null,
        State|string|null $state = null,
        Tag|string|null $tag = null,
    ): self {
        $self = new self;

        null !== $_id && $self['_id'] = $_id;
        null !== $company && $self['company'] = $company;
        null !== $default && $self['default'] = $default;
        null !== $isTest && $self['isTest'] = $isTest;
        null !== $modality && $self['modality'] = $modality;
        null !== $name && $self['name'] = $name;
        null !== $nbInvoices && $self['nbInvoices'] = $nbInvoices;
        null !== $nbQuotes && $self['nbQuotes'] = $nbQuotes;
        null !== $public && $self['public'] = $public;
        null !== $rang && $self['rang'] = $rang;
        null !== $secret && $self['secret'] = $secret;
        null !== $site && $self['site'] = $site;
        null !== $state && $self['state'] = $state;
        null !== $tag && $self['tag'] = $tag;

        return $self;
    }

    /**
     * Unique identifier for the payment method.
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
     * Whether this is the default payment method.
     */
    public function withDefault(bool $default): self
    {
        $self = clone $this;
        $self['default'] = $default;

        return $self;
    }

    /**
     * Whether this is a test payment method.
     */
    public function withIsTest(bool $isTest): self
    {
        $self = clone $this;
        $self['isTest'] = $isTest;

        return $self;
    }

    /**
     * Additional information about the payment method.
     */
    public function withModality(string $modality): self
    {
        $self = clone $this;
        $self['modality'] = $modality;

        return $self;
    }

    /**
     * Name of the payment method.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Number of invoices using this payment method.
     */
    public function withNbInvoices(int $nbInvoices): self
    {
        $self = clone $this;
        $self['nbInvoices'] = $nbInvoices;

        return $self;
    }

    /**
     * Number of quotes using this payment method.
     */
    public function withNbQuotes(int $nbQuotes): self
    {
        $self = clone $this;
        $self['nbQuotes'] = $nbQuotes;

        return $self;
    }

    /**
     * Public information.
     */
    public function withPublic(string $public): self
    {
        $self = clone $this;
        $self['public'] = $public;

        return $self;
    }

    /**
     * Paybox specific field.
     */
    public function withRang(string $rang): self
    {
        $self = clone $this;
        $self['rang'] = $rang;

        return $self;
    }

    /**
     * Secret information.
     */
    public function withSecret(string $secret): self
    {
        $self = clone $this;
        $self['secret'] = $secret;

        return $self;
    }

    /**
     * Paybox specific field.
     */
    public function withSite(string $site): self
    {
        $self = clone $this;
        $self['site'] = $site;

        return $self;
    }

    /**
     * State of the payment method.
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
     * Type of payment method.
     *
     * @param Tag|value-of<Tag> $tag
     */
    public function withTag(Tag|string $tag): self
    {
        $self = clone $this;
        $self['tag'] = $tag;

        return $self;
    }
}
