<?php

declare(strict_types=1);

namespace Wuro\PaymentMethods;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Concerns\SdkParams;
use Wuro\Core\Contracts\BaseModel;
use Wuro\PaymentMethods\PaymentMethodUpdateParams\State;
use Wuro\PaymentMethods\PaymentMethodUpdateParams\Tag;

/**
 * Met à jour un moyen de paiement existant.
 *
 * ## Définir comme défaut
 *
 * Si vous définissez `default: true`, ce moyen deviendra le moyen par défaut
 * pour les nouveaux documents. L'ancien moyen par défaut sera automatiquement
 * désélectionné.
 *
 * ## Désactivation
 *
 * Utilisez `state: "inactive"` pour masquer un moyen de paiement sans le supprimer.
 * Les documents existants utilisant ce moyen ne seront pas affectés.
 *
 * @see Wuro\Services\PaymentMethodsService::update()
 *
 * @phpstan-type PaymentMethodUpdateParamsShape = array{
 *   default?: bool|null,
 *   modality?: string|null,
 *   name?: string|null,
 *   state?: null|State|value-of<State>,
 *   tag?: null|Tag|value-of<Tag>,
 * }
 */
final class PaymentMethodUpdateParams implements BaseModel
{
    /** @use SdkModel<PaymentMethodUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Définir comme moyen de paiement par défaut.
     */
    #[Optional]
    public ?bool $default;

    /**
     * Modalités de paiement affichées sur les documents.
     * Ex. "Paiement à 30 jours", "RIB : FR76...", "Payable à réception".
     */
    #[Optional]
    public ?string $modality;

    /**
     * Nom du moyen de paiement (ex. "Virement bancaire", "Carte Bancaire").
     */
    #[Optional]
    public ?string $name;

    /**
     * État du moyen de paiement.
     *
     * @var value-of<State>|null $state
     */
    #[Optional(enum: State::class)]
    public ?string $state;

    /**
     * Type de moyen de paiement :
     * - **check** : Chèque
     * - **transfer** : Virement bancaire
     * - **stripe** : Stripe
     * - **paypal** : PayPal
     * - **paybox** : Paybox
     * - **epayment** : Paiement électronique
     * - **other** : Autre
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
        ?bool $default = null,
        ?string $modality = null,
        ?string $name = null,
        State|string|null $state = null,
        Tag|string|null $tag = null,
    ): self {
        $self = new self;

        null !== $default && $self['default'] = $default;
        null !== $modality && $self['modality'] = $modality;
        null !== $name && $self['name'] = $name;
        null !== $state && $self['state'] = $state;
        null !== $tag && $self['tag'] = $tag;

        return $self;
    }

    /**
     * Définir comme moyen de paiement par défaut.
     */
    public function withDefault(bool $default): self
    {
        $self = clone $this;
        $self['default'] = $default;

        return $self;
    }

    /**
     * Modalités de paiement affichées sur les documents.
     * Ex. "Paiement à 30 jours", "RIB : FR76...", "Payable à réception".
     */
    public function withModality(string $modality): self
    {
        $self = clone $this;
        $self['modality'] = $modality;

        return $self;
    }

    /**
     * Nom du moyen de paiement (ex. "Virement bancaire", "Carte Bancaire").
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * État du moyen de paiement.
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
     * Type de moyen de paiement :
     * - **check** : Chèque
     * - **transfer** : Virement bancaire
     * - **stripe** : Stripe
     * - **paypal** : PayPal
     * - **paybox** : Paybox
     * - **epayment** : Paiement électronique
     * - **other** : Autre
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
