<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSchedule extends FormRequest
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
            'course_id'  => 'required', // 必須, 整数型
            'capacity'  => 'required|integer', // 必須, 整数型
//            'is_zoom' => 'required|boolean', // 必須
            'start' => 'required|date', // 必須
//            'end' => 'required|date', // 必須
        ];
    }


    public function messages()
    {
        return [
            'course_id.required' => 'コースを選択してください。',
            'capacity.required' => '定員を入力して下さい。',
            'start.required' => '開始時間を入力して下さい。',
//            'end.required' => '終了時間を入力して下さい。',
        ];
    }
   
}
