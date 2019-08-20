<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\Cast\Object_;

//use App\Config;

class Helper extends Model
{

    /*
     * Start Header configurations section
     */
    //Creating primary menu
    public static function primaryMenu(){
        if (!blank(Config::where('name','primary_menu')->where('type','show')->get()) && !blank($menu_items = Config::with('metas')->where('type', 'primary_menu')->get())) {
            return $menu_items;
        }
        return false;
    }

    //Creating Secondary menu
    public static function secondaryMenu(){
        if (!blank(Config::where('name','secondary_menu')->where('type','show')->get()) && !blank($menu_items = Config::where('type', 'secondary_menu')->get())) {
            return $menu_items;
        }
        return false;
    }

    //Creating dropdown menu
    public static function dropdownMenu(){
        if (!blank(Config::where('name','dropdown_menu')->where('type','show')->get()) && !blank($menu_items = Config::where('type', 'dropdown_menu')->get())) {
            return $menu_items;
        }
        return false;
    }

    //Creating search dropdown
    public static function searchDropdown(){
        if (!blank(Config::where('name','search_dropdown')->where('type','show')->get()) && !blank($menu_items = Config::where('type', 'search_dropdown')->get())) {
            return $menu_items;
        }
        return false;
    }
    /*
     * End of header configs section
     * _____________________________________________________________
     */

    /*
     * _____________________________________________________________
     * Start of slider section
     */

    public static function sliderSection(){
        $items = new \stdClass();
        if (!blank(Config::where('name','slider_section')->where('type','show')->get())) {
            $items->leftName = Config::where('name','slider_section')->where('type','show')->pluck('key_1')->first();
            $items->rightName = Config::where('name','slider_section')->where('type','show')->pluck('key_2')->first();
            $items->banner = Config::where('name','slider_down_banner')->where('type','show')->first();
            if (!blank($items_left_menu = Config::where('type','slider_section_left_menu')->get())){
                $items->left_menu = $items_left_menu;
            }
            if (!blank($items_image = Config::where('type','slider_image')->get())){
                $items->images = $items_image;
            }
            if (!blank($items_right_menu = Config::where('type','slider_section_right_menu')->get())){
                $items->right_menu = $items_right_menu;
            }
            return $items;
        }
        return false;
    }

    public static function footer(){

    }

    //End of the class
}
