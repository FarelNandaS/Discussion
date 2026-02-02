# Discussion Platform

Aplikasi platform diskusi berbasis web yang dibangun dengan Laravel 11 dan Livewire 3. Platform ini memungkinkan pengguna untuk membuat, berbagi, dan mendiskusikan topik-topik dengan fitur lengkap seperti komentar, reaksi, laporan konten, dan sistem verifikasi.

## 📋 Daftar Isi

- [Fitur Utama](#fitur-utama)
- [Stack Teknologi](#stack-teknologi)
- [Instalasi](#instalasi)
- [Struktur Direktori](#struktur-direktori)
- [Dokumentasi Module](#dokumentasi-module)
- [API Routes](#api-routes)

## ✨ Fitur Utama

- ✅ Autentikasi pengguna dengan email & Google OAuth
- ✅ Sistem verifikasi email
- ✅ Reset password melalui email
- ✅ Membuat, mengedit, dan menghapus post/diskusi
- ✅ Sistem komentar berjenjang
- ✅ Reaksi terhadap post dan komentar
- ✅ Pencarian dan filter konten
- ✅ Tag/kategori untuk post
- ✅ Simpan post favorit
- ✅ Laporan konten yang melanggar
- ✅ Appeal/banding untuk konten yang dilaporkan
- ✅ Dashboard admin untuk pengelolaan
- ✅ Sistem trust score untuk pengguna
- ✅ Notifikasi real-time
- ✅ Pengaturan profil dan keamanan

## 🛠 Stack Teknologi

**Backend:**
- Laravel 11.31
- PHP 8.2+
- Livewire 3.6
- Laravel Socialite 5.23 (Google OAuth)
- Spatie Permission 6.21 (Role & Permission)

**Frontend:**
- Tailwind CSS 4.1
- Vite 5.0
- DaisyUI 5.5
- Alpine.js
- jQuery
- ApexCharts (Grafik)
- DataTables (Tabel)
- Tagify (Tag Input)

**Database:**
- MySQL/PostgreSQL

**Testing:**
- Pest PHP 3.6
- PHPUnit

## 📦 Instalasi

### Prerequisites
- PHP 8.2 atau lebih tinggi
- Composer
- Node.js & npm
- MySQL/PostgreSQL

### Setup Project

```bash
# Clone repository
git clone <repository-url>
cd Discussion

# Install PHP dependencies
composer install

# Install Node dependencies
npm install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Configure database di .env
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_DATABASE=discussion
# DB_USERNAME=root
# DB_PASSWORD=

# Run migrations
php artisan migrate

# Seed database (optional)
php artisan db:seed

# Build frontend assets
npm run build

# Untuk development
npm run dev

# Start server
php artisan serve
```

## 📁 Struktur Direktori

```
Discussion/
├── app/
│   ├── Http/
│   │   ├── Controllers/         # HTTP Controllers
│   │   └── Middleware/          # Custom Middleware
│   ├── Models/                  # Database Models
│   ├── Jobs/                    # Queue Jobs
│   ├── Notifications/           # Email Notifications
│   └── Providers/               # Service Providers
├── routes/
│   ├── web.php                  # Web Routes
│   └── console.php              # Console Commands
├── database/
│   ├── migrations/              # Database Migrations
│   ├── factories/               # Model Factories
│   └── seeders/                 # Database Seeders
├── resources/
│   ├── views/                   # Blade Templates
│   ├── css/                     # Stylesheet
│   └── js/                      # JavaScript
├── config/                      # Configuration Files
├── storage/                     # Uploaded Files & Logs
├── tests/                       # Test Files
├── public/                      # Public Assets
└── vendor/                      # Dependencies
```

---

## 📚 Dokumentasi Module

### 1. **Models (Database Models)**

#### **User**
Model utama untuk pengguna platform.
- Fields: id, name, email, password, email_verified_at, profile_picture, bio, trust_score, suspended_at
- Relations: 
  - hasOne: UserDetail, UserSetting
  - hasMany: Post, Comment, Reaction, Report, Appeal, TrustScoreLog
  - belongsToMany: savedPosts (Post)

#### **Post**
Model untuk post/diskusi yang dibuat pengguna.
- Fields: id, user_id, title, content, created_at, updated_at
- Relations:
  - belongsTo: User
  - hasMany: Comment, Reaction, Report, Appeal
  - belongsToMany: Tag, Saved (User)

#### **Comment**
Model untuk komentar pada post.
- Fields: id, post_id, user_id, content, created_at, updated_at
- Relations:
  - belongsTo: Post, User
  - hasMany: Reaction, Report

#### **Tag**
Model untuk kategori/tag post.
- Fields: id, name, slug
- Relations:
  - belongsToMany: Post

#### **Reaction**
Model untuk reaksi (like/emoji) pada post atau comment.
- Fields: id, user_id, post_id, comment_id, reaction_type, created_at
- Relations:
  - belongsTo: User, Post, Comment

#### **Report**
Model untuk laporan konten yang melanggar.
- Fields: id, user_id, post_id, comment_id, reason, created_at
- Relations:
  - belongsTo: User, Post, Comment
  - hasOne: Appeal

#### **Appeals**
Model untuk appeal/banding atas laporan konten.
- Fields: id, report_id, user_id, reason, status, created_at, updated_at
- Relations:
  - belongsTo: Report, User

#### **Saved**
Model untuk post yang disimpan pengguna (Pivot table).
- Fields: user_id, post_id, created_at
- Relations:
  - belongsTo: User, Post

#### **UserDetail**
Model untuk detail tambahan profil pengguna.
- Fields: id, user_id, phone, address, city, country, website, date_of_birth
- Relations:
  - belongsTo: User

#### **UserSetting**
Model untuk pengaturan pengguna.
- Fields: id, user_id, email_notification, public_profile, two_factor_enabled
- Relations:
  - belongsTo: User

#### **TrustScoreLog**
Model untuk log perubahan trust score pengguna.
- Fields: id, user_id, change_amount, reason, created_at
- Relations:
  - belongsTo: User

#### **Remember_Me**
Model untuk token remember me.
- Fields: id, user_id, token, expires_at

#### **PostTag**
Pivot table untuk relasi Post-Tag.
- Fields: post_id, tag_id

---

### 2. **Controllers (HTTP Controllers)**

#### **IndexController**
Controller untuk halaman utama dan tampilan publik.
- `home()` - Halaman beranda dengan list post
- `login()` - Tampil form login
- `register()` - Tampil form register
- `search()` - Pencarian post
- `newest()` - List post terbaru
- `DetailPost($id)` - Detail halaman post
- `Profile($username)` - Profil pengguna
- `tags()` - Halaman list semua tag
- `tagPost($slug)` - Post dengan tag tertentu
- `saved()` - Post yang disimpan oleh user (protected)
- `post()` - Form tambah post (protected)
- `postEdit($id)` - Form edit post (protected)
- `EditProfile()` - Form edit profil (protected)
- `dashboard()` - Dashboard user (protected)
- `settings()` - Halaman pengaturan (protected)
- `inbox()` - Notifikasi inbox (protected)
- `inboxDetail($id)` - Detail notifikasi (protected)

#### **AuthController**
Controller untuk autentikasi Google OAuth.
- `redirectToGoogle()` - Redirect ke Google login
- `handlerGoogleCallback()` - Handle callback dari Google

#### **UserController**
Controller untuk CRUD operasi user.
- `index()` - Login/attempt autentikasi
- `create()` - Register user baru
- `logout()` - Logout user
- `update()` - Update profil user
- `giveAccess($id)` - Memberikan akses/role ke user
- `deleteAccess($id)` - Menghapus akses/role user

#### **PostController**
Controller untuk CRUD post.
- `store()` - Membuat post baru
- `update()` - Update post
- `destroy()` - Hapus post

#### **CommentController**
Controller untuk CRUD komentar.
- `store()` - Membuat komentar baru
- `destroy()` - Hapus komentar

#### **ReactionController**
Controller untuk reaksi pada post/comment.
- `store()` - Tambah reaksi
- `destroy()` - Hapus reaksi

#### **ReportController**
Controller untuk laporan konten.
- `store()` - Buat laporan konten
- `index()` - List semua laporan (admin)

#### **AppealController**
Controller untuk appeal/banding laporan.
- `store()` - Buat appeal
- `update()` - Update status appeal (admin)

#### **AdminController**
Controller untuk fungsi admin.
- `dashboard()` - Dashboard admin dengan statistik
- `manageUsers()` - Kelola pengguna
- `manageReports()` - Kelola laporan
- `manageAppeals()` - Kelola appeals

#### **SettingController**
Controller untuk pengaturan user.
- `changePassword()` - Ubah password
- `updatePrivacy()` - Update pengaturan privasi
- `updateNotification()` - Update pengaturan notifikasi

#### **ForgotPasswordController**
Controller untuk reset password.
- `showLinkRequestForm()` - Tampil form input email
- `sendResetLinkEmail()` - Kirim link reset ke email
- `resetPassword($token)` - Tampil form buat password baru
- `resetPasswordAttempt()` - Proses ubah password

#### **VerificationController**
Controller untuk verifikasi email.
- `notice()` - Tampil halaman verifikasi email
- `verify($id, $hash)` - Verifikasi email dengan link
- `resend()` - Kirim ulang email verifikasi
- `changeEmail()` - Ubah email

---

### 3. **Jobs (Queue Jobs)**

#### **ProcessReportReward**
Job untuk memproses reward/insentif ketika laporan konten diterima.
- Menambah trust score reporter
- Mengurangi trust score pembuat konten
- Membuat log perubahan trust score
- Trigger suspensi jika trust score terlalu rendah

---

### 4. **Notifications (Email Notifications)**

#### **AppealsResult**
Notifikasi hasil keputusan appeal.
- Dikirim ketika admin memutuskan appeal
- Berisi hasil dan alasan keputusan

#### **GetSuspend**
Notifikasi suspensi akun.
- Dikirim ketika akun pengguna disuspensi
- Berisi alasan dan durasi suspensi

#### **QueuedResetPassword**
Notifikasi reset password.
- Dikirim link reset password ke email pengguna
- Berisi token dan instruksi

#### **QueuedVerifyEmail**
Notifikasi verifikasi email.
- Dikirim link verifikasi email ke email pengguna baru
- Berisi token verifikasi

#### **ReactionNotification**
Notifikasi reaksi pada post/comment.
- Dikirim ketika ada reaksi terhadap post/comment user
- Berisi info siapa yang bereaksi dan konten apa

---

### 5. **Middleware**

#### **auth.alert**
Middleware custom untuk proteksi route yang memerlukan autentikasi.
- Cek apakah user sudah login
- Cek apakah email user sudah verified
- Cek apakah akun user suspended

---

### 6. **Routes (Web Routes)**

#### **Public Routes (Tanpa Autentikasi)**
```
GET  /                          - Halaman beranda
GET  /login                     - Form login
GET  /register                  - Form register
POST /login                     - Attempt login
POST /register                  - Attempt register
GET  /forgotPassword            - Form forgot password
POST /forgotPassword            - Send reset link
GET  /reset-password/{token}    - Form reset password
POST /reset-password            - Update password
GET  /search                    - Pencarian post
GET  /newest                    - Post terbaru
GET  /post/detail/{id}          - Detail post
GET  /user/profile/{username}   - Profil pengguna
GET  /tags                      - List tags
GET  /tags/{slug}               - Post dengan tag
GET  /auth/google               - Google OAuth
GET  /auth/google/callback      - Google callback
```

#### **Protected Routes (Memerlukan Autentikasi)**
```
GET  /saved                     - Post tersimpan
GET  /post/add                  - Form tambah post
GET  /post/edit/{id}            - Form edit post
POST /post/save                 - Simpan post
POST /post/update               - Update post
POST /post/delete               - Hapus post

GET  /user/edit                 - Form edit profil
POST /profile/update            - Update profil
POST /give-access/{id}          - Berikan akses
POST /delete-access/{id}        - Hapus akses

POST /comment/save              - Tambah komentar
POST /comment/delete            - Hapus komentar

GET  /dashboard                 - Dashboard user

GET  /settings                  - Pengaturan
POST /settings/changePassword   - Ubah password

GET  /inbox                     - Notifikasi
GET  /inbox/{id}                - Detail notifikasi

GET  /email/verify              - Halaman verifikasi
GET  /email/verify/{id}/{hash}  - Verifikasi email
POST /email/verify/resend       - Kirim ulang verifikasi
POST /email/verify/change       - Ubah email
```

#### **Admin Routes**
```
GET  /admin/dashboard           - Dashboard admin
GET  /admin/users               - Kelola pengguna
GET  /admin/reports             - Kelola laporan
GET  /admin/appeals             - Kelola appeals
POST /admin/reports/{id}/accept - Terima laporan
POST /admin/reports/{id}/reject - Tolak laporan
```

---

### 7. **Database Features**

#### **Migrations**
- `create_sessions_table` - Sesi pengguna
- `create_users_table` - Data pengguna
- `create_user_details_table` - Detail profil
- `create_posts_table` - Post/diskusi
- `create_comments_table` - Komentar
- `create_tags_table` - Tag/kategori
- `create_post_tags_table` - Relasi post-tag
- `create_reactions_table` - Reaksi
- `create_reports_table` - Laporan konten
- `create_appeals_table` - Appeal laporan
- `create_saved_table` - Post tersimpan
- `create_user_settings_table` - Pengaturan user
- `create_trust_score_logs_table` - Log trust score
- `create_remember_mes_table` - Remember me tokens

#### **Factories**
- `UserFactory` - Generate dummy user untuk testing

#### **Seeders**
- `CommentSeeder` - Seed komentar dummy

---

### 8. **Configuration Files**

#### **config/app.php**
- Konfigurasi aplikasi Laravel (timezone, locale, dll)

#### **config/auth.php**
- Konfigurasi authentication guards dan providers

#### **config/database.php**
- Konfigurasi koneksi database

#### **config/filesystems.php**
- Konfigurasi storage disk untuk upload file

#### **config/mail.php**
- Konfigurasi email driver (SMTP, Mailgun, dll)

#### **config/queue.php**
- Konfigurasi queue driver untuk background jobs

#### **config/session.php**
- Konfigurasi session lifetime dan behavior

#### **config/permission.php**
- Konfigurasi Spatie Permission (role & permission)

#### **config/services.php**
- Konfigurasi third-party services (Google, dll)

---

## 🚀 Environment Variables

Buat file `.env` dengan variabel berikut:

```env
APP_NAME=Discussion
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=discussion
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=587
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_FROM_ADDRESS=noreply@discussion.local
MAIL_FROM_NAME=Discussion

GOOGLE_CLIENT_ID=your_google_client_id
GOOGLE_CLIENT_SECRET=your_google_client_secret
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback

QUEUE_CONNECTION=database
SESSION_DRIVER=cookie
```

---

## 🧪 Testing

Jalankan test dengan Pest PHP:

```bash
# Jalankan semua test
php artisan pest

# Jalankan test spesifik
php artisan pest tests/Feature/AuthTest.php

# Jalankan dengan coverage
php artisan pest --coverage

# Format code dengan Pint
./vendor/bin/pint
```

---

## 📝 Development Commands

```bash
# Tinker - Interactive shell
php artisan tinker

# Generate model dengan migration
php artisan make:model Post -m

# Generate controller
php artisan make:controller PostController --resource

# Publish vendor assets
php artisan vendor:publish

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Queue listener untuk background jobs
php artisan queue:listen
```

---

## 🤝 Kontribusi

1. Fork repository ini
2. Buat branch fitur (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

---


## 👨‍💻 Author

Created with ❤️ for Discussion Platform

---

**Last Updated:** February 2, 2026
