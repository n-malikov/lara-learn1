<?php

namespace App\Entity\Adverts;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $category_id
 * @property string $name
 * @property string $type
 * @property string $default
 * @property boolean $required
 * @property array $variants
 * @property integer $sort
 */
class Attribute extends Model
{
    public const TYPE_STRING = 'string';
    public const TYPE_INTEGER = 'integer';
    public const TYPE_FLOAT = 'float';

    protected $table = 'advert_attributes';

    public $timestamps = false;

    protected $fillable = ['name', 'type', 'required', 'default', 'variants', 'sort'];

    protected $casts = [
        'variants' => 'array', // laralearn переопределяем тип, с которым доставать из БД и сохранять туда
    ];

    public static function typesList(): array
    {
        return [
            self::TYPE_STRING  => 'String',
            self::TYPE_INTEGER => 'Integer',
            self::TYPE_FLOAT   => 'Float',
        ];
    }

}
