<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = ['name','slug','parent_id'];
    // public function getSlugAttribute(){
    //     // $categoryRouteService = app(SlugService::class);

    //     // return $categoryRouteService->getRoute($this);
    //     return $this->getRoute($this->id);
    // }
    public function products(){
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

    public function makeSlugFromTitle($title)
    {
        $slug = Str::slug($title);
        $count = $this->whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
        return $count ? "{$slug}-{$count}" : $slug;
    }
    //Find Category by its slug
    public function findCategoryBySlug($slug){
        $find = explode('/', $slug);
        $find = array_pop($find);
        $result = $this->where('slug', $find)->first();
        return $result;
        if(!blank($result)){
            $result->slug = $this->create_slug($result->id);
            return $result->slug == $slug ? $result:false;
        }
        return false;
    }
    public function create_slug($value, $column = 'id'){
        $find = $this->where($column,$value)->firstOrFail();
        $this_slug = $find->slug;
        if($find->parent_id != 0){
            $this_slug = $this->create_slug($find->parent_id)."/".$this_slug;
        } 
        return $this_slug;
    }
    //End of finding category

    //Start finding product by slug
    public function findProductBySlug($slug){
        $this_slug = explode('/', $slug);
        $this_slug = array_pop($this_slug);
        $product = Product::where('slug', $this_slug)->firstOrFail();
        $category_slug = $this->create_slug($product->category_id);
        $product->slug = $category_slug.'/'.$product->slug;
        return $product->slug == $slug ? $product:false;
    }
    //End of finding product

    //Outputting Category tree in admin panels create product page
    public function outputHTML($category, $parent_id = null, $category_id = null) { 
	    $result = null;
        foreach ($category as $k => $item) 
            if ($item->parent_id == $parent_id) { 
            $ul_class = ($item->parent_id == null) ? "rounded border-tree tree-css":null;
            if($category_id == null){
                $selected = ($k == 0 && $item->parent_id == null) ? "checked":null;
            } else {
                $selected = $category_id == $item->id ? "checked":null;
            }
            $result .= "<li class=\"form-check\">
            <label class=\"form-check-label\">
                <input type=\"radio\" class=\"form-check-input\" $selected name=\"category_id\" value=\"$item->id\">$item->name
            </label>". $this->outputHTML($category, $item->id, $category_id) ."</li>";
            } 
        return $result ?  "\n<ul class=\"$ul_class\">\n$result</ul>\n" : null; 
    }

    public function outputTree($category_id = null){
      $category = $this->all();
      return $this->outputHTML($category,null, $category_id);
    }
    //End outputting category tree on admin panel create product page
    

    //Testing _____________________________________________________
    private $routes = [];

    public function getRoute($category_id)
    {
        $this->determineCategoriesRoutes();
        return $this->routes;
    }

    private function determineCategoriesRoutes()
    {
        $categories = $this->all()->keyBy('id');

        foreach ($categories as $id => $category) {
            $slugs = $this->determineCategorySlugs($category, $categories);

            if (count($slugs) === 1) {
                // $this->routes[$id] = '/' . $slugs[0];
                $this->routes[$category->slug] = '/' . $slugs[0];
            }
            else {
                // $this->routes[$id] = '/' . implode('/', $slugs);
                $this->routes[$category->slug] = '/' . implode('/', $slugs);
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

    //End Testing__________________________________________________

    //end of this class
}
