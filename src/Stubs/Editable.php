<?php namespace UniBen\CMS\Stubs;

use UniBen\CMS\Models\Editable as BaseEditable;
use UniBen\CMS\EditableFactory;

/**
 * Class Editable
 *
 * @property EditableFactory|string $name
 */
class Editable extends BaseEditable
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'content'];
}
