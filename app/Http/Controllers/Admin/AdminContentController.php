<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AdminContent;

class AdminContentController extends Controller
{
    
    public function index(AdminContent $content){
        $content = $content->where('id',1)->first();
        return $content->products;
    }

    //end of the controller
}
