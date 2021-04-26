<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException as HttpResponse;

class NewsPostRequest extends FormRequest
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

            'news_title' => 'required',
            'publish_start_date' => 'required',
            'publish_end_date' => 'required',
            'category_id' => 'required',
            'description' => '',
            'image' => '',
            'video' => ''
        ];
    }
    
     protected function failedValidation(Validator $validator)
    {
        $res = [
            "status_code" => 202,
            "message" => $validator->errors()->first(),
            "data" => (object)[]
        ];
        throw new HttpResponse(response()->json($res, 202));
    }
}
