<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BkCounselingNote extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'teacher_id', 'note_date', 'title', 'description', 'follow_up_notes'];

    protected function casts(): array
    {
        return ['note_date' => 'date'];
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
