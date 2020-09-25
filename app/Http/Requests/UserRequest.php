<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\User;


class UserRequest extends FormRequest
{
    /**
     * Determine if the uaser is authorized to make this request.
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
     * @param  \App\Models\User  $user
     * @return array
     */
    public function rules()
    {
        $id = ($this->route('user'));
        return [
            'name' => 'required|max:100',
            'email' => ['required','email','max:256',
                Rule::unique('users')->ignore($id)],
            'password' => ['required','string','min:4','regex:/[0-9]/']
        ];
    }
}
