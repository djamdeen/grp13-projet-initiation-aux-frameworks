@extends('layouts.app')

@section('title', 'Modifier une tâche')

@section('content')
    <h1 class="h3 mb-4">Modifier la tâche</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('tasks.update', $task) }}" method="POST">
                @csrf
                @method('PUT')
                @include('tasks._form', ['task' => $task, 'submitButtonText' => 'Enregistrer'])
            </form>
        </div>
    </div>
@endsection
