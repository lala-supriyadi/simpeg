<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Pajak Karyawan
        <small>List</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Pajak Karyawan</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <?php
        $message = $this->session->flashdata('message');
        $type_message = $this->session->flashdata('type_message');
        echo (!empty($message) && $type_message == "success") ? ' <div class="col-md-12" id="data-alert-box"><div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times</button><strong>Berhasil! </strong>' . $message . '</div></div>' : '';
        echo (!empty($message) && $type_message == "error") ? '   <div class="col-md-12" id="data-alert-box"><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times</button><strong>Error! </strong>' . $message . '</div></div>' : '';
        ?>
        <div class="col-xs-12">
            <div class="box">
              <div class="box-header with-border">
                    <h3 class="box-title">Pencarian</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                   <form method="post" action="<?php echo $current_context . 'search_rekap_pajak'; ?>" class="form-horizontal">
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-5">Select Bulan</label>
                                <div class="col-md-7">
                                    <select class="form-control select2me" name="bln">
                                                <option>--Select Bulan--</option>
                                        <?php 
                                                echo "<option value='01'>Januari</option>";
                                                echo "<option value='02'>Febuari</option>";
                                                echo "<option value='03'>Maret</option>";
                                                echo "<option value='04'>April</option>";
                                                echo "<option value='05'>Mei</option>";
                                                echo "<option value='06'>Juni</option>";
                                                echo "<option value='07'>Juli</option>";
                                                echo "<option value='08'>Agustus</option>";
                                                echo "<option value='09'>September</option>";
                                                echo "<option value='10'>Oktober</option>";
                                                echo "<option value='11'>November</option>";
                                                echo "<option value='12'>Desember</option>";
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-5">Select Tahun</label>
                                <div class="col-md-7">
                                    <select class="form-control select2me" name="thn">
                                                <option>--Select Tahun--</option>
                                        <?php 
                                                $year = date("Y");
                                                for ($x=$year+1;$x>=2019;$x--){
                                                    echo "<option value='".$x."'>".$x."</option>";
                                                }
                                        ?>
                                    </select>
                                    <!--<input class="form-control " name="id_kelas" value="<?php echo $key->id_kelas; ?>" placeholder="Role Id">-->
                                </div>
                            </div>
                        </div>

                        <div class="clearfix pull-right">
                            <button type="submit" class="btn btn-sm btn-primary">Cari</button>
                            <button type="button" class="btn btn-sm btn-default" onclick="location.href = '<?php echo $current_context; ?>'">Reset</button>
                        </div>
                    </form>
                </div><!-- /.box-body -->
                <div class="box-header">
                    <h3 class="box-title">Data</h3>
                    <div class="box-tools pull-right">
                        <!-- <a href="<?php echo $current_context . 'add/'; ?>" class="btn btn-sm bg-light-blue">
                            <i class="fa fa-plus"></i>&nbsp; Tambah
                        </a> -->
                    </div>
                </div><!-- /.box-header -->

                
            </div><!-- /.box -->
        </div>
    </div>
</section><!-- /.content -->
<!-- <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script> -->
<form method="post" role="form" enctype="multipart/form-data">
