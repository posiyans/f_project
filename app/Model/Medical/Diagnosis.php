<?php

namespace App\Model\Medical;

use Illuminate\Database\Eloquent\Model;

use App\Model\Medical\Mkb;

class Diagnosis extends Model
{
    //
    public function mkb()
    {
         return $this->hasOne(Mkb::class, 'id', 'mkb_id');
    }
}
