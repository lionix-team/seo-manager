<?php

namespace Lionix\SeoManager\Models;

use Illuminate\Database\Eloquent\Model;

class SeoManager extends Model
{
    protected $table;

    protected $fillable = [
        'uri',
        'params',
        'mapping',
        'keywords',
        'description',
        'title',
        'author',
        'title_dynamic',
        'og_data'
    ];

    protected $casts = [
        'params' => 'array',
        'mapping' => 'array',
        'keywords' => 'array',
        'title_dynamic' => 'array',
        'og_data' => 'array',
    ];

    public function __construct()
    {
        $this->table = config('seo-manager.database.table');

        parent::__construct();
    }
}
