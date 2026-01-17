<?php

declare(strict_types=1);

namespace Wuro\Services\Quotes;

use Wuro\Client;
use Wuro\Core\Contracts\BaseResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\Quotes\Line\LineAddParams;
use Wuro\Quotes\Line\LineAddParams\Type;
use Wuro\Quotes\Line\LineAddResponse;
use Wuro\Quotes\Line\LineDeleteParams;
use Wuro\Quotes\Line\LineUpdateParams;
use Wuro\Quotes\Line\LineUpdateResponse;
use Wuro\Quotes\Line\Quote;
use Wuro\RequestOptions;
use Wuro\ServiceContracts\Quotes\LineRawContract;

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
     * Met à jour une ligne existante d'un devis.
     *
     * **Comportement:**
     * - Les totaux du devis sont automatiquement recalculés après modification
     * - Seuls les champs fournis sont modifiés (mise à jour partielle)
     *
     * **Types de lignes:**
     * - **product** : Ligne produit standard avec prix et quantité
     * - **header** : Ligne de titre/séparation
     * - **subtotal** : Sous-total automatique
     * - **globalDiscount** : Remise globale
     *
     * **Événement déclenché:** UPDATE_QUOTE
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
            path: ['quote/%1$s/line/%2$s', $uid, $lineUuid],
            body: (object) array_diff_key($parsed, array_flip(['uid'])),
            options: $options,
            convert: LineUpdateResponse::class,
        );
    }

    /**
     * @api
     *
     * Supprime une ligne d'un devis existant.
     *
     * **Comportement:**
     * - Les totaux du devis sont automatiquement recalculés après suppression
     * - La ligne est définitivement supprimée (pas de soft delete)
     *
     * **Événement déclenché:** UPDATE_QUOTE
     *
     * @param string $lineUuid Identifiant unique de la ligne à supprimer
     * @param array{uid: string}|LineDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Quote>
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
            path: ['quote/%1$s/line/%2$s', $uid, $lineUuid],
            options: $options,
            convert: Quote::class,
        );
    }

    /**
     * @api
     *
     * Ajoute une nouvelle ligne à un devis existant.
     *
     * Les totaux sont automatiquement recalculés après l'ajout.
     *
     * @param string $uid ID du devis
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
            path: ['quote/%1$s/line', $uid],
            body: (object) $parsed,
            options: $options,
            convert: LineAddResponse::class,
        );
    }
}
