# 🛋️ FurniStock – Sistem Manajemen Stok Toko Furniture

FurniStock adalah aplikasi web berbasis **Laravel** untuk mengelola data produk dan stok toko furniture secara rapi dan modern.  
Project ini dibuat sebagai latihan **problem solving & CRUD** dengan tampilan UI yang mirip website premium.

---

## ✨ Fitur Utama

### 1. Manajemen Produk Furniture
- CRUD Produk (**Create, Read, Update, Delete**)
- Data yang disimpan:
  - Nama produk
  - Kategori (Meja, Kursi, Lemari, dll.)
  - Material (kayu, besi, dll.)
  - Warna
  - Ukuran
  - Harga
  - Minimal stok
  - Stok saat ini
- Upload foto produk:
  - Format: `jpg`, `jpeg`, `png`, `webp`
  - Maksimal ukuran file: 2 MB
  - Ditampilkan sebagai thumbnail di daftar produk dan gambar besar di halaman detail

### 2. Manajemen Stok (Stock Transaction)
- Mencatat **pergerakan stok** barang:
  - Stok **Masuk** (Barang datang, restock, koreksi stok)
  - Stok **Keluar** (Barang terjual, barang rusak, koreksi stok)
- Fitur transaksi stok:
  - Tambah transaksi stok
  - Edit transaksi stok
  - Hapus transaksi stok
- Stok produk otomatis ter-update setiap ada:
  - Penambahan transaksi baru
  - Perubahan transaksi (edit)
  - Penghapusan transaksi

### 3. Perhitungan Stok Otomatis
Setiap transaksi stok akan:
- Menambah stok jika **type = in**
- Mengurangi stok jika **type = out**
- Saat edit transaksi:
  - Efek transaksi lama dibatalkan dulu
  - Lalu efek transaksi baru diterapkan
- Saat hapus transaksi:
  - Efek transaksi dikembalikan ke stok

### 4. Indikator Stok Menipis
- Setiap produk punya field **minimal stok** (`min_stock`)
- Jika `stock <= min_stock`:
  - Ditandai dengan badge **“Stok Menipis”**
  - Membantu pemilik toko tahu produk mana yang harus cepat di-restock

### 5. UI/UX Premium
- Tampilan dibuat modern dan rapi:
  - Menggunakan **Bootstrap 5**
  - Typography dengan **Google Font Poppins**
  - Background gradient & card dengan efek shadow
  - Card dengan hover effect (terangkat sedikit)
- Layout:
  - Navbar dengan menu: **Produk** dan **Transaksi Stok**
  - Tabel responsif untuk daftar produk dan transaksi
  - Form yang rapi dengan validation error di bagian atas

---

## 🧱 Teknologi yang Digunakan

- **Framework**: Laravel
- **Bahasa**: PHP
- **Database**: MySQL (via XAMPP)
- **Front-End**:
  - Blade Template Engine
  - Bootstrap 5
  - Google Fonts (Poppins)
- **Lainnya**:
  - Eloquent ORM
  - Pagination
  - Form Request Validation
  - Storage link untuk upload gambar

---

## 📁 Struktur Fitur Utama

### Model

- `Product`
  - Relasi: `hasMany(StockTransaction::class)`
  - Menyimpan data produk & stok
- `StockTransaction`
  - Relasi: `belongsTo(Product::class)`
  - Menyimpan catatan keluar-masuk stok

### Controller

- `ProductController`
  - `index` – daftar produk + search
  - `create` / `store` – tambah produk + upload foto
  - `edit` / `update` – edit produk + ganti foto
  - `show` – detail produk + riwayat transaksi stok
  - `destroy` – hapus produk + hapus foto

- `StockTransactionController`
  - `index` – daftar semua transaksi stok
  - `create` / `store` – tambah transaksi stok (in/out)
  - `edit` / `update` – edit transaksi & sesuaikan stok
  - `destroy` – hapus transaksi & kembalikan stok produk

---

## 🚀 Cara Instalasi & Menjalankan Project

### 0. Prasyarat

Pastikan di komputer sudah terinstall:

- PHP **8.1+**
- [Composer](https://getcomposer.org/)
- MySQL / MariaDB (misalnya dari **XAMPP**)
- Git

---

### 1–7. Langkah Instalasi

1. **Clone Repository**

   ```bash
   git clone https://github.com/berandalofficial-byte/furniture-stock.git
   cd furniture-stock
2. **Install Dependency Laravel**

   ```bash
   composer install
3. **Salin & Atur File Environment**
   '''bash
   cp .env.example .env
4.**Generate APP_KEY**
   ```bash
   php artisan key:generate
5. **Migrasi Database**
   ```bash
   php artisan migrate
6. **Buat Storage Link (untuk Foto Produk)**
   ```bash
   php artisan storage:link
7. **Jalankan Development Server**
   ```bash
   php artisan serve
