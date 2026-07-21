<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'name'        => 'admin',
                'description' => 'Administrator sistem — akses penuh ke semua fitur termasuk manajemen pengguna.',
            ],
            [
                'name'        => 'kepala_sekolah',
                'description' => 'Kepala Sekolah — akses monitoring, laporan, dan statistik semua modul.',
            ],
            [
                'name'        => 'guru',
                'description' => 'Guru Mata Pelajaran — akses jurnal mengajar dan data akademik kelas.',
            ],
            [
                'name'        => 'guru_bk',
                'description' => 'Guru Bimbingan Konseling — akses data BK dan riwayat konseling siswa.',
            ],
            [
                'name'        => 'wali_kelas',
                'description' => 'Wali Kelas — akses data kelas, presensi, dan laporan siswa per kelas.',
            ],
            [
                'name'        => 'siswa',
                'description' => 'Siswa — akses nilai, jadwal, dan tugas pribadi.',
            ],
            [
                'name'        => 'orang_tua',
                'description' => 'Orang Tua/Wali — akses monitoring perkembangan dan kehadiran anak.',
            ],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role['name']], $role);
        }
    }
}
