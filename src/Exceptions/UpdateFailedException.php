<?php

namespace UniBen\CMS\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\Model;
use UniBen\CMS\Models\Editable;

/**
 * Class UpdateFailedException
 * @package UniBen\CMS\Exceptions
 */
class UpdateFailedException extends Exception {
    /**
     * @var Model
     */
    protected $model;

    /**
     * @var array
     */
    protected $data;

    /**
     * @var string
     */
    protected $intent;

    /**
     * @return Editable
     */
    public function getModel(): Editable
    {
        return $this->model;
    }

    /**
     * @param Editable $model
     */
    public function setModel(Model $model): self
    {
        $this->model = $model;
        return $this;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data): self
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return string
     */
    public function getIntent(): string
    {
        return $this->intent;
    }

    /**
     * @param string $intent
     */
    public function setIntent(string $intent): self
    {
        $this->intent = $intent;
        return $this;
    }
}
