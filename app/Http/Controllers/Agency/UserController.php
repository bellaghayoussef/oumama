<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\UserCreated;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function index()
    {
        $agency = Auth::guard('agency')->user();
        $users = User::where('agency_id', $agency->id)
            ->latest()
            ->paginate(10);

        return view('agency.users.index', compact('users'));
    }

    public function create()
    {
        return view('agency.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
        ]);

        $plainPassword = $request->password;

        $user = new User($request->all());
        $user->agency_id = Auth::guard('agency')->id();
        $user->password = bcrypt($request->password);
        $user->save();

        Mail::to($user->email)->send(new UserCreated($user, $plainPassword));

        return redirect()->route('agency.users.index')
            ->with('success', 'Utilisateur créé avec succès.');
    }

    public function show(User $user)
    {
        return view('agency.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('agency.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|string|min:8|confirmed',
            ]);
            $user->password = bcrypt($request->password);
        }

        $user->update($request->except('password'));

        return redirect()->route('agency.users.index')
            ->with('success', 'Utilisateur mis à jour avec succès.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('agency.users.index')
            ->with('success', 'Utilisateur supprimé avec succès.');
    }
}
