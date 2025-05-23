<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formuler extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'task_id'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function variables()
    {
        return $this->hasMany(Variable::class, 'formuler_id');
    }



    public function repences()
    {
        return $this->hasMany(Repence::class);
    }
}
