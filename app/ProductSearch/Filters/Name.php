<?php

namespace App\ProductSearch\Filters;

use Illuminate\Database\Eloquent\Builder;

class Name implements Filter
{
    /**
     * Apply a given search value to the builder instance.
     *
     * @param Builder $builder
     * @param mixed $value
     * @return Builder $builder
     */
    public static function apply(Builder $builder, $value)
    {
        $altValue = static::stringToRegExp($value);

        return $builder->where(function (Builder $query) use ($value, $altValue) {
            $query->where('name', 'LIKE', '%'.$value.'%')
                ->orWhereHas('category', function(Builder $q) use($value) {
                    $q->where('name', 'LIKE', '%'.$value.'%');
            })
                ->orWhere('name', 'RLIKE', $altValue);
        });
    }

    private static function stringToRegExp($string) {
        //Lower case everything
        $string = strtolower($string);
        //Make alphanumeric (removes all other characters)
        $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
        //Clean up multiple dashes or whitespace
        $string = preg_replace("/[\s-]+/", " ", $string);
        //Convert whitespace and underscore to pipe
        $string = preg_replace("/[\s_]/", "|", $string);
        return $string;
    }
}
