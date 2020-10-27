<?php
class m_cuti extends Generic_dao {

    public function table_name() {
        return Tables::$cuti;
    }

    public function field_map() {
        return array(
            'id_cuti' => 'id_cuti',
            'id_karyawan' => 'id_karyawan',
            'jenis_cuti' => 'jenis_cuti',
            'no_surat_cuti' => 'no_surat_cuti',
            'tgl_surat_cuti' => 'tgl_surat_cuti',
            'tgl_mulai' => 'tgl_mulai',
            'tgl_selesai' => 'selesai',
            'keterangan' => 'keterangan',
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

}

?>