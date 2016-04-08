<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTask extends Model
{
    protected $table = 'usertask';


    public $timestamps = false;

    protected $fillable = [
        'task_id',
        'user_id'
    ];
}
