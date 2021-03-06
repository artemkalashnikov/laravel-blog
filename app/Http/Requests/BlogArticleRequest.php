<?php

namespace App\Http\Requests;

use App\Rules\NoSameValues;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class BlogArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::check()) {
            return true;
        }

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
            'title'         =>  'required|min:3|max:200',
            'fragment'      =>  'max:500',
            'content'       =>  'required|string|min:5|max:10000',
            'parent_ids'    =>  [
                'exists:blog_articles,id',
                new NoSameValues('child_ids', $this->input('child_ids')),
            ],
            'child_ids'   =>  [
                'exists:blog_articles,id',
                new NoSameValues('parent_ids', $this->input('parent_ids')),
            ],
            'category_id'   =>  'integer|exists:blog_categories,id',
            'is_published'  =>  'bool',
        ];
    }
}
