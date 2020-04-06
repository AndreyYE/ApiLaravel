<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;

class CreateCategory extends FormRequest
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
            'name' => ['required','string', function ($attribute, $value, $fail) {
                if(request()->category){
                    $alreadyExists = Category::where([
                        ['name',$value],
                        ['parent_id',request()->category],
                    ])->count();
                    if($alreadyExists)
                    {
                        $fail(__('messages.CategoryAlreadyExists'));
                    }
                }else{
                    $alreadyExists = Category::where([
                        ['name',$value],
                    ])->count();
                    if($alreadyExists)
                    {
                        $fail(__('messages.CategoryAlreadyExists'));
                    }
                }
            },],
        ];
    }
}
