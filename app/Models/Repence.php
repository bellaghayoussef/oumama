<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repence extends Model
{
    use HasFactory;

    protected $fillable = [
        'dossier_id',
        'formuler_id',
        'status',
        'answers'
    ];

    protected $casts = [
        'answers' => 'array'
    ];

    public function dossier()
    {
        return $this->belongsTo(Dossier::class);
    }

    public function formuler()
    {
        return $this->belongsTo(Formuler::class);
    }
}
