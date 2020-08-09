<?php

namespace App\Model\Supplier;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'supplier';

    public function company(){
        return $this->belongsTo('App\Model\Company\Company', 'company_id');
    }
}
