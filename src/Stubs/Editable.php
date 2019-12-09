<?php namespace UniBen\CMS\Stubs;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        '_editables'
    ];

    protected $with = [
        'parent',
        'others',
    ];

    /**
     * @var array
     */
    protected $casts = [
        '_editables' => 'json'
    ];

    /**
     * @return BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(Editable::class);
    }

    public function others()
    {
        return $this->morphTo();
    }
}
