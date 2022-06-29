<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $with = ['assignee'];
    public function meta()
    {
      return $this->hasMany('App\Models\AssetMeta');
    }

    public function assignee()
    {
      return $this->belongsTo('App\Models\User','assigned_to');
    }
}
