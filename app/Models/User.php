<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;
use Session;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
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
      if($this->id==1)
      {
        return true;
      }
      return false;
    }
}
