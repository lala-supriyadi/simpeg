<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Penagihan
        <small>Insert</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?php echo $current_context; ?>">Penagihan</a></li>
        <li class="active">Insert</li>
    </ol>
</section>

 <!-- Select2 -->
<link rel="stylesheet" href="<?php echo base_url(); ?>asset/plugins/select2/select2.min.css">
<script type='text/javascript' src='<?php echo base_url(); ?>asset/js/jquery-2.1.3.js'></script>

    <script language="javascript">
            
            //<![CDATA[
                $(window).load(function(){
                $("#cekkaryawan").on("change", function(){
                    var nilai = $("#cekkaryawan :selected").attr("data-nip");
                    var nilai2 = $("#cekkaryawan :selected").attr("data-nama_karyawan");
                    var nilai3 = $("#cekkaryawan :selected").attr("data-thp");
                    var nilai4 = $("#cekkaryawan :selected").attr("data-tunj_bpjskes");
                    var nilai5 = $("#cekkaryawan :selected").attr("data-tunj_bpjstk");
                    var nilai6 = $("#cekkaryawan :selected").attr("data-fee");
                    var nilai7 = $("#cekkaryawan :selected").attr("data-pph21_bulan");
                    var nilai8 = $("#cekkaryawan :selected").attr("data-nama_perusahaan");
                    // var nilai9 = $("#cekkaryawan :selected").attr("data-periode");
                    var nilai10 = $("#cekkaryawan :selected").attr("data-id_penempatan");
                    var nilai11 = $("#cekkaryawan :selected").attr("data-id_gaji_karyawan");
                    var nilai12 = $("#cekkaryawan :selected").attr("data-potongan_absensi");
                    $("#nip").val(nilai);
                    $("#nama_karyawan").val(nilai2);
                    $("#thp").val(nilai3);
                    $("#tunj_bpjskes").val(nilai4);
                    $("#tunj_bpjstk").val(nilai5);
                    $("#fee").val(nilai6);
                    $("#pph21_bulan").val(nilai7);
                    $("#nama_perusahaan").val(nilai8);
                    // $("#periode").val(nilai9);
                    $("#id_penempatan").val(nilai10);
                    $("#id_gaji_karyawan").val(nilai11);
                    $("#potongan_absensi").val(nilai12);
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
                    <h3 class="box-title">Penagihan</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <form role="form" method="POST" enctype="multipart/form-data" class="form-horizontal">
                     

                        <div class="form-group <?php echo (form_error('id_karyawan') != "") ? "has-error" : "" ?>">
                                <label class="control-label col-md-2">Karyawan</label>
                                    <div class="col-md-10">
                                         <select class="form-control select2me" name="id_karyawan" data-placeholder="Pilih..."  id="cekkaryawan">
                                            <option>--Select--</option>
                                            <?php foreach($Gajikaryawanlist as $row) { ?>
                                            <option 
                                                value="<?php echo $row->id_karyawan ?>"
                                                data-nip="<?php echo $row->nip; ?>" 
                                                data-nama_karyawan="<?php echo $row->nama_karyawan; ?>"
                                                data-thp="<?php echo $row->thp; ?>"
                                                data-tunj_bpjskes="<?php echo $row->tunj_bpjskes; ?>"
                                                data-tunj_bpjstk="<?php echo $row->tunj_bpjstk; ?>"
                                                data-fee="<?php echo $row->fee; ?>"
                                                data-nama_perusahaan="<?php echo $row->nama_perusahaan; ?>"
                                                data-id_penempatan="<?php echo $row->id_penempatan; ?>"
                                                data-id_gaji_karyawan="<?php echo $row->id_gaji_karyawan; ?>"
                                                data-potongan_absensi="<?php echo $row->potongan_absensi; ?>"
                                                data-pph21_bulan="<?php echo $row->pph21_bulan; ?>"><?php echo $row->nip; ?> - <?php echo $row->nama_karyawan; ?></option>
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
                            <label class="control-label col-md-2">Premi BPJSKES</label><div class="col-md-10"><input class="form-control " id="tunj_bpjskes" name="tunj_bpjskes" type="text"   readonly="readonly" required></div>  
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-2">Premi BPJSTK</label><div class="col-md-10"><input class="form-control " id="tunj_bpjstk" name="tunj_bpjstk" type="text"   readonly="readonly" required></div>  
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-2">Gaji</label><div class="col-md-10"><input class="form-control " id="thp" name="thp" type="text"   readonly="readonly" required></div>  
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-2">PPH 21</label><div class="col-md-10"><input class="form-control " id="pph21_bulan" name="pph21_bulan" type="text"   readonly="readonly" required></div>  
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-2">Penempatan</label><div class="col-md-10"><input class="form-control " id="nama_perusahaan" name="nama_perusahaan" type="text"   readonly="readonly" required></div>  
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-2">Fee PT (%)</label><div class="col-md-10"><input class="form-control " id="fee" name="fee" type="text"   readonly="readonly" required></div>  
                        </div>
                        <!-- <input class="form-control " id="periode" name="periode" type="hidden" readonly="readonly" required> -->
                        <input class="form-control " id="id_penempatan" name="id_penempatan" type="hidden" readonly="readonly" required>
                        <input class="form-control " id="id_gaji_karyawan" name="id_gaji_karyawan" type="hidden" readonly="readonly" required>
                        <input class="form-control " id="potongan_absensi" name="potongan_absensi" type="hidden" readonly="readonly" required>

                        <div class="form-group <?php echo (form_error('periode') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Periode</label><div class="col-md-10"><input class="form-control " name="periode" type="date" value="<?php echo set_value('periode', $penagihan->periode); ?>" placeholder="Periode"  maxlength=100 required></div>
                            <?php echo form_error('periode'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('rafel') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Rafel</label><div class="col-md-10"><input class="form-control " name="rafel" type="text" value="<?php echo set_value('rafel', $penagihan->rafel); ?>" placeholder="Rafel"  maxlength=100 ></div>
                            <?php echo form_error('rafel'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('thr') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">THR</label><div class="col-md-10"><input class="form-control " name="thr" type="text" value="<?php echo set_value('thr', $penagihan->thr); ?>" placeholder="THR"  maxlength=100 ></div>
                            <?php echo form_error('thr'); ?>
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