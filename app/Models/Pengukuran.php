<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengukuran extends Model
{
    protected $guarded = [];

    public function gardu()
    {
        return $this->belongsTo(Gardu::class);
    }

    public function jurusanBebans()
    {
        return $this->hasMany(PengukuranJurusanBeban::class);
    }

    public function teganganUjungJtrs()
    {
        return $this->hasMany(PengukuranTeganganUjungJtr::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
