<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasImages;

class Skill extends Model
{
    use HasFactory, HasImages;

    protected $fillable = [
        'skill_category_id',
        'name',
        'level',
        'icon',
    ];

    protected $casts = [
        'level' => 'integer',
    ];

   // Correct MongoDB relation
    public function category()
    {
        return $this->belongsTo(SkillCategory::class, 'skill_category_id', '_id')
                    ->withDefault([
                        'id' => null,
                        'name' => 'Uncategorized',
                    ]);
    }
}
