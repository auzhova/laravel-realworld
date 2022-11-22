<?php

namespace App\Modules\Users\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUser extends FormRequest
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
            'user.username' => 'sometimes|max:50|alpha_num|unique:users,username,' . $this->user()->id,
            'user.email' => 'sometimes|email|max:255|unique:users,email,' . $this->user()->id,
            'user.password' => 'sometimes|min:6',
            'user.bio' => 'sometimes|nullable|max:255',
            'user.image' => 'sometimes|nullable|url',
        ];
    }
}
