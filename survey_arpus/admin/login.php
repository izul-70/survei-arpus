<?php
session_start();
require_once '../config/database.php';

// Jika sudah login, redirect ke dashboard
if(isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] === true) {
    header('Location: index.php');
    exit;
}

$error = '';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    $stmt = $pdo->prepare("SELECT * FROM admin_users WHERE username = :username");
    $stmt->execute([':username' => $username]);
    $admin = $stmt->fetch();
    
    if($admin && password_verify($password, $admin['password_hash'])) {
        $_SESSION['admin_logged'] = true;
        $_SESSION['admin_username'] = $admin['username'];
        header('Location: index.php');
        exit;
    } else {
        $error = 'Username atau password salah!';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Survey Arpus</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: linear-gradient(135deg, #003d7a, #007bff); min-height: 100vh; display: flex; justify-content: center; align-items: center; }
        .login-box { background: white; padding: 40px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.3); width: 100%; max-width: 400px; }
        .login-box h2 { text-align: center; color: #003d7a; margin-bottom: 30px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; color: #333; }
        input { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 16px; }
        button { width: 100%; padding: 12px; background: #007bff; color: white; border: none; border-radius: 8px; font-size: 16px; cursor: pointer; }
        button:hover { background: #003d7a; }
        .error { background: #f8d7da; color: #721c24; padding: 10px; border-radius: 8px; margin-bottom: 20px; text-align: center; }
        .logo { text-align: center; margin-bottom: 20px; }
        .logo img { width: 80px; }
    </style>
</head>
<body>
    <div class="login-box">
        <div class="logo">
            <img src="../images/dinas.png" alt="Logo">
        </div>
        <h2>Login Admin</h2>
        <h2>Survey Kepuasan Masyarakat</h2>
        
        <?php if($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required autofocus>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit">MASUK</button>
        </form>
    </div>
</body>
</html>