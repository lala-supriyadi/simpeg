<?php
class m_pekerjaan extends Generic_dao {

    public function table_name() {
        return Tables::$pekerjaan;
    }

    public function field_map() {
        return array(
            'id_pekerjaan' => 'id_pekerjaan',
            'jabatan' => 'jabatan',
            'gaji_pokok' => 'gaji_pokok',
            'tunj_jabatan' => 'tunj_jabatan',
            'tunj_bpjstk' => 'tunj_bpjstk',
            'tunj_bpjskes' => 'tunj_bpjskes',
            'tunj_dapen' => 'tunj_dapen',
            'tunj_lain' => 'tunj_lain',
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