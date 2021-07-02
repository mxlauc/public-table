<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Hash;
use Illuminate\Support\Facades\Auth;
use Str;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{


    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleProviderCallback()
    {
        // Obtenemos los datos del usuario
        $social_user = Socialite::driver('google')->user();
        //dd($social_user); // Sirve para visualizar que llega el callback antes de seguir con el codigo

        if ($user = User::where('email', $social_user->email)->first()) {
            return $this->authAndRedirect($user); // Login y redirección
        } else {
            // add user to database
            $user = User::create([
                // 'token' => $user->token;
                'name' => $social_user->getName(),
                'email' => $social_user->getEmail(),
                'avatar' => $social_user->avatar,
                'provider' => 'google',
            ]);
            return $this->authAndRedirect($user); // Login y redirección
        }
    }

    // Login y redirección
    public function authAndRedirect($user)
    {
        Auth::login($user);
        return redirect()->route('home');
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('home');
    }
}
