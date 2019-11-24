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
     * @param string $name
     *
     * @return EditableFactory|mixed
     */
    public function __get($name)
    {
        return new EditableFactory($this, $name, $this->attributes[$name]);
    }
}
