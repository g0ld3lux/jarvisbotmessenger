<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Socialite;
use App\Http\Requests;
use App\Providers\SocialAccountServiceProvider;
use Notification;

class SocialAuthController extends Controller
{
  public function redirect($provider)
  {
    return Socialite::driver($provider)->redirect();
  }

  public function callback(SocialAccountServiceProvider $service, $provider)
  {
    $user = $service->createOrGetUser(Socialite::driver($provider));

    auth()->login($user);

    if(auth()->user()->google2fa_on == true){
        $userId = auth()->user()->id;
        session(['userid' => $userId]);
        auth()->logout();
        Notification::info('Provide Token from Your Google Authenticator App.');
        return redirect()->route('auth.get2FA');
      }

    return redirect()->to('/bots');
  }
}
