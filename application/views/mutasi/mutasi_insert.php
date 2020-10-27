<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Mutasi
        <small>Insert</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?php echo $current_context; ?>">Mutasi</a></li>
        <li class="active">Insert</li>
    </ol>
</section>

 <!-- Select2 -->
<!-- <link rel="stylesheet" href="<?php echo base_url(); ?>asset/plugins/select2/select2.min.css"> -->
<script type='text/javascript' src='<?php echo base_url(); ?>asset/js/jquery-2.1.3.js'></script>

    <script language="javascript">
            
            //<![CDATA[
                $(window).load(function(){
                $("#cekkaryawan").on("change", function(){
                    var nilai = $("#cekkaryawan :selected").attr("data-nip");
                    var nilai2 = $("#cekkaryawan :selected").attr("data-nama_karyawan");
                    var nilai3 = $("#cekkaryawan :selected").attr("data-penempatan_awal");
                    var nilai4 = $("#cekkaryawan :selected").attr("data-no_kontrak_lama");
                    var nilai5 = $("#cekkaryawan :selected").attr("data-tgl_masuk_lama");
                    var nilai6 = $("#cekkaryawan :selected").attr("data-tgl_berakhir_lama");
                    $("#nip").val(nilai);
                    $("#nama_karyawan").val(nilai2);
                    $("#penempatan_awal").val(nilai3);
                    $("#no_kontrak_lama").val(nilai4);
                    $("#tgl_masuk_lama").val(nilai5);
                    $("#tgl_berakhir_lama").val(nilai6);
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
                    <h3 class="box-title">Mutasi</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <form role="form" method="POST" enctype="multipart/form-data" class="form-horizontal">
                     

                        <div class="form-group <?php echo (form_error('id_karyawan') != "") ? "has-error" : "" ?>">
                                <label class="control-label col-md-2">Karyawan</label>
                                    <div class="col-md-10">
                                         <select class="form-control select2me" name="id_karyawan" data-placeholder="Pilih..."  id="cekkaryawan">
                                            <option>--Select--</option>
                                            <?php foreach($karyawan_list as $row) { ?>
                                            <option 
                                                value="<?php echo $row->id_karyawan ?>"
                                                data-nip="<?php echo $row->nip; ?>" 
                                                data-nama_karyawan="<?php echo $row->nama_karyawan; ?>"
                                                data-no_kontrak_lama="<?php echo $row->no_kontrak; ?>"
                                                data-tgl_masuk_lama="<?php echo $row->tgl_masuk; ?>"
                                                data-tgl_berakhir_lama="<?php echo $row->tgl_berakhir; ?>"
                                                data-penempatan_awal="<?php echo $row->nama_perusahaan; ?>"><?php echo $row->nip; ?> - <?php echo $row->nama_karyawan; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                <?php echo form_error('id_karyawan'); ?>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-2">NIP</label><div class="col-md-10"><input class="form-control " id="nip" name="nip" type="text"   readonly="readonly" required></div>                           
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-2">Nama Karyawan</label><div class="col-md-10"><input class="form-control " id="nama_karyawan" name="nama_karyawan" type="text"   readonly="readonly" required></div>                            
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-2">Penempatan Awal</label><div class="col-md-10"><input class="form-control " id="penempatan_awal" name="penempatan_awal" type="text"   readonly="readonly" required></div>  
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-2">Nomor Kontrak</label><div class="col-md-10"><input class="form-control " id="no_kontrak_lama" name="no_kontrak_lama" type="text"   readonly="readonly" required></div>  
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-2">Tanggal Masuk</label><div class="col-md-10"><input class="form-control " id="tgl_masuk_lama" name="tgl_masuk_lama" type="text"   readonly="readonly" required></div>  
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-2">Tanggal Berakhir</label><div class="col-md-10"><input class="form-control " id="tgl_berakhir_lama" name="tgl_berakhir_lama" type="text"   readonly="readonly" required></div>  
                        </div>

                        <div class="form-group <?php echo (form_error('id_penempatan') != "") ? "has-error" : "" ?>">
                                <label class="control-label col-md-2">Penempatan Baru</label>
                                    <div class="col-md-10">
                                         <select class="form-control select2me" name="id_penempatan" data-placeholder="Pilih..."  id="id_penempatan">
                                                <option>--Select--</option>
                                                <?php foreach ($penempatan_list as $row) {
                                                    if ($row->id_penempatan == set_value('id_penempatan',$divisi->id_divisi)){
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

                        <div class="form-group <?php echo (form_error('no_kontrak') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Nomor Kontrak</label><div class="col-md-10"><input class="form-control " name="no_kontrak" type="text" value="<?php echo set_value('no_kontrak', $mutasi->no_kontrak); ?>" placeholder="Nomor Kontrak"  maxlength=100 required></div>
                            <?php echo form_error('no_kontrak'); ?>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6">
                                <div class="form-group <?php echo (form_error('tgl_masuk') != "") ? "has-error" : "" ?>">
                                    <label class="control-label col-md-4">Tanggal Masuk</label><div class="col-md-8"><input class="form-control " name="tgl_masuk" type="date" value="<?php echo set_value('tgl_masuk', $mutasi->tgl_masuk); ?>" placeholder="Tanggal Masuk"  maxlength=100 required></div>
                                    <?php echo form_error('tgl_masuk'); ?>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group <?php echo (form_error('tgl_berakhir') != "") ? "has-error" : "" ?>">
                                    <label class="control-label col-md-4">Tanggal Berakhir</label><div class="col-md-8"><input class="form-control " name="tgl_berakhir" type="date" value="<?php echo set_value('tgl_berakhir', $mutasi->tgl_berakhir); ?>" placeholder="Tanggal Berakhir"  maxlength=100 required></div>
                                    <?php echo form_error('tgl_berakhir'); ?>
                                </div>
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