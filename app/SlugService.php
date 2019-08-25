<?php
namespace App;

use App\Category;
use Illuminate\Database\Eloquent\Collection;

class SlugService
{
    private $routes = [];

    public function __construct()
    {
        $this->determineCategoriesRoutes();
    }

    public function getRoute(Category $category)
    {
        return $this->routes[$category->id];
    }

    private function determineCategoriesRoutes()
    {
        $categories = Category::all()->keyBy('id');

        foreach ($categories as $id => $category) {
            $slugs = $this->determineCategorySlugs($category, $categories);

            if (count($slugs) === 1) {
                $this->routes[$id] = url('/p/' . $slugs[0]);
            }
            else {
                $this->routes[$id] = url('/' . implode('/', $slugs));
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
}