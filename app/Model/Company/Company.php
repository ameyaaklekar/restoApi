<?php

namespace App\Model\Company;

use Laratrust\Models\LaratrustTeam;

class Company extends LaratrustTeam
{
    public $guarded = [];

    public function users() {
        return $this->hasMany('App\Model\User', 'company_id');
    }
}
