<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Pinjaman
        <small>Insert</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?php echo $current_context; ?>">Pinjaman</a></li>
        <li class="active">Insert</li>
    </ol>
</section>

<script type='text/javascript' src='<?php echo base_url(); ?>asset/js/jquery-2.1.3.js'></script>

    <script language="javascript">
            
            //<![CDATA[
                $(window).load(function(){
                $("#cekkaryawan").on("change", function(){
                    var nilai = $("#cekkaryawan :selected").attr("data-nip");
                    var nilai2 = $("#cekkaryawan :selected").attr("data-nama_karyawan");
                    var nilai3 = $("#cekkaryawan :selected").attr("data-gaji_pokok");
                    var nilai4 = $("#cekkaryawan :selected").attr("data-status_pernikahan");
                    var nilai5 = $("#cekkaryawan :selected").attr("data-fee");
                    var nilai6 = $("#cekkaryawan :selected").attr("data-id_penempatan");
                    $("#nip").val(nilai);
                    $("#nama_karyawan").val(nilai2);
                    $("#gaji_pokok").val(nilai3);
                    $("#status_pernikahan").val(nilai4);
                    $("#fee").val(nilai5);
                    $("#id_penempatan").val(nilai6);
                });
                });//]]>
            
    </script>

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
                    <h3 class="box-title">Pinjaman</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <form role="form" method="POST" enctype="multipart/form-data" class="form-horizontal">

                        <!-- <div class="form-group <?php echo (form_error('id_karyawan') != "") ? "has-error" : "" ?>">
                                <label class="control-label col-md-2">Karyawan</label>
                                    <div class="col-md-10">
                                         <select class="form-control select2me" name="id_karyawan" data-placeholder="Pilih..."  id="id_karyawan">
                                            <option>--Select--</option>
                                            <?php foreach ($karyawan_list as $row) {
                                                if ($row->id_karyawan == set_value('id_karyawan',$pinjaman->id_karyawan)){
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
                        </div> -->

                        <div class="form-group <?php echo (form_error('id_karyawan') != "") ? "has-error" : "" ?>">
                                <label class="control-label col-md-2">Karyawan</label>
                                    <div class="col-md-10">
                                         <select class="form-control select2me" name="id_karyawan" data-placeholder="Pilih..."  id="cekkaryawan" required="required">
                                            <option>--Select--</option>
                                            <?php foreach($karyawan_list as $row) { ?>
                                            <option 
                                                value="<?php echo $row->id_karyawan ?>"
                                                data-nip="<?php echo $row->nip; ?>" 
                                                data-nama_karyawan="<?php echo $row->nama_karyawan; ?>"
                                                data-status_pernikahan="<?php echo $row->status_pernikahan; ?>"
                                                data-fee="<?php echo $row->fee; ?>"
                                                data-id_penempatan="<?php echo $row->id_penempatan; ?>"
                                                data-gaji_pokok="<?php echo $row->gaji_pokok; ?>"><?php echo $row->nip; ?> - <?php echo $row->nama_karyawan; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                <?php echo form_error('id_karyawan'); ?>
                        </div> 
                        <input type="hidden" class="form-control " id="nama_karyawan" name="nama_karyawan" readonly="readonly" required>

                        <div class="form-group <?php echo (form_error('jumlah_pinjaman') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Jumlah Pinjaman</label><div class="col-md-10"><input class="form-control " name="jumlah_pinjaman" type="text" value="<?php echo set_value('jumlah_pinjaman', $pinjaman->jumlah_pinjaman); ?>" placeholder="Jumlah Pinjaman"  maxlength=100 required></div>
                            <?php echo form_error('jumlah_pinjaman'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('tgl_pinjaman') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Tanggal Pinjaman</label><div class="col-md-10"><input class="form-control " name="tgl_pinjaman" type="date" value="<?php echo set_value('tgl_pinjaman', $pinjaman->tgl_pinjaman); ?>" placeholder="Tanggal Pinjaman"  maxlength=100 required></div>
                            <?php echo form_error('tgl_pinjaman'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('nama_pinjaman') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Keterangan</label><div class="col-md-10"><input class="form-control " name="nama_pinjaman" type="text" value="<?php echo set_value('nama_pinjaman', $pinjaman->nama_pinjaman); ?>" placeholder="Keterangan"  maxlength=100 required></div>
                            <?php echo form_error('nama_pinjaman'); ?>
                        </div>

                        <!-- <div class="form-group <?php echo (form_error('keterangan') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Keterangan</label><div class="col-md-10"><input class="form-control " name="keterangan" type="text" value="<?php echo set_value('keterangan', $pinjaman->keterangan); ?>" placeholder="Keterangan"  maxlength=100 required></div>
                            <?php echo form_error('keterangan'); ?>
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