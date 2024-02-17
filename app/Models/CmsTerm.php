<?php

namespace App\Models;

use App\Traits\MultiTenantModelTrait;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CmsTerm extends Model
{
    use SoftDeletes, MultiTenantModelTrait, HasFactory;

    public $table = 'cms_terms';

    public static $searchable = [
        'name',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'team_id',
        'name',
        'slug',
        'term_group',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function termCmsTermTaxonomies()
    {
        return $this->hasMany(CmsTermTaxonomy::class, 'term_id', 'id');
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }
}
