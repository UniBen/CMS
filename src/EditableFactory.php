<?php namespace UniBen\CMS;

use Illuminate\Database\Eloquent\Model;

/**
 * Class EditableFactory
 */
class EditableFactory {
    /**
     * @var Model
     */
    protected $model;

    /**
     * @var string
     */
    protected $field;

    /**
     * @var array
     */
    protected $values = [];

    /**
     * EditableFactory constructor.
     *
     * @param Model  $model
     * @param string $field
     * @param array  $values
     */
    public function __construct($model, $field, ...$values)
    {
        $this->model = $model;
        $this->field = $field;
        $this->values = $values;
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
     * @return array
     */
    public function getValues(): array
    {
        return $this->values;
    }

    /**
     * @param string $tag
     * @param array  $attributes
     *
     * @return string
     */
    public function title($tag = 'p', $attributes = []) : string
    {
        $attributes = collect($attributes);
        $intent = new EditableIntent($this);
        $intent->getID();
        return "<$tag ". $attributes->map(function($value, $key) { return "$key='$value'"; })->implode(' ') . ">{$this->values[0]}</$tag>";
    }

    /**
     * @param string $tag
     * @param array  $attributes
     *
     * @return string
     */
    public function text($tag = 'p', $attributes = []) : string
    {
        return "<$tag ". implode('', array_map(function($key, $value) { return "$key='$value'"; }, $attributes)) . ">{$this->values[0]}</$tag>";
    }

    /**
     * @return string
     */
    public function media() : string
    {

    }

    /**
     * @return string
     */
    public function image() : string
    {

    }

    /**
     * @return string
     */
    public function video() : string
    {

    }

    /**
     * @return string
     */
    public function __toString() : string
    {
        return $this->values[0];
    }
}
