NAMA  : IZUL KHAEROH
NIM   : 101230070
KELAS : TF23C
# Survey Kepuasan Masyarakat - Dinas Kearsipan dan Perpustakaan Kabupaten Pekalongan

Aplikasi survei kepuasan masyarakat (SKM) untuk Dinas Kearsipan dan Perpustakaan Kabupaten Pekalongan.

## 📋 Tech Stack

### Backend
- **PHP 8.x** - Server-side scripting
- **PDO (PHP Data Objects)** - Database abstraction layer
- **MySQL/MariaDB** - Database relasional
- **PDO Prepared Statements** - Prepared statements untuk keamanan SQL injection
- **PHP Sessions** - Session management untuk autentikasi admin & session survei

### Frontend
- **HTML5** - Markup semantik
- **CSS3** - Custom CSS dengan CSS Variables (Custom Properties)
- **Vanilla JavaScript (ES6+)** - Vanilla JS tanpa framework
- **Swiper.js v11** - Slider/carousel untuk laporan SKM (via CDN)
- **CSS Variables** - Design system dengan custom properties (--biru, --hijau, dll)
- **Responsive Design** - Mobile-first responsive design dengan CSS Grid/Flexbox

### Database
- **MySQL/MariaDB** - Database utama
- **Table: survey_responses** - Menyimpan respons survei (9 pertanyaan + saran + biodata + metadata)

### Libraries & CDN
- **Swiper.js v11** (via jsDelivr CDN) - Touch slider untuk carousel laporan SKM
- **Google Fonts** (jika digunakan via CDN di header.php)

### Development Tools
- **XAMPP** - Local development environment (Apache + MySQL + PHP)
- **Git** - Version control
- **GitHub** - Remote repository hosting

---

## 📦 Modules & Features

### 1. **Public Frontend (Frontend Publik)**
| Modul | Fitur |
|-------|-------|
| **Landing Page** (`index.php`) | Dashboard publik dengan indeks kepuasan masyarakat (IKM), filter tahun, slider laporan SKM tahunan |
| **Biodata** (`biodata.php`) | Form pengisian biodata responden (nama, JK, umur, WA, pendidikan, pekerjaan, kecamatan, jenis layanan) |
| **Kuesioner** (`kuesioner.php`) | Survei 9 pertanyaan dengan UI emoji rating (4 level: Sangat Baik/Sesuai → Tidak Baik/Tidak Sesuai) + kolom saran |
| **Thank You** (`thanks.php`) | Halaman ucapan terima kasih setelah submit survei |

### 2. **Admin Panel** (`admin/`)
| Modul | Fitur |
|-------|-------|
| **Login** (`login.php`) | Autentikasi admin (session-based, hardcoded credentials) |
| **Dashboard** (`index.php`) | - Statistik per tahun (rata-rata skor, jumlah responden)<br>- Analisis kelemahan per pertanyaan (rata-rata per q1-q9)<br>- Filter: Tahun, Kecamatan, Pencarian nama/WA<br>- Pagination (20 per halaman)<br>- Export Excel |
| **Export Excel** (`export_excel.php`) | Export data survei ke Excel (filter sesuai dashboard) |
| **Delete Data** (`delete.php`) | Hapus data responden individual |
| **Logout** (`logout.php`) | Logout & destroy session |

### 3. **Backend Processing**
| File | Fungsi |
|------|--------|
| `proses_biodata.php` | Validasi & simpan biodata ke session, redirect ke kuesioner |
| `proses_survey.php` | Validasi 9 pertanyaan wajib + saran, hitung rata-rata, simpan ke DB, redirect ke thanks.php |
| `konfig.php` / `config/database.php` | Koneksi PDO ke MySQL + session_start() |

### 4. **Shared Components**
| File | Fungsi |
|------|--------|
| `header.php` | Header HTML, CSS variables, meta tags, navigation |
| `footer.php` | Footer HTML, closing tags |
| `buat_admin.php` | Script one-time setup untuk membuat user admin default |

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
