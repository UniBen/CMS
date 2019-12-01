<?php namespace UniBen\CMS\Stubs;

use UniBen\CMS\Models\Editable as BaseEditable;
use UniBen\CMS\EditableFactory;

/**
 * Class Editable
 *
 * @property EditableFactory $name
 * @property EditableFactory $content
 */
class Editable extends BaseEditable
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'content'];
}
