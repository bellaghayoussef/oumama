<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Models\Dossier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $agency = Auth::guard('agency')->user();
        $dossiers = Dossier::where('agency_id', $agency->id)
            ->with(['procedure', 'user', 'task'])
            ->latest()
            ->paginate(10);

        return view('agency.dashboard', compact('dossiers'));
    }
} 