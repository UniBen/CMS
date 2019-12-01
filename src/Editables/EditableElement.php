<?php

namespace UniBen\CMS\Editables;

use UniBen\CMS\EditableFactory;
use UniBen\CMS\Contracts\EditableElement as EditableElementContract;

/**
 * Class EditableElement
 * @package UniBen\CMS\Editables
 */
class EditableElement implements EditableElementContract {
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
        return $this->renderViewable([
            'data-editable' => $this->factory->intent()->getID(),
            'class' => 'editable',
            'contenteditable' => 'true'
        ]);
    }

    /**
     * @param array|null $arr
     *
     * @return mixed
     */
    public function renderViewable(array $arr = []) : string
    {
        $tag = $this->tag;
        $attributes = $this->attributes;
        if (is_array($tag)) {
            $attributes = $tag;
            $tag = 'p';
        }

        return $this->outputElement(
            $this->factory->getValues()[0] ?? $this->default,
            $tag,
            array_merge($attributes, $arr)
        );
    }

    /**
     * @return bool
     */
    public function handleUpdate() : bool
    {
        return true;
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
