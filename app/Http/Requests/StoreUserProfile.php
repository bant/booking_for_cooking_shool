<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserProfile extends FormRequest
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
            'name'  => 'required', // 必須
            'tel'   => 'required|numeric|digits_between:2,4',
            'year' => 'nullable|present|numeric|required_with:month,day',
            'month' => 'nullable|present|numeric|required_with:year,day',
            'day' => 'nullable|present|numeric|required_with:year,month',
        ];
    
    }
    public function attributes()
    {
        return [
            'name' => '名前',
            'year' => '年',
            'month' => '月',
            'day' => '日',
        ];
    }


    public function messages()
    {
        return [
            'name.required' => 'お名前を入力してください。',
        ];
    }

}
