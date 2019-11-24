<?php namespace UniBen\CMS;

use Illuminate\Database\Eloquent\Model;

/**
 * Class EditableIntent
 */
class EditableIntent {
    /**
     * @var Model
     */
    protected $model;
    /**
     * @var string
     */
    protected $field;
    /**
     * @var null
     */
    protected $value;

    /**
     * EditableIntent constructor.
     *
     * @param $model
     * @param $field
     * @param $value
     */
    public function __construct(Model $model, string $field, $value = null)
    {
        $this->model = $model;
        $this->field = $field;
        $this->value = $value;
    }

    /**
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * @return string
     */
    public function getField(): string
    {
        return $this->field;
    }

    /**
     * @return null
     */
    public function getValue()
    {
        return $this->value;
    }
}
