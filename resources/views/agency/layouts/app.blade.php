<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Agence</title>

    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div class="bg-blue-900 text-white w-64 py-6 flex flex-col">
            <div class="p-4">
                <h1 class="text-xl font-semibold text-white">Agence</h1>
            </div>
            <nav class="mt-5">
                <a href="{{ route('agency.dashboard') }}" class="flex items-center px-4 py-2 text-white hover:bg-yellow-500 rounded-md text-decoration: blink; {{ request()->routeIs('agency.dashboard') ? 'bg-yellow-500' : '' }}"  style="border-radius: 32px;margin: 9px;text-decoration: blink;">
                    <i class="fas fa-tachometer-alt mr-3"></i>
                    Tableau de Bord
                </a>
                <a href="{{ route('agency.dossiers.index') }}" class="flex items-center px-4 py-2 text-white hover:bg-yellow-500 rounded-md text-decoration: blink; {{ request()->routeIs('agency.dossiers.*') ? 'bg-yellow-500' : '' }}"  style="border-radius: 32px;margin: 9px;text-decoration: blink;">
                    <i class="fas fa-folder mr-3"></i>
                    Dossiers
                </a>
                <a href="{{ route('agency.users.index') }}" class="flex items-center px-4 py-2 text-white hover:bg-yellow-500 rounded-md text-decoration: blink; {{ request()->routeIs('agency.users.*') ? 'bg-yellow-500' : '' }}"  style="border-radius: 32px;margin: 9px;text-decoration: blink;">
                    <i class="fas fa-users mr-3"></i>
                    Utilisateurs
                </a>
                <form action="{{ route('agency.logout') }}" method="POST" class="mt-5">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-4 py-2 text-white hover:bg-yellow-500 rounded-md text-decoration: blink; {{ request()->routeIs('agency.logout') ? 'bg-yellow-500' : '' }}">
                        <i class="fas fa-sign-out-alt mr-3"></i>
                        Déconnexion
                    </button>
                </form>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1">
            <!-- Header -->
            <header class="bg-white shadow">
                <div class="px-4 py-4">
                    <h2 class="text-xl font-semibold text-gray-800">@yield('header')</h2>
                </div>
            </header>

            <!-- Content -->
            <main class="p-6">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap JS Bundle (with Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoU8wE6vU8vwxH8333z6fzlA0Bt4Zj+EkZ1V7lGyzR3Oe9C" crossorigin="anonymous"></script>
</body>
</html>
