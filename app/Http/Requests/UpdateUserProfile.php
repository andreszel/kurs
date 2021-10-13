<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateUserProfile extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //czy pozwalamy na aktualizację danych
        //jeżeli to są dane zalogowanego usera to pozwalamy
        //bo to są jego dane
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        /* return [
            'email' => 'required|email',
            'name' => 'required|max:200'
        ]; */

        //'unique:users' alternatywa dla krótszego zapisu Rule::unique('users'),

        $userId = Auth::id();

        return [
            'email' => [
                'required',
                //'unique:users',
                Rule::unique('users')->ignore($userId),
                'email'
            ],
            'name' => 'required|max:50'
        ];
    }

    public function messages()
    {
        // :max możemy w ten sposób wstawiać wartości zmiennych
        return [
            'email.unique' => 'Podany adres email jest już zajęty!',
            'name.max' => 'Podana ilość znaków jest zbyt duża! Max to: :max'
        ];
    }
}
