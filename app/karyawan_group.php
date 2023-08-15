<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class karyawan_group extends Model
{
    protected $table = 'karyawan_group';
    protected $fillable = ['id'];
    public $incrementing = false;
}
