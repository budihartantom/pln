<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TopsisRunDetail extends Model
{
    protected $table = 'topsis_run_details';
    protected $guarded = [];

    public function topsisRun()
    {
        return $this->belongsTo(TopsisRun::class, 'topsis_run_id');
    }

    public function gardu()
    {
        return $this->belongsTo(Gardu::class);
    }
}
