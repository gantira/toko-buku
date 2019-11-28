<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
            'title' => 'required',
            'author' => 'required',
            'publisher' => 'required',
            'isbn' => 'required|unique:products',
            'year' => 'required|numeric|min:1900|max:2500',
            'curriculum' => 'required|',
            'image' => 'sometimes|max:2048',
            'price' => 'sometimes|numeric',
            'stock' => 'sometimes|numeric',
        ];
    }
}
