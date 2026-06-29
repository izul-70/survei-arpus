<?php
session_start();
require_once __DIR__ . '/../config/database.php';

// Cek login admin
if(!isset($_SESSION['admin_logged']) || $_SESSION['admin_logged'] !== true) {
    header('Location: login.php');
    exit;
}

// Ambil parameter filter dari URL
$filter_tahun = isset($_GET['tahun']) ? $_GET['tahun'] : '';
$filter_kecamatan = isset($_GET['kecamatan']) ? $_GET['kecamatan'] : '';
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Bangun query WHERE
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

// Ambil data sesuai filter
$sql = "SELECT * FROM survey_responses $where_sql ORDER BY created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$data = $stmt->fetchAll();

// Set header untuk download file Excel
header('Content-Type: application/vnd.ms-excel; charset=utf-8');
header('Content-Disposition: attachment; filename="Laporan_Survey_Arpus_' . date('Y-m-d') . '_Tahun_' . ($filter_tahun ?: 'Semua') . '.xls"');
header('Cache-Control: max-age=0');

// Buat output
echo "<meta charset='utf-8'>";
echo "<table border='1' cellpadding='5' cellspacing='0'>";

// HEADER TABEL
echo "<tr style='background-color: #003d7a; color: white; font-weight: bold;'>";
echo "<th>No</th>";
echo "<th>ID</th>";
echo "<th>Nama Lengkap</th>";
echo "<th>Jenis Kelamin</th>";
echo "<th>Usia</th>";
echo "<th>Nomor HP/WA</th>";
echo "<th>Pendidikan</th>";
echo "<th>Pekerjaan</th>";
echo "<th>Kecamatan</th>";
echo "<th>Jenis Layanan</th>";
echo "<th>Tahun Survey</th>";
echo "<th>Q1</th>";
echo "<th>Q2</th>";
echo "<th>Q3</th>";
echo "<th>Q4</th>";
echo "<th>Q5</th>";
echo "<th>Q6</th>";
echo "<th>Q7</th>";
echo "<th>Q8</th>";
echo "<th>Q9</th>";
echo "<th>Rata-rata</th>";
echo "<th>Predikat</th>";
echo "<th>Saran</th>";
echo "<th>Tanggal Survey</th>";
echo "</tr>";

// DATA
$no = 1;
foreach($data as $row) {
    $rata = ($row['q1'] + $row['q2'] + $row['q3'] + $row['q4'] + $row['q5'] + 
             $row['q6'] + $row['q7'] + $row['q8'] + $row['q9']) / 9;
    $rata = round($rata, 2);
    
    if($rata >= 88.31) {
        $predikat = "SANGAT BAIK";
    } elseif($rata >= 76.61) {
        $predikat = "BAIK";
    } else {
        $predikat = "KURANG BAIK";
    }
    
    echo "<tr>";
    echo "<td style='text-align: center;'>" . $no++ . "</td>";
    echo "<td style='text-align: center;'>" . $row['id'] . "</td>";
    echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
    echo "<td style='text-align: center;'>" . ($row['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan') . "</td>";
    echo "<td style='text-align: center;'>" . $row['usia'] . "</td>";
    echo "<td style='text-align: center;'>" . $row['wa'] . "</td>";
    echo "<td>" . $row['pendidikan'] . "</td>";
    echo "<td>" . $row['pekerjaan'] . "</td>";
    echo "<td>" . $row['kecamatan'] . "</td>";
    echo "<td>" . $row['layanan'] . "</td>";
    echo "<td style='text-align: center;'>" . $row['tahun'] . "</td>";
    echo "<td style='text-align: center;'>" . $row['q1'] . "%</td>";
    echo "<td style='text-align: center;'>" . $row['q2'] . "%</td>";
    echo "<td style='text-align: center;'>" . $row['q3'] . "%</td>";
    echo "<td style='text-align: center;'>" . $row['q4'] . "%</td>";
    echo "<td style='text-align: center;'>" . $row['q5'] . "%</td>";
    echo "<td style='text-align: center;'>" . $row['q6'] . "%</td>";
    echo "<td style='text-align: center;'>" . $row['q7'] . "%</td>";
    echo "<td style='text-align: center;'>" . $row['q8'] . "%</td>";
    echo "<td style='text-align: center;'>" . $row['q9'] . "%</td>";
    echo "<td style='text-align: center; font-weight: bold;'>" . $rata . "%</td>";
    echo "<td style='text-align: center;'>" . $predikat . "</td>";
    echo "<td style='max-width: 300px; word-wrap: break-word;'>" . htmlspecialchars($row['saran']) . "</td>";
    echo "<td style='text-align: center;'>" . date('d/m/Y H:i', strtotime($row['created_at'])) . "</td>";
    echo "</tr>";
}

echo "</table>";
exit;
?>