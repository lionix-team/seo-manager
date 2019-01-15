<?php

namespace Lionix\SeoManager\Models;

use Illuminate\Database\Eloquent\Model;

class SeoManager extends Model
{
    protected $table;
    protected $locale;

    protected $fillable = [
        'uri',
        'params',
        'mapping',
        'keywords',
        'description',
        'title',
        'author',
        'url',
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
        $this->table = /** @scrutinizer ignore-call */config('seo-manager.database.table');
        $this->locale = /** @scrutinizer ignore-call */app()->getLocale();

        parent::__construct();
    }

    public function translation()
    {
        return $this->hasOne(Translate::class, 'route_id', 'id')->where('locale', /** @scrutinizer ignore-call */app()->getLocale());
    }

    private function isNotDefaultLocale()
    {
        return $this->locale !== /** @scrutinizer ignore-call */config('seo-manager.locale') && $this->has('translation');
    }

    public function getKeywordsAttribute($value)
    {
        if ($this->isNotDefaultLocale() && !empty(optional($this->translation)->keywords)) {
            return $this->translation->keywords;
        }
        return json_decode($value);
    }

    public function getDescriptionAttribute($value)
    {
        if ($this->isNotDefaultLocale() && !is_null(optional($this->translation)->description)) {
            return $this->translation->description;
        }
        return $value;
    }

    public function getTitleAttribute($value)
    {
        if ($this->isNotDefaultLocale() && !is_null(optional($this->translation)->title)) {
            return $this->translation->title;
        }
        return $value;
    }

    public function getAuthorAttribute($value)
    {
        if ($this->isNotDefaultLocale() && !is_null(optional($this->translation)->author)) {
            return $this->translation->author;
        }
        return $value;
    }

    public function getUrlAttribute($value)
    {
        if ($this->isNotDefaultLocale() && !is_null(optional($this->translation)->url)) {
            return $this->translation->url;
        }
        return $value;
    }

    public function getTitleDynamicAttribute($value)
    {
        if ($this->isNotDefaultLocale() && !empty(optional($this->translation)->title_dynamic)) {
            return $this->translation->title_dynamic;
        }
        return json_decode($value);
    }

    public function getOgDataAttribute($value)
    {
        if ($this->isNotDefaultLocale() && !is_null(optional($this->translation)->og_data)) {
            return $this->translation->og_data;
        }
        return json_decode($value, true);
    }

}
