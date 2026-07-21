<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function isSystemRole(): bool
    {
        return in_array($this->name, [
            'admin',
            'kepala_sekolah',
            'guru',
            'guru_bk',
            'wali_kelas',
            'siswa',
            'orang_tua',
        ], true);
    }
}
