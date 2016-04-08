<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    protected $table = 'task';

    use SoftDeletes;

    protected $fillable = [
        'nr',
        'name',
        'sprint_id',
        'estimatedtime',
    ];
}
