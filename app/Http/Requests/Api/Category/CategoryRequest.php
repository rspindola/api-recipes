<?php

namespace App\Http\Requests\Api\Category;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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

        $rules = [
            'category_id' => ['exists:categories,id,category_id'],
            'description' => [],
            'icon' => [],
        ];

        if ($this->isMethod('post')) {
            $rules['name'] = 'required';
            $rules['description'] = ['required'];
            $rules['icon'] = ['required'];
        }

        return $rules;
    }
}
