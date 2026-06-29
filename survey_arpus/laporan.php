<?php
require_once 'header.php';
require_once 'config/database.php';

// Ambil semua data
$stmt = $pdo->query("SELECT tahun, COUNT(*) as jumlah, AVG((q1+q2+q3+q4+q5+q6+q7+q8+q9)/9) as rata FROM survey_responses GROUP BY tahun ORDER BY tahun DESC");
$data = $stmt->fetchAll();

// Rata-rata keseluruhan
$stmt_all = $pdo->query("SELECT AVG((q1+q2+q3+q4+q5+q6+q7+q8+q9)/9) as total FROM survey_responses");
$total = $stmt_all->fetch()['total'];
$total = round($total, 2);

if($total >= 88.31) $predikat = "SANGAT BAIK";
elseif($total >= 76.61) $predikat = "BAIK";
else $predikat = "KURANG BAIK";
?>

<h2 style="text-align:center; color: var(--biru);">📊 LAPORAN INDEKS KEPUASAN MASYARAKAT</h2>

<div style="max-width: 600px; margin: 0 auto 40px; text-align: center;">
    <div class="card-indeks" style="background: #003d7a; padding: 30px; border-radius: 15px; color: white;">
        <div>RATA-RATA KESELURUHAN</div>
        <div style="font-size: 55px; font-weight: 800;"><?php echo $total; ?>%</div>
        <div style="font-size: 20px;"><?php echo $predikat; ?></div>
    </div>
</div>

<table style="width: 100%; border-collapse: collapse; background: white; border-radius: 10px; overflow: hidden;">
    <thead>
        <tr style="background: #003d7a; color: white;">
            <th style="padding: 12px;">Tahun</th>
            <th style="padding: 12px;">Jumlah Responden</th>
            <th style="padding: 12px;">Indeks Kepuasan</th>
            <th style="padding: 12px;">Predikat</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($data as $row): 
            $rata = round($row['rata'], 2);
            if($rata >= 88.31) $pred = "SANGAT BAIK";
            elseif($rata >= 76.61) $pred = "BAIK";
            else $pred = "KURANG BAIK";
        ?>
        <tr style="border-bottom: 1px solid #eee;">
            <td style="padding: 12px; text-align: center;"><?php echo $row['tahun']; ?></td>
            <td style="padding: 12px; text-align: center;"><?php echo $row['jumlah']; ?></td>
            <td style="padding: 12px; text-align: center;"><strong><?php echo $rata; ?>%</strong></td>
            <td style="padding: 12px; text-align: center;"><?php echo $pred; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div style="text-align: center; margin-top: 30px;">
    <a href="index.php" class="btn">KEMBALI KE BERANDA</a>
</div>

<?php require_once 'footer.php'; ?>