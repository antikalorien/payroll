<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class karyawan_hutang_perusahaan extends Model
{
    protected $table = 'karyawan_hutang_perusahaan';
    protected $fillable = ['id'];
    public $incrementing = false;
}
