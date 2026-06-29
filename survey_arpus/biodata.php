<?php
session_start();
require_once 'header.php';
?>

<div id="p2" style="display: block;">
    <h2 style="text-align: center; margin-bottom: 30px; color: var(--biru);">BIODATA RESPONDEN</h2>
    
    <form action="proses_biodata.php" method="POST">
        <div class="form-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px 50px; max-width: 1100px; margin: 0 auto;">
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" required style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 8px;">
            </div>
            <div class="form-group">
                <label>Jenis Kelamin</label>
                <select name="jk" required style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 8px;">
                    <option value="">-- Pilih --</option>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>
            <div class="form-group">
                <label>Umur</label>
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-top: 10px;">
                    <label><input type="radio" name="usia" value="< 20"> &lt; 20</label>
                    <label><input type="radio" name="usia" value="20 - 29"> 20 - 29</label>
                    <label><input type="radio" name="usia" value="30 - 39"> 30 - 39</label>
                    <label><input type="radio" name="usia" value="40 - 49"> 40 - 49</label>
                    <label><input type="radio" name="usia" value=">= 50"> >= 50</label>
                </div>
            </div>
            <div class="form-group">
                <label>Nomor HP</label>
                <input type="text" name="wa" placeholder="08xxxxxxxxxx" required style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 8px;">
            </div>
            <div class="form-group">
                <label>Pendidikan</label>
                <select name="pendidikan" required style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 8px;">
                    <option value="">-- Pilih --</option>
                    <option value="SD/Sederajat">SD/Sederajat</option>
                    <option value="SMP">SMP/Sederajat</option>
                    <option value="SMA/SMK/Sederajat">SMA/SMK/Sederajat</option>
                    <option value="Diploma">Diploma</option>
                    <option value="S1">S1</option>
                    <option value="S2/S3">S2/S3</option>
                </select>
            </div>
            <div class="form-group">
                <label>Pekerjaan</label>
                <select name="pekerjaan" required style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 8px;">
                    <option value="">-- Pilih --</option>
                    <option value="PNS/PPPK">PNS/PPPK</option>
                    <option value="TNI/POLRI">TNI/POLRI</option>
                    <option value="Karyawan Swasta">Karyawan Swasta</option>
                    <option value="Wiraswasta">Wiraswasta</option>
                    <option value="Pelajar/Mahasiswa">Pelajar/Mahasiswa</option>
                    <option value="Ibu Rumah Tangga">Ibu Rumah Tangga</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>
            <div class="form-group">
                <label>Kecamatan</label>
                <select name="kecamatan" required style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 8px;">
                    <option value="">-- Pilih --</option>
                    <option value="Kajen">Kajen</option>
                    <option value="Kesesi">Kesesi</option>
                    <option value="Sragi">Sragi</option>
                    <option value="Bojong">Bojong</option>
                    <option value="Wonopringgo">Wonopringgo</option>
                    <option value="Kedungwuni">Kedungwuni</option>
                    <option value="Buaran">Buaran</option>
                    <option value="Tirto">Tirto</option>
                    <option value="Wiradesa">Wiradesa</option>
                    <option value="Siwalan">Siwalan</option>
                    <option value="Wonokerto">Wonokerto</option>
                    <option value="Karangdadap">Karangdadap</option>
                    <option value="Talun">Talun</option>
                    <option value="Doro">Doro</option>
                    <option value="Karanganyar">Karanganyar</option>
                    <option value="Lebakbarang">Lebakbarang</option>
                    <option value="Paninggaran">Paninggaran</option>
                    <option value="Kandangserang">Kandangserang</option>
                    <option value="Petungkriyono">Petungkriyono</option>
                </select>
            </div>
            <div class="form-group">
                <label>Jenis Layanan</label>
                <select name="layanan" required style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 8px;">
                    <option value="">-- Pilih Layanan --</option>
                    <option value="Informasi Arsip">Layanan Informasi Arsip</option>
                    <option value="Peminjaman Arsip">Layanan Peminjaman Arsip</option>
                    <option value="Konsultasi Kearsipan">Layanan Konsultasi Kearsipan</option>
                    <option value="Fasilitas Kearsipan">Layanan Fasilitas Kearsipan</option>
                    <option value="Layanan Pengaduan">Layanan Pengaduan</option>
                    <option value="Layanan Umum Perpustakaan">Layanan Umum Perpustakaan</option>
                </select>
            </div>
        </div>
        <div class="btn-group">
            <a href="index.php" class="btn btn-back">KEMBALI</a>
            <button type="submit" class="btn">LANJUT KE PENILAIAN</button>
        </div>
    </form>
</div>

<?php require_once 'footer.php'; ?>