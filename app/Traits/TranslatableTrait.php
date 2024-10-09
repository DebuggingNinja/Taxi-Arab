<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait TranslatableTrait
{

    public function translations()
    {
        return $this->hasMany($this->translationTable, $this->foreignKeyColumn);
    }
    public function translation()
    {
        return $this->hasOne($this->translationTable, $this->foreignKeyColumn);
    }
    protected static function bootTranslatableTrait()
    {

        static::addGlobalScope('getLanguage', function (Builder $builder) {
            $currentLanguages = session('language') ?? session('language', 'en');

            $builder->with(['translation' => function ($query) use ($currentLanguages) {
                $query->where('language', $currentLanguages)
                    ->withTrashed();
            }]);
        });
    }

    public function scopegetAllTranslations($query)
    {

        return $query->withoutGlobalScope('getLanguage')->with('translations');
    }
}
