<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable implements MustVerifyEmail
{
    use HasRoles, HasFactory, Notifiable;

    protected $guarded = ['id'];
    protected $with = ['department'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function hasVerifiedPhone()
    {
        return $this->phone_verified_at ? true : false;
    }

    public function markPhoneAsVerified()
    {
        $this->phone_verified_at = now();
        $this->save();
    }

    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }

    public function tasks()
    {
        return $this->hasMany('App\Models\Task');
    }

    public function assigned()
    {
        return $this->hasMany('App\Models\Task','assigned_to');
    }

    public function education()
    {
        return $this->hasMany('App\Models\Education');
    }

    public function certifications()
    {
        return $this->hasMany('App\Models\Certification');
    }

    public function work_experiences()
    {
        return $this->hasMany('App\Models\WorkExperience');
    }

    public function languages()
    {
        return $this->hasMany('App\Models\Language');
    }

    public function dependants()
    {
        return $this->hasMany('App\Models\Dependant');
    }

    public function beneficiaries()
    {
        return $this->hasMany('App\Models\Beneficiary');
    }

    public function emergency_contacts()
    {
        return $this->hasMany('App\Models\EmergencyContact');
    }


    public function department()
    {
        return $this->belongsTo('App\Models\Department');
    }

    public function referees()
    {
        return $this->hasMany('App\Models\Referee');
    }

    public function meta()
    {
      return $this->hasMany('App\Models\UserMeta');
    }

    public function benefits()
    {
      return $this->hasMany('App\Models\Benefit');
    }

    public function deductions()
    {
      return $this->hasMany('App\Models\Deduction');
    }

    public function payrolls()
    {
      return $this->belongsToMany('App\Models\Payrolls');
    }

    public function supervisor()
    {
      return $this->belongsTo('App\Models\User','reports_to');
    }

    public function leaves()
    {
      return $this->hasmany('App\Models\Leave','employee_id');
    }

    public function assets()
    {
      return $this->hasmany('App\Models\Asset','assigned_to');
    }

    public function media()
    {
        return $this->morphMany('App\Models\Media', 'mediaable');
    }

    
}
