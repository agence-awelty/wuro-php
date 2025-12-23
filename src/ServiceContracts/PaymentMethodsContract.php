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
     * @param 'paybox'|'epayment'|'check'|'stripe'|'paypal'|'transfer'|'other'|Tag $tag Type de moyen de paiement
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
        string|Tag $tag = 'other',
        ?RequestOptions $requestOptions = null,
    ): PaymentMethodNewResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du moyen de paiement
     *
     * @throws APIException
     */
    public function retrieve(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): PaymentMethodGetResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du moyen de paiement
     * @param bool $default Définir comme moyen de paiement par défaut
     * @param string $modality Modalités de paiement affichées sur les documents.
     * Ex. "Paiement à 30 jours", "RIB : FR76...", "Payable à réception"
     * @param string $name Nom du moyen de paiement (ex. "Virement bancaire", "Carte Bancaire")
     * @param 'active'|'inactive'|State $state État du moyen de paiement
     * @param 'paybox'|'epayment'|'check'|'stripe'|'paypal'|'transfer'|'other'|\Wuro\PaymentMethods\PaymentMethodUpdateParams\Tag $tag Type de moyen de paiement :
     * - **check** : Chèque
     * - **transfer** : Virement bancaire
     * - **stripe** : Stripe
     * - **paypal** : PayPal
     * - **paybox** : Paybox
     * - **epayment** : Paiement électronique
     * - **other** : Autre
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        ?bool $default = null,
        ?string $modality = null,
        ?string $name = null,
        string|State|null $state = null,
        string|\Wuro\PaymentMethods\PaymentMethodUpdateParams\Tag|null $tag = null,
        ?RequestOptions $requestOptions = null,
    ): PaymentMethodUpdateResponse;

    /**
     * @api
     *
     * @param 'active'|'inactive'|\Wuro\PaymentMethods\PaymentMethodListParams\State $state Filtrer par état (active/inactive)
     * @param 'paybox'|'epayment'|'check'|'stripe'|'paypal'|'transfer'|'other'|\Wuro\PaymentMethods\PaymentMethodListParams\Tag $tag Filtrer par type de moyen de paiement
     *
     * @throws APIException
     */
    public function list(
        string|\Wuro\PaymentMethods\PaymentMethodListParams\State|null $state = null,
        string|\Wuro\PaymentMethods\PaymentMethodListParams\Tag|null $tag = null,
        ?RequestOptions $requestOptions = null,
    ): PaymentMethodListResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du moyen de paiement
     *
     * @throws APIException
     */
    public function delete(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): PaymentMethodDeleteResponse;
}
