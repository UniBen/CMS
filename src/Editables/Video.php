<?php

namespace UniBen\CMS\Editables;

use Exception;
use UniBen\CMS\EditableFactory;

/**
 * Class Video
 * @package UniBen\CMS\Editables
 */
class Video extends EditableElement
{
    /**
     * Input constructor.
     *
     * @param EditableFactory $factory
     * @param string          $default
     * @param string          $tag
     * @param array           $attributes
     */
    public function __construct(EditableFactory $factory, $default = 'https://www.w3schools.com/html/mov_bbb.mp4', $tag = 'text', $attributes = [])
    {
        parent::__construct($factory, $default, $tag, $attributes);
    }

    /**
     * @return string
     * @throws Exception
     */
    public function renderEditable(): string
    {
        return $this->outputElement(
            $this->renderViewable(),
            'div',
            $this->editableAttrArr()
        );
    }

    /**
     * @param array|null $arr
     *
     * @return string
     * @throws Exception
     */
    public function renderViewable(array $arr = []): string
    {
        $default = $this->default;
        $attributes = $this->attributes;
        $sources = collect();

        if (is_array($default)) {
            $sources->push(...$default);
        } else if (is_string($default)) {
            $sources->push(['src' => $default, 'type' => pathinfo($default, PATHINFO_EXTENSION)]);
        } else {
            throw new \Exception('The value must be of type string or array.');
        }

        return $this->outputElement(
            $sources->map(function($video) {
                return $this->outputElement(null, 'source', $video);
            })->implode(null, null),
            'video',
            array_merge($attributes, ['controls'])
        );
    }
}
