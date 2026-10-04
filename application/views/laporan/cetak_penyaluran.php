<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$bulan_nama = [
    1 => 'Januari',
    2 => 'Februari',
    3 => 'Maret',
    4 => 'April',
    5 => 'Mei',
    6 => 'Juni',
    7 => 'Juli',
    8 => 'Agustus',
    9 => 'September',
    10 => 'Oktober',
    11 => 'November',
    12 => 'Desember'
];

$periode = 'Semua Periode';

if (!empty($filters['tanggal_mulai']) && !empty($filters['tanggal_selesai'])) {
    $periode = date('d/m/Y', strtotime($filters['tanggal_mulai'])) . ' - ' . date('d/m/Y', strtotime($filters['tanggal_selesai']));
} elseif (!empty($filters['bulan']) && !empty($filters['tahun'])) {
    $periode = ($bulan_nama[(int) $filters['bulan']] ?? $filters['bulan']) . ' ' . $filters['tahun'];
} elseif (!empty($filters['tahun'])) {
    $periode = 'Tahun ' . $filters['tahun'];
}

$jenis_zis = !empty($filters['jenis_zis'])
    ? ucfirst(strtolower($filters['jenis_zis']))
    : 'Semua Jenis ZIS';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= html_escape($title) ?></title>
    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/img/favicon.ico'); ?>">

    <style>
        @page {
            size: A4 portrait;
            margin: 12mm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            color: #111827;
            font-size: 12px;
            line-height: 1.5;
            background: #ffffff;
        }

        .container {
            width: 100%;
        }

        .header {
            text-align: center;
            margin-bottom: 18px;
        }

        .header h1 {
            margin: 0;
            font-size: 20px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .header h2 {
            margin: 2px 0 0;
            font-size: 15px;
            font-weight: 600;
        }

        .header p {
            margin: 4px 0 0;
            font-size: 11px;
            color: #4b5563;
        }

        .line {
            border-top: 2px solid #111827;
            margin: 12px 0 16px;
        }

        .info {
            width: 100%;
            margin-bottom: 16px;
            border-collapse: collapse;
        }

        .info td {
            padding: 3px 0;
            vertical-align: top;
        }

        .info td:first-child {
            width: 120px;
            font-weight: 600;
        }

        .summary {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
        }

        .summary td {
            border: 1px solid #d1d5db;
            padding: 9px 10px;
        }

        .summary-label {
            color: #4b5563;
            font-size: 10px;
        }

        .summary-value {
            margin-top: 2px;
            font-size: 14px;
            font-weight: 700;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
        }

        table.data th,
        table.data td {
            border: 1px solid #9ca3af;
            padding: 7px 6px;
        }

        table.data th {
            background: #f3f4f6;
            text-align: center;
            font-weight: 700;
        }

        table.data td {
            vertical-align: top;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .total-row td {
            font-weight: 700;
            background: #f9fafb;
        }

        .footer {
            margin-top: 28px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .footer-date {
            font-size: 11px;
            color: #4b5563;
        }

        .signature {
            width: 180px;
            text-align: center;
        }

        .signature-space {
            height: 65px;
        }

        .signature-name {
            font-weight: 700;
            border-bottom: 1px solid #111827;
            display: inline-block;
            min-width: 150px;
            padding-bottom: 2px;
        }

        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            border: 0;
            border-radius: 8px;
            background: #059669;
            color: #ffffff;
            padding: 10px 16px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
        }

        @media print {
            .print-button {
                display: none;
            }
        }

        @media screen {
            body {
                background: #e5e7eb;
                padding: 30px;
            }

            .container {
                max-width: 210mm;
                min-height: 297mm;
                margin: 0 auto;
                padding: 18mm;
                background: #ffffff;
                box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            }
        }
    </style>
</head>

<body>

<button type="button" class="print-button" onclick="window.print()">
    Cetak
</button>

<div class="container">

    <div class="header">
        <h1>MWCNU Kecamatan Ngasem</h1>
        <h2>Laporan Penyaluran Zakat, Infaq, dan Sedekah</h2>
        <p>ZIS Care</p>
    </div>

    <div class="line"></div>

    <table class="info">
        <tr>
            <td>Periode</td>
            <td>: <?= html_escape($periode) ?></td>
        </tr>
        <tr>
            <td>Jenis ZIS</td>
            <td>: <?= html_escape($jenis_zis) ?></td>
        </tr>
        <tr>
            <td>Tanggal Cetak</td>
            <td>: <?= date('d/m/Y H:i') ?></td>
        </tr>
    </table>

    <table class="summary">
        <tr>
            <td>
                <div class="summary-label">Jumlah Penyaluran</div>
                <div class="summary-value">
                    <?= count($data_penyaluran) ?>
                </div>
            </td>

            <td>
                <div class="summary-label">Total Dana Disalurkan</div>
                <div class="summary-value">
                    Rp <?= number_format((float) $total_penyaluran, 0, ',', '.') ?>
                </div>
            </td>
        </tr>
    </table>

    <table class="data">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="12%">Tanggal</th>
                <th width="15%">Kode</th>
                <th width="11%">Jenis ZIS</th>
                <th width="16%">Penerima</th>
                <th width="17%">Kategori</th>
                <th width="11%">Metode</th>
                <th width="13%">Nominal</th>
            </tr>
        </thead>

        <tbody>
            <?php if (!empty($data_penyaluran)): ?>

                <?php foreach ($data_penyaluran as $i => $row): ?>

                    <tr>
                        <td class="text-center">
                            <?= $i + 1 ?>
                        </td>

                        <td class="text-center">
                            <?= !empty($row->tanggal)
                                ? date('d/m/Y', strtotime($row->tanggal))
                                : '-' ?>
                        </td>

                        <td>
                            <?= html_escape($row->kode_penyaluran ?? '-') ?>
                        </td>

                        <td class="text-center">
                            <?= html_escape(
                                ucfirst(strtolower($row->jenis_zis ?? '-'))
                            ) ?>
                        </td>

                        <td>
                            <?= html_escape($row->nama_penerima ?? '-') ?>
                        </td>

                        <td>
                            <?= html_escape($row->kategori_penerima ?? '-') ?>
                        </td>

                        <td class="text-center">
                            <?= html_escape(
                                ucfirst(strtolower($row->metode_penyaluran ?? '-'))
                            ) ?>
                        </td>

                        <td class="text-right">
                            Rp <?= number_format(
                                (float) ($row->nominal ?? 0),
                                0,
                                ',',
                                '.'
                            ) ?>
                        </td>
                    </tr>

                <?php endforeach; ?>

                <tr class="total-row">
                    <td colspan="7" class="text-right">
                        TOTAL
                    </td>

                    <td class="text-right">
                        Rp <?= number_format(
                            (float) $total_penyaluran,
                            0,
                            ',',
                            '.'
                        ) ?>
                    </td>
                </tr>

            <?php else: ?>

                <tr>
                    <td colspan="8" class="text-center">
                        Tidak ada data penyaluran pada periode yang dipilih.
                    </td>
                </tr>

            <?php endif; ?>
        </tbody>
    </table>

    <div class="footer">

        <div class="footer-date">
            Dicetak pada <?= date('d/m/Y H:i') ?>
        </div>

        <div class="signature">
            <div>Mengetahui,</div>

            <div class="signature-space"></div>

            <div class="signature-name">
                Pengelola ZIS
            </div>
        </div>

    </div>

</div>

<script>
window.addEventListener('load', function () {
    window.print();
});
</script>

</body>
</html>