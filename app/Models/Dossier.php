<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dossier extends Model
{
    use HasFactory;

    protected $fillable = [
        'procedure_id',
        'agency_id',
        'user_id',
        'task_id',
        'status',
        'signature',
    ];

    public function procedure()
    {
        return $this->belongsTo(Procedure::class);
    }

    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function repences()
    {
        return $this->hasMany(Repence::class);
    }

             

} 