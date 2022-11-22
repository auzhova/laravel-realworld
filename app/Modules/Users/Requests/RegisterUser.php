<?php

namespace App\Modules\Users\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user.username' => 'required|max:50|alpha_num|unique:users,username',
            'user.email' => 'required|email|max:255|unique:users,email',
            'user.password' => 'required|min:6',
        ];
    }
}
