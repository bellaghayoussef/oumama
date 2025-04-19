<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etap extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'procedure_id',
        'delait'
    ];

    public function procedure()
    {
        return $this->belongsTo(Procedure::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
