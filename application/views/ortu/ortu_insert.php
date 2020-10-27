<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Orang Tua
        <small>Insert</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?php echo $current_context; ?>">Orang Tua</a></li>
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
                    <h3 class="box-title">Orang Tua</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <form role="form" method="POST" enctype="multipart/form-data" class="form-horizontal">

                        <div class="form-group <?php echo (form_error('id_karyawan') != "") ? "has-error" : "" ?>">
                                <label class="control-label col-md-2">Karyawan</label>
                                    <div class="col-md-10">
                                         <select class="form-control select2me" name="id_karyawan" data-placeholder="Pilih..."  id="id_karyawan">
                                            <option>--Select--</option>
                                            <?php foreach ($karyawan_list as $row) {
                                                if ($row->id_karyawan == set_value('id_karyawan',$ortu->id_karyawan)){
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

                        <div class="form-group <?php echo (form_error('nik') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">NIK</label><div class="col-md-10"><input class="form-control " name="nik" type="text" value="<?php echo set_value('nik', $ortu->nik); ?>" placeholder="NIK"  maxlength=100 required></div>
                            <?php echo form_error('nik'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('nama_ortu') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Nama Orang Tua</label><div class="col-md-10"><input class="form-control " name="nama_ortu" type="text" value="<?php echo set_value('nama_ortu', $ortu->nama_ortu); ?>" placeholder="Nama Orang Tua"  maxlength=100 required></div>
                            <?php echo form_error('nama_ortu'); ?>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6">
                                <div class="form-group <?php echo (form_error('tempat_lahir') != "") ? "has-error" : "" ?>">
                                    <label class="control-label col-md-4">Tempat Lahir</label><div class="col-md-8"><input class="form-control " name="tempat_lahir" type="text" value="<?php echo set_value('tempat_lahir', $ortu->tempat_lahir); ?>" placeholder="Tempat Lahir"  maxlength=100 required></div>
                                    <?php echo form_error('tempat_lahir'); ?>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group <?php echo (form_error('tgl_lahir') != "") ? "has-error" : "" ?>">
                                    <label class="control-label col-md-4">Tanggal Lahir</label><div class="col-md-8"><input class="form-control " name="tgl_lahir" type="date" value="<?php echo set_value('tgl_lahir', $ortu->tgl_lahir); ?>" placeholder="Tanggal Lahir"  maxlength=100 required></div>
                                    <?php echo form_error('tgl_lahir'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group <?php echo (form_error('pendidikan') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Pendidikan</label>
                            <div class="col-md-10">
                            <select class="form-control select2me" name="pendidikan" required>
                                <option value="">--Select--</option>
                                    <option value="SD">SD</option>
                                    <option value="SMP">SMP</option>
                                    <option value="SMA">SMA</option>
                                    <option value="D3">D3</option>
                                    <option value="S1">S1</option>
                                    <option value="S2">S2</option>
                                <?php if($ortu->pendidikan == 'SD'):?>
                                    <option value="SD" selected>SD</option>
                                    <option value="SMP">SMP</option>
                                    <option value="SMA">SMA</option>
                                    <option value="D3">D3</option>
                                    <option value="S1">S1</option>
                                    <option value="S2">S2</option>
                                <?php elseif($ortu->pendidikan == 'SMP'):?>
                                    <option value="SD">SD</option>
                                    <option value="SMP" selected>SMP</option>
                                    <option value="SMA">SMA</option>
                                    <option value="D3">D3</option>
                                    <option value="S1">S1</option>
                                    <option value="S2">S2</option>
                                <?php elseif($ortu->pendidikan == 'SMA'):?>
                                    <option value="SD">SD</option>
                                    <option value="SMP">SMP</option>
                                    <option value="SMA" selected>SMA</option>
                                    <option value="D3">D3</option>
                                    <option value="S1">S1</option>
                                    <option value="S2">S2</option>
                                <?php elseif($ortu->pendidikan == 'D3'):?>
                                    <option value="SD">SD</option>
                                    <option value="SMP">SMP</option>
                                    <option value="SMA">SMA</option>
                                    <option value="D3" selected>D3</option>
                                    <option value="S1">S1</option>
                                    <option value="S2">S2</option>
                                <?php elseif($ortu->pendidikan == 'S1'):?>
                                    <option value="SD">SD</option>
                                    <option value="SMP">SMP</option>
                                    <option value="SMA">SMA</option>
                                    <option value="D3">D3</option>
                                    <option value="S1" selected>S1</option>
                                    <option value="S2">S2</option>
                                <?php elseif($ortu->pendidikan == 'S2'):?>
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

                        <div class="form-group <?php echo (form_error('pekerjaan') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Pekerjaan</label><div class="col-md-10"><input class="form-control " name="pekerjaan" type="text" value="<?php echo set_value('pekerjaan', $ortu->pekerjaan); ?>" placeholder="Pekerjaan"  maxlength=100 required></div>
                            <?php echo form_error('pekerjaan'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('hubungan') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Hubungan</label>
                            <div class="col-md-10">
                            <select class="form-control select2me" name="hubungan" >
                                <option value="">--Select--</option>
                                <option value="Ayah">Ayah</option>
                                <option value="Ibu">Ibu</option>
                                <?php if($ortu->hubungan == 'Ayah'):?>
                                    <option value="Ayah" selected>Ayah</option>
                                    <option value="Ibu">Ibu</option>
                                <?php elseif($ortu->hubungan == 'Ibu'):?>
                                    <option value="Ayah">Ayah</option>
                                    <option value="Ibu" selected>Ibu</option>        
                                <?php endif;?>
                            </select>
                            </div>
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