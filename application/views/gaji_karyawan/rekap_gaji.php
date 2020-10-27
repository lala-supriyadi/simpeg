<!-- <?php 
    error_reporting(0)
?> -->
<html lang="en" moznomarginboxes mozdisallowselectionprint>
<head>
    <title>Rekap Gaji Perbulan</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/laporan.css')?>"/>
    <style>
        @page {
            size: 210mm 297mm landscape;
        }
    </style>
</head>
<!-- <body onload="window.print()"> -->
<div id="laporan">
<table align="center" style="width:900px; border-bottom:3px double;border-top:none;border-right:none;border-left:none;margin-top:5px;margin-bottom:20px;">
<!--<tr>
    <td><img src="<?php// echo base_url().'assets/img/kop_surat.png'?>"/></td>
</tr>-->
</table>

<table border="0" align="center" style="width:800px; border:none;margin-top:5px;margin-bottom:0px;">
<tr>
    <td colspan="2" style="width:800px;paddin-left:20px;"><center><h4>Rekap Gaji Perbulan</h4></center></td>
</tr>
<tr>
    <td colspan="2" style="width:800px;paddin-left:20px;"><center><h4>PT. xxx</h4></center><br/></td>
</tr>
                       
</table>
 
<table border="0" align="center" style="width:900px;border:none;">
        <tr>
            <th style="text-align:left"></th>
        </tr>
</table>


<table border="1" align="center" style="width:100%;margin-bottom:20px;">
<thead>
<tr>
</tr>
<div class="page">
    <tr style='background-color:#ccc;'>
        <th>No</th>
        <th>NIP</th>
        <th>Nama Karyawan</th>
        <th>Divisi</th>
        <th>Gaji Pokok</th>
        <th>Tunjangan Jabatan</th>
        <th>Tunjangan BPJSTK</th>
        <th>Tunjangan BPJSKES</th>
        <th>Tunjangan Dapen</th>
        <th>Tunjangan Makan</th>
        <th>Tunjangan Lain</th>
        <th>Potongan Absensi</th>
        <th>Potongan BPJSTK</th>
        <th>Potongan BPJSKES</th>
        <th>Potongan Dapen</th>
        <th>Potongan Simpanan Wajib</th>
        <th>Potongan Sekunder</th>
        <th>Potongan Darurat</th>
        <th>Potongan Toko</th>
        <th>Potongan Lain</th>
    </tr>
</thead>
<tbody>

<?php 
$no=0;
    foreach ($getGajikaryawan as $i) {
        $no++;
        $nip=$i['nip'];
        $nama_karyawan=$i['nama_karyawan'];
        $divisi=$i['divisi'];
        $gaji_pokok=$i['gaji_pokok'];

        $tunj_jabatan=$i['tunj_jabatan'];
        $tunj_bpjstk=$i['tunj_bpjstk'];
        $tunj_bpjskes=$i['tunj_bpjskes'];
        $tunj_dapen=$i['tunj_dapen'];
        $tunj_makan=$i['tunj_makan'];
        $tunj_lain=$i['tunj_lain'];
        
        $potongan_absensi=$i['potongan_absensi'];
        $potongan_bpjstk=$i['potongan_bpjstk'];
        $potongan_bpjskes=$i['potongan_bpjskes'];
        $potongan_dapen=$i['potongan_dapen'];
        $potongan_simpanan_wajib=$i['potongan_simpanan_wajib'];
        $potongan_sekunder=$i['potongan_sekunder'];
        $potongan_darurat=$i['potongan_darurat'];
        $potongan_toko=$i['potongan_toko'];
        $potongan_lain=$i['potongan_lain'];
?>
    <tr>
        <td style="text-align:left;"><?php echo $no;?></td>
        <td style="text-align:left;"><?php echo $nip;?></td>
        <td style="text-align:left;"><?php echo $nama_karyawan;?></td>
        <td style="text-align:left;"><?php echo $divisi;?></td>
        <td style="text-align:left;"><?php echo $gaji_pokok;?></td>
        <td style="text-align:left;"><?php echo $tunj_jabatan;?></td>
        <td style="text-align:left;"><?php echo $tunj_bpjstk;?></td>
        <td style="text-align:left;"><?php echo $tunj_bpjskes;?></td>
        <td style="text-align:left;"><?php echo $tunj_dapen;?></td>
        <td style="text-align:left;"><?php echo $tunj_makan;?></td>
        <td style="text-align:left;"><?php echo $tunj_lain;?></td>
        <td style="text-align:left;"><?php echo $potongan_absensi;?></td>
        <td style="text-align:left;"><?php echo $potongan_bpjstk;?></td>
        <td style="text-align:left;"><?php echo $potongan_bpjskes;?></td>
        <td style="text-align:left;"><?php echo $potongan_dapen;?></td>
        <td style="text-align:left;"><?php echo $potongan_simpanan_wajib;?></td>
        <td style="text-align:left;"><?php echo $potongan_sekunder;?></td>
        <td style="text-align:left;"><?php echo $potongan_darurat;?></td>
        <td style="text-align:left;"><?php echo $potongan_toko;?></td>
        <td style="text-align:left;"><?php echo $potongan_lain;?></td>
    </tr>
<?php }?>

</tbody>

</table>


<table align="center" style="width:800px; border:none;margin-top:5px;margin-bottom:20px;">
    <tr>
        <td></td>
</table>
<table align="center" style="width:800px; border:none;margin-top:5px;margin-bottom:20px;">
    <tr>
        <td align="right">Bandung, <?php echo date('d-M-Y')?></td>
    </tr>
    <tr>
        <td align="right"></td>
    </tr>
   
    <tr>
    <td><br/><br/><br/><br/></td>
    </tr>    
    <tr>
        <td align="right">( <?php echo $this->session->userdata('username');?> )</td>
    </tr>
    <tr>
        <td align="center"></td>
    </tr>
</table>
<table align="center" style="width:800px; border:none;margin-top:5px;margin-bottom:20px;">
    <tr>
        <th><br/><br/></th>
    </tr>
    <tr>
        <th align="left"></th>
    </tr>
</table>
</div>
<!-- <tfoot>
<?php 
    $b=$no->row_array();
?>
    <tr>
        <td colspan="9" style="text-align:center;"><b>Total</b></td>
        <td style="text-align:right;"><b><?php echo 'Rp '.number_format($b['total']);?></b></td>
    </tr>
</tfoot> -->
</div>
</body>
</html>_