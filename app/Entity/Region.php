<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int|null $parent_id
 *
 * @property Region $parent
 * @property Region[] $children
 *
 * @method Builder roots()
 */
class Region extends Model
{
    protected $fillable = ['name', 'slug', 'parent_id'];

    public function getAddress(): string
    {
        // рекурсия:
        return ($this->parent ? $this->parent->getAddress() . ', ' : '') . $this->name;
    }

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

    public function scopeRoots(Builder $query)
    {
        // нужен под метод roots()
        return $query->where('parent_id', null);
    }
}
