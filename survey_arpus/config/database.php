<?php
// config/database.php
// Ini file untuk koneksi ke MySQL

$host = 'localhost';        // server database (biasanya localhost)
$dbname = 'survey_arpus';   // nama database yang sudah dibuat
$username = 'root';         // username MySQL (default root)
$password = '';             // password MySQL (default kosong)

try {
    // Membuat koneksi ke database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    
    // Setting error mode ke exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Setting default fetch mode ke array asosiatif
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
    // (Opsional) Untuk testing, bisa hapus baris ini nanti
    // echo "Koneksi berhasil!";
    
} catch(PDOException $e) {
    // Jika koneksi gagal, tampilkan pesan error
    die("Koneksi database gagal: " . $e->getMessage());
}

// Mulai session untuk admin (jika belum dimulai)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>