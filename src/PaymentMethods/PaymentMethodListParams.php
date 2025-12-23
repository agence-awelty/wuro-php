<?php

declare(strict_types=1);

namespace Wuro\PaymentMethods;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Concerns\SdkParams;
use Wuro\Core\Contracts\BaseModel;
use Wuro\PaymentMethods\PaymentMethodListParams\State;
use Wuro\PaymentMethods\PaymentMethodListParams\Tag;

/**
 * Récupère la liste de tous les moyens de paiement configurés pour l'entreprise.
 *
 * Les moyens de paiement sont utilisés sur les factures et devis pour indiquer
 * au client comment régler sa facture.
 *
 * ## Types de moyens de paiement (tags)
 *
 * - **check** : Chèque
 * - **transfer** : Virement bancaire
 * - **paybox** : Paiement Paybox
 * - **stripe** : Paiement Stripe
 * - **paypal** : Paiement PayPal
 * - **epayment** : Paiement électronique générique
 * - **other** : Autre moyen de paiement
 *
 * ## Moyen de paiement par défaut
 *
 * Un seul moyen peut être défini comme "default" et sera automatiquement
 * sélectionné lors de la création de nouveaux documents.
 *
 * @see Wuro\Services\PaymentMethodsService::list()
 *
 * @phpstan-type PaymentMethodListParamsShape = array{
 *   state?: null|State|value-of<State>, tag?: null|Tag|value-of<Tag>
 * }
 */
final class PaymentMethodListParams implements BaseModel
{
    /** @use SdkModel<PaymentMethodListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Filtrer par état (active/inactive).
     *
     * @var value-of<State>|null $state
     */
    #[Optional(enum: State::class)]
    public ?string $state;

    /**
     * Filtrer par type de moyen de paiement.
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
        State|string|null $state = null,
        Tag|string|null $tag = null
    ): self {
        $self = new self;

        null !== $state && $self['state'] = $state;
        null !== $tag && $self['tag'] = $tag;

        return $self;
    }

    /**
     * Filtrer par état (active/inactive).
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
     * Filtrer par type de moyen de paiement.
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
