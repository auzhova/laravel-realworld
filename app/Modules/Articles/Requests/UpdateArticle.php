<?php

namespace App\Modules\Articles\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArticle extends FormRequest
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
            'article.title' => 'sometimes|string|max:255',
            'article.description' => 'sometimes|string|max:255',
            'article.body' => 'sometimes|string',
        ];
    }
}
