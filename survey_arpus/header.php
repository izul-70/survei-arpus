<?php
// header.php - Tidak ada tombol login admin di sini
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Survei Arpus Pekalongan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <style>
        /* Sembunyikan laporan di layar HP */
        @media (max-width: 768px) {
            #section-laporan {
                display: none !important;
            }
        }

        @media (min-width: 769px) {
            #section-laporan {
                display: block;
            }
        }

        :root { --biru: #003d7a; --langit: #007bff; --hijau: #28a745; --abu: #f8f9fa; --text: #333; }
        
        body { font-family: 'Segoe UI', sans-serif; background: #cbdcf7; margin: 0; min-height: 100vh; padding: 20px; display: flex; justify-content: center; color: var(--text); }

        .container { background: white; width: 95%; max-width: 1400px; border-radius: 15px; box-shadow: 0 10px 40px rgba(0,0,0,0.15); overflow: hidden; }
        
        .header { background: linear-gradient(135deg, var(--biru), var(--langit)); padding: 20px 40px; display: flex; align-items: center; color: white; gap: 20px; flex-wrap: wrap; }
        .header img { width: 50px; height: auto; }
        .header .title-area { display: flex; flex-direction: column; }
        .header h1 { margin: 0; font-size: 32px; line-height: 1; text-transform: uppercase; }
        .header h2 { margin: 5px 0 0 0; font-size: 16px; font-weight: 300; }

        .welcome-split { display: flex; align-items: center; gap: 50px; flex-wrap: wrap; }
        .welcome-img { flex: 1; text-align: center; }
        .welcome-img img { width: 70%; max-width: 400px; border-radius: 15px; }
        .welcome-text { flex: 1; }

        .btn-group { display: flex; justify-content: center; gap: 15px; margin-top: 40px; flex-wrap: wrap; }
        .btn { background: var(--langit); color: white; border: none; padding: 18px 45px; border-radius: 10px; font-weight: bold; cursor: pointer; font-size: 16px; transition: 0.2s; text-decoration: none; display: inline-block; }
        .btn:hover { background: var(--biru); transform: translateY(-2px); }
        .btn-back { background: #6c757d; color: white; }

        .extra-logos { margin-top: 40px; display: flex; gap: 40px; align-items: center; flex-wrap: wrap; }
        .extra-logos img { height: 100px; width: auto; }

        .content { padding: 40px; min-height: 500px; }
        .footer { text-align: center; padding: 20px; color: #666; font-size: 14px; border-top: 1px solid #eee; margin-top: 30px; }

        @media (max-width: 768px) {
            .header { flex-direction: column; text-align: center; padding: 16px; }
            .header h1 { font-size: 20px; }
            .header h2 { font-size: 13px; }
            .content { padding: 20px; }
            .welcome-split { flex-direction: column; text-align: center; gap: 25px; }
            .welcome-img img { width: 85%; max-width: 260px; }
            .welcome-text h2 { font-size: 28px !important; }
            .btn { width: 100%; padding: 14px; }
            .extra-logos img { height: 60px; }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <img src="images/dinas.png" alt="Logo">
        <div class="title-area">
            <h1>DINAS ARPUS</h1>
            <h2>Kabupaten Pekalongan</h2>
        </div>
    </div>
    <div class="content">