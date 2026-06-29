<?php
session_start();

if($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: biodata.php');
    exit;
}

$required_fields = ['nama', 'jk', 'usia', 'wa', 'pendidikan', 'pekerjaan', 'kecamatan', 'layanan'];
foreach($required_fields as $field) {
    if(empty($_POST[$field])) {
        header('Location: biodata.php?error=Semua field harus diisi!');
        exit;
    }
}

$_SESSION['biodata'] = [
    'nama' => $_POST['nama'],
    'jk' => $_POST['jk'],
    'usia' => $_POST['usia'],
    'wa' => $_POST['wa'],
    'pendidikan' => $_POST['pendidikan'],
    'pekerjaan' => $_POST['pekerjaan'],
    'kecamatan' => $_POST['kecamatan'],
    'layanan' => $_POST['layanan']
];

header('Location: kuesioner.php');
exit;
?>