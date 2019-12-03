<?php

namespace UniBen\CMS\Editables;

use UniBen\CMS\EditableFactory;

/**
 * Class Text
 * @package UniBen\CMS\Editables
 */
class Text extends EditableElement
{
    /**
     * Text constructor.
     *
     * @param EditableFactory $factory
     * @param string          $default
     * @param string          $tag
     * @param array           $attributes
     */
    public function __construct(EditableFactory $factory, $default = 'Please enter text.', $tag = null, $attributes = [])
    {
        parent::__construct($factory, $default, $tag, $attributes);
    }

    public function renderViewable(array $arr = []): string
    {
        return $this->tag || !empty($arr) ? parent::renderViewable($arr) : $this->value;
    }

    /**
     * @return string
     */
    public function renderEditable(): string
    {
        return $this->renderViewable($this->editableAttrArr(['contenteditable' => 'true']));
    }
}
