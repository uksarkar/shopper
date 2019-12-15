<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Category;

class Menu extends Model
{
  protected $fillable = ['name', 'slug', 'parent_id', 'priority'];

  //Menu builder methods
  public function buildMenu($menu, $parent_id = null)
  {
    $result = null;
    foreach ($menu as $item)
      if ($item->parent_id == $parent_id) {
        $result .= "<li class=\"dd-item\" data-id=\"$item->id\" data-name=\"$item->name\" data-slug=\"$item->slug\" data-new=\"0\" data-deleted=\"0\">
        <div class=\"dd-handle\">$item->name</div>
        <span class=\"button-delete btn btn-default btn-xs pull-right text-danger\" data-owner-id=\"$item->id\">
        <i class=\"fa fa-times-circle-o\" aria-hidden=\"true\"></i>
        </span>
        <span class=\"button-edit btn btn-default btn-xs pull-right text-success\" data-owner-id=\"$item->id\">
        <i class=\"fa fa-pencil\" aria-hidden=\"true\"></i>
        </span>" . $this->buildMenu($menu, $item->id) . "</li>";
      }
    return $result ?  "\n<ol class=\"dd-list\">\n$result</ol>\n" : null;
  }

  //Store the menu items
  public function storeMenu($data_, $parent = null)
  {
    foreach ($data_ as $key => $data) {
      $dataChildren = isset($data['children']) ? $data['children'] : null;
      if ($data['deleted'] == 1) {
        $this->destroy($data['id']);
      } else {
        $menu = $this->updateOrCreate(
          ['id' => $data['id']],
          [
            'name' => $data['name'],
            'slug' => $data['slug'],
            'priority' => $key,
            'parent_id' => $parent
          ]
        );
        if ($dataChildren) {
          $this->storeMenu($dataChildren, $menu->id);
        }
      }
    }
    return true;
  }

  public function outputHTML($menu, $parent_id = null)
  {
    $result = null;
    foreach ($menu as $item) {
      $slug = (new Category)->getRoute($item->id);
      if ($item->parent_id == $parent_id) {
        $a_tag = "<a class=\"border-b border-transparent hover:text-blue-800 hover:border-gray-700 transition-250\" href=\"$slug\">$item->name</a>";
        $result .= "<li class=''>" . $a_tag . $this->outputHTML($menu, $item->id) . "</li>";
      }
    }
    return $result ?  "\n<ul class=\"ml-8\">\n$result</ul>\n" : null;
  }

  public function outputMenu()
  {
    $menu = Category::all();
    return $this->outputHTML($menu);
  }

  // Getter for the HTML menu builder
  public function getHTML($items)
  {
    return $this->buildMenu($items);
  }
  //end of this controller
}
