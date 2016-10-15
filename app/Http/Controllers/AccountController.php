<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteUserRequest;
use App\Http\Requests\UpdateUserPasswordRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Notification;
use Auth;

class AccountController extends Controller
{
    /**
     * Show user form.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $user = $request->user();
      $google2fa = app()->make('PragmaRX\Google2FA\Contracts\Google2FA');
      $google2fa_url = $google2fa->getQRCodeGoogleUrl(
        'Jarvis Bot Messenger',
          $user->email,
          $user->google2fa_secret
        );
      return view('account.index',compact('user','google2fa_url'));
    }

    /**
     * Update user details.
     *
     * @param UpdateUserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateUserRequest $request)
    {
      if($request->has('email'))
      {
        $request->user()->email = $request->get('email');
      }
      $request->user()->name = $request->get('name');
      $request->user()->save();

      Notification::success('Account details updated successfully.');

      return redirect()->route('account.index');
    }

    /**
     * Update user details.
     *
     * @param UpdateUserPasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function password(UpdateUserPasswordRequest $request)
    {
        $request->user()->password = bcrypt($request->get('new_password'));
        $request->user()->save();

        Notification::success('Account password updated successfully.');

        return redirect()->route('account.index')->withInput(['tab' => 'password']);
    }

    /**
     * Delete user.
     *
     * @param DeleteUserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(DeleteUserRequest $request)
    {
        $userId = $request->user()->id;

        Auth::logout();

        User::findOrFail($userId)->delete();

        return redirect()->route('home');
    }

    public function enableGoogleTwoFactor(Request $request)
    {

      $user = $request->user();
      $google2fa = app()->make('PragmaRX\Google2FA\Contracts\Google2FA');
      $secret = $request->input('secret');
      $valid = $google2fa->verifyKey($user->google2fa_secret, $secret);
      if($valid){
        $user->google2fa_on = true;
        $user->save();
        Notification::success('Google 2 Factor Authentication Enabled.');
        return redirect()->route('account.index')->withInput(['tab' => 'google2fa']);
      }
      Notification::warning('Failed to Enable 2 Factor Authentication.');
      return redirect()->route('account.index')->withInput(['tab' => 'google2fa']);
    }

    public function disableGoogleTwoFactor(Request $request)
    {
      $user = $request->user();
      $user->google2fa_on = false;
      $user->save();
      Notification::warning('Google 2 Factor Authentication Disabled!');
      return redirect()->route('account.index')->withInput(['tab' => 'google2fa']);

    }
}
