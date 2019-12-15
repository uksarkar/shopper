<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Price;

class Variant extends Model
{
    protected $fillable = ['variant_name', 'query'];
    /**
     * Get all of the posts that are assigned this tag.
     */
    public function variants()
    {
        return $this->morphedByMany(Variant::class, 'photoable');
    }
    /**
     * Create variant query.
     *
     * @param  string $name
     * @return string
     */
    public function makeQueryFromName($name)
    {
        $query = Str::slug($name);
        $count = $this->whereRaw("query RLIKE '^{$query}(-[0-9]+)?$'")->count();
        return $count ? "{$query}-{$count}" : $query;
    }
    public function createNewVariants($names, $price, $thePrice)
    {
        foreach ($price as $k => $item) {
            $query = $this->makeQueryFromName($names[$k]);
            if (!blank($item) && !blank($names[$k])) {
                $newVariant = $this->create(["variant_name" => $names[$k], "query" => $query]);
                $findPrice = Price::find($thePrice);
                $findPrice->variants()->attach([$newVariant->id => ["amounts" => $item]]);
            }
        }
    }
}
