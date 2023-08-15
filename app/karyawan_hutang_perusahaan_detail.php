<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class karyawan_hutang_perusahaan_detail extends Model
{
    protected $table = 'karyawan_hutang_perusahaan_detail';
    protected $fillable = ['id'];
    public $incrementing = false;
}
