<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;


    protected $fillable = [
        'avatar',
        'sponsor_code',
        'sponsor_code_parent_id',
        'name',
        'last_name',
        'country',
        'state',
        'city',
        'identity_document_name',
        'identity_document_number',
        'wallet',
        'phone_number',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /*
    public function sponsors(){
        return $this->hasMany(Product::class);
    }
    */


    public function adminlte_image(){
        return asset('storage/avatars/'.Auth::user()->avatar);
    }

    public function adminlte_desc(){
        if(Auth::user()->roles->first())
        {
            return Auth::user()->roles->first()->name;
        }
        else{
            "no autorizado";
        }

    }

    public function adminlte_profile_url(){
        //$user=User::where('id',Auth::user()->id)->first();
        return "admin/profile";
    }


    public function tickets(){
        return $this->hasMany(Tickets::class);
    }
    public function contracts(){
        return $this->hasMany(Contracts::class);
    }
}
