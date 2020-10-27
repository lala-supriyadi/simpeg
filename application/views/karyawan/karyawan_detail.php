<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Karyawan
        <small>Detail</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?php echo $current_context; ?>">Karyawan</a></li>
        <li class="active">Detail</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <!-- right column -->
        <div class="col-md-12">
            <!-- general form elements disabled -->
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Karyawan</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div class="form-group">
                        <label>Foto:</label>
                        <p><img src="<?php echo base_url() ?>./upload/karyawan_foto/<?php echo $karyawan->foto ?>" class="image image-responsive" height="100" width="100"></p>
                    </div>
                    <div class="form-group">
                        <label>NIP:</label>
                        <p><?php echo $karyawan->nip; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Nama Karyawan:</label>
                        <p><?php echo $karyawan->nama_karyawan; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Kode Pagu:</label>
                        <p><?php echo $karyawan->kode_pagu; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Nomor KTP:</label>
                        <p><?php echo $karyawan->nik; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Nomor NPWP:</label>
                        <p><?php echo $karyawan->no_npwp; ?></p>
                    </div> 
                    <div class="form-group">
                        <label>Tempat, Tanggal Lahir:</label>
                        <p><?php echo $karyawan->tempat_lahir; ?>, <?php echo $karyawan->tgl_lahir; ?> </p>
                    </div>
                    <div class="form-group">
                        <label>Agama:</label>
                        <p><?php echo $karyawan->agama; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Jenis Kelamin:</label>
                        <p><?php 
                                if ($karyawan->jenis_kelamin == 'L') 
                                    echo "Laki-laki"
                                 ; else 
                                    echo "Perempuan";
                                 ; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Alamat:</label>
                        <p><?php echo $karyawan->alamat; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Nomor Telpon:</label>
                        <p><?php echo $karyawan->no_telp; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Email:</label>
                        <p><?php echo $karyawan->email; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Bank:</label>
                        <p><?php echo $karyawan->bank; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Nomor Rekening:</label>
                        <p><?php echo $karyawan->no_rekening; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Status Pernikahan:</label>
                        <p><?php echo $karyawan->status_pernikahan; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Grade:</label>
                        <p><?php echo $karyawan->grade; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Jurusan:</label>
                        <p><?php echo $karyawan->jurusan; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Penempatan:</label>
                        <p><?php echo $karyawan->nama_perusahaan; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Nomor Kontrak:</label>
                        <p><?php echo $karyawan->no_kontrak; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Masuk:</label>
                        <p><?php echo $karyawan->tgl_masuk; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Berakhir:</label>
                        <p><?php echo $karyawan->tgl_berakhir; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Divisi:</label>
                        <p><?php echo $karyawan->divisi; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Jabatan:</label>
                        <p><?php echo $karyawan->jabatan; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Gaji Pokok:</label>
                        <p><?php echo "Rp " . number_format($karyawan->gaji_pokok,0,',','.'); ?></p>
                    </div>
                    <div class="box-footer">
                        <a href="<?php echo $current_context; ?>" class="btn btn-default">Kembali</a>
                        <!-- <a href="<?php echo $current_context . 'edit/' . $distribusi->id_prod; ?>" class="btn btn-primary pull-right">Ubah</a> -->
                    </div><!-- /.box-footer -->
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!--/.col (right) -->
    </div>   <!-- /.row -->
</section><!-- /.content -->