<?php

declare(strict_types=1);

namespace Wuro\Services;

use Wuro\Client;
use Wuro\Core\Contracts\BaseResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\PaymentMethods\PaymentMethodCreateParams;
use Wuro\PaymentMethods\PaymentMethodCreateParams\Tag;
use Wuro\PaymentMethods\PaymentMethodDeleteResponse;
use Wuro\PaymentMethods\PaymentMethodGetResponse;
use Wuro\PaymentMethods\PaymentMethodListParams;
use Wuro\PaymentMethods\PaymentMethodListResponse;
use Wuro\PaymentMethods\PaymentMethodNewResponse;
use Wuro\PaymentMethods\PaymentMethodUpdateParams;
use Wuro\PaymentMethods\PaymentMethodUpdateParams\State;
use Wuro\PaymentMethods\PaymentMethodUpdateResponse;
use Wuro\RequestOptions;
use Wuro\ServiceContracts\PaymentMethodsRawContract;

final class PaymentMethodsRawService implements PaymentMethodsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
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
     * @param array{
     *   name: string,
     *   default?: bool,
     *   isTest?: bool,
     *   modality?: string,
     *   public?: string,
     *   rang?: string,
     *   secret?: string,
     *   site?: string,
     *   tag?: 'paybox'|'epayment'|'check'|'stripe'|'paypal'|'transfer'|'other'|Tag,
     * }|PaymentMethodCreateParams $params
     *
     * @return BaseResponse<PaymentMethodNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|PaymentMethodCreateParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = PaymentMethodCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'payment-method',
            body: (object) $parsed,
            options: $options,
            convert: PaymentMethodNewResponse::class,
        );
    }

    /**
     * @api
     *
     * Récupère les informations détaillées d'un moyen de paiement par son identifiant.
     *
     * Les informations incluent le nom, le type (tag), les modalités de paiement
     * et si c'est le moyen par défaut.
     *
     * @param string $uid Identifiant unique du moyen de paiement
     *
     * @return BaseResponse<PaymentMethodGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['payment-method/%1$s', $uid],
            options: $requestOptions,
            convert: PaymentMethodGetResponse::class,
        );
    }

    /**
     * @api
     *
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
     * @param string $uid Identifiant unique du moyen de paiement
     * @param array{
     *   default?: bool,
     *   modality?: string,
     *   name?: string,
     *   state?: 'active'|'inactive'|State,
     *   tag?: 'paybox'|'epayment'|'check'|'stripe'|'paypal'|'transfer'|'other'|PaymentMethodUpdateParams\Tag,
     * }|PaymentMethodUpdateParams $params
     *
     * @return BaseResponse<PaymentMethodUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        array|PaymentMethodUpdateParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = PaymentMethodUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'patch',
            path: ['payment-method/%1$s', $uid],
            body: (object) $parsed,
            options: $options,
            convert: PaymentMethodUpdateResponse::class,
        );
    }

    /**
     * @api
     *
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
     * @param array{
     *   state?: 'active'|'inactive'|PaymentMethodListParams\State,
     *   tag?: 'paybox'|'epayment'|'check'|'stripe'|'paypal'|'transfer'|'other'|PaymentMethodListParams\Tag,
     * }|PaymentMethodListParams $params
     *
     * @return BaseResponse<PaymentMethodListResponse>
     *
     * @throws APIException
     */
    public function list(
        array|PaymentMethodListParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = PaymentMethodListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'payment-methods',
            query: $parsed,
            options: $options,
            convert: PaymentMethodListResponse::class,
        );
    }

    /**
     * @api
     *
     * Supprime un moyen de paiement (soft delete).
     *
     * Le moyen passe en état "inactive" et n'est plus proposé pour les nouveaux documents.
     *
     * **Note** : Il est recommandé d'utiliser PATCH avec `state: "inactive"` plutôt que DELETE
     * pour conserver l'historique des documents utilisant ce moyen.
     *
     * @param string $uid Identifiant unique du moyen de paiement
     *
     * @return BaseResponse<PaymentMethodDeleteResponse>
     *
     * @throws APIException
     */
    public function delete(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['payment-method/%1$s', $uid],
            options: $requestOptions,
            convert: PaymentMethodDeleteResponse::class,
        );
    }
}
