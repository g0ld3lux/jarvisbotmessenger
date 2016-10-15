<?php

namespace App\Http\Requests;

class LoginRequest extends Request
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
            'email' => 'required|exists:users,email',
            'password' => 'required|min:6',
            'g-recaptcha-response' => 'required|captcha',
        ];
    }

    public function messages()
    {
        return [
                'email.required' => 'Provide a Registered Email.',
                'email.exists'   => 'Account is Not Registered.',
                'password.required' => 'Provide Password For Login.',
                'password.min'      => 'Password is Too Short!',
                'g-recaptcha-response.required' => 'Are You Human? Please Answer Captcha.',
                'g-recaptcha-response.captcha' => 'Captcha Verification Failed!.'

        ];
    }
}
