<?php
session_start();

if(!isset($_SESSION['biodata'])) {
    header('Location: biodata.php');
    exit;
}

require_once 'header.php';
$tahun = date('Y');
?>

<div id="p3" style="display: block;">
    <h2 style="text-align:center; color: var(--biru);">Survei Kepuasan Masyarakat Tahun <?php echo $tahun; ?></h2>
    
    <form action="proses_survey.php" method="POST" id="surveyForm">
        <!-- 9 Pertanyaan dengan emoji -->
        <?php for($i=1; $i<=9; $i++): ?>
        <div id="stepQ<?php echo $i; ?>" class="q-box <?php echo $i==1 ? 'q-active' : ''; ?>">
            <h3><?php echo $i; ?>. <?php echo getQuestion($i); ?></h3>
            <div class="emoji-grid" id="q<?php echo $i; ?>">
                <div class="emoji-item" data-q="<?php echo $i; ?>" data-value="100"><span>😍</span><b><?php echo getLabel($i, 100); ?></b></div>
                <div class="emoji-item" data-q="<?php echo $i; ?>" data-value="75"><span>😊</span><b><?php echo getLabel($i, 75); ?></b></div>
                <div class="emoji-item" data-q="<?php echo $i; ?>" data-value="50"><span>😐</span><b><?php echo getLabel($i, 50); ?></b></div>
                <div class="emoji-item" data-q="<?php echo $i; ?>" data-value="25"><span>☹️</span><b><?php echo getLabel($i, 25); ?></b></div>
            </div>
            <input type="hidden" name="q<?php echo $i; ?>" id="input_q<?php echo $i; ?>">
            <button type="button" class="btn" onclick="nextQ(<?php echo $i+1; ?>)">SELANJUTNYA</button>
        </div>
        <?php endfor; ?>
        
        <!-- Saran -->
        <div id="stepQ10" class="q-box">
            <h3>Saran dan Masukan</h3>
            <textarea name="saran" rows="5" style="width:100%; max-width:600px; border-radius:12px; padding:15px; border:1px solid #ccc;"></textarea>
            <div class="btn-group">
                <button type="button" class="btn btn-back" onclick="nextQ(9)">KEMBALI</button>
                <button type="submit" class="btn" style="background: var(--hijau);">SIMPAN JAWABAN</button>
            </div>
        </div>
    </form>
</div>

<style>
    .q-box { display: none; text-align: center; max-width: 850px; margin: 0 auto; }
    .q-box.q-active { display: block; }
    .emoji-grid { display: flex; justify-content: space-around; gap: 20px; margin: 40px 0; flex-wrap: wrap; }
    .emoji-item { flex: 1; padding: 25px; border: 2px solid #eee; border-radius: 20px; cursor: pointer; transition: 0.3s; background: #fff; text-align: center; min-width: 130px; }
    .emoji-item span { font-size: 50px; display: block; }
    .emoji-item.selected { border-color: var(--hijau); background: #f0fff4; transform: scale(1.05); }
    @media (max-width: 768px) { .emoji-item { flex: 0 0 48%; padding: 15px; } .emoji-item span { font-size: 36px; } }
</style>

<script>
    let skor = {};
    let currentQ = 1;

    document.querySelectorAll('.emoji-item').forEach(item => {
        item.addEventListener('click', function() {
            let qNum = this.getAttribute('data-q');
            let value = this.getAttribute('data-value');
            let parent = this.parentElement;
            parent.querySelectorAll('.emoji-item').forEach(i => i.classList.remove('selected'));
            this.classList.add('selected');
            skor['q'+qNum] = value;
            document.getElementById('input_q'+qNum).value = value;
        });
    });

    function nextQ(n) {
        if(currentQ <= 9 && !skor['q'+currentQ]) {
            alert("Pilih salah satu emoji!");
            return;
        }
        document.querySelectorAll('.q-box').forEach(q => q.classList.remove('q-active'));
        document.getElementById('stepQ'+n).classList.add('q-active');
        currentQ = n;
    }
</script>

<?php
function getQuestion($num) {
    $questions = [
        1 => "Bagaimana pendapat saudara tentang kesesuaian persyaratan pelayanan dengan jenis pelayanannya?",
        2 => "Bagaimana pemahaman saudara tentang kemudahan prosedur layanan di unit ini?",
        3 => "Bagaimana pendapat saudara tentang Kecepatan Waktu dalam memberikan pelayanan?",
        4 => "Bagaimana pendapat saudara tentang kewajaran biaya atau tarif dalam pelayanan",
        5 => "Bagaimana pendapat saudara tentang kesesuaian produk pelayanan antara yang tercantum dalam standar pelayanan dengan hasil yang di berikan",
        6 => "Bagaimana pendapat saudara tentang kompetensi atau kemampuan petugas dalam pelayanan?",
        7 => "Bagaimana pendapat saudara perilaku petugas dalam pelayanan terkait kesopanan dan keramahan?",
        8 => "Bagaimana pendapat saudara tentang kualitas sarana dan prasarana?",
        9 => "Bagaimana pendapat saudara tentang penanganan, pengaduan pengguna layanan?"
    ];
    return $questions[$num];
}

function getLabel($num, $value) {
    $labels = [
        1 => [100=>"Sangat Sesuai", 75=>"Sesuai", 50=>"Kurang Sesuai", 25=>"Tidak Sesuai"],
        2 => [100=>"Sangat Mudah", 75=>"Mudah", 50=>"Kurang Mudah", 25=>"Tidak Mudah"],
        3 => [100=>"Sangat Cepat", 75=>"Cepat", 50=>"Kurang Cepat", 25=>"Tidak Cepat"],
        4 => [100=>"Gratis", 75=>"Murah", 50=>"Cukup Mahal", 25=>"Sangat Mahal"],
        5 => [100=>"Sangat Sesuai", 75=>"Sesuai", 50=>"Kurang Sesuai", 25=>"Tidak Sesuai"],
        6 => [100=>"Sangat Kompeten", 75=>"Kompeten", 50=>"Kurang Kompeten", 25=>"Tidak Kompeten"],
        7 => [100=>"Sangat Sopan", 75=>"Sopan", 50=>"Kurang Sopan", 25=>"Tidak Sopan"],
        8 => [100=>"Sangat Baik", 75=>"Baik", 50=>"Cukup", 25=>"Buruk"],
        9 => [100=>"Sangat Baik", 75=>"Baik", 50=>"Kurang Baik", 25=>"Tidak Baik"]
    ];
    return $labels[$num][$value];
}
?>

<?php require_once 'footer.php'; ?>