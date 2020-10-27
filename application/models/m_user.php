<?php
class M_user extends Generic_dao {

    public function table_name() {
        return Tables::$user;
    }

    public function field_map() {
        return array(
            'id_user' => 'id_user',
            'role_id' => 'role_id',
            'full_name' => 'full_name',
            'username' => 'username',
            'password' => 'password',
            'gambar' => 'gambar',
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

    // public function check_login($username, $pass) {
    //     $password = md5($pass);
    //     $query = $this->ci->db->query("select * from ".$this->table_name()." where username='$username' and password='$password'");
    //     return ($query->num_rows() == 1);
    // }

    public function check_login($username, $pass) {
        $password = md5($pass);
        $query = $this->ci->db->query("select * from  user where username='$username' and password='$password' ");
        return ($query->num_rows() == 1);
    }
    
    
    public function joined_table() {
        return array(
            array(
                'table_name' => Tables::$role,
                'condition' => Tables::$role . '.role_id = ' . $this->table_name() . '.role_id',
                'field' => 'role_name'
            )
        );
    }
}

?>