<!-- Content Header (Page header) --> 
<script>
window.onload = function () {

var chart = new CanvasJS.Chart("chartContainer", {
  animationEnabled: true,
  theme: "light3",  
  label: 'Laki-Laki',
  title:{
    text: "Jumlah Karyawan Berdasarkan Jenis Kelamin"
  },
  /**/
  data: [{
    type: "column",
    dataPoints: [
      <?php 
        foreach ($getDiagram as $row) {
      ?>
        { label: '<?php if ($row->jenis_kelamin == 'L') echo "Laki-laki"; else echo "Perempuan"; ; ?>', y: <?php echo $row->jenis ?> },
      <?php
        }
      ?>
    ]
  }
  ]
});
chart.render();

var chart = new CanvasJS.Chart("chartContainer1", {
  animationEnabled: true,
  theme: "light3",  
  title:{
    text: "Jumlah Karyawan Berdasarkan Pendidikan"
  },
  /**/
  data: [{
    type: "column",
    dataPoints: [
      <?php 
        foreach ($getPendidikan as $row) {
      ?>
        { label: '<?php echo $row->grade ?>', y: <?php echo $row->pendidikan ?> },
      <?php
        }
      ?>
    ]
  }
  ]
});
chart.render();

var chart = new CanvasJS.Chart("chartContainer2", {
  animationEnabled: true,
  theme: "light3",  
  title:{
    text: "Jumlah Karyawan Berdasarkan Status Pernikahan"
  },
  /**/
  data: [{
    type: "column",
    dataPoints: [
      <?php 
        foreach ($getPernikahan as $row) {
      ?>
        { label: '<?php echo $row->status_pernikahan ?>', y: <?php echo $row->pernikahan ?> },
      <?php
        }
      ?>
    ]
  }
  ]
});
chart.render();



}
</script>
<section class="content-header">
  <h1>
    Dashboard
  </h1>
  <ol class="breadcrumb">
    <li class="active">Dashboard</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
      <div class="col-md-12">
	        <div class="col-md-4 col-sm-6 col-xs-12">
	          <div class="info-box">
	            <span class="info-box-icon bg-aqua">
	            	<i class="fa fa-users"></i>
	            </span>

	            <div class="info-box-content">
	              	<span class="info-box-text">Total Karyawan</span>
              		<span class="info-box-number"><?php echo $jumlah_karyawan ?><small> Orang</small></span>
	            </div>
	            <!-- /.info-box-content -->
	          </div>
	          <!-- /.info-box -->
	        </div>

	        <div class="col-md-4 col-sm-6 col-xs-12">
	          <div class="info-box">
	            <span class="info-box-icon bg-aqua">
	            	<i class="fa fa-users"></i>
	            </span>

	            <div class="info-box-content">
	              <span class="info-box-text">Total Karyawan Yang</span>
	              <span class="info-box-text">Habis Kontrak Bulan Ini</span>
              <span class="info-box-number"><?php echo $jumlah_kontrak ?><small> Orang</small></span>
	            </div>
	            <!-- /.info-box-content -->
	          </div>
	          <!-- /.info-box -->
	        </div>

	        <div class="col-md-4 col-sm-6 col-xs-12">
	          <div class="info-box">
	            <span class="info-box-icon bg-aqua">
	            	<i class="fa fa-users"></i>
	            </span>

	            <div class="info-box-content">
	              <span class="info-box-text">Total Karyawan Habis Kontrak</span>
	              <span class="info-box-text">Bulan Ini dan Tidak Diperpanjang</span>
              <span class="info-box-number"><?php echo $jumlah_tidak_kontrak ?><small> Orang</small></span>
	            </div>
	            <!-- /.info-box-content -->
	          </div>
	          <!-- /.info-box -->
          </div>
	        </div><br><br>

          
          <div class="col-md-12">
            <div class="col-md-6">
            <div class="box box-success">
          <div class="chart">
                    <!-- Sales Chart Canvas -->
              <div id="chartContainer" style="height: 300px; width: 100%;"></div>
              <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
          </div>
        </div>
      </div>
          <div class="col-md-6">
            <div class="box box-success">
                    <!-- Sales Chart Canvas -->
              <div id="chartContainer2" style="height: 300px; width: 100%;"></div>
              <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
          </div>
          </div>

          



        <div class="col-md-12">
          <div class="box box-success">
          <div class="chart">
                    <!-- Sales Chart Canvas -->
              <div id="chartContainer1" style="height: 300px; width: 100%;"></div>
              <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
          </div><br>
          </div><br>
        </div><br>


	     <div class="col-md-12">
          <!-- MAP & BOX PANE -->
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Karyawan Yang Akan Habis Kontrak</h3>
              <div class="box-tools pull-right">
                        <a href="<?php echo 'dashboard/export_excel/'; ?>" class="btn btn-sm bg-red">
                            </i>&nbsp; Export Data
                        </a>
                    </div>

              <table class="table">
              	<tr>
              		<th>No</th>   
                    <th>Nama Karyawan</th>
                    <th>NIP</th>
                    <th>Penempatan</th>
                    <th>Tanggal Berakhir</th>
                    <th>Sisa Hari</th>
              	</tr>
              	<?php
                        $i=0;
                        $offset=1;
                        foreach ($getListkontrak as $row) {

                            ?>
                            <tr>
                                <td><?php echo $i + $offset; ?></td>
                                <td><?php echo $row->nama_karyawan; ?></td>
                                <td><?php echo $row->nip; ?></td>
                                <td><?php echo $row->nama_perusahaan; ?></td>
                                <td><?php echo $row->tgl_berakhir; ?></td>
                                <td><?php echo $row->selisih; ?> Hari</td>
                            </tr>
                        <?php $i++;
                        } ?>
              
              </table>
            </div>

            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- /.box -->
        </div>

            
	 </div>
</section>