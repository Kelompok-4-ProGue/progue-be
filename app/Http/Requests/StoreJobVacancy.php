<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJobVacancy extends FormRequest
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
            'user_skill_id' => 'required|integer',
            'company_id' => 'required|integer',
            'position' => 'required|string',
            'city' => 'required|string',
            'salary' => 'required|string',
        ];
    }
}
