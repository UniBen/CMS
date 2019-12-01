<?php namespace UniBen\CMS;

/**
 * Class EditableIntent
 */
class EditableIntent {
    /**
     * @var EditableFactory
     */
    protected $factory;

    /**
     * EditableIntent constructor.
     *
     * @param EditableFactory $factory
     */
    public function __construct(EditableFactory $factory)
    {
        $this->factory = $factory;
    }

    public function getID()
    {
        return base64_encode(json_encode([
            'm' => get_class($this->factory->getModel()),
            'i' => $this->factory->getModel()->getKey(),
            'f' => $this->factory->getField()
        ]));
    }
}
