<?php

namespace UniBen\CMS\Contracts;

use Illuminate\Support\HtmlString;

interface EditableElement
{
    public function render() : HtmlString;
    public function handleUpdate() : bool;
}
