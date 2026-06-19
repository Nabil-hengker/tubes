<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Application extends Model
{
    use HasFactory;

    protected $table = 'applications';

    protected $fillable = [
        'user_id',
        'scholarship_id',
        'npm',
        'nama_lengkap',
        'ipk',
        'penghasilan_orang_tua',
        'document_path',
        'status',
        'catatan_admin',
    ];

    protected function casts(): array
    {
        return [
            'ipk' => 'decimal:2',
            'penghasilan_orang_tua' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scholarship(): BelongsTo
    {
        return $this->belongsTo(Scholarship::class);
    }
}
