<?php
class m_kontrak extends Generic_dao {

    public function table_name() {
        return Tables::$kontrak;
    }

    public function field_map() {
        return array(
            'id_kontrak' => 'id_kontrak',
            'id_karyawan' => 'id_karyawan',
            'no_kontrak' => 'no_kontrak',
            'tgl_mulai' => 'tgl_mulai',
            'tgl_selesai' => 'tgl_selesai',
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
                'field' => 'karyawan.nik, karyawan.nama_karyawan, karyawan.nip'
            )
        );
    }

}

?>