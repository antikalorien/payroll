<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class group_sub extends Model
{
    protected $table = 'group_sub';
    protected $fillable = ['id'];
    public $incrementing = false;
}
