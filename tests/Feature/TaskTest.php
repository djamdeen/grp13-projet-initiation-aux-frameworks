<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_root_redirects_to_tasks_index(): void
    {
        $this->get('/')->assertRedirect('/tasks');
    }

    public function test_index_shows_tasks_and_counters(): void
    {
        Task::create([
            'title' => 'Tâche À Faire',
            'responsible' => 'Alice',
            'due_date' => '2026-11-10',
            'status' => 'a_faire',
        ]);

        Task::create([
            'title' => 'Tâche En Cours',
            'responsible' => 'Thomas',
            'due_date' => '2026-11-12',
            'status' => 'en_cours',
        ]);

        Task::create([
            'title' => 'Tâche Terminée',
            'responsible' => 'Emma',
            'due_date' => '2026-11-05',
            'status' => 'terminee',
        ]);

        $response = $this->get('/tasks');

        $response->assertOk();
        $response->assertSee('Tâche À Faire');
        $response->assertSee('Alice');
        $response->assertViewHas('counters', [
            'total' => 3,
            'a_faire' => 1,
            'en_cours' => 1,
            'terminee' => 1,
        ]);
    }

    public function test_can_filter_by_status(): void
    {
        Task::create([
            'title' => 'Tâche ouverte',
            'responsible' => 'Alice',
            'due_date' => '2026-11-10',
            'status' => 'a_faire',
        ]);

        Task::create([
            'title' => 'Tâche clôturée',
            'responsible' => 'Bob',
            'due_date' => '2026-11-12',
            'status' => 'terminee',
        ]);

        $this->get('/tasks?status=a_faire')
            ->assertOk()
            ->assertSee('Tâche ouverte')
            ->assertDontSee('Tâche clôturée');
    }

    public function test_can_search_by_title(): void
    {
        Task::create([
            'title' => 'Rédiger le README',
            'responsible' => 'Alice',
            'due_date' => '2026-11-10',
            'status' => 'a_faire',
        ]);

        Task::create([
            'title' => 'Créer la migration',
            'responsible' => 'Bob',
            'due_date' => '2026-11-12',
            'status' => 'en_cours',
        ]);

        $this->get('/tasks?search=README')
            ->assertOk()
            ->assertSee('Rédiger le README')
            ->assertDontSee('Créer la migration');
    }

    public function test_validation_requires_fields(): void
    {
        $this->post('/tasks', [])
            ->assertSessionHasErrors([
                'title' => 'Le champ titre est obligatoire.',
                'responsible' => 'Le champ responsable est obligatoire.',
                'due_date' => 'Le champ date d\'échéance est obligatoire.',
                'status' => 'Le champ statut est obligatoire.',
            ]);

        $this->assertEquals(0, Task::count());
    }

    public function test_can_create_task(): void
    {
        $this->post('/tasks', [
            'title' => 'Nouvelle tâche',
            'description' => 'Une description',
            'responsible' => 'Alice',
            'due_date' => '2026-11-15',
            'status' => 'a_faire',
        ])
            ->assertRedirect(route('tasks.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('tasks', [
            'title' => 'Nouvelle tâche',
            'status' => 'a_faire',
        ]);
    }

    public function test_can_update_task(): void
    {
        $task = Task::create([
            'title' => 'Ancien titre',
            'responsible' => 'Alice',
            'due_date' => '2026-11-10',
            'status' => 'a_faire',
        ]);

        $this->put(route('tasks.update', $task), [
            'title' => 'Nouveau titre',
            'description' => null,
            'responsible' => 'Thomas',
            'due_date' => '2026-11-18',
            'status' => 'en_cours',
        ])->assertRedirect(route('tasks.index'));

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'Nouveau titre',
            'status' => 'en_cours',
        ]);
    }

    public function test_can_delete_task(): void
    {
        $task = Task::create([
            'title' => 'À supprimer',
            'responsible' => 'Lucas',
            'due_date' => '2026-11-10',
            'status' => 'terminee',
        ]);

        $this->delete(route('tasks.destroy', $task))
            ->assertRedirect(route('tasks.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}