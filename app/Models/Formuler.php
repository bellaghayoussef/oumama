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
        return $this->belongsToMany(Variable::class, 'formuler_variable')
            ->withPivot('order')
            ->orderBy('order');
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'formuler_question')
            ->withPivot('order')
            ->orderBy('order');
    }
} 