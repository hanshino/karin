<?php

namespace App\Models\Line;

use Database\Factories\Line\GroupFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'group_id',
        'name',
        'count',
        'picture_url',
    ];

    protected static function newFactory()
    {
        return GroupFactory::new();
    }
}
