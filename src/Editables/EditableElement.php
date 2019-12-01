<?php namespace UniBen\CMS\Editables;

use UniBen\CMS\EditableFactory;

/**
 * Class EditableElement
 * @package UniBen\CMS\Editables
 */
class EditableElement {
    /**
     * @var EditableFactory
     */
    protected $factory;

    /**
     * @var null
     */
    protected $default;

    /**
     * @var string
     */
    protected $tag;

    /**
     * @var array
     */
    protected $attributes;

    /**
     * EditableElement constructor.
     *
     * @param EditableFactory $factory
     * @param string|null     $default
     * @param string          $tag
     * @param array           $attributes
     */
    public function __construct(EditableFactory $factory, $default = null, $tag = 'div', $attributes = [])
    {
        $this->factory = $factory;
        $this->default = $default;
        $this->tag = $tag;
        $this->attributes = $attributes;
    }

    /**
     * @return string
     */
    public function render() : string
    {
        return $this->factory->getModel()->canEdit()
            ? $this->renderEditable()
            : $this->renderViewable();
    }

    /**
     * @return string
     */
    public function renderEditable() : string
    {
        $tag = $this->tag;
        $attributes = $this->attributes;
        if (is_array($tag)) {
            $attributes = $tag;
            $tag = 'p';
        }

        return $this->outputElement(
            $this->outputElement(
                $this->factory->getValues()[0] ?? $this->default,
                'span',
                ['class' => 'editable_content', 'contenteditable' => 'true']
            ),
            $tag,
            array_merge($attributes, ['data-editable' => $this->factory->intent()->getID()])
        );
    }

    /**
     * @return mixed
     */
    public function renderViewable() : string
    {
        return (string) $this->factory->getValues()[0];
    }

    /**
     *
     */
    public function handleUpdate()
    {
        // Todo
    }

    /**
     * @param $attributes
     *
     * @return string
     */
    public function outputArgs($attributes) : string
    {
        return collect($attributes)
            ->map(function($value, $key) {
                return is_int($key) ? $value : "$key='$value'";
            })
            ->implode(' ');
    }

    /**
     * @param null   $value
     * @param string $tag
     * @param array  $attributes
     * @param bool   $isSingleton
     *
     * @return string
     */
    public function outputElement($value = null, $tag = 'div', $attributes = [], $isSingleton = false) : string
    {
        return "<$tag {$this->outputArgs($attributes)}" . ($isSingleton ? "/>" : ">$value</$tag>");
    }
}
