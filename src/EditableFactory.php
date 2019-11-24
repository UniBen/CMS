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
     * @var array
     */
    protected $values = [];

    /**
     * EditableFactory constructor.
     *
     * @param array $values
     */
    public function __construct($model, ...$values)
    {
        $this->$model = $model;
        $this->values = $values;
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
