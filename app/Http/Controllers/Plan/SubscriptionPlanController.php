<?php

namespace App\Http\Controllers\Plan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Package;

class SubscriptionPlanController extends Controller
{
  public function index(Request $request)
  {

    $search = $request->get('search');

    $packages = Package::with('features')->orderBy('order', 'asc');

    if ($search) {
        $packages = $packages->where(function ($query) use ($search) {
            $query
                ->where('id', '=', $search)
                ->orWhere('name', 'like', '%'.$search.'%')
                ->orWhere('plan', 'like', '%'.$search.'%');
        });
    }

    $packages = $packages->paginate(4);

    if ($search) {
        $packages->appends(['search' => $search]);
    }

    return view('plans.index', [
        'packages' => $packages,
        'search' => $search,
    ]);
  }

}
