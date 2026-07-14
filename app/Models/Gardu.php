<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gardu extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function pengukurans()
    {
        return $this->hasMany(Pengukuran::class);
    }

    public function topsisRunDetails()
    {
        return $this->hasMany(TopsisRunDetail::class);
    }
}
