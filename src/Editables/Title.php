<?php

namespace UniBen\CMS\Editables;

use UniBen\CMS\EditableFactory;

/**
 * Class Title
 * @package UniBen\CMS\Editables
 */
class Title extends EditableElement
{
    /**
     * Title constructor.
     *
     * @param EditableFactory $factory
     * @param string          $default
     * @param string          $tag
     * @param array           $attributes
     */
    public function __construct(EditableFactory $factory, $default = 'Please enter a title.', $tag = 'h1', $attributes = [])
    {
        parent::__construct($factory, $default, $tag, $attributes);
    }

    /**
     * @return string
     */
    public function renderEditable(): string
    {
        return $this->renderViewable($this->editableAttrArr(['contenteditable' => 'true']));
    }

    public function renderViewable(array $arr = []): string
    {
        $tag = $this->tag;
        $attributes = $this->attributes;
        if (is_array($tag)) {
            $attributes = $tag;
            $tag = 'p';
        }

        return $this->outputElement(
            e($this->factory->getValues()[0] ?? $this->default),
            $tag,
            array_merge($attributes, $arr)
        );
    }
}
