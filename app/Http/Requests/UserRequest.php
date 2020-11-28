<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;//emailとunique_idのユニークチェックのために使用
use App\Rules\AlphaNumHalfUserId;//バリデーションのために作成したルールを使用


class UserRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email'=> 'required|string|email|max:255|unique:users,email,'.Auth::user()->id,
            'self' => 'max:255',
            'pro_image' => 'nullable|file|image',
            'unique_id' => ['required',new AlphaNumHalfUserId,'min:6','string','max:20','unique:users,unique_id,'.Auth::user()->id],
        ];
    }
}
