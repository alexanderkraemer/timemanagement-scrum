<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class TimeRequest extends Request
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
            'task_id' => 'exists:task,id',
            'user_id' => 'exists:users,id',
            'timeneeded' => 'required',
            'timestillneeded' => 'required',
        ];
    }
}
