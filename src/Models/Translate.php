<?php

namespace Lionix\SeoManager\Models;

use Illuminate\Database\Eloquent\Model;

class Translate extends Model
{
    protected $table;

    protected $casts = [
        'keywords' => 'array',
        'title_dynamic' => 'array',
        'og_data' => 'array',
    ];

    public function __construct()
    {
        $this->table = /** @scrutinizer ignore-call */config('seo-manager.database.translates_table');

        parent::__construct();
    }
}
