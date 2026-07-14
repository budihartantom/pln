<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TopsisBobot extends Model
{
    protected $table = 'topsis_bobots';
    protected $guarded = [];

    public function kriteria()
    {
        return $this->belongsTo(TopsisKriteria::class, 'kriteria_id');
    }
}
