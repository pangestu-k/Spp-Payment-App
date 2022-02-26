<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    use HasFactory;

    protected $table = 'table_petugas';
    protected $primaryKey = 'id_petugas';
    protected $fillable = ['username', 'email', 'password', 'nama_petugas', 'level'];
}
