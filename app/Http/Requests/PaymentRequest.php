<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
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
      [
        "email"=> "required|email|exists:users,email",
        "user_id" => "required|exists:users,id",
        "amount" => "required|numeric",
        "type" => "required",
        "type_id" => "required",
        "currency" => "required|in:NGN",
        "channel" => "required|in:card",
    ];
    }
}
