<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;
use Session;
use Carbon\Carbon;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'activated','trial_ends_at',
    ];

    /**
     * The attributes excluded from the model's json form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $cast = [
      'activated' => 'boolean',
    ];

    protected $dates = [
       'created_at',
       'updated_at',
       'trial_ends_at',
       'subscription_ends_at',
   ];

    /**
     * Boot the model.
     * Automatically Append this during Creation of USER
     * But is Easily Override if an Attribute is Given.
     */
    public static function boot()
    {
        parent::boot();
        static::creating(function ($user) {
          $google2fa = app()->make('PragmaRX\Google2FA\Contracts\Google2FA');
            $user->google2fa_secret = $google2fa->generateSecretKey(32);
            // Add 7 Days Trial to Newly Created Account
            $user->trial_ends_at = Carbon::now()->addDays(7);
        });
    }

    /**
     * Get user projects.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projects()
    {
        return $this->hasMany(Project::class, 'user_id');
    }

    /**
     * Get user permissions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'users_permissions', 'user_id', 'permission_id');
    }

    /**
     * @return mixed
     */
    public function getDisplayNameAttribute()
    {
        if (Str::length($this->name) > 0) {
            return $this->name;
        }

        return $this->email;
    }

    /**
     * Get user social accounts
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function socialAccounts()
    {
        return $this->hasMany(SocialAccount::class);
    }

    public function setImpersonating($id)
    {
        Session::put('impersonate', $id);
    }

    public function stopImpersonating()
    {
        Session::forget('impersonate');
    }

    public function isImpersonating()
    {
        return Session::has('impersonate');
    }

    public function isAdministrator()
    {
      if($this->permissions()->where('permission', 'access.admin')->first() && $this->permissions()->where('permission', 'master')->first())
      {
        return true;
      }
      return false;
    }

    public function trialExpired()
    {
      $date =$this->trial_ends_at;
      if(is_null($date))
      {
        return null;
      }
      elseif($date >= Carbon::now())
      {
        // Not Yet Expired
        return false;
      }else{
        // Expired
        return true;
      }
    }

    public function subscriptionExpired()
    {
      $date = $this->subscription_ends_at;
      if(is_null($date))
      {
        return null;
      }
      elseif($date >= Carbon::now())
      {
        // Not Yet Expired
        return false;
      }else{
        // Expired
        return true;
      }

    }
}
