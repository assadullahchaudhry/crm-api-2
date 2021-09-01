<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = 'auc_tickets';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'companyId',
        'subject',
        'description',
        'status',
        'createdBy',
        'assignedTo',
        'priority',
    ];
}
