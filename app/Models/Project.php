<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Project extends Model implements HasMedia
{
    use SoftDeletes, HasFactory, InteractsWithMedia;

    public $table = 'projects';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const TYPE_RADIO = [
        'type1' => 'Type 1',
        'type2' => 'Type 2',
        'type3' => 'Type 3',
    ];

    const CATEGORY_SELECT = [
        'category1' => 'Category 1',
        'category2' => 'Category 2',
        'category3' => 'Category 3',
    ];

    protected $casts = [
        'birthday' => 'datetime:Y-m-d',
        'birthtime' => 'datetime:H:i:s',
        'datetime' => 'datetime:Y-m-d H:i:s',
    ];

    protected $fillable = [
        'name',
        'description',
        'type',
        'category',
        'is_active',
        'price',
        'author_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function participants()
    {
        return $this->belongsToMany(User::class);
    }
}
