<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts;

use Wuro\Core\Exceptions\APIException;
use Wuro\DeliveryReceipts\DeliveryReceiptCreateParams\Line;
use Wuro\DeliveryReceipts\DeliveryReceiptCreateParams\State;
use Wuro\DeliveryReceipts\DeliveryReceiptCreateParams\Type;
use Wuro\DeliveryReceipts\DeliveryReceiptDeleteResponse;
use Wuro\DeliveryReceipts\DeliveryReceiptGenerateHTMLResponse;
use Wuro\DeliveryReceipts\DeliveryReceiptGetResponse;
use Wuro\DeliveryReceipts\DeliveryReceiptListResponse;
use Wuro\DeliveryReceipts\DeliveryReceiptNewInvoiceResponse;
use Wuro\DeliveryReceipts\DeliveryReceiptNewResponse;
use Wuro\DeliveryReceipts\DeliveryReceiptUpdateResponse;
use Wuro\RequestOptions;

/**
 * @phpstan-import-type LineShape from \Wuro\DeliveryReceipts\DeliveryReceiptCreateParams\Line
 * @phpstan-import-type LineShape from \Wuro\DeliveryReceipts\DeliveryReceiptUpdateParams\Line as LineShape1
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
interface DeliveryReceiptsContract
{
    /**
     * @api
     *
     * @param string $client Référence du client (obligatoire)
     * @param string $clientAddress Adresse de livraison
     * @param string $clientCity Ville de livraison
     * @param string $clientCountry Pays de livraison
     * @param string $clientEmail Email du client (pour envoi du bon)
     * @param string $clientName Nom du client (copié du client si non fourni)
     * @param string $clientZipCode Code postal
     * @param \DateTimeInterface $date Date du bon (par défaut aujourd'hui)
     * @param list<Line|LineShape> $lines Lignes du bon de livraison
     * @param \DateTimeInterface $shippingDate Date d'expédition prévue
     * @param State|value-of<State> $state État initial du bon
     * @param string $title Description courte ou libellé du bon
     * @param Type|value-of<Type> $type Type de document (delivery par défaut)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $client,
        ?string $clientAddress = null,
        ?string $clientCity = null,
        string $clientCountry = 'France',
        ?string $clientEmail = null,
        ?string $clientName = null,
        ?string $clientZipCode = null,
        ?\DateTimeInterface $date = null,
        ?array $lines = null,
        ?\DateTimeInterface $shippingDate = null,
        State|string $state = 'draft',
        ?string $title = null,
        Type|string $type = 'delivery',
        RequestOptions|array|null $requestOptions = null,
    ): DeliveryReceiptNewResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du bon de livraison
     * @param string $populate Relations à inclure (ex. "client", "documentModel")
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $uid,
        ?string $populate = null,
        RequestOptions|array|null $requestOptions = null,
    ): DeliveryReceiptGetResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du bon de livraison
     * @param string $clientAddress Adresse du client
     * @param string $clientCity Ville du client
     * @param string $clientCountry Pays du client
     * @param string $clientEmail Email du client
     * @param string $clientName Nom du client
     * @param string $clientZipCode Code postal du client
     * @param \DateTimeInterface $date Date du bon de livraison
     * @param list<\Wuro\DeliveryReceipts\DeliveryReceiptUpdateParams\Line|LineShape1> $lines Lignes du bon de livraison
     * @param \DateTimeInterface $shippingDate Date d'expédition
     * @param \Wuro\DeliveryReceipts\DeliveryReceiptUpdateParams\State|value-of<\Wuro\DeliveryReceipts\DeliveryReceiptUpdateParams\State> $state État du bon de livraison :
     * - **draft** : Brouillon
     * - **waiting** : En attente d'expédition
     * - **shipped** : Expédié
     * - **delivered** : Livré
     * - **refused** : Refusé
     * - **canceled** : Annulé
     * @param string $title Description courte ou libellé du bon
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        ?string $clientAddress = null,
        ?string $clientCity = null,
        ?string $clientCountry = null,
        ?string $clientEmail = null,
        ?string $clientName = null,
        ?string $clientZipCode = null,
        ?\DateTimeInterface $date = null,
        ?array $lines = null,
        ?\DateTimeInterface $shippingDate = null,
        \Wuro\DeliveryReceipts\DeliveryReceiptUpdateParams\State|string|null $state = null,
        ?string $title = null,
        RequestOptions|array|null $requestOptions = null,
    ): DeliveryReceiptUpdateResponse;

    /**
     * @api
     *
     * @param string $client Filtre par ID du client
     * @param int $limit Nombre maximum de bons à retourner
     * @param int $skip Nombre de bons à ignorer (pagination)
     * @param string $sort Champ de tri et direction
     * @param \Wuro\DeliveryReceipts\DeliveryReceiptListParams\State|value-of<\Wuro\DeliveryReceipts\DeliveryReceiptListParams\State> $state Filtre par état
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        ?string $client = null,
        int $limit = 20,
        int $skip = 0,
        ?string $sort = null,
        \Wuro\DeliveryReceipts\DeliveryReceiptListParams\State|string|null $state = null,
        RequestOptions|array|null $requestOptions = null,
    ): DeliveryReceiptListResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du bon de livraison
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): DeliveryReceiptDeleteResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du bon de livraison source
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function createInvoice(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): DeliveryReceiptNewInvoiceResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du bon de livraison
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function generateHTML(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): DeliveryReceiptGenerateHTMLResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du bon de livraison
     * @param bool $forceDownload Si true, force le téléchargement du fichier au lieu de l'afficher
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function generatePdf(
        string $uid,
        bool $forceDownload = false,
        RequestOptions|array|null $requestOptions = null,
    ): string;
}
