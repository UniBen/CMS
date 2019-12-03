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
     * @var array
     */
    protected $fillable = ['_editables'];

    /**
     * @return boolean
     */
    public function canEdit()

    {
        return !auth()->user();
    }

    /**
     * @param array $data
     *
     * @return array
     */
    public function transform(array $data = [])
    {
        return array_merge(
            array_intersect_key($data, array_flip($this->fillable)),
            ['_editables' => array_diff_key($data, array_flip($this->fillable))]
        );
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
        $result = parent::__get($field);

        if (!$result && $this->getAttributeValue('_editables')[$field]) {
            $result = $this->getAttributeValue('_editables')[$field];
        }

        return new EditableFactory($this, $field, $result);
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
