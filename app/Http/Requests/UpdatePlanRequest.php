<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePlanRequest extends FormRequest
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
            "name"=>"required",
            "description"=>"required",
            "price"=>"required",
            "currency"=>"required"
        ];
    }

    public function messages()
    {
        return [
            "name.required" =>"Name is required",
            "description.required" =>"Description is required",
            "price.required" =>"Price is required",
            "currency.required" =>"Currency is required",
        ];
    }
}
