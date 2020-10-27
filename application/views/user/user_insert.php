<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Pengguna
        <small>Insert</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?php echo $current_context; ?>">Pengguna</a></li>
        <li class="active">Insert</li>
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
        <!-- right column -->
        <div class="col-md-12">
            <!-- general form elements disabled -->
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Pengguna</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <form role="form" method="POST" enctype="multipart/form-data" class="form-horizontal">



                        <div class="form-group <?php echo (form_error('role_id') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Jabatan</label>
                            <div class="col-md-10">
                            <select class="form-control select2me" name="role_id" >
                                <option>--Select--</option>
                                <?php foreach ($role as $row) {
                                    if($row->role_id == set_value('role_id', $user->role_id)){
                                        echo "<option value='$row->role_id ?>' selected>$row->role_name</option>";
                                    }else{
                                    echo "<option value='$row->role_id'>$row->role_name</option>";
                                    }
                                }
                                ?>
                            </select>
                            </div>
                            <!--<input class="form-control mask_number" name="role_id" value="<?php echo set_value('role_id', $user->role_id); ?>" placeholder="Role Id"  required  maxlength=10>-->
                            <?php echo form_error('role_id'); ?>
                        </div>
                        <div class="form-group <?php echo (form_error('id_clinic') != "") ? "has-error" : "" ?>" id="klinik" style="display:none">
                            <label class="control-label col-md-2">Klinik</label>
                            <div class="col-md-10">
                            <select class="form-control" name="id_clinic">
                                    <option>--Pilih--</option>
                                <?php foreach ($clinic as $row) {
                                    ?>
                                    <option value="<?php echo $row->id_clinic ?>"><?php echo $row->clinic_name; ?></option>
                                    <?php }
                                ?>
                            </select>
                            </div>
                            <!--<input class="form-control mask_number" name="role_id" value="<?php echo set_value('role_id', $user->role_id); ?>" placeholder="Role Id"  required  maxlength=10>-->
                            <?php echo form_error('id_clinic'); ?>
                        </div>
                        <div class="form-group <?php echo (form_error('username') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Username</label><div class="col-md-10"><input class="form-control " name="username" value="<?php echo set_value('username', $user->username); ?>" placeholder="Username"  maxlength=10></div>
                            <?php echo form_error('username'); ?>
                        </div>
                        <div class="form-group <?php echo (form_error('password') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Kata Sandi</label><div class="col-md-10"><input type="password" class="form-control " name="password" value="<?php //echo set_value('password', $user->password); ?>" placeholder="Kata Sandi"  maxlength=255></div>
                            <?php echo form_error('password'); ?>
                        </div>
                        <div class="form-group <?php echo (form_error('full_name') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Nama Lengkap</label><div class="col-md-10"><input class="form-control " name="full_name" value="<?php echo set_value('full_name', $user->full_name); ?>" placeholder="Nama Lengkap"  maxlength=50></div>
                            <?php echo form_error('full_name'); ?>
                        </div>
                        <div class="form-group <?php echo (form_error('gambar') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Photo</label><div class="col-md-10"><input class="form-control" name="gambar" type="file" value="<?php echo set_value('gambar', $user->gambar); ?>" placeholder="Photo" maxlength=50></div>
                            <?php echo form_error('gambar'); ?>
                        </div>
                        <div class="box-footer">
                            <a href="<?php echo $current_context; ?>" class="btn btn-default">Batal</a>
                            <button type="submit" class="btn btn-primary pull-right">Simpan</button>
                        </div><!-- /.box-footer -->
                    </form>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!--/.col (right) -->
    </div>   <!-- /.row -->
</section><!-- /.content -->
<script>
   
</script>