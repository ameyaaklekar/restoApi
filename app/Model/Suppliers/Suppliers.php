<?php

namespace App\Model\Suppliers;

use Illuminate\Database\Eloquent\Model;

class Suppliers extends Model
{
    protected $table = 'suppliers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'email',  
        'contact_person',
        'country_code', 
        'contact',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'company_id',
        'status'
    ];

    public function company(){
        return $this->belongsTo('App\Model\Company\Company', 'company_id');
    }
}
