<?php
class m_anak extends Generic_dao {

    public function table_name() {
        return Tables::$anak;
    }

    public function field_map() {
        return array(
            'id_anak' => 'id_anak',
            'id_karyawan' => 'id_karyawan',
            'nik' => 'nik',
            'nama_anak' => 'nama_anak',
            'tempat_lahir' => 'tempat_lahir',
            'tgl_lahir' => 'tgl_lahir',
            'pendidikan' => 'pendidikan',
            'pekerjaan' => 'pekerjaan',
            'hubungan' => 'hubungan',
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
                'field' => 'nama_karyawan, nip'
            )
        );
    }

}

?>