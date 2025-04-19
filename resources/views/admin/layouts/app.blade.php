<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - @yield('title')</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div class="bg-gray-800 text-white w-64 py-6 flex flex-col">
            <div class="px-6 mb-8">
                <h1 class="text-2xl font-bold">Admin Panel</h1>
            </div>
            <nav class="flex-1">
                <a href="{{ route('admin.dashboard') }}" class="block px-6 py-2 hover:bg-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-home mr-2"></i> Dashboard
                </a>
                <a href="{{ route('admin.agencies.index') }}" class="block px-6 py-2 hover:bg-gray-700 {{ request()->routeIs('admin.agencies.*') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-building mr-2"></i> Gérer les Agences
                </a>
                <a href="{{ route('admin.users.index') }}" class="block px-6 py-2 hover:bg-gray-700 {{ request()->routeIs('admin.users.*') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-users mr-2"></i> Gérer les Utilisateurs
                </a>
                <a href="{{ route('admin.dossiers.index') }}" class="block px-6 py-2 hover:bg-gray-700 {{ request()->routeIs('admin.dossiers.*') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-reply mr-2"></i> Gérer les Dossiers
                </a>
                
                <a href="{{ route('admin.procedures.index') }}" class="block px-6 py-2 hover:bg-gray-700 {{ request()->routeIs('admin.procedures.*') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-list mr-2"></i> Gérer les Procédures
                </a>
                <a href="{{ route('admin.etaps.index') }}" class="block px-6 py-2 hover:bg-gray-700 {{ request()->routeIs('admin.etaps.*') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-step-forward mr-2"></i> Gérer les Étapes
                </a>
                <a href="{{ route('admin.tasks.index') }}" class="block px-6 py-2 hover:bg-gray-700 {{ request()->routeIs('admin.tasks.*') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-tasks mr-2"></i> Gérer les Tâches
                </a>
                <a href="{{ route('admin.formulers.index') }}" class="block px-6 py-2 hover:bg-gray-700 {{ request()->routeIs('admin.formulers.*') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-file-alt mr-2"></i> Gérer les Formulaires
                </a>
                <a href="{{ route('admin.variables.index') }}" class="block px-6 py-2 hover:bg-gray-700 {{ request()->routeIs('admin.variables.*') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-code mr-2"></i> Gérer les Variables
                </a>
                <a href="{{ route('admin.repences.index') }}" class="block px-6 py-2 hover:bg-gray-700 {{ request()->routeIs('admin.repences.*') ? 'bg-gray-700' : '' }}">
                    <i class="fas fa-reply mr-2"></i> Gérer les Réponses
                </a>

              
            </nav>
            <div class="px-6 py-4 border-t border-gray-700">
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-700 rounded">
                        <i class="fas fa-sign-out-alt mr-2"></i> Déconnexion
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1">
            <!-- Top Navigation -->
            <div class="bg-white shadow-md p-4">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-semibold">@yield('header')</h2>
                    <div class="flex items-center">
                        <span class="mr-2">{{ auth()->guard('admin')->user()->name }}</span>
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->guard('admin')->user()->name) }}"
                             alt="Profile"
                             class="w-8 h-8 rounded-full">
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <div class="p-6">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <!-- Alpine.js -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
