<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prospect extends Model
{
    use HasFactory;
    protected $table = 'auc_prospects';
    public $incrementing = false;

    protected $with = ['contact', 'group', 'stage', 'action'];

    public function contact()
    {
        return $this->hasOne(Contact::class, 'id', 'contactId');
    }

    public function stage()
    {
        return $this->hasoNe(Stage::class, 'id', 'stageId');
    }

    public function action()
    {
        return $this->hasoNe(Action::class, 'id', 'actionId');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'groupId', 'id');
    }
}
