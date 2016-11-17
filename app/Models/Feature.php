<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    protected $table = 'features';

    protected $fillable = ['name', 'active'];

    protected $casts = [
       'active' => 'boolean',
   ];

   protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function packages()
    {
      return $this->belongsToMany('App\Models\Package', 'feature_package', 'feature_id', 'package_id')
      ->withPivot('feature_description')
      ->withTimestamps();
    }

    // Commented because we already have cascade delete in our pivot table
    // public static function boot() {
    //     parent::boot();
    //
    //     static::deleting(function($feature) {
    //          $feature->packages()->detach();
    //     });
    // }
}
