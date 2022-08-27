<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;



class LalaRequest extends FormRequest
{
     /**
     * Determine if the user is authorized to make this request.开启用户验证权限
     * 
     * @return bool
     */
    public function authorize()
    {
        return true;
    }


    /**
     * Get the validation rules that apply to the request.验证规则
     * 
     * @return array
     */
    
    public function rules()
    {
        return [
                    'title' => 'required|max:2',
                    'body' => 'required', 
        ];
    }

    /**
     * Get the validation rules that apply to the request.返回信息
     * 
     * @return array
     */
    public function messages()
    {
        return[
            "title.required" => "标题必填",
            "title.max" => "标题长度不超过2字符",
            "body.required" => "文章内容不能为空",
        ];
    }
   
    /**
     * @description: 错误返回信息
     * @param {Validator}实例 $validator
     * @return {*}
     */    
    // protected function failedValidation(Validator $validator)
    // {
    //     dd($validator->errors()->messages());
    // }

}
