<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Pinjaman
        <small>List</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Pinjaman</li>
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
                        <?php $key = (object) $this->session->userdata('filter_pinjaman'); ?>
                          <div class="col-md-6"><div class="form-group">
                                <label class="control-label col-md-5">Nama Karyawan</label>
                                <div class="col-md-7"><input class="form-control " name="nama_karyawan" value="<?php echo $key->nama_karyawan; ?>" placeholder="Nama Karyawan">
                                </div>
                            </div>
                        </div>  
                        <div class="col-md-6"><div class="form-group">
                                <label class="control-label col-md-5">Tanggal Pinjaman</label>
                                <div class="col-md-7"><input class="form-control " name="tgl_pinjaman" type="date" value="<?php echo $key->tgl_pinjaman; ?>" placeholder="Tanggal Pinjaman">
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
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover" id="table_data">
                        <tr>
                            <th class="table-checkbox"></th>
                            <th>No</th>
                            <th>NIP</th>
                            <th>Karyawan</th>
                            <th>Keterangan</th>
                            <th>Jumlah Pinjaman</th>
                            <th>Tanggal Pinjaman</th>
                            <th>Sisa</th>
                            <th>Aksi</th>
                        </tr>
                        <?php
                        $i=1;
                        foreach ($pinjaman as $row) {

                               
                            ?>
                            <tr>
                                <td></td>
                                <td><?php echo $i + $offset; ?></td>
                                <td><?php echo $row->nip; ?></td>
                                <td><?php echo $row->nama_karyawan; ?></td>
                                <td><?php echo $row->nama_pinjaman; ?></td>
                                <td><?php echo "Rp " . number_format($row->jumlah_pinjaman,0,',','.'); ?></td>
                                <td><?php echo $row->tgl_pinjaman; ?></td>
                                <!-- <td><?php echo "Rp " . number_format($row->sisa,0,',','.'); ?></td> -->
                                <td>
                                <?php 
                                if ($row->sisa == '0') {?>
                                    <span class="label label-danger">Lunas</span>
                                 <?php }else{
                                   echo "Rp " . number_format($row->sisa,0,',','.');
                                 } ?>
                                 </td>
                                 
                                <td class="td-btn">
                                    <!-- <a href="<?php echo $current_context . 'detail' . '/' . $row->id_pinjaman ?>" class="badge bg-yellow"><i class="fa fa-eye fa-fw"></i>Detail</a> -->
                                    <a href="<?php echo $current_context . 'edit' . '/' . $row->id_pinjaman ?>" class="badge bg-green"><i class="fa fa-edit fa-fw"></i>Ubah</a>
                                    <a href="#" data-href="<?php echo $current_context . 'delete' . '/' . $row->id_pinjaman ?>" data-toggle="modal" data-target="#deleteModal"  class="badge bg-red"><i class="fa fa-trash-o fa-fw"></i>Hapus</a>
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