<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        Task::create([
            'title' => 'Préparer la présentation Laravel',
            'description' => 'Préparer les diapositives pour la soutenance.',
            'responsible' => 'Alice Martin',
            'due_date' => now()->addDays(5)->format('Y-m-d'),
            'status' => 'a_faire',
        ]);

        Task::create([
            'title' => 'Créer les vues Blade',
            'description' => 'Mettre en place le layout et les formulaires.',
            'responsible' => 'Thomas Dubois',
            'due_date' => now()->subDays(2)->format('Y-m-d'),
            'status' => 'terminee',
        ]);

        Task::create([
            'title' => 'Développer le contrôleur des tâches',
            'description' => 'Implémenter le CRUD et les filtres.',
            'responsible' => 'Emma Bernard',
            'due_date' => now()->addDays(2)->format('Y-m-d'),
            'status' => 'en_cours',
        ]);

        Task::create([
            'title' => 'Rédiger le README',
            'description' => 'Expliquer l\'installation et le démarrage du projet.',
            'responsible' => 'Alice Martin',
            'due_date' => now()->addDays(3)->format('Y-m-d'),
            'status' => 'en_cours',
        ]);

        Task::create([
            'title' => 'Créer la migration tasks',
            'description' => 'Définir les colonnes de la table tasks.',
            'responsible' => 'Thomas Dubois',
            'due_date' => now()->subDays(4)->format('Y-m-d'),
            'status' => 'terminee',
        ]);
    }
}
