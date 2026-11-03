<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public const STATUSES = [
        'a_faire'  => 'À faire',
        'en_cours' => 'En cours',
        'terminee' => 'Terminée',
    ];

    protected $fillable = [
        'title',
        'description',
        'responsible',
        'due_date',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'due_date' => 'date',
        ];
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }

    public function getStatusBadgeAttribute(): string
    {
        $badges = [
            'a_faire'  => 'secondary',
            'en_cours' => 'warning text-dark',
            'terminee' => 'success',
        ];

        return $badges[$this->status] ?? 'secondary';
    }
}
