<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'etap_id',
        'intervenant',
        'delait'
    ];

    public function etap()
    {
        return $this->belongsTo(Etap::class);
    }
}
