<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DepartmentRequest extends FormRequest
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
        $id = $this->route('department');

        return [
            'name' => ['required','max:100',Rule::unique('departments')->ignore($id)],
            'description' => 'required|max:1024',
            'user_id.*' => 'int',
            'logo' => 'image|file|max:4096'
        ];
    }
}
