<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    protected $table = 'pasien';

    protected $fillable = [
        'nama',
        'tgl_lahir',
        'gender',
        'alamat',
    ];

    protected $dates = ['tgl_lahir'];
}
