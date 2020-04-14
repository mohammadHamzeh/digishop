<?php

namespace App\Http\Requests\AdminPanel;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ArticleRequest extends FormRequest
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

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'error' => $validator->errors()->first(),
                'error_type' => array_keys($validator->errors()->messages())[0],
            ], 422)
        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if (isset($this->id) && !empty($this->id)) {
            if (!is_numeric($this->id)) {
                throw new HttpResponseException(response()->json([], 400));
            }
        }
        $role = [
            'title' => 'string|required|max:255',
            'description' => 'string|required',
            'text' => 'string|required',
            'blog_img' => 'required|image',
            'tags' => 'nullable',
            'articleStatus' => 'in:1,2|required',
            'categories' => 'nullable',
            'meta_data_title' => 'required|string',
            'meta_data_description' => 'required',
            'meta_data_keyword' => 'nullable',
            'meta_data_author' => 'nullable',
            'meta_data_image' => 'nullable|image'
        ];
        switch ($this->method()) {
            case 'PUT':
            case 'POST':
                return $role;
                break;
        }

    }

}
