<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class AlphaNumHalfUserId implements Rule
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
        return preg_match('/^[a-zA-Z0-9\_]+$/u', $value);//半角英数記号のバリデーションが真偽を判定するメソッド偽の場合下記メッセージに移行
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'User IDは半角英数と「 _ 」のみ使用可';
    }
}
