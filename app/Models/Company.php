<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = ['id'];
    protected $with = ['meta'];

    public function users()
    {
      return $this->hasMany('App\Models\User');
    }

    public function meta()
    {
      return $this->hasMany('App\Models\CompanyMeta');
    }

    public function departments()
    {
      return $this->hasMany('App\Models\Department');
    }

    public function media()
    {
        return $this->morphMany('App\Models\Media', 'mediaable');
    }

    public function subscriptions()
    {
      return $this->belongsToMany('App\Models\Subscription')->as('subscription')->withPivot('start_date','end_date');
    }

    public function attendance()
    {
        return $this->hasMany('App\Models\Attendance');
    }

}
