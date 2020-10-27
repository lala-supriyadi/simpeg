<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Kontrak
        <small>Insert</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?php echo $current_context; ?>">Kontrak</a></li>
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
                    <h3 class="box-title">Kontrak</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <form role="form" method="POST" enctype="multipart/form-data" class="form-horizontal">

                        <div class="form-group <?php echo (form_error('id_karyawan') != "") ? "has-error" : "" ?>">
                                <label class="control-label col-md-2">Karyawan</label>
                                    <div class="col-md-10">
                                         <select class="form-control select2me" name="id_karyawan" data-placeholder="Pilih..."  id="id_karyawan">
                                            <option>--Select--</option>
                                            <?php foreach ($karyawan_list as $row) {
                                                if ($row->id_karyawan == set_value('id_karyawan',$karyawan->id_karyawan)){
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

                        <div class="form-group <?php echo (form_error('no_kontrak') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Nomor Kontrak</label><div class="col-md-10"><input class="form-control " name="no_kontrak" type="text" value="<?php echo set_value('no_kontrak', $kontrak->no_kontrak); ?>" placeholder="Nomor Kontrak"  maxlength=100 required></div>
                            <?php echo form_error('no_kontrak'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('tgl_mulai') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Tanggal Masuk</label><div class="col-md-10"><input class="form-control " name="tgl_mulai" type="date" value="<?php echo set_value('tgl_mulai', $kontrak->tgl_mulai); ?>" placeholder="Tanggal Masuk"  maxlength=100 required></div>
                            <?php echo form_error('tgl_mulai'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('tgl_selesai') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Tanggal Berakhir</label><div class="col-md-10"><input class="form-control " name="tgl_selesai" type="date" value="<?php echo set_value('tgl_selesai', $kontrak->tgl_selesai); ?>" placeholder="Tanggal Berakhir"  maxlength=100 required></div>
                            <?php echo form_error('tgl_selesai'); ?>
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