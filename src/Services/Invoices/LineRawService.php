<?php

declare(strict_types=1);

namespace Wuro\Services\Invoices;

use Wuro\Client;
use Wuro\Core\Contracts\BaseResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\Invoices\Line\Invoice;
use Wuro\Invoices\Line\LineAddParams;
use Wuro\Invoices\Line\LineAddParams\Type;
use Wuro\Invoices\Line\LineAddResponse;
use Wuro\Invoices\Line\LineDeleteParams;
use Wuro\Invoices\Line\LineUpdateParams;
use Wuro\Invoices\Line\LineUpdateResponse;
use Wuro\RequestOptions;
use Wuro\ServiceContracts\Invoices\LineRawContract;

/**
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
final class LineRawService implements LineRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Met à jour une ligne existante d'une facture.
     *
     * **Restrictions:**
     * - La facture ne doit pas être numérotée (en brouillon uniquement)
     * - Une facture validée ne peut pas être modifiée
     *
     * **Comportement:**
     * - Les totaux de la facture sont automatiquement recalculés après modification
     * - Seuls les champs fournis sont modifiés (mise à jour partielle)
     *
     * **Types de lignes:**
     * - **product** : Ligne produit standard avec prix et quantité
     * - **header** : Ligne de titre/séparation
     * - **subtotal** : Sous-total automatique
     * - **globalDiscount** : Remise globale
     *
     * **Événement déclenché:** UPDATE_INVOICE
     *
     * @param string $lineUuid Path param: Identifiant unique de la ligne à modifier
     * @param array{
     *   uid: string,
     *   description?: string,
     *   discount?: float,
     *   priceHt?: float,
     *   quantity?: float,
     *   reference?: string,
     *   title?: string,
     *   tvaRate?: float,
     *   unit?: string,
     * }|LineUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<LineUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $lineUuid,
        array|LineUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = LineUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $uid = $parsed['uid'];
        unset($parsed['uid']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'patch',
            path: ['invoice/%1$s/line/%2$s', $uid, $lineUuid],
            body: (object) array_diff_key($parsed, array_flip(['uid'])),
            options: $options,
            convert: LineUpdateResponse::class,
        );
    }

    /**
     * @api
     *
     * Supprime une ligne d'une facture existante.
     *
     * **Restrictions:**
     * - La facture ne doit pas être numérotée (en brouillon uniquement)
     * - Une facture validée ne peut pas être modifiée
     *
     * **Comportement:**
     * - Les totaux de la facture sont automatiquement recalculés après suppression
     * - La ligne est définitivement supprimée (pas de soft delete)
     *
     * **Événement déclenché:** UPDATE_INVOICE
     *
     * @param string $lineUuid Identifiant unique de la ligne à supprimer
     * @param array{uid: string}|LineDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Invoice>
     *
     * @throws APIException
     */
    public function delete(
        string $lineUuid,
        array|LineDeleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = LineDeleteParams::parseRequest(
            $params,
            $requestOptions,
        );
        $uid = $parsed['uid'];
        unset($parsed['uid']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['invoice/%1$s/line/%2$s', $uid, $lineUuid],
            options: $options,
            convert: Invoice::class,
        );
    }

    /**
     * @api
     *
     * Ajoute une nouvelle ligne à une facture existante.
     *
     * Les totaux sont automatiquement recalculés après l'ajout.
     *
     * @param string $uid ID de la facture
     * @param array{
     *   _id?: string,
     *   description?: string,
     *   priceHt?: float,
     *   quantity?: float,
     *   reference?: string,
     *   title?: string,
     *   totalHt?: float,
     *   totalTtc?: float,
     *   tvaRate?: float,
     *   type?: Type|value-of<Type>,
     *   unit?: string,
     * }|LineAddParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<LineAddResponse>
     *
     * @throws APIException
     */
    public function add(
        string $uid,
        array|LineAddParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = LineAddParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['invoice/%1$s/line', $uid],
            body: (object) $parsed,
            options: $options,
            convert: LineAddResponse::class,
        );
    }
}
