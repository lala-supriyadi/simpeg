<?php
class m_sekolah extends Generic_dao {

    public function table_name() {
        return Tables::$sekolah;
    }

    public function field_map() {
        return array(
            'id_sekolah' => 'id_sekolah',
            'id_karyawan' => 'id_karyawan',
            'nama_sekolah' => 'nama_sekolah',
            'lokasi' => 'lokasi',
            'grade' => 'grade',
            'jurusan' => 'jurusan',
            'tgl_ijazah' => 'tgl_ijazah',
            'no_ijazah' => 'no_ijazah',
            'nama_kepsek' => 'nama_kepsek',
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
                'field' => 'nip, nama_karyawan'
            )
        );
    }

}

?>