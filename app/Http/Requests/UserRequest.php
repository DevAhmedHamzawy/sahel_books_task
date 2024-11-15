<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'required',
            'address' => 'required',
            'phone' => ['required','regex:/^(009665|9665|\+9665|05|5)(5|0|3|6|4|9|1|8|7)([0-9]{7})$/'],
        ];

        if ($this->method() == 'PATCH') {
            $rules['email'] = 'required|email|unique:users,email,' . $this->user->id;
            $rules['main_image'] = 'mimes:jpeg,jpg,png,gif|sometimes|max:10000';
            $rules['password'] = 'nullable|min:8|max:25';
        }else{
            $rules['email'] = 'required|email|unique:users,email';
            $rules['main_image'] = 'mimes:jpeg,jpg,png,gif|sometimes|max:10000';
            $rules['password'] = 'required|min:8|max:25';
        }

        return $rules;
    }


}
