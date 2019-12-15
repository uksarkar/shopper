<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class CreatePriceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (auth()->check() && auth()->user()->can('create product')) return true;
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
            'shop' => 'required',
            'product' => 'required|integer'
        ];
    }
}
