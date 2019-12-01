<?php

namespace UniBen\CMS\Editables;

use UniBen\CMS\EditableFactory;

/**
 * Class Image
 * @package UniBen\CMS\Editables
 */
class Image extends EditableElement
{
    /**
     * Input constructor.
     *
     * @param EditableFactory $factory
     * @param string          $default
     * @param string          $tag
     * @param array           $attributes
     */
    public function __construct(EditableFactory $factory, $default = 'http://placeimg.com/640/360/any', $tag = null, $attributes = [])
    {
        parent::__construct($factory, $default, $tag, $attributes);
    }

    /**
     * @return string
     */
    public function renderEditable(): string
    {
        $default = $this->default;
        $attributes = $this->attributes;
        $values = $this->factory->getValues();
        $value = $values[0] ? $values[0] : $default;
        $json = json_decode($value);
        $images = collect($json ?? [['srcset' => $value]]);

        return $this->outputElement(
            $images->map(function($attributes, $i) {
                if ($i === 0) {
                    $element = 'img';
                    if (!isset($attributes['src']) && isset($attributes['srcset'])) {
                        $attributes['src'] = $attributes['srcset'];
                        unset($attributes['srcset']);
                    }
                } else {
                    $element = 'picture';
                }

                return $this->outputElement(null, $element, $attributes);
            })->implode(null, null),
            'picture',
            $attributes
        );
    }
}
