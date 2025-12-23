<?php

declare(strict_types=1);

namespace Wuro\ServiceContracts;

use Wuro\Core\Exceptions\APIException;
use Wuro\DeliveryReceipts\DeliveryReceiptCreateParams\Line\Type;
use Wuro\DeliveryReceipts\DeliveryReceiptCreateParams\State;
use Wuro\DeliveryReceipts\DeliveryReceiptDeleteResponse;
use Wuro\DeliveryReceipts\DeliveryReceiptGenerateHTMLResponse;
use Wuro\DeliveryReceipts\DeliveryReceiptGetResponse;
use Wuro\DeliveryReceipts\DeliveryReceiptListResponse;
use Wuro\DeliveryReceipts\DeliveryReceiptNewInvoiceResponse;
use Wuro\DeliveryReceipts\DeliveryReceiptNewResponse;
use Wuro\DeliveryReceipts\DeliveryReceiptUpdateResponse;
use Wuro\RequestOptions;

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
     * @param string|\DateTimeInterface $date Date du bon (par défaut aujourd'hui)
     * @param list<array{
     *   description?: string,
     *   order?: int,
     *   quantity?: float,
     *   reference?: string,
     *   title?: string,
     *   type?: 'product'|'header'|Type,
     *   weight?: float,
     * }> $lines Lignes du bon de livraison
     * @param string|\DateTimeInterface $shippingDate Date d'expédition prévue
     * @param 'draft'|'waiting'|'shipped'|'delivered'|State $state État initial du bon
     * @param string $title Description courte ou libellé du bon
     * @param 'delivery'|\Wuro\DeliveryReceipts\DeliveryReceiptCreateParams\Type $type Type de document (delivery par défaut)
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
        string|\DateTimeInterface|null $date = null,
        ?array $lines = null,
        string|\DateTimeInterface|null $shippingDate = null,
        string|State $state = 'draft',
        ?string $title = null,
        string|\Wuro\DeliveryReceipts\DeliveryReceiptCreateParams\Type $type = 'delivery',
        ?RequestOptions $requestOptions = null,
    ): DeliveryReceiptNewResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du bon de livraison
     * @param string $populate Relations à inclure (ex. "client", "documentModel")
     *
     * @throws APIException
     */
    public function retrieve(
        string $uid,
        ?string $populate = null,
        ?RequestOptions $requestOptions = null,
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
     * @param string|\DateTimeInterface $date Date du bon de livraison
     * @param list<array{
     *   description?: string,
     *   quantity?: float,
     *   reference?: string,
     *   title?: string,
     *   weight?: float,
     * }> $lines Lignes du bon de livraison
     * @param string|\DateTimeInterface $shippingDate Date d'expédition
     * @param 'draft'|'waiting'|'shipped'|'delivered'|'refused'|'canceled'|'inactive'|\Wuro\DeliveryReceipts\DeliveryReceiptUpdateParams\State $state État du bon de livraison :
     * - **draft** : Brouillon
     * - **waiting** : En attente d'expédition
     * - **shipped** : Expédié
     * - **delivered** : Livré
     * - **refused** : Refusé
     * - **canceled** : Annulé
     * @param string $title Description courte ou libellé du bon
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
        string|\DateTimeInterface|null $date = null,
        ?array $lines = null,
        string|\DateTimeInterface|null $shippingDate = null,
        string|\Wuro\DeliveryReceipts\DeliveryReceiptUpdateParams\State|null $state = null,
        ?string $title = null,
        ?RequestOptions $requestOptions = null,
    ): DeliveryReceiptUpdateResponse;

    /**
     * @api
     *
     * @param string $client Filtre par ID du client
     * @param int $limit Nombre maximum de bons à retourner
     * @param int $skip Nombre de bons à ignorer (pagination)
     * @param string $sort Champ de tri et direction
     * @param 'draft'|'waiting'|'shipped'|'delivered'|'refused'|'canceled'|'inactive'|\Wuro\DeliveryReceipts\DeliveryReceiptListParams\State $state Filtre par état
     *
     * @throws APIException
     */
    public function list(
        ?string $client = null,
        int $limit = 20,
        int $skip = 0,
        ?string $sort = null,
        string|\Wuro\DeliveryReceipts\DeliveryReceiptListParams\State|null $state = null,
        ?RequestOptions $requestOptions = null,
    ): DeliveryReceiptListResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du bon de livraison
     *
     * @throws APIException
     */
    public function delete(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): DeliveryReceiptDeleteResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du bon de livraison source
     *
     * @throws APIException
     */
    public function createInvoice(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): DeliveryReceiptNewInvoiceResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du bon de livraison
     *
     * @throws APIException
     */
    public function generateHTML(
        string $uid,
        ?RequestOptions $requestOptions = null
    ): DeliveryReceiptGenerateHTMLResponse;

    /**
     * @api
     *
     * @param string $uid Identifiant unique du bon de livraison
     * @param bool $forceDownload Si true, force le téléchargement du fichier au lieu de l'afficher
     *
     * @throws APIException
     */
    public function generatePdf(
        string $uid,
        bool $forceDownload = false,
        ?RequestOptions $requestOptions = null,
    ): string;
}
