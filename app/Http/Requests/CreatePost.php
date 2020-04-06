<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePost extends FormRequest
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
            'name' => 'required|string',
            'text' => 'required|string',
            'image' => 'mimes:jpeg,jpg,png,gif|nullable|max:10000',
            'category_id' => 'required|integer|exists:categories,id'
        ];
    }
}
