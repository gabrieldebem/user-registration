<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' => 'email',
            'password' => 'required|min:6',
            'first_name' => 'required|max:100',
            'last_name' => 'required|max:100',
            'cpf' => 'required|min:11|max:11',
            'rg' => 'required|min:10|max:10',
            'birth_date' => 'date_format:Y-m-d',
            'phone' => 'nullable|min:10|max:11',
            'cellphone' => 'required|min:11|max:11',
        ];
    }
}
