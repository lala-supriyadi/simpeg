<style type="text/css">
.st_total {
	font-size: 9pt;
	font-weight: bold;
	font-family:Verdana, Arial, Helvetica, sans-serif;
}
.cetak{
  margin-top:40px; 
  text-align:center;
}
@media print{
  .no-print{
    display:none !important;
  }
}
.style6 {
	color: #000000;
	font-size: 9pt;
	font-weight: bold;
	font-family: Arial;
}
.style9 {
	color: #000000;
	font-size: 9pt;
	font-weight: normal;
	font-family: Arial;
}
.style9b {
	color: #000000;
	font-size: 9pt;
	font-weight: bold;
	font-family: Arial;
}
.style19b {
	color: #000000;
	font-size: 11pt;
	font-weight: bold;
	font-family: Arial;
}
.style10b {
	color: #000000;
	font-size: 11pt;
	font-weight: bold;
	font-family: Arial;
}
.par{
  color: #000000;
  font-size: 9pt;
  font-weight: normal;
  font-family: Arial;
  margin-top: 3;
}
.vl {
  border-left: 1px solid black;
  height: 12px;
  padding-top: 0;

}
</style>
</style>

<html lang="en" moznomarginboxes mozdisallowselectionprint>
<!-- <body> -->
<body onload="window.print()">

  <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="7">
      <div align="center">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="69%" rowspan="3" valign="top" class="style19b">
            <h3>PT. xxxx</h3>
            <p class="par">Jln. xxxx,</p>
            <p class="par">Kecamatan xxx, Kota Bandung </p>
            </td>
            <td colspan="3"><div align="center" class="style9b">
              <div align="left" class="style19b"><strong><u>SLIP GAJI</u></strong></div>
            </div></td>
            </tr>
          <tr>
            <td width="11%" height="18" class="style9">NIP </td>
            <td width="1%" class="style9"><div align="center">:</div></td>
            <td width="14%" class="style9"><?php echo $gaji_karyawan->nip; ?></td>
          </tr>
          <tr>
            <td width="11%" height="18" class="style9">Nama </td>
            <td width="1%" class="style9"><div align="center">:</div></td>
            <td width="14%" class="style9"><?php echo $gaji_karyawan->nama_karyawan; ?></td>
          </tr>
          <tr>
            <td width="11%" height="18" class="style9">Alamat </td>
            <td width="1%" class="style9"><div align="center">:</div></td>
            <td width="14%" class="style9"><?php echo $gaji_karyawan->alamat; ?></td>
          </tr>
          <tr>
            <td width="11%" height="18" class="style9">Periode </td>
            <td width="1%" class="style9"><div align="center">:</div></td>
            <td width="14%" class="style9"><?php echo $gaji_karyawan->periode; ?> <?php echo $gaji_karyawan->tahun; ?></td>
          </tr>
          

        </table>
          </div>
       </td>
    </tr>
  </table>
   </br>
  <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="7">
      <hr />      </td>
    </tr>
    <tr>
    	<td width="24" class="style6"><div align="center">No.</div></td>
      <td width="150" class="style6"><div align="left">Keterangan</div></td>
      <td width="203" class="style6"><div align="left">Jumlah</div></td>
    </tr>

    <tr>
      <td colspan="7">
      <hr />      </td>
    </tr>
    <tr>
        <td class="style9" align="center">1.</td>
        <!-- <td class="style9"><?php echo $gaji_karyawan->kode_produksi; ?></td> -->
        <!-- <td class="style9"><?php echo $gaji_karyawan->jenis_pesanan; ?></td> -->
        <!-- <td class="style9" align="left"><?php echo $distribusi->jml_pesanan; ?></td> -->
    </tr>


      <tr>
      <td colspan="7">
      <hr />      </td>
      </tr>
      </table>
<table align="right">
   <tr>
     <td colspan="3">&nbsp;</td>
     <td colspan="3">&nbsp;</td>
     <td colspan="3">&nbsp;</td>
   </tr>
   <tr>
     <td colspan="3"><div align="center" class="style9">Penerima</div></td>
     <td colspan="3">&nbsp;</td>
     <td colspan="3"></td>
   </tr>
   <tr>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
   </tr>
   <br>
   <tr>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td width="82"><div align="right"></div></td>
     <td width="89" align="center" class="style9"><b><?php echo $gaji_karyawan->nama_karyawan;?></b></td>
     <div align="center" class="style9"></div></td>
     <td width="76"></td>
   </tr>
 </table>
 <br>
 <br>
 <br>
 <br>
 <br>
 <br>
 <br>
 <br>
 <div class="cetak no-print">
   <!-- <a href="" onclick="print();">(Cetak)</a> -->
   <!-- <a href="" onclick="<?php echo base_url() ?>distribusi/pdf/;">(pdf)</a> -->
   <!-- <a href="<?php echo base_url() ?>distribusi/laporan_pdf" >(Download)</a> -->
 </div>

 </body>
</html>



      <!-- <?php
      	$tampil = cetak($_GET['kode_produksi']);
		foreach ($tampil as $index => $data){	
	  ?>  -->
      <!-- <tr>
        <td class="style9" align="center"><?php echo $index + 1;?>.</td>
        <td class="style9"><?php echo $distribusi->kode_produksi; ?></td>
        <td class="style9"><?php echo $distribusi->jenis_pesanan; ?></td>
        <td class="style9" align="left"><?php echo $distribusi->jml_pesanan; ?></td>
      </tr> -->
      <!-- <?php }?> -->

  <!-- </table> -->
  