<?php
class m_divisi extends Generic_dao {

    public function table_name() {
        return Tables::$divisi;
    }

    public function field_map() {
        return array(
            'id_divisi' => 'id_divisi',
            'id_penempatan' => 'id_penempatan',
            'nama_divisi' => 'nama_divisi',
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
                'table_name' => Tables::$penempatan,
                'condition' => Tables::$penempatan . '.id_penempatan = ' . $this->table_name() . '.id_penempatan',
                'field' => 'penempatan.id_penempatan, penempatan.nama_perusahaan'
            )
        );
    }

}

?>