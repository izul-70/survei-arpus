-- =============================================
-- TAMBAH DATA SURVEY TAHUN 2023, 2024, 2025
-- Dinas ARPUS Kabupaten Pekalongan
-- =============================================

-- DATA TAHUN 2023
INSERT INTO survey_responses (nama, jenis_kelamin, usia, wa, pendidikan, pekerjaan, kecamatan, layanan, tahun, q1, q2, q3, q4, q5, q6, q7, q8, q9, saran) VALUES
('Responden 2023', 'L', '30-39', '08123456789', 'S1', 'Swasta', 'Kajen', 'Informasi Arsip', 2023, 75, 80, 70, 85, 75, 80, 85, 70, 75, 'Test data tahun 2023');

-- DATA TAHUN 2024
INSERT INTO survey_responses (nama, jenis_kelamin, usia, wa, pendidikan, pekerjaan, kecamatan, layanan, tahun, q1, q2, q3, q4, q5, q6, q7, q8, q9, saran) VALUES
('Responden 2024 A', 'P', '20-29', '08123456780', 'SMA', 'Mahasiswa', 'Kedungwuni', 'Layanan Umum Perpustakaan', 2024, 85, 90, 80, 88, 85, 90, 92, 80, 85, 'Pelayanan sudah baik'),
('Responden 2024 B', 'L', '40-49', '08123456781', 'S2', 'PNS', 'Wiradesa', 'Konsultasi Kearsipan', 2024, 70, 75, 65, 80, 70, 75, 80, 65, 70, 'Saran untuk perbaikan'),
('Responden 2024 C', 'P', '30-39', '08123456782', 'S1', 'Guru', 'Bojong', 'Peminjaman Arsip', 2024, 90, 85, 88, 92, 85, 90, 95, 88, 85, 'Sangat memuaskan');

-- DATA TAHUN 2025
INSERT INTO survey_responses (nama, jenis_kelamin, usia, wa, pendidikan, pekerjaan, kecamatan, layanan, tahun, q1, q2, q3, q4, q5, q6, q7, q8, q9, saran) VALUES
('Responden 2025 A', 'L', '25-35', '08123456783', 'S1', 'Karyawan', 'Sragi', 'Informasi Arsip', 2025, 88, 85, 82, 90, 86, 88, 90, 85, 88, 'Layanan sudah meningkat'),
('Responden 2025 B', 'P', '30-40', '08123456784', 'S2', 'Dosen', 'Kesesi', 'Konsultasi Kearsipan', 2025, 92, 90, 88, 95, 90, 92, 94, 89, 91, 'Sangat baik, pertahankan'),
('Responden 2025 C', 'L', '20-30', '08123456785', 'SMA', 'Mahasiswa', 'Wonopringgo', 'Peminjaman Arsip', 2025, 78, 82, 75, 85, 80, 78, 85, 80, 82, 'Cukup baik'),
('Responden 2025 D', 'P', '35-45', '08123456786', 'D3', 'Wiraswasta', 'Buaran', 'Layanan Umum Perpustakaan', 2025, 85, 88, 80, 90, 85, 87, 90, 84, 86, 'Perbaiki fasilitas');

-- CEK SEMUA DATA PER TAHUN
SELECT tahun, COUNT(*) as jumlah_responden FROM survey_responses GROUP BY tahun ORDER BY tahun DESC;