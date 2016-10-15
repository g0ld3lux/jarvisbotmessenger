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
            'projects' => $user->projects,
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
      // Guard against administrator impersonate
      if(! $user->isAdministrator())
      {
      	auth()->user()->setImpersonating($user->id);
      }
      else
      {
      	Notification::error('You Have No Such Priviledges!.');
      }

      return redirect()->to('/account');
    }

    public function stopImpersonate()
    {
        auth()->user()->stopImpersonating();

        Notification::success('Welcome Back Admin!');

        return redirect()->route('admin.users.index');
    }
}
