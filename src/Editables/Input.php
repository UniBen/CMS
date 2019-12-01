<?php

namespace UniBen\CMS\Editables;

use UniBen\CMS\EditableFactory;

/**
 * Class Input
 * @package UniBen\CMS\Editables
 */
class Input extends EditableElement
{
    /**
     * Input constructor.
     *
     * @param EditableFactory $factory
     * @param string          $default
     * @param string          $tag
     * @param array           $attributes
     */
    public function __construct(EditableFactory $factory, $default = 'Please enter placeholder text.', $tag = 'text', $attributes = [])
    {
        parent::__construct($factory, $default, $tag, $attributes);
    }

    public function renderEditable(): string
    {
        return $this->renderViewable($this->editableAttrArr());
    }

    /**
     * @param array|null $arr
     *
     * @return string
     */
    public function renderViewable(array $arr = []): string
    {
        return $this->outputElement(
            null,
            'input',
            array_merge($this->attributes, $arr, ['placeholder' => $this->default, 'type' => $this->tag]),
            true
        );
    }
}
