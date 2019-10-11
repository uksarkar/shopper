<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->hasRole('admin');
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
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'location' => ['required', 'string'],
            'phone' => ['required', 'string', 'size:11'],
            'password' => ['required', 'string', 'min:8'],
            'roles' => ['required','array'],
            'roles.*' => ['integer'],
            'image' => ['sometimes','image','mimes:jpg,jpeg,png,gif,svg','max:2048']
        ];
    }
    
    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'roles.required'=> 'Please select a role for the user.'
        ];
    }
}
