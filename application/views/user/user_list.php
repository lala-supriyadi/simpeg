<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Pengguna
        <small>List</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Pengguna</li>
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
                        <?php $key = (object) $this->session->userdata('filter_user'); ?>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-5">Hak Akses</label>
                                <div class="col-md-7">
                                    <select class="form-control select2me" name="role_id" data-placeholder="Pilih..." >
                                        <option>--Select--</option>
                                        <?php foreach ($role as $row) {
                                            if($row->role_id == set_value('role_id',$key->role_id)){
                                                echo "<option value='$row->role_id' selected>$row->role_name</option>";
                                              } else {
                                                echo "<option value='$row->role_id'>$row->role_name</option>";
                                              }
                                            ?>
                                            <!--<option value="<?php echo $row->role_id ?>"><?php echo $row->role_name; ?></option>-->
                                        <?php }
                                        ?>
                                    </select>
                                    <!--<input class="form-control " name="role_id" value="<?php echo $key->role_id; ?>" placeholder="Role Id">-->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6"><div class="form-group">
                                <label class="control-label col-md-5">Username</label>
                                <div class="col-md-7"><input class="form-control " name="username" value="<?php echo $key->username; ?>" placeholder="Username">
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
                <hr>
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
                            <th class="table-checkbox"><input type="checkbox" class="group-checkable" data-set="#table_data .checkboxes" /></th>
                            <th>No</th>
                            <th>Jabatan</th>
                            <th>Username</th>
                            <th>Nama Lengkap</th>
                            <th>Foto</th>
                            <th>Aksi</th>
                        </tr>
                        <?php
                        $i=1;
                        foreach ($user as $row) {
                            ?>
                            <tr>
                                <td><input type="checkbox" class="checkboxes"  data-id_user="<?php echo $row->id_user; ?>"  /></td>
                                <td><?php echo $i + $offset; ?></td>
                                <td><?php echo $row->role_name. (!empty($row->clinic_name) ? " - " . $row->clinic_name : ""); ?></td>
                                <td><?php echo $row->username; ?></td>
                                <td><?php echo $row->full_name; ?></td>
                                <td><img src="<?php echo base_url() ?>./upload/user_photo/<?php echo $row->gambar ?>" class="image image-responsive" height="50" width="50"></td>
                                <td class="td-btn">
                                    <a href="<?php echo $current_context . 'detail' . '/' . $row->id_user ?>" class="badge bg-yellow"><i class="fa fa-eye fa-fw"></i>lihat</a>
                                    <a href="<?php echo $current_context . 'edit' . '/' . $row->id_user ?>" class="badge bg-green"><i class="fa fa-edit fa-fw"></i>ubah</a>
                                    <a href="#" data-href="<?php echo $current_context . 'delete' . '/' . $row->id_user ?>" data-toggle="modal" data-target="#deleteModal"  class="badge bg-red"><i class="fa fa-trash-o fa-fw"></i>hapus</a>
                                </td>
                            </tr>
                        <?php $i++;
                        } ?>
                    </table>
                    <div class="box-footer clearfix">
                        <button id="deleteall" class="btn bg-red btn-sm" data-href="<?php echo $current_context . 'delete_multiple'; ?>" data-toggle="modal" data-target="#deleteAll"><i class="fa fa-trash-o"></i> Hapus Semua</button>
                        <?php echo $pagination; ?>
                    </div>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
</section><!-- /.content -->
