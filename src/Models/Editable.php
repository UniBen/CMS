<?php namespace UniBen\CMS\Models;

use Illuminate\Database\Eloquent\Builder;
use UniBen\CMS\EditableFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

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
        $b = $result = parent::__get($field);


        if (!$result && isset($this->getAttributeValue('_editables')[$field])) {
            $a = $result = $this->getAttributeValue('_editables')[$field];
        }

        $caller = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[1];

        $f = !(isset($caller['class']) && (
            is_a($caller['class'], Relation::class, true) ||
            is_a($caller['class'], Model::class, true)
        ))
            ? new EditableFactory($this, $field, $result)
            : $result;

        return $f;
    }

    /**
     * @param string $key
     * @param mixed  $value
     */
    public function __set($key, $value)
    {
        parent::__set($key, $value);
    }
}
