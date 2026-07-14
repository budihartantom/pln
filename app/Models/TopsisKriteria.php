<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TopsisKriteria extends Model
{
    protected $table = 'topsis_kriterias';
    protected $guarded = [];

    public function bobots()
    {
        return $this->hasMany(TopsisBobot::class, 'kriteria_id');
    }

    public function currentBobot()
    {
        return $this->hasOne(TopsisBobot::class, 'kriteria_id')->latestOfMany();
    }
}
