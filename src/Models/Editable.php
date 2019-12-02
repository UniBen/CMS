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
        return !auth()->user();
    }

    /**
     * @param string $field
     *
     * @return EditableFactory|mixed
     *
     */
    public function __get($field)
    {
        // If value not found via parent get check content.{field} if there is
        // a consent column and is json.
        return new EditableFactory($this, $field, parent::__get($field));
    }

    /**
     * @param string $key
     * @param mixed  $value
     */
    public function __set($key, $value)
    {
        // If the field is not in attributes array and their is content column
        // which casts to json then insert the value in to that.
        parent::__set($key, $value);
    }
}
