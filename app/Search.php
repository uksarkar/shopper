<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ProductSearch\ProductSearch;
use Illuminate\Http\Request;

class Search extends Model
{
    /**
     * Create the search method for search page
     */
    public static function apply(Request $request){

        //creating the absolute query for search
        if($request->has('min') && is_null($request->min) || $request->has('min') && !is_numeric($request->min)){
            $request->query->add(['min' => 0]);
        }

        //getting all request as an array on $query var
        $query = $request->all();
        
        //pointing the type = latest to latest = latest 
        if(array_key_exists('type', $query) && $query['type'] == 'latest') {
           unset($query['type']);
           $query['latest'] = 'latest';
        }

        //making sure that max value is a string otherwise remove it
        if($request->has('max') && is_null($request->max) || $request->has('max') && !is_numeric($request->max)){
            unset($query['max']);
        }

        //making sure that min value and max value is not equal if equal then remove max value
        // if($request->has('min') && $request->has('max') && $request->min === $request->max){
        //     unset($query['max']);
        // }

        //making sure that min value is not greater then max value if it is then remove max value
        if($request->has('min') && $request->has('max') && $request->min > $request->max){
            unset($query['max']);
        }

        //Let's create the request with valid input
        $request->replace($query);
        
        //let's apply the filters and get all of the products
        $products = ProductSearch::apply($request);

        //return the results
        return $products;
    }


    //end of the model
}
