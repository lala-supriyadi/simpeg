<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Setting
        <small>Akun</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?php echo $current_context; ?>">Setting</a></li>
        <li class="active">Akun</li>
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
                    <h3 class="box-title">Setting Akun</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <form role="form" method="POST" enctype="multipart/form-data" class="form-horizontal">

                        <!-- <div class="form-group <?php echo (form_error('nama_ortu') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Nama Ortu</label><div class="col-md-10"><input class="form-control " name="nama_ortu" value="<?php echo set_value('nama_ortu', $pelanggan->nama_ortu); ?>" placeholder="Nama Ortu"  maxlength=100 required></div>
                            <?php echo form_error('nama_ortu'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('nama_siswa') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Nama Siswa</label><div class="col-md-10"><input class="form-control " name="nama_siswa" value="<?php echo set_value('nama_siswa', $pelanggan->nama_siswa); ?>" placeholder="Nama Siswa"  maxlength=100></div>
                            <?php echo form_error('nama_siswa'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('nis') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">NIS</label><div class="col-md-10"><input class="form-control " name="nis" value="<?php echo set_value('nis', $pelanggan->nis); ?>" placeholder="NIS"  maxlength=100 required></div>
                            <?php echo form_error('nis'); ?>
                        </div> -->

                        <div class="form-group <?php echo (form_error('username') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Username</label><div class="col-md-10"><input class="form-control " name="username" value="<?php echo set_value('username', $user->username); ?>" placeholder="Username"  maxlength=10></div>
                            <?php echo form_error('username'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('password_lama') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Kata Sandi Lama</label><div class="col-md-10"><input type="password" class="form-control " name="password_lama" value="<?php //echo set_value('password', $pelanggan->password); ?>" placeholder="Kata Sandi Lama"  maxlength=255></div>
                            <?php echo form_error('password_lama'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('password') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Kata Sandi Baru</label><div class="col-md-10"><input type="password" class="form-control " name="password" value="<?php //echo set_value('password', $user->password); ?>" placeholder="Kata Sandi Baru"  maxlength=255></div>
                            <?php echo form_error('password'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('password_konf') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Konfirmasi Kata Sandi</label><div class="col-md-10"><input type="password" class="form-control " name="password_konf" value="<?php //echo set_value('password', $user->password); ?>" placeholder="Konfirmasi Kata Sandi"  maxlength=255></div>
                            <?php echo form_error('password_konf'); ?>
                        </div>

                        <!-- <div class="form-group <?php echo (form_error('alamat') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Alamat</label><div class="col-md-10"><input class="form-control " name="alamat" value="<?php echo set_value('alamat', $pelanggan->alamat); ?>" placeholder="Nama Siswa"  maxlength=100></div>
                            <?php echo form_error('alamat'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('jenis_kelamin') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Jenis Kelamin</label>
                            <div class="col-md-10">
                            <select class="form-control select2me" name="jenis_kelamin" >
                                <option value="">--Select--</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                            </div>
                        </div>

                        <div class="form-group <?php echo (form_error('tgl_lahir') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Tanggal Lahir</label><div class="col-md-10"><input class="form-control " name="tgl_lahir" value="<?php echo set_value('tgl_lahir', $pelanggan->tgl_lahir); ?>" placeholder="Tanggal Lahir" type="date" maxlength=100></div>
                            <?php echo form_error('tgl_lahir'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('tingkat') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Tingkat</label><div class="col-md-10"><input class="form-control " name="tingkat" value="<?php echo set_value('tingkat', $pelanggan->tingkat); ?>" placeholder="Tingkat"  maxlength=100></div>
                            <?php echo form_error('tingkat'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('asal_sekolah') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Asal Sekolah</label><div class="col-md-10"><input class="form-control " name="asal_sekolah" value="<?php echo set_value('asal_sekolah', $pelanggan->asal_sekolah); ?>" placeholder="Asal Sekolah"  maxlength=100></div>
                            <?php echo form_error('asal_sekolah'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('no_telp') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">No Telp</label><div class="col-md-10"><input class="form-control " name="no_telp" value="<?php echo set_value('no_telp', $pelanggan->no_telp); ?>" placeholder="No Telp"  maxlength=100></div>
                            <?php echo form_error('no_telp'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('email') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Email</label><div class="col-md-10"><input class="form-control " name="email" value="<?php echo set_value('email', $pelanggan->email); ?>" placeholder="Email"  maxlength=100></div>
                            <?php echo form_error('email'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('gambar') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Photo</label><div class="col-md-10"><input class="form-control" name="gambar" type="file" value="<?php echo set_value('gambar', $pelanggan->gambar); ?>" placeholder="Photo" maxlength=50></div>
                            <?php echo form_error('gambar'); ?>
                        </div> -->
                      
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
    function show_clinic(e) {
        var role = $(e).val();
        if (role === '2') {
            $('#klinik').css('display', 'block');
        } else {
            $('#klinik').css('display', 'none');
        }
    }
</script>