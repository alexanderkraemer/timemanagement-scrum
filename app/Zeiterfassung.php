<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Zeiterfassung extends Model
{
    protected $table = 'zeiterfassung';

    use SoftDeletes;

    protected $fillable = [
        'task_id',
        'user_id',
        'timeneeded',
        'timestillneeded',
    ];
}
