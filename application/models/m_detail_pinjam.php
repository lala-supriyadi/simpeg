<?php
class m_detail_pinjam extends Generic_dao {

    public function table_name() {
        return Tables::$detail_pinjam;
    }

    public function field_map() {
        return array(
            'id_detail_pinjam' => 'id_detail_pinjam',
            'id_pinjaman' => 'id_pinjaman',
            'id_karyawan' => 'id_karyawan',
            // 'id_gaji_karyawan' => 'id_gaji_karyawan',
            'tgl_bayar' => 'tgl_bayar',
            'cicilan_ke' => 'cicilan_ke',
            'bayar' => 'bayar',
            'created_by' => 'created_by',
            'created_at' => 'created_at',
            'updated_by' => 'updated_by',
            'updated_at' => 'updated_at',
            'is_deleted' => 'is_deleted'
        );
    }

    public function __construct() {
        parent::__construct();
    }

    public function joined_table() {
        return array(
            array(
                'table_name' => Tables::$karyawan,
                'condition' => Tables::$karyawan . '.id_karyawan = ' . $this->table_name() . '.id_karyawan',
                'field' => 'karyawan.nip, nama_karyawan'
            ),
            array(
                'table_name' => Tables::$gaji_karyawan,
                'condition' => Tables::$gaji_karyawan . '.id_gaji_karyawan = ' . $this->table_name() . '.id_gaji_karyawan',
                'field' => 'gaji_karyawan.nip'
            ),
            array(
                'table_name' => Tables::$pinjaman,
                'condition' => Tables::$pinjaman . '.id_pinjaman = ' . $this->table_name() . '.id_pinjaman',
                'field' => 'tgl_pinjaman, jumlah_pinjaman, keterangan, nama_pinjaman, sisa'
            )
        );
    }

}

?>