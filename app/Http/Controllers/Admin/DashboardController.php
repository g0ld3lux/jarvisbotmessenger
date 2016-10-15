<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;

class DashboardController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex()
    {
        $users = User::orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.dashboard.index', [
            'users' => $users,
        ]);
    }
}
