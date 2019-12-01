<?php

namespace UniBen\CMS\Contracts;

interface EditableElement
{
    public function render() : string;
    public function handleUpdate() : bool;
}
