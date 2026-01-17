<?php

declare(strict_types=1);

namespace Wuro\Services;

use Wuro\Client;
use Wuro\Core\Exceptions\APIException;
use Wuro\Core\Util;
use Wuro\Invoices\InvoiceCreateParams\State;
use Wuro\Invoices\InvoiceCreateParams\Type;
use Wuro\Invoices\InvoiceGetLogsResponse;
use Wuro\Invoices\InvoiceGetResponse;
use Wuro\Invoices\InvoiceGetStatsResponse;
use Wuro\Invoices\InvoiceGetTurnoverResponse;
use Wuro\Invoices\InvoiceListPaymentsResponse;
use Wuro\Invoices\InvoiceListResponse;
use Wuro\Invoices\InvoiceListWaitingPaymentsResponse;
use Wuro\Invoices\InvoiceNewCreditResponse;
use Wuro\Invoices\InvoiceNewPackageResponse;
use Wuro\Invoices\InvoiceNewResponse;
use Wuro\Invoices\InvoiceRecordPaymentResponse;
use Wuro\Invoices\InvoiceSendEmailParams\Action;
use Wuro\Invoices\InvoiceSendEmailResponse;
use Wuro\Invoices\InvoiceUpdateResponse;
use Wuro\Invoices\Line\InvoiceLine;
use Wuro\RequestOptions;
use Wuro\ServiceContracts\InvoicesContract;
use Wuro\Services\Invoices\LineService;

/**
 * @phpstan-import-type InvoiceLineShape from \Wuro\Invoices\InvoiceCreateParams\InvoiceLine as InvoiceLineShape1
 * @phpstan-import-type InvoiceLineShape from \Wuro\Invoices\Line\InvoiceLine
 * @phpstan-import-type RequestOpts from \Wuro\RequestOptions
 */
final class InvoicesService implements InvoicesContract
{
    /**
     * @api
     */
    public InvoicesRawService $raw;

    /**
     * @api
     */
    public LineService $line;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new InvoicesRawService($client);
        $this->line = new LineService($client);
    }

    /**
     * @api
     *
     * Crée une nouvelle facture.
     *
     * **Numérotation automatique:**
     * - Si l'état est 'waiting', 'paid', 'notpaid' ou 'late', un numéro est automatiquement attribué
     * - Le système verrouille la numérotation pendant l'attribution pour éviter les doublons
     * - Un numéro d'enregistrement FEC (numberRecord) est aussi généré
     *
     * **Types de factures:**
     * - `invoice`: Facture standard
     * - `invoice_credit`: Avoir
     * - `external`: Facture externe (client fournisseur)
     * - `external_credit`: Avoir externe
     * - `proforma`: Facture proforma
     * - `advance`: Acompte
     *
     * **Calculs automatiques:**
     * - Les totaux HT, TVA et TTC sont calculés automatiquement
     * - Les réductions globales sont appliquées
     * - La date d'échéance est calculée selon les paramètres de l'entreprise
     *
     * **Événements déclenchés:**
     * - CREATE_INVOICE
     * - Mise à jour du stock si nécessaire
     *
     * **Réponse:**
     * - Inclut les liens `pdf_link` et `html_link` pour accéder aux documents
     *
     * @param string $client ID du client
     * @param string $clientEmail Email pour l'envoi de la facture
     * @param string $clientName Nom du client (si pas de client référencé)
     * @param \DateTimeInterface $date Date de la facture (défaut = maintenant)
     * @param list<\Wuro\Invoices\InvoiceCreateParams\InvoiceLine|InvoiceLineShape1> $invoiceLines Lignes de la facture
     * @param \DateTimeInterface $paymentExpiryDate Date d'échéance (calculée automatiquement si non fournie)
     * @param State|value-of<State> $state État initial (draft = brouillon sans numéro)
     * @param string $title Titre/objet de la facture
     * @param Type|value-of<Type> $type
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        ?string $client = null,
        ?string $clientAddress = null,
        ?string $clientCity = null,
        string $clientCountry = 'France',
        ?string $clientEmail = null,
        ?string $clientName = null,
        ?string $clientZipCode = null,
        ?\DateTimeInterface $date = null,
        ?array $invoiceLines = null,
        ?\DateTimeInterface $paymentExpiryDate = null,
        State|string $state = 'draft',
        ?string $title = null,
        Type|string $type = 'invoice',
        RequestOptions|array|null $requestOptions = null,
    ): InvoiceNewResponse {
        $params = Util::removeNulls(
            [
                'client' => $client,
                'clientAddress' => $clientAddress,
                'clientCity' => $clientCity,
                'clientCountry' => $clientCountry,
                'clientEmail' => $clientEmail,
                'clientName' => $clientName,
                'clientZipCode' => $clientZipCode,
                'date' => $date,
                'invoiceLines' => $invoiceLines,
                'paymentExpiryDate' => $paymentExpiryDate,
                'state' => $state,
                'title' => $title,
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
     * Récupère les détails complets d'une facture spécifique.
     *
     * Inclut toutes les informations: client, lignes, paiements, etc.
     *
     * @param string $uid ID de la facture
     * @param string $populate Champs à peupler (ex. "client,positionCreator")
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $uid,
        ?string $populate = null,
        RequestOptions|array|null $requestOptions = null,
    ): InvoiceGetResponse {
        $params = Util::removeNulls(['populate' => $populate]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($uid, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Met à jour une facture existante.
     *
     * **Numérotation automatique:**
     * - Si la facture passe de 'draft' à un état validé (waiting, paid, etc.), un numéro est automatiquement attribué
     * - Le numéro est verrouillé pendant l'attribution pour éviter les doublons
     * - Un numéro d'enregistrement FEC (numberRecord) est aussi généré
     *
     * **Restrictions:**
     * - Une facture numérotée ne peut pas revenir en brouillon
     * - Certaines modifications sont interdites sur les factures validées
     *
     * **Événements déclenchés:**
     * - Mise à jour du stock si nécessaire
     * - Logs de numérotation
     *
     * @param string $client ID du client
     * @param string $clientAddress Adresse du client
     * @param string $clientName Nom du client
     * @param \DateTimeInterface $date Date de la facture
     * @param list<InvoiceLine|InvoiceLineShape> $invoiceLines Lignes de la facture
     * @param \DateTimeInterface $paymentExpiryDate Date d'échéance de paiement
     * @param \Wuro\Invoices\InvoiceUpdateParams\State|value-of<\Wuro\Invoices\InvoiceUpdateParams\State> $state État de la facture
     * @param string $title Titre/objet de la facture
     * @param \Wuro\Invoices\InvoiceUpdateParams\Type|value-of<\Wuro\Invoices\InvoiceUpdateParams\Type> $type Type de facture
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $uid,
        ?string $client = null,
        ?string $clientAddress = null,
        ?string $clientCity = null,
        ?string $clientCountry = null,
        ?string $clientEmail = null,
        ?string $clientName = null,
        ?string $clientZipCode = null,
        ?\DateTimeInterface $date = null,
        ?array $invoiceLines = null,
        ?\DateTimeInterface $paymentExpiryDate = null,
        \Wuro\Invoices\InvoiceUpdateParams\State|string|null $state = null,
        ?string $title = null,
        \Wuro\Invoices\InvoiceUpdateParams\Type|string|null $type = null,
        RequestOptions|array|null $requestOptions = null,
    ): InvoiceUpdateResponse {
        $params = Util::removeNulls(
            [
                'client' => $client,
                'clientAddress' => $clientAddress,
                'clientCity' => $clientCity,
                'clientCountry' => $clientCountry,
                'clientEmail' => $clientEmail,
                'clientName' => $clientName,
                'clientZipCode' => $clientZipCode,
                'date' => $date,
                'invoiceLines' => $invoiceLines,
                'paymentExpiryDate' => $paymentExpiryDate,
                'state' => $state,
                'title' => $title,
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
     * Récupère la liste des factures avec pagination, tri et filtres avancés.
     *
     * **Filtres disponibles:**
     * - `state`: État de la facture (draft, waiting, paid, notpaid, late, inactive)
     * - `type`: Type de facture (invoice, invoice_credit, external, external_credit, proforma, advance)
     * - `client`: ID du client
     * - `minDate` / `maxDate`: Plage de dates
     * - `number`: Numéro de facture
     * - `search`: Recherche textuelle
     *
     * **Réponse:**
     * - `invoices`: Liste des factures
     * - `total`: Nombre total de factures correspondantes
     * - `skip` et `limit`: Paramètres de pagination
     *
     * @param string $client Filtre par ID du client
     * @param int $limit Nombre maximum de factures à retourner
     * @param \DateTimeInterface $maxDate Date maximum (ISO 8601)
     * @param \DateTimeInterface $minDate Date minimum (ISO 8601)
     * @param string $number Numéro de facture (recherche exacte)
     * @param string $search Recherche textuelle dans les factures
     * @param int $skip Nombre de factures à ignorer (pagination)
     * @param string $sort Champ de tri et direction (ex. "date:-1" pour tri décroissant par date)
     * @param \Wuro\Invoices\InvoiceListParams\State|value-of<\Wuro\Invoices\InvoiceListParams\State> $state Filtre par état de la facture
     * @param \Wuro\Invoices\InvoiceListParams\Type|value-of<\Wuro\Invoices\InvoiceListParams\Type> $type Filtre par type de facture
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        ?string $client = null,
        int $limit = 20,
        ?\DateTimeInterface $maxDate = null,
        ?\DateTimeInterface $minDate = null,
        ?string $number = null,
        ?string $search = null,
        int $skip = 0,
        ?string $sort = null,
        \Wuro\Invoices\InvoiceListParams\State|string|null $state = null,
        \Wuro\Invoices\InvoiceListParams\Type|string|null $type = null,
        RequestOptions|array|null $requestOptions = null,
    ): InvoiceListResponse {
        $params = Util::removeNulls(
            [
                'client' => $client,
                'limit' => $limit,
                'maxDate' => $maxDate,
                'minDate' => $minDate,
                'number' => $number,
                'search' => $search,
                'skip' => $skip,
                'sort' => $sort,
                'state' => $state,
                'type' => $type,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Supprime (désactive) une facture.
     *
     * **Restrictions:**
     * - Seules les factures en brouillon non numérotées peuvent être supprimées
     * - Une facture avec un numéro ou un numberRecord ne peut pas être supprimée
     * - L'état passe à 'inactive' (soft delete)
     *
     * **Événement déclenché:** DELETE_INVOICE
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): mixed {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($uid, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Crée un avoir (facture d'avoir) lié à une facture existante.
     *
     * L'avoir reprend les informations de la facture d'origine avec des montants négatifs.
     *
     * @param string $uid ID de la facture d'origine
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function createCredit(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): InvoiceNewCreditResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->createCredit($uid, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Génère un bon de livraison (Receipt) à partir d'une facture.
     *
     * Le bon de livraison reprend les lignes de la facture.
     *
     * @param string $uid ID de la facture
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function createDeliveryReceipt(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): mixed {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->createDeliveryReceipt($uid, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Génère une archive ZIP contenant les PDFs de plusieurs factures.
     *
     * **Comportement:**
     * - Si le nombre de factures > seuil configuré ou `DEFERRED=true`, l'archive est générée en arrière-plan
     * - Un objet Package est créé pour suivre la progression
     * - Une fois terminé, l'archive est téléchargeable via GET /package/{uid}/download
     *
     * **Mode différé:**
     * - Retourne immédiatement avec `newPackage` et un message
     * - Le package passe par les états: created → finished (ou error)
     *
     * @param list<string> $invoicesID Liste des IDs de factures à inclure
     * @param bool $deferred Forcer le mode différé (génération en arrière-plan)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function createPackage(
        array $invoicesID,
        ?bool $deferred = null,
        RequestOptions|array|null $requestOptions = null,
    ): InvoiceNewPackageResponse {
        $params = Util::removeNulls(
            ['invoicesID' => $invoicesID, 'deferred' => $deferred]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->createPackage(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Récupère les logs d'actions effectuées sur les factures (création, modification, envoi, etc.).
     *
     * Utile pour l'audit et le suivi des modifications.
     *
     * @param string $invoice Filtre par ID de facture
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function getLogs(
        ?string $invoice = null,
        int $limit = 20,
        int $skip = 0,
        RequestOptions|array|null $requestOptions = null,
    ): InvoiceGetLogsResponse {
        $params = Util::removeNulls(
            ['invoice' => $invoice, 'limit' => $limit, 'skip' => $skip]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->getLogs(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Calcule et retourne des statistiques agrégées sur les factures.
     *
     * **Statistiques retournées:**
     * - Totaux HT/TTC par état
     * - Montants min/max
     * - Répartition par type de facture
     *
     * Utilise les mêmes filtres que GET /invoices (state, type, client, dates, etc.)
     *
     * @param string $state Filtre par état
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function getStats(
        ?\DateTimeInterface $maxDate = null,
        ?\DateTimeInterface $minDate = null,
        ?string $state = null,
        RequestOptions|array|null $requestOptions = null,
    ): InvoiceGetStatsResponse {
        $params = Util::removeNulls(
            ['maxDate' => $maxDate, 'minDate' => $minDate, 'state' => $state]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->getStats(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Calcule le chiffre d'affaires sur une période donnée.
     *
     * Basé sur les factures validées (état waiting, paid, late, notpaid).
     * Exclut les avoirs et proformas.
     *
     * @param \DateTimeInterface $maxDate Date de fin de la période
     * @param \DateTimeInterface $minDate Date de début de la période
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function getTurnover(
        ?\DateTimeInterface $maxDate = null,
        ?\DateTimeInterface $minDate = null,
        RequestOptions|array|null $requestOptions = null,
    ): InvoiceGetTurnoverResponse {
        $params = Util::removeNulls(['maxDate' => $maxDate, 'minDate' => $minDate]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->getTurnover(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Récupère la liste des paiements enregistrés sur les factures.
     *
     * **Filtres spécifiques aux paiements:**
     * - `minDate` / `maxDate` / `date`: Date du paiement
     * - `amount`: Montant du paiement
     * - `method_name`: Nom du mode de paiement
     * - `mode`: ID du mode de paiement
     *
     * **Réponse agrégée:**
     * - `payments`: Liste des paiements avec informations de la facture associée
     * - `count`: Nombre total de paiements
     * - `total`: Somme des montants
     * - `average`: Moyenne des montants
     *
     * @param \DateTimeInterface $maxDate Date maximum du paiement
     * @param \DateTimeInterface $minDate Date minimum du paiement
     * @param string $mode ID du mode de paiement
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function listPayments(
        ?int $limit = null,
        ?\DateTimeInterface $maxDate = null,
        ?\DateTimeInterface $minDate = null,
        ?string $mode = null,
        ?int $skip = null,
        RequestOptions|array|null $requestOptions = null,
    ): InvoiceListPaymentsResponse {
        $params = Util::removeNulls(
            [
                'limit' => $limit,
                'maxDate' => $maxDate,
                'minDate' => $minDate,
                'mode' => $mode,
                'skip' => $skip,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->listPayments(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Récupère les factures qui sont en attente de paiement (état waiting ou late).
     *
     * **Réponse:**
     * - `invoices`: Liste des factures en attente
     * - `total`: Nombre de factures
     * - `totalAmount`: Somme des montants restant à payer (total_nettopay)
     *
     * @param list<\Wuro\Invoices\InvoiceListWaitingPaymentsParams\State|value-of<\Wuro\Invoices\InvoiceListWaitingPaymentsParams\State>> $state Filtre par état (par défaut waiting et late)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function listWaitingPayments(
        ?int $limit = null,
        ?int $skip = null,
        ?array $state = null,
        RequestOptions|array|null $requestOptions = null,
    ): InvoiceListWaitingPaymentsResponse {
        $params = Util::removeNulls(
            ['limit' => $limit, 'skip' => $skip, 'state' => $state]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->listWaitingPayments(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Enregistre un paiement sur une facture en attente.
     *
     * **Restrictions:**
     * - La facture doit être en état 'waiting'
     * - Le mode de paiement doit exister et être actif
     *
     * **Comportement:**
     * - Le paiement est ajouté à la liste `payments` de la facture
     * - Le `total_nettopay` (reste à payer) est recalculé
     * - Si le montant couvre le total, l'état passe à 'paid'
     * - La `payment_date` est mise à jour
     *
     * **Événement déclenché:** PAYMENT_INVOICE
     *
     * @param string $uid ID de la facture
     * @param float $amount Montant du paiement
     * @param string $mode ID du mode de paiement (PaymentMethod)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function recordPayment(
        string $uid,
        float $amount,
        string $mode,
        RequestOptions|array|null $requestOptions = null,
    ): InvoiceRecordPaymentResponse {
        $params = Util::removeNulls(['amount' => $amount, 'mode' => $mode]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->recordPayment($uid, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Récupère l'historique des actions sur une facture spécifique.
     *
     * Inclut: création, modifications, numérotations, envois par email, etc.
     *
     * @param string $uid ID de la facture
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveLogs(
        string $uid,
        RequestOptions|array|null $requestOptions = null
    ): mixed {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveLogs($uid, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Envoie la facture par email au client.
     *
     * **Restrictions:**
     * - La facture ne doit pas être en brouillon
     *
     * **Personnalisation:**
     * - Utilise les modèles d'email configurés dans l'entreprise
     * - Variables disponibles: [lien-html], [lien-pdf], [facture-numero], [facture-date], [contact-nom], etc.
     *
     * **Options:**
     * - `action`: 'send_invoice' (envoi standard) ou 'dunning_invoice' (relance)
     * - `joinPdf`: true pour joindre le PDF en pièce jointe
     * - Possibilité de personnaliser subject, content, to, copyto, replyTo
     *
     * @param string $uid ID de la facture
     * @param Action|value-of<Action> $action Type d'envoi (envoi ou relance)
     * @param string $content Contenu personnalisé
     * @param string $copyto Email en copie
     * @param bool $joinPdf Joindre le PDF en pièce jointe
     * @param string $replyTo Email pour les réponses
     * @param string $subject Objet personnalisé
     * @param string $to Email du destinataire (défaut = email du client)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function sendEmail(
        string $uid,
        Action|string $action = 'send_invoice',
        ?string $content = null,
        ?string $copyto = null,
        bool $joinPdf = false,
        ?string $replyTo = null,
        ?string $subject = null,
        ?string $to = null,
        RequestOptions|array|null $requestOptions = null,
    ): InvoiceSendEmailResponse {
        $params = Util::removeNulls(
            [
                'action' => $action,
                'content' => $content,
                'copyto' => $copyto,
                'joinPdf' => $joinPdf,
                'replyTo' => $replyTo,
                'subject' => $subject,
                'to' => $to,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->sendEmail($uid, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
