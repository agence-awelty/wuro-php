<?php

declare(strict_types=1);

namespace Wuro\Companies\Position;

use Wuro\Companies\Position\PositionCreateParams\Right;
use Wuro\Core\Attributes\Optional;
use Wuro\Core\Attributes\Required;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Concerns\SdkParams;
use Wuro\Core\Contracts\BaseModel;

/**
 * Crée un nouveau poste (position) pour un utilisateur dans l'entreprise.
 *
 * **Concept de Position:**
 * - Un poste représente le lien entre un utilisateur et une entreprise
 * - Chaque poste définit un type (admin, collaborateur, etc.) et des droits spécifiques
 * - Un utilisateur peut avoir des postes dans plusieurs entreprises
 *
 * **Champs requis:**
 * - `user` : Identifiant de l'utilisateur à ajouter
 * - `type` : Type de poste (référence vers un Type de droits)
 *
 * **Événement déclenché:** CREATE_POSITION
 *
 * @see Wuro\Services\Companies\PositionService::create()
 *
 * @phpstan-import-type RightShape from \Wuro\Companies\Position\PositionCreateParams\Right
 *
 * @phpstan-type PositionCreateParamsShape = array{
 *   type: string, user: string, rights?: list<Right|RightShape>|null
 * }
 */
final class PositionCreateParams implements BaseModel
{
    /** @use SdkModel<PositionCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Type de poste (ID du Type de droits).
     */
    #[Required]
    public string $type;

    /**
     * Identifiant de l'utilisateur.
     */
    #[Required]
    public string $user;

    /**
     * Liste des droits spécifiques.
     *
     * @var list<Right>|null $rights
     */
    #[Optional(list: Right::class)]
    public ?array $rights;

    /**
     * `new PositionCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PositionCreateParams::with(type: ..., user: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PositionCreateParams)->withType(...)->withUser(...)
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
     *
     * @param list<Right|RightShape>|null $rights
     */
    public static function with(
        string $type,
        string $user,
        ?array $rights = null
    ): self {
        $self = new self;

        $self['type'] = $type;
        $self['user'] = $user;

        null !== $rights && $self['rights'] = $rights;

        return $self;
    }

    /**
     * Type de poste (ID du Type de droits).
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Identifiant de l'utilisateur.
     */
    public function withUser(string $user): self
    {
        $self = clone $this;
        $self['user'] = $user;

        return $self;
    }

    /**
     * Liste des droits spécifiques.
     *
     * @param list<Right|RightShape> $rights
     */
    public function withRights(array $rights): self
    {
        $self = clone $this;
        $self['rights'] = $rights;

        return $self;
    }
}
