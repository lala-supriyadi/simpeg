<?php
class M_role_menu extends Generic_dao {

    public function table_name() {
        return Tables::$role_menu;
    }

    public function field_map() {
		return array(
			'role_id' => 'role_id',
			'menu_id' => 'menu_id'
		);
    }

    public function __construct() {
        parent::__construct();
    }
	
	public function joined_table() {
        return array(
            array(
                'table_name' => Tables::$menu,
                'condition' => Tables::$menu . '.menu_id = ' . $this->table_name() . '.menu_id',
                'field' => 'MENU_NAME as menu_name'
            )
        );
    }

}

?>