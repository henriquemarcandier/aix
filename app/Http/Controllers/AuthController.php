<?php

namespace App\Http\Controllers;

use App\Logs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function showLoginForm()
    {
        return view('admin.formLogin');
    }
    public function showForgotPassword()
    {
        return view('admin.formForgotPassword');
    }
    public function showCadaster()
    {
        return view('admin.formCadaster');
    }

    public function login(Request $request)
    {

        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];
        if (Auth::attempt($credentials)){
            $Logs = new logs();
            $Logs->user = $_SESSION['user']['id'];
            $Logs->action = "Se logou no sistema";
            $Logs->save();
            $login['success'] = true;
            echo json_encode($login);
            return;
        }
        $login['success'] = false;
        $login['message'] = "Os dados informados não conferem!";
        echo json_encode($login);
        return;
    }

    public function logout()
    {
        $Logs = new logs();
        $Logs->user = $_SESSION['user']['id'];
        $Logs->action = "Efetuou logout no sistema";
        $Logs->save();
        unset($_SESSION['user']);
        return redirect()->route('admin.login');
    }
}
