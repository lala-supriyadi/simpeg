<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Divisi
        <small>Insert</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?php echo $current_context; ?>">Divisi</a></li>
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
                    <h3 class="box-title">Divisi</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <form role="form" method="POST" enctype="multipart/form-data" class="form-horizontal">

                        <div class="form-group <?php echo (form_error('nama_divisi') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Nama Divisi</label><div class="col-md-10"><input class="form-control " name="nama_divisi" type="text" value="<?php echo set_value('nama_divisi', $divisi->nama_divisi); ?>" placeholder="Divisi"  maxlength=100 required></div>
                            <?php echo form_error('nama_divisi'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('id_penempatan') != "") ? "has-error" : "" ?>">
                                <label class="control-label col-md-2">Nama Perusahaan</label>
                                    <div class="col-md-10">
                                         <select class="form-control select2me" name="id_penempatan" data-placeholder="Pilih..."  id="id_penempatan">
                                            <option>--Select--</option>
                                            <?php foreach ($penempatan_list as $row) {
                                                if ($row->id_penempatan == set_value('id_penempatan',$divisi->id_penempatan)){
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