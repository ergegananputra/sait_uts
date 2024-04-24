# Deskripsi

Proyek ini terstruktur ke dalam dua folder utama: `api` dan `src`.

## Folder api

Folder `api` menampung logika backend aplikasi. Ini menangani permintaan yang masuk dan berinteraksi dengan database. Folder ini menyediakan dua jenis API:

1. **API Tabel Relasi:** API ini digunakan untuk mengambil data yang melibatkan penggabungan tabel dalam database. Ini berguna saat Anda perlu mengambil data dari beberapa tabel terkait dalam satu permintaan.

2. **API Individual:** API ini digunakan untuk melakukan operasi pada tabel individual dalam database. Terdapat API individual untuk tabel "perkuliahan" (kuliah), "mahasiswa" (siswa), dan "matakuliah" (mata kuliah).

## Folder src

Folder `src` berisi elemen frontend aplikasi, khususnya tampilan yang disajikan kepada pengguna. Tampilan ini berada di subfolder `view`. Tampilan utama, `main_index.php`, bertanggung jawab untuk menampilkan semua data yang diambil menggunakan tipe API yang pertama.

## Routing dan Model

* **route.php (src/route):** File ini bertugas untuk merutekan permintaan masuk ke tampilan yang sesuai berdasarkan URL yang diminta.
* **model_classes.php (api/model & src/model):** File-file ini mendefinisikan model data yang digunakan di seluruh aplikasi.

## File Utilitas

* **import_helper.php (api/utils & src/utils):** File-file ini berfungsi sebagai penolong utilitas, menyediakan fungsi yang digabungkan ke dalam file lain di dalam direktori masing-masing.

## Konfigurasi Database

* **db_config.php (api):** File ini berisi detail konfigurasi koneksi database.

## Data Awal

* **sait_db_uts.sql:** File dump SQL ini berisi perintah SQL yang diperlukan untuk membuat struktur database dan mengisinya dengan data awal.