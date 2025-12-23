<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts;

use Wuro\Companies\CompanyConfirmDomainResponse;
use Wuro\Companies\CompanyGetByIDResponse;
use Wuro\Companies\CompanyGetCgvResponse;
use Wuro\Companies\CompanyGetExtraInfosResponse;
use Wuro\Companies\CompanyGetResponse;
use Wuro\Companies\CompanyListPositionsResponse;
use Wuro\Companies\CompanyNewResponse;
use Wuro\Companies\CompanyUpdateResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\RequestOptions;

interface CompaniesContract
{
    /**
     * @api
     *
     * @param string $name Nom de l'entreprise (obligatoire)
     * @param string $url URL unique pour l'entreprise (obligatoire)
     * @param list<array{
     *   city?: string, country?: string, street?: string, zipCode?: string
     * }> $addresses
     * @param string $commercialCourt Tribunal de commerce
     * @param string $companyType ID du type d'entreprise (SARL, SAS, etc.)
     * @param string $email Email principal de l'entreprise
     * @param string $nafApe Code NAF/APE
     * @param string $nic Code NIC
     * @param string $numRcs Numéro d'inscription au RCS
     * @param string $numTradeDirectory Numéro au répertoire des métiers
     * @param float $shareCapital Capital social
     * @param string $siren Numéro SIREN (9 chiffres)
     * @param string $siret Numéro SIRET (14 chiffres)
     * @param string $tvaNumber Numéro de TVA intracommunautaire
     * @param string $website Site web de l'entreprise
     *
     * @throws APIException
     */
    public function create(
        string $name,
        string $url,
        ?array $addresses = null,
        ?string $commercialCourt = null,
        ?string $companyType = null,
        ?string $email = null,
        ?string $nafApe = null,
        ?string $nic = null,
        ?string $numRcs = null,
        ?string $numTradeDirectory = null,
        ?float $shareCapital = null,
        ?string $siren = null,
        ?string $siret = null,
        ?string $tvaNumber = null,
        ?string $website = null,
        ?RequestOptions $requestOptions = null,
    ): CompanyNewResponse;

    /**
     * @api
     *
     * @throws APIException
     */
    public function retrieve(
        ?RequestOptions $requestOptions = null
    ): CompanyGetResponse;

    /**
     * @api
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): CompanyUpdateResponse;

    /**
     * @api
     *
     * @throws APIException
     */
    public function delete(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): mixed;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de l'entreprise
     *
     * @throws APIException
     */
    public function confirmDomain(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): CompanyConfirmDomainResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de l'entreprise
     *
     * @throws APIException
     */
    public function listPositions(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): CompanyListPositionsResponse;

    /**
     * @api
     *
     * @param string $uid ID de l'entreprise
     *
     * @throws APIException
     */
    public function retrieveByID(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): CompanyGetByIDResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de l'entreprise
     *
     * @throws APIException
     */
    public function retrieveCgv(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): CompanyGetCgvResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique de l'entreprise
     *
     * @throws APIException
     */
    public function retrieveExtraInfos(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): CompanyGetExtraInfosResponse;
}
