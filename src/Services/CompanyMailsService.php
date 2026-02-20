<?php

declare(strict_types=1);

namespace Wuro\Services;

use Wuro\Client;
use Wuro\CompanyMails\CompanyMailListResponse;
use Wuro\Core\Exceptions\APIException;
use Wuro\RequestOptions;
use Wuro\ServiceContracts\CompanyMailsContract;

/**
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
final class CompanyMailsService implements CompanyMailsContract
{
    /**
     * @api
     */
    public CompanyMailsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new CompanyMailsRawService($client);
    }

    /**
     * @api
     *
     * Récupère la liste des adresses email configurées pour l'entreprise.
     *
     * **Utilisation:**
     * - Sélection de l'expéditeur pour l'envoi de documents
     * - Configuration des réponses automatiques
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): CompanyMailListResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(requestOptions: $requestOptions);

        return $response->parse();
    }
}
