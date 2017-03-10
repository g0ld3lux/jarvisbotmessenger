<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Template;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class Category extends Model
{
    /**
     * Use The Following Trait
     *
     */
    //  We Can Invoke findBySlug($var) and findBySlugOrFail($var) with SluggableScopeHelpers
    use SoftDeletes, Sluggable, SluggableScopeHelpers;

    /**
     * Cast Model Type to Date
     *
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    /**
     * Set Properties to be Mass Assignable
     *
     */
    protected $fillable = ['name', 'description'];
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
     * Set Many to Many Relationship
     * Category - Temaplates
     */
    public function templates()
    {
    return $this->belongsToMany(Template::class)->withTimestamps();
    }
    /**
     * Find Categories by Name , Give you an Array of Category
     *
     */
    public static function findByName($name)
    {
        return self::where('name', $name)->get();
    }
}
