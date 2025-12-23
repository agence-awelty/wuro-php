<?php

declare(strict_types=1);

namespace Wuro\Clients;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Concerns\SdkParams;
use Wuro\Core\Contracts\BaseModel;

/**
 * Importe une liste de clients à partir d'un fichier CSV.
 *
 * **Format du fichier CSV:**
 * - Le fichier doit être encodé en UTF-8
 * - La première ligne doit contenir les en-têtes des colonnes
 * - Séparateur de colonnes : point-virgule (;) ou virgule (,)
 *
 * **Colonnes supportées:**
 * - `name` : Nom du client (obligatoire)
 * - `email` : Adresse email
 * - `phone` : Numéro de téléphone
 * - `address` : Adresse postale
 * - `city` : Ville
 * - `zip_code` : Code postal
 * - `country` : Pays
 * - `code` : Code client
 * - `siren` : Numéro SIREN
 * - `tva_intracom` : Numéro de TVA intracommunautaire
 *
 * **Comportement:**
 * - Les clients existants (basé sur l'email ou le code) sont mis à jour
 * - Les nouveaux clients sont créés
 * - Un rapport d'import est retourné
 *
 * **Télécharger un modèle:**
 * - GET /files/clients.csv pour obtenir un fichier modèle
 *
 * @see Wuro\Services\ClientsService::importFromCsv()
 *
 * @phpstan-type ClientImportFromCsvParamsShape = array{file?: string|null}
 */
final class ClientImportFromCsvParams implements BaseModel
{
    /** @use SdkModel<ClientImportFromCsvParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Fichier CSV à importer.
     */
    #[Optional]
    public ?string $file;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?string $file = null): self
    {
        $self = new self;

        null !== $file && $self['file'] = $file;

        return $self;
    }

    /**
     * Fichier CSV à importer.
     */
    public function withFile(string $file): self
    {
        $self = clone $this;
        $self['file'] = $file;

        return $self;
    }
}
