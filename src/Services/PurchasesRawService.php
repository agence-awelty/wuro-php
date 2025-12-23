<?php

declare(strict_types=1);

namespace Wuro\Services;

use Wuro\Client;
use Wuro\Core\Contracts\BaseResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\Purchases\PurchaseCreateParams;
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
     *   date?: string|\DateTimeInterface,
     *   invoiceNumber?: string,
     *   lines?: list<array{
     *     title?: string,
     *     totalHt?: float,
     *     totalTtc?: float,
     *     totalTva?: float,
     *     tvaRate?: float,
     *     type?: string,
     *   }>,
     *   paymentDate?: string|\DateTimeInterface,
     *   paymentExpiryDate?: string|\DateTimeInterface,
     *   payments?: list<array{
     *     amount?: float, date?: string|\DateTimeInterface, mode?: string
     *   }>,
     *   state?: 'draft'|'waiting'|'paid'|'to_pay'|'notpaid'|State,
     *   supplier?: string,
     *   supplierCode?: string,
     *   supplierName?: string,
     *   supplierReverseCharge?: bool,
     *   supplierTvaNumber?: string,
     *   totalHt?: float,
     *   totalTtc?: float,
     *   totalTva?: float,
     *   type?: 'purchase'|'purchase_credit'|Type,
     * }|PurchaseCreateParams $params
     *
     * @return BaseResponse<PurchaseNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|PurchaseCreateParams $params,
        ?RequestOptions $requestOptions = null
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
     *
     * @return BaseResponse<PurchaseGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $uid,
        array|PurchaseRetrieveParams $params,
        ?RequestOptions $requestOptions = null,
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
     *   date?: string|\DateTimeInterface,
     *   invoiceNumber?: string,
     *   lines?: list<array{
     *     title?: string,
     *     totalHt?: float,
     *     totalTtc?: float,
     *     totalTva?: float,
     *     tvaRate?: float,
     *     type?: string,
     *   }>,
     *   paymentDate?: string|\DateTimeInterface,
     *   paymentExpiryDate?: string|\DateTimeInterface,
     *   payments?: list<array{
     *     amount?: float, date?: string|\DateTimeInterface, mode?: string
     *   }>,
     *   state?: 'draft'|'waiting'|'paid'|'to_pay'|'notpaid'|PurchaseUpdateParams\State,
     *   supplier?: string,
     *   supplierCode?: string,
     *   supplierName?: string,
     *   supplierReverseCharge?: bool,
     *   supplierTvaNumber?: string,
     *   totalHt?: float,
     *   totalTtc?: float,
     *   totalTva?: float,
     *   type?: 'purchase'|'purchase_credit'|PurchaseUpdateParams\Type,
     * }|PurchaseUpdateParams $params
     *
     * @return BaseResponse<PurchaseUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        array|PurchaseUpdateParams $params,
        ?RequestOptions $requestOptions = null,
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
     *   state?: 'draft'|'waiting'|'paid'|'to_pay'|'notpaid'|'inactive'|PurchaseListParams\State,
     *   supplier?: string,
     * }|PurchaseListParams $params
     *
     * @return BaseResponse<PurchaseListResponse>
     *
     * @throws APIException
     */
    public function list(
        array|PurchaseListParams $params,
        ?RequestOptions $requestOptions = null
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
     *
     * @return BaseResponse<PurchaseDeleteResponse>
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
     *
     * @return BaseResponse<PurchaseNewCreditResponse>
     *
     * @throws APIException
     */
    public function createCredit(
        string $uid,
        ?RequestOptions $requestOptions = null
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
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function getStats(
        ?RequestOptions $requestOptions = null
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
