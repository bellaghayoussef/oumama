<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Models\Dossier;
use App\Models\Repence;
use App\Models\Formuler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $agency = Auth::guard('agency')->user();

        // Get all dossiers for this agency
        $dossiers = Dossier::where('agency_id', $agency->id)
            ->with(['procedure', 'user', 'task'])
            ->latest()
            ->paginate(10);

        // Get forms that need to be filled out
        $formsToFill = Formuler::whereHas('task', function($query) {
                $query->where('intervenant', 'agence');
            })
            ->whereHas('task.dossiers', function($query) use ($agency) {
                $query->where('agency_id', $agency->id)
                    ->whereIn('status', ['en_cours', 'en_attente']);
            })
            ->whereDoesntHave('repences', function($query) use ($agency) {
                $query->whereHas('dossier', function($q) use ($agency) {
                    $q->where('agency_id', $agency->id);
                });
            })
            ->with(['task' => function($query) {
                $query->where('intervenant', 'agence');
            }, 'task.dossiers' => function($query) use ($agency) {
                $query->where('agency_id', $agency->id)
                    ->whereIn('status', ['en_cours', 'en_attente']);
            }, 'task.dossiers.procedure', 'task.dossiers.task'])
            ->latest()
            ->take(5)
            ->get();

        // Get pending forms that need agency response
        $pendingForms = Repence::whereHas('dossier', function($query) use ($agency) {
                $query->where('agency_id', $agency->id);
            })

            ->with(['dossier', 'formuler', 'dossier.procedure', 'dossier.task'])
            ->latest()
            ->take(5)
            ->get();

        // Get statistics
        $stats = [
            'total_dossiers' => Dossier::where('agency_id', $agency->id)->count(),
            'pending_forms' => Repence::whereHas('dossier', function($query) use ($agency) {
                $query->where('agency_id', $agency->id);
            })->where('status', 'agency')->count(),
            'completed_forms' => Repence::whereHas('dossier', function($query) use ($agency) {
                $query->where('agency_id', $agency->id);
            })->where('status', 'termine')->count(),
            'active_dossiers' => Dossier::where('agency_id', $agency->id)
                ->whereIn('status', ['en_cours', 'en_attente'])
                ->count()
        ];

        return view('agency.dashboard', compact('dossiers', 'pendingForms', 'stats', 'formsToFill'));
    }
}
