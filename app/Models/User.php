<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Storage;

use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_photo_path'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    
    public function adminlte_image()
    {
        $user = User::with('roles')
                    ->where('id', auth()->user()->id)
                    ->get();        
        
        if(ucfirst($user[0]->roles[0]->name) == "Cliente"){
            return asset('images/iconos/cliente.jpg');
        }        

        if(ucfirst($user[0]->roles[0]->name) != "Cliente" && $user[0]->profile_photo_path == ""){
            return asset('images/iconos/usuario_default.png');
        }
        else{            
            $photo = $user[0]->profile_photo_path;
            return asset($photo);
        }
        
    }

    //relacion uno a muchos
    public function activities(){

        return $this->belongsTo('App\Models\Activity');

    }
 
    public function comments(){

        return $this->hasMany('App\Models\Comment');
    }

    public function orders(){

        return $this->hasMany('App\Models\Order');

    }

    public function adminlte_desc(){

        $user = User::with('roles')
                    ->where('id', auth()->user()->id)
                    ->get();        
       
        return ucfirst($user[0]->roles[0]->name);        
    }

}
