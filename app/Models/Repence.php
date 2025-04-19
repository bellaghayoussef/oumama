<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repence extends Model
{
    use HasFactory;

    protected $fillable = [
        'variable_id',
        'user_id',
        'agency_id',
        'admin_id',
        'value'
    ];

    public function variable()
    {
        return $this->belongsTo(Variable::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
} 