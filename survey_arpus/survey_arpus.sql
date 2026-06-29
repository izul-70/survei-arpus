-- ======================================================
-- DATABASE SURVEY KEPUASAN MASYARAKAT
-- DINAS ARPUS KABUPATEN PEKALONGAN
-- ======================================================

-- ======================================================
-- 1. TABEL SURVEY_RESPONSES (Tempat semua data survey)
-- ======================================================
DROP TABLE IF EXISTS survey_responses;
CREATE TABLE survey_responses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    jenis_kelamin ENUM('L','P') NOT NULL,
    usia VARCHAR(20) NOT NULL,
    wa VARCHAR(20) NOT NULL,
    pendidikan VARCHAR(50) NOT NULL,
    pekerjaan VARCHAR(50) NOT NULL,
    kecamatan VARCHAR(50) NOT NULL,
    layanan VARCHAR(100) NOT NULL,
    tahun INT NOT NULL,
    q1 INT NOT NULL,
    q2 INT NOT NULL,
    q3 INT NOT NULL,
    q4 INT NOT NULL,
    q5 INT NOT NULL,
    q6 INT NOT NULL,
    q7 INT NOT NULL,
    q8 INT NOT NULL,
    q9 INT NOT NULL,
    saran TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    -- Index untuk mempercepat pencarian
    INDEX idx_tahun (tahun),
    INDEX idx_kecamatan (kecamatan),
    INDEX idx_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ======================================================
-- 2. TABEL ADMIN_USERS (Untuk login admin)
-- ======================================================
DROP TABLE IF EXISTS admin_users;
CREATE TABLE admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ======================================================
-- 3. DATA ADMIN DEFAULT
-- Username: admin
-- Password: admin123
-- ======================================================
INSERT INTO admin_users (username, password_hash) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- ======================================================
-- 4. DATA CONTOH SURVEY (Untuk testing)
-- ======================================================

-- Data tahun 2023
INSERT INTO survey_responses (nama, jenis_kelamin, usia, wa, pendidikan, pekerjaan, kecamatan, layanan, tahun, q1, q2, q3, q4, q5, q6, q7, q8, q9, saran) VALUES
('Responden 2023', 'L', '30-39', '08123456789', 'S1', 'Swasta', 'Kajen', 'Informasi Arsip', 2023, 75, 80, 70, 85, 75, 80, 85, 70, 75, 'Data contoh tahun 2023');

-- Data tahun 2024
INSERT INTO survey_responses (nama, jenis_kelamin, usia, wa, pendidikan, pekerjaan, kecamatan, layanan, tahun, q1, q2, q3, q4, q5, q6, q7, q8, q9, saran) VALUES
('Responden 2024 A', 'P', '20-29', '08123456780', 'SMA', 'Mahasiswa', 'Kedungwuni', 'Layanan Umum Perpustakaan', 2024, 85, 90, 80, 88, 85, 90, 92, 80, 85, 'Pelayanan sudah baik'),
('Responden 2024 B', 'L', '40-49', '08123456781', 'S2', 'PNS', 'Wiradesa', 'Konsultasi Kearsipan', 2024, 70, 75, 65, 80, 70, 75, 80, 65, 70, 'Saran untuk perbaikan'),
('Responden 2024 C', 'P', '30-39', '08123456782', 'S1', 'Guru', 'Bojong', 'Peminjaman Arsip', 2024, 90, 85, 88, 92, 85, 90, 95, 88, 85, 'Sangat memuaskan');

-- Data tahun 2025
INSERT INTO survey_responses (nama, jenis_kelamin, usia, wa, pendidikan, pekerjaan, kecamatan, layanan, tahun, q1, q2, q3, q4, q5, q6, q7, q8, q9, saran) VALUES
('Responden 2025 A', 'L', '25-35', '08123456783', 'S1', 'Karyawan', 'Sragi', 'Informasi Arsip', 2025, 88, 85, 82, 90, 86, 88, 90, 85, 88, 'Layanan sudah meningkat'),
('Responden 2025 B', 'P', '30-40', '08123456784', 'S2', 'Dosen', 'Kesesi', 'Konsultasi Kearsipan', 2025, 92, 90, 88, 95, 90, 92, 94, 89, 91, 'Sangat baik, pertahankan'),
('Responden 2025 C', 'L', '20-30', '08123456785', 'SMA', 'Mahasiswa', 'Wonopringgo', 'Peminjaman Arsip', 2025, 78, 82, 75, 85, 80, 78, 85, 80, 82, 'Cukup baik'),
('Responden 2025 D', 'P', '35-45', '08123456786', 'D3', 'Wiraswasta', 'Buaran', 'Layanan Umum Perpustakaan', 2025, 85, 88, 80, 90, 85, 87, 90, 84, 86, 'Perbaiki fasilitas');