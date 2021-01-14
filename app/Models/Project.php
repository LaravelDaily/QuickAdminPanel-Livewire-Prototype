<?php

namespace App\Models;

use \DateTimeInterface;
use App\Support\HasAdvancedFilter;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Project extends Model implements HasMedia
{
    use SoftDeletes;
    use HasFactory;
    use InteractsWithMedia;
    use HasAdvancedFilter;

    public const TYPE_RADIO = [
        'type1' => 'Type 1',
        'type2' => 'Type 2',
        'type3' => 'Type 3',
    ];

    public const CATEGORY_SELECT = [
        'category1' => 'Category 1',
        'category2' => 'Category 2',
        'category3' => 'Category 3',
    ];

    public $table = 'projects';

    public $orderable = [
        'id',
        'name',
        'type',
        'category',
        'is_active',
        'price',
        'author.name',
    ];

    protected $filterable = [
        'name',
        'description',
        'type',
        'category',
        'author.name',
        'participants.name',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
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
        'birthday',
        'birthtime',
        'datetime',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function participants()
    {
        return $this->belongsToMany(User::class);
    }

    public function getBirthdayAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setBirthdayAttribute($value)
    {
        $this->attributes['birthday'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getDatetimeAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.datetime_format')) : null;
    }

    public function setDatetimeAttribute($value)
    {
        $this->attributes['datetime'] = $value ? Carbon::createFromFormat(config('panel.datetime_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function getDocumentsAttribute()
    {
        return $this->getMedia('someXcollection')->map(function ($item) {
            $media = $item->toArray();
            $media['url'] = $item->getUrl();

            return $media;
        });
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
