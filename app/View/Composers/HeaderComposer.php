<?php

namespace App\View\Composers;

use App\Category;
use App\Menu;
use Illuminate\View\View;

class HeaderComposer
{
    /**
     * The categories implementation.
     *
     * @var Categories
     */
    protected $categories;
    protected $menu;

    /**
     * Create a new profile composer.
     *
     * @param  Categories $categories
     * @return void
     */
    public function __construct(Category $category,Menu $menu)
    {
        // Dependencies automatically resolved by service container...
        $this->categories = $category;
        $this->menu = $menu;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('categories', $this->categories->all())
            ->with('menu',$this->menu);
    }
}