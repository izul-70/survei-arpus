<?php
session_start();
require_once __DIR__ . '/../config/database.php';

// Cek login
if(!isset($_SESSION['admin_logged']) || $_SESSION['admin_logged'] !== true) {
    header('Location: login.php');
    exit;
}

// Pesan sukses/error
$success_msg = isset($_GET['success']) ? htmlspecialchars($_GET['success']) : '';
$error_msg = isset($_GET['error']) ? htmlspecialchars($_GET['error']) : '';

// Pagination
$limit = 20;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Filter
$filter_tahun = isset($_GET['tahun']) ? $_GET['tahun'] : '';
$filter_kecamatan = isset($_GET['kecamatan']) ? $_GET['kecamatan'] : '';
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Build query
$where = [];
$params = [];

if($filter_tahun) {
    $where[] = "tahun = :tahun";
    $params[':tahun'] = $filter_tahun;
}
if($filter_kecamatan) {
    $where[] = "kecamatan = :kecamatan";
    $params[':kecamatan'] = $filter_kecamatan;
}
if($search) {
    $where[] = "(nama LIKE :search OR wa LIKE :search)";
    $params[':search'] = "%$search%";
}

$where_sql = !empty($where) ? "WHERE " . implode(" AND ", $where) : "";

// Hitung total data
$count_sql = "SELECT COUNT(*) as total FROM survey_responses $where_sql";
$stmt = $pdo->prepare($count_sql);
$stmt->execute($params);
$total_data = $stmt->fetch()['total'];
$total_pages = ceil($total_data / $limit);

// Ambil data
$sql = "SELECT * FROM survey_responses $where_sql ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$responses = $stmt->fetchAll();

// Statistik nilai rata-rata per pertanyaan (untuk analisis kelemahan)
$stats_q = $pdo->query("SELECT 
    AVG(q1) as avg_q1, AVG(q2) as avg_q2, AVG(q3) as avg_q3, AVG(q4) as avg_q4,
    AVG(q5) as avg_q5, AVG(q6) as avg_q6, AVG(q7) as avg_q7, AVG(q8) as avg_q8, AVG(q9) as avg_q9
    FROM survey_responses")->fetch();

// List tahun & kecamatan untuk filter
$tahun_list = $pdo->query("SELECT DISTINCT tahun FROM survey_responses ORDER BY tahun DESC")->fetchAll();
$kecamatan_list = $pdo->query("SELECT DISTINCT kecamatan FROM survey_responses ORDER BY kecamatan")->fetchAll();

// Ambil data per tahun untuk statistik card
$data_per_tahun = $pdo->query("SELECT tahun, AVG((q1+q2+q3+q4+q5+q6+q7+q8+q9)/9) as rata, COUNT(*) as jumlah 
                               FROM survey_responses 
                               GROUP BY tahun 
                               ORDER BY tahun DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Survey Arpus</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f0f2f5; }
        
        .sidebar {
            width: 260px;
            background: linear-gradient(180deg, #003d7a 0%, #001f3f 100%);
            color: white;
            position: fixed;
            height: 100%;
            padding: 20px 0;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            z-index: 100;
        }
        .sidebar h3 { text-align: center; margin-bottom: 30px; padding: 0 20px; font-size: 20px; }
        .sidebar a {
            display: flex;
            align-items: center;
            gap: 12px;
            color: white;
            text-decoration: none;
            padding: 14px 25px;
            margin: 5px 15px;
            border-radius: 12px;
            transition: all 0.3s;
        }
        .sidebar a:hover { background: #007bff; transform: translateX(5px); }
        
        .main { margin-left: 260px; padding: 20px; }
        
        .header {
            background: white;
            padding: 15px 25px;
            border-radius: 15px;
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .logout-btn { background: #dc3545; color: white; padding: 8px 20px; border-radius: 8px; text-decoration: none; }
        
        .stats-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 25px;
        }
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            min-width: 160px;
            flex: 1;
        }
        .stat-card .number { font-size: 28px; font-weight: bold; color: #007bff; }
        .stat-card .label { color: #666; margin-top: 5px; font-size: 13px; font-weight: 600; }
        
        .analisis-box {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .analisis-title {
            font-size: 18px;
            font-weight: bold;
            color: #003d7a;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #eee;
        }
        .skor-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: space-between;
        }
        .skor-item {
            flex: 1;
            min-width: 100px;
            background: #f8f9fa;
            border-radius: 12px;
            padding: 12px;
            text-align: center;
        }
        .skor-item .q-name { font-size: 11px; color: #666; margin-bottom: 5px; }
        .skor-item .q-value { font-size: 20px; font-weight: bold; }
        .skor-baik { color: #28a745; }
        .skor-sedang { color: #ffc107; }
        .skor-kurang { color: #dc3545; }
        
        .filter-bar {
            background: white;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 25px;
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            align-items: flex-end;
        }
        .filter-group { display: flex; flex-direction: column; }
        .filter-group label { font-size: 12px; color: #666; margin-bottom: 5px; }
        .filter-group select, .filter-group input { padding: 10px 15px; border: 1px solid #ddd; border-radius: 8px; min-width: 150px; }
        .btn-filter { background: #007bff; color: white; border: none; padding: 10px 25px; border-radius: 8px; cursor: pointer; }
        .btn-reset { background: #6c757d; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; }
        .btn-export { background: #28a745; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; margin-left: auto; }
        
        .table-container {
            background: white;
            border-radius: 15px;
            overflow-x: auto;
        }
        table { width: 100%; border-collapse: collapse; min-width: 1600px; }
        th { background: #003d7a; color: white; padding: 12px 8px; font-size: 12px; text-align: center; }
        td { padding: 10px 8px; border-bottom: 1px solid #eee; font-size: 12px; text-align: center; }
        tr:hover { background: #f8f9fa; }
        
        .badge { display: inline-block; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: bold; }
        .badge-sangatbaik { background: #28a745; color: white; }
        .badge-baik { background: #17a2b8; color: white; }
        .badge-kurang { background: #ffc107; color: #333; }
        
        .btn-hapus { background: #dc3545; color: white; border: none; padding: 5px 12px; border-radius: 6px; cursor: pointer; text-decoration: none; font-size: 11px; }
        
        .pagination { margin-top: 20px; display: flex; justify-content: center; gap: 8px; flex-wrap: wrap; }
        .pagination a, .pagination span { padding: 8px 15px; background: white; border-radius: 8px; text-decoration: none; color: #007bff; }
        .pagination .active { background: #007bff; color: white; }
        
        @media (max-width: 768px) {
            .sidebar { width: 100%; height: auto; position: relative; }
            .main { margin-left: 0; }
            .stats-container { flex-direction: column; }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h3>📊 Admin Panel</h3>
        <a href="index.php">📋 Semua Data</a>
        <a href="logout.php">🚪 Logout</a>
    </div>
    
    <div class="main">
        <div class="header">
            <h2>📋 Dashboard Survey Kepuasan Masyarakat</h2>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
        
        <?php if($success_msg): ?>
            <div style="background: #d4edda; color: #155724; padding: 12px; border-radius: 8px; margin-bottom: 20px;">✅ <?php echo $success_msg; ?></div>
        <?php endif; ?>
        
        <!-- STATISTIK CARD (Rata-rata per Tahun) -->
        <div class="stats-container">
            <?php if(empty($data_per_tahun)): ?>
                <div class="stat-card">
                    <div class="number">0</div>
                    <div class="label">Belum ada data</div>
                </div>
            <?php else: ?>
                <?php foreach($data_per_tahun as $tahun_data): 
                    $rata_tahun = round($tahun_data['rata'], 2);
                    if($rata_tahun >= 88.31) $warna = "#28a745";
                    elseif($rata_tahun >= 76.61) $warna = "#17a2b8";
                    else $warna = "#ffc107";
                ?>
                <div class="stat-card" style="border-top: 4px solid <?php echo $warna; ?>;">
                    <div class="number"><?php echo $rata_tahun; ?>%</div>
                    <div class="label">📅 Rata-rata Tahun <?php echo $tahun_data['tahun']; ?></div>
                    <div style="font-size: 11px; color: #888; margin-top: 5px;"><?php echo $tahun_data['jumlah']; ?> responden</div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <!-- ANALISIS SKOR PER PERTANYAAN -->
        <div class="analisis-box">
            <div class="analisis-title">📊 ANALISIS SKOR PER PERTANYAAN (Rata-rata keseluruhan)</div>
            <div class="skor-grid">
                <?php
                $questions = [
                    'q1' => 'Persyaratan', 'q2' => 'Prosedur', 'q3' => 'Kecepatan',
                    'q4' => 'Biaya', 'q5' => 'Produk', 'q6' => 'Kompetensi',
                    'q7' => 'Kesopanan', 'q8' => 'Sarpras', 'q9' => 'Pengaduan'
                ];
                $i = 1;
                foreach($questions as $key => $label):
                    $avg = round($stats_q['avg_' . $key], 2);
                    $class = ($avg >= 75) ? "skor-baik" : (($avg >= 50) ? "skor-sedang" : "skor-kurang");
                ?>
                <div class="skor-item">
                    <div class="q-name">Q<?php echo $i; ?>: <?php echo $label; ?></div>
                    <div class="q-value <?php echo $class; ?>"><?php echo $avg; ?>%</div>
                </div>
                <?php $i++; endforeach; ?>
            </div>
        </div>
        
        <!-- FILTER BAR -->
        <div class="filter-bar">
            <div class="filter-group">
                <label>📅 TAHUN</label>
                <select id="filterTahun">
                    <option value="">Semua Tahun</option>
                    <?php foreach($tahun_list as $t): ?>
                        <option value="<?php echo $t['tahun']; ?>" <?php echo $filter_tahun == $t['tahun'] ? 'selected' : ''; ?>><?php echo $t['tahun']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="filter-group">
                <label>📍 KECAMATAN</label>
                <select id="filterKecamatan">
                    <option value="">Semua Kecamatan</option>
                    <?php foreach($kecamatan_list as $k): ?>
                        <option value="<?php echo htmlspecialchars($k['kecamatan']); ?>" <?php echo $filter_kecamatan == $k['kecamatan'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($k['kecamatan']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="filter-group">
                <label>🔍 CARI NAMA/HP</label>
                <input type="text" id="searchInput" placeholder="Nama atau No HP..." value="<?php echo htmlspecialchars($search); ?>">
            </div>
            <div class="filter-group">
                <button class="btn-filter" onclick="applyFilter()">🔍 Filter</button>
            </div>
            <div class="filter-group">
                <a href="index.php" class="btn-reset">↺ Reset</a>
            </div>
            <div class="filter-group">
                <a href="export_excel.php?tahun=<?php echo urlencode($filter_tahun); ?>&kecamatan=<?php echo urlencode($filter_kecamatan); ?>&search=<?php echo urlencode($search); ?>" class="btn-export">📊 Export ke Excel</a>
            </div>
        </div>
        
        <!-- TABEL DATA -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>No</th><th>Nama</th><th>JK</th><th>Usia</th><th>Kecamatan</th><th>Layanan</th><th>Tahun</th>
                        <th>Q1</th><th>Q2</th><th>Q3</th><th>Q4</th><th>Q5</th><th>Q6</th><th>Q7</th><th>Q8</th><th>Q9</th>
                        <th>Skor</th><th>Predikat</th><th>Saran</th><th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($responses)): ?>
                        <tr><td colspan="21" style="text-align:center;">Belum ada data</td></tr>
                    <?php else: 
                        $no = $offset + 1;
                        foreach($responses as $r): 
                            $rata = round(($r['q1']+$r['q2']+$r['q3']+$r['q4']+$r['q5']+$r['q6']+$r['q7']+$r['q8']+$r['q9'])/9, 2);
                            if($rata >= 88.31) { $predikat = 'SANGAT BAIK'; $badge = 'badge-sangatbaik'; }
                            elseif($rata >= 76.61) { $predikat = 'BAIK'; $badge = 'badge-baik'; }
                            else { $predikat = 'KURANG BAIK'; $badge = 'badge-kurang'; }
                    ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><strong><?php echo htmlspecialchars($r['nama']); ?></strong></td>
                            <td><?php echo $r['jenis_kelamin'] == 'L' ? 'L' : 'P'; ?></td>
                            <td><?php echo $r['usia']; ?></td>
                            <td><?php echo htmlspecialchars($r['kecamatan']); ?></td>
                            <td><?php echo htmlspecialchars(substr($r['layanan'],0,15)); ?></td>
                            <td><?php echo $r['tahun']; ?></td>
                            <td><?php echo $r['q1']; ?>%</td><td><?php echo $r['q2']; ?>%</td><td><?php echo $r['q3']; ?>%</td>
                            <td><?php echo $r['q4']; ?>%</td><td><?php echo $r['q5']; ?>%</td><td><?php echo $r['q6']; ?>%</td>
                            <td><?php echo $r['q7']; ?>%</td><td><?php echo $r['q8']; ?>%</td><td><?php echo $r['q9']; ?>%</td>
                            <td><strong><?php echo $rata; ?>%</strong></td>
                            <td><span class="badge <?php echo $badge; ?>"><?php echo $predikat; ?></span></td>
                            <td style="max-width:150px; word-break:break-all;"><?php echo htmlspecialchars(substr($r['saran'],0,40)) . (strlen($r['saran'])>40 ? '...' : ''); ?></td>
                            <td><a href="delete.php?id=<?php echo $r['id']; ?>&page=<?php echo $page; ?>" class="btn-hapus" onclick="return confirm('Hapus?')">Hapus</a></td>
                        </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
        
        <?php if($total_pages > 1): ?>
        <div class="pagination">
            <?php for($i=1; $i<=$total_pages; $i++): ?>
                <?php if($i==$page): ?><span class="active"><?php echo $i; ?></span>
                <?php else: ?><a href="?page=<?php echo $i; ?>&tahun=<?php echo urlencode($filter_tahun); ?>&kecamatan=<?php echo urlencode($filter_kecamatan); ?>&search=<?php echo urlencode($search); ?>"><?php echo $i; ?></a><?php endif; ?>
            <?php endfor; ?>
        </div>
        <?php endif; ?>
    </div>
    
    <script>
        function applyFilter() {
            let tahun = document.getElementById('filterTahun').value;
            let kecamatan = document.getElementById('filterKecamatan').value;
            let search = document.getElementById('searchInput').value;
            let url = 'index.php?';
            if(tahun) url += 'tahun=' + tahun + '&';
            if(kecamatan) url += 'kecamatan=' + encodeURIComponent(kecamatan) + '&';
            if(search) url += 'search=' + encodeURIComponent(search);
            window.location.href = url;
        }
        document.getElementById('searchInput')?.addEventListener('keypress', function(e) { if(e.key === 'Enter') applyFilter(); });
    </script>
</body>
</html>