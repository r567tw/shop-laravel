<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BuyMerchandiseRequest extends FormRequest
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
            'buy_count' => 'required|integer|min:1',
        ];
    }

    public function messages()
    {
        return [];
    }
}
