<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\Users\CreateRequest;
use App\Http\Requests\Admin\Users\UpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Notification;

class UsersController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        $users = User::orderBy('email', 'asc');

        if ($search) {
            $users = $users->where(function ($query) use ($search) {
                $query
                    ->where('id', '=', $search)
                    ->orWhere('name', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%')
                    ->orWhere('created_at', 'like', '%'.$search.'%');
            });
        }

        $users = $users->paginate(30);

        if ($search) {
            $users->appends(['search' => $search]);
        }

        return view('admin.users.index', [
            'users' => $users,
            'search' => $search,
        ]);
    }

    /**
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user)
    {
        return view('admin.users.show', [
            'user' => $user,
            'bots' => $user->bots,
        ]);
    }

    /**
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', [
            'user' => $user,
        ]);
    }

    /**
     * @param UpdateRequest $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request, User $user)
    {
        $user->fill([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
        ]);

        if ($request->has('password')) {
            $user->password = bcrypt($request->get('password'));
        }

        $user->save();

        $user->permissions()->sync((array) $request->get('permissions', []));

        Notification::success('User updated successfully.');

        return redirect()->route('admin.users.show', $user->id);
    }

    /**
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(User $user)
    {
        $user->delete();

        Notification::success('User deleted successfully.');

        return redirect()->route('admin.users.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * @param CreateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateRequest $request)
    {
        $user = new User([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
        ]);

        $user->save();

        $user->permissions()->sync((array) $request->get('permissions', []));

        Notification::success('User created successfully.');

        return redirect()->route('admin.users.show', $user->id);
    }

    public function impersonate(User $user)
    {
      if($user->isAdministrator()){
        Notification::success('You Are Already Logged in As Admin!');
        return redirect()->back();
      }
        auth()->user()->setImpersonating($user->id);
      	Notification::success('You are Signed is as '.$user->name);
        return redirect()->to('/account');

    }

    public function stopImpersonate()
    {
        $id = session()->get('impersonate');
        $user = User::find($id);
        auth()->user()->stopImpersonating();
        Notification::warning('You Have Stopped Impersonating '.$user->name);

        return redirect()->route('admin.users.index');
    }

    public function toggleActiveToIndex(User $user)
    {
      // If We Are Toggling Admin Prevent it
      if($user->isAdministrator()){
        Notification::error('You Cannot Deactivate or Activate An Admin');
        return redirect()->back();
      }
      $user->update([
        'activated' => !$user->activated
      ]);
      $message= 'Deactivated ';
      if($user->activated){
        $message = 'Activated ';
        Notification::success('You have '.$message.$user->name);
        return redirect()->route('admin.users.index');
      }
      Notification::error('You have '.$message.$user->name);
      return redirect()->route('admin.users.index');
    }

    public function toggleActiveToShow(User $user)
    {
      // If We Are Toggling Admin Prevent it
      if($user->isAdministrator()){
        Notification::error('You Cannot Deactivate or Activate An Admin');
        return redirect()->back();
      }
      $user->update([
        'activated' => !$user->activated
      ]);
      $message= 'Deactivated ';
      if($user->activated){
        $message = 'Activated ';
        Notification::success('You have '.$message.$user->name);
        return redirect()->route('admin.users.show', $user->id);
      }
      Notification::error('You have '.$message.$user->name);
      return redirect()->route('admin.users.show', $user->id);
    }

    public function resendActivationEmail(User $user)
    {
      $user = $user->toArray();
      $user['link'] = str_random(15);

      \DB::table('user_activations')->insert(['id_user'=>$user['id'],'token'=>$user['link']]);
      \Mail::send('emails.activation', $user, function($message) use ($user) {
          $message->to($user['email']);
          $message->subject(config('jarvis.site.name') . ' - Verify Your Email');
      });
      Notification::success('You Have Re-Sent Verification Email To '.$user['email']);
      return redirect()->back();
    }

    public function refreshTrial(User $user)
    {
      $user->update([
        'trial_ends_at' => \Carbon\Carbon::now()->addDays(7)
      ]);
      Notification::success('You Have Set Free Trial To '.$user->name);
      return redirect()->back();
    }

    public function removeTrial(User $user)
    {
      $user->update([
        'trial_ends_at' => null
      ]);
      Notification::error('You Have Remove Free Trial from '.$user->name);
      return redirect()->back();
    }
}
