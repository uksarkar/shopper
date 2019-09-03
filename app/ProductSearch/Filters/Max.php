<?php

namespace App\ProductSearch\Filters;

use Illuminate\Database\Eloquent\Builder;
use App\Price;

class Max implements Filter
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
        return $builder->whereHas('prices',function(Builder $query) use($value){
            $query->havingRaw('MIN(amounts) <= '.$value);
        });
    }
}
