<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateShopRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //if the user has permission to create shop or user is admin then authorize the request
        if(auth()->check()){
            if(auth()->user()->can('create shop') || auth()->user()->hasRole('admin')) return true;
        }

        //for unauthorized user
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'shop_name'=>'string|max:60|required',
            'shop_location'=>'string|max:120|required',
            'shop_description'=>'string|max:1000|required',
            'shop_image'=>'sometimes|image|mimes:jpg,png,jpeg|max:3072'
        ];
    }
}
