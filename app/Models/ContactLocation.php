<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactLocation extends Model
{
    use HasFactory;
    protected $table = 'auc_contact_locations';

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
