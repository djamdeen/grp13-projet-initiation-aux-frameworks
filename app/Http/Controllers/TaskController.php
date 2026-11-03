<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $counters = [
            'total'    => Task::count(),
            'a_faire'  => Task::where('status', 'a_faire')->count(),
            'en_cours' => Task::where('status', 'en_cours')->count(),
            'terminee' => Task::where('status', 'terminee')->count(),
        ];

        $query = Task::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('responsible')) {
            $query->where('responsible', 'like', '%' . $request->responsible . '%');
        }

        $tasks = $query->orderBy('due_date', 'asc')->get();

        return view('tasks.index', compact('tasks', 'counters'));
    }

    public function create()
    {
        $task = new Task();
        $task->status = 'a_faire';

        return view('tasks.create', compact('task'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'responsible' => ['required', 'string', 'max:100'],
            'due_date'    => ['required', 'date'],
            'status'      => ['required', Rule::in(['a_faire', 'en_cours', 'terminee'])],
        ]);

        Task::create($validated);

        return redirect()
            ->route('tasks.index')
            ->with('success', 'La tâche a été créée avec succès.');
    }

    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'responsible' => ['required', 'string', 'max:100'],
            'due_date'    => ['required', 'date'],
            'status'      => ['required', Rule::in(['a_faire', 'en_cours', 'terminee'])],
        ]);

        $task->update($validated);

        return redirect()
            ->route('tasks.index')
            ->with('success', 'La tâche a été modifiée avec succès.');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()
            ->route('tasks.index')
            ->with('success', 'La tâche a été supprimée avec succès.');
    }
}
