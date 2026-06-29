<?php
// buat_admin.php - Jalankan file ini sekali saja untuk membuat akun admin

$host = 'localhost';
$dbname = 'survey_arpus';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Password yang mau dipakai (ganti sesuai keinginan)
    $password_admin = 'admin123';
    $hash = password_hash($password_admin, PASSWORD_DEFAULT);
    
    // Hapus data admin lama
    $pdo->exec("TRUNCATE TABLE admin_users");
    
    // Insert admin baru
    $stmt = $pdo->prepare("INSERT INTO admin_users (username, password_hash) VALUES (:username, :hash)");
    $stmt->execute([
        ':username' => 'admin',
        ':hash' => $hash
    ]);
    
    echo "<h2 style='color:green'>✅ AKUN ADMIN BERHASIL DIBUAT!</h2>";
    echo "<hr>";
    echo "<h3>📋 Informasi Login:</h3>";
    echo "<p><strong>Username:</strong> admin</p>";
    echo "<p><strong>Password:</strong> " . $password_admin . "</p>";
    echo "<hr>";
    echo "<a href='admin/login.php' style='background:#007bff; color:white; padding:10px 20px; text-decoration:none; border-radius:5px;'>🔐 Klik Disini untuk Login</a>";
    
} catch(PDOException $e) {
    echo "<h2 style='color:red'>❌ ERROR: " . $e->getMessage() . "</h2>";
}
?>