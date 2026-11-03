@extends('layouts.app')

@section('title', 'Liste des tâches')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Liste des tâches</h1>
        <a href="{{ route('tasks.create') }}" class="btn btn-primary">Ajouter une tâche</a>
    </div>

    {{-- Compteurs --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card text-center h-100">
                <div class="card-body">
                    <div class="text-muted small">Total</div>
                    <div class="fs-4 fw-bold">{{ $counters['total'] }}</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card text-center h-100">
                <div class="card-body">
                    <div class="text-muted small">À faire</div>
                    <div class="fs-4 fw-bold">{{ $counters['a_faire'] }}</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card text-center h-100">
                <div class="card-body">
                    <div class="text-muted small">En cours</div>
                    <div class="fs-4 fw-bold">{{ $counters['en_cours'] }}</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card text-center h-100">
                <div class="card-body">
                    <div class="text-muted small">Terminées</div>
                    <div class="fs-4 fw-bold">{{ $counters['terminee'] }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filtres --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('tasks.index') }}" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="search" class="form-label">Recherche (titre)</label>
                    <input type="text" name="search" id="search" class="form-control"
                           value="{{ request('search') }}" placeholder="Mot-clé...">
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">Statut</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">Tous</option>
                        @foreach (\App\Models\Task::STATUSES as $code => $label)
                            <option value="{{ $code }}" @selected(request('status') === $code)>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="responsible" class="form-label">Responsable</label>
                    <input type="text" name="responsible" id="responsible" class="form-control"
                           value="{{ request('responsible') }}" placeholder="Nom...">
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Filtrer</button>
                    <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">Effacer</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Liste --}}
    <div class="card">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Titre</th>
                        <th>Responsable</th>
                        <th>Statut</th>
                        <th>Échéance</th>
                        <th style="width: 260px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tasks as $task)
                        <tr>
                            <td>{{ $task->title }}</td>
                            <td>{{ $task->responsible }}</td>
                            <td>
                                <span class="badge bg-{{ $task->status_badge }}">
                                    {{ $task->status_label }}
                                </span>
                            </td>
                            <td>{{ $task->due_date->format('d/m/Y') }}</td>
                            <td class="text-nowrap">
                                <a href="{{ route('tasks.show', $task) }}" class="btn btn-sm btn-outline-primary">Voir</a>
                                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-outline-secondary">Modifier</a>
                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Supprimer cette tâche ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                Aucune tâche trouvée.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
