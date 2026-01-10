<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts;

use Wuro\Core\Exceptions\APIException;
use Wuro\PaymentMethods\PaymentMethodCreateParams\Tag;
use Wuro\PaymentMethods\PaymentMethodDeleteResponse;
use Wuro\PaymentMethods\PaymentMethodGetResponse;
use Wuro\PaymentMethods\PaymentMethodListResponse;
use Wuro\PaymentMethods\PaymentMethodNewResponse;
use Wuro\PaymentMethods\PaymentMethodUpdateParams\State;
use Wuro\PaymentMethods\PaymentMethodUpdateResponse;
use Wuro\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
interface PaymentMethodsContract
{
    /**
     * @api
     *
     * @param string $name Nom du moyen de paiement (obligatoire)
     * @param bool $default Définir comme moyen par défaut
     * @param bool $isTest Mode test (pas de paiement réel)
     * @param string $modality Modalités de paiement affichées sur les documents.
     * Ex. coordonnées bancaires, délai de paiement, etc.
     * @param string $public Clé publique (Stripe, Paybox) ou identifiant marchand (PayPal)
     * @param string $rang Rang Paybox (spécifique Paybox)
     * @param string $secret Clé secrète (Stripe, Paybox) - **Ne jamais exposer côté client**
     * @param string $site Numéro de site Paybox (spécifique Paybox)
     * @param Tag|value-of<Tag> $tag Type de moyen de paiement
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $name,
        bool $default = false,
        bool $isTest = false,
        ?string $modality = null,
        ?string $public = null,
        ?string $rang = null,
        ?string $secret = null,
        ?string $site = null,
        Tag|string $tag = 'other',
        RequestOptions|array|null $requestOptions = null,
    ): PaymentMethodNewResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du moyen de paiement
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): PaymentMethodGetResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du moyen de paiement
     * @param bool $default Définir comme moyen de paiement par défaut
     * @param string $modality Modalités de paiement affichées sur les documents.
     * Ex. "Paiement à 30 jours", "RIB : FR76...", "Payable à réception"
     * @param string $name Nom du moyen de paiement (ex. "Virement bancaire", "Carte Bancaire")
     * @param State|value-of<State> $state État du moyen de paiement
     * @param \Wuro\PaymentMethods\PaymentMethodUpdateParams\Tag|value-of<\Wuro\PaymentMethods\PaymentMethodUpdateParams\Tag> $tag Type de moyen de paiement :
     * - **check** : Chèque
     * - **transfer** : Virement bancaire
     * - **stripe** : Stripe
     * - **paypal** : PayPal
     * - **paybox** : Paybox
     * - **epayment** : Paiement électronique
     * - **other** : Autre
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        ?bool $default = null,
        ?string $modality = null,
        ?string $name = null,
        State|string|null $state = null,
        \Wuro\PaymentMethods\PaymentMethodUpdateParams\Tag|string|null $tag = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaymentMethodUpdateResponse;

    /**
     * @api
     *
     * @param \Wuro\PaymentMethods\PaymentMethodListParams\State|value-of<\Wuro\PaymentMethods\PaymentMethodListParams\State> $state Filtrer par état (active/inactive)
     * @param \Wuro\PaymentMethods\PaymentMethodListParams\Tag|value-of<\Wuro\PaymentMethods\PaymentMethodListParams\Tag> $tag Filtrer par type de moyen de paiement
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        \Wuro\PaymentMethods\PaymentMethodListParams\State|string|null $state = null,
        \Wuro\PaymentMethods\PaymentMethodListParams\Tag|string|null $tag = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaymentMethodListResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du moyen de paiement
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): PaymentMethodDeleteResponse;
}
