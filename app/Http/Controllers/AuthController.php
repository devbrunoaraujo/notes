<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function logout()
    {

    }

    public function loginSubmit(Request $request)
    {
        //form validation
        $request->validate(
            [
                'text_username' => 'required|email',
                'text_password' => 'required|min:6|max:16'
            ],
            //error messages
            [
                'text_username.required' => 'O campo é obrigatório',
                'text_username.email' => 'Deve ser um email válido',
                'text_password.required' => 'O campo senha é obrigatório!',
                'text_password.min' => 'O campo senha deve ter no mínimo :min caracteres',
                'text_password.max' => 'O campo senha deve ter no máximo :max caracteres',
            ]
        );
        //get user input
        $username = $request->input('text_username');
        $password = $request->input('text_password');
        echo'ok';

    }
}
