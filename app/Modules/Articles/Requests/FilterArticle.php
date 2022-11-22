<?php

namespace App\Modules\Articles\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilterArticle extends FormRequest
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
            'article.tag' => 'sometimes|string',
            'article.author' => 'sometimes|string',
            'article.favorited' => 'sometimes|string',
            'article.limit' => 'sometimes|integer',
            'article.offset' => 'sometimes|integer',
        ];
    }
}
