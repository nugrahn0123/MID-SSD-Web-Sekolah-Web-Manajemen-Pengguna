UJIAN MID SEMESTER
Mata Kuliah: Scalable System Design
Bentuk Ujian: Proyek Kelompok

A. Judul Proyek
Perancangan dan Pengembangan Web Sekolah Terintegrasi Berbasis Scalable System Design

B. Deskripsi Umum Proyek
Pada Ujian MID Semester mata kuliah Scalable System Design, mahasiswa diminta membuat proyek berupa web sekolah terintegrasi.
Web sekolah yang dibuat harus terdiri dari beberapa modul atau layanan, misalnya:
Web Sistem Jurnal Mengajar
Web Bimbingan Konseling atau BK
Web Data Kesiswaan
Web Akademik
Web Manajemen Pengguna
Modul tambahan lain sesuai kebutuhan sekolah
Seluruh modul tersebut harus saling terhubung dan menggunakan satu database utama sebagai pusat penyimpanan data.
Proyek ini tidak hanya menilai kemampuan mahasiswa dalam membuat web, tetapi juga menilai kemampuan mahasiswa dalam merancang sistem yang scalable, yaitu sistem yang dapat dikembangkan, dapat menangani pertambahan pengguna, dapat mengelola pertambahan data, dan tetap stabil ketika jumlah akses meningkat.
Mahasiswa tidak boleh hanya membuat tampilan web biasa. Proyek harus menunjukkan penerapan konsep Scalable System Design melalui rancangan modul, arsitektur sistem, pembagian vCPU atau server virtual, integrasi database, hak akses pengguna, strategi scaling, monitoring, logging, dan optimasi sistem.

C. Latar Belakang Proyek
Banyak sekolah masih menggunakan sistem yang terpisah untuk mengelola jurnal mengajar, data siswa, data BK, absensi, nilai, jadwal, dan laporan akademik. Kondisi tersebut dapat menimbulkan beberapa masalah, seperti data ganda, data tidak sinkron, proses administrasi lambat, sulitnya membuat laporan, dan terbatasnya integrasi antarbagian sekolah.
Contohnya, data siswa yang sudah ada pada bagian kesiswaan sering kali harus dimasukkan ulang pada sistem BK atau sistem jurnal mengajar. Hal ini tidak efisien dan dapat menyebabkan perbedaan data antara satu bagian dengan bagian lain.
Melalui proyek ini, mahasiswa diminta merancang dan mengembangkan sistem web sekolah yang terintegrasi. Setiap modul memiliki fungsi masing-masing, tetapi tetap menggunakan data utama yang sama. Data siswa, guru, kelas, mata pelajaran, tahun ajaran, dan pengguna harus dapat digunakan bersama oleh beberapa modul.
Selain itu, sistem harus dirancang dengan mempertimbangkan skalabilitas. Artinya, sistem harus dapat dikembangkan jika jumlah siswa bertambah, jumlah guru bertambah, jumlah akses meningkat, atau sekolah membutuhkan modul baru pada masa depan.

D. Tujuan Proyek
Setelah menyelesaikan proyek ini, mahasiswa diharapkan mampu:
Merancang web sekolah terintegrasi yang terdiri dari beberapa modul utama.
Menjelaskan hubungan antar-modul dalam satu sistem.
Merancang satu database utama yang digunakan bersama oleh semua modul.
Menerapkan konsep Scalable System Design dalam rancangan sistem.
Membuat rancangan pembagian layanan menggunakan beberapa vCPU atau server virtual.
Menjelaskan strategi skalabilitas sistem, baik secara horizontal maupun vertikal.
Merancang hak akses pengguna berdasarkan peran atau role.
Membuat dokumentasi proyek yang sistematis dan mudah dipahami.
Mengunggah source code proyek ke GitHub.
Membuat video presentasi proyek dan mengunggahnya ke YouTube.

E. Bentuk Pengerjaan
Proyek ini dikerjakan secara berkelompok.
Setiap kelompok terdiri dari 3 sampai 5 mahasiswa. Jumlah ideal anggota kelompok adalah 4 mahasiswa agar pembagian tugas dapat dilakukan secara seimbang.
Setiap kelompok wajib mencantumkan nama anggota, NIM, kelas, dan pembagian tugas masing-masing dalam laporan proyek.
Pembagian tugas dapat disusun sebagai berikut:
System Analyst / Project Lead
Bertugas menyusun latar belakang, tujuan, analisis kebutuhan, alur sistem, dan use case.
System Architect
Bertugas menyusun arsitektur sistem, pembagian vCPU, load balancing, API integration, scaling strategy, monitoring, dan logging.
Database Designer
Bertugas menyusun rancangan database, ERD, tabel, relasi, indeks, dan penjelasan konsistensi data.
UI/UX dan Documentation Designer
Bertugas membuat rancangan tampilan, diagram pendukung, dokumentasi akhir, dan menyusun laporan agar rapi.
Security and Access Control Designer
Bertugas merancang role pengguna, pembatasan akses data, audit log, autentikasi, dan mitigasi risiko keamanan.
Jika anggota kelompok hanya 3 orang, beberapa tugas dapat digabung. Jika anggota kelompok 5 orang, pembagian tugas harus dibuat lebih spesifik.
Setiap anggota wajib berkontribusi dan menjelaskan bagian yang dikerjakan pada video presentasi.

F. Ketentuan Sistem yang Dibuat
Mahasiswa wajib membuat proyek web sekolah dengan ketentuan berikut.
1. Sistem Memiliki Minimal Tiga Modul Utama
Minimal sistem harus memiliki tiga modul berikut:
Modul Jurnal Mengajar
Modul BK
Modul Data Kesiswaan
Mahasiswa boleh menambahkan modul lain, seperti:
Modul Akademik
Modul Absensi
Modul Nilai
Modul Jadwal Pelajaran
Modul Perpustakaan
Modul Keuangan Sekolah
Modul Informasi Orang Tua
Modul Laporan Kepala Sekolah
Semakin baik integrasi antar-modul, semakin kuat nilai proyek.

2. Semua Modul Menggunakan Satu Database Utama
Semua modul harus menggunakan satu database utama. Database ini menjadi pusat penyimpanan data sekolah.
Data yang digunakan bersama dapat berupa:
Data siswa
Data guru
Data kelas
Data mata pelajaran
Data tahun ajaran
Data semester
Data pengguna
Data role
Data aktivitas sistem
Contoh integrasi:
Modul BK mengambil data siswa dari tabel siswa.
Modul Jurnal Mengajar mengambil data guru, kelas, dan mata pelajaran dari database yang sama.
Modul Akademik menggunakan data siswa, guru, kelas, dan mata pelajaran yang sama.
Modul Manajemen Pengguna mengatur hak akses semua pengguna dalam sistem.

3. Sistem Memiliki Hak Akses Pengguna
Sistem harus memiliki rancangan hak akses pengguna berdasarkan role.
Contoh role pengguna:
Admin
Kepala sekolah
Guru
Guru BK
Wali kelas
Siswa
Orang tua
Setiap role harus memiliki hak akses yang berbeda.
Contoh:
Admin dapat mengelola seluruh data.
Guru dapat mengisi jurnal mengajar.
Guru BK dapat mengelola data konseling dan pelanggaran siswa.
Wali kelas dapat melihat data siswa di kelasnya.
Kepala sekolah dapat melihat laporan.
Siswa hanya dapat melihat data tertentu yang berkaitan dengan dirinya.
Orang tua hanya dapat melihat perkembangan anaknya.

4. Sistem Menunjukkan Unsur Scalable System Design
Mahasiswa wajib menjelaskan bagaimana sistem dapat berkembang ketika:
Jumlah pengguna bertambah.
Jumlah siswa bertambah.
Jumlah data semakin besar.
Jumlah akses meningkat.
Sekolah ingin menambahkan modul baru.
Salah satu modul memiliki beban akses lebih tinggi daripada modul lain.
Unsur Scalable System Design harus terlihat pada rancangan sistem, bukan hanya ditulis sebagai teori.

G. Modul Minimal yang Harus Ada
1. Modul Jurnal Mengajar
Modul Jurnal Mengajar digunakan oleh guru untuk mencatat aktivitas pembelajaran.
Fitur minimal:
Login guru
Input jurnal mengajar
Pilih kelas
Pilih mata pelajaran
Input tanggal mengajar
Input materi pembelajaran
Input metode pembelajaran
Input catatan pembelajaran
Riwayat jurnal mengajar
Rekap jurnal per guru atau per kelas
Contoh alur:
Guru login ke sistem. Guru memilih menu Jurnal Mengajar. Guru memilih kelas, mata pelajaran, tanggal, dan materi pembelajaran. Setelah data disimpan, sistem mencatat jurnal tersebut ke database.

2. Modul BK
Modul BK digunakan oleh guru BK untuk mencatat data bimbingan, konseling, pelanggaran, prestasi, dan tindak lanjut siswa.
Fitur minimal:
Login guru BK
Cari data siswa
Input data konseling
Input data pelanggaran
Input data prestasi
Input catatan tindak lanjut
Riwayat pembinaan siswa
Rekap kasus BK per siswa atau per kelas
Contoh alur:
Guru BK login ke sistem. Guru BK mencari nama siswa atau NIS. Guru BK mencatat kasus, hasil konseling, dan tindak lanjut. Data tersebut tersimpan ke database dan hanya dapat diakses oleh pihak yang berwenang.

3. Modul Data Kesiswaan
Modul Data Kesiswaan digunakan untuk mengelola data utama siswa.
Fitur minimal:
Tambah data siswa
Ubah data siswa
Hapus data siswa jika diperlukan
Kelola data kelas
Kelola data wali kelas
Kelola status siswa
Import data siswa
Export data siswa
Riwayat data siswa
Contoh status siswa:
Aktif
Pindah
Lulus
Keluar
Contoh alur:
Admin kesiswaan login ke sistem. Admin menambahkan data siswa baru. Data siswa tersebut otomatis dapat digunakan oleh modul BK, modul jurnal mengajar, dan modul akademik.

4. Modul Manajemen Pengguna
Modul Manajemen Pengguna digunakan untuk mengatur akun dan hak akses.
Fitur minimal:
Login
Logout
Manajemen akun pengguna
Manajemen role
Reset password
Pembatasan akses berdasarkan role
Audit log aktivitas pengguna
Contoh alur:
Admin membuat akun untuk guru, guru BK, wali kelas, kepala sekolah, siswa, dan orang tua. Setiap akun diberi role sesuai tugasnya. Sistem akan membatasi menu dan data yang dapat diakses berdasarkan role tersebut.






H. Arsitektur Sistem yang Diharapkan
Mahasiswa harus membuat rancangan arsitektur sistem. Arsitektur dapat dibuat dalam bentuk diagram.
Contoh arsitektur sederhana:

Mahasiswa boleh menggunakan pendekatan:
Modular monolith
Service-based architecture
Microservices sederhana
Hybrid architecture
Untuk proyek MID, mahasiswa tidak harus benar-benar membuat microservices penuh. Namun, mahasiswa harus mampu menjelaskan bagaimana sistem dapat dikembangkan menuju arsitektur yang lebih scalable.


I. Pembagian vCPU atau Server Virtual
Mahasiswa wajib membuat rancangan pembagian vCPU atau server virtual.
vCPU dalam proyek ini dapat dipahami sebagai server virtual atau node layanan yang digunakan untuk membagi beban sistem.
Contoh rancangan pembagian vCPU:
vCPU 1: Web Sistem Jurnal Mengajar
vCPU 2: Web BK
vCPU 3: Web Data Kesiswaan
vCPU 4: Web Akademik dan Manajemen Pengguna
vCPU 5: Database Server
vCPU 6: Load Balancer, Backup, Monitoring, dan Logging
Mahasiswa boleh membuat rancangan pembagian lain selama dapat memberikan alasan teknis yang jelas.
Contoh alasan teknis:
Modul Jurnal Mengajar dipisahkan karena sering diakses guru setiap hari.
Modul BK dipisahkan karena berisi data sensitif.
Database Server dipisahkan agar performa penyimpanan data lebih stabil.
Load Balancer digunakan untuk membagi request pengguna.
Monitoring digunakan untuk memantau performa server dan error sistem.

J. Unsur Scalable System Design yang Wajib Dijelaskan
Mahasiswa wajib menjelaskan minimal enam unsur berikut.
1. Modular Architecture
Sistem harus dibagi menjadi beberapa modul. Setiap modul memiliki fungsi yang jelas.
Contoh:
Modul Jurnal Mengajar fokus pada aktivitas pembelajaran.
Modul BK fokus pada bimbingan dan konseling siswa.
Modul Kesiswaan fokus pada data utama siswa.
Modul Manajemen Pengguna fokus pada akun dan hak akses.
Tujuannya agar sistem mudah dikembangkan dan tidak bercampur antara satu fungsi dengan fungsi lain.

2. Centralized Database
Seluruh modul menggunakan satu database utama. Tujuannya agar data tetap konsisten dan tidak terjadi duplikasi data.
Contoh:
Data siswa cukup disimpan satu kali pada tabel students. Data tersebut dapat digunakan oleh modul BK, Jurnal Mengajar, Akademik, dan Laporan.

3. Load Balancing
Load balancing digunakan untuk membagi request pengguna ke beberapa server atau layanan.
Contoh:
Jika banyak guru login untuk mengisi jurnal mengajar, request pengguna dapat dibagi ke beberapa server agar sistem tidak overload.

4. Horizontal Scaling
Horizontal scaling dilakukan dengan menambah server atau vCPU baru.
Contoh:
Jika modul Jurnal Mengajar paling banyak diakses, maka layanan Jurnal Mengajar dapat ditambah menjadi dua server.

5. Vertical Scaling
Vertical scaling dilakukan dengan menambah kapasitas server.
Contoh:
Server database ditingkatkan kapasitas CPU, RAM, atau storage agar mampu menangani data yang semakin besar.

6. API-Based Integration
Setiap modul dapat saling berkomunikasi melalui API.
Contoh:
Modul BK mengambil data siswa melalui API dari layanan data kesiswaan. Modul Jurnal Mengajar mengambil data kelas dan mata pelajaran melalui API akademik.

7. Role-Based Access Control
Sistem harus membatasi akses berdasarkan role pengguna.
Contoh:
Guru biasa tidak boleh mengakses catatan konseling siswa. Data BK hanya dapat diakses oleh guru BK, kepala sekolah, atau pihak yang diberi izin.

8. Database Optimization
Database harus dirancang agar pencarian data lebih cepat dan relasinya jelas.
Contoh strategi:
Membuat indeks pada student_id, teacher_id, class_id, dan subject_id.
Menentukan relasi antar-tabel dengan jelas.
Menghindari duplikasi data.
Menggunakan query yang efisien.

9. Caching
Caching digunakan untuk menyimpan data yang sering diakses agar sistem tidak selalu mengambil data langsung dari database.
Contoh data yang dapat di-cache:
Daftar kelas
Daftar guru
Daftar mata pelajaran
Jadwal pelajaran
Menu aplikasi

10. Monitoring dan Logging
Monitoring digunakan untuk memantau performa sistem. Logging digunakan untuk mencatat aktivitas pengguna dan error aplikasi.
Contoh data yang dipantau:
Jumlah request
Penggunaan CPU
Penggunaan RAM
Error aplikasi
Aktivitas login
Aktivitas perubahan data
Aktivitas akses data sensitif

K. Rancangan Database
Mahasiswa wajib membuat rancangan database awal.
Minimal tabel yang harus ada:
users
roles
students
teachers
classes
subjects
academic_years
semesters
teaching_journals
bk_cases
bk_counseling_notes
student_violations
student_achievements
schedules
activity_logs
Mahasiswa dapat menambahkan tabel lain sesuai kebutuhan.
Contoh relasi:
Tabel users terhubung dengan tabel roles.
Tabel students terhubung dengan tabel classes.
Tabel teachers terhubung dengan tabel subjects.
Tabel teaching_journals terhubung dengan teachers, classes, dan subjects.
Tabel bk_cases terhubung dengan students dan teachers.
Tabel bk_counseling_notes terhubung dengan students dan teachers.
Tabel activity_logs mencatat aktivitas pengguna dalam sistem.
Mahasiswa wajib membuat ERD atau diagram relasi database.




L. Use Case Minimal
Mahasiswa wajib membuat minimal tiga use case.
Use Case 1: Guru Mengisi Jurnal Mengajar
Guru login ke sistem. Guru memilih menu Jurnal Mengajar. Guru memilih kelas, mata pelajaran, tanggal, dan materi pembelajaran. Sistem menyimpan data jurnal ke database. Kepala sekolah atau wakil kurikulum dapat melihat rekap jurnal mengajar.

Use Case 2: Guru BK Mencatat Kasus Siswa
Guru BK login ke sistem. Guru BK mencari data siswa berdasarkan nama atau NIS. Guru BK mencatat kasus, hasil konseling, dan tindak lanjut. Sistem menyimpan data tersebut ke database. Data hanya dapat diakses oleh guru BK, kepala sekolah, atau pengguna yang memiliki hak akses.

Use Case 3: Admin Mengelola Data Siswa
Admin login ke sistem. Admin menambahkan data siswa baru, mengubah data kelas, atau memperbarui status siswa. Data siswa yang telah diperbarui dapat digunakan oleh modul Jurnal Mengajar, modul BK, dan modul Akademik.

Mahasiswa boleh menambahkan use case lain, misalnya:
Kepala sekolah melihat laporan.
Wali kelas melihat data siswa di kelasnya.
Siswa melihat jadwal pelajaran.
Orang tua melihat perkembangan anak.
Admin melihat log aktivitas pengguna.

M. Pertanyaan Analisis yang Wajib Dijawab
Dalam laporan proyek, mahasiswa wajib menjawab pertanyaan berikut.
Mengapa sistem web sekolah ini membutuhkan desain yang scalable?
Apa masalah yang mungkin terjadi jika semua modul dibuat dalam satu aplikasi tanpa pembagian layanan?
Bagaimana cara sistem menjaga konsistensi data jika semua modul menggunakan satu database?
Modul mana yang paling mungkin mengalami beban akses paling tinggi? Jelaskan alasannya.
Bagaimana strategi scaling yang tepat jika jumlah pengguna meningkat?
Apa risiko dari penggunaan satu database terpusat?
Bagaimana cara mengurangi risiko database menjadi bottleneck?
Bagaimana sistem membatasi akses data sensitif, terutama data BK?
Bagaimana sistem tetap dapat dikembangkan jika sekolah ingin menambah modul baru?
Bagaimana monitoring dan logging membantu menjaga kestabilan sistem?
Jawaban tidak boleh hanya berupa teori. Jawaban harus dikaitkan langsung dengan proyek web sekolah yang dibuat.

N. Ketentuan Laporan Proyek
Setiap kelompok wajib membuat laporan proyek dalam format PDF.
Laporan minimal memuat:
Cover
Nama kelompok
Nama anggota, NIM, dan kelas
Pembagian tugas setiap anggota
Judul proyek
Latar belakang
Tujuan proyek
Deskripsi sistem
Daftar modul yang dibuat
Fitur setiap modul
Arsitektur sistem
Rancangan pembagian vCPU
Rancangan database
ERD atau relasi antar-tabel
Rancangan hak akses pengguna
Alur kerja sistem
Use case minimal tiga skenario
Penjelasan unsur Scalable System Design
Risiko sistem dan solusi
Jawaban pertanyaan analisis
Kesimpulan
Link YouTube
Link GitHub
Nama file laporan:
MID_ScalableSystemDesign_NamaKelompok_Kelas.pdf
Contoh:
MID_ScalableSystemDesign_Kelompok3_TI4A.pdf

O. Ketentuan Video Presentasi YouTube
Setiap kelompok wajib membuat video presentasi yang menjelaskan proyek Web Sekolah Terintegrasi Berbasis Scalable System Design.
Video diunggah ke YouTube melalui salah satu akun anggota kelompok.
Ketentuan video:
Video diatur sebagai public atau unlisted.
Video tidak boleh diatur sebagai private.
Durasi video adalah 10 sampai 15 menit.
Setiap anggota kelompok wajib tampil atau berbicara dalam video.
Setiap anggota wajib menjelaskan bagian yang menjadi tanggung jawabnya.
Suara harus jelas.
Tampilan slide, diagram, atau aplikasi harus terbaca.
Penjelasan harus runtut dan mudah dipahami.
Video presentasi minimal memuat:
Pembukaan dan pengenalan anggota kelompok
Latar belakang masalah
Tujuan proyek
Gambaran umum sistem web sekolah
Penjelasan modul yang dibuat
Arsitektur sistem
Pembagian vCPU atau server virtual
Rancangan database dan relasi tabel
Rancangan hak akses pengguna
Penjelasan unsur Scalable System Design
Risiko sistem dan solusi
Kesimpulan
Mahasiswa boleh menggunakan:
Slide presentasi
Rekaman layar
Diagram arsitektur
ERD
Tampilan prototipe web
Demo sistem sederhana
Kombinasi dari beberapa media tersebut
Mahasiswa tidak boleh hanya membaca teks. Mahasiswa harus menjelaskan rancangan sistem dengan bahasa sendiri.

P. Ketentuan Upload Proyek ke GitHub
Setiap kelompok wajib mengunggah proyek web sekolah ke GitHub.
Repository GitHub digunakan sebagai:
Bukti pengerjaan proyek
Tempat menyimpan source code
Dokumentasi teknis
Media penilaian struktur proyek
Bukti kontribusi anggota kelompok
Repository dapat dibuat pada salah satu akun anggota kelompok.
Nama repository disarankan menggunakan format:
MID-SSD-Web-Sekolah-NamaKelompok
Contoh:
MID-SSD-Web-Sekolah-Kelompok-3
Repository GitHub minimal harus memuat:
Source code proyek web sekolah
File database atau rancangan database
File dokumentasi proyek
Diagram arsitektur sistem
Diagram relasi database atau ERD
File README.md
Daftar anggota kelompok dan pembagian tugas
Panduan instalasi dan cara menjalankan proyek
Link video presentasi YouTube
Screenshot tampilan sistem, jika ada
Repository boleh bersifat public atau private.
Jika repository dibuat private, kelompok wajib mengundang dosen sebagai collaborator atau memberikan akses yang dapat dibuka oleh dosen.
Repository public lebih disarankan agar pemeriksaan lebih mudah.

Q. Ketentuan File README.md
Setiap repository wajib memiliki file README.md.
File README.md wajib memuat:
Judul proyek
Deskripsi singkat sistem
Nama anggota kelompok
Pembagian tugas setiap anggota
Daftar modul yang dibuat
Teknologi yang digunakan
Struktur folder proyek
Rancangan arsitektur sistem
Rancangan database
Cara instalasi
Cara menjalankan aplikasi
Akun login demo, jika ada
Link video presentasi YouTube
Penjelasan unsur Scalable System Design dalam proyek
Contoh akun demo boleh ditulis seperti ini:
Admin
Email: admin@sekolah.test
Password: password123
Guru
Email: guru@sekolah.test
Password: password123
Guru BK
Email: bk@sekolah.test
Password: password123
Gunakan akun demo, bukan akun asli.

R. Ketentuan Keamanan Repository
Mahasiswa tidak boleh mengunggah data sensitif ke GitHub.
Repository tidak boleh memuat:
Password database asli
Token API
File .env asli yang berisi kredensial
Private key
Data pribadi siswa yang sebenarnya
Data rahasia sekolah
Kredensial akun admin asli
Jika proyek membutuhkan file konfigurasi, gunakan file contoh seperti:
.env.example
Jika proyek membutuhkan data, gunakan data dummy.
Contoh data dummy:
Nama siswa fiktif
Nama guru fiktif
Kelas fiktif
Mata pelajaran fiktif
Data kasus BK fiktif
Data jurnal mengajar fiktif

S. Format Pengumpulan
Setiap kelompok wajib mengumpulkan data proyek dengan format berikut:
Nama Kelompok:
Kelas:
Nama Anggota:
Judul Proyek:
Link YouTube:
Link GitHub:
Link Dokumen Laporan:
Ketiga link wajib dapat diakses oleh dosen pada saat batas akhir pengumpulan.
Link yang tidak dapat dibuka dianggap belum memenuhi ketentuan pengumpulan proyek.

T. Output yang Wajib Dikumpulkan
Setiap kelompok wajib mengumpulkan tiga komponen utama:
Laporan proyek dalam format PDF
Link video presentasi YouTube
Link repository GitHub proyek web sekolah
Laporan proyek berisi rancangan sistem, arsitektur, pembagian vCPU, database, hak akses pengguna, alur kerja sistem, use case, unsur Scalable System Design, risiko sistem, solusi, dan kesimpulan.
Video YouTube berisi penjelasan proyek secara lisan oleh seluruh anggota kelompok.
Repository GitHub berisi source code, dokumentasi teknis, rancangan database, diagram, README, dan panduan menjalankan proyek.

U. Ketentuan Teknis Pengembangan
Mahasiswa boleh menggunakan teknologi berikut.
Frontend:
HTML
CSS
JavaScript
Bootstrap
Tailwind CSS
React
Vue
Backend:
PHP
Laravel
CodeIgniter
Node.js
Express.js
Python Flask
Python Django
Database:
MySQL
PostgreSQL
MariaDB
Server dan tools pendukung:
Nginx
HAProxy
Docker
Redis
GitHub
Draw.io
Figma
Canva
Lucidchart
Mahasiswa tidak wajib menggunakan semua teknologi tersebut. Pilih teknologi yang paling dikuasai oleh kelompok.
Untuk Ujian MID, mahasiswa tidak wajib melakukan deployment online. Proyek cukup dapat dijalankan secara lokal. Deployment online dapat menjadi nilai tambahan jika kelompok mampu melakukannya.

V. Kriteria Penilaian Umum
Penilaian proyek MID menggunakan kriteria berikut:
Kesesuaian proyek dengan studi kasus web sekolah: 10%
Kelengkapan modul dan fitur sistem: 15%
Kualitas arsitektur sistem: 20%
Penerapan konsep Scalable System Design: 25%
Rancangan database dan relasi data: 10%
Keamanan akses dan pembagian role pengguna: 5%
Kerapian dokumentasi dan laporan: 10%
Kreativitas dan pengembangan tambahan: 5%
Total: 100%

W. Penilaian Video Presentasi
Penilaian video presentasi mencakup:
Kejelasan penjelasan proyek: 20%
Kelengkapan pembahasan modul sistem: 15%
Kualitas penjelasan arsitektur dan pembagian vCPU: 20%
Ketepatan penerapan konsep Scalable System Design: 25%
Kualitas diagram, slide, atau tampilan pendukung: 10%
Kontribusi dan keterlibatan setiap anggota kelompok: 10%
Video yang hanya menjelaskan tampilan web tanpa membahas arsitektur, database, integrasi layanan, skalabilitas, dan pembagian beban sistem tidak akan memperoleh nilai maksimal.

X. Penilaian Repository GitHub
Penilaian repository GitHub mencakup:
Kelengkapan source code proyek: 25%
Struktur folder dan kerapian kode: 15%
Kelengkapan README.md: 20%
Dokumentasi instalasi dan cara menjalankan sistem: 15%
Ketersediaan rancangan database, ERD, dan diagram arsitektur: 15%
Riwayat commit dan kontribusi anggota kelompok: 10%
Repository yang tidak dapat diakses oleh dosen sampai batas waktu pengumpulan dianggap belum memenuhi ketentuan pengumpulan proyek.

Y. Hal yang Tidak Diperbolehkan
Mahasiswa tidak diperbolehkan:
Hanya membuat tampilan web tanpa konsep scalable system.
Mengumpulkan laporan tanpa source code GitHub.
Mengumpulkan video YouTube yang tidak dapat diakses.
Menggunakan repository private tanpa memberikan akses kepada dosen.
Mengunggah file .env asli berisi password atau token.
Menggunakan data siswa asli tanpa izin.
Menyalin proyek orang lain tanpa modifikasi dan pemahaman.
Membuat video presentasi yang hanya membaca teks tanpa penjelasan.
Tidak mencantumkan pembagian tugas anggota kelompok.
Tidak menjelaskan unsur Scalable System Design dalam proyek.

Z. Kesimpulan Tugas
Melalui proyek ini, mahasiswa diharapkan memahami bahwa sistem informasi sekolah tidak hanya membutuhkan tampilan dan fitur, tetapi juga membutuhkan rancangan arsitektur yang baik.
Sistem yang baik harus mampu menangani pertambahan pengguna, pertambahan data, penambahan modul, keamanan akses, integrasi layanan, pembagian beban, monitoring, logging, dan optimasi database.
Mahasiswa harus mampu menunjukkan bahwa proyek web sekolah yang dibuat bukan hanya web biasa, melainkan sistem yang dirancang dengan prinsip Scalable System Design.
