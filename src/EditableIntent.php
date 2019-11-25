<?php namespace UniBen\CMS;

use Illuminate\Encryption\Encrypter;

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
        $encrypted = (openssl_encrypt(json_encode([[
            'model_name' => get_class($this->factory->getModel()),
            'model_key' => $this->factory->getModel()->getQualifiedKeyName(),
            'model_id' => $this->factory->getModel()->getKey()
        ]]), 'aes-128-ctr', 'key'));

        print $encrypted;


    }
}
