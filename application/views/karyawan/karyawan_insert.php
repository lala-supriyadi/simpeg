<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Karyawan
        <small>Insert</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?php echo $current_context; ?>">Karyawan</a></li>
        <li class="active">Insert</li>
    </ol>
</section>

<script type='text/javascript' src='<?php echo base_url(); ?>asset/js/jquery-2.1.3.js'></script>

    <script language="javascript">
            
            //<![CDATA[
                $(window).load(function(){
                $("#cekkaryawan").on("change", function(){
                    var nilai = $("#cekkaryawan :selected").attr("data-nama_divisi");
                    $("#nama_divisi").val(nilai);
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
                    <h3 class="box-title">Karyawan</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <form role="form" method="POST" enctype="multipart/form-data" class="form-horizontal">

                        <div class="form-group <?php echo (form_error('nip') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Nomor Induk Karyawan</label><div class="col-md-10"><input class="form-control " name="nip" type="text" value="<?php echo set_value('nip', $karyawan->nip); ?>" placeholder="Nomor Induk Karyawan"  maxlength=100 required></div>
                            <?php echo form_error('nip'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('kode_pagu') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Kode Pagu</label><div class="col-md-10"><input class="form-control " name="kode_pagu" type="text" value="<?php echo set_value('kode_pagu', $karyawan->kode_pagu); ?>" placeholder="Kode Pagu"  maxlength=100 required></div>
                            <?php echo form_error('kode_pagu'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('nik') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Nomor KTP</label><div class="col-md-10"><input class="form-control " name="nik" type="text" value="<?php echo set_value('nik', $karyawan->nik); ?>" placeholder="Nomor KTP"  maxlength=100 required></div>
                            <?php echo form_error('nik'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('no_npwp') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Nomor NPWP</label><div class="col-md-10"><input class="form-control " name="no_npwp" type="text" value="<?php echo set_value('no_npwp', $karyawan->no_npwp); ?>" placeholder="Nomor NPWP"  maxlength=100 required></div>
                            <?php echo form_error('no_npwp'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('nama_karyawan') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Nama Karyawan</label><div class="col-md-10"><input class="form-control " name="nama_karyawan" type="text" value="<?php echo set_value('nama_karyawan', $karyawan->nama_karyawan); ?>" placeholder="Nama Karyawan"  maxlength=100 required></div>
                            <?php echo form_error('nama_karyawan'); ?>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6">
                                <div class="form-group <?php echo (form_error('tempat_lahir') != "") ? "has-error" : "" ?>">
                                    <label class="control-label col-md-4">Tempat Lahir</label><div class="col-md-8"><input class="form-control " name="tempat_lahir" type="text" value="<?php echo set_value('tempat_lahir', $karyawan->tempat_lahir); ?>" placeholder="Tempat Lahir"  maxlength=100 required></div>
                                    <?php echo form_error('tempat_lahir'); ?>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group <?php echo (form_error('tgl_lahir') != "") ? "has-error" : "" ?>">
                                    <label class="control-label col-md-4">Tanggal Lahir</label><div class="col-md-8"><input class="form-control " name="tgl_lahir" type="date" value="<?php echo set_value('tgl_lahir', $karyawan->tgl_lahir); ?>" placeholder="Tanggal Lahir"  maxlength=100 required></div>
                                    <?php echo form_error('tgl_lahir'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group <?php echo (form_error('foto') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Foto</label><div class="col-md-10"><input class="form-control " name="foto" type="file" value="<?php echo set_value('foto', $karyawan->foto); ?>" placeholder="Foto"  maxlength=100 required></div>
                            <?php echo form_error('foto'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('agama') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Agama</label>
                            <div class="col-md-10">
                            <select class="form-control select2me" name="agama" required>
                                <option value="">--Select--</option>
                                    <option value="Budha">Budha</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Katolik">Katolik</option>
                                    <option value="Konghucu">Konghucu</option>
                                    <option value="Protestan">Protestan</option>
                                <?php if($karyawan->agama == 'Budha'):?>
                                    <option value="Budha" selected>Budha</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Katolik">Katolik</option>
                                    <option value="Konghucu">Konghucu</option>
                                    <option value="Protestan">Protestan</option>
                                <?php elseif($karyawan->agama == 'Hindu'):?>
                                    <option value="Budha">Budha</option>
                                    <option value="Hindu" selected>Hindu</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Katolik">Katolik</option>
                                    <option value="Konghucu">Konghucu</option>
                                    <option value="Protestan">Protestan</option>
                                <?php elseif($karyawan->agama == 'Islam'):?>
                                    <option value="Budha">Budha</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Islam" selected>Islam</option>
                                    <option value="Katolik">Katolik</option>
                                    <option value="Konghucu">Konghucu</option>
                                    <option value="Protestan">Protestan</option>
                                <?php elseif($karyawan->agama == 'Katolik'):?>
                                    <option value="Budha">Budha</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Katolik" selected>Katolik</option>
                                    <option value="Konghucu">Konghucu</option>
                                    <option value="Protestan">Protestan</option>
                                <?php elseif($karyawan->agama == 'Konghucu'):?>
                                    <option value="Budha">Budha</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Katolik">Katolik</option>
                                    <option value="Konghucu" selected>Konghucu</option>
                                    <option value="Protestan">Protestan</option>
                                <?php elseif($karyawan->agama == 'Protestan'):?>
                                    <option value="Budha">Budha</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Katolik">Katolik</option>
                                    <option value="Konghucu">Konghucu</option>
                                    <option value="Protestan" selected>Protestan</option>          
                                <?php endif;?>
                            </select>
                            </div>
                        </div>

                        <div class="form-group <?php echo (form_error('jenis_kelamin') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Jenis Kelamin</label>
                                <div class="col-md-10">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="jenis_kelamin" value="L" <?php echo set_value('jenis_kelamin', ($karyawan->jenis_kelamin == 'L') ? "checked" : ""); ?>> Laki-laki
                                        <!-- </label>
                                        <label> --> &nbsp &nbsp &nbsp &nbsp &nbsp
                                            <input type="radio" name="jenis_kelamin" value="P" <?php echo set_value('jenis_kelamin', ($karyawan->jenis_kelamin === 'P') ? "checked" : ""); ?>> Perempuan
                                        </label>
                                    </div>
                                </div>
                            <?php echo form_error('jenis_kelamin'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('alamat') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Alamat</label><div class="col-md-10"><input class="form-control " name="alamat" type="text" value="<?php echo set_value('alamat', $karyawan->alamat); ?>" placeholder="Alamat"  maxlength=100 required></div>
                            <?php echo form_error('alamat'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('no_telp') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Nomor Telepon</label><div class="col-md-10"><input class="form-control " name="no_telp" type="text" value="<?php echo set_value('no_telp', $karyawan->no_telp); ?>" placeholder="Nomor Telepon"  maxlength=100 required></div>
                            <?php echo form_error('no_telp'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('email') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Email</label><div class="col-md-10"><input class="form-control " name="email" type="text" value="<?php echo set_value('email', $karyawan->email); ?>" placeholder="Email"  maxlength=100 required></div>
                            <?php echo form_error('email'); ?>
                        </div>

                        <div class="form-group">
                            <!-- <div class="col-md-6">
                                <div class="form-group <?php echo (form_error('bank') != "") ? "has-error" : "" ?>">
                                    <label class="control-label col-md-4">Bank</label><div class="col-md-8"><input class="form-control " name="bank" type="text" value="<?php echo set_value('bank', $karyawan->bank); ?>" placeholder="Bank"  maxlength=100 required></div>
                                    <?php echo form_error('bank'); ?>
                                </div>
                            </div> -->

                            <div class="col-md-6">
                                <div class="form-group <?php echo (form_error('bank') != "") ? "has-error" : "" ?>">
                                    <label class="control-label col-md-4">Bank</label>
                                    <div class="col-md-8">
                                        <select class="form-control select2me" name="bank" >
                                            <option value="">--Select--</option>
                                                <option value="BCA">BCA</option>
                                                <option value="BNI">BNI</option>
                                                <option value="BRI">BRI</option>
                                                <option value="MANDIRI">MANDIRI</option>
                                                <option value="CASH">CASH</option>
                                            <?php if($karyawan->bank == 'BCA'):?>
                                                <option value="BCA" selected>BCA</option>
                                                <option value="BNI">BNI</option>
                                                <option value="BRI">BRI</option>
                                                <option value="MANDIRI">MANDIRI</option>
                                                <option value="CASH">CASH</option>
                                            <?php elseif($karyawan->bank == 'BNI'):?>
                                                <option value="BCA">BCA</option>
                                                <option value="BNI" selected>BNI</option>
                                                <option value="BRI">BRI</option>
                                                <option value="MANDIRI">MANDIRI</option>
                                                <option value="CASH">CASH</option>
                                            <?php elseif($karyawan->bank == 'BRI'):?>
                                                <option value="BCA">BCA</option>
                                                <option value="BNI">BNI</option>
                                                <option value="BRI" selected>BRI</option>
                                                <option value="MANDIRI">MANDIRI</option>
                                                <option value="CASH">CASH</option>
                                            <?php elseif($karyawan->bank == 'MANDIRI'):?>
                                                <option value="BCA">BCA</option>
                                                <option value="BNI">BNI</option>
                                                <option value="BRI">BRI</option>
                                                <option value="MANDIRI" selected>MANDIRI</option>
                                                <option value="CASH">CASH</option>
                                            <?php elseif($karyawan->bank == 'CASH'):?>
                                                <option value="BCA">BCA</option>
                                                <option value="BNI">BNI</option>
                                                <option value="BRI">BRI</option>
                                                <option value="MANDIRI">MANDIRI</option>
                                                <option value="CASH" selected>CASH</option>  
                                            <?php endif;?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group <?php echo (form_error('no_rekening') != "") ? "has-error" : "" ?>">
                                    <label class="control-label col-md-4">Nomor Rekening</label><div class="col-md-8"><input class="form-control " name="no_rekening" type="text" value="<?php echo set_value('no_rekening', $karyawan->no_rekening); ?>" placeholder="Nomor Rekening"  maxlength=100 required></div>
                                    <?php echo form_error('no_rekening'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group <?php echo (form_error('status_pernikahan') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Status Pernikahan</label>
                            <div class="col-md-10">
                            <select class="form-control select2me" name="status_pernikahan" >
                                <option value="">--Select--</option>
                                    <option value="Menikah">Menikah</option>
                                    <option value="Belum Menikah">Belum Menikah</option>
                                <?php if($karyawan->status_pernikahan == 'Menikah'):?>
                                    <option value="Menikah" selected>Menikah</option>
                                    <option value="Belum Menikah">Belum Menikah</option>
                                <?php elseif($karyawan->status_pernikahan == 'Belum Menikah'):?>
                                    <option value="Menikah">Menikah</option>
                                    <option value="Belum Menikah" selected>Belum Menikah</option>       
                                <?php endif;?>
                            </select>
                            </div>
                        </div>

                        <!-- <div class="form-group <?php echo (form_error('grade') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Grade</label><div class="col-md-10"><input class="form-control " name="grade" type="text" value="<?php echo set_value('grade', $karyawan->grade); ?>" placeholder="Grade"  maxlength=100 required></div>
                            <?php echo form_error('grade'); ?>
                        </div> -->

                        <div class="form-group <?php echo (form_error('grade') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Grade</label>
                            <div class="col-md-10">
                            <select class="form-control select2me" name="grade" required>
                                <option value="">--Select--</option>
                                    <option value="SMP">SMP</option>
                                    <option value="SMA">SMA</option>
                                    <option value="SMK">SMK</option>
                                    <option value="D1">D1</option>
                                    <option value="D2">D2</option>
                                    <option value="D3">D3</option>
                                    <option value="S1">S1</option>
                                    <option value="S2">S2</option>
                                    <option value="S3">S3</option>
                                <?php if($karyawan->grade == 'SMP'):?>
                                    <option value="SMP" selected>SMP</option>
                                    <option value="SMA">SMA</option>
                                    <option value="SMK">SMK</option>
                                    <option value="D1">D1</option>
                                    <option value="D2">D2</option>
                                    <option value="D3">D3</option>
                                    <option value="S1">S1</option>
                                    <option value="S2">S2</option>
                                    <option value="S3">S3</option>
                                <?php elseif($karyawan->grade == 'SMA'):?>
                                    <option value="SMP">SMP</option>
                                    <option value="SMA" selected>SMA</option>
                                    <option value="SMK">SMK</option>
                                    <option value="D1">D1</option>
                                    <option value="D2">D2</option>
                                    <option value="D3">D3</option>
                                    <option value="S1">S1</option>
                                    <option value="S2">S2</option>
                                    <option value="S3">S3</option>
                                <?php elseif($karyawan->grade == 'SMK'):?>
                                    <option value="SMP">SMP</option>
                                    <option value="SMA">SMA</option>
                                    <option value="SMK" selected>SMK</option>
                                    <option value="D1">D1</option>
                                    <option value="D2">D2</option>
                                    <option value="D3">D3</option>
                                    <option value="S1">S1</option>
                                    <option value="S2">S2</option>
                                    <option value="S3">S3</option>
                                <?php elseif($karyawan->grade == 'D1'):?>
                                    <option value="SMP">SMP</option>
                                    <option value="SMA">SMA</option>
                                    <option value="SMK">SMK</option>
                                    <option value="D1" selected>D1</option>
                                    <option value="D2">D2</option>
                                    <option value="D3">D3</option>
                                    <option value="S1">S1</option>
                                    <option value="S2">S2</option>
                                    <option value="S3">S3</option>
                                <?php elseif($karyawan->grade == 'D2'):?>
                                    <option value="SMP">SMP</option>
                                    <option value="SMA">SMA</option>
                                    <option value="SMK">SMK</option>
                                    <option value="D1">D1</option>
                                    <option value="D2" selected>D2</option>
                                    <option value="D3">D3</option>
                                    <option value="S1">S1</option>
                                    <option value="S2">S2</option>
                                    <option value="S3">S3</option>
                                <?php elseif($karyawan->grade == 'D3'):?>
                                    <option value="SMP">SMP</option>
                                    <option value="SMA">SMA</option>
                                    <option value="SMK">SMK</option>
                                    <option value="D1">D1</option>
                                    <option value="D2">D2</option>
                                    <option value="D3" selected>D3</option>
                                    <option value="S1">S1</option>
                                    <option value="S2">S2</option>
                                    <option value="S3">S3</option>       
                                <?php elseif($karyawan->grade == 'S1'):?>
                                    <option value="SMP">SMP</option>
                                    <option value="SMA">SMA</option>
                                    <option value="SMK">SMK</option>
                                    <option value="D1">D1</option>
                                    <option value="D2">D2</option>
                                    <option value="D3">D3</option>
                                    <option value="S1" selected>S1</option>
                                    <option value="S2">S2</option>
                                    <option value="S3">S3</option>
                                <?php elseif($karyawan->grade == 'S2'):?>
                                    <option value="SMP">SMP</option>
                                    <option value="SMA">SMA</option>
                                    <option value="SMK">SMK</option>
                                    <option value="D1">D1</option>
                                    <option value="D2">D2</option>
                                    <option value="D3">D3</option>
                                    <option value="S1">S1</option>
                                    <option value="S2" selected>S2</option>
                                    <option value="S3">S3</option>            
                                <?php elseif($karyawan->grade == 'S3'):?>
                                    <option value="SMP">SMP</option>
                                    <option value="SMA">SMA</option>
                                    <option value="SMK">SMK</option>
                                    <option value="D1">D1</option>
                                    <option value="D2">D2</option>
                                    <option value="D3">D3</option>
                                    <option value="S1">S1</option>
                                    <option value="S2">S2</option>
                                    <option value="S3" selected>S3</option>                    
                                <?php endif;?>
                            </select>
                            </div>
                        </div>

                        <div class="form-group <?php echo (form_error('jurusan') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Jurusan</label><div class="col-md-10"><input class="form-control " name="jurusan" type="text" value="<?php echo set_value('jurusan', $karyawan->jurusan); ?>" placeholder="Jurusan"  maxlength=100 required></div>
                            <?php echo form_error('jurusan'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('id_penempatan') != "") ? "has-error" : "" ?>">
                                <label class="control-label col-md-2">Penempatan</label>
                                    <div class="col-md-10">
                                         <select class="form-control select2me" name="id_penempatan" data-placeholder="Pilih..."  id="id_penempatan">
                                            <option>--Select--</option>
                                            <?php foreach ($penempatan_list as $row) {
                                                if ($row->id_penempatan == set_value('id_penempatan',$karyawan->id_penempatan)){
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

                                <!-- <div class="form-group">
                                    <label class="control-label col-md-2">Penempatan</label>
                                        <div class="col-md-10">
                                             
                                            <select class="form-control" name="penempatan" id="penempatan" required>
                                                <option value="">No Selected</option>
                                                <?php foreach($penempatan_list as $row) {?>
                                                <option value="<?php echo $row->id_penempatan;?>"><?php echo $row->nama_perusahaan;?></option>
                                                <?php } ?>
                                            </select>

                                        </div>
                                </div> -->

                        <div class="form-group <?php echo (form_error('nama_kontrak') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Kontrak</label><div class="col-md-10"><input class="form-control " name="nama_kontrak" type="text" value="<?php echo set_value('nama_kontrak', $karyawan->nama_kontrak); ?>" placeholder="Kontrak"  maxlength=100 required></div>
                            <?php echo form_error('nama_kontrak'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('no_kontrak') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Nomor Kontrak</label><div class="col-md-10"><input class="form-control " name="no_kontrak" type="text" value="<?php echo set_value('no_kontrak', $karyawan->no_kontrak); ?>" placeholder="Nomor Kontrak"  maxlength=100 required></div>
                            <?php echo form_error('no_kontrak'); ?>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6">
                                <div class="form-group <?php echo (form_error('tgl_masuk') != "") ? "has-error" : "" ?>">
                                    <label class="control-label col-md-4">Tanggal Masuk</label><div class="col-md-8"><input class="form-control " name="tgl_masuk" type="date" value="<?php echo set_value('tgl_masuk', $karyawan->tgl_masuk); ?>" placeholder="Tanggal Masuk"  maxlength=100 required></div>
                                    <?php echo form_error('tgl_masuk'); ?>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group <?php echo (form_error('tgl_berakhir') != "") ? "has-error" : "" ?>">
                                    <label class="control-label col-md-4">Tanggal Berakhir</label><div class="col-md-8"><input class="form-control " name="tgl_berakhir" type="date" value="<?php echo set_value('tgl_berakhir', $karyawan->tgl_berakhir); ?>" placeholder="Tanggal Berakhir"  maxlength=100 required></div>
                                    <?php echo form_error('tgl_berakhir'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <!-- <div class="col-md-6">
                                <div class="form-group <?php echo (form_error('divisi') != "") ? "has-error" : "" ?>">
                                    <label class="control-label col-md-4">Divisi</label><div class="col-md-8"><input class="form-control " name="divisi" type="text" value="<?php echo set_value('divisi', $karyawan->divisi); ?>" placeholder="Divisi"  maxlength=100 required></div>
                                    <?php echo form_error('divisi'); ?>
                                </div>
                            </div> -->

                            <!-- <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Divisi</label>
                                    <div class="col-md-8">
                                        <select name="subkategori" class="subkategori form-control">
                                            <option value="0">-PILIH-</option>
                                        </select>
                                    </div>
                                     
                                </div>
                            </div> -->
                            <div class="col-md-6">
                            <div class="form-group <?php echo (form_error('id_divisi') != "") ? "has-error" : "" ?>">
                                <label class="control-label col-md-4">Divisi</label>
                                    <div class="col-md-8">
                                         <select class="form-control select2me" name="id_divisi" data-placeholder="Pilih..."  id="cekkaryawan" required="required">
                                            <option>--Select--</option>
                                            <?php foreach($divisi_list as $row) { ?>
                                            <option 
                                                value="<?php echo $row->id_divisi ?>"
                                                data-nama_divisi="<?php echo $row->nama_divisi; ?>"><?php echo $row->nama_divisi; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                <?php echo form_error('id_divisi'); ?>
                        </div> 
                        </div>
                        <input type="hidden" class="form-control " id="nama_divisi" name="nama_divisi" readonly="readonly" required>

                            <div class="col-md-6">
                                <div class="form-group <?php echo (form_error('jabatan') != "") ? "has-error" : "" ?>">
                                    <label class="control-label col-md-4">Jabatan</label><div class="col-md-8"><input class="form-control " name="jabatan" type="text" value="<?php echo set_value('jabatan', $karyawan->jabatan); ?>" placeholder="Jabatan"  maxlength=100 required></div>
                                    <?php echo form_error('jabatan'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group <?php echo (form_error('gaji_pokok') != "") ? "has-error" : "" ?>">
                            <label class="control-label col-md-2">Gaji Pokok</label><div class="col-md-10"><input class="form-control " name="gaji_pokok" type="text" value="<?php echo set_value('gaji_pokok', $karyawan->gaji_pokok); ?>" placeholder="Gaji Pokok"  maxlength=100 required></div>
                            <?php echo form_error('gaji_pokok'); ?>
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


<script type="text/javascript" src="<?php echo base_url().'asset/js/jquery-3.3.1.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'asset/js/bootstrap.js'?>"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $('#kategori').change(function(){
            var id=$(this).val();
            $.ajax({
                url : "<?php echo base_url();?>karyawan/get_subkategori",
                method : "POST",
                data : {id: id},
                async : false,
                dataType : 'json',
                success: function(data){
                    var html = '';
                    var i;
                    for(i=0; i<data.length; i++){
                        html += '<option>'+data[i].nama_divisi+'</option>';
                    }
                    $('.subkategori').html(html);
                     
                }
            });
        });
    });
</script>

<!-- <script type="text/javascript">
        $(document).ready(function(){
 
            $('#penempatan').change(function(){ 
                var id=$(this).val();
                $.ajax({
                    url : "<?php echo site_url('karyawan/get_divisi');?>",
                    method : "POST",
                    data : {id: id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                         
                        var html = '';
                        var i;
                        for(i=0; i<data.length; i++){
                            html += '<option value='+data[i].id_divisi+'>'+data[i].nama_divisi+'</option>';
                        }
                        $('#divisi').html(html);
 
                    }
                });
                return false;
            }); 
             
        });
    </script> -->

<!-- <script type="text/javascript">

$(function(){

    $.ajaxSetup({
    type:"POST",
    url: "<?php echo base_url('karyawan/ambil_data') ?>",
    cache: false,
    });

    $("#penempatan").change(function(){
    
        var value=$(this).val();
        if(value>0){
            $.ajax({
                data:{modul:'kabupaten',id:value},
                success: function(respond){
                    $("#divisi").html(respond);
                }
            })
        }
    
    });

})

</script>    --> 