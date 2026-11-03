@extends('layouts.app')

@section('title', 'Détail de la tâche')

@section('content')
    <div class="mb-3">
        <a href="{{ route('tasks.index') }}" class="btn btn-sm btn-outline-secondary">Retour à la liste</a>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h1 class="h4 mb-0">{{ $task->title }}</h1>
            <span class="badge bg-{{ $task->status_badge }}">{{ $task->status_label }}</span>
        </div>

        <div class="card-body">
            <p class="mb-2"><strong>Responsable :</strong> {{ $task->responsible }}</p>
            <p class="mb-3"><strong>Date d'échéance :</strong> {{ $task->due_date->format('d/m/Y') }}</p>

            <p class="mb-1"><strong>Description :</strong></p>
            @if ($task->description)
                <p class="mb-0">{{ $task->description }}</p>
            @else
                <p class="text-muted mb-0">Aucune description.</p>
            @endif
        </div>

        <div class="card-footer d-flex gap-2">
            <a href="{{ route('tasks.edit', $task) }}" class="btn btn-primary">Modifier</a>
            <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                  onsubmit="return confirm('Supprimer cette tâche ?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger">Supprimer</button>
            </form>
        </div>
    </div>
@endsection
