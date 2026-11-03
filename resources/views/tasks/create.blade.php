@extends('layouts.app')

@section('title', 'Créer une tâche')

@section('content')
    <h1 class="h3 mb-4">Créer une nouvelle tâche</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('tasks.store') }}" method="POST">
                @csrf
                @include('tasks._form', ['task' => $task, 'submitButtonText' => 'Créer la tâche'])
            </form>
        </div>
    </div>
@endsection
