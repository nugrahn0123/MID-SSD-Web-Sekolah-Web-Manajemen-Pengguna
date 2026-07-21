# Web Sekolah Terintegrasi Berbasis Scalable System Design

Repository ini berisi implementasi **Modul Manajemen Pengguna** untuk proyek MID mata kuliah Scalable System Design. Modul ini berperan sebagai pusat autentikasi, otorisasi, audit log, dan integrasi API bagi modul lain seperti Jurnal Mengajar, BK, Data Kesiswaan, dan Akademik.

## Identitas Proyek

- Judul proyek: Web Sekolah Terintegrasi Berbasis Scalable System Design
- Fokus repository: Modul Manajemen Pengguna
- Mata kuliah: Scalable System Design
- Stack: Laravel 13, PHP 8.3, MySQL 8, Bootstrap 5, Laravel Sanctum

## Deskripsi Singkat Sistem

Sistem sekolah dibagi menjadi beberapa modul agar mudah dikembangkan dan lebih scalable. Repository ini mengerjakan modul yang mengelola login, logout, reset password, role-based access control, manajemen akun, manajemen role, audit log, dan endpoint API untuk verifikasi user antar-modul.

Dalam rancangan sistem penuh, modul ini menjadi sumber identitas utama untuk seluruh ekosistem aplikasi sekolah. Modul lain tidak menyimpan logika login sendiri, tetapi memanfaatkan API dari modul ini.

## Nama Anggota Kelompok

Isi sesuai data kelompok:

- Nama anggota 1 - NIM - Kelas
- Nama anggota 2 - NIM - Kelas
- Nama anggota 3 - NIM - Kelas
- Nama anggota 4 - NIM - Kelas

## Pembagian Tugas

Isi sesuai pembagian kelompok. Contoh yang sesuai dengan brief dosen:

- System Analyst / Project Lead: latar belakang, tujuan proyek, analisis kebutuhan, use case, alur integrasi modul.
- System Architect: rancangan modular monolith/service-based, pembagian vCPU, API integration, scaling strategy, monitoring.
- Database Designer: rancangan tabel, relasi, indeks, konsistensi data, ERD.
- Security and Access Control Designer: login, logout, reset password, RBAC, audit log, mitigasi risiko keamanan.
- UI/UX and Documentation Designer: layout antarmuka, dokumentasi README, screenshot, dan narasi presentasi.

## Modul Dalam Sistem Sekolah

Sistem sekolah yang dibahas pada presentasi dapat dijelaskan sebagai berikut:

- Modul Manajemen Pengguna: mengatur autentikasi, otorisasi, akun, role, audit log, dan API verifikasi identitas.
- Modul Jurnal Mengajar: dipakai guru untuk input jurnal pembelajaran.
- Modul BK: dipakai guru BK untuk data konseling, pelanggaran, prestasi, dan tindak lanjut siswa.
- Modul Data Kesiswaan: dipakai untuk data inti siswa, kelas, dan status siswa.
- Modul Akademik: dipakai untuk nilai, jadwal, kelas, dan data pembelajaran.

Repository ini hanya mengimplementasikan **Modul Manajemen Pengguna**, tetapi desain integrasinya sudah disiapkan untuk modul lain.

## Fitur Yang Sudah Diimplementasikan

- Login dan logout berbasis session.
- Reset password.
- Redirect dashboard berdasarkan role.
- Middleware RBAC berbasis role.
- Helper cek role pada view.
- Manajemen akun pengguna oleh admin.
- Manajemen role oleh admin.
- Search dan filter pengguna berdasarkan role/status.
- Audit log aktivitas login, logout, dan perubahan data penting.
- API integrasi antar-modul berbasis token Sanctum.
- Data dummy untuk akun demo.

## Role dan Hak Akses

Role default yang tersedia:

- admin
- kepala_sekolah
- guru
- guru_bk
- wali_kelas
- siswa
- orang_tua

Ringkasan akses:

- Admin dapat mengelola akun, role, dan melihat audit log.
- Kepala sekolah dapat mengakses dashboard monitoring.
- Guru diarahkan ke dashboard yang nantinya terhubung ke modul jurnal mengajar.
- Guru BK diarahkan ke dashboard yang nantinya terhubung ke modul BK.
- Wali kelas diarahkan ke dashboard yang nantinya terhubung ke data kelas/akademik.
- Siswa dan orang tua hanya melihat menu relevan untuk perannya.

## Rancangan Arsitektur Sistem

Pendekatan yang dipakai untuk proyek MID ini adalah **modular monolith dengan integrasi API internal**.

Gambaran arsitektur presentasi:

```text
[Client Browser / Mobile]
        |
        v
[Load Balancer / Reverse Proxy]
        |
        +-------------------+-------------------+-------------------+
        |                   |                   |                   |
        v                   v                   v                   v
[User Management]   [Jurnal Mengajar]      [BK]         [Data Kesiswaan/Akademik]
        |                   |                   |                   |
        +-------------------+-------------------+-------------------+
                            |
                            v
                  [Centralized MySQL Database]
```

Penjelasan yang bisa dipakai saat presentasi:

- Modul dipisah berdasarkan domain bisnis agar tidak saling bercampur.
- Modul Manajemen Pengguna menyediakan login, verifikasi token, dan data role.
- Database tetap terpusat agar data user, siswa, guru, dan aktivitas konsisten.
- Modul dengan trafik tinggi dapat dipisah ke service atau node sendiri pada tahap scale-out.

## Pembagian vCPU / Server Virtual

Contoh pembagian vCPU yang sesuai dengan brief dosen:

1. vCPU 1: Modul Jurnal Mengajar
2. vCPU 2: Modul BK
3. vCPU 3: Modul Data Kesiswaan
4. vCPU 4: Modul Akademik dan Manajemen Pengguna
5. vCPU 5: Database MySQL terpusat
6. vCPU 6: Load balancer, monitoring, logging, dan backup

Alasan teknis singkat:

- Jurnal Mengajar cenderung ramai saat jam sekolah.
- BK dipisahkan karena data sensitif.
- Database dipisahkan agar I/O dan konsistensi data lebih terjaga.
- User Management dipusatkan agar login dan hak akses tidak tersebar di banyak modul.

## Unsur Scalable System Design

Unsur yang sudah atau dapat dijelaskan dari modul ini:

1. Modular architecture: manajemen pengguna dipisah dari jurnal, BK, dan kesiswaan.
2. Centralized database: tabel users, roles, dan activity_logs menjadi basis bersama.
3. API-based integration: modul lain memverifikasi token dan role melalui endpoint API.
4. Role-based access control: akses dibatasi sesuai role user.
5. Logging dan audit trail: aktivitas sensitif dicatat ke activity_logs.
6. Database optimization: foreign key dan struktur relasi dibuat jelas.
7. Horizontal scaling: service login/API verifikasi dapat dipisah saat trafik meningkat.
8. Vertical scaling: database server dapat ditambah CPU, RAM, atau storage.
9. Caching: daftar role/menu dapat di-cache pada tahap optimasi berikutnya.
10. Monitoring: audit log dan statistik aktivitas menjadi dasar observabilitas awal.

## Rancangan Database

Repository ini mengimplementasikan tabel berikut untuk modul manajemen pengguna:

- roles
- users
- activity_logs
- password_reset_tokens
- personal_access_tokens

Relasi utama:

- users.role_id -> roles.id
- activity_logs.user_id -> users.id
- personal_access_tokens.tokenable -> users

Dalam sistem sekolah penuh, tabel ini menjadi bagian dari database pusat yang juga akan dipakai bersama tabel students, teachers, classes, subjects, schedules, teaching_journals, dan tabel domain lain.

## Struktur Folder Proyek

```text
app/
  Helpers/
  Http/
    Controllers/
      Admin/
      Api/
      Auth/
    Middleware/
    Requests/
  Models/
bootstrap/
config/
database/
  migrations/
  seeders/
public/
resources/views/
routes/
storage/
tests/
```

## Cara Instalasi

Prasyarat:

- Laragon atau PHP 8.3 + Composer + MySQL
- Git

Langkah instalasi lokal:

```bash
composer install
copy .env.example .env
php artisan key:generate
php artisan migrate --seed
```

Jika memakai Laragon seperti environment pengembangan saat ini, proyek dapat diakses melalui:

```text
http://localhost/tugas-mid-scalable
```

## Cara Menjalankan Aplikasi

Opsi 1, melalui Laragon Apache:

```text
http://localhost/tugas-mid-scalable
```

Opsi 2, melalui server development Laravel:

```bash
php artisan serve
```

Lalu akses:

```text
http://127.0.0.1:8000
```

## Akun Demo

Password semua akun demo adalah `password123`.

- Admin Sistem: admin@sekolah.sch.id
- Kepala Sekolah: kepsek@sekolah.sch.id
- Guru 1: guru.siti@sekolah.sch.id
- Guru 2: guru.budi@sekolah.sch.id
- Guru BK: bk.dewi@sekolah.sch.id
- Wali Kelas: walikelas.ahmad@sekolah.sch.id
- Siswa 1: rizki.p@siswa.sekolah.sch.id
- Siswa 2: nur.f@siswa.sekolah.sch.id
- Orang Tua: orangtua.pratama@gmail.com

## API Integrasi Antar Modul

Endpoint utama yang bisa dipakai modul lain:

- POST /api/auth/login
- POST /api/auth/logout
- GET /api/auth/verify
- GET /api/users
- GET /api/users/{id}/role

Contoh penggunaan integrasi:

- Modul Jurnal Mengajar memanggil `/api/auth/verify` untuk memastikan user ber-role `guru`.
- Modul BK memanggil `/api/auth/verify` untuk memastikan user ber-role `guru_bk`.
- Modul Akademik dapat memanggil `/api/users?role=guru` untuk kebutuhan lookup data guru.
- Modul lain dapat menggunakan `/api/users/{id}/role` untuk validasi akses lanjutan.

## Risiko Sistem dan Solusi

- Risiko kebocoran akses data sensitif: ditangani dengan RBAC dan middleware role.
- Risiko penyalahgunaan akun: ditangani dengan password hashing, reset password, dan status aktif/nonaktif.
- Risiko audit sulit ditelusuri: ditangani dengan activity_logs.
- Risiko bottleneck login saat trafik naik: mitigasi dengan pemisahan service auth/API dan caching sesi/token.
- Risiko inkonsistensi data antar-modul: mitigasi dengan database terpusat dan endpoint verifikasi yang sama.

## Screenshot dan Diagram

Tambahkan ke repository sebelum pengumpulan:

- screenshot halaman login
- screenshot dashboard admin
- screenshot manajemen pengguna
- screenshot audit log
- ERD database
- diagram arsitektur sistem

## Link Pengumpulan

Lengkapi sebelum submit:

- Link video presentasi YouTube: isi di sini
- Link repository GitHub: isi di sini
- Link dokumen laporan PDF: isi di sini

## Catatan Repository

- Jangan commit file `.env` berisi kredensial asli.
- Gunakan data dummy saja.
- Usahakan commit history menunjukkan kontribusi anggota.
- Jika repository private, beri akses ke dosen.
#   M I D - S S D - W e b - S e k o l a h - W e b - M a n a j e m e n - P e n g g u n a  
 #   M I D - S S D - W e b - S e k o l a h - W e b - M a n a j e m e n - P e n g g u n a  
 