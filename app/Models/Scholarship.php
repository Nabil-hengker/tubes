<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Scholarship extends Model
{
    use HasFactory;

    protected $fillable = [
    'title',
    'provider',
    'coverage',
    'deadline',
    'category',
    'description',
    'country',
    'status',
    'official_url',
    ];



    protected function casts(): array
    {
        return [
            'deadline' => 'date',
        ];
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }
}
