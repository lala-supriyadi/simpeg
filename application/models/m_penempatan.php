<?php
class m_penempatan extends Generic_dao {

    public function table_name() {
        return Tables::$penempatan;
    }

    public function field_map() {
        return array(
            'id_penempatan' => 'id_penempatan',
            'nama_perusahaan' => 'nama_perusahaan',
            'alamat' => 'alamat',
            'fee' => 'fee',
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