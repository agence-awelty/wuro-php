<?php

declare(strict_types=1);

namespace Wuro\Services;

use Wuro\Client;
use Wuro\Core\Contracts\BaseResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\Purchases\PurchaseCreateParams;
use Wuro\Purchases\PurchaseCreateParams\Line;
use Wuro\Purchases\PurchaseCreateParams\Payment;
use Wuro\Purchases\PurchaseCreateParams\State;
use Wuro\Purchases\PurchaseCreateParams\Type;
use Wuro\Purchases\PurchaseDeleteResponse;
use Wuro\Purchases\PurchaseGetResponse;
use Wuro\Purchases\PurchaseListParams;
use Wuro\Purchases\PurchaseListResponse;
use Wuro\Purchases\PurchaseNewCreditResponse;
use Wuro\Purchases\PurchaseNewResponse;
use Wuro\Purchases\PurchaseRetrieveParams;
use Wuro\Purchases\PurchaseUpdateParams;
use Wuro\Purchases\PurchaseUpdateResponse;
use Wuro\RequestOptions;
use Wuro\ServiceContracts\PurchasesRawContract;

/**
 * @phpstan-import-type LineShape from \Wuro\Purchases\PurchaseCreateParams\Line
 * @phpstan-import-type PaymentShape from \Wuro\Purchases\PurchaseCreateParams\Payment
 * @phpstan-import-type LineShape from \Wuro\Purchases\PurchaseUpdateParams\Line as LineShape1
 * @phpstan-import-type PaymentShape from \Wuro\Purchases\PurchaseUpdateParams\Payment as PaymentShape1
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
final class PurchasesRawService implements PurchasesRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Crée un nouvel achat (facture fournisseur).
     *
     * ## Champs principaux
     *
     * - **supplier** : Référence du fournisseur
     * - **supplier_name** : Nom du fournisseur
     * - **date** : Date de l'achat
     * - **lines** : Lignes de l'achat (produits/services)
     *
     * ## États disponibles
     *
     * L'achat peut être créé directement en état :
     * - **draft** : Brouillon
     * - **waiting** : En attente
     * - **paid** : Déjà payé
     *
     * ## Événement déclenché
     *
     * Un événement `CREATE_PURCHASE` est émis après la création.
     *
     * @param array{
     *   analyticalCode?: string,
     *   categories?: list<string>,
     *   currency?: string,
     *   date?: \DateTimeInterface,
     *   invoiceNumber?: string,
     *   lines?: list<Line|LineShape>,
     *   paymentDate?: \DateTimeInterface,
     *   paymentExpiryDate?: \DateTimeInterface,
     *   payments?: list<Payment|PaymentShape>,
     *   state?: State|value-of<State>,
     *   supplier?: string,
     *   supplierCode?: string,
     *   supplierName?: string,
     *   supplierReverseCharge?: bool,
     *   supplierTvaNumber?: string,
     *   totalHt?: float,
     *   totalTtc?: float,
     *   totalTva?: float,
     *   type?: Type|value-of<Type>,
     * }|PurchaseCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PurchaseNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|PurchaseCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = PurchaseCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'purchase',
            body: (object) $parsed,
            options: $options,
            convert: PurchaseNewResponse::class,
        );
    }

    /**
     * @api
     *
     * Récupère les informations détaillées d'un achat par son identifiant.
     *
     * Les informations incluent :
     * - Informations du fournisseur
     * - Lignes de l'achat (produits/services, quantités, prix)
     * - Montants (HT, TVA, TTC)
     * - État et échéances de paiement
     *
     * @param string $uid Identifiant unique de l'achat
     * @param array{populate?: string}|PurchaseRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PurchaseGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $uid,
        array|PurchaseRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = PurchaseRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['purchase/%1$s', $uid],
            query: $parsed,
            options: $options,
            convert: PurchaseGetResponse::class,
        );
    }

    /**
     * @api
     *
     * Met à jour un achat existant.
     *
     * Vous pouvez modifier :
     * - Les informations fournisseur
     * - Les lignes de l'achat
     * - Les dates et échéances
     * - L'état (pour marquer comme payé, etc.)
     *
     * ## Événement déclenché
     *
     * Un événement `UPDATE_PURCHASE` est émis après la mise à jour.
     *
     * @param string $uid Identifiant unique de l'achat
     * @param array{
     *   analyticalCode?: string,
     *   categories?: list<string>,
     *   currency?: string,
     *   date?: \DateTimeInterface,
     *   invoiceNumber?: string,
     *   lines?: list<PurchaseUpdateParams\Line|LineShape1>,
     *   paymentDate?: \DateTimeInterface,
     *   paymentExpiryDate?: \DateTimeInterface,
     *   payments?: list<PurchaseUpdateParams\Payment|PaymentShape1>,
     *   state?: PurchaseUpdateParams\State|value-of<PurchaseUpdateParams\State>,
     *   supplier?: string,
     *   supplierCode?: string,
     *   supplierName?: string,
     *   supplierReverseCharge?: bool,
     *   supplierTvaNumber?: string,
     *   totalHt?: float,
     *   totalTtc?: float,
     *   totalTva?: float,
     *   type?: PurchaseUpdateParams\Type|value-of<PurchaseUpdateParams\Type>,
     * }|PurchaseUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PurchaseUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        array|PurchaseUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = PurchaseUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'patch',
            path: ['purchase/%1$s', $uid],
            body: (object) $parsed,
            options: $options,
            convert: PurchaseUpdateResponse::class,
        );
    }

    /**
     * @api
     *
     * Récupère la liste de tous les achats/factures fournisseurs avec pagination et filtres.
     *
     * Les achats permettent de suivre les dépenses de l'entreprise (factures fournisseurs,
     * notes de frais, etc.).
     *
     * ## États disponibles
     *
     * - **draft** : Brouillon (pas encore validé)
     * - **waiting** : En attente de paiement
     * - **to_pay** : À payer
     * - **paid** : Payé
     * - **notpaid** : Impayé (échéance dépassée)
     * - **inactive** : Supprimé (soft delete)
     *
     * @param array{
     *   limit?: int,
     *   skip?: int,
     *   sort?: string,
     *   state?: PurchaseListParams\State|value-of<PurchaseListParams\State>,
     *   supplier?: string,
     * }|PurchaseListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PurchaseListResponse>
     *
     * @throws APIException
     */
    public function list(
        array|PurchaseListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = PurchaseListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'purchases',
            query: $parsed,
            options: $options,
            convert: PurchaseListResponse::class,
        );
    }

    /**
     * @api
     *
     * Supprime un achat (soft delete).
     *
     * L'achat passe en état "inactive" et n'apparaît plus dans les listes standards.
     *
     * ## Événement déclenché
     *
     * Un événement `DELETE_PURCHASE` est émis après la suppression.
     *
     * @param string $uid Identifiant unique de l'achat
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PurchaseDeleteResponse>
     *
     * @throws APIException
     */
    public function delete(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['purchase/%1$s', $uid],
            options: $requestOptions,
            convert: PurchaseDeleteResponse::class,
        );
    }

    /**
     * @api
     *
     * Crée un avoir (note de crédit) lié à un achat existant.
     *
     * **Fonctionnement:**
     * - L'avoir reprend les informations de l'achat d'origine avec des montants négatifs
     * - L'avoir est automatiquement lié à l'achat parent
     * - Le solde de l'achat est recalculé
     *
     * **Utilisation:**
     * - Remboursement d'une facture fournisseur
     * - Correction d'une erreur de facturation
     *
     * **Événement déclenché:** CREATE_PURCHASE_CREDIT
     *
     * @param string $uid Identifiant unique de l'achat d'origine
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PurchaseNewCreditResponse>
     *
     * @throws APIException
     */
    public function createCredit(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['purchase/%1$s/credit', $uid],
            options: $requestOptions,
            convert: PurchaseNewCreditResponse::class,
        );
    }

    /**
     * @api
     *
     * Récupère des statistiques agrégées sur les achats de l'entreprise.
     *
     * Les statistiques incluent généralement :
     * - Total des achats par période
     * - Répartition par fournisseur
     * - Montants en attente de paiement
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function getStats(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'purchases/stats',
            options: $requestOptions,
            convert: null,
        );
    }
}
