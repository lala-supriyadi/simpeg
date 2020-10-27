<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Gaji Karyawan
        <small>Insert</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?php echo $current_context; ?>">Gaji Karyawan</a></li>
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
                    <h3 class="box-title">Gaji Karyawan</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <form role="form" method="POST" enctype="multipart/form-data" class="form-horizontal">
                     
                        
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

                        <div class="form-group">
                            <label class="control-label col-md-2">NIP</label><div class="col-md-10"><input class="form-control " id="nip" name="nip" type="text"   readonly="readonly" required></div>                           
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-2">Nama Karyawan</label><div class="col-md-10"><input class="form-control " id="nama_karyawan" name="nama_karyawan" type="text"   readonly="readonly" required></div>                            
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-2">Gaji Pokok</label>
                            <div class="col-md-10">
                                <div class="input-group">
                                    <input class="form-control " id="gaji_pokok" name="gaji_pokok" type="text"   readonly="readonly" required>
                                    <span class="input-group-addon" style="background-color: lightgrey">Rp</span>
                                </div>
                            </div>  
                        </div>
                        <input type="hidden" class="form-control " id="status_pernikahan" name="status_pernikahan" readonly="readonly" required>
                        <input type="hidden" class="form-control " id="fee" name="fee" readonly="readonly" required>
                        <input type="hidden" class="form-control " id="id_penempatan" name="id_penempatan" readonly="readonly" required>
                        <!-- <input type="hidden" class="form-control " id="id_gaji_karyawan" name="id_gaji_karyawan" readonly="readonly" required> -->

                        <div class="form-group">
                            <label class="control-label col-md-2">PERIODE</label>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6">
                                <div class="form-group <?php echo (form_error('awal_tgl') != "") ? "has-error" : "" ?>">
                                    <label class="control-label col-md-4">Tanggal Awal</label><div class="col-md-8"><input class="form-control " name="awal_tgl" type="date" value="<?php echo set_value('awal_tgl'); ?>" placeholder="Tanggal Awal"  maxlength=100 required></div>
                                    <?php echo form_error('awal_tgl'); ?>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group <?php echo (form_error('akhir_tgl') != "") ? "has-error" : "" ?>">
                                    <label class="control-label col-md-4">Tanggal Akhir</label><div class="col-md-8"><input class="form-control " name="akhir_tgl" type="date" value="<?php echo set_value('akhir_tgl', $gaji_karyawan->periode); ?>" placeholder="Tanggal Akhir"  maxlength=100 required></div>
                                    <?php echo form_error('akhir_tgl'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-2">TUNJANGAN</label>
                        </div>

                        <!-- <div class="form-group <?php echo (form_error('tunj_jabatan') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Tunjangan Jabatan</label>
                            <div class="col-md-10 input-group"><input class="form-control " name="tunj_jabatan" type="text" value="<?php echo set_value('tunj_jabatan', $gaji_karyawan->tunj_jabatan); ?>" placeholder="Tunjangan Jabatan"  maxlength=100 >
                                
                                    <span class="input-group-addon">Rp</span>
                            </div>
                            <?php echo form_error('tunj_jabatan'); ?>
                        </div> -->

                        <div class="form-group <?php echo (form_error('tunj_jabatan') != "") ? "has-error" : "" ?>">  
                            <label class="control-label col-md-2">Tunjangan Jabatan</label>
                            <div class="col-md-10">
                                <div class="input-group">
                                    <input class="form-control" name="tunj_jabatan" value="<?php echo set_value('tunj_jabatan', $gaji_karyawan->tunj_jabatan); ?>" placeholder="Tunjangan Jabatan" maxlength=100>
                                    <span class="input-group-addon" style="background-color: lightgrey">Rp</span>
                                </div>
                            </div>    
                            <?php echo form_error('tunj_jabatan'); ?>
                        </div>

                        <!-- <div class="form-group <?php echo (form_error('bpjstk_stat_tun') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Tunjangan BPJSTK</label><div class="col-md-10">
                                <div class="radio">
                                    <label>
                                    <input type="radio" name="bpjstk_stat_tun" value="1" <?php echo set_value('bpjstk_stat_tun', ($gaji_karyawan->bpjstk_stat_tun == '1') ? "checked" : ""); ?>> Aktif
                                    &nbsp &nbsp &nbsp &nbsp &nbsp
                                    <input type="radio" name="bpjstk_stat_tun" value="0" <?php echo set_value('bpjstk_stat_tun', ($gaji_karyawan->bpjstk_stat_tun == '0') ? "checked" : ""); ?>> Tidak Aktif
                                    </label>
                                </div>
                            </div>
                            <?php echo form_error('bpjstk_stat_tun'); ?>
                        </div> -->

                        <div class="form-group <?php echo (form_error('bpjstk_stat_tun') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Tunjangan BPJSTK</label>
                                <div class="col-md-10">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="bpjstk_stat_tun" value="1" <?php echo set_value('bpjstk_stat_tun', ($gaji_karyawan->bpjstk_stat_tun == '1') ? "checked" : ""); ?>> Aktif
                                        <!-- </label>
                                        <label> --> &nbsp &nbsp &nbsp &nbsp &nbsp
                                            <input type="radio" name="bpjstk_stat_tun" value="0" <?php echo set_value('bpjstk_stat_tun', ($gaji_karyawan->bpjstk_stat_tun === '0') ? "checked" : ""); ?>> Tidak Aktif
                                        </label>
                                    </div>
                                </div>
                            <?php echo form_error('bpjstk_stat_tun'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('bpjskes_stat_tun') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Tunjangan BPJSKES</label>
                                <div class="col-md-10">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="bpjskes_stat_tun" value="1" <?php echo set_value('bpjskes_stat_tun', ($gaji_karyawan->bpjskes_stat_tun == '1') ? "checked" : ""); ?>> Aktif
                                        <!-- </label>
                                        <label> --> &nbsp &nbsp &nbsp &nbsp &nbsp
                                            <input type="radio" name="bpjskes_stat_tun" value="0" <?php echo set_value('bpjskes_stat_tun', ($gaji_karyawan->bpjskes_stat_tun === '0') ? "checked" : ""); ?>> Tidak Aktif
                                        </label>
                                    </div>
                                </div>
                            <?php echo form_error('bpjskes_stat_tun'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('dapen_stat_tun') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Tunjangan Dapen</label>
                                <div class="col-md-10">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="dapen_stat_tun" value="1" <?php echo set_value('dapen_stat_tun', ($gaji_karyawan->dapen_stat_tun == '1') ? "checked" : ""); ?>> Aktif
                                        <!-- </label>
                                        <label> --> &nbsp &nbsp &nbsp &nbsp &nbsp
                                            <input type="radio" name="dapen_stat_tun" value="0" <?php echo set_value('dapen_stat_tun', ($gaji_karyawan->dapen_stat_tun === '0') ? "checked" : ""); ?>> Tidak Aktif
                                        </label>
                                    </div>
                                </div>
                            <?php echo form_error('dapen_stat_tun'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('tunj_makan') != "") ? "has-error" : "" ?>">  
                            <label class="control-label col-md-2">Tunjangan Makan</label>
                            <div class="col-md-10">
                                <div class="input-group">
                                    <input class="form-control" name="tunj_makan" value="<?php echo set_value('tunj_makan', $gaji_karyawan->tunj_makan); ?>" placeholder="Tunjangan Makan" maxlength=100 >
                                    <span class="input-group-addon" style="background-color: lightgrey">Rp</span>
                                </div>
                            </div>    
                            <?php echo form_error('tunj_makan'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('tunj_lain') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Tunjangan Lain-Lain</label>
                            <div class="col-md-10">
                                <div class="input-group">
                                    <input class="form-control " name="tunj_lain" type="text" value="<?php echo set_value('tunj_lain', $gaji_karyawan->tunj_lain); ?>" placeholder="Tunjangan Lain-Lain"  maxlength=100 >
                                    <span class="input-group-addon" style="background-color: lightgrey">Rp</span>
                                </div>
                            </div>
                            <?php echo form_error('tunj_lain'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('rafel') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Rafel</label>
                            <div class="col-md-10">
                                <div class="input-group">
                                    <input class="form-control " name="rafel" type="text" value="<?php echo set_value('rafel', $gaji_karyawan->rafel); ?>" placeholder="Rafel"  maxlength=100 >
                                    <span class="input-group-addon" style="background-color: lightgrey">Rp</span>
                                </div>
                            </div>
                            <?php echo form_error('rafel'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('thr') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">THR</label>
                            <div class="col-md-10">
                                <div class="input-group">
                                    <input class="form-control " name="thr" type="text" value="<?php echo set_value('thr', $gaji_karyawan->thr); ?>" placeholder="THR"  maxlength=100 >
                                    <span class="input-group-addon" style="background-color: lightgrey">Rp</span>
                                </div>
                            </div>
                            <?php echo form_error('thr'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('jatah_cuti_mandiri') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Jatah Cuti Mandiri</label>
                            <div class="col-md-10">
                                <div class="input-group">
                                    <input class="form-control " name="jatah_cuti_mandiri" type="text" value="<?php echo set_value('jatah_cuti_mandiri', $gaji_karyawan->jatah_cuti_mandiri); ?>" placeholder="Jatah Cuti Mandiri"  maxlength=100 >
                                    <span class="input-group-addon" style="background-color: lightgrey">Rp</span>
                                </div>
                            </div>
                            <?php echo form_error('jatah_cuti_mandiri'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('jatah_cuti_bersama') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Jatah Cuti Bersama</label>
                            <div class="col-md-10">
                                <div class="input-group">
                                    <input class="form-control " name="jatah_cuti_bersama" type="text" value="<?php echo set_value('jatah_cuti_bersama', $gaji_karyawan->jatah_cuti_bersama); ?>" placeholder="Jatah Cuti Bersama"  maxlength=100 >
                                    <span class="input-group-addon" style="background-color: lightgrey">Rp</span>
                                </div>
                            </div>
                            <?php echo form_error('jatah_cuti_bersama'); ?>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-2">POTONGAN</label>
                        </div>

                        <div class="form-group <?php echo (form_error('potongan_simpanan_wajib') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Potongan Simpanan Wajib</label>
                            <div class="col-md-10">
                                <div class="input-group">
                                    <input class="form-control " name="potongan_simpanan_wajib" type="text" value="<?php echo set_value('potongan_simpanan_wajib', $gaji_karyawan->potongan_simpanan_wajib); ?>" placeholder="Potongan Simpanan Wajib"  maxlength=100 >
                                    <span class="input-group-addon" style="background-color: lightgrey">Rp</span>
                                </div>
                            </div>
                            <?php echo form_error('potongan_simpanan_wajib'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('potongan_sekunder') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Potongan Sekunder</label>
                            <div class="col-md-10">
                                <div class="input-group">
                                    <input class="form-control " name="potongan_sekunder" type="text" value="<?php echo set_value('potongan_sekunder', $gaji_karyawan->potongan_sekunder); ?>" placeholder="Potongan Sekunder"  maxlength=100 >
                                    <span class="input-group-addon" style="background-color: lightgrey">Rp</span>
                                </div>
                            </div>
                            <?php echo form_error('potongan_sekunder'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('potongan_darurat') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Potongan Darurat</label>
                            <div class="col-md-10">
                                <div class="input-group">
                                    <input class="form-control " name="potongan_darurat" type="text" value="<?php echo set_value('potongan_darurat', $gaji_karyawan->potongan_darurat); ?>" placeholder="Potongan Darurat"  maxlength=100 >
                                    <span class="input-group-addon" style="background-color: lightgrey">Rp</span>
                                </div>
                            </div>
                            <?php echo form_error('potongan_darurat'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('potongan_toko') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Potongan Toko</label>
                            <div class="col-md-10">
                                <div class="input-group">
                                    <input class="form-control " name="potongan_toko" type="text" value="<?php echo set_value('potongan_toko', $gaji_karyawan->potongan_toko); ?>" placeholder="Potongan Toko"  maxlength=100 >
                                    <span class="input-group-addon" style="background-color: lightgrey">Rp</span>
                                </div>
                            </div>
                            <?php echo form_error('potongan_toko'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('absen') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Potongan Absensi</label>
                            <div class="col-md-10">
                                <div class="input-group">
                                    <input class="form-control " name="absen" type="text" value="<?php echo set_value('absen', $gaji_karyawan->absen); ?>" placeholder="Potongan Absensi"  maxlength=100 >
                                    <span class="input-group-addon" style="background-color: lightgrey">Hari</span>
                                </div>
                            </div>
                            <?php echo form_error('absen'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('potongan_lain') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Potongan Koperasi</label>
                            <div class="col-md-10">
                                <div class="input-group">
                                    <input class="form-control " name="potongan_lain" type="text" value="<?php echo set_value('potongan_lain', $gaji_karyawan->potongan_lain); ?>" placeholder="Potongan Koperasi"  maxlength=100 >
                                    <span class="input-group-addon" style="background-color: lightgrey">Rp</span>
                                </div>
                            </div>
                            <?php echo form_error('potongan_lain'); ?>
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