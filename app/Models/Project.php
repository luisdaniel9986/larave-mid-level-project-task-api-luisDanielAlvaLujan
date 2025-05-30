<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Project extends Model
{


    protected $fillable = [
        'name',
        'description',
        'status',
    ];

    public function tasks(){
        return $this->hasMany(Task::class);
    }

}
