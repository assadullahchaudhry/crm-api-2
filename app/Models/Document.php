<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model
{
    use HasFactory;
    protected $table = 'auc_folder_documents';
    public $incrementing = false;

    //protected $with = ['owner'];

    // public function owner()
    // {
    //     return $this->belongsTo(User::class, 'ownerId', 'id');
    // }
}
