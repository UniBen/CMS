<?php namespace UniBen\CMS;

use Illuminate\Support\HtmlString;
use UniBen\CMS\Editables\EditableElement;
use UniBen\CMS\Editables\Editor;
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
     * @return HtmlString|string
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
     * @return EditableElement|string
     */
    protected function editable($default = null, $tag = 'span', $attributes = []) : EditableElement
    {
        return new EditableElement($this, $default, $tag, $attributes);
    }

    /**
     * @param string $default
     * @param string $tag
     * @param array  $attributes
     *
     * @return Title|string
     */
    public function title($default = 'Please enter a title.', $tag = 'h1', $attributes = []) : Title
    {
        return new Title($this, $default, $tag, $attributes);
    }

    /**
     * @param string $default
     * @param string $tag
     * @param array  $attributes
     *
     * @return Text|string
     */
    public function text($default = 'Please enter text.', $tag = 'span', $attributes = []) : Text
    {
        return new Text($this, $default, $tag, $attributes);
    }

    /**
     * @param string $default
     * @param string $tag
     * @param array  $attributes
     *
     * @return Editor|string
     */
    public function editor($default = 'Please enter text.', $tag = 'div', $attributes = []) : Editor
    {
        return new Editor($this, $default, $tag, $attributes);
    }

    /**
     * @param string $default
     * @param string $tag
     * @param array  $attributes
     *
     * @return Input|string
     */
    public function input($default = 'Please enter placeholder text.', $tag = 'text', $attributes = []) : Input
    {
        return new Input($this, $default, $tag, $attributes);
    }

    /**
     * @param string|array $default
     * @param array  $attributes
     *
     * @return Image|string
     */
    public function image($default = 'http://placeimg.com/640/360/any', $attributes = []) : Image
    {
        return new Image($this, $default, null, $attributes);
    }

    /**
     * @param string|array $default
     * @param string $tag
     * @param array  $attributes
     *
     * @return Video|string
     */
    public function video($default = 'https://www.w3schools.com/html/mov_bbb.mp4', $tag = 'text', $attributes = []) : Video
    {
        return new Video($this, $default, $tag, $attributes);
    }

    /**
     * @return mixed
     */
    public function __toString()
    {
        return (string) $this->values[0] ?? '';
    }
}
