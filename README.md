# 💬 Discussion Platform

<div align="center">
  <p>
    <img src="https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel" />
    <img src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP" />
    <img src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL" />
    <img src="https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black" alt="JavaScript" />
    <img src="https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS" />
  </p>
  
  <p>
    <img src="https://img.shields.io/github/stars/FarelNandaS/Discussion?style=social" alt="GitHub Stars" />
    <img src="https://img.shields.io/github/forks/FarelNandaS/Discussion?style=social" alt="GitHub Forks" />
    <img src="https://img.shields.io/github/issues/FarelNandaS/Discussion" alt="GitHub Issues" />
    <img src="https://img.shields.io/github/license/FarelNandaS/Discussion" alt="License" />
  </p>
</div>

---

Platform diskusi web yang dibuat dengan Laravel untuk memfasilitasi komunikasi dan berbagi ide dalam komunitas. Aplikasi ini memungkinkan pengguna untuk membuat akun, memulai topik diskusi, dan berpartisipasi dalam percakapan tentang berbagai topik.

## 📸 Screenshots

<div align="center">
  
  <!-- Tambahkan screenshot aplikasi Anda di sini -->
  <img src="https://i.postimg.cc/TwRXprKk/ss.png" alt="Homepage Screenshot" />

</div>

---

Discussion Platform adalah aplikasi web yang dirancang untuk memfasilitasi diskusi dan komunikasi dalam komunitas. Dengan fitur-fitur yang user-friendly, aplikasi ini memungkinkan pengguna untuk berbagi ide, bertanya, dan terlibat dalam percakapan yang bermakna.

## ✨ Fitur

- 👥 **Sistem Autentikasi** - Registrasi dan login pengguna yang aman
- 💬 **Diskusi Topik** - Buat dan kelola topik diskusi dengan mudah
- 🔍 **Pencarian Topik** - Cari diskusi berdasarkan judul atau konten
- 👤 **Profil Pengguna** - Kelola informasi profil dan aktivitas diskusi
- 🏷️ **Kategori Diskusi** - Organisir topik berdasarkan kategori
- ⚡ **Real-time Updates** - Update diskusi secara real-time
- 🔐 **Keamanan** - Sistem keamanan yang robust dengan Laravel

## 🛠️ Teknologi yang Digunakan

- [Laravel](https://laravel.com/) - PHP framework untuk pengembangan web
- [PHP](https://www.php.net/) - Server-side scripting language
- [MySQL](https://www.mysql.com/) - Database management system
- [Tailwind CSS](https://tailwindcss.com/) - Utility-first CSS framework
- [JavaScript](https://developer.mozilla.org/en-US/docs/Web/JavaScript) - Client-side scripting
- [Composer](https://getcomposer.org/) - PHP dependency manager

## 🚀 Instalasi dan Menjalankan Proyek

### Prasyarat

Pastikan Anda telah menginstal:
- PHP (versi 8.1 atau lebih baru)
- Composer
- MySQL atau MariaDB
- Node.js dan npm (untuk asset compilation)

### Langkah-langkah

1. **Clone repositori**
   ```bash
   git clone https://github.com/FarelNandaS/Discussion.git
   cd Discussion
   ```

2. **Install dependencies PHP**
   ```bash
   composer install
   ```

3. **Install dependencies JavaScript**
   ```bash
   npm install
   ```

4. **Setup environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Konfigurasi database**
   
   Edit file `.env` dan sesuaikan konfigurasi database:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=discussion_db
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

6. **Migrasi database**
   ```bash
   php artisan migrate
   ```

7. **Seed database (opsional)**
   ```bash
   php artisan db:seed
   ```

8. **Compile assets dengan Tailwind**
   ```bash
   npm run dev
   ```

9. **Jalankan aplikasi**
   ```bash
   php artisan serve
   ```

10. **Buka aplikasi**
    
    Buka [http://localhost:8000](http://localhost:8000) di browser Anda untuk melihat aplikasi.

## 📝 Cara Menggunakan

1. **Registrasi Akun**
   - Buka halaman registrasi
   - Isi formulir dengan informasi yang diperlukan
   - Verifikasi email jika diperlukan

2. **Login ke Aplikasi**
   - Masukkan kredensial login Anda
   - Akses dashboard utama

3. **Membuat Topik Diskusi**
   - Klik tombol "Buat Topik Baru"
   - Isi judul dan deskripsi topik
   - Pilih kategori yang sesuai
   - Publikasikan topik

4. **Berpartisipasi dalam Diskusi**
   - Jelajahi topik yang tersedia
   - Berikan komentar atau tanggapan
   - Gunakan fitur like/dislike
   - Ikuti topik yang menarik

5. **Mengelola Profil**
   - Edit informasi profil
   - Lihat riwayat aktivitas
   - Atur preferensi notifikasi

## 🌟 Pengembangan

Untuk pengembangan lebih lanjut, Anda dapat:

- Menambahkan fitur baru di direktori `app/`
- Membuat migration baru dengan `php artisan make:migration`
- Menambahkan model dengan `php artisan make:model`
- Membuat controller dengan `php artisan make:controller`
- Menambahkan middleware dengan `php artisan make:middleware`

## 📚 Struktur Proyek

```
Discussion/
├── app/
│   ├── Http/Controllers/
│   ├── Models/
│   ├── Middleware/
│   └── ...
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── ...
├── resources/
│   ├── views/
│   ├── js/
│   └── css/
├── routes/
│   ├── web.php
│   └── api.php
└── ...
```

## 🚢 Deployment

Untuk men-deploy aplikasi Laravel:

1. **Pilih hosting provider** (Heroku, DigitalOcean, AWS, dll.)
2. **Setup environment production**
3. **Konfigurasi database production**
4. **Compile assets untuk production**
   ```bash
   npm run prod
   ```
5. **Optimize aplikasi**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

Lihat [dokumentasi deployment Laravel](https://laravel.com/docs/deployment) untuk detail lebih lanjut.

## 🤝 Kontribusi

Kontribusi sangat diterima! Jika Anda memiliki saran untuk meningkatkan aplikasi ini, silakan:

1. Fork repositori
2. Buat branch fitur baru (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan Anda (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

## 📄 Lisensi

Proyek ini dilisensikan di bawah MIT License. Lihat file [LICENSE](LICENSE) untuk detail lebih lanjut.

## 👨‍💻 Pembuat

**FarelNandaS**

- GitHub: [@FarelNandaS](https://github.com/FarelNandaS)

## 🙏 Terima Kasih

- Tim Laravel untuk framework yang luar biasa
- Komunitas open source yang mendukung
- Semua kontributor yang telah membantu pengembangan proyek ini

## 📞 Dukungan

Jika Anda mengalami masalah atau memiliki pertanyaan:

- Buka [Issues](https://github.com/FarelNandaS/Discussion/issues) untuk melaporkan bug
- Diskusikan di [Discussions](https://github.com/FarelNandaS/Discussion/discussions) untuk saran dan pertanyaan
- Hubungi maintainer melalui email atau sosial media

---

⭐ Jangan lupa untuk memberikan star jika proyek ini membantu Anda!

<div align="center">
  Made with ❤️ by FarelNandaS
</div>
