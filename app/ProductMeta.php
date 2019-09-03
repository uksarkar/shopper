<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ProductMeta extends Model
{
    /**
     * Set the fillable table column
     * 
     * @var array
     */
    protected $fillable = ['name','data','product_id'];

    /**
     * Store the product data to database
     * 
     * @return bool
     */
    public function storeMeta($product_id){
        if(Cache::has('tamp_meta_data_'.auth()->id()) && !blank(Cache::get('tamp_meta_data_'.auth()->id())))
        {
            //get the meta data from cache
            $meta_data = Cache::get('tamp_meta_data_'.auth()->id());

            //Store it in database
            foreach ($meta_data as $data) {
                if($data['status'] == 'delete')
                {
                    $this->destroy($data['id']);
                } 
                $this->updateOrCreate(
                    ['id'=> $data['id']],
                    [
                        'name'=> $data['name'],
                        'data'=> $data['data'],
                        'product_id'=> $product_id
                    ]
                );
            }

            //remove it from cache
            Cache::forget('tamp_meta_data_'.auth()->id());

            return true;
        }
    }

    /**
     * End of the model
     */
}
