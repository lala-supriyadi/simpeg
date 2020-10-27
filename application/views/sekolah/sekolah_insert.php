<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Pendidikan
        <small>Insert</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?php echo $current_context; ?>">Pendidikan</a></li>
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
                    <h3 class="box-title">Pendidikan</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <form role="form" method="POST" enctype="multipart/form-data" class="form-horizontal">

                        <div class="form-group <?php echo (form_error('id_karyawan') != "") ? "has-error" : "" ?>">
                                <label class="control-label col-md-2">Karyawan</label>
                                    <div class="col-md-10">
                                         <select class="form-control select2me" name="id_karyawan" data-placeholder="Pilih..."  id="id_karyawan">
                                            <option>--Select--</option>
                                            <?php foreach ($karyawan_list as $row) {
                                                if ($row->id_karyawan == set_value('id_karyawan',$sekolah->id_karyawan)){
                                                    echo "<option value='$row->id_karyawan' selected>$row->nip - $row->nama_karyawan</option>";
                                                    } else {
                                                    echo "<option value='$row->id_karyawan'>$row->nip - $row->nama_karyawan</option>";
                                                    }
                                                ?>
                                            <?php }
                                             ?>
                                        </select>
                                    </div>
                                <?php echo form_error('id_karyawan'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('nama_sekolah') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Nama Sekolah</label><div class="col-md-10"><input class="form-control " name="nama_sekolah" type="text" value="<?php echo set_value('nama_sekolah', $sekolah->nama_sekolah); ?>" placeholder="Nama Sekolah"  maxlength=100 required></div>
                            <?php echo form_error('nama_sekolah'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('lokasi') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Lokasi</label><div class="col-md-10"><input class="form-control " name="lokasi" type="text" value="<?php echo set_value('lokasi', $sekolah->lokasi); ?>" placeholder="Lokasi"  maxlength=100 required></div>
                            <?php echo form_error('lokasi'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('grade') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Grade</label>
                            <div class="col-md-10">
                            <select class="form-control select2me" name="grade" required>
                                <option value="">--Select--</option>
                                    <option value="SD">SD</option>
                                    <option value="SMP">SMP</option>
                                    <option value="SMA">SMA</option>
                                    <option value="D3">D3</option>
                                    <option value="S1">S1</option>
                                    <option value="S2">S2</option>
                                <?php if($sekolah->grade == 'SD'):?>
                                    <option value="SD" selected>SD</option>
                                    <option value="SMP">SMP</option>
                                    <option value="SMA">SMA</option>
                                    <option value="D3">D3</option>
                                    <option value="S1">S1</option>
                                    <option value="S2">S2</option>
                                <?php elseif($sekolah->grade == 'SMP'):?>
                                    <option value="SD">SD</option>
                                    <option value="SMP" selected>SMP</option>
                                    <option value="SMA">SMA</option>
                                    <option value="D3">D3</option>
                                    <option value="S1">S1</option>
                                    <option value="S2">S2</option>
                                <?php elseif($sekolah->grade == 'SMA'):?>
                                    <option value="SD">SD</option>
                                    <option value="SMP">SMP</option>
                                    <option value="SMA" selected>SMA</option>
                                    <option value="D3">D3</option>
                                    <option value="S1">S1</option>
                                    <option value="S2">S2</option>
                                <?php elseif($sekolah->grade == 'D3'):?>
                                    <option value="SD">SD</option>
                                    <option value="SMP">SMP</option>
                                    <option value="SMA">SMA</option>
                                    <option value="D3" selected>D3</option>
                                    <option value="S1">S1</option>
                                    <option value="S2">S2</option>
                                <?php elseif($sekolah->grade == 'S1'):?>
                                    <option value="SD">SD</option>
                                    <option value="SMP">SMP</option>
                                    <option value="SMA">SMA</option>
                                    <option value="D3">D3</option>
                                    <option value="S1" selected>S1</option>
                                    <option value="S2">S2</option>
                                <?php elseif($sekolah->grade == 'S2'):?>
                                    <option value="SD">SD</option>
                                    <option value="SMP">SMP</option>
                                    <option value="SMA">SMA</option>
                                    <option value="D3">D3</option>
                                    <option value="S1">S1</option>
                                    <option value="S2" selected>S2</option>                   
                                <?php endif;?>
                            </select>
                            </div>
                        </div>

                        <div class="form-group <?php echo (form_error('jurusan') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Jurusan</label><div class="col-md-10"><input class="form-control " name="jurusan" type="text" value="<?php echo set_value('jurusan', $sekolah->jurusan); ?>" placeholder="Jurusan"  maxlength=100 required></div>
                            <?php echo form_error('jurusan'); ?>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6">
                                <div class="form-group <?php echo (form_error('tgl_ijazah') != "") ? "has-error" : "" ?>">
                                    <label class="control-label col-md-4">Tanggal Ijazah</label><div class="col-md-8"><input class="form-control " name="tgl_ijazah" type="date" value="<?php echo set_value('tgl_ijazah', $sekolah->tgl_ijazah); ?>" placeholder="Tanggal Ijazah"  maxlength=100 required></div>
                                    <?php echo form_error('tgl_ijazah'); ?>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group <?php echo (form_error('no_ijazah') != "") ? "has-error" : "" ?>">
                                    <label class="control-label col-md-4">Nomor Ijazah</label><div class="col-md-8"><input class="form-control " name="no_ijazah" type="text" value="<?php echo set_value('no_ijazah', $sekolah->no_ijazah); ?>" placeholder="Tanggal Lahir"  maxlength=100 required></div>
                                    <?php echo form_error('no_ijazah'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group <?php echo (form_error('nama_kepsek') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Nama Kepala Sekolah/ Rektor</label><div class="col-md-10"><input class="form-control " name="nama_kepsek" type="text" value="<?php echo set_value('nama_kepsek', $sekolah->nama_kepsek); ?>" placeholder="Nama Kepala Sekolah/ Rektor"  maxlength=100 required></div>
                            <?php echo form_error('nama_kepsek'); ?>
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
    function show_clinic(e) {
        var role = $(e).val();
        if (role === '2') {
            $('#klinik').css('display', 'block');
        } else {
            $('#klinik').css('display', 'none');
        }
    }
</script>