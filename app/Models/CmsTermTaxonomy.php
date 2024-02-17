<?php

namespace App\Models;

use App\Traits\MultiTenantModelTrait;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class CmsTermTaxonomy extends Model implements HasMedia
{
    use SoftDeletes, MultiTenantModelTrait, InteractsWithMedia, HasFactory;

    public $table = 'cms_term_taxonomies';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'term_id',
        'taxonomy_id',
        'description',
        'parent_id',
        'count',
        'created_at',
        'image_id',
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

    public function parentCmsTermTaxonomies()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    public function termTaxonomyCmsTermRelationships()
    {
        return $this->hasMany(CmsTermRelationship::class, 'term_taxonomy_id', 'id');
    }

    public function term()
    {
        return $this->belongsTo(CmsTerm::class, 'term_id');
    }

    public function taxonomy()
    {
        return $this->belongsTo(CmsTaxonomy::class, 'taxonomy_id');
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function image()
    {
        return $this->belongsTo(Asset::class, 'image_id');
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }
}
