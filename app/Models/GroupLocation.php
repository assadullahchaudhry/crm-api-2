<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GroupLocation extends Model
{
    use HasFactory;
    protected $table = 'auc_group_locations';

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
