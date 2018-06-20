<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MerchandiseRequest extends FormRequest
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
            'status' =>'required|max:80',
            'name' =>'required|max:80',
            'name_en'=>'required|max:80',
            'introduction'=>'required|max:2000',
            'introduction_en'=>'required|max:2000',
            'photo'=>'file|image|max:10240',//10mb,
            'price'=>'required|integer|min:0',
            'remain_count'=>'required|integer|min:0'
        ];
    }

    public function messages()
    {
        return [
        ];
    }
}
