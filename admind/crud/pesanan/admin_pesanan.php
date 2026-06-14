<?php
include "koneksi.php";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Panel Admin - Pesanan Aktif</title>
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <link rel="stylesheet" href="../../asset/style_sidebar.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }
        body {
            font-family: 'Poppins', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f5f2;
            min-height: 100vh;
            margin: 0;
        }

        .main-content{
            margin-left: 260px;
            padding: 25px;
        }

        .page-header{
            background:linear-gradient(135deg,#7d0a0a,#a31621);
            padding:20px 25px;
            border-radius:18px;
            margin-bottom:25px;
            color:white;
            box-shadow:0 10px 25px rgba(0,0,0,.12);
        }

        .page-header h1{
            margin:0;
            font-size:24px;
            font-weight:600;
        }

        .page-header p{
            margin-top:6px;
            opacity:.9;
            font-size: 14px;
            color:rgba(255,255,255,.85);
        }

        .summary-grid{
            margin-top: 30px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }

        .summary-card{
            min-height: 110px;
            padding:24px;
            display:flex;
            align-items:center;
            gap:16px;
            background:#fff;
            border-radius:20px;
            box-shadow:0 8px 20px rgba(0,0,0,.06);
        }

        .summary-icon{
            width:64px;
            height:64px;
            border-radius:18px;
            display:flex;
            align-items:center;
            justify-content:center;
            flex-shrink:0;
            background:#fdf1f1;
        }

        .summary-icon svg{
            width:28px;
            height:28px;
        }

        .summary-card span{
            font-size:13px;
            font-weight:600;
            color:#64748b;
        }

        .summary-card h3{
            margin-top:4px;
            font-size:28px;
            line-height:1.1;
            font-weight:700;
            color:#7d0a0a;
        }

        .summary-card small{
            font-size:13px;
            color:#94a3b8;
        }

        .filter-bar{
            display:flex;
            justify-content: space-between;
            align-items: center;
            gap:15px;
            margin-bottom:20px;
        }

        .filter-right{
            display:flex;
            justify-content:flex-end;
        }
        .filter-bar input{
            padding:12px 15px;
            border:1px solid #e5e7eb;
            border-radius:12px;
            font-size:14px;
            outline:none;
            min-width:220px;
        }

        .filter-bar select{
            padding:12px 15px;
            border:1px solid #e5e7eb;
            border-radius:12px;
            font-size:14px;
            outline:none;
            min-width:200px;
        }

        .filter-bar input:focus,
        .filter-bar select:focus{
            border-color:#8b1e2d;
            box-shadow:0 0 0 3px rgba(139,30,45,.1);
        }

        .btn-search,
        .btn-reset{
            padding:12px 18px;
            font-size:14px;
            font-weight:600;
            border-radius:10px;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            height:42px;
            box-sizing:border-box;
        }

        .btn-search{
            background:#8b1e2d;
            color:white;
            border:none;
            cursor:pointer;
        }

        .btn-reset{
            background:#6b7280;
            color:white;
            text-decoration:none;
        }

        .btn-search:hover{
            background:#6f0f1a;
        }

        .btn-reset:hover{
            background:#4b5563;
        }

        .table-wrapper{
            background:white;
            padding:0;
            border-radius:20px;
            overflow:hidden;
            box-shadow:0 8px 25px rgba(0,0,0,.08);
        }

        table {
            border-collapse: collapse;
            width: 100%;
            background: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        tbody tr{
            transition: background 0.5s ease;
        }

        tbody tr:hover{
            background:#f9fafb ;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-right: 1px solid #ddd;
        }
        td {
            padding:14px 16px;
            border-bottom:1px solid #e5e7eb;
            text-align: left;
            vertical-align: top;
        }
        th {
            background: rgba(139,30,45,.92);
            backdrop-filter: blur(10px);
            color: #fff;
            padding: 22px;
            text-align: center;
            font-size: 14px;
            font-weight: 600;
            border-right: 1px solid rgba(255,255,255,.15);
        }

        .pesanan-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .pelanggan-icon{
            width:55px;
            height:55px;
            border-radius:50%;
            background:#fdf2f2;
            color:#8b1e2d;
            display:flex;
            justify-content:center;
            align-items:center;
            flex-shrink:0;
        }
        .pelanggan-icon svg{
            width:24px;
            height:24px;
            stroke:#8b1e2d;
        }
        .nomor-pesanan {
            font-size: 20px;
            font-weight: 600;
            color: #8b1e2d;
            margin-bottom: 1.2px;
            display: block;
        }
        .nama-pelanggan{
            font-size: 16px;  
            color: #111;
            
        }
        
        .total-bayar {
            font-size: 16px;
            font-weight: 600;
            color: #7a1a26;
        }
        
        .status-badge {
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 13px;
            font-weight: 600;
            text-transform: capitalize;
            display: inline-block;
        }

        .diproses { background: #b8daff; color: #004085; }
        .selesai { background: #d4edda; color: #155724; }
        .dibayar { background: #c3e6cb; color: #155724; border: 1px solid green; }
        .pending { background: #fff3cd; color: #856404; } 

        .item-menu {
            padding: 6px 0;
            border-bottom: 1px dashed rgba(0,0,0,0.25);
        }
        .item-menu:last-child {
            border-bottom: none;
        }
        .nama-menu{
            display: flex;
            align-items:center;
            gap: 8px;
            font-size:16px;
            font-weight:600;
            color:#7a1a26;
            margin-bottom:2px;
        }

        .qty{
            background:#fdf2f2;
            color:#8b1e2d;
            padding:2px 8px;
            border-radius:20px;
            font-size:15px;
            font-weight:600;
            line-height:1;
        }
        
        .menu-pedas{
            padding:4px 10px;
            background:#ffe5e5;
            color:#c62828;
            border-radius:20px;
            font-size:12px;
            font-weight:600;
        }

        .detail-menu,
        .catatan-menu {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-top: 3px;
        }
        .detail-menu svg, .catatan-menu svg {
            width: 14px;
            height: 14px;
        }
        .detail-menu svg { color: #ea580c; }
        .catatan-menu svg { color: #6b7280; }
        
        .text-muted{
            color: #4b5563;
            font-size: 12px;
        }
        .btn-status {
            padding:10px 15px;
            text-decoration:none;
            border-radius:10px;
            font-size:13px;
            display:inline-flex;
            align-items:center;
            gap:8px;
            margin:2px;
            color:white;
            font-weight:600;
            transition:.2s;
        }
        .btn-status svg{
            width: 16px;
            height: 16px;
        }
        .btn-status:hover { opacity: 0.8; }
        
        
        .btn-maps { 
            background: #ea4335; 
            color: white !important; 
            text-decoration: none;
            margin-top: 5px;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            padding:10px 15px;
            border-radius:10px;
        }

        .badge-meja{
            background:#ffe5e5;
            color:#8b1e2d;
            padding:6px 12px;
            border-radius:12px;
            font-weight:600;
            font-size:13px;
            display: inline-block;
        }
        
      .aksi-group {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    align-items: center;
}

/* base button style (PILL SOFT) */
.aksi-group button,
.aksi-group a {
    padding: 6px 12px;
    font-size: 12.5px;
    font-weight: 600;
    border-radius: 999px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    text-decoration: none;
    border: 1px solid transparent;
    transition: 0.2s ease;
    white-space: nowrap;
}

/* DETAIL (abu kebiruan soft) */
/* ICON */

/* =========================
   DETAIL (slate / abu modern)
========================= */
/* DETAIL (neutral / slate) */
.btn-detail {
    color: #334155;
    background-color: #eef2f7;
    border: 1px solid #d6dee8;
    font-weight: 600;
}

.btn-detail:hover {
    background-color: #e2e8f0;
}

/* BUKTI / QRIS (orange soft premium) */
.btn-bukti {
    color: #d35400;
    background-color: #fff1e6;
    border: 1px solid #ffd2b3;
    font-weight: 600;
}

.btn-bukti:hover {
    background-color: #ffe1cc;
}

/* BAYAR (blue trust) */
.btn-bayar {
    color: #1e40af;
    background-color: #e8f0ff;
    border: 1px solid #b6ccff;
    font-weight: 600;
}

.btn-bayar:hover {
    background-color: #d6e4ff;
}

/* PROSES (violet workflow) */
.btn-proses {
    color: #5b21b6;
    background-color: #f1e9ff;
    border: 1px solid #d8c2ff;
    font-weight: 600;
}

.btn-proses:hover {
    background-color: #e6dbff;
}

/* SELESAI (green success) */
.btn-selesai {
    color: #166534;
    background-color: #e6f7ed;
    border: 1px solid #a7e3bf;
    font-weight: 600;
}

.btn-selesai:hover {
    background-color: #d1f2df;
}/* =========================
   BADGE DELIVERY
========================= */
.badge-delivery {
    background: #e0f2fe;
    color: #0369a1;
    padding: 6px 12px;
    border-radius: 12px;
    font-weight: 600;
    font-size: 13px;
    display: inline-block;
}

/* =========================
   BADGE METODE
========================= */
.badge-metode {
    display: inline-block;
    padding: 5px 10px;
    background: #f3f4f6;
    color: #1f2937;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
}

/* QRIS badge */
.badge-qris {
    background: #e0f2fe;
    color: #0369a1;
}

/* =========================
   ALAMAT DELIVERY
========================= */
.alamat-delivery-box {
    font-size: 12px;
    color: #4b5563;
    max-width: 200px;
    word-wrap: break-word;
    margin-top: 4px;
    line-height: 1.4;
}
        .table-footer{
            display:flex;
            justify-content:space-between;
            align-items:center;
            padding:15px 20px;
            font-size:14px;
            color:#6b7280;
        }
        .page-btn.disabled{
    pointer-events:none;
    opacity:.4;
    cursor:not-allowed;
}

        .pagination{
            display:flex;
            align-items:center;
            gap:8px;
        }

        .page-btn,
        .page-number{
            width:38px;
            height:38px;
            display:flex;
            align-items:center;
            justify-content:center;
            border-radius:10px;
            text-decoration:none;
            border:1px solid #e5e7eb;
            background:white;
            color:#64748b;
            transition:.2s;
        }

        .page-number.active{
            background:#8b1e2d;
            color:white;
            border-color:#8b1e2d;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 9999;
            padding-top: 50px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.8);
            backdrop-filter: blur(5px);
        }
        .modal-content {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 450px;
            border-radius: 12px;
            animation: zoom 0.3s ease-in-out;
        }

        /* =========================
   MODAL DETAIL PESANAN
========================= */

.modal-detail{
    display:none;
    position:fixed;
    inset:0;
    z-index:9998;

    background:rgba(0,0,0,.55);

    justify-content:center;
    align-items:center;

    padding:20px;
}

.modal-detail-content{
    width:100%;
    max-width:850px;
    max-height:90vh;

    overflow-y:auto;

    background:#fff;

    border-radius:18px;

    padding:24px;

    box-shadow:0 15px 40px rgba(0,0,0,.15);
}

.modal-header-premium {
    background: linear-gradient(135deg, #7a1a26, #a32232);
    color: white;
    padding: 18px 22px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-header-premium h3 {
    font-size: 18px;
    font-weight: 700;
}

.close-detail-modal {
    font-size: 26px;
    cursor: pointer;
    color: rgba(255,255,255,0.8);
    transition: 0.2s;
}

.close-detail-modal:hover {
    color: white;
    transform: scale(1.1);
}

/* =========================
   CARD
========================= */

.detail-card {
    background: #f8fafc;
    border: 1px solid #eef2f7;
    border-radius: 14px;
    padding: 16px;
    margin: 14px 18px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.04);
    transition: 0.2s;
}

.detail-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.06);
}

.detail-card h4{
    margin-bottom:12px;

    
    font-weight:700;

    

    position: relative;
    font-size: 14px;
    letter-spacing: 0.5px;
    color: #374151;
}



.detail-card h4::after {
    content: "";
    display: block;
    margin-top: 6px;
    height: 1px;
    background: linear-gradient(to right, #e5e7eb, transparent);
}

/* =========================
   DETAIL ROW
========================= */
.detail-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    border-bottom: 1px dashed #e5e7eb;
    font-size: 14px;
}

.detail-row span {
    color: #6b7280;
}

.detail-row strong {
    color: #111827;
    font-weight: 600;
}

.cash-box {
    margin-top: 12px;
    padding: 14px;
    background: #fff7ed;
    border: 1px solid #fed7aa;
    border-radius: 12px;
}

.map-box {
    margin-top: 10px;
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid #e5e7eb;
}

#map-detail {
    height: 280px;
    width: 100%;
}

/* =========================
   ITEM TABLE
========================= */

/* =========================
   RECEIPT STYLE TABLE
========================= */


/* =========================
   FORM
========================= */

.form-group{
    margin-top:15px;
}

.form-group label{
    display:block;

    margin-bottom:6px;

    font-size:14px;
    font-weight:600;

    color:#374151;
}

.form-group input{
    width:100%;

    padding:12px;

    border:1px solid #d1d5db;

    border-radius:10px;

    outline:none;
}

.form-group input:focus{
    border-color:#8b1e2d;
    box-shadow:0 0 0 3px rgba(139,30,45,.1);
}


/* =========================
   QRIS IMAGE
========================= */

.bukti-qris{
    width:100%;

    max-height:350px;

    object-fit:contain;

    border-radius:12px;

    border:1px solid #e5e7eb;
}


/* =========================
   INVOICE BUTTON
========================= */

.btn-invoice,
.btn-print{
    padding:10px 15px;

    border:none;

    border-radius:10px;

    cursor:pointer;

    font-weight:600;

    margin-right:8px;
}

.btn-invoice{
    background:#e5e7eb;
    color:#111827;
}

.btn-print{
    background:#22c55e;
    color:white;
}


/* =========================
   QRIS ACTION
========================= */

.btn-setuju{
    background:#22c55e;
    color:white;
}

.btn-tolak{
    background:#dc2626;
    color:white;
}


/* =========================
   FOOTER
========================= */

.modal-footer {
    background: #f8fafc;
    padding: 14px;
    border-top: 1px solid #e5e7eb;
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.modal-footer button {
    border-radius: 10px;
    padding: 10px 14px;
    font-weight: 600;
    font-size: 13px;
    transition: 0.2s;
    border: none;
}

.modal-footer button:hover {
    transform: translateY(-2px);
    opacity: 0.9;
}

.status-pill {
    padding: 4px 10px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
    background: #f1f5f9;
    color: #334155;
}

#toastContainer{
    position:fixed;
    top:20px;
    right:20px;
    z-index:99999;
}

.toast{
    min-width:250px;
    padding:12px 16px;
    margin-bottom:10px;
    border-radius:8px;
    color:#fff;
    font-weight:600;
    box-shadow:0 4px 12px rgba(0,0,0,.15);
    animation:slideIn .3s ease;
}

.toast-success{
    background:#22c55e;
}

.toast-error{
    background:#ef4444;
}

@keyframes slideIn{
    from{
        opacity:0;
        transform:translateX(50px);
    }
    to{
        opacity:1;
        transform:translateX(0);
    }
}/* =========================
   RESPONSIVE
========================= */

@media (max-width:768px){

    .modal-detail-content{
        max-height:95vh;
        padding:16px;
    }

    .detail-row{
        flex-direction:column;
        gap:5px;
    }

    .detail-row strong{
        text-align:left;
    }

    .modal-footer{
        flex-direction:column;
    }

    .modal-footer button{
        width:100%;
    }
}

.detail-item-table{
    width:100%;
    border-collapse:collapse;
    margin-top:8px;
    background:transparent;
    border:none;
    box-shadow:none;
}

.detail-item-table td{
    padding:12px 0;
    border-bottom:1px dashed #d1d5db;
}



.detail-item-table td:nth-child(1) {
    font-weight: 600;
    color: #111827;
}

.detail-item-table td:nth-child(3) {
    text-align: right;
    font-weight: 700;
    color: #7a1a26;
}

.item-nama{
    font-weight:600;
    color:#111827;
    margin-bottom:4px;
}

.item-pedas{
    display:inline-block;
    margin-top:4px;
    padding:4px 10px;

    background:#fee2e2;
    color:#dc2626;

    border-radius:999px;
    font-size:12px;
    font-weight:600;
}

.item-catatan{
    margin-top:6px;

    color:#6b7280;
    font-size:13px;
    line-height:1.4;

    font-style:italic;
}

.item-qty{
    text-align:center;
    font-weight:600;
}

.item-harga{
    text-align:right;
    font-weight:700;
    color:#8b1e2d;
}
        @keyframes zoom {
            from {transform:scale(0)}
            to {transform:scale(1)}
        }
        .close-modal {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
        }
    </style>
</head>
<body>
<?php 
$halaman = "pesanan"; 
include "../../components/sidebar.php"; 

$today = date('Y-m-d');

function getCount($conn, $status, $type = 'status') {
    global $today;
    $sql = "SELECT COUNT(*) as total FROM pesanan WHERE DATE(tanggal) = '$today'";
    
    if ($type == 'status') {
        $sql .= " AND LOWER(TRIM(status_pesanan)) = '$status'";
    }
    
    $res = mysqli_query($conn, $sql);
    $data = mysqli_fetch_assoc($res);
    return $data['total'] ?? 0;
}

$count_pending   = getCount($conn, 'pending');
$count_dibayar   = getCount($conn, 'dibayar');
$count_proses    = getCount($conn, 'diproses');
$count_selesai   = getCount($conn, 'selesai');
$count_batal     = getCount($conn, 'dibatalkan');
?>

<div class="main-content">
    <div class="page-header">
        <h1>Manajemen Pesanan</h1>
        <p>Kelola seluruh pesanan pelanggan mulai dari konfirmasi pembayaran hingga pesanan selesai.</p>
    </div>

    <div class="summary-grid">
        <div class="summary-card">
            <div class="summary-icon"><i data-feather="clock"></i></div>
            <div>
                <span>Menunggu Bayar</span>
                <h3><?= $count_pending; ?></h3>
                <small>Hari ini</small>
            </div>
        </div>
        <div class="summary-card">
            <div class="summary-icon"><i data-feather="credit-card"></i></div>
            <div>
                <span>Siap Diproses</span>
                <h3><?= $count_dibayar; ?></h3>
                <small>Hari ini</small>
            </div>
        </div>
        <div class="summary-card">
            <div class="summary-icon"><i data-feather="coffee"></i></div>
            <div>
                <span>Diproses</span>
                <h3><?= $count_proses; ?></h3>
                <small>Hari ini</small>
            </div>
        </div>
        <div class="summary-card">
            <div class="summary-icon"><i data-feather="check-circle"></i></div>
            <div>
                <span>Selesai</span>
                <h3><?= $count_selesai; ?></h3>
                <small>Hari ini</small>
            </div>
        </div>
        <div class="summary-card">
            <div class="summary-icon"><i data-feather="x-circle"></i></div>
            <div>
                <span>Dibatalkan</span>
                <h3><?= $count_batal; ?></h3>
                <small>Hari ini</small>
            </div>
        </div>
    </div>

    <div class="filter-bar">
    <div class="filter-group">
        <input 
            type="text" 
            id="searchInput"
            placeholder="Cari nomor pesanan / nama pelanggan..."
        >

        <select id="kategoriSelect">
    <option value="">Semua Status</option>
    <option value="menunggu pembayaran">Menunggu Pembayaran</option>
    <option value="siap diproses">Siap Diproses</option>
    <option value="sedang diproses">Sedang Diproses</option>
    
</select>
    </div>
</div>

    <div class="table-wrapper">
        <table>       
            <thead>
                <tr>
                    <th>Pelanggan</th>
                    <th>Tipe</th>
                    <th>Metode</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
                <tbody>
                <?php
               $perPage = 5;

$page = isset($_GET['page'])
    ? (int)$_GET['page']
    : 1;

$totalData = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) AS total
         FROM pesanan
         WHERE LOWER(TRIM(status_pesanan))
         IN ('pending','dibayar','diproses')"
    )
)['total'];

$totalPage = max(1, ceil($totalData / $perPage));

if($page < 1) $page = 1;
if($page > $totalPage) $page = $totalPage;

$offset = ($page - 1) * $perPage;

$startData = ($totalData == 0)
    ? 0
    : $offset + 1;

$endData = min(
    $offset + $perPage,
    $totalData
);

$sql = "SELECT p.*, pl.nama_pelanggan
        FROM pesanan p
        JOIN pelanggan pl
            ON p.id_pelanggan = pl.id_pelanggan
        WHERE LOWER(TRIM(p.status_pesanan))
        IN ('pending','dibayar','diproses')";
                
                $search = $_GET['search'] ?? '';
                $status = $_GET['status'] ?? '';

                if (!empty($status)) {
                    $sql .= " AND LOWER(TRIM(p.status_pesanan)) = '" . mysqli_real_escape_string($conn, $status) . "'";
                }

                if (!empty($search)) {
                    $search = mysqli_real_escape_string($conn, $search);
                    $sql .= " AND (p.nomor_pesanan LIKE '%$search%' OR pl.nama_pelanggan LIKE '%$search%')";
                }

                $sql .= "
    ORDER BY p.id_pesanan DESC
    LIMIT $perPage
    OFFSET $offset
";
                $query = mysqli_query($conn, $sql);
            
            


                        


$markers = [];

if (mysqli_num_rows($query) > 0) {

    while ($row = mysqli_fetch_assoc($query)) {

        $id_p = $row['id_pesanan'];
        $status = strtolower(trim($row['status_pesanan']));
        $metode = strtoupper($row['metode_pembayaran'] ?? 'KASIR');
        $jenis_pesanan = strtolower($row['jenis_pesanan'] ?? 'dinein');

        if (!empty($row['latitude']) && !empty($row['longitude'])) {
            $markers[] = [
                "lat" => $row['latitude'],
                "lng" => $row['longitude'],
                "nomor" => $row['nomor_pesanan'],
                "jenis" => $row['jenis_pesanan'],
                "alamat" => $row['alamat']
            ];
        }


        ?>
                <tr id="row_pesanan_<?= $id_p ?>">
    <td>
        <div class="pesanan-info">
                <div class="pelanggan-icon">
                <i data-feather="user"></i>
                </div>
                <div>

                    <span class="nomor-pesanan">
                        <?= $row['nomor_pesanan']; ?>
                    </span>

    
                <div class="nama-pelanggan">
                    <?= htmlspecialchars($row['nama_pelanggan']); ?>
                </div>
                    <span class="tanggal-pesanan">
                        <?= date('d M Y H:i', strtotime($row['tanggal'])); ?>
                    </span>
                </div>

            


            

        </div>
    </td>

    <td>

        <?php if($jenis_pesanan == 'delivery'): ?>

            <span class="tipe-badge delivery">
                Delivery
            </span>

        <?php elseif(!empty($row['id_meja'])): ?>

            <span class="tipe-badge dinein">
                Dine In
            </span>

        <?php else: ?>

            <span class="tipe-badge takeaway">
                Take Away
            </span>

        <?php endif; ?>

    </td>

    <td>
        <span class="metode-badge <?= strtolower($metode); ?>">
            <?= $metode; ?>
        </span>
    </td>

    <td>
        <div class="total-harga">
            Rp <?= number_format($row['total_harga'],0,',','.'); ?>
        </div>

        <?php if($jenis_pesanan == 'delivery' && !empty($row['ongkir'])): ?>
            <small>
                Ongkir Rp <?= number_format($row['ongkir'],0,',','.'); ?>
            </small>
        <?php endif; ?>
    </td>

    <td>

        <?php
        $labelStatus = '';

        switch($status){

            case 'pending':
                $labelStatus = 'Menunggu Pembayaran';
            break;

            case 'dibayar':
                $labelStatus = 'Siap Diproses';
            break;

            case 'diproses':
                $labelStatus = 'Sedang Diproses';
            break;

            case 'selesai':
                $labelStatus = 'Selesai';
            break;

            default:
                $labelStatus = ucfirst($status);
        }
        ?>

        <span
        id="status_<?= $id_p ?>"
        class="status-badge <?= $status ?>">
        <?= $labelStatus ?>
    </span>
    </td>

    <td>

        <div class="aksi-group">

            <button
                type="button"
                class="btn-detail"
                onclick="bukaDetail(<?= $id_p ?>)">
                   <i data-feather="eye"></i>
                Detail
            </button>

            <?php if($status == 'pending'): ?>

                <?php if($metode == 'QRIS'): ?>

                    <button
                        class="btn-bukti"
                        onclick="bukaDetail(<?= $id_p ?>)">
                        Verifikasi QRIS
                    </button>

                <?php else: ?>

                    <button
                        class="btn-bayar"
                        onclick="bukaDetail(<?= $id_p ?>)">
                        Terima Pembayaran
                    </button>

                <?php endif; ?>

            <?php elseif($status == 'dibayar'): ?>

                <a
                    href="konfirmasi_proses.php?id=<?= $id_p ?>&status=diproses"
                    class="btn-proses">
                    Mulai Proses
                </a>

            <?php elseif($status == 'diproses'): ?>

                <a
                    href="konfirmasi_proses.php?id=<?= $id_p ?>&status=selesai"
                    class="btn-selesai">
                    Selesaikan
                </a>

            <?php endif; ?>

        </div>

    </td>
</tr>
                <?php 
                        } 
                    } else {
                        echo "<tr><td colspan='7' style='text-align:center;'>Tidak ada pesanan aktif saat ini.</td></tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>

    <div class="table-footer">

    <div>
        Menampilkan <?= $startData ?>
        - <?= $endData ?>
        dari <?= $totalData ?> pesanan
    </div>

    <div class="pagination">

        <a
            href="?page=<?= $page - 1 ?>"
            class="page-btn <?= ($page <= 1) ? 'disabled' : '' ?>">
            <i data-feather="chevron-left"></i>
        </a>

        <span class="page-number active">
            <?= $page ?>
        </span>

        <a
            href="?page=<?= $page + 1 ?>"
            class="page-btn <?= ($page >= $totalPage) ? 'disabled' : '' ?>">
            <i data-feather="chevron-right"></i>
        </a>

    </div>

</div>


<div id="modalBukti" class="modal">
    <span class="close-modal" onclick="tutupBukti()">&times;</span>
    <img class="modal-content" id="imgBukti">
</div>
<div class="modal-detail" id="modalDetail">

    <div class="modal-detail-content">
        <input type="hidden" id="detail_id_pesanan">

        <!-- Header -->
        <div class="modal-header-premium">
            <h3>Detail Pesanan</h3>
            <span class="close-detail-modal" onclick="tutupDetail()">&times;</span>
        </div>

        <!-- Informasi Pesanan -->
        <div class="detail-card">

            <h4>Informasi Pesanan</h4>
            
            
            <div class="detail-row">
                <span>Status</span>
                <strong id="detail_status">-</strong>
            </div>

            <div class="detail-row">
                <span>No Pesanan</span>
                <strong id="detail_nomor_pesanan">-</strong>
            </div>

            <div class="detail-row">
                <span>Pelanggan</span>
                <strong id="detail_pelanggan">-</strong>
            </div>

            <div class="detail-row">
                <span>Tanggal</span>
                <strong id="detail_tanggal">-</strong>
            </div>

            <div class="detail-row">
                <span>Tipe</span>
                <strong id="detail_tipe">-</strong>
            </div>

            <div class="detail-row">
                <span>Meja</span>
                <strong id="detail_meja">-</strong>
            </div>
        </div>

        <!-- Item Pesanan -->
        <div class="detail-card">

            <h4>Item Pesanan</h4>

           

    

    <table class="detail-item-table">
        <tbody id="detail_item_container">
        </tbody>
    </table>

</div>
        

        <!-- Pembayaran -->
        <div class="detail-card">

            <h4>Pembayaran</h4>

            <div class="detail-row">
                <span>Metode</span>
                <strong id="detail_metode">
                    -
                </strong>
            </div>

            <div class="detail-row">
                <span>Total</span>
                <strong id="detail_total">
                    Rp0
                </strong>
            </div>
            <div id="section_uang_tunai" class="cash-box">
            
                <div class="form-group">
                    <label>Uang Diterima</label>
                    <input type="text" id="uang_pelanggan" oninput="hitungKembalian()">
                </div>
    
                <div class="detail-row">
                    <span>Kembalian</span>
                    <strong id="kembalian_preview">Rp0</strong>
                </div>
        </div>

        </div>

        <!-- QRIS -->
        <div id="section_qris" class="detail-card">

            <h4>Bukti Pembayaran QRIS</h4>

            <img src=""   id="detail_bukti_qris" class="bukti-qris">

        </div>

        <!-- Delivery -->
        <div id="section_delivery" class="detail-card">

            <h4>Informasi Delivery</h4>


            <div class="detail-row">
                <span>Alamat</span>
                <strong id="detail_alamat">
                    -
                </strong>
            </div>

            <div class="detail-row">
                <span>No HP</span>
                <strong id="detail_no_hp">
                    -
                </strong>
            </div>
            
             <div class="map-box">
                <div id="map-detail"></div>
            </div>

            <a href="javascript:void(0)"
   id="detail_maps"
   class="btn-maps">
   Lihat di Google Maps
</a>

        </div>

        <!-- Invoice -->
        <!-- Invoice -->
        <div id="section_invoice" class="detail-card">

            <h4>Invoice</h4>

            <div id="invoiceContainer" style="display:none;"></div>

            <button id="btnPreviewInvoice" class="btn-invoice">
                Preview Invoice
            </button>

            <button id="btnPrintInvoice" class="btn-print">
                Cetak Invoice
            </button>

            <button onclick="downloadInvoicePDF()" class="btn-invoice">
                Download PDF
            </button>

        </div>

        <!-- Footer -->
        <div class="modal-footer">

            <button id="footer_btn_bayar" class="btn-bayar">
                Konfirmasi Pembayaran
            </button>

            <button id="footer_btn_batal" class="btn-batal">
                Batalkan
            </button>

            <button id="footer_btn_setuju" class="btn-setuju">
                Setujui Pembayaran
            </button>

            <button id="footer_btn_tolak" class="btn-tolak">
                Tolak Pembayaran
            </button>

            <button id="footer_btn_proses" class="btn-proses">
                Mulai Proses
            </button>

            <button id="footer_btn_selesai" class="btn-selesai">
                Selesaikan
            </button>

        </div>

    </div>

</div>
<div id="toastContainer" class="toast">

</div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
let detailMap = null;
let detailMarker = null;
const STATUS_ENGINE = {
    pending: {
        buttons: ["bayar", "batal"]
    },
    dibayar: {
        buttons: ["proses", "tolak"]
    },
    diproses: {
        buttons: ["selesai"]
    },
    selesai: {
        buttons: []
    },
    dibatalkan: {
        buttons: []
    }
};

feather.replace();

function formatRupiah(elemen) {
    let angka = elemen.value.replace(/[^,\d]/g, '').toString();
    let split = angka.split(',');
    let sisa  = split[0].length % 3;
    let rupiah = split[0].substr(0, sisa);
    let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
        let separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    elemen.value = rupiah;
}

async function prosesBayar(id, total) {

    let inputField = document.getElementById('input_uang_' + id);
    let uangMentah = inputField.value.replace(/\./g, '');

    if (uangMentah === "" || parseInt(uangMentah) < parseInt(total)) {
        alert("Jumlah uang tidak valid atau kurang dari total harga!");
        return;
    }

    try {
        let res = await fetch("update_pembayaran_cash.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `id=${id}&uang=${uangMentah}&status=dibayar`
        });

        let data = await res.json();

        if (data.status === "success") {
            alert("Pembayaran berhasil dikonfirmasi");

            // refresh modal
            bukaDetail(id);

        } else {
            showToast(data.message, "error");
        }

    } catch (err) {
        console.error(err);
        alert("Gagal proses pembayaran");
    }
}
function bukaBukti(src) {
    document.getElementById("modalBukti").style.display = "block";
    document.getElementById("imgBukti").src = src;
}

function tutupBukti() {
    document.getElementById("modalBukti").style.display = "none";
}

function formatTanggal(tanggal) {
    let date = new Date(tanggal);

    return date.toLocaleString("id-ID", {
        day: "2-digit",
        month: "short",
        year: "numeric",
        hour: "2-digit",
        minute: "2-digit"
    });
}

function formatStatus(status) {
    switch(status) {

        case "pending":
            return "Menunggu Pembayaran";

        case "dibayar":
            return "Siap Diproses";

        case "diproses":
            return "Sedang Diproses";

        case "selesai":
            return "Selesai";

        case "dibatalkan":
            return "Dibatalkan";

        default:
            return status;
    }
}




function generateInvoiceHTML(data) {

const RESTO_NAME = "SAGALALADA RESTAURANT";
const RESTO_ADDRESS = "Jalan Contoh No. 123";

    let p = data.pesanan || data.data?.pesanan;
    let items = data.items || data.data?.items;

    console.log("RAW DATA:", JSON.stringify(data, null, 2));

    if (!p || !items) {
        console.error("STRUKTUR DATA SALAH:", data);
        return `<p style="color:red;">Data invoice tidak valid</p>`;
    }

    let html = `
<div style="
    font-family: 'Segoe UI', Tahoma, sans-serif;
    width: 380px;
    padding: 24px;
    border-radius: 14px;
    background: #ffffff;
    border: 1px solid #e5e7eb;
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
">

    <!-- HEADER -->
    <div style="text-align:center; margin-bottom:14px;">
        <div style="font-size:18px; font-weight:700; letter-spacing:1px;">
            ${RESTO_NAME}
        </div>
        <div style="font-size:12px; color:#6b7280;">
            ${RESTO_ADDRESS}
        </div>
    </div>

    <div style="border-top:1px dashed #ddd; margin:10px 0;"></div>

    <!-- INFO -->
    <div style="font-size:12px; color:#374151; line-height:1.6;">
        <div><b>No:</b> ${p.nomor_pesanan}</div>
        <div><b>Pelanggan:</b> ${p.nama_pelanggan}</div>
        <div><b>Tanggal:</b> ${formatTanggal(p.tanggal)}</div>
    </div>

    <div style="border-top:1px dashed #ddd; margin:10px 0;"></div>

    <!-- ITEM -->
  <!-- ITEM -->
<table style="width:100%; font-size:12px; border-collapse:collapse;">
`;

items.forEach(item => {
    html += `
        <tr>
            <td  color:#111827;">
                ${item.nama_menu}
            </td>

            <td style="text-align:center; color:#374151;">
                x${item.jumlah}
            </td>

            <td style="text-align:right; font-weight:600; color:#111827;">
                Rp ${Number(item.subtotal).toLocaleString("id-ID")}
            </td>
        </tr>
    `;
});
   html += `
    </table>

    <div style="border-top:1px dashed #ddd; margin:12px 0;"></div>

    <div style="font-size:12px; color:#374151;">
        <div style="display:flex; justify-content:space-between;">
            <span>Total</span>
            <b>Rp ${Number(p.total_harga ?? p.total ?? 0).toLocaleString("id-ID")}</b>
        </div>

        <div style="display:flex; justify-content:space-between; margin-top:4px;">
            <span>Uang Diterima</span>
            <span>Rp ${Number(p.uang_diterima ?? 0).toLocaleString("id-ID")}</span>
        </div>

        <div style="display:flex; justify-content:space-between; margin-top:4px;">
            <span>Kembalian</span>
            <span>
                Rp ${
                    Math.max(
                        (p.uang_diterima ?? 0) - (p.total_harga ?? p.total ?? 0),
                        0
                    ).toLocaleString("id-ID")
                }
            </span>
        </div>
    </div>

    <div style="
        text-align:center;
        margin-top:14px;
        font-size:12px;
        color:#6b7280;
    ">
        Terima kasih 
    </div>

</div>
`;
    return html;
}

/* ======================
   MODAL DETAIL
====================== */

async function bukaDetail(id) {
    document.getElementById("modalDetail").style.display = "flex";

    // =========================
    // RESET SEMUA BUTTON MODAL
    // =========================

    // reset isi modal
    document.getElementById("detail_nomor_pesanan").innerText = "-";
    document.getElementById("detail_pelanggan").innerText = "-";
    document.getElementById("detail_tanggal").innerText = "-";
    document.getElementById("detail_tipe").innerText = "-";
    document.getElementById("detail_meja").innerText = "-";
    document.getElementById("detail_metode").innerText = "-";
    document.getElementById("detail_total").innerText = "Rp0";
        
    document.getElementById("detail_item_container").innerHTML =
        `<tr><td colspan="3">Memuat data...</td></tr>`;

    try {
        let res = await fetch("get_detail_pesanan.php?id=" + id);
        let data = await res.json();

        if (data.status !== "success") {
            showToast(data.message, "error");
            return;
        }

        let p = data.data.pesanan;
        console.log("DATA PESANAN:", p);
        console.log("NO HP:", p.no_hp);
        document.getElementById("detail_id_pesanan").value =
    p.id;
        let status = p.status;
        let items = data.data.items;
        console.log(items);
        renderModalButtons(status, p.metode);

        // =========================
        // ISI DATA PESANAN UTAMA
        // =========================
        document.getElementById("detail_status").innerText = formatStatus(status);
        document.getElementById("detail_nomor_pesanan").innerText = p.nomor_pesanan;
        document.getElementById("detail_pelanggan").innerText = p.nama_pelanggan;
        document.getElementById("detail_tanggal").innerText =    formatTanggal(p.tanggal);
        document.getElementById("detail_tipe").innerText = p.tipe_pesanan;
        document.getElementById("detail_metode").innerText = p.metode;

        if (p.metode === "QRIS") {
            document.getElementById("section_uang_tunai").style.display = "none";
        } else {
            document.getElementById("section_uang_tunai").style.display = "block";
        }

        document.getElementById("detail_total").innerText =
            "Rp " + Number(p.total).toLocaleString("id-ID");

        document.getElementById("uang_pelanggan").value =
    p.uang_diterima ?? "";

    hitungKembalian();

        document.getElementById("detail_meja").innerText =
            p.meja ? "Meja " + p.meja : "-";

        // =========================
        // RENDER ITEM PESANAN
        // =========================
       let html = "";

items.forEach(item => {

    let infoTambahan = "";

    if (item.pedas && item.pedas !== "Original") {
        infoTambahan += `
            <div class="item-pedas">
                 ${item.pedas}
            </div>
        `;
    }

    if (item.catatan && item.catatan.trim() !== "") {
        infoTambahan += `
            <div class="item-catatan">
                Catatan: ${item.catatan}
            </div>
        `;
    }

    html += `
        <tr>
            <td>
                <div class="item-nama">
                    ${item.nama_menu}
                </div>

                ${infoTambahan}
            </td>

            <td style="text-align:center;">
                x${item.jumlah}
            </td>

            <td>
                Rp ${Number(item.subtotal).toLocaleString("id-ID")}
            </td>
        </tr>
    `;
});
        console.log(html);
        document.getElementById("detail_item_container").innerHTML = html;

        // =========================
        // CONDITIONAL SECTION
        // =========================

        // DELIVERY
        if (p.tipe_pesanan === "delivery") {
            document.getElementById("section_delivery").style.display = "block";
            document.getElementById("detail_alamat").innerText = p.alamat || "-";
            document.getElementById("detail_no_hp").innerText = p.no_hp || "-";
        } else {
            document.getElementById("section_delivery").style.display = "none";
        }

        // QRIS
        if (p.metode === "QRIS" && p.bukti) {

    document.getElementById("section_qris").style.display = "block";

    document.getElementById("detail_bukti_qris").src =
        "../../../pelanggan/upload/bukti/" + p.bukti;

} else {

    document.getElementById("section_qris").style.display = "none";

}

        let lat = p.latitude;
let lng = p.longitude;
document.getElementById("detail_maps").onclick = function () {

    if (!lat || !lng) {
        alert("Lokasi tidak tersedia");
        return;
    }

    window.open(
        `https://www.google.com/maps/dir/?api=1&destination=${lat},${lng}`,
        "_blank"
    );
};

if (lat && lng) {

    setTimeout(() => {

        if (detailMap !== null) {
            detailMap.remove();
            detailMap = null;
        }

        detailMap = L.map('map-detail').setView([lat, lng], 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(detailMap);

        detailMarker = L.marker([lat, lng])
            .addTo(detailMap)
            .bindPopup("Lokasi Pesanan")
            .openPopup();

        setTimeout(() => {
            detailMap.invalidateSize();
        }, 200);

    }, 300);
}

    } catch (error) {
        console.error(error);
        showToast("Gagal mengambil data pesanan", "error");
    }

    
}

function renderModalButtons(status, metode) {

    const allButtons = [
        "bayar",
        "batal",
        "setuju",
        "tolak",
        "proses",
        "selesai"
    ];

    allButtons.forEach(btn => {
        let el = document.getElementById("footer_btn_" + btn);

        if (el) {
            el.style.display = "none";
        }
    });

    if (status === "pending") {

        if (metode === "QRIS") {

            document.getElementById("footer_btn_setuju")
                .style.display = "inline-block";

            document.getElementById("footer_btn_tolak")
                .style.display = "inline-block";
        }
        else {

            document.getElementById("footer_btn_bayar")
                .style.display = "inline-block";

            document.getElementById("footer_btn_batal")
                .style.display = "inline-block";
        }

        return;
    }

    let config = STATUS_ENGINE[status];

    if (!config) return;

    config.buttons.forEach(btn => {

        let el = document.getElementById(
            "footer_btn_" + btn
        );

        if (el) {
            el.style.display = "inline-block";
        }
    });
}

function tutupDetail() {
    document.getElementById("modalDetail").style.display = "none";
    document.getElementById("invoiceContainer").innerHTML = "";
document.getElementById("invoiceContainer").style.display = "none";
}

function hitungKembalian() {

    let uang = document.getElementById("uang_pelanggan").value;
    let totalText = document.getElementById("detail_total").innerText;

    let total = parseInt(totalText.replace(/[^0-9]/g, ""));
    let bayar = parseInt(uang.replace(/[^0-9]/g, ""));

    if (isNaN(bayar)) {
        document.getElementById("kembalian_preview").innerText = "Rp0";
        return;
    }

    let kembali = bayar - total;

    document.getElementById("kembalian_preview").innerText =
        "Rp " + (kembali >= 0 ? kembali.toLocaleString("id-ID") : 0);
}

async function konfirmasiPembayaran() {

    let id = document.getElementById("detail_id_pesanan").value;
    let uang = document.getElementById("uang_pelanggan").value;

    uang = uang.replace(/[^0-9]/g, "");

    if (!uang) {
        alert("Masukkan uang pelanggan!");
        return;
    }

    try {
        let res = await fetch("update_pembayaran_cash.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `id=${id}&uang=${uang}&status=dibayar`
        });

        let data = await res.json();

        if (data.status === "success") {
            alert("Pembayaran berhasil dikonfirmasi");
            bukaDetail(id); // refresh modal
        } else {
            showToast(data.message, "error");
        }

    } catch (err) {
        console.error(err);
        alert("Gagal proses pembayaran");
    }
}
async function actionUpdateStatus(id, statusBaru) {

    try {
        let res = await fetch("update_status_pesanan.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `id=${id}&status=${statusBaru}`
        });

        let data = await res.json();

        if (data.status === "success") {

            showToast("Status berhasil diupdate", "success");

            // update badge di tabel (kalau ada)
            let badge = document.getElementById("status_" + id);

            if (badge) {
                badge.className = "status-badge " + statusBaru;
                badge.innerText = formatStatus(statusBaru);
            }

            bukaDetail(id); // refresh modal

        } else {
            showToast(data.message, "error");
        }

    } catch (error) {
        console.error(error);
        showToast("Gagal update status", "error");
    }
}
window.onclick = function(event) {

    let modalBukti = document.getElementById("modalBukti");
    let modalDetail = document.getElementById("modalDetail");

    if (event.target == modalBukti) {
        modalBukti.style.display = "none";
    }

    if (event.target == modalDetail) {
        modalDetail.style.display = "none";
    }

}
</script>
<script>
document.getElementById("searchInput").addEventListener("input", cariMenu);
document.getElementById("kategoriSelect").addEventListener("change", cariMenu);

function cariMenu() {
    let keyword = document.getElementById("searchInput").value.toLowerCase();
    let status = document.getElementById("kategoriSelect").value;

    let rows = document.querySelectorAll("tbody tr");

    rows.forEach(row => {
        let teksBaris = row.innerText.toLowerCase();
        let statusBaris = row.cells[4].innerText.trim().toLowerCase();

        let cocokSearch = teksBaris.includes(keyword);
        let cocokStatus = (status === "" || statusBaris === status);

        row.style.display = (cocokSearch && cocokStatus) ? "" : "none";
    });
}
function initModalEvents() {

    document.getElementById("footer_btn_bayar")
        .addEventListener("click", () => konfirmasiPembayaran());

    document.getElementById("footer_btn_batal")
        .addEventListener("click", () => {
            let id = document.getElementById("detail_id_pesanan").value;
            actionUpdateStatus(id, "dibatalkan");
        });

    document.getElementById("footer_btn_proses")
        .addEventListener("click", () => {
            let id = document.getElementById("detail_id_pesanan").value;
            actionUpdateStatus(id, "diproses");
        });

    document.getElementById("footer_btn_selesai")
        .addEventListener("click", () => {
            let id = document.getElementById("detail_id_pesanan").value;
            actionUpdateStatus(id, "selesai");
        });

    document.getElementById("footer_btn_tolak")
    .addEventListener("click", () => {
        let id = document.getElementById("detail_id_pesanan").value;
        actionUpdateStatus(id, "dibatalkan");
    });

    document.getElementById("footer_btn_setuju")
        .addEventListener("click", () => {
            let id = document.getElementById("detail_id_pesanan").value;
            actionUpdateStatus(id, "dibayar");
        });
}

window.addEventListener("DOMContentLoaded", function () {
    initModalEvents();
});

async function previewInvoice() {
    try {
        let id = document.getElementById("detail_id_pesanan").value;

        if (!id) {
            showToast("ID pesanan kosong", "error");
            return;
        }

        let res = await fetch("get_detail_pesanan.php?id=" + id);
        let data = await res.json();

        console.log("INVOICE DATA:", data);

        if (data.status !== "success") {
            showToast("Gagal load invoice", "error");
            return;
        }

        let html = generateInvoiceHTML(data);

        let container = document.getElementById("invoiceContainer");
        container.innerHTML = html;
        container.style.display = "block";

        showToast("Invoice siap dipreview", "success");

    } catch (err) {
        console.error(err);
        showToast("Error invoice: cek console", "error");
    }
}

function printInvoice() {

    let container = document.getElementById("invoiceContainer");

    if (!container || !container.innerHTML.trim()) {
        alert("Silakan preview invoice dulu");
        return;
    }

    let w = window.open("", "", "width=400,height=600");

    w.document.write(`
        <html>
            <head>
                <title>Print Invoice</title>
                <style>
                    body { font-family: Arial; padding: 20px; }
                </style>
            </head>
            <body onload="window.print()">
                ${container.innerHTML}
            </body>
        </html>
    `);

    w.document.close();
}

function downloadInvoicePDF() {

    let container = document.getElementById("invoiceContainer");

    if (!container || !container.innerHTML.trim()) {
        alert("Silakan preview invoice dulu");
        return;
    }

    let opt = {
        margin: 0.5,
        filename: 'invoice-pesanan.pdf',
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
    };

    html2pdf().set(opt).from(container).save();
}

function showToast(message, type = "success") {

    let toast = document.createElement("div");

    toast.className = "toast-message";
    toast.innerText = message;

    toast.style.position = "fixed";
    toast.style.bottom = "20px";
    toast.style.right = "20px";
    toast.style.padding = "12px 16px";
    toast.style.borderRadius = "8px";
    toast.style.color = "#fff";
    toast.style.zIndex = "9999";
    toast.style.fontSize = "14px";

    if (type === "success") {
        toast.style.background = "#22c55e";
    } else if (type === "error") {
        toast.style.background = "#ef4444";
    } else {
        toast.style.background = "#334155";
    }

    document.body.appendChild(toast);

    setTimeout(() => {
        toast.remove();
    }, 2500);
}
function setButtonLoading(id, loading = true) {

    let btn = document.getElementById(id);
    if (!btn) return;

    if (loading) {
        btn.disabled = true;
        btn.dataset.originalText = btn.innerText;
        btn.innerText = "Memproses...";
    } else {
        btn.disabled = false;
        btn.innerText = btn.dataset.originalText;
    }
}
window.addEventListener("DOMContentLoaded", function () {

    const btnPreview = document.getElementById("btnPreviewInvoice");
    const btnPrint = document.getElementById("btnPrintInvoice");

    if (btnPreview) {
        btnPreview.addEventListener("click", previewInvoice);
    }

    if (btnPrint) {
        btnPrint.addEventListener("click", printInvoice);
    }

});

</script>
</body>
</html>