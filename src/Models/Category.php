<?php

namespace SBD\Softbd\Models;

use Illuminate\Database\Eloquent\Model;
use SBD\Softbd\Facades\Softbd;
use SBD\Softbd\Traits\Translatable;

class Category extends Model
{
    use Translatable;

    protected $translatable = ['name'];

    protected $table = 'categories';

    protected $fillable = ['slug', 'name'];

    public function posts()
    {
        return $this->hasMany(Softbd::modelClass('Post'))
            ->published()
            ->orderBy('created_at', 'DESC');
    }

    public function parentId()
    {
        return $this->belongsTo(self::class);
    }
}
