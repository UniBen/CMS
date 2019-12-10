<?php

namespace UniBen\CMS\Models;

use Illuminate\Database\Eloquent\Model;

class EditableData extends Model
{
    protected $table = 'editables';

    protected $fillable = ['data'];

    protected $casts = ['data' => 'json'];
}
