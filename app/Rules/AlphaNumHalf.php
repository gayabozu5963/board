<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class AlphaNumHalf implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return preg_match('/\A(?=.*?[a-z])(?=.*?[A-Z])(?=.*?\d)[a-zA-Z\d]+\z/', $value);//半角英数のバリデーションが真偽を判定するメソッド偽の場合下記メッセージに移行
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attributeは小文字半角英字、大文字半角英字、数字をそれぞれ使用必須';
    }
}
