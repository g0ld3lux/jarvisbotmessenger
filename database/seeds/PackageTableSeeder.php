<?php

use Illuminate\Database\Seeder;
use App\Models\Feature;
use App\Models\Package;

class PackageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $features = [
          // Monthly
          ['name'=> 'Create Projects', 'active' =>true], //1
          ['name'=> 'Create Flows', 'active' =>true], //2
          ['name'=> 'Connect with Multi Fan Pages', 'active' =>true], //3
          ['name'=> 'Add Welcome Screen', 'active' =>true], //4
          ['name'=> 'Add Persistent Menu', 'active' =>true], //5
          ['name'=> 'Send Structure Messages', 'active' =>true], //6
          ['name'=> 'Broadcast Mass Messages', 'active' =>true], //7
          ['name'=> 'Scheduled Messages', 'active' =>true], //8
          ['name'=> 'Subscribe User to Channels', 'active' =>true], //9
          ['name'=> 'Save User Input', 'active' =>true], //10
          ['name'=> 'Import/Export Flows', 'active' =>true], //11
          ['name'=> 'Toggle Bot Chat', 'active' =>true], //12
          ['name'=> 'Add RSS Feed Integration', 'active' =>true], //13
          ['name'=> 'Add Callback Integration', 'active' =>true], //14
          ['name'=> 'Tutorials', 'active' =>true], //15
          ['name'=> 'Support', 'active' =>true], //16

          //Yearly
          ['name'=> 'Discount', 'active' =>true], //17

          // Business Package Add On

          ['name'=> 'Create Products', 'active' =>true], //18
          ['name'=> 'Create Invoice', 'active' =>true], //19
          ['name'=> 'Send Receipt Template', 'active' =>true], //20
          ['name'=> 'Accept Payment Online', 'active' =>true], //21

          // Enterprise
          ['name'=> 'Access Full Source Code', 'active' =>true], //22
          ['name'=> 'Re-Brand/Whitelabel', 'active' =>true], //23
          ['name'=> 'Free Updates', 'active' =>true], // 24
          ['name'=> 'Customization', 'active' =>true], // 25


        ];

        foreach($features as $feature)
        {
          Feature::create($feature);
        }

        $packages = [
          ['name' => 'Premium Monthly', 'plan' => 'premium-monthly', 'cost' => 10.00, 'per' => 'month', 'active' => true, 'featured' => false, 'order' => 1],
          ['name' => 'Premium Yearly', 'plan' => 'premium-yearly', 'cost' => 100.00, 'per' => 'year', 'active' => true, 'featured' => true, 'order' => 2],
          ['name' => 'Business Pack Monthly', 'plan' => 'businesspack-monthly', 'cost' => 25.00, 'per' => 'year', 'active' => true, 'featured' => true, 'order' => 3],
          ['name' => 'Business Pack Yearly', 'plan' => 'businesspack-yearly', 'cost' => 250.00, 'per' => 'year', 'active' => true, 'featured' => true, 'order' => 4],
          ['name' => 'White Label', 'plan' => 'white label', 'cost' => 1000.00, 'per' => 'lifetime', 'active' => true, 'featured' => true, 'order' => 5],
        ];

        foreach($packages as $package)
        {
          Package::create($package);
        }

        $package = Package::find(1);
        $package->features()->sync([
           1 => ['feature_description' => 'Yes'],
           2 => ['feature_description' => 'Yes'],
           3 => ['feature_description' => 'Yes'],
           4 => ['feature_description' => 'Yes'],
           5 => ['feature_description' => 'Yes'],
           6 => ['feature_description' => 'Yes'],
           7 => ['feature_description' => 'Yes'],
           8 => ['feature_description' => 'Yes'],
           9 => ['feature_description' => 'Yes'],
           10 => ['feature_description' => 'Yes'],
           11 => ['feature_description' => 'Yes'],
           12 => ['feature_description' => 'Yes'],
           13 => ['feature_description' => 'Yes'],
           14 => ['feature_description' => 'Yes'],
           15 => ['feature_description' => 'Yes'],
           16 => ['feature_description' => 'Yes'],
        ]);

        $package = Package::find(2);
        $package->features()->sync([
           1 => ['feature_description' => 'Yes'],
           2 => ['feature_description' => 'Yes'],
           3 => ['feature_description' => 'Yes'],
           4 => ['feature_description' => 'Yes'],
           5 => ['feature_description' => 'Yes'],
           6 => ['feature_description' => 'Yes'],
           7 => ['feature_description' => 'Yes'],
           8 => ['feature_description' => 'Yes'],
           9 => ['feature_description' => 'Yes'],
           10 => ['feature_description' => 'Yes'],
           11 => ['feature_description' => 'Yes'],
           12 => ['feature_description' => 'Yes'],
           13 => ['feature_description' => 'Yes'],
           14 => ['feature_description' => 'Yes'],
           15 => ['feature_description' => 'Yes'],
           16 => ['feature_description' => 'Yes'],
           17 => ['feature_description' => '2 Months Off!'],
        ]);

        $package = Package::find(3);
        $package->features()->sync([
           1 => ['feature_description' => 'Yes'],
           2 => ['feature_description' => 'Yes'],
           3 => ['feature_description' => 'Yes'],
           4 => ['feature_description' => 'Yes'],
           5 => ['feature_description' => 'Yes'],
           6 => ['feature_description' => 'Yes'],
           7 => ['feature_description' => 'Yes'],
           8 => ['feature_description' => 'Yes'],
           9 => ['feature_description' => 'Yes'],
           10 => ['feature_description' => 'Yes'],
           11 => ['feature_description' => 'Yes'],
           12 => ['feature_description' => 'Yes'],
           13 => ['feature_description' => 'Yes'],
           14 => ['feature_description' => 'Yes'],
           15 => ['feature_description' => 'Yes'],
           16 => ['feature_description' => 'Yes'],

           18 => ['feature_description' => 'Yes'],
           19 => ['feature_description' => 'Yes'],
           20 => ['feature_description' => 'Yes'],
           21 => ['feature_description' => 'Yes'],
        ]);

        $package = Package::find(4);
        $package->features()->sync([
           1 => ['feature_description' => 'Yes'],
           2 => ['feature_description' => 'Yes'],
           3 => ['feature_description' => 'Yes'],
           4 => ['feature_description' => 'Yes'],
           5 => ['feature_description' => 'Yes'],
           6 => ['feature_description' => 'Yes'],
           7 => ['feature_description' => 'Yes'],
           8 => ['feature_description' => 'Yes'],
           9 => ['feature_description' => 'Yes'],
           10 => ['feature_description' => 'Yes'],
           11 => ['feature_description' => 'Yes'],
           12 => ['feature_description' => 'Yes'],
           13 => ['feature_description' => 'Yes'],
           14 => ['feature_description' => 'Yes'],
           15 => ['feature_description' => 'Yes'],
           16 => ['feature_description' => 'Yes'],
           17 => ['feature_description' => '2 Months Off!'],
           18 => ['feature_description' => 'Yes'],
           19 => ['feature_description' => 'Yes'],
           20 => ['feature_description' => 'Yes'],
           21 => ['feature_description' => 'Yes'],
        ]);

        $package = Package::find(5);
        $package->features()->sync([
           1 => ['feature_description' => 'Yes'],
           2 => ['feature_description' => 'Yes'],
           3 => ['feature_description' => 'Yes'],
           4 => ['feature_description' => 'Yes'],
           5 => ['feature_description' => 'Yes'],
           6 => ['feature_description' => 'Yes'],
           7 => ['feature_description' => 'Yes'],
           8 => ['feature_description' => 'Yes'],
           9 => ['feature_description' => 'Yes'],
           10 => ['feature_description' => 'Yes'],
           11 => ['feature_description' => 'Yes'],
           12 => ['feature_description' => 'Yes'],
           13 => ['feature_description' => 'Yes'],
           14 => ['feature_description' => 'Yes'],
           15 => ['feature_description' => 'Yes'],
           16 => ['feature_description' => 'Yes'],
           17 => ['feature_description' => '2 Months Off!'],
           18 => ['feature_description' => 'Yes'],
           19 => ['feature_description' => 'Yes'],
           20 => ['feature_description' => 'Yes'],
           21 => ['feature_description' => 'Yes'],
           22 => ['feature_description' => 'Yes'],
           23 => ['feature_description' => 'Yes'],
           24 => ['feature_description' => 'Yes'],
           25 => ['feature_description' => 'Yes'],
        ]);
    }
}
