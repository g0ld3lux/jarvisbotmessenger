<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\Feature;
use Validator;

class FeaturesController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
      // $features = Feature::all();
      // return view('admin.features.index')->with('features', $features);

      $search = $request->get('search');

      $features = Feature::orderBy('id', 'asc');

      if ($search) {
          $features = $features->where(function ($query) use ($search) {
              $query
                  ->where('id', '=', $search)
                  ->orWhere('name', 'like', '%'.$search.'%');
          });
      }

      $features = $features->paginate(30);

      if ($search) {
          $features->appends(['search' => $search]);
      }

      return view('admin.features.index', [
          'features' => $features,
          'search' => $search,
      ]);
  }

  /**
   * Show the form for creating a new resource.
   * This Form Can Submit Multiple Features
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    // if view return has already old input
    // make a logic in blade to show all old input
      return view('admin.features.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {

    $validator = Validator::make($request->all(), [
          'name' => 'required|max:30',
    ]);

    if ($validator->fails()) {
        return redirect()->route('admin.features.create')
                      ->withErrors($validator)
                      ->withInput();
    }
    $active = ($request->input('active') === 'on') ? true : false;

    Feature::create([
      'name' => $request->input('name'),
      'active' => $active
    ]);

    return redirect()->route('admin.features.index');

  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
      $feature = Feature::findOrFail($id);
      return view('admin.features.show')->with('feature', $feature);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
      $feature = Feature::findOrFail($id);
      return view('admin.features.edit')->with('feature', $feature);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $validator = Validator::make($request->all(), [
          'name' => 'required|max:30',
    ]);

    if ($validator->fails()) {
        return redirect()->route('admin.features.edit',['id' => $id])
                      ->withErrors($validator)
                      ->withInput();
    }
    // Update With new Input
    $feature = Feature::findOrFail($id);
    $feature->name = $request->input('name');
    $feature->active = ($request->input('active') === 'on') ? true : false;
    $feature->save();

    return redirect()->route('admin.features.show', ['id' => $id]);
  }

  /**
   * You cannot Use Implicit Model Binding Here
   * You Cannot Delete It , so Just Revert to Manual FindOrFail
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
      $feature = Feature::findOrFail($id);
      $feature->delete();
      return redirect()->route('admin.features.index');
  }

  public function toggleActive($id)
  {
    $feature = Feature::findOrFail($id);
    $feature->active = !$feature->active;
    $feature->save();
    return redirect()->route('admin.features.index');
  }
}
