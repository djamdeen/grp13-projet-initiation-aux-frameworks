<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Gestionnaire de tâches') — Groupe 13</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('tasks.index') }}">Gestionnaire de tâches</a>
            <div class="d-flex gap-3">
                <a class="nav-link text-white {{ request()->routeIs('tasks.index') ? 'fw-bold text-decoration-underline' : '' }}"
                   href="{{ route('tasks.index') }}">
                    Liste des tâches
                </a>
                <a class="nav-link text-white {{ request()->routeIs('tasks.create') ? 'fw-bold text-decoration-underline' : '' }}"
                   href="{{ route('tasks.create') }}">
                    Ajouter une tâche
                </a>
            </div>
        </div>
    </nav>

    <main class="container pb-5">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @yield('content')
    </main>

    <footer class="border-top bg-white py-3 text-center text-muted">
        <small>Projet Laravel — Initiation aux frameworks — Groupe 13</small>
    </footer>

</body>
</html>
