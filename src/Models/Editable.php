<?php namespace UniBen\CMS\Models;

use Illuminate\Database\Eloquent\Relations\MorphOne;
use UniBen\CMS\EditableFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * Class Editable
 */
class Editable extends Model {
    /**
     * Editable constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
        $this->with[] = 'editable';
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
        $result = parent::__get($field);

        // If the value can't be found in the attributes array we try get it
        // from the editables column.
        if (!$result) {
            /** @var EditableData $editableModel */
            if ($editableModel = $this->getRelationValue('editable')) {
                $result = $editableModel->data[$field] ?? null;
            }
        }

        // There is a very slight performance hit here. A better way of going about
        // implementing this would be to fix casting in relations but there are
        // a lot and it seems difficult to maintain.
        $caller = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[1];

        // Note on performance. is_a is 54.98% slower than instance of however,
        // instanceof would require and actual instantiation and not a string.
        return !(isset($caller['class']) && (
                is_a($caller['class'], Relation::class, true) ||
                is_a($caller['class'], Model::class, true)
            ))
            ? new EditableFactory($this, $field, $result)
            : $result;
    }
}
