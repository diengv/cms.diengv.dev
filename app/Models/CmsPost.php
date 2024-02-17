<?php

namespace App\Models;

use App\Traits\MultiTenantModelTrait;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class CmsPost extends Model implements HasMedia
{
    use SoftDeletes, MultiTenantModelTrait, InteractsWithMedia, HasFactory;

    public $table = 'cms_posts';

    public static $searchable = [
        'post_title',
    ];

    protected $dates = [
        'post_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const COMMENT_STATUS_RADIO = [
        'open'  => 'Open',
        'close' => 'Close',
        'login' => 'Login',
    ];

    public const POST_STATUS_SELECT = [
        'publish' => 'Publish',
        'draft'   => 'Draft',
        'pending' => 'Pending',
    ];

    protected $fillable = [
        'type_id',
        'post_title',
        'post_name',
        'post_content',
        'post_date',
        'post_excerpt',
        'post_status',
        'comment_status',
        'post_password',
        'created_at',
        'thumbnail_id',
        'updated_at',
        'deleted_at',
        'team_id',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function postCmsContentMeta()
    {
        return $this->hasMany(CmsContentMetum::class, 'post_id', 'id');
    }

    public function type()
    {
        return $this->belongsTo(CmsContenType::class, 'type_id');
    }

    public function getPostDateAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setPostDateAttribute($value)
    {
        $this->attributes['post_date'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function thumbnail()
    {
        return $this->belongsTo(Asset::class, 'thumbnail_id');
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }
}
