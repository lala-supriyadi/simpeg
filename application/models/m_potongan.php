<?php
class m_potongan extends Generic_dao {

    public function table_name() {
        return Tables::$potongan;
    }

    public function field_map() {
        return array(
            'id_potongan' => 'id_potongan',
            'id_karyawan' => 'id_karyawan',
            'potongan_absensi' => 'potongan_absensi',
            'cuti_mandiri' => 'cuti_mandiri',
            'cuti_bersama' => 'cuti_bersama',
            'potongan_bpjstk' => 'potongan_bpjstk',
            'potongan_bpjskes' => 'potongan_bpjskes',
            'potongan_dapen' => 'potongan_dapen',
            'potongan_lain' => 'potongan_lain',
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