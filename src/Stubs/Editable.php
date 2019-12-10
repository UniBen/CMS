<?php namespace UniBen\CMS\Stubs;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use UniBen\CMS\Models\Editable as BaseEditable;
use UniBen\CMS\EditableFactory;

/**
 * Class Editable
 *
 * @property EditableFactory $name
 * @property EditableFactory $content
 */
class Editable extends BaseEditable
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'content',
    ];
    /**
     * @var array
     */
    protected $with = [
        'parent',
        'others',
    ];

    /**
     * @return BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(Editable::class);
    }

    /**
     * @return MorphTo
     */
    public function others()
    {
        return $this->morphTo();
    }
}
