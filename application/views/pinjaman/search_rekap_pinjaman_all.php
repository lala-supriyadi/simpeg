<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Data Pinjaman
        <small>List</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Data Pinjaman</li>
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
                   <form method="post" action="<?php echo $current_context . 'cek'; ?>" class="form-horizontal">
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label col-md-4">Bulan</label>
                                <div class="col-md-8">
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

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label col-md-4">Tahun</label>
                                <div class="col-md-8">
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

                        <div class="col-md-4">
                        <div class="form-group <?php echo (form_error('id_penempatan') != "") ? "has-error" : "" ?>">
                                    <label class="control-label col-md-4">Penempatan</label>
                                        <div class="col-md-8">
                                             <select class="form-control select2me" name="id_penempatan" data-placeholder="Pilih..."  id="id_penempatan">
                                                <option>--Select Penempatan--</option>
                                                <?php foreach ($penempatan_list as $row) {
                                                    if ($row->id_penempatan == set_value('id_penempatan',$penempatan->id_penempatan)){
                                                        echo "<option value='$row->id_penempatan' selected>$row->nama_perusahaan</option>";
                                                        } else {
                                                        echo "<option value='$row->id_penempatan'>$row->nama_perusahaan</option>";
                                                        }
                                                    ?>
                                                <?php }
                                                 ?>
                                            </select>
                                        </div>
                                    <?php echo form_error('id_penempatan'); ?>
                                </div>
                            </div>

                        <div class="clearfix pull-right">
                            <button type="submit" class="btn btn-sm btn-primary" name="cari">Cari</button>
                            <button type="submit" class="btn btn-sm btn-success" name="export">Export</button>
                            <button type="button" class="btn btn-sm btn-default" onclick="location.href = '<?php echo $current_context . 'rekap_pinjaman'; ?>'">Reset</button>
                        </div>
                    </form>
                </div><!-- /.box-body -->
                <!-- <div class="box-header">
                    <div class="box-tools pull-right">
                          <a href="<?php echo $current_context . 'search_rekap_penagihan/'; ?>" target="_BLANK" class="btn btn-sm bg-light-blue">
                            <i class="fa fa-print"></i>&nbsp; Cetak Penagihan
                        </a> 
                    </div>
                </div> -->
                <!-- /.box-header -->
                
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover" id="table_data">
                        <tr>
                            <th class="table-checkbox"></th>
                            <th>No</th>
                            <th>Nip</th>   
                            <th>Nama Karyawan</th>
                            <th>Jumlah Pinjaman</th>
                            <th>Tanggal Pinjam</th>
                            <th>Sisa</th>
                            <th>Keterangan</th>
                        </tr>
                        <?php
                        $i=1;
                        foreach ($getPinjamantotalsearchAll as $raw) {
                            ?>

                        <?php
                        // $i=1;
                        foreach ($getPinjamansearchAll as $row) {

                               
                            ?>
                            <tr>
                                <td></td>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo $row->nip; ?></td>
                                <td><?php echo $row->nama_karyawan; ?></td>
                                <td><?php echo "Rp " . number_format($row->jumlah_pinjaman,0,',','.'); ?></td>
                                <td><?php echo $row->tgl_pinjaman; ?></td>
                                <td><?php echo "Rp " . number_format($row->sisa,0,',','.'); ?></td>
                                <td><?php echo $row->nama_pinjaman; ?></td>
                            </tr>
                        <?php ;
                        } ?>

                        <tr>
                            <td colspan="4" style="text-align:center;"><b>Jumlah Total</b></td>
                                <td style="text-align:left;"><b><?php echo "Rp " . number_format($raw->total_pinjaman,0,',','.'); ?></b></td> 
                                <td></td> 
                                <td style="text-align:left;"><b><?php echo "Rp " . number_format($raw->total_sisa,0,',','.'); ?></b></td>
                        </tr>

                        <?php $i++;
                        } ?>
                    </table>
                    <div class="box-footer clearfix">
                        <!-- <button id="deleteall" class="btn bg-red btn-sm" data-href="<?php echo $current_context . 'delete_multiple'; ?>" data-toggle="modal" data-target="#deleteAll"><i class="fa fa-trash-o"></i> Hapus Semua</button> -->
                        <!-- <?php echo $pagination; ?> -->
                    </div>
                   <!--  <div class="box-footer clearfix">
                        <a href="<?php echo base_url() ?>/barang_print/" target="_blank" class="btn btn-warning">Print</a>
                        <button id="deleteall" class="btn bg-red btn-sm" data-href="<?php echo $current_context . 'delete_multiple'; ?>" data-toggle="modal" data-target="#deleteAll"><i class="fa fa-trash-o"></i> Hapus Semua</button>
                        <?php //echo $pagination; ?>
                    </div> -->
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
</section><!-- /.content -->
<form method="post" role="form" enctype="multipart/form-data">
