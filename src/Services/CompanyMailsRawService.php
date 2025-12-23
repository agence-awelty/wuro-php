<?php

declare(strict_types=1);

namespace Wuro\Services;

use Wuro\Client;
use Wuro\CompanyMails\CompanyMailListResponse;
use Wuro\Core\Contracts\BaseResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\RequestOptions;
use Wuro\ServiceContracts\CompanyMailsRawContract;

final class CompanyMailsRawService implements CompanyMailsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Récupère la liste des adresses email configurées pour l'entreprise.
     *
     * **Utilisation:**
     * - Sélection de l'expéditeur pour l'envoi de documents
     * - Configuration des réponses automatiques
     *
     * @return BaseResponse<CompanyMailListResponse>
     *
     * @throws APIException
     */
    public function list(?RequestOptions $requestOptions = null): BaseResponse
    {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'company-mails',
            options: $requestOptions,
            convert: CompanyMailListResponse::class,
        );
    }
}
