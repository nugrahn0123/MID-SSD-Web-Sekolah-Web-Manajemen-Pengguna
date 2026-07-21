<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Data dummy untuk demo & pengujian.
 * SEMUA data bersifat FIKTIF. Password default: password123
 *
 * Akun demo:
 *   admin@sekolah.sch.id         — Admin
 *   kepsek@sekolah.sch.id        — Kepala Sekolah
 *   guru.siti@sekolah.sch.id     — Guru
 *   guru.budi@sekolah.sch.id     — Guru
 *   bk.dewi@sekolah.sch.id       — Guru BK
 *   walikelas.ahmad@sekolah.sch.id — Wali Kelas
 *   rizki.p@siswa.sekolah.sch.id — Siswa
 *   nur.f@siswa.sekolah.sch.id   — Siswa
 *   orangtua.pratama@gmail.com   — Orang Tua
 */
class UserSeeder extends Seeder
{
    public function run(): void
    {
        $roleId = fn (string $name): int => Role::where('name', $name)->value('id');

        $users = [
            // 1 Admin
            [
                'name'    => 'Admin Sistem',
                'email'   => 'admin@sekolah.sch.id',
                'role'    => 'admin',
                'status'  => 'aktif',
            ],
            // 1 Kepala Sekolah
            [
                'name'    => 'Drs. Hendra Kusuma, M.Pd.',
                'email'   => 'kepsek@sekolah.sch.id',
                'role'    => 'kepala_sekolah',
                'status'  => 'aktif',
            ],
            // 2 Guru
            [
                'name'    => 'Siti Rahayu, S.Pd.',
                'email'   => 'guru.siti@sekolah.sch.id',
                'role'    => 'guru',
                'status'  => 'aktif',
            ],
            [
                'name'    => 'Budi Santoso, S.T.',
                'email'   => 'guru.budi@sekolah.sch.id',
                'role'    => 'guru',
                'status'  => 'aktif',
            ],
            // 1 Guru BK
            [
                'name'    => 'Dewi Lestari, S.Psi.',
                'email'   => 'bk.dewi@sekolah.sch.id',
                'role'    => 'guru_bk',
                'status'  => 'aktif',
            ],
            // 1 Wali Kelas
            [
                'name'    => 'Ahmad Fauzi, S.Pd.',
                'email'   => 'walikelas.ahmad@sekolah.sch.id',
                'role'    => 'wali_kelas',
                'status'  => 'aktif',
            ],
            // 2 Siswa
            [
                'name'    => 'Rizki Pratama',
                'email'   => 'rizki.p@siswa.sekolah.sch.id',
                'role'    => 'siswa',
                'status'  => 'aktif',
            ],
            [
                'name'    => 'Nur Fitriani',
                'email'   => 'nur.f@siswa.sekolah.sch.id',
                'role'    => 'siswa',
                'status'  => 'aktif',
            ],
            // 1 Orang Tua
            [
                'name'    => 'Ir. Pratama Wijaya',
                'email'   => 'orangtua.pratama@gmail.com',
                'role'    => 'orang_tua',
                'status'  => 'aktif',
            ],
        ];

        foreach ($users as $data) {
            User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name'     => $data['name'],
                    'password' => Hash::make('password123'),
                    'role_id'  => $roleId($data['role']),
                    'status'   => $data['status'],
                ]
            );
        }
    }
}
