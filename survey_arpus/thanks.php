<?php
require_once 'header.php';
$nama = isset($_GET['nama']) ? htmlspecialchars($_GET['nama']) : 'Responden';
?>

<div style="text-align: center; padding: 60px 20px;">
    <div style="width: 120px; height: 120px; background: #28a745; border-radius: 50%; display: flex; justify-content: center; align-items: center; margin: 0 auto 30px;">
        <span style="color: white; font-size: 70px;">✓</span>
    </div>
    <h2 style="color: #28a745;">TERIMA KASIH!</h2>
    <p style="font-size: 18px;">Terima kasih <?php echo $nama; ?>, data survey Anda telah tersimpan.</p>
    <a href="index.php" class="btn" style="margin-top: 30px;">KEMBALI KE BERANDA</a>
</div>

<?php require_once 'footer.php'; ?>