<?php
require_once 'header.php';
require_once 'config/database.php';

// Ambil daftar tahun yang tersedia di database
$tahun_list = $pdo->query("SELECT DISTINCT tahun FROM survey_responses ORDER BY tahun DESC")->fetchAll();

// Jika tidak ada data, tampilkan tahun berjalan
if(empty($tahun_list)) {
    $tahun_list = [['tahun' => date('Y')]];
}

// Tahun yang dipilih (default: tahun terbaru)
$tahun_terpilih = isset($_GET['tahun']) ? (int)$_GET['tahun'] : $tahun_list[0]['tahun'];

// Ambil data rata-rata skor berdasarkan tahun yang dipilih
$stmt = $pdo->prepare("SELECT AVG((q1+q2+q3+q4+q5+q6+q7+q8+q9)/9) as rata_skor, COUNT(*) as jumlah FROM survey_responses WHERE tahun = :tahun");
$stmt->execute([':tahun' => $tahun_terpilih]);
$result = $stmt->fetch();
$rata_skor = $result['rata_skor'] ? round($result['rata_skor'], 2) : 0;

// Tentukan predikat dan warna
if($rata_skor >= 88.31) {
    $predikat = "SANGAT BAIK";
    $warna = "#28a745";
    $ikon = "🌟";
} elseif($rata_skor >= 76.61) {
    $predikat = "BAIK";
    $warna = "#17a2b8";
    $ikon = "😊";
} elseif($rata_skor >= 50) {
    $predikat = "CUKUP";
    $warna = "#ffc107";
    $ikon = "😐";
} else {
    $predikat = "KURANG";
    $warna = "#dc3545";
    $ikon = "😔";
}
?>

<div id="p1" class="step active">
    <!-- DASHBOARD ATAS (WELCOME SPLIT) -->
    <div class="welcome-split">
        <div class="welcome-img">
            <img src="images/gambar.png" alt="Library Illustration">
        </div>
        <div class="welcome-text">
            <h2 style="font-size: 42px; color: var(--biru); margin-bottom: 15px;">Survei Kepuasan Masyarakat</h2>
            <p style="font-size: 19px; color: #666; margin-bottom: 35px;">Wujudkan pelayanan publik yang lebih baik bersama<br> Dinas Kearsipan dan Perpustakaan Kabupaten Pekalongan.</p>
            <div class="btn-group" style="justify-content: flex-start;">
                <a href="biodata.php" class="btn">📝 MULAI SURVEI</a>
            </div>
            <div class="extra-logos">
                <img src="images/bangga.png" alt="Logo 1">  
                <img src="images/berakhlaq.png" alt="Logo 2"> 
            </div>
        </div>
    </div>

    <!-- GARIS PEMISAH 1 -->
    <div style="border-top: 2px dashed #ccc; margin: 50px 0 30px 0;"></div>

    <!-- INDEKS KEPUASAN MASYARAKAT -->
    <div style="text-align: center;">
        <h3 style="color: var(--biru); font-size: 24px; margin-bottom: 15px; font-weight: 600;">
            📊 INDEKS KEPUASAN MASYARAKAT
        </h3>
        
        <!-- FILTER TAHUN -->
        <div style="margin-bottom: 25px;">
            <label style="font-weight: 600; margin-right: 10px; color: #555;">Pilih Tahun:</label>
            <select id="filterTahun" onchange="window.location.href='?tahun='+this.value" style="padding: 10px 25px; border-radius: 30px; border: 1px solid #ccc; font-size: 14px; background: white; cursor: pointer;">
                <?php foreach($tahun_list as $t): ?>
                    <option value="<?php echo $t['tahun']; ?>" <?php echo $tahun_terpilih == $t['tahun'] ? 'selected' : ''; ?>>
                        📅 Tahun <?php echo $t['tahun']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <!-- KOTAK INDEKS (Tanpa jumlah responden) -->
        <div style="display: inline-block; background: <?php echo $warna; ?>; color: white; padding: 35px 70px; border-radius: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); min-width: 320px;">
            <div style="font-size: 56px; font-weight: 800;"><?php echo $rata_skor; ?>%</div>
            <div style="font-size: 22px; font-weight: 600; margin-top: 15px; padding-top: 12px; border-top: 2px solid rgba(255,255,255,0.3);">
                <?php echo $ikon; ?> <?php echo $predikat; ?>
            </div>
        </div>
    </div>

    <!-- GARIS PEMISAH 2 -->
    <div style="border-top: 2px dashed #ccc; margin: 50px 0 40px 0;"></div>

    <!-- SECTION LAPORAN PDF SLIDER -->
    <div id="section-laporan" style="width: 100%;">
        <h2 style="text-align:center; color: var(--biru); font-weight: 700; margin-bottom: 30px; font-size: 26px;">
            📄 LAPORAN SKM TAHUNAN
        </h2>

        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                <!-- Tahun 2018 -->
                <div class="swiper-slide">
                    <div class="skm-card">
                        <img src="images/dinas.png" style="width: 55px; margin-bottom: 12px;">
                        <h3>SKM 2018</h3>
                        <p style="font-size: 11px; color: #666;">Laporan Tahunan</p>
                        <a href="https://drive.google.com/file/d/1DcBeUgZFVUlDktsgkEthfhKNEYYOHpIo/view" target="_blank" class="btn-pdf">Lihat Laporan →</a>
                    </div>
                </div>
                <!-- Tahun 2019 -->
                <div class="swiper-slide">
                    <div class="skm-card">
                        <img src="images/dinas.png" style="width: 55px; margin-bottom: 12px;">
                        <h3>SKM 2019</h3>
                        <p style="font-size: 11px; color: #666;">Laporan Tahunan</p>
                        <a href="https://drive.google.com/file/d/1EB5QSL_z-7LnByrJSHzC6ZrSfcG0U7cl/view" target="_blank" class="btn-pdf">Lihat Laporan →</a>
                    </div>
                </div>
                <!-- Tahun 2020 -->
                <div class="swiper-slide">
                    <div class="skm-card">
                        <img src="images/dinas.png" style="width: 55px; margin-bottom: 12px;">
                        <h3>SKM 2020</h3>
                        <p style="font-size: 11px; color: #666;">Laporan Tahunan</p>
                        <a href="https://drive.google.com/file/d/1orGrL5DoD95U-GKkGH0fyYBSRTmhiuQo/view" target="_blank" class="btn-pdf">Lihat Laporan →</a>
                    </div>
                </div>
                <!-- Tahun 2021 -->
                <div class="swiper-slide">
                    <div class="skm-card">
                        <img src="images/dinas.png" style="width: 55px; margin-bottom: 12px;">
                        <h3>SKM 2021</h3>
                        <p style="font-size: 11px; color: #666;">Laporan Tahunan</p>
                        <a href="https://drive.google.com/file/d/1iacGphsFtFHfK-j1BM9i2Rw2JMeZd4xd/view" target="_blank" class="btn-pdf">Lihat Laporan →</a>
                    </div>
                </div>
                <!-- Tahun 2022 -->
                <div class="swiper-slide">
                    <div class="skm-card">
                        <img src="images/dinas.png" style="width: 55px; margin-bottom: 12px;">
                        <h3>SKM 2022</h3>
                        <p style="font-size: 11px; color: #666;">Laporan Tahunan</p>
                        <a href="https://drive.google.com/file/d/111uSekZNfCz3M6AhoarU9kqRSJXZb3G3/view" target="_blank" class="btn-pdf">Lihat Laporan →</a>
                    </div>
                </div>
                <!-- Tahun 2023 -->
                <div class="swiper-slide">
                    <div class="skm-card">
                        <img src="images/dinas.png" style="width: 55px; margin-bottom: 12px;">
                        <h3>SKM 2023</h3>
                        <p style="font-size: 11px; color: #666;">Laporan Tahunan</p>
                        <a href="https://drive.google.com/file/d/1iacGphsFtFHfK-j1BM9i2Rw2JMeZd4xd/view" target="_blank" class="btn-pdf">Lihat Laporan →</a>
                    </div>
                </div>
                <!-- Tahun 2024 -->
                <div class="swiper-slide">
                    <div class="skm-card">
                        <img src="images/dinas.png" style="width: 55px; margin-bottom: 12px;">
                        <h3>SKM 2024</h3>
                        <p style="font-size: 11px; color: #666;">Laporan Tahunan</p>
                        <a href="https://drive.google.com/file/d/19x7DGrcDcFn34jn-A50KnD7avNHMtusG/view" target="_blank" class="btn-pdf">Lihat Laporan →</a>
                    </div>
                </div>
                <!-- Tahun 2025 -->
                <div class="swiper-slide">
                    <div class="skm-card">
                        <img src="images/dinas.png" style="width: 55px; margin-bottom: 12px;">
                        <h3>SKM 2025</h3>
                        <p style="font-size: 11px; color: #666;">Laporan Tahunan</p>
                        <a href="https://drive.google.com/file/d/1rTebrhEmeMky2N5YqViFUxXC_ZVnMKDI/view" target="_blank" class="btn-pdf">Lihat Laporan →</a>
                    </div>
                </div>
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>
</div>

<style>
    .skm-card {
        background: white;
        border-radius: 15px;
        padding: 20px 12px;
        text-align: center;
        max-width: 200px;
        margin: 0 auto;
        box-shadow: 0 8px 20px rgba(0,0,0,0.08);
        border: 1px solid #eee;
        transition: all 0.3s ease;
    }
    .skm-card:hover { transform: translateY(-8px); }
    .skm-card h3 { font-size: 18px; margin: 10px 0 5px; color: #003d7a; }
    .btn-pdf { background: #003d7a; color: white; padding: 8px 18px; border-radius: 30px; font-size: 12px; text-decoration: none; display: inline-block; }
    .btn-pdf:hover { background: #007bff; }
    .swiper { padding: 20px 50px !important; }
    .swiper-button-next, .swiper-button-prev { background: white; width: 40px; height: 40px; border-radius: 50%; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
    .welcome-split { display: flex; align-items: center; gap: 50px; flex-wrap: wrap; }
    .welcome-img { flex: 1; text-align: center; }
    .welcome-img img { width: 70%; max-width: 400px; border-radius: 15px; }
    .welcome-text { flex: 1; }
    .btn-group { display: flex; justify-content: flex-start; gap: 15px; margin-top: 40px; }
    .btn { background: #007bff; color: white; padding: 16px 40px; border-radius: 50px; text-decoration: none; font-weight: bold; }
    .btn:hover { background: #003d7a; transform: translateY(-3px); }
    .extra-logos { margin-top: 40px; display: flex; gap: 40px; align-items: center; }
    .extra-logos img { height: 90px; }
    @media (max-width: 768px) {
        .welcome-split { flex-direction: column; text-align: center; }
        .btn-group { justify-content: center; }
        .extra-logos { justify-content: center; }
        .extra-logos img { height: 60px; }
        .btn { width: 100%; padding: 14px; text-align: center; }
        .skm-card { max-width: 160px; padding: 15px 8px; }
        .skm-card h3 { font-size: 14px; }
        .swiper { padding: 20px 30px !important; }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    var swiper = new Swiper(".mySwiper", {
        slidesPerView: 1, spaceBetween: 15, loop: true, autoplay: { delay: 2500, disableOnInteraction: false },
        navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" },
        pagination: { el: ".swiper-pagination", clickable: true },
        breakpoints: { 0: { slidesPerView: 2 }, 640: { slidesPerView: 3 }, 768: { slidesPerView: 4 }, 1024: { slidesPerView: 5 } }
    });
</script>

<?php require_once 'footer.php'; ?>