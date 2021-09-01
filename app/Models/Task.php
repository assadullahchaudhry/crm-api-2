<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $table = 'auc_tasks';
    public $incrementing = false;

    protected $with = ['assignee', 'company'];

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assignedTo', 'id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'companyId', 'id');
    }
}
