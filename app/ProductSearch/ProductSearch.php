<?php

namespace App\ProductSearch;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class ProductSearch
{
    static protected $q = null;

    public static function apply(Request $filters)
    {
        self::$q = $filters->all();
        $query = static::applyDecoratorsFromRequest($filters, (new Product)->newQuery());
        return static::getResults($query);
    }
    private static function applyDecoratorsFromRequest(Request $request, Builder $query)
    {
        foreach ($request->all() as $filterName => $value) {
            $decorator = static::createFilterDecorator($filterName);
            if (static::isValidDecorator($decorator)) {
                $query = $decorator::apply($query, $value);
            }
        }
        return $query;
    }
    private static function createFilterDecorator($name)
    {
        return __NAMESPACE__ . '\\Filters\\' . studly_case($name);
    }
    private static function isValidDecorator($decorator)
    {
        return class_exists($decorator);
    }
    private static function getResults(Builder $query)
    {
        return $query->paginate(25)->appends(self::$q);
        // dd($query->toSql());
    }
}
