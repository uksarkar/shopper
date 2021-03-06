<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;
use App\Price;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'parent_id'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id')->with('children');
    }
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
    public function content()
    {
        return $this->belongsToMany(AdminContent::class);
    }

    public function makeSlugFromTitle($title)
    {
        $slug = Str::slug($title);
        $count = $this->whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
        return $count ? "{$slug}-{$count}" : $slug;
    }
    //Find Category by its slug
    public function findCategoryBySlug($slug)
    {
        $find = explode('/', $slug);
        $find = array_pop($find);
        $result = $this->where('slug', $find)->first();
        if (!blank($result)) {
            $result->slug = $this->getRoute($result->id);
            return $result->slug == "/" . $slug ? $result : false;
        }
        return false;
    }
    //find category name and slug by slug
    public function getNameSlugOfCategory($slug)
    {
        $category = $this->where('slug', $slug)->firstOrFail();
        $category->slug = $this->getRoute($category->id);
        return $category;
    }
    //End of finding category

    //Start finding product by slug
    public function findProductBySlug($slug)
    {
        $this_slug = explode('/', $slug);
        $this_slug = array_pop($this_slug);
        $product = Product::where('slug', $this_slug)->firstOrFail();
        $productMeta = $product->getLowestPriceData();
        $category_slug = $this->getRoute($product->category_id);
        $product->slug = $category_slug . '/' . $product->slug;
        $product->price = $productMeta['price'];
        $product->count = $productMeta['count'];
        $product->variant = $productMeta['variant'];
        $product->cat_slug = $category_slug;

        return $product->slug == "/" . $slug ? $product : false;
    }
    //End of finding product

    //Outputting Category tree in admin panels create product page
    public function outputHTML($category, $parent_id = 0, $category_id = null)
    {
        $result = null;
        foreach ($category as $item)
            if ($item->parent_id == $parent_id) {

                $ul_class = ($item->parent_id == 0) ? "rounded border-tree tree-css pb-2" : null;
                $selected = ($category_id == $item->id) ? "checked" : null;

                $result .= "<li class=\"form-check\">
                <label class=\"form-check-label\">
                    <input type=\"radio\" class=\"form-check-input\" $selected name=\"category_id\" value=\"$item->id\">$item->name
                </label>" . $this->outputHTML($category, $item->id, $category_id) . "</li>";
            }
        return $result ?  "\n<ul class=\"$ul_class\">\n$result</ul>\n" : null;
    }

    public function outputTree($category_id = null)
    {
        $category = $this->all();
        return $this->outputHTML($category, 0, $category_id);
    }
    //End outputting category tree on admin panel create product page

    public function slug()
    {
        return $this->getRoute($this->id);
    }
    //Making the route for category
    private $routes = [];

    public function getRoute($category_id)
    {
        if (Cache::has('product_categories') && array_key_exists($category_id, Cache::get('product_categories'))) return Cache::get('product_categories')[$category_id];

        $this->updateCache();
        $route = array_key_exists($category_id, $this->routes) ? $this->routes[$category_id] : '/unrecognized';
        return $route;
    }
    //update the cache if any changes made on database by ConfigController
    public function updateCache()
    {
        $this->determineCategoriesRoutes();
        Cache::put('product_categories', $this->routes);
        return true;
    }

    private function determineCategoriesRoutes()
    {
        $categories = $this->all()->keyBy('id');

        foreach ($categories as $id => $category) {
            $slugs = $this->determineCategorySlugs($category, $categories);

            if (count($slugs) === 1) {
                $this->routes[$id] = '/' . $slugs[0];
            } else {
                $this->routes[$id] = '/' . implode('/', $slugs);
            }
        }
    }

    private function determineCategorySlugs(Category $category, Collection $categories, array $slugs = [])
    {
        array_unshift($slugs, $category->slug);

        if ($category->parent_id != 0) {
            $slugs = $this->determineCategorySlugs($categories[$category->parent_id], $categories, $slugs);
        }

        return $slugs;
    }
    //End of the route making section

    //end of this class
}
