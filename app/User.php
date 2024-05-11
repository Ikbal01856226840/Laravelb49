<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Session;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function shops():HasMany
    {
        return $this->hasMany(User::class, 'parent_id', 'id');
    }

    public function salesParent():HasMany
    {
        return $this->hasMany(Sale::class, 'user_id', 'id');
    }

    public function salesSoldBy():HasMany
    {
        return $this->hasMany(Sale::class, 'sold_by', 'id');
    }

    public function expenseParent():HasMany
    {
        return $this->hasMany(Expense::class, 'parent_id', 'id');
    }

    public function expenseUser():HasMany
    {
        return $this->hasMany(Expense::class, 'user_id', 'id');
    }

    public function sale():HasMany
    {
        return $this->hasMany(Sale::class, 'user_id', 'id');
    }
}
