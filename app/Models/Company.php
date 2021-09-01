<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $table = 'auc_companies';
    public $incrementing = false;

    //protected $with = ['location', 'group', 'contacts'];

    // public function location()
    // {
    //     return $this->hasOne(CompanyLocation::class, 'companyId', 'id');
    // }

    // public function contacts()
    // {
    //     return $this->hasMany(Contact::class, 'id', 'companyId');
    // }

    // public function group()
    // {
    //     return $this->belongsTo(Group::class, 'groupId', 'id');
    // }
}
