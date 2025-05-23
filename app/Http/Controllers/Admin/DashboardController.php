<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agency;
use App\Models\User;
use App\Models\Dossier;
use App\Models\Repence;
use App\Models\Formuler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class DashboardController extends Controller
{
    public function index()
    {
        // Get agency statistics
        $totalAgencies = Agency::count();
        $activeAgencies = Agency::where('is_active', true)->count();
        $totalUsers = User::count();
        $recentAgencies = Agency::latest()->take(5)->get();

        // Get all dossiers
        $dossiers = Dossier::with(['procedure', 'agency', 'user', 'task'])
            ->latest()
            ->paginate(10);

        // Get forms that need to be filled by admin
        $formsToFill = Formuler::whereHas('task', function($query) {
                $query->where('intervenant', 'admin');
            })
            ->whereHas('task.dossiers', function($query) {
                $query->whereIn('status', ['en_cours', 'en_attente'])
                    ->where('task_id', function($subquery) {
                        $subquery->select('task_id')
                            ->from('formulers')
                            ->whereColumn('task_id', 'tasks.id')
                            ->limit(1);
                    });
            })
            ->whereDoesntHave('repences', function($query) {
                $query->whereHas('dossier', function($q) {
                    $q->whereIn('status', ['en_cours', 'en_attente']);
                });
            })
            ->with([
                'task' => function($query) {
                    $query->where('intervenant', 'admin');
                },
                'task.dossiers' => function($query) {
                    $query->whereIn('status', ['en_cours', 'en_attente'])
                        ->where('task_id', function($subquery) {
                            $subquery->select('task_id')
                                ->from('formulers')
                                ->whereColumn('task_id', 'tasks.id')
                                ->limit(1);
                        });
                },
                'task.dossiers.procedure',
                'task.dossiers.task',
                'task.dossiers.agency'
            ])
            ->latest()
            ->take(10)
            ->get();

        // Get pending forms that need admin response
        $pendingForms = Repence::whereHas('dossier', function($query) {
                $query->whereIn('status', ['en_cours', 'en_attente']);
            })
            ->whereHas('formuler.task', function($query) {
                $query->where('intervenant', 'admin');
            })
            ->where('status', 'admin')
            ->with([
                'dossier.procedure',
                'dossier.task',
                'dossier.agency',
                'formuler.task'
            ])
            ->latest()
            ->take(5)
            ->get();

        // Get statistics
        $stats = [
            'total_dossiers' => Dossier::count(),
            'pending_forms' => Repence::where('status', 'admin')->count(),
            'completed_forms' => Repence::where('status', 'termine')->count(),
            'active_dossiers' => Dossier::whereIn('status', ['en_cours', 'en_attente'])->count()
        ];

        return view('admin.dashboard.index', compact(
            'totalAgencies',
            'activeAgencies',
            'totalUsers',
            'recentAgencies',
            'dossiers',
            'formsToFill',
            'pendingForms',
            'stats'
        ));
    }

    public function listAgencies()
    {
        return response()->json(Agency::paginate(10));
    }

    public function createAgency(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:agencies',
            'password' => 'required|string|min:8',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
        ]);

        $agency = Agency::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'country' => $request->country,
        ]);

        return response()->json($agency, 201);
    }

    public function updateAgency(Request $request, Agency $agency)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('agencies')->ignore($agency->id)],
            'password' => 'nullable|string|min:8',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'is_active' => 'boolean',
        ]);

        $data = $request->except('password');
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $agency->update($data);

        return response()->json($agency);
    }

    public function deleteAgency(Agency $agency)
    {
        $agency->delete();
        return response()->json(['message' => 'Agency deleted successfully']);
    }

    public function getAgencyClients(Agency $agency)
    {
        return response()->json($agency->users()->paginate(10));
    }

    public function showDossiers()
    {
        // Get dossiers that need admin attention
        $dossiers = Dossier::whereHas('task', function($query) {
                $query->where('intervenant', 'admin');
            })
            ->whereIn('status', ['en_cours', 'en_attente'])
            ->with([
                'procedure',
                'agency',
                'user',
                'task' => function($query) {
                    $query->where('intervenant', 'admin');
                },
                'task.formulers' => function($query) {
                    $query->whereDoesntHave('repences', function($q) {
                        $q->whereHas('dossier', function($subq) {
                            $subq->whereIn('status', ['en_cours', 'en_attente']);
                        });
                    });
                }
            ])
            ->latest()
            ->paginate(10);

        // Get statistics for admin dossiers
        $stats = [
            'total_admin_dossiers' => Dossier::whereHas('task', function($query) {
                $query->where('intervenant', 'admin');
            })->count(),
            'pending_admin_dossiers' => Dossier::whereHas('task', function($query) {
                $query->where('intervenant', 'admin');
            })->whereIn('status', ['en_cours', 'en_attente'])->count(),
            'completed_admin_dossiers' => Dossier::whereHas('task', function($query) {
                $query->where('intervenant', 'admin');
            })->where('status', 'termine')->count(),
            'rejected_admin_dossiers' => Dossier::whereHas('task', function($query) {
                $query->where('intervenant', 'admin');
            })->where('status', 'rejete')->count()
        ];

        return view('admin.dossiers.index', compact('dossiers', 'stats'));
    }
}
