<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dossier;
use Illuminate\Support\Facades\Auth;

class DosesController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return response()->json([
            'status' => 'success',
            'data' => $user
        ]);
        $doses = Dossier::where('user_id', $user->id)
                    ->orderBy('created_at', 'desc')
                    ->get();

        return response()->json([
            'status' => 'success',
            'data' => $doses
        ]);
    }
   
} 