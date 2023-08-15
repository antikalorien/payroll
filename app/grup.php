<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class grup extends Model
{
    protected $table = 'grup';
    protected $fillable = ['id'];
    public $incrementing = false;
}
