<?php namespace UniBen\CMS;

use UniBen\CMS\Editables\EditableElement;
use UniBen\CMS\Editables\Image;
use UniBen\CMS\Editables\Input;
use UniBen\CMS\Editables\Text;
use UniBen\CMS\Editables\Title;
use UniBen\CMS\Editables\Video;
use UniBen\CMS\Models\Editable;

/**
 * Class EditableFactory
 */
class EditableFactory {
    /**
     * @var Editable
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
     * @param Editable  $model
     * @param string $field
     * @param array  $values
     */
    public function __construct(Editable $model, string $field, ...$values)
    {
        $this->model = $model;
        $this->field = $field;
        $this->values = $values;
    }

    /**
     * @return Editable
     */
    public function getModel(): Editable
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
     * @return EditableIntent
     */
    public function intent()
    {
        return new EditableIntent($this);
    }

    /**
     * @param string $default
     * @param string $tag
     * @param array  $attributes
     *
     * @return string
     */
    protected function editable($default = null, $tag = 'div', $attributes = []) : string
    {
        return (new EditableElement($this, $default, $tag, $attributes))->render();
    }

    /**
     * @param string $default
     * @param string $tag
     * @param array  $attributes
     *
     * @return string
     */
    public function title($default = 'Please enter a title.', $tag = 'h1', $attributes = []) : string
    {
        return (new Title($this, $default, $tag, $attributes))->render();
    }

    /**
     * @param string $default
     * @param string $tag
     * @param array  $attributes
     *
     * @return string
     */
    public function text($default = 'Please enter text.', $tag = 'p', $attributes = []) : string
    {
        return (new Text($this, $default, $tag, $attributes))->render();
    }

    /**
     * @param string $default
     * @param string $tag
     * @param array  $attributes
     *
     * @return string
     */
    public function input($default = 'Please enter placeholder text.', $tag = 'text', $attributes = []) : string
    {
        return (new Input($this, $default, $tag, $attributes))->render();
    }

    /**
     * @param string $default
     * @param array  $attributes
     *
     * @return string
     */
    public function image($default = 'http://placeimg.com/640/360/any', $attributes = []) : string
    {
        return (new Image($this, $default, null, $attributes))->render();
    }

    /**
     * @param string $default
     * @param string $tag
     * @param array  $attributes
     *
     * @return string
     */
    public function video($default = 'https://www.w3schools.com/html/mov_bbb.mp4', $tag = 'text', $attributes = []) : string
    {
        return (new Video($this, $default, $tag, $attributes))->render();
    }

    /**
     * @return string
     */
    public function __toString() : string
    {
        return $this->values[0];
    }
}
