<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class grade extends Model
{
    protected $table = 'grade';
    protected $fillable = ['id'];
    public $incrementing = false;
}
