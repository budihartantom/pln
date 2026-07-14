<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TopsisRun extends Model
{
    protected $table = 'topsis_runs';
    protected $guarded = [];

    public function creator()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    public function details()
    {
        return $this->hasMany(TopsisRunDetail::class, 'topsis_run_id');
    }

    public function normalizedDetails()
    {
        return $this->hasMany(TopsisRunNormalized::class, 'topsis_run_id');
    }
}
