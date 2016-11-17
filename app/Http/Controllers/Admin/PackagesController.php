<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\{Package,Feature};
use Validator;

class PackagesController extends Controller
{
    /**
     * Display all Packages
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $packages = Package::all();
        // return view('admin.packages.index')->with('packages', $packages);

        $search = $request->get('search');

        $packages = Package::orderBy('order', 'asc');

        if ($search) {
            $packages = $packages->where(function ($query) use ($search) {
                $query
                    ->where('id', '=', $search)
                    ->orWhere('name', 'like', '%'.$search.'%')
                    ->orWhere('plan', 'like', '%'.$search.'%');
            });
        }

        $packages = $packages->paginate(30);

        if ($search) {
            $packages->appends(['search' => $search]);
        }

        return view('admin.packages.index', [
            'packages' => $packages,
            'search' => $search,
        ]);
    }

    /**
     * Show the form for creating a new Package with Feature List (Only Active Feature)
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $featurelist = Feature::where('active', true)->pluck('name', 'id')->all();
        return view('admin.packages.create')->with('featurelist', $featurelist);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      // Custom Message
    $messages = [
      'feature_description.*.required_if' => 'Feature is Enabled but Has No Description!',
   ];
   // Custom Rules
   $rules = [
         'name' => 'required|max:30',
         'plan' => 'required|unique:packages,plan|max:30',
         'cost' => 'required|regex:/^[0-9]+(\\.[0-9]+)?$/',
         'per' => 'required|in:month,year,lifetime',
         'currency_code' => 'required|max:4',
         'active' => 'in:on',
         'featured' => 'in:on',
         'order' => 'required|integer',
         'feature_active.*' => 'in:on',
         'feature_description.*' => 'required_if:feature_active.*,on|:max:30',
         'feature_id.*' => 'exists:features,id'
   ];

   // Validate Request
    $validator = Validator::make($request->all(), $rules,$messages);

    if(!is_null($request->input('feature_active')) && !is_null($request->input('feature_description')))
    {
      // Custom Validation For Inactive Features
      $feature_description = $request->input('feature_description');
      $feature_active = $request->input('feature_active');

      // Filter null , 0 , '' or false
      $feature_description = array_filter($feature_description);
      $feature_active = array_filter($feature_active);
      // Add this 2 Variable
      $activeID;
      $inactiveID;
      // At least One Feature is Enable then Filled Up activeID Array
      if(!empty($feature_active))
      {
        // Put all those ID to $activeID
        foreach($feature_active as $id => $val)
        {
          $activeID[]=[$id => $id];
        }
      }
      // At Least One Description Has Value then Filled Up inactiveID Array
      if(!empty($feature_description))
      {
        // Put All Those ID to $inactiveID
        foreach($feature_description as $id => $val)
        {
          $inactiveID[]=[$id => $id];
        }
      }else {
        $inactiveID[]=[];
      }
    // Merge All ID
    $feature_active_id = array_merge($activeID,$inactiveID);
    // Flatten Array of Full List to its Value
    $feature_active_id = array_flatten($feature_active_id);
    // Flatten Active Array to its Value
    $activeOnlyList = array_flatten($activeID);
    // You cannot use array_flip if the featured Id is not flatten
    $featuredActiveList = array_keys(array_flip($feature_active_id));
    // Get Only the Difference In The Array To Get Inactive
    $inactive =  array_diff($featuredActiveList,$activeOnlyList);
    // Loop thru all Inactive ID
    foreach($inactive as $id)
    {
            // Add Each New Error Message per ID
            $validator->after(function($validator) use ($id) {
              return $validator->errors()->add('feature_active.'.$id, 'Enable The Feature For This Description!');
            });
    }
    }
  // Return If there is Error in the Validation
    if ($validator->fails()) {
        return redirect()->route('admin.packages.create')
                      ->withErrors($validator)
                      ->withInput();
    }
    // Prepare Data
    $data= [
      'name' => $request->input('name'),
      'plan' => $request->input('plan'),
      'cost' => $request->input('cost'),
      'per' => $request->input('per'),
      'currency_code' => $request->input('currency_code'),
      'active' => ($request->input('active') === 'on') ? true : false,
      'featured' => ($request->input('featured') === 'on') ? true : false,
      'order' => $request->input('order'),
    ];
    // Create a New Package
    $package = Package::create($data);
    // If There are No Features Create Package then Redirect to Create a New Feature Route...
    // If There are Features Then Check It From The List of Features

      if($request->input('feature_active'))
      {
        $activefeatures = $request->input('feature_active');
        $feature_description = $request->input('feature_description');


        $featurelist=[];
        // We need put into a List all Packages that are Active
        foreach($activefeatures as $id => $val)
        {
          if($val === 'on'){
            $featurelist[$id]=['feature_description' => $feature_description[$id]];
          }
        }



        $package->features()->sync($featurelist);

      }
      // If No feature_active is suplied just Go to Index then


      return redirect()->route('admin.packages.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $list_of_ID_of_choosen_features = $package->features->pluck('id');
        // // We Want the Feature Description
        // $list_of_ID_of_active_features = Feature::where('active', true)->pluck('id')->all();
        $featurelist = Feature::where('active', true)->pluck('name', 'id')->all();
        $package = Package::findOrFail($id);
        $activelist = $package->features->pluck('pivot.feature_description', 'id');
        return view('admin.packages.show')->with('featurelist', $featurelist)->with('activelist', $activelist)->with('package' ,$package);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $featurelist = Feature::where('active', true)->pluck('name', 'id')->all();
      $package = Package::findOrFail($id);
      $activelist = $package->features->pluck('pivot.feature_description', 'id');

      return view('admin.packages.edit')->with('featurelist', $featurelist)->with('activelist', $activelist)->with('package', $package);
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
      $packageID = $id;
      $messages = [
        'feature_description.*.required_if' => 'Feature is Enabled but Has No Description!',
     ];
     // Custom Rules
     $rules = [
           'name' => 'required|max:30',
           'plan' => 'required|max:30',
           'cost' => 'required|regex:/^[0-9]+(\\.[0-9]+)?$/',
           'per' => 'required|in:month,year,lifetime',
           'currency_code' => 'required|max:4',
           'active' => 'in:on',
           'featured' => 'in:on',
           'order' => 'required|integer',
           'feature_active.*' => 'in:on',
           'feature_description.*' => 'required_if:feature_active.*,on|:max:30',
           'feature_id.*' => 'exists:features,id'
     ];

     // Validate Request
      $validator = Validator::make($request->all(), $rules,$messages);

      if(!is_null($request->input('feature_active')) && !is_null($request->input('feature_description')))
      {
        // Custom Validation For Inactive Features
        $feature_description = $request->input('feature_description');
        $feature_active = $request->input('feature_active');

        // Filter null , 0 , '' or false
        $feature_description = array_filter($feature_description);
        $feature_active = array_filter($feature_active);
        // Add this 2 Variable
        $activeID;
        $inactiveID;
        // At least One Feature is Enable then Filled Up activeID Array
        if(!empty($feature_active))
        {
          // Put all those ID to $activeID
          foreach($feature_active as $id => $val)
          {
            $activeID[]=[$id => $id];
          }
        }
        // At Least One Description Has Value then Filled Up inactiveID Array
        if(!empty($feature_description))
        {
          // Put All Those ID to $inactiveID
          foreach($feature_description as $id => $val)
          {
            $inactiveID[]=[$id => $id];
          }
        }else {
          $inactiveID[]=[];
        }
      // Merge All ID
      $feature_active_id = array_merge($activeID,$inactiveID);
      // Flatten Array of Full List to its Value
      $feature_active_id = array_flatten($feature_active_id);
      // Flatten Active Array to its Value
      $activeOnlyList = array_flatten($activeID);
      // You cannot use array_flip if the featured Id is not flatten
      $featuredActiveList = array_keys(array_flip($feature_active_id));
      // Get Only the Difference In The Array To Get Inactive
      $inactive =  array_diff($featuredActiveList,$activeOnlyList);
      // Loop thru all Inactive ID
      foreach($inactive as $id)
      {
              // Add Each New Error Message per ID
              $validator->after(function($validator) use ($id) {
                return $validator->errors()->add('feature_active.'.$id, 'Enable The Feature For This Description!');
              });
      }
      }
    // Return If there is Error in the Validation

      if ($validator->fails()) {
          return redirect()->route('admin.packages.edit', ['id' => $packageID])
                        ->withErrors($validator)
                        ->withInput();
      }
      // Update New Value of Package

      $package = Package::findOrFail($packageID);

      $data= [
        'name' => $request->input('name'),
        'plan' => $request->input('plan'),
        'cost' => $request->input('cost'),
        'per' => $request->input('per'),
        'currency_code' => $request->input('currency_code'),
        'active' => ($request->input('active') === 'on') ? true : false,
        'featured' => ($request->input('featured') === 'on') ? true : false,
        'order' => $request->input('order'),
      ];

      $package->update($data);

      $activefeatures = $request->input('feature_active');
      $feature_description = $request->input('feature_description');
      $feature_id = $request->input('feature_id');


      if($request->input('feature_active'))
      {
        $activefeatures = $request->input('feature_active');
        $feature_description = $request->input('feature_description');


        $featurelist=[];
        // We need put into a List all Packages that are Active
        foreach($activefeatures as $id => $val)
        {
          if($val === 'on'){
            $featurelist[$id]=['feature_description' => $feature_description[$id]];
          }
        }



        $package->features()->sync($featurelist);

      }
      return redirect()->route('admin.packages.show', ['id' => $package->id]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $package = Package::findOrFail($id);
      $package->delete();
      return redirect()->route('admin.packages.index');
    }

    public function toggleFeatured($id)
    {
      $package = Package::findOrFail($id);
      $package->featured = !$package->featured;
      $package->save();
      return redirect()->route('admin.packages.index');
    }

    public function toggleActive($id)
    {
      $package = Package::findOrFail($id);
      $package->active = !$package->active;
      $package->save();
      return redirect()->route('admin.packages.index');
    }


}
