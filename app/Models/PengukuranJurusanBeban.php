<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengukuranJurusanBeban extends Model
{
    protected $table = 'pengukuran_jurusan_beban';
    protected $guarded = [];

    public function pengukuran()
    {
        return $this->belongsTo(Pengukuran::class);
    }
}
