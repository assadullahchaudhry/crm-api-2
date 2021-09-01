<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{

    use HasFactory;

    protected $table = 'auc_groups';
    public $incrementing = false;

    protected $with = ['location', 'phones'];

    public function location()
    {
        return $this->hasOne(GroupLocation::class, 'groupId', 'id');
    }

    public function phones()
    {
        return $this->hasMany(GroupPhone::class, 'groupId', 'id');
    }
}
