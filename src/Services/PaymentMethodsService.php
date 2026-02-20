<?php

declare(strict_types=1);

namespace Wuro\Services;

use Wuro\Client;
use Wuro\Core\Exceptions\APIException;
use Wuro\Core\Util;
use Wuro\PaymentMethods\PaymentMethodCreateParams\Tag;
use Wuro\PaymentMethods\PaymentMethodDeleteResponse;
use Wuro\PaymentMethods\PaymentMethodGetResponse;
use Wuro\PaymentMethods\PaymentMethodListResponse;
use Wuro\PaymentMethods\PaymentMethodNewResponse;
use Wuro\PaymentMethods\PaymentMethodUpdateParams\State;
use Wuro\PaymentMethods\PaymentMethodUpdateResponse;
use Wuro\RequestOptions;
use Wuro\ServiceContracts\PaymentMethodsContract;

/**
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
final class PaymentMethodsService implements PaymentMethodsContract
{
    /**
     * @api
     */
    public PaymentMethodsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new PaymentMethodsRawService($client);
    }

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
    ): PaymentMethodNewResponse {
        $params = Util::removeNulls(
            [
                'name' => $name,
                'default' => $default,
                'isTest' => $isTest,
                'modality' => $modality,
                'public' => $public,
                'rang' => $rang,
                'secret' => $secret,
                'site' => $site,
                'tag' => $tag,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
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
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): PaymentMethodGetResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($uid, requestOptions: $requestOptions);

        return $response->parse();
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
    ): PaymentMethodUpdateResponse {
        $params = Util::removeNulls(
            [
                'default' => $default,
                'modality' => $modality,
                'name' => $name,
                'state' => $state,
                'tag' => $tag,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($uid, params: $params, requestOptions: $requestOptions);

        return $response->parse();
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
    ): PaymentMethodListResponse {
        $params = Util::removeNulls(['state' => $state, 'tag' => $tag]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
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
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): PaymentMethodDeleteResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($uid, requestOptions: $requestOptions);

        return $response->parse();
    }
}
