<?php

namespace App\Http\Requests\Todo;

use App\Http\Requests\FormRequest;

class TodoFormRequest extends FormRequest
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
            'task' => 'required',
            'description' => 'nullable',
            'is_completed' => 'required|boolean',
        ];


        return $rules;
    }
}
