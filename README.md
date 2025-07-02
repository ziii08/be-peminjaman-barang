# Sistem Peminjaman Barang

Sistem Peminjaman Barang adalah aplikasi web berbasis Laravel yang dirancang untuk mengelola dan melacak peminjaman barang dalam suatu organisasi. Aplikasi ini menyediakan antarmuka yang intuitif untuk mencatat, memantau, dan menghasilkan laporan tentang transaksi peminjaman barang.

## Fitur Utama

- **Dashboard Admin**: Tampilan komprehensif untuk melihat semua transaksi peminjaman
- **Sistem Filtering**: Filter data berdasarkan tanggal dan status peminjaman
- **Export Data**: Kemampuan untuk mengekspor data transaksi ke format Excel dan PDF
- **Pelacakan Status**: Pemantauan status peminjaman (aktif/kembali)
- **Perhitungan Durasi**: Penghitungan otomatis durasi peminjaman

## Teknologi yang Digunakan

- **Backend**: Laravel (PHP Framework)
- **Database**: MySQL/MariaDB
- **Frontend**: Bootstrap 5, Bootstrap Icons
- **Export Tools**: Laravel Excel, DOMPDF

## Instalasi

### Persyaratan Sistem

- PHP >= 8.0
- Composer
- MySQL/MariaDB
- Node.js & NPM (untuk asset compilation)

### Langkah Instalasi

1. Clone repositori ini:
   ```bash
   git clone https://github.com/ziii08/be-peminjaman-barang.git
   cd peminjaman-barang
   ```

2. Instal dependensi PHP:
   ```bash
   composer install
   ```

3. Instal dependensi JavaScript:
   ```bash
   npm install
   ```

4. Salin file .env.example menjadi .env:
   ```bash
   cp .env.example .env
   ```

5. Generate application key:
   ```bash
   php artisan key:generate
   ```

6. Konfigurasi database di file .env:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=peminjaman_barang
   DB_USERNAME=root
   DB_PASSWORD=
   ```

7. Jalankan migrasi database:
   ```bash
   php artisan migrate
   ```

8. (Opsional) Jalankan seeder untuk data awal:
   ```bash
   php artisan db:seed
   ```

9. Compile assets:
   ```bash
   npm run dev
   ```

10. Jalankan server development:
    ```bash
    php artisan serve
    ```

11. Akses aplikasi di browser: `http://localhost:8000`

## Struktur Database

Aplikasi ini menggunakan tabel utama berikut:

- **users**: Menyimpan data pengguna/admin
- **transaksis**: Menyimpan data transaksi peminjaman barang

## Penggunaan

### Dashboard Admin

Dashboard admin menyediakan tampilan lengkap dari semua transaksi peminjaman dengan fitur berikut:

1. **Filter Data**:
   - Filter berdasarkan rentang tanggal
   - Filter berdasarkan status peminjaman (aktif/kembali)

2. **Export Data**:
   - Export ke Excel: Menghasilkan file Excel dengan data transaksi yang difilter
   - Export ke PDF: Menghasilkan file PDF dengan data transaksi yang difilter

3. **Tabel Data**:
   - Menampilkan ID transaksi
   - Kode barang
   - Nama peminjam
   - Waktu peminjaman
   - Waktu pengembalian
   - Status peminjaman
   - Durasi peminjaman

### Pengelolaan Transaksi

Aplikasi ini memungkinkan admin untuk:
- Melihat semua transaksi peminjaman
- Memfilter transaksi berdasarkan kriteria tertentu
- Mengekspor data transaksi untuk pelaporan

## Pengembangan Lanjutan

Untuk pengembangan lebih lanjut, Anda dapat:

1. Menambahkan fitur manajemen barang
2. Mengimplementasikan sistem notifikasi
3. Menambahkan fitur reservasi barang
4. Mengintegrasikan dengan sistem inventaris
5. Menambahkan dashboard untuk pengguna non-admin

## Lisensi

[MIT License](LICENSE)

## Kontributor

- [FAUZI DEV](https://github.com/ziii08)

---
