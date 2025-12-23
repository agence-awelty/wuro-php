<?php

declare(strict_types=1);

namespace Wuro\Clients;

use Wuro\Core\Attributes\Required;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Concerns\SdkParams;
use Wuro\Core\Contracts\BaseModel;

/**
 * Fusionne deux fiches clients en une seule.
 *
 * **Fonctionnement:**
 * - Le client `source` est fusionné dans le client `target`
 * - Toutes les factures, devis et documents du client source sont transférés au client cible
 * - Le client source est supprimé après la fusion
 *
 * **Transfert des données:**
 * - Factures et devis
 * - Historique des paiements
 * - Notes et commentaires
 * - Interlocuteurs
 *
 * **Attention:**
 * - Cette opération est irréversible
 * - Les informations du client source qui diffèrent ne sont pas copiées (seuls les documents sont transférés)
 *
 * **Événement déclenché:** MERGE_CLIENT
 *
 * @see Wuro\Services\ClientsService::merge()
 *
 * @phpstan-type ClientMergeParamsShape = array{source: string, target: string}
 */
final class ClientMergeParams implements BaseModel
{
    /** @use SdkModel<ClientMergeParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * ID du client à fusionner (sera supprimé).
     */
    #[Required]
    public string $source;

    /**
     * ID du client cible (recevra les documents).
     */
    #[Required]
    public string $target;

    /**
     * `new ClientMergeParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ClientMergeParams::with(source: ..., target: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ClientMergeParams)->withSource(...)->withTarget(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(string $source, string $target): self
    {
        $self = new self;

        $self['source'] = $source;
        $self['target'] = $target;

        return $self;
    }

    /**
     * ID du client à fusionner (sera supprimé).
     */
    public function withSource(string $source): self
    {
        $self = clone $this;
        $self['source'] = $source;

        return $self;
    }

    /**
     * ID du client cible (recevra les documents).
     */
    public function withTarget(string $target): self
    {
        $self = clone $this;
        $self['target'] = $target;

        return $self;
    }
}
