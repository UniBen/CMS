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
}
