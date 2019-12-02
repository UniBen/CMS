<?php

namespace UniBen\CMS\Editables;

use Illuminate\Support\Arr;
use UniBen\CMS\EditableFactory;
use Illuminate\Contracts\Support\Htmlable;
use UniBen\CMS\Contracts\EditableElement as EditableElementContract;

/**
 * Class EditableElement
 * @package UniBen\CMS\Editables
 */
class EditableElement implements EditableElementContract, Htmlable {
    /**
     * @var EditableFactory
     */
    protected $factory;

    /**
     * @var string|null
     */
    protected $default;

    /**
     * @var string|null
     */
    protected $value;

    /**
     * @var string
     */
    protected $tag;

    /**
     * @var array
     */
    protected $attributes;

    /**
     * @var array
     */
    private $rules;

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
        $this->value = $this->factory->getValues()[0] ?? $this->default;
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
        return $this->renderViewable($this->editableAttrArr());
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
            $this->value,
            $tag,
            $this->mergeAttributes($attributes, $arr)
        );
    }

    /**
     * Rules
     *
     * @param array $rules
     */
    public function rules(array $rules = [])
    {
        $this->rules = $rules;
    }

    /**
     * @return bool
     */
    public function handleUpdate() : bool
    {
        return true;
    }

    /**
     * @param array $arr
     *
     * @return array
     */
    public function editableAttrArr(array $arr = [])
    {
        return $this->mergeAttributes([
            'data-editable' => $this->factory->intent()->getID(),
            'data-editable-field' => $this->factory->getField(),
            'data-editable-type' => get_called_class(),
            'class' => 'editable'
        ], $arr);
    }

    /**
     * @param mixed ...$arrays
     *
     * @return array
     */
    public function mergeAttributes(...$arrays)
    {
        $stringMerges =  ['class'];
        $mergedStrings = [];

        foreach ($stringMerges as $key) {
            $mergedStrings[$key] = implode(' ', Arr::pluck($arrays, $key));

            foreach ($arrays as &$array) {
                unset($array[$key]);
            }
        }

        return array_merge($mergedStrings, ...$arrays);
    }

    /**
     * @param $attributes
     *
     * @return string
     */
    public function outputAttributes($attributes) : string
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
        return "<$tag {$this->outputAttributes($attributes)}" . ($isSingleton ? "/>" : ">$value</$tag>");
    }

    /**
     * Get content as a string of HTML.
     * @return string
     */
    public function toHtml()
    {
        return $this->render();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }
}
