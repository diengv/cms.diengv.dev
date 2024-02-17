<?php

namespace App\Models;

use App\Traits\MultiTenantModelTrait;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CmsTermRelationship extends Model
{
    use SoftDeletes, MultiTenantModelTrait, HasFactory;

    public $table = 'cms_term_relationships';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'object',
        'term_taxonomy_id',
        'term_order',
        'created_at',
        'updated_at',
        'deleted_at',
        'team_id',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function term_taxonomy()
    {
        return $this->belongsTo(CmsTermTaxonomy::class, 'term_taxonomy_id');
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }
}
