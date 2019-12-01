<?php namespace UniBen\CMS\Models;

use Illuminate\Database\Eloquent\Model;
use UniBen\CMS\EditableFactory;

/**
 * Class Editable
 */
class Editable extends Model {
    /**
     * @var null
     */
    protected $model = null;

    /**
     * @var null
     */
    protected $field = null;


    /**
     * @return boolean
     */
    public function canEdit()

    {
        return auth()->user();
    }

    /**
     * @param string $field
     *
     * @return EditableFactory|mixed
     *
     */
    public function __get($field)
    {
        return new EditableFactory($this, $field, parent::__get($field));
    }
}
