<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectResource extends Model
{
    use HasFactory;

    const RESOURCE_TYPE_WEB = 1;
    const RESOURCE_TYPE_API = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'project_id',
        'type_id',
        'name',
        'method',
        'endpoint',
        'uptime',
        'settings',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'uptime' => 'float',
        'settings' => 'array',
        'checked_at' => 'datetime',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'method' => 'GET',
        'uptime' => 100,
        'settings' => '[]',
    ];

    /**
     * @return string
     */
    public function getTypeNameAttribute() : string
    {
        switch($this->type_id) {
            case self::RESOURCE_TYPE_WEB:
                return 'Web';

            case self::RESOURCE_TYPE_API:
                return 'API';

            default:
                return '-';
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project() : \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
