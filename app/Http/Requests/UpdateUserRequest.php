<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return !$this->has('password');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'nullable|email',
            'first_name' => 'nullable|max:100',
            'last_name' => 'nullable|max:100',
            'cpf' => 'nullable|min:11|max:11',
            'rg' => 'nullable|min:10|max:10',
            'birth_date' => 'nullable|date_format:Y-m-d',
            'phone' => 'nullable|min:10|max:11',
            'cellphone' => 'nullable|min:11|max:11',
        ];
    }
}
