<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'is_required'
    ];

    public function formulers()
    {
        return $this->belongsToMany(Formuler::class, 'formuler_question')
            ->withPivot('order')
            ->orderBy('order');
    }

    public function variables()
    {
        return $this->belongsToMany(Variable::class, 'formuler_question_variable', 'formuler_question_id', 'variable_id')
            ->withPivot('order')
            ->orderBy('order');
    }
} 