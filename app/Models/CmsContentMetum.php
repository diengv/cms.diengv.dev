<?php

namespace App\Models;

use App\Traits\MultiTenantModelTrait;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CmsContentMetum extends Model
{
    use SoftDeletes, MultiTenantModelTrait, HasFactory;

    public $table = 'cms_content_meta';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'value',
        'type',
        'post_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'team_id',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function post()
    {
        return $this->belongsTo(CmsPost::class, 'post_id');
    }

    public function assets()
    {
        return $this->belongsToMany(Asset::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }
}
