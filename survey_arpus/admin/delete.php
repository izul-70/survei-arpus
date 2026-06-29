<?php
session_start();
require_once __DIR__ . '/../config/database.php';

// Cek login admin
if(!isset($_SESSION['admin_logged']) || $_SESSION['admin_logged'] !== true) {
    header('Location: login.php');
    exit;
}

// Ambil ID dari URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

if($id > 0) {
    try {
        $stmt = $pdo->prepare("DELETE FROM survey_responses WHERE id = :id");
        $stmt->execute([':id' => $id]);
        
        // Redirect kembali ke halaman admin dengan pesan sukses
        header("Location: index.php?page=" . $page . "&success=Data berhasil dihapus");
        exit;
    } catch(PDOException $e) {
        echo "Error menghapus data: " . $e->getMessage();
        echo "<br><a href='index.php?page=" . $page . "'>Kembali</a>";
        exit;
    }
} else {
    // Jika ID tidak valid
    header("Location: index.php?page=" . $page . "&error=ID tidak valid");
    exit;
}
?>