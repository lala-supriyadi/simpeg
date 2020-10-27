<?php
class m_mutasi extends Generic_dao {

    public function table_name() {
        return Tables::$mutasi;
    }

    public function field_map() {
        return array(
            'id_mutasi' => 'id_mutasi',
            'id_karyawan' => 'id_karyawan',
            'id_penempatan' => 'id_penempatan',
            'penempatan_awal' => 'penempatan_awal',
            'no_kontrak' => 'no_kontrak',
            'tgl_masuk' => 'tgl_masuk',
            'tgl_berakhir' => 'tgl_berakhir',
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
                'field' => 'nama_karyawan, nip, karyawan.id_penempatan'
            ),
            array(
                'table_name' => Tables::$penempatan,
                'condition' => Tables::$penempatan . '.id_penempatan = ' . $this->table_name() . '.id_penempatan',
                'field' => 'nama_perusahaan, penempatan.alamat'
            )
        );
    }

}

?>