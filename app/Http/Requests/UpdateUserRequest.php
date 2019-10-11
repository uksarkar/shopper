<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'size:11'],
            'location' => ['required', 'string'],
            'email' => Rule::unique('users')->ignore($this->route()->user->id),
            'roles' => ['required','array'],
            'roles.*' => ['integer'],
            'image' => ['sometimes','image','mimes:jpg,jpeg,png,gif,svg','max:2048']
        ];
    }
}
