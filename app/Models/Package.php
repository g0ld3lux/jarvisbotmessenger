<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $table = 'packages';

    protected $fillable = ['name', 'plan', 'cost', 'currency_code', 'per', 'active', 'featured', 'order'];

    protected $casts = [
       'active' => 'boolean',
       'featured' => 'boolean',
   ];

   protected $dates = [
        'created_at',
        'updated_at',
    ];


    public function features()
    {
        return $this->belongsToMany('App\Models\Feature', 'feature_package', 'package_id', 'feature_id')
        ->withPivot('feature_description')
        ->withTimestamps();
    }

    public static function findByPlan($plan)
    {
      return self::where('plan', $plan)->firstOrFail();
    }

    // $package->features()->attach(1, ['feature_description' => 'text description']);
    // $package->features()->sync([
    // 1 => ['feature_description' => 'this is my description'],
    // ]);
}
