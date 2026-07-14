<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengukuranTeganganUjungJtr extends Model
{
    protected $table = 'pengukuran_tegangan_ujung_jtr';
    protected $guarded = [];

    public function pengukuran()
    {
        return $this->belongsTo(Pengukuran::class);
    }
}
