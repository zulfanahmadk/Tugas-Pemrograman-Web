=========================================================
HR SYSTEM - APLIKASI CRUD PEGAWAI & JABATAN
=========================================================

Deskripsi:
Aplikasi ini merupakan sistem informasi sederhana untuk mengelola entitas 
Pegawai, Jabatan, serta Penugasan Jabatan pada Pegawai (Relasi). 
Aplikasi dibangun menggunakan teknologi murni tanpa framework besar:
- Backend: PHP (Native)
- Frontend: HTML, CSS (Vanilla), JavaScript (Vanilla - Fetch API)
- Database: MySQL (db_tiga)

--- FITUR ---
1. Single Page Application (SPA): Berpindah antar halaman tanpa loading.
2. Manajemen Pegawai (Tambah, Edit, Hapus, Tampil).
3. Manajemen Jabatan (Tambah, Edit, Hapus, Tampil).
4. Penugasan Jabatan (Mengatur relasi pegawai menduduki jabatan apa).
5. Dark Mode: Tema gelap untuk kenyamanan mata.

--- STRUKTUR FILE ---
- db_tiga.sql         : Database yang digunakan
- koneksi.php         : Konfigurasi koneksi PHP ke database (MySQL).
- index.php           : Kerangka utama HTML (Antarmuka Pengguna).
- style.css           : Styling premium (tata letak, warna, animasi).
- script.js           : Logika JavaScript (AJAX) untuk menarik/mengirim data ke API.
- api_pegawai.php     : File API backend khusus entitas Pegawai.
- api_jabatan.php     : File API backend khusus entitas Jabatan.
- api_jabatanpegawai.php: File API backend khusus entitas Relasi.

--- PANDUAN PENGGUNAAN ---
1. Persiapan
   - Pastikan modul Apache dan MySQL sudah berjalan di XAMPP Control Panel.
   - Pastikan database "db_tiga" sudah ada di phpMyAdmin (bisa import dari file sql sebelumnya jika belum ada).

2. Akses Aplikasi
   - Buka browser web (Google Chrome, Firefox, dsb).
   - Ketikkan alamat berikut di bilah URL: 
     http://localhost/{nama_folder}/ -> tanpa tanda {} dan gunakan garis miring di akhir

3. Menggunakan Dashboard
   - Di sisi kiri (Sidebar), Anda dapat menekan menu "Dashboard", "Data Pegawai", "Data Jabatan", atau "Jabatan Pegawai".
   - Untuk menambah data, masuk ke salah satu menu data (contoh: Data Pegawai), lalu tekan tombol biru "+ Tambah Pegawai" di kanan atas tabel.
   - Untuk mengubah atau menghapus data, gunakan tombol dengan icon Pensil (Edit) dan Tempat Sampah (Hapus) pada kolom 'Aksi' di baris tabel.

4. Catatan Penting
   - Karena tabel "jabatanpegawai" berelasi (memiliki foreign key) ke tabel "pegawai" dan "jabatan", jika Anda menghapus data di tabel Induk (misal menghapus seorang pegawai), maka data penugasan pegawai tersebut otomatis terhapus untuk menjaga konsistensi database (ON DELETE CASCADE).

=========================================================
Created with ❤️ by Antigravity
=========================================================
