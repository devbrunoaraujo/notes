<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;

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
        
        // check user exists

        $user = User::where('username', $username)
                        ->where('deleted_at', NULL)
                        ->first();
        // check user exists! 
        if(!$user){
            return redirect()
                    ->back()
                    ->withInput()
                    ->with('loginError', 'Username ou password incorretos!');
        }

        // check password
        if(!password_verify($password, $user->password)){
            return redirect()
                    ->back()
                    ->withInput()
                    ->with('loginError', 'Username ou password incorretos!');
        }
        // update last login
        $user->last_login = date('Y-m-d H:i:s');
        $user->save();

        //login
        session([
            'user' => [
                'id' => $user->id,
                'username' => $user->username
            ]
            ]);

        echo 'Usuário '.$user->username.'Autenticado com sucesso!';
    }
}