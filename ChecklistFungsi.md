# Checklist Fungsi Proyek MID

Dokumen ini merangkum fitur minimal pada brief Tugas MID, lalu menandai status implementasi berdasarkan kode yang ada saat ini.

Legenda:
- [x] Sudah ada di project
- [~] Ada, tetapi masih parsial
- [ ] Belum ditemukan

## 1) Modul Jurnal Mengajar

- [x] Login guru
- [x] Input jurnal mengajar
- [x] Pilih kelas
- [x] Pilih mata pelajaran
- [x] Input tanggal mengajar
- [x] Input materi pembelajaran
- [x] Input metode pembelajaran
- [x] Input catatan pembelajaran
- [x] Riwayat jurnal mengajar
- [x] Rekap jurnal per guru / per kelas (melalui filter role + filter kelas)

## 2) Modul BK

- [x] Login guru BK
- [x] Cari data siswa (filter siswa)
- [x] Input data konseling
- [x] Input data pelanggaran
- [x] Input data prestasi
- [x] Input catatan tindak lanjut
- [x] Riwayat pembinaan siswa
- [x] Rekap kasus BK per siswa / per kelas

## 3) Modul Data Kesiswaan

- [x] Tambah data siswa
- [x] Ubah data siswa
- [x] Hapus data siswa
- [x] Kelola data kelas
- [x] Kelola data wali kelas
- [x] Kelola status siswa (aktif/pindah/lulus/keluar)
- [x] Import data siswa
- [x] Export data siswa
- [~] Riwayat data siswa (tersedia lewat activity log global, belum riwayat per-siswa khusus)

## 4) Modul Manajemen Pengguna

- [x] Login
- [x] Logout
- [x] Manajemen akun pengguna
- [x] Manajemen role
- [x] Reset password
- [x] Pembatasan akses berdasarkan role (RBAC)
- [x] Audit log aktivitas pengguna

## Ringkasan

- Total item: 35
- Sudah terpenuhi: 34
- Parsial: 1
- Belum ada: 0

## Catatan Parsial

- Riwayat data siswa saat ini masih mengandalkan log aktivitas umum. Jika ingin memenuhi secara penuh, bisa ditambah halaman khusus timeline perubahan per siswa.