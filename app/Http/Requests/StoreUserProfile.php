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
            'kana'  => 'required', // 必須
            'tel'   => 'required|regex:/^[0-9]{2,4}-[0-9]{2,4}-[0-9]{3,4}$/',
            'year' => 'nullable|present|numeric|required_with:month,day',
            'month' => 'nullable|present|numeric|required_with:year,day',
            'day' => 'nullable|present|numeric|required_with:year,month',
            'zip_code' => 'required|regex:/^\d{3}\-\d{4}$/',
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
            'kana.required' => 'お名前の読み方を入力してください。',
            'zip_code.regex' => '郵便番号は(658-0053)のように半角文字で入力してください。',
            'tel.regex' => '電話番号は(078-123-4567)のように半角文字で入力してください。',
        ];
    }

}
