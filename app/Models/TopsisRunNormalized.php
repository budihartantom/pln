<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TopsisRunNormalized extends Model
{
    protected $table = 'topsis_run_normalizeds';
    protected $guarded = [];

    public function topsisRun()
    {
        return $this->belongsTo(TopsisRun::class, 'topsis_run_id');
    }

    public function gardu()
    {
        return $this->belongsTo(Gardu::class);
    }

    public function kriteria()
    {
        return $this->belongsTo(TopsisKriteria::class, 'kriteria_id');
    }
}
