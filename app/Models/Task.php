<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $with = ['user','assignee','employee'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function assignee()
    {
        return $this->belongsTo('App\Models\User','assigned_to');
    }

    public function employee()
    {
        return $this->belongsTo('App\Models\User','type_id');
    }
}
