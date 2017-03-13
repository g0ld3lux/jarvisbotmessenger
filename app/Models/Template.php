<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Conner\Tagging\Taggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Category;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class Template extends Model
{
    /**
     * Use the Following Traits
     *
     */
    //  We Can Invoke findBySlug($var) and findBySlugOrFail($var) with SluggableScopeHelpers
    // We Can Invoke tag() , untag() retag() tagNames() ::withAnyTag([])->get()  ::existingTags() with Taggable
    use Taggable, SoftDeletes, Sluggable, SluggableScopeHelpers;

    /**
     * Cast Model Properties
     *
     */
    protected $casts = [
        'flows' => 'array',
        'approved' => 'boolean'
    ];

    /**
     * Cast Model Type to Date
     *
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * Set Properties to be Mass Assignable
     *
     */
    protected $fillable = ['name', 'description', 'flows'];

    /**
     * Set the Slug From Source Property , Can be an Array
     *
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    /**
     * Get the route key for the model.
     *  Allows Use to Use it On Our Route Model Binding
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Set Relationship Many to Many
     * Templates and Categories
     */
    public function categories()
  	{
    return $this->belongsToMany(Category::class)->withTimestamps();
  	}
    /**
     * Only Return An Approved template
     *
     */
    public function scopeApproved($query)
    {
        return $query->where('approved', true);
    }
    /**
     * Find Template by Name , return an Array of Template
     *
     */
    public static function findByName($name)
    {
        return self::where('name', $name)->get();
    }
    /**
     * Mutators to Get Category List 
     * $template->categorylist
     *
     */
    public function getCategorylistAttribute()
    {
        return $this->categories->pluck('id');
    }

}
