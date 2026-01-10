<?php

declare(strict_types=1);

namespace Wuro\Services;

use Wuro\Client;
use Wuro\Core\Exceptions\APIException;
use Wuro\Core\Util;
use Wuro\Purchases\PurchaseCreateParams\Line;
use Wuro\Purchases\PurchaseCreateParams\Payment;
use Wuro\Purchases\PurchaseCreateParams\State;
use Wuro\Purchases\PurchaseCreateParams\Type;
use Wuro\Purchases\PurchaseDeleteResponse;
use Wuro\Purchases\PurchaseGetResponse;
use Wuro\Purchases\PurchaseListResponse;
use Wuro\Purchases\PurchaseNewCreditResponse;
use Wuro\Purchases\PurchaseNewResponse;
use Wuro\Purchases\PurchaseUpdateResponse;
use Wuro\RequestOptions;
use Wuro\ServiceContracts\PurchasesContract;

/**
 * @phpstan-import-type LineShape from \Wuro\Purchases\PurchaseCreateParams\Line
 * @phpstan-import-type PaymentShape from \Wuro\Purchases\PurchaseCreateParams\Payment
 * @phpstan-import-type LineShape from \Wuro\Purchases\PurchaseUpdateParams\Line as LineShape1
 * @phpstan-import-type PaymentShape from \Wuro\Purchases\PurchaseUpdateParams\Payment as PaymentShape1
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
final class PurchasesService implements PurchasesContract
{
    /**
     * @api
     */
    public PurchasesRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new PurchasesRawService($client);
    }

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
     * @param list<string> $categories
     * @param list<Line|LineShape> $lines
     * @param list<Payment|PaymentShape> $payments
     * @param State|value-of<State> $state
     * @param Type|value-of<Type> $type
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        ?string $analyticalCode = null,
        ?array $categories = null,
        ?string $currency = null,
        ?\DateTimeInterface $date = null,
        ?string $invoiceNumber = null,
        ?array $lines = null,
        ?\DateTimeInterface $paymentDate = null,
        ?\DateTimeInterface $paymentExpiryDate = null,
        ?array $payments = null,
        State|string|null $state = null,
        ?string $supplier = null,
        ?string $supplierCode = null,
        ?string $supplierName = null,
        ?bool $supplierReverseCharge = null,
        ?string $supplierTvaNumber = null,
        ?float $totalHt = null,
        ?float $totalTtc = null,
        ?float $totalTva = null,
        Type|string|null $type = null,
        RequestOptions|array|null $requestOptions = null,
    ): PurchaseNewResponse {
        $params = Util::removeNulls(
            [
                'analyticalCode' => $analyticalCode,
                'categories' => $categories,
                'currency' => $currency,
                'date' => $date,
                'invoiceNumber' => $invoiceNumber,
                'lines' => $lines,
                'paymentDate' => $paymentDate,
                'paymentExpiryDate' => $paymentExpiryDate,
                'payments' => $payments,
                'state' => $state,
                'supplier' => $supplier,
                'supplierCode' => $supplierCode,
                'supplierName' => $supplierName,
                'supplierReverseCharge' => $supplierReverseCharge,
                'supplierTvaNumber' => $supplierTvaNumber,
                'totalHt' => $totalHt,
                'totalTtc' => $totalTtc,
                'totalTva' => $totalTva,
                'type' => $type,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
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
     * @param string $populate Relations à inclure (ex. "supplier")
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $uid,
        ?string $populate = null,
        RequestOptions|array|null $requestOptions = null,
    ): PurchaseGetResponse {
        $params = Util::removeNulls(['populate' => $populate]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($uid, params: $params, requestOptions: $requestOptions);

        return $response->parse();
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
     * @param list<string> $categories
     * @param list<\Wuro\Purchases\PurchaseUpdateParams\Line|LineShape1> $lines
     * @param list<\Wuro\Purchases\PurchaseUpdateParams\Payment|PaymentShape1> $payments
     * @param \Wuro\Purchases\PurchaseUpdateParams\State|value-of<\Wuro\Purchases\PurchaseUpdateParams\State> $state
     * @param \Wuro\Purchases\PurchaseUpdateParams\Type|value-of<\Wuro\Purchases\PurchaseUpdateParams\Type> $type
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        ?string $analyticalCode = null,
        ?array $categories = null,
        ?string $currency = null,
        ?\DateTimeInterface $date = null,
        ?string $invoiceNumber = null,
        ?array $lines = null,
        ?\DateTimeInterface $paymentDate = null,
        ?\DateTimeInterface $paymentExpiryDate = null,
        ?array $payments = null,
        \Wuro\Purchases\PurchaseUpdateParams\State|string|null $state = null,
        ?string $supplier = null,
        ?string $supplierCode = null,
        ?string $supplierName = null,
        ?bool $supplierReverseCharge = null,
        ?string $supplierTvaNumber = null,
        ?float $totalHt = null,
        ?float $totalTtc = null,
        ?float $totalTva = null,
        \Wuro\Purchases\PurchaseUpdateParams\Type|string|null $type = null,
        RequestOptions|array|null $requestOptions = null,
    ): PurchaseUpdateResponse {
        $params = Util::removeNulls(
            [
                'analyticalCode' => $analyticalCode,
                'categories' => $categories,
                'currency' => $currency,
                'date' => $date,
                'invoiceNumber' => $invoiceNumber,
                'lines' => $lines,
                'paymentDate' => $paymentDate,
                'paymentExpiryDate' => $paymentExpiryDate,
                'payments' => $payments,
                'state' => $state,
                'supplier' => $supplier,
                'supplierCode' => $supplierCode,
                'supplierName' => $supplierName,
                'supplierReverseCharge' => $supplierReverseCharge,
                'supplierTvaNumber' => $supplierTvaNumber,
                'totalHt' => $totalHt,
                'totalTtc' => $totalTtc,
                'totalTva' => $totalTva,
                'type' => $type,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($uid, params: $params, requestOptions: $requestOptions);

        return $response->parse();
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
     * @param int $limit Nombre maximum d'achats à retourner
     * @param int $skip Nombre d'achats à ignorer (pagination)
     * @param string $sort Champ et direction de tri (ex. "date:-1" pour les plus récents)
     * @param \Wuro\Purchases\PurchaseListParams\State|value-of<\Wuro\Purchases\PurchaseListParams\State> $state Filtrer par état de l'achat
     * @param string $supplier Filtrer par fournisseur (ID du fournisseur)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        int $limit = 20,
        int $skip = 0,
        ?string $sort = null,
        \Wuro\Purchases\PurchaseListParams\State|string|null $state = null,
        ?string $supplier = null,
        RequestOptions|array|null $requestOptions = null,
    ): PurchaseListResponse {
        $params = Util::removeNulls(
            [
                'limit' => $limit,
                'skip' => $skip,
                'sort' => $sort,
                'state' => $state,
                'supplier' => $supplier,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
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
     * @throws APIException
     */
    public function delete(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): PurchaseDeleteResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($uid, requestOptions: $requestOptions);

        return $response->parse();
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
     * @throws APIException
     */
    public function createCredit(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): PurchaseNewCreditResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->createCredit($uid, requestOptions: $requestOptions);

        return $response->parse();
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
     * @throws APIException
     */
    public function getStats(
        RequestOptions|array|null $requestOptions = null
    ): mixed {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->getStats(requestOptions: $requestOptions);

        return $response->parse();
    }
}
