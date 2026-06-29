<?php
session_start();
require_once 'config/database.php';

// Cek apakah biodata ada di session
if(!isset($_SESSION['biodata'])) {
    header('Location: biodata.php');
    exit;
}

$biodata = $_SESSION['biodata'];

// Ambil nilai dari form
$q1 = $_POST['q1'] ?? 0;
$q2 = $_POST['q2'] ?? 0;
$q3 = $_POST['q3'] ?? 0;
$q4 = $_POST['q4'] ?? 0;
$q5 = $_POST['q5'] ?? 0;
$q6 = $_POST['q6'] ?? 0;
$q7 = $_POST['q7'] ?? 0;
$q8 = $_POST['q8'] ?? 0;
$q9 = $_POST['q9'] ?? 0;
$saran = $_POST['saran'] ?? '';

try {
    $sql = "INSERT INTO survey_responses (nama, jenis_kelamin, usia, wa, pendidikan, pekerjaan, kecamatan, layanan, tahun, q1, q2, q3, q4, q5, q6, q7, q8, q9, saran) 
            VALUES (:nama, :jk, :usia, :wa, :pendidikan, :pekerjaan, :kecamatan, :layanan, :tahun, :q1, :q2, :q3, :q4, :q5, :q6, :q7, :q8, :q9, :saran)";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nama' => $biodata['nama'],
        ':jk' => $biodata['jk'],
        ':usia' => $biodata['usia'],
        ':wa' => $biodata['wa'],
        ':pendidikan' => $biodata['pendidikan'],
        ':pekerjaan' => $biodata['pekerjaan'],
        ':kecamatan' => $biodata['kecamatan'],
        ':layanan' => $biodata['layanan'],
        ':tahun' => date('Y'),
        ':q1' => $q1,
        ':q2' => $q2,
        ':q3' => $q3,
        ':q4' => $q4,
        ':q5' => $q5,
        ':q6' => $q6,
        ':q7' => $q7,
        ':q8' => $q8,
        ':q9' => $q9,
        ':saran' => $saran
    ]);
    
    // Hapus session biodata setelah sukses
    unset($_SESSION['biodata']);
    
    // Redirect ke halaman terima kasih
    header('Location: thanks.php?nama=' . urlencode($biodata['nama']));
    exit;
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
    echo "<br><a href='kuesioner.php'>Kembali ke kuesioner</a>";
    exit;
}
?>