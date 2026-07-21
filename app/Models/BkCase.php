<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BkCase extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'teacher_id',
        'case_type',
        'case_date',
        'title',
        'description',
        'follow_up_notes',
    ];

    protected function casts(): array
    {
        return [
            'case_date' => 'date',
        ];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }
}
