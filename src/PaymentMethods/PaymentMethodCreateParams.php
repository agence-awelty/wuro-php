<?php

declare(strict_types=1);

namespace Wuro\PaymentMethods;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Attributes\Required;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Concerns\SdkParams;
use Wuro\Core\Contracts\BaseModel;
use Wuro\PaymentMethods\PaymentMethodCreateParams\Tag;

/**
 * Crée un nouveau moyen de paiement pour l'entreprise.
 *
 * ## Types de moyens de paiement
 *
 * Le champ `tag` définit le type de moyen de paiement et détermine les champs additionnels requis :
 *
 * - **check** : Chèque (pas de champs supplémentaires)
 * - **transfer** : Virement bancaire (utilisez `modality` pour les coordonnées bancaires)
 * - **stripe** : Stripe (`public` pour la clé publique, `secret` pour la clé secrète)
 * - **paypal** : PayPal (`public` pour l'identifiant marchand)
 * - **paybox** : Paybox (`public`, `secret`, `rang`, `site`)
 * - **epayment** : Paiement électronique générique
 * - **other** : Autre
 *
 * ## Mode test
 *
 * Utilisez `isTest: true` pour créer un moyen de paiement en mode test.
 * Les paiements effectués avec ce moyen ne seront pas réellement débités.
 *
 * ## Moyen par défaut
 *
 * Si `default: true`, ce moyen sera automatiquement sélectionné pour les nouveaux documents.
 *
 * @see Wuro\Services\PaymentMethodsService::create()
 *
 * @phpstan-type PaymentMethodCreateParamsShape = array{
 *   name: string,
 *   default?: bool|null,
 *   isTest?: bool|null,
 *   modality?: string|null,
 *   public?: string|null,
 *   rang?: string|null,
 *   secret?: string|null,
 *   site?: string|null,
 *   tag?: null|Tag|value-of<Tag>,
 * }
 */
final class PaymentMethodCreateParams implements BaseModel
{
    /** @use SdkModel<PaymentMethodCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Nom du moyen de paiement (obligatoire).
     */
    #[Required]
    public string $name;

    /**
     * Définir comme moyen par défaut.
     */
    #[Optional]
    public ?bool $default;

    /**
     * Mode test (pas de paiement réel).
     */
    #[Optional]
    public ?bool $isTest;

    /**
     * Modalités de paiement affichées sur les documents.
     * Ex. coordonnées bancaires, délai de paiement, etc.
     */
    #[Optional]
    public ?string $modality;

    /**
     * Clé publique (Stripe, Paybox) ou identifiant marchand (PayPal).
     */
    #[Optional]
    public ?string $public;

    /**
     * Rang Paybox (spécifique Paybox).
     */
    #[Optional]
    public ?string $rang;

    /**
     * Clé secrète (Stripe, Paybox) - **Ne jamais exposer côté client**.
     */
    #[Optional]
    public ?string $secret;

    /**
     * Numéro de site Paybox (spécifique Paybox).
     */
    #[Optional]
    public ?string $site;

    /**
     * Type de moyen de paiement.
     *
     * @var value-of<Tag>|null $tag
     */
    #[Optional(enum: Tag::class)]
    public ?string $tag;

    /**
     * `new PaymentMethodCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PaymentMethodCreateParams::with(name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PaymentMethodCreateParams)->withName(...)
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
     * @param Tag|value-of<Tag>|null $tag
     */
    public static function with(
        string $name,
        ?bool $default = null,
        ?bool $isTest = null,
        ?string $modality = null,
        ?string $public = null,
        ?string $rang = null,
        ?string $secret = null,
        ?string $site = null,
        Tag|string|null $tag = null,
    ): self {
        $self = new self;

        $self['name'] = $name;

        null !== $default && $self['default'] = $default;
        null !== $isTest && $self['isTest'] = $isTest;
        null !== $modality && $self['modality'] = $modality;
        null !== $public && $self['public'] = $public;
        null !== $rang && $self['rang'] = $rang;
        null !== $secret && $self['secret'] = $secret;
        null !== $site && $self['site'] = $site;
        null !== $tag && $self['tag'] = $tag;

        return $self;
    }

    /**
     * Nom du moyen de paiement (obligatoire).
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Définir comme moyen par défaut.
     */
    public function withDefault(bool $default): self
    {
        $self = clone $this;
        $self['default'] = $default;

        return $self;
    }

    /**
     * Mode test (pas de paiement réel).
     */
    public function withIsTest(bool $isTest): self
    {
        $self = clone $this;
        $self['isTest'] = $isTest;

        return $self;
    }

    /**
     * Modalités de paiement affichées sur les documents.
     * Ex. coordonnées bancaires, délai de paiement, etc.
     */
    public function withModality(string $modality): self
    {
        $self = clone $this;
        $self['modality'] = $modality;

        return $self;
    }

    /**
     * Clé publique (Stripe, Paybox) ou identifiant marchand (PayPal).
     */
    public function withPublic(string $public): self
    {
        $self = clone $this;
        $self['public'] = $public;

        return $self;
    }

    /**
     * Rang Paybox (spécifique Paybox).
     */
    public function withRang(string $rang): self
    {
        $self = clone $this;
        $self['rang'] = $rang;

        return $self;
    }

    /**
     * Clé secrète (Stripe, Paybox) - **Ne jamais exposer côté client**.
     */
    public function withSecret(string $secret): self
    {
        $self = clone $this;
        $self['secret'] = $secret;

        return $self;
    }

    /**
     * Numéro de site Paybox (spécifique Paybox).
     */
    public function withSite(string $site): self
    {
        $self = clone $this;
        $self['site'] = $site;

        return $self;
    }

    /**
     * Type de moyen de paiement.
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
