<?php

namespace App\Http\Requests\Admin\Users;

use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'  => 'required|string|max:255',
            // laralearn чтоб не говорил о том, что у редактируемого пользователя email уже занят:
            'email' => 'required|string|email|max:255|unique:users,id,' . $this->user->id,
            //'status'=> ['required', 'string', Rule::in([
            //    User::STATUS_WAIT,
            //    User::STATUS_ACTIVE
            //])],
            'role'=> ['required', 'string', Rule::in(array_keys(User::rolesList()))],
        ];
    }
}
