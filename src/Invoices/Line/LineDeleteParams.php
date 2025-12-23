<?php

declare(strict_types=1);

namespace Wuro\Invoices\Line;

use Wuro\Core\Attributes\Required;
use Wuro\Core\Concerns\SdkModel;
use Wuro\Core\Concerns\SdkParams;
use Wuro\Core\Contracts\BaseModel;

/**
 * Supprime une ligne d'une facture existante.
 *
 * **Restrictions:**
 * - La facture ne doit pas être numérotée (en brouillon uniquement)
 * - Une facture validée ne peut pas être modifiée
 *
 * **Comportement:**
 * - Les totaux de la facture sont automatiquement recalculés après suppression
 * - La ligne est définitivement supprimée (pas de soft delete)
 *
 * **Événement déclenché:** UPDATE_INVOICE
 *
 * @see Wuro\Services\Invoices\LineService::delete()
 *
 * @phpstan-type LineDeleteParamsShape = array{uid: string}
 */
final class LineDeleteParams implements BaseModel
{
    /** @use SdkModel<LineDeleteParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $uid;

    /**
     * `new LineDeleteParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * LineDeleteParams::with(uid: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new LineDeleteParams)->withUid(...)
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
    public static function with(string $uid): self
    {
        $self = new self;

        $self['uid'] = $uid;

        return $self;
    }

    public function withUid(string $uid): self
    {
        $self = clone $this;
        $self['uid'] = $uid;

        return $self;
    }
}
