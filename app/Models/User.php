<?php

/**
 * User Model
 *
 * User Model manages User operation.
 *
 * @category   User
 * @package    vRent
 * @author     Techvillage Dev Team
 * @copyright  2020 Techvillage
 * @license
 * @version    2.7
 * @link       http://techvill.net
 * @since      Version 1.3
 * @deprecated None
 */

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\UserDetails;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = ['profile_src'];

    public function users_verification()
    {
        return $this->hasOne('App\Models\UsersVerification', 'user_id', 'id');
    }

    public function payouts()
    {
        return $this->hasMany('App\Models\Payouts', 'user_id', 'id');
    }

    public function accounts()
    {
        return $this->hasMany('App\Models\Account', 'user_id', 'id');
    }

    public function bookings()
    {
        return $this->hasMany('App\Models\Bookings', 'user_id', 'id');
    }

    public function notifications()
    {
        return $this->hasMany('App\Models\Notification', 'user_id', 'id');
    }

    public function reports()
    {
        return $this->hasMany('App\Models\Report', 'user_id', 'id');
    }


    public function user_details()
    {
        return $this->hasMany('App\Models\UserDetail', 'user_id', 'id');
    }

    public function payments()
    {
        return $this->hasMany('App\Models\Payment', 'user_id', 'id');
    }

    public function withdraw()
    {
        return $this->hasMany('App\Models\Withdrawal', 'user_id', 'id');
    }

    public function properties()
    {
        return $this->hasMany('App\Models\Properties', 'host_id', 'id');
    }

    public function reviews()
    {
        return $this->hasMany('App\Models\Reviews', 'sender_id', 'id');
    }

    public function getProfileSrcAttribute()
    {
        if ($this->attributes['profile_image'] == '') {
            $src = asset('public/images/default-profile.png');
        } else {
            $src = url('public/images/profile/'.$this->attributes['id'].'/'.$this->attributes['profile_image']);
        }

        return $src;
    }

    public function details_key_value()
    {
        $details = UserDetails::where('user_id', $this->attributes['id'])->pluck('value', 'field');
        return $details;
    }

    public function getAccountSinceAttribute()
    {
        $since = date('F Y', strtotime($this->attributes['created_at']));
        return $since;
    }

    public function getFullNameAttribute()
    {
        $full_name = ucfirst($this->attributes['first_name']).' '.ucfirst($this->attributes['last_name']);
        return $full_name;
    }
}
