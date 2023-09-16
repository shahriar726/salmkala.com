<?php

namespace App\Http\Requests\Customer\SalesProcess;

use Illuminate\Foundation\Http\FormRequest;

class ProfileCompletionRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //sometimes age qhbalan por karde bashi dige lazem nadari por koni
            'first_name' => 'sometimes|required',
            'last_name' => 'sometimes|required',
            'email' => 'sometimes|email|unique:users,email',
            'mobile' => 'sometimes|required|min:10|max:13||unique:users,mobile',
            //byad national_code ro ke dar rule ezafe mikoni ba helper  inja seda bezani
//            'national_code' => ['sometimes', 'required', 'unique:users,national_code', new NationalCode()],
        ];
    }
}
