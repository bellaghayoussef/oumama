<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variable extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'formuler_id'
    ];

    public function formuler()
    {
        return $this->belongsTo(Formuler::class);
    }

    public function formulers()
    {
        return $this->belongsToMany(Formuler::class, 'formuler_variable')
            ->withPivot('order')
            ->orderBy('order');
    }

    public function repences()
    {
        return $this->hasMany(Repence::class);
    }
} 