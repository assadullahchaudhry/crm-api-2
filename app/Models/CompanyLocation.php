<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyLocation extends Model
{
    protected $table = 'auc_company_locations';

    protected $with = ['country', 'state', 'city'];

    public function country()
    {
        return $this->belongsTo(Country::class, 'countryId');
    }
    public function state()
    {
        return $this->belongsTo(State::class, 'stateId');
    }
    public function city()
    {
        return $this->belongsTo(City::class, 'cityId');
    }
}
