<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TanggalNonaktif extends Model
{
    protected $table = 'tanggal_nonaktif';
    protected $fillable = ['tanggal', 'keterangan'];
}
