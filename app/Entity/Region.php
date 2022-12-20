<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int|null $parent_id
 *
 * @property Region $parent
 * @property Region[] $children
 */
class Region extends Model
{
    protected $fillable = ['name', 'slug', 'parent_id'];

    public function parent()
    {
        // laralearn по belongsTo будем напрямую связываться на parent_id по нашему id
        return $this->belongsTo(static::class, 'parent_id', 'id');
    }

    public function children()
    {
        // laralearn наоборот ищем по нашему id все такие parent_id
        return $this->hasMany(static::class, 'parent_id', 'id');
    }
}
