# Event & Ticket Management System

## 🚀 Tentang Project
Event Ticket adalah sistem manajemen event dan tiket yang dibangun menggunakan CodeIgniter 4. Sistem ini memungkinkan pengguna untuk mengelola event dan tiket secara efisien.

⚠️ **PENTING**: Project ini menggunakan CodeIgniter 4 karena versi PHPMyAdmin yang digunakan tidak mendukung CodeIgniter 3.

## 🛠️ Fitur Utama
- Manajemen Event
- Sistem Tiket
- Autentikasi Pengguna
- Dashboard Admin
- Manajemen Profil
- Role-based Access Control

## 📋 Prasyarat
- PHP >= 7.4
- MySQL/MariaDB
- Composer
- Web Server (Apache/Nginx)

## 🔧 Instalasi

1. Clone repository ini
```bash
git clone https://github.com/NovalMaulana/Manajemen-Tiket.git
```

2. Masuk ke direktori project
```bash
cd [nama_folder]
```

3. Install dependencies menggunakan Composer
```bash
composer install
```

4. Salin file env
```bash
cp env .env
```

5. Konfigurasi database di file .env
```env
database.default.hostname = localhost
database.default.database = [nama_database]
database.default.username = [username]
database.default.password = [password]
```

## 🗂️ Struktur Project
```
Manejemen Tiket/
├── app/                    # Direktori aplikasi
│   ├── Controllers/       # Controller aplikasi
│   ├── Models/           # Model database
│   ├── Views/           # File-file view
│   └── Filters/        # Filter aplikasi
├── public/              # Asset publik
└── system/             # Core system CI4
```

## 🔐 Keamanan
- Implementasi AuthFilter untuk proteksi route
- Validasi input
- CSRF Protection
- XSS Prevention

## 📱 Plugin & Library
- Bootstrap
- jQuery
- DataTables
- SweetAlert2
- Chart.js
- Dan lainnya

## 👥 Kontribusi
Kontribusi selalu diterima. Untuk perubahan besar, harap buka issue terlebih dahulu untuk mendiskusikan apa yang ingin Anda ubah.

## 🙏 Ucapan Terima Kasih
Terima kasih kepada semua kontributor yang telah membantu dalam pengembangan project ini. 
