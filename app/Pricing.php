<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pricing extends Model
{
    protected $fillable = ['className', 'fees', 'user_id'];
    public $timestamps = false;
}
