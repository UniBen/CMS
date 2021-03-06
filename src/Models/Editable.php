<?php namespace UniBen\CMS\Models;

use Exception;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Collection;
use Route;
use UniBen\CMS\EditableFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * Class Editable
 */
class Editable extends Model {
    /**
     * List of paths to exclude
     * @var array
     */
    protected $excluded = [];

    /**
     * Editable constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = []) {
        $this->with[] = 'editable';
        parent::__construct($attributes);
    }

    /**
     * @return MorphOne
     */
    public function editable()
    {
        return $this->morphOne(EditableData::class, 'editable');
    }

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
        $result = parent::__get($field);

        if (request()->is($this->excluded) || is_object($result) || is_iterable($result)) return $result;

        // If the value can't be found in the attributes array we try get it
        // from the editables column.
        if ($result === null) {
            /** @var EditableData $editableModel */
            if (isset($this->relations['editable']) && $editableModel = $this->relations['editable']) {
                $result = $editableModel->data[$field] ?? null;
            }
        }

        // There is a very slight performance hit here. A better way of going about
        // implementing this would be to fix casting in relations but there are
        // a lot and it seems difficult to maintain.
        $caller = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[1];

        return isset($caller['file']) && strpos($caller['file'], 'vendor/laravel/framework/src/Illuminate/View/Engines/PhpEngine.php') !== false
            ? new EditableFactory($this, $field, $result)
            : $result;
    }

    /**
     * @param string $key
     * @param mixed  $value
     */
    public function __set($key, $value)
    {
        if ($value instanceof EditableFactory) $value = $value->getValues()[0];
        parent::__set($key, $value);
    }
}
