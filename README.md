NAMA  : IZUL KHAEROH
NIM   : 101230070
KELAS : TF23C
# Survey Kepuasan Masyarakat - Dinas Kearsipan dan Perpustakaan Kabupaten Pekalongan

Aplikasi survei kepuasan masyarakat (SKM) berbasis web untuk mengukur kepuasan pengguna layanan publik di lingkungan Dinas Kearsipan dan Perpustakaan Kabupaten Pekalongan.

## 📋 Tech Stack / Stack yang Digunakan

### Backend
- **PHP 8.x** - Logika server-side dan proses bisnis
- **PDO (PHP Data Objects)** - Koneksi database yang aman dan fleksibel
- **MySQL/MariaDB** - Database utama penyimpanan data survei
- **Prepared Statements** - Perlindungan dari SQL injection
- **PHP Sessions** - Manajemen sesi login admin dan alur survei

### Frontend
- **HTML5** - Struktur halaman
- **CSS3** - Styling dan desain responsif
- **Vanilla JavaScript (ES6+)** - Interaksi halaman tanpa framework
- **Swiper.js v11** - Slider/carousel laporan SKM
- **CSS Variables** - Variabel desain seperti warna utama dan elemen visual

### Database
- **MySQL/MariaDB** - Database relasional utama
- **Tabel utama:** `survey_responses` - menyimpan biodata, jawaban 9 pertanyaan, saran, rata-rata, predikat, dan metadata survey

### Tools & Environment
- **XAMPP** - Local development (Apache + MySQL + PHP)
- **Git** - Version control
- **GitHub** - Hosting repository dan kolaborasi

---

## 📦 Modul & Fitur Utama

### 1. Frontend Publik
- **Landing Page** (`index.php`) - Menampilkan indeks kepuasan masyarakat (IKM), filter tahun, dan slider laporan SKM tahunan
- **Biodata** (`biodata.php`) - Form input biodata responden seperti nama, jenis kelamin, usia, nomor WA, pendidikan, pekerjaan, kecamatan, dan jenis layanan
- **Kuesioner** (`kuesioner.php`) - Survei 9 pertanyaan dengan UI emoji rating dan kolom saran
- **Thank You** (`thanks.php`) - Halaman penutup setelah survei selesai

### 2. Panel Admin
- **Login** (`admin/login.php`) - Autentikasi admin berbasis session
- **Dashboard** (`admin/index.php`) - Menampilkan statistik per tahun, analisis skor per pertanyaan, filter tahun/kecamatan, pencarian nama/nomor WA, pagination, dan export Excel
- **Export Excel** (`admin/export_excel.php`) - Ekspor data hasil survei ke file Excel
- **Delete Data** (`admin/delete.php`) - Hapus data responden per baris
- **Logout** (`admin/logout.php`) - Mengakhiri sesi admin

### 3. Backend Processing
- **`proses_biodata.php`** - Validasi dan simpan data biodata ke session sebelum masuk ke kuesioner
- **`proses_survey.php`** - Validasi jawaban wajib, hitung rata-rata, simpan ke database, lalu redirect ke halaman terima kasih
- **`config/database.php`** - Koneksi PDO ke database MySQL dan pengaturan session

### 4. Shared Components
- **`header.php`** - Bagian header, meta tag, navigasi, dan desain global
- **`footer.php`** - Penutup halaman dan elemen footer
- **`buat_admin.php`** - Script setup admin default untuk keperluan development

---

## 🗄 Database Schema

```sql
CREATE TABLE survey_responses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100),
    jenis_kelamin ENUM('L','P'),
    umur VARCHAR(20),
    wa VARCHAR(20),
    pendidikan VARCHAR(50),
    pekerjaan VARCHAR(100),
    kecamatan VARCHAR(50),
    jenis_layanan VARCHAR(100),
    tahun YEAR,
    q1 INT, q2 INT, q3 INT, q4 INT, q5 INT, q6 INT, q6 INT, q8 INT, q9 INT,
    saran TEXT,
    rata_rata DECIMAL(5,2),
    predikat VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

**Predikat IKM:**
- **SANGAT BAIK** (≥ 88.31%) - 🟢 Hijau
- **BAIK** (76.61% - 88.30%) - 🔵 Biru
- **CUKUP** (50% - 76.60%) - 🟡 Kuning
- **KURANG** (< 50%) - 🔴 Merah

---

## 🚀 Deployment & Workflow

### Local Development (XAMPP)
1. Start Apache & MySQL di XAMPP
2. Import `survey_arpus.sql` ke database `survey_arpus`
3. Akses `http://localhost/survey_arpus/`
4. Admin: `http://localhost/survey_arpus/admin/login.php`
   - Default: `admin` / `admin123` (lihat `buat_admin.php`)

### GitHub Deployment Workflow
1. **Local Development** → Test di localhost
2. **Commit & Push** → `git commit -m "msg" && git push origin main`
3. **GitHub Actions (CI/CD)** → Auto-test di GitHub
4. **Deploy** → Deploy ke hosting/production

### Pre-commit Checklist
- [ ] Test di localhost (semua fitur: survei, admin, export, delete)
- [ ] No console errors (JS/CSS)
- [ ] Database migration OK (import SQL)
- [ ] Semua role: Responden, Admin
- [ ] UI/UX konsisten (responsive mobile/desktop)
- [ ] No hardcoded localhost URLs

---

## 📁 Project Structure

```
survey_arpus/
├── index.php              # Landing page publik (IKM + Slider SKM)
├── biodata.php            # Form biodata responden
├── kuesioner.php          # Form survei 9 pertanyaan (emoji rating)
├── thanks.php             # Thank you page
├── proses_biodata.php     # Proses simpan biodata ke session
├── proses_survey.php      # Proses simpan survei ke DB
├── laporan.php            # (Legacy) Laporan PDF
├── konfig.php             # Config DB + session (root)
├── header.php             # Shared header
├── footer.php             # Shared footer
├── buat_admin.php         # Setup admin default
├── survey_arpus.sql       # Schema + seed data
├── tambah_data_2023_2025.sql # Data seed tambahan
├── config/
│   └── database.php       # PDO connection config
├── admin/
│   ├── index.php          # Dashboard admin
│   ├── login.php          # Login admin
│   ├── logout.php         # Logout
│   ├── export_excel.php   # Export Excel
│   └── delete.php         # Hapus data
└── images/
    ├── gambar.png         # Ilustrasi landing
    ├── dinas.png          # Logo dinas
    ├── bangga.png         # Logo bangga
    └── berakhlaq.png      # Logo berakhlaq
```

---

## 🔐 Default Admin Credentials
| Field | Value |
|-------|-------|
| Username | `admin` |
| Password | `admin123` |

> **⚠️ Security Note:** Ganti password default di production! Edit `buat_admin.php` atau update manual di database.

---

## 📊 Survey Questions (9 Pertanyaan SKM)

1. Kesesuaian persyaratan pelayanan
2. Kemudahan prosedur layanan
3. Kecepatan waktu pelayanan
4. Kewajaran biaya/tarif
5. Kesesuaian produk pelayanan
6. Kompetensi petugas
7. Perilaku petugas (sopan santun)
8. Kualitas sarana prasarana
9. Penanganan pengaduan

**Skoring:** 100 (Sangat Baik/Sesuai) → 75 → 50 → 25 (Tidak Baik/Tidak Sesuai)

---

## 📄 License
Proyek internal Dinas Kearsipan dan Perpustakaan Kabupaten Pekalongan.

---

## ✅ GitHub Task Checklist (Checklist di GitHub)

> **Cara pakai:** Centang kotak `[ ]` → `[x]` langsung di GitHub UI (README.md di repo GitHub).
> Gunakan untuk tracking progress development, testing, dan deployment.

### 🔧 Setup & Configuration
- [ ] Clone repository ke lokal
- [ ] Start XAMPP (Apache + MySQL)
- [ ] Create database `survey_arpus` di phpMyAdmin
- [ ] Import `survey_arpus.sql` (schema + seed data)
- [ ] Import `tambah_data_2023_2025.sql` (data tambahan)
- [ ] Jalankan `buat_admin.php` sekali untuk create admin user
- [ ] Verify akses `http://localhost/survey_arpus/`
- [ ] Verify akses admin `http://localhost/survey_arpus/admin/login.php` (admin/admin123)

### 🎯 Public Frontend Testing
#### Landing Page (`index.php`)
- [ ] Load halaman tanpa error
- [ ] Tampil IKM (Indeks Kepuasan Masyarakat) dengan skor & predikat
- [ ] Filter tahun dropdown berfungsi
- [ ] Slider laporan SKM (Swiper.js) berjalan (autoplay, nav, pagination)
- [ ] Link laporan PDF ke Google Drive terbuka di tab baru
- [ ] Tombol "MULAI SURVEI" redirect ke `biodata.php`
- [ ] Responsive di mobile (≤768px) & desktop
- [ ] Logo & gambar tampil (gambar.png, dinas.png, bangga.png, berakhlaq.png)

#### Biodata (`biodata.php`)
- [ ] Form tampil lengkap (nama, JK, usia, WA, pendidikan, pekerjaan, kecamatan, layanan)
- [ ] Validasi client-side (required fields)
- [ ] Submit redirect ke `kuesioner.php`
- [ ] Data tersimpan di `$_SESSION['biodata']`
- [ ] Responsive mobile/desktop

#### Kuesioner (`kuesioner.php`)
- [ ] Redirect dari biodata berfungsi
- [ ] 9 pertanyaan tampil berurutan (step-by-step)
- [ ] Emoji rating 4 level per pertanyaan (100, 75, 50, 25)
- [ ] Seleksi emoji update hidden input & visual feedback (selected)
- [ ] Validasi: harus pilih emoji sebelum "SELANJUTNYA"
- [ ] Navigasi Next/Back berfungsi
- [ ] Step 10: Saran (textarea optional)
- [ ] Submit "SIMPAN JAWABAN" → `proses_survey.php`
- [ ] Responsive mobile/desktop

#### Proses Survey (`proses_survey.php`)
- [ ] Validasi 9 pertanyaan wajib terisi
- [ ] Hitung rata-rata skor (q1-q9 / 9)
- [ ] Tentukan predikat (SANGAT BAIK/BAIK/CUKUP/KURANG)
- [ ] Insert ke `survey_responses` (biodata + q1-q9 + saran + tahun + rata + predikat)
- [ ] Redirect ke `thanks.php`
- [ ] Session biodata dihapus setelah submit

#### Thank You (`thanks.php`)
- [ ] Tampil pesan terima kasih
- [ ] Link "Kembali ke Beranda" berfungsi

### 🔐 Admin Panel Testing
#### Login (`admin/login.php`)
- [ ] Form login tampil
- [ ] Validasi username/password
- [ ] Login berhasil → redirect ke `admin/index.php` + set `$_SESSION['admin_logged']`
- [ ] Login gagal → tampil error
- [ ] Session protection: akses `admin/index.php` tanpa login → redirect ke login

#### Dashboard (`admin/index.php`)
- [ ] Sidebar navigasi (Semua Data, Logout)
- [ ] Header dengan logout button
- [ ] Statistik card per tahun (rata-rata %, jumlah responden, warna predikat)
- [ ] Analisis skor per pertanyaan (Q1-Q9 dengan color coding: hijau/kuning/merah)
- [ ] Filter: Tahun dropdown, Kecamatan dropdown, Search nama/WA
- [ ] Tombol Filter & Reset berfungsi
- [ ] Tabel data: pagination (20/halaman), sorting by created_at DESC
- [ ] Kolom: No, Nama, JK, Usia, Kecamatan, Layanan, Tahun, Q1-Q9, Skor, Predikat (badge), Saran, Aksi
- [ ] Badge predikat warna: hijau (SANGAT BAIK), biru (BAIK), kuning (KURANG BAIK)
- [ ] Tombol Hapus per baris → konfirmasi → `delete.php`
- [ ] Export Excel → `export_excel.php` (dengan filter yg sama)
- [ ] Pagination berfungsi (next, prev, page number)
- [ ] Responsive mobile (sidebar collapse, horizontal scroll tabel)

#### Export Excel (`admin/export_excel.php`)
- [ ] Download file .xls/.xlsx
- [ ] Data sesuai filter (tahun, kecamatan, search)
- [ ] Header kolom lengkap
- [ ] Encoding UTF-8 (karakter Indonesia benar)

#### Delete (`admin/delete.php`)
- [ ] Hapus data by ID
- [ ] Redirect kembali ke `index.php` dengan page & filter params
- [ ] Success message tampil

#### Logout (`admin/logout.php`)
- [ ] Destroy session
- [ ] Redirect ke login.php
- [ ] Tidak bisa akses dashboard setelah logout

### 🗄 Database Verification
- [ ] Table `survey_responses` ter-create dengan index (tahun, kecamatan, created_at)
- [ ] Table `admin_users` ter-create dengan password hash
- [ ] Seed data 2023, 2024, 2025 ter-insert
- [ ] Insert manual via survei publik → data masuk DB benar
- [ ] Kolom `rata_rata` & `predikat` ter-hitung otomatis di `proses_survey.php`
- [ ] Foreign key / constraint tidak diperlukan (standalone table)

### 🔒 Security & Best Practices
- [ ] PDO Prepared Statements di semua query (no SQL injection)
- [ ] `htmlspecialchars()` di semua output user-generated
- [ ] Session_start() di semua file yang butuh session
- [ ] Admin session check di setiap file admin/
- [ ] Password admin di-hash (bcrypt via `buat_admin.php`)
- [ ] No hardcoded credentials di production code
- [ ] No `localhost` URL di production (relative paths only)
- [ ] Error handling: try-catch PDO, die() dengan pesan user-friendly

### 📱 UI/UX & Responsive
- [ ] CSS Variables (--biru, --hijau, dll) konsisten di semua halaman
- [ ] Mobile-first: ≤768px stack layout, touch-friendly
- [ ] Desktop: sidebar fixed, grid layout, hover effects
- [ ] Color coding predikat konsisten (hijau/biru/kuning/merah)
- [ ] Loading state / feedback pada aksi user
- [ ] Font size, spacing, contrast accessible
- [ ] Swiper.js slider touch/swipe di mobile
- [ ] Table horizontal scroll di mobile dengan container overflow-x

### 🧪 Cross-Browser Testing
- [ ] Chrome (latest)
- [ ] Firefox (latest)
- [ ] Edge (latest)
- [ ] Safari (jika tersedia)
- [ ] Mobile Chrome (Android)
- [ ] Mobile Safari (iOS)

### 🚀 Deployment Checklist
- [ ] Push ke GitHub (`git add . && git commit -m "msg" && git push`)
- [ ] GitHub Actions CI/CD pass (jika dikonfigurasi)
- [ ] Deploy ke hosting (shared hosting / VPS / cloud)
- [ ] Setup database di production
- [ ] Update config database.php untuk production credentials
- [ ] Ganti password admin default
- [ ] Setup HTTPS/SSL
- [ ] Test semua fitur di production URL
- [ ] Backup database & files berkala

### 📋 Documentation
- [ ] README.md up-to-date
- [ ] AGEN.md workflow dokumentasi
- [ ] Comment kode fungsi kompleks
- [ ] Changelog / version history

---

## 🔍 Compare & Sync Checklist (GitHub ↔ Local)

| Item | Local | GitHub | Status |
|------|-------|--------|--------|
| `index.php` | ☐ | ☐ | ☐ Synced |
| `biodata.php` | ☐ | ☐ | ☐ Synced |
| `kuesioner.php` | ☐ | ☐ | ☐ Synced |
| `thanks.php` | ☐ | ☐ | ☐ Synced |
| `proses_biodata.php` | ☐ | ☐ | ☐ Synced |
| `proses_survey.php` | ☐ | ☐ | ☐ Synced |
| `konfig.php` | ☐ | ☐ | ☐ Synced |
| `config/database.php` | ☐ | ☐ | ☐ Synced |
| `header.php` | ☐ | ☐ | ☐ Synced |
| `footer.php` | ☐ | ☐ | ☐ Synced |
| `buat_admin.php` | ☐ | ☐ | ☐ Synced |
| `survey_arpus.sql` | ☐ | ☐ | ☐ Synced |
| `tambah_data_2023_2025.sql` | ☐ | ☐ | ☐ Synced |
| `admin/index.php` | ☐ | ☐ | ☐ Synced |
| `admin/login.php` | ☐ | ☐ | ☐ Synced |
| `admin/logout.php` | ☐ | ☐ | ☐ Synced |
| `admin/export_excel.php` | ☐ | ☐ | ☐ Synced |
| `admin/delete.php` | ☐ | ☐ | ☐ Synced |
| `images/` (4 files) | ☐ | ☐ | ☐ Synced |
| `README.md` | ☐ | ☐ | ☐ Synced |
| `AGENT.md` | ☐ | ☐ | ☐ Synced |

> **Tip:** Gunakan `git status`, `git diff`, dan GitHub web UI (Compare & pull request) untuk verify sync.
