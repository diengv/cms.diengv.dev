<?php

namespace App\Models;

use App\Traits\MultiTenantModelTrait;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CmsContenType extends Model
{
    use SoftDeletes, MultiTenantModelTrait, HasFactory;

    public $table = 'cms_conten_types';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'description',
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

    public function typeCmsPosts()
    {
        return $this->hasMany(CmsPost::class, 'type_id', 'id');
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
