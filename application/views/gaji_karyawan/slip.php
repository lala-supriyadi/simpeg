<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CETAK SLIP</title>
    <style>
        @page {
            size: 215mm 200mm potrait;
        }
        @font-face {
            font-family:"1979 Dot Matrix Regular";
            src:url("/printer/1979_dot_matrix.eot?") format("eot"),url("/printer/1979_dot_matrix.woff") format("woff"),url("/printer/1979_dot_matrix.ttf") format("truetype"),url("/printer/1979_dot_matrix.svg#1979-Dot-Matrix") format("svg");
            font-weight:normal;
            font-style:normal;
        }

        body, h1, h2, h3, h4, h5, h6 {
            font-family: "1979 Dot Matrix Regular";
            font-size: 3mm;
            margin: 0mm;
            padding: 0mm;
            line-height: 4mm;
        }
        .page {
            /*width: 210mm;
            height: 148mm;*/
            position: fixed;
            background: none;
            border: none;
        }
        p {
            margin: 0 0 1mm 0;
            background-color: none;
        }
        div {
            background-color: none;
            /*#f7f7f7;*/
        }
        .title {
            font-weight: bold;
        }
        .list-product {
            height: 62mm;
            overflow: hidden;
            border-top: 0.5mm solid black;
            border-bottom: 0.5mm solid black;
        }
        .list-product p {
            margin: 0;
        }
        .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
            padding:1mm 3mm 0.5mm 0mm;
            border:none;
        }
        .table>thead {
            text-align: left;
        }
        .table>tbody>tr>td:last-child, .table>tbody>tr>th:last-child,.table>thead>tr>td:last-child, .table>thead>tr>th:last-child {
            padding-right: 0mm;
        }
    </style>
    <script src="<?= base_url(); ?>assets/js/jquery-1.12.4.min.js"></script>
</head>

<body onload="onbeforeunload()">
    <div class="page">
        <div style="position: fixed;margin-top: 4mm;margin-left: 4mm;">
            <h2>SLIP GAJI</h2>
        </div>
        <div style="position: fixed;margin-top: 12mm;margin-left: 4mm;">
            <p style="max-width:90mm;">
                PT. Puri Makmur Lestari <br>               
                Jl. Batununggal Kav. B No. 9</p>
        </div>
        <div style="position: fixed;margin-top: 12mm;margin-left: 110mm;">
            <p> 
                Nama     : <?php echo $gaji_karyawan->nama_karyawan; ?> <br>      
                <!-- Alamat    : <?php echo $gaji_karyawan->alamat; ?> <br>        -->
                Periode    : <?php echo $gaji_karyawan->periode; ?>
            </p>
        </div>
        <div style="width: 500mm;">
            <div style="position: fixed;margin-top: 25mm;margin-left: 4.5mm;width: 180mm;height: 4mm;overflow: hidden; border-bottom: 0.5mm solid black; border-top:0.5mm solid black; ">
                PENERIMAAN
            </div>
            <div style="position: fixed;margin-top: 25mm;margin-left: 115mm;width: 71mm;height: 4mm;overflow: hidden;">
                POTONGAN
            </div>
        </div>
       
        

        <!-- tanda tangan -->
        <div style="position: fixed;margin-top: 100mm; margin-left: 80mm;">
            <div style="position: relative;margin-left: 0mm;background:none;float: left;">
                <p style="text-align: center;width: 100%; margin-top: 5mm;">
                    Diserahkan oleh,
                </p>
                <p style="height: 16mm;">
                </p>
                <p style="align-content: center;width: 100%;height: 100%; margin-top: -15mm;">
                    <img src="<?php echo base_url() ?>./assets/images/cap.jpg" class="img-circle" alt="User Image">
                </p>
                <p style="text-align: center;width: 100%;height: 4mm;">
                    ( Asep Sopian )
                </p>
            </div>
        </div>

         <div style="position: fixed;margin-top: 100mm; margin-left: 120mm;">
            <div style="position: relative;margin-left: 0mm;background:none;">
                <p>Bandung, &nbsp;<?= str_replace('/',' ', date('d/M/Y')); ?></p>
                <p style="text-align: center;width: 100%;">
                    Diterima oleh,
                </p>
                <p style="height: 11mm;">
                </p>
                <p style="text-align: center;width: 100%;height: 4mm; margin-top: 17mm;">
                    ( <?php echo $gaji_karyawan->nama_karyawan; ?> )
                </p>
            </div>
        </div>
        <!-- tampung data ke variabel biar gampang -->
        <?php 
            $gaji_pokok                 = $gaji_karyawan->gaji_pokok;
            $tunj_jabatan               = $gaji_karyawan->tunj_jabatan;
            $tunj_bpjstk                = $gaji_karyawan->tunj_bpjstk;
            $tunj_bpjskes               = $gaji_karyawan->tunj_bpjskes;
            $tunj_dapen                 = $gaji_karyawan->tunj_dapen;
            $tunj_makan                 = $gaji_karyawan->tunj_makan;
            $tunj_lain                  = $gaji_karyawan->tunj_lain;
            $potongan_absensi           = $gaji_karyawan->potongan_absensi;
            $potongan_bpjstk            = $gaji_karyawan->potongan_bpjstk;
            $potongan_bpjskes           = $gaji_karyawan->potongan_bpjskes;
            $potongan_dapen             = $gaji_karyawan->potongan_dapen;
            $potongan_simpanan_wajib    = $gaji_karyawan->potongan_simpanan_wajib;
            $potongan_sekunder          = $gaji_karyawan->potongan_sekunder;
            $potongan_darurat           = $gaji_karyawan->potongan_darurat;
            $potongan_toko              = $gaji_karyawan->potongan_toko;
            $potongan_lain              = $gaji_karyawan->potongan_lain;
            // $pph21_bulan                = $gaji_karyawan->pph21_bulan;
            // $pph21_tahun                = $gaji_karyawan->pph21_tahun;

            $total_gaji_bruto = 
                (   
                    $gaji_pokok     + 
                    $tunj_jabatan   +
                    $tunj_bpjstk    +
                    $tunj_bpjskes   +
                    $tunj_dapen     +
                    $tunj_makan     + 
                    $tunj_lain
                );

            $total_potongan = 
                (
                    $potongan_absensi           +
                    $potongan_bpjstk            + 
                    $potongan_bpjskes           +
                    $potongan_dapen             +
                    $potongan_simpanan_wajib    +
                    $potongan_sekunder          +
                    $potongan_darurat           +
                    $potongan_toko              +
                    $potongan_lain  
                );
            $total_diterima = ( $total_gaji_bruto ) - ( $total_potongan );

        ?>
        <!-- fix ok -->
        <div style="position: fixed;margin-top: 30mm; margin-left: 4mm;width: 200mm;">
            <!-- <div class="list-product"> -->
            <table width="100%" class="table">
                <tr>
                    <td>Gaji Pokok <span style="margin-left: 21mm;"></span>:&nbsp;<?= number_format($gaji_pokok,0,',','.') ?></td>
                    <td></td>
                    <td>BPJS Kesehatan <span style="margin-left: 13.8mm;"></span>: <?= number_format($potongan_bpjskes,0,',','.') ?></td>
                </tr>
                <tr>
                    <td colspan="1">Tunjangan Jabatan <span style="margin-left: 12.1mm;"></span>:&nbsp;<?= number_format($tunj_jabatan,0,',','.'); ?></td>
                    <td></td>
                    <td>BPJS Ketenagakerjaan <span style="margin-left: 6mm;"></span>: <?= number_format($potongan_bpjstk,0,',','.') ?></td>
                </tr>
                <tr>
                    <td colspan="1">Tunjangan BPJS TK <span style="margin-left: 10mm;"></span>:&nbsp;<?= number_format($tunj_bpjstk,0,',','.'); ?></td>
                    <td></td>
                    <td>Dana Pensiun <span style="margin-left: 16.8mm;"></span>: <?= number_format($potongan_dapen,0,',','.') ?></td>
                </tr>
                <tr>
                    <td colspan="1">Tunjangan BPJS Kesehatan <span style="margin-left: 1.6mm;"></span>:&nbsp;<?= number_format($tunj_bpjskes,0,',','.') ?></td>
                    <td></td>
                    <td>Potongan Simpanan Wajib <span style="margin-left: 1.4mm;"></span>: <?= number_format($potongan_simpanan_wajib,0,',','.') ?></td>
                </tr>
                <tr>
                    <td colspan="1">Tunjangan Dana Pensiun <span style="margin-left: 4.7mm;"></span>:&nbsp;<?=  number_format($tunj_dapen,0,',','.') ?></td>
                    <td></td>
                    <td>Potongan Sekunder <span style="margin-left: 9.8mm;"></span>: <?= number_format($potongan_sekunder,0,',','.') ?></td>
                </tr>
                <tr>
                    <td colspan="1">Tunjangan Makan <span style="margin-left: 13.1mm;"></span>:&nbsp;<?= number_format($tunj_makan,0,',','.') ?></td>
                    <td></td>
                    <td>Potongan Darurat <span style="margin-left: 11.9mm;"></span>: <?= number_format($potongan_darurat,0,',','.') ?></td>
                </tr>
                <tr>
                    <td colspan="1">Tunjangan Lain-Lain <span style="margin-left: 9.5mm;"></span>:&nbsp;<?= number_format($tunj_lain,0,',','.') ?></td>
                    <td></td>
                    <td>Potongan Toko <span style="margin-left: 14.9mm;"></span>: <?= number_format($potongan_toko,0,',','.') ?></td>
                </tr>
                <tr>
                    <!-- <td colspan="1">Pph21 Terutang Bulan Ini <span style="margin-left: 4mm;"></span>: <?= number_format($pph21_bulan,0,',','.') ?></td> -->
                    <td></td>
                    <td></td>
                    <td colspan="1">Potongan Lain-Lain <span style="margin-left: 8.9mm;"></span>: <?= number_format($potongan_lain,0,',','.') ?></td>
                </tr>
                <tr>
                    <td colspan="1"></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="1">Total Gaji Bruto <span style="margin-left: 14mm;">&nbsp;&nbsp;: <?= number_format($total_gaji_bruto,0,',','.') ?></td>
                    <td></td>
                    <td>Total Potongan <span style="margin-left: 14.5mm;"></span>:&nbsp;<?= number_format($total_potongan,0,',','.') ?></td>
                </tr>
                <!-- <tr>
                    <td colspan="1" style="border-bottom: 0.5mm solid black; border-top:0.5mm solid black;">Total Gaji Yang di terima <span style="margin-left: 3mm;">&nbsp;&nbsp;:
                        <span style="margin-left: 0mm;">&nbsp;&nbsp;:</td>
                    <td></td>
                </tr> -->
            </table>
            <div style="width: 500mm;">
                <div style="position: fixed;margin-left: 0.5mm;width: 177mm;height: 4mm;overflow: hidden; border-bottom: 0.5mm solid black; border-top:0.5mm solid black; ">
                    Total gaji yang diterima
                </div>
                <div style="position: fixed;margin-left: 109.5mm;width: 71mm;height: 4mm;overflow: hidden;">
                    RP <span style="margin-left: 28mm;">&nbsp;&nbsp;: <?= number_format($total_diterima,0,',','.'); ?>
                </div>
            </div>
        </div>
    </div>
    <script>
        // window.print();
    </script>
</body>
</html>
