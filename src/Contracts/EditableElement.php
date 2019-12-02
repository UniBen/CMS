<?php

namespace UniBen\CMS\Contracts;

use Illuminate\Support\HtmlString;

interface EditableElement
{
    public function render() : string;
    public function handleUpdate() : bool;
}
