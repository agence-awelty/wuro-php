<?php

declare(strict_types=1);

namespace Wuro\Absences;

use Wuro\Core\Attributes\Optional;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Concerns\SdkParams;
use Wuro\Core\Contracts\BaseModel;

/**
 * Récupère les informations détaillées d'une absence spécifique.
 *
 * Les informations incluent :
 * - Les dates et moments (matin/après-midi/journée entière)
 * - Le type d'absence
 * - L'état actuel (en attente, validée, refusée, etc.)
 * - L'historique complet des actions (logs)
 * - Le collaborateur et son poste concernés
 *
 * @see Wuro\Services\AbsencesService::retrieve()
 *
 * @phpstan-type AbsenceRetrieveParamsShape = array{populate?: string|null}
 */
final class AbsenceRetrieveParams implements BaseModel
{
    /** @use SdkModel<AbsenceRetrieveParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Relations à inclure (ex. "type", "positionTo", "userTo").
     */
    #[Optional]
    public ?string $populate;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?string $populate = null): self
    {
        $self = new self;

        null !== $populate && $self['populate'] = $populate;

        return $self;
    }

    /**
     * Relations à inclure (ex. "type", "positionTo", "userTo").
     */
    public function withPopulate(string $populate): self
    {
        $self = clone $this;
        $self['populate'] = $populate;

        return $self;
    }
}
