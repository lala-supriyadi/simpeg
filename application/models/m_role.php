<?php
class M_role extends Generic_dao {

    public function table_name() {
        return Tables::$role;
    }

    public function field_map() {
		return array(
			'role_id' => 'role_id',
			'role_name' => 'role_name',
			'role_status' => 'role_status',
            'role_canlogin' => 'role_canlogin',
            'created_by' => 'created_by',
            'id_user'=>'id_user',
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