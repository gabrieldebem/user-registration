<?php

namespace App\Http\Requests;

use App\Enums\State;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserAddressRequest extends FormRequest
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
            'zipcode' => 'required|numeric',
            'address' => 'required|max:100',
            'number' => 'required|numeric',
            'complement'  => 'nullable|max:100',
            'district'  => 'required|string',
            'city'  => 'required|string',
            'state'  => ['required', Rule::in(State::values())],
        ];
    }
}
