<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agency;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class DashboardController extends Controller
{
    public function index()
    {
        $totalAgencies = Agency::count();
        $activeAgencies = Agency::where('is_active', true)->count();
        $totalUsers = User::count();
        $recentAgencies = Agency::latest()->take(5)->get();

        return view('admin.dashboard.index', compact(
            'totalAgencies',
            'activeAgencies',
            'totalUsers',
            'recentAgencies'
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
}
