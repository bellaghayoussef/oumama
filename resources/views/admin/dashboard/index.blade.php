@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <!-- Total Agencies -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                <i class="fas fa-building text-2xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-gray-500 text-sm">Total Agences</h3>
                <p class="text-2xl font-semibold">{{ $totalAgencies }}</p>
            </div>
        </div>
    </div>

    <!-- Active Agencies -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-500">
                <i class="fas fa-check-circle text-2xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-gray-500 text-sm">Agences Actives</h3>
                <p class="text-2xl font-semibold">{{ $activeAgencies }}</p>
            </div>
        </div>
    </div>

    <!-- Total Users -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 text-purple-500">
                <i class="fas fa-users text-2xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-gray-500 text-sm">Total Utilisateurs</h3>
                <p class="text-2xl font-semibold">{{ $totalUsers }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Recent Agencies -->
<div class="bg-white rounded-lg shadow-md mb-6">
    <div class="p-4 border-b border-gray-200">
        <h2 class="text-xl font-semibold">Agences Récentes</h2>
    </div>
    <div class="p-4">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ville</th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($recentAgencies as $agency)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $agency->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $agency->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $agency->city }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $agency->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $agency->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="bg-white rounded-lg shadow-md">
    <div class="p-4 border-b border-gray-200">
        <h2 class="text-xl font-semibold">Actions Rapides</h2>
    </div>
    <div class="p-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('admin.agencies.create') }}" class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100">
                <i class="fas fa-plus-circle text-blue-500 text-xl mr-3"></i>
                <span class="text-blue-700">Nouvelle Agence</span>
            </a>
            <a href="{{ route('admin.users.create') }}" class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100">
                <i class="fas fa-user-plus text-green-500 text-xl mr-3"></i>
                <span class="text-green-700">Nouvel Utilisateur</span>
            </a>
            <a href="{{ route('admin.agencies.index') }}" class="flex items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100">
                <i class="fas fa-cog text-purple-500 text-xl mr-3"></i>
                <span class="text-purple-700">Gérer les Agences</span>
            </a>
        </div>
    </div>
</div>
@endsection
