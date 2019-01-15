<?php

namespace Lionix\SeoManager\Models;

use Illuminate\Database\Eloquent\Model;

class Locale extends Model
{
    protected $table;

    protected $fillable = ['name'];

    public function __construct()
    {
        $this->table = /** @scrutinizer ignore-call */config('seo-manager.database.locales_table');

        parent::__construct();
    }
}
