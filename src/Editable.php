<?php namespace UniBen\CMS;

use Illuminate\Database\Eloquent\Model;

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
     * @param string $field
     *
     * @return EditableFactory|mixed
     */
    public function __get($field)
    {
        return new EditableFactory($this, $field, $this->attributes[$field]);
    }
}
