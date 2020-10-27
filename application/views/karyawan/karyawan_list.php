<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Karyawan
        <small>List</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Karyawan</li>
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
                   <form method="post" action="<?php echo $current_context . 'search'; ?>" class="form-horizontal" enctype="multipart/form-data">
                        <?php $key = (object) $this->session->userdata('filter_karyawan'); ?>
                         <div class="col-md-6"><div class="form-group">
                                <label class="control-label col-md-5">NIP</label>
                                <div class="col-md-7"><input class="form-control " name="nip" value="<?php echo $key->nip; ?>" placeholder="NIP">
                                </div>
                            </div>
                        </div> 
                        <div class="col-md-6"><div class="form-group">
                                <label class="control-label col-md-5">Nama Karyawan</label>
                                <div class="col-md-7"><input class="form-control " name="nama_karyawan" value="<?php echo $key->nama_karyawan; ?>" placeholder="Nama Karyawan">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="search" name="search" value="true">
                        <div class="clearfix pull-right">
                            <button type="submit" class="btn btn-sm btn-primary">Cari</button>
                            <button type="button" class="btn btn-sm btn-default" onclick="location.href = '<?php echo $current_context; ?>'">Reset</button>
                        </div>
                    </form>
                </div><!-- /.box-body -->
                <div class="box-header">
                    <h3 class="box-title">Data Tabel (<?php echo $total_rows; ?> Data)</h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo $current_context . 'add/'; ?>" class="btn btn-sm bg-light-blue">
                            <i class="fa fa-plus"></i>&nbsp; Tambah
                        </a>
                        <a href="<?php echo $current_context . 'export_excel/'; ?>" class="btn btn-sm bg-red">
                            </i>&nbsp; Export Data
                        </a> 
                        <!-- <button class="btn btn-default" name="excel" type="file" ><i class="glyphicon glyphicon glyphicon-floppy-open"></i> Import Data</button> -->
                        <button class="btn btn-default" data-toggle="modal" name="excel" data-target="#import-pegawai"><i class="glyphicon glyphicon glyphicon-floppy-open"></i> Import Data</button>

                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover" id="table_data">
                        <tr>
                            <th class="table-checkbox"></th>
                            <th>No</th>                
                            <th>Foto</th>
                            <th>NIP</th>
                            <th>Nama Karyawan</th>
                            <th>TTL</th>
                            <th>Jenis Kelamin</th>
                            <th>No. Telp</th>
                            
                            <th>Aksi</th>
                        </tr>
                        <?php
                        $i=1;
                        foreach ($karyawan as $row) {

                               
                            ?>
                            <tr>
                                <td></td>
                                <td><?php echo $i + $offset; ?></td>
                                <td>
                                <?php
                                if ($row->foto == null) { ?>
                                    <img src="<?php echo base_url() ?>./upload/karyawan_foto/default.jpg" class="image image-responsive" height="70" width="50">
                                <?php } else { ?>
                                    <img src="<?php echo base_url() ?>./upload/karyawan_foto/<?php echo $row->foto ?>" class="image image-responsive" height="70" width="50">
                                <?php }
                                ?>    
                                </td>
                                <!-- <td><img src="<?php echo base_url() ?>./upload/karyawan_foto/<?php echo $row->foto ?>" class="image image-responsive" height="70" width="50"></td> -->
                                <td><?php echo $row->nip; ?></td>
                                <td><?php echo $row->nama_karyawan; ?></td>
                                <td><?php echo $row->tempat_lahir; ?>  <?php echo $row->tgl_lahir; ?></td>
                                <td>
                                <?php 
                                if ($row->jenis_kelamin == 'L') 
                                    echo "Laki-laki"
                                 ; else 
                                    echo "Perempuan";
                                 ; ?>
                                     
                                 </td>
                                <td><?php echo $row->no_telp; ?></td>
                                <!-- <td><?php echo $row->nama_divisi; ?></td> -->
                                <td class="td-btn">
                                    <a href="<?php echo $current_context . 'detail' . '/' . $row->id_karyawan ?>" class="badge bg-yellow"><i class="fa fa-eye fa-fw"></i>Detail</a>
                                    <a href="<?php echo $current_context . 'edit' . '/' . $row->id_karyawan ?>" class="badge bg-green"><i class="fa fa-edit fa-fw"></i>Ubah</a>
                                    <a href="#" data-href="<?php echo $current_context . 'delete' . '/' . $row->id_karyawan ?>" data-toggle="modal" data-target="#deleteModal"  class="badge bg-red"><i class="fa fa-trash-o fa-fw"></i>Hapus</a>
                                </td>
                            </tr>
                        <?php $i++;
                        } ?>
                    </table>
                    <div class="box-footer clearfix">
                        <!-- <button id="deleteall" class="btn bg-red btn-sm" data-href="<?php echo $current_context . 'delete_multiple'; ?>" data-toggle="modal" data-target="#deleteAll"><i class="fa fa-trash-o"></i> Hapus Semua</button> -->
                        <?php echo $pagination; ?>
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

<!-- ============ MODAL ADD =============== -->
        <div class="modal fade" id="import-pegawai" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Import Data Karyawan</h3>
            
            <form class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo base_url().'karyawan/importExcel'?>">
                <div class="input-group form-group">
                    <span class="input-group-addon" id="sizing-addon2"><i class="glyphicon glyphicon-file"></i></span>
                        <input type="file" name="file" class="form-control" aria-describedby="sizing-addon2" required>
                </div>
                <div class="col-md-14" style="margin-left:-130px">    
                <div class="form-group">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-4">Tanggal Awal</label><div class="col-md-8"><input class="form-control " name="awal_tgl" type="date" value="<?php echo set_value('awal_tgl'); ?>" placeholder="Tanggal Awal"  maxlength=100 required></div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-4">Tanggal Akhir</label><div class="col-md-8"><input class="form-control " name="akhir_tgl" type="date" value="<?php echo set_value('akhir_tgl'); ?>" placeholder="Tanggal Akhir"  maxlength=100 required></div>
                        </div>
                    </div>
                </div>
                </div>    
                <div class="form-group">
                    <div class="col-md-12">
                        <button type="submit" class="form-control btn btn-primary"> <i class="glyphicon glyphicon-ok"></i> Import Data</button>
                    </div>
                </div>
            </form>
            </div>
            </div>
            </div>
        </div>