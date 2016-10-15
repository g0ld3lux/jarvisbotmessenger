<?php

namespace App\Http\Requests;

class SignUpRequest extends Request
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
          'name' => 'required|max:255',
          'email' => 'required|email|max:255|unique:users',
          'password' => 'required|min:6|confirmed',
          'g-recaptcha-response' => 'required|captcha',
          'icode' => 'exists:users,name'
        ];
    }

    public function messages()
    {
        return [
                'name.required' => 'What is Your Full Name?.',
                'name.max'   => 'Oh My Such a Long Name.',
                'email.required' => 'Provide your Most Used Email.',
                'email.email' => 'This is Not An Email.',
                'email.max' => 'Email Provided is Too Long.',
                'email.unique' => 'Someone Already Has That Email.',
                'password.required' => 'Please Provide Password.',
                'password.min'      => 'Password Provided is Too Short.',
                'password.confirmed' => 'Password Confimation Dont Match.',
                'g-recaptcha-response.required' => 'Are You Human? Please Answer Captcha.',
                'g-recaptcha-response.captcha' => 'Captcha Verification Failed!',
                'icode.exists' => 'Invitation Code Not Found!'

        ];
    }
}
