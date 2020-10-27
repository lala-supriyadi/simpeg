<?php
class M_menu extends Generic_dao {

    public function table_name() {
        return Tables::$menu;
    }

    public function field_map() {
        return array(
            'menu_id' => 'menu_id',
            'parent_menu_id' => 'men_menu_id',
            'menu_name' => 'menu_name',
            'menu_link' => 'menu_link',
            'menu_status' => 'menu_status',
            'menu_ismaster' => 'menu_ismaster',
            'id_user' => 'id_user',
            'created_by' => 'created_by',
            'created_at' => 'created_at',
            'updated_by' => 'updated_by',
            'updated_at' => 'updated_at',
            'is_deleted' => 'is_deleted',
            'menu_order' => 'menu_order'
        );
    }

    public function __construct() {
        parent::__construct();
    }

   public function get_active_menu($role_id, $parent = null, $ismaster = true) {
        $ismaster = ($ismaster)?" and a.menu_ismaster = 1 ":" and a.menu_ismaster = 0";
        $isparent = (!empty($parent))?" and a.men_menu_id = $parent":" and a.men_menu_id is null";
        $sql = "select a.menu_id, a.menu_name, a.menu_link from menu a inner join menu_role b
            ON a.menu_id=b.menu_id 
            where a.menu_status = 1 and b.role_id='$role_id' ".$isparent.$ismaster." order by menu_order asc";
        $query = $this->ci->db->query($sql);
        return $query->result();
    }

    public function get_whole_menu($parent = null) {
        if ($parent == null) {
            $sql = "select menu_id, menu_name, menu_link from menu 
                where menu_status = 1 and men_menu_id is null";
        } else {
            $sql = "SELECT menu_id, menu_name, menu_link from menu where men_menu_id = $parent and menu_status = 1";
        }
        $query = $this->ci->db->query($sql);
        return $query->result();
    }

    public function get_menu($role_id) {
        $sql = "select menu_id from menu_role where role_id='$role_id'";
        $query = $this->ci->db->query($sql);
        return $query->result();
    }
    
    public function joined_table() {
        return array(
            array(
                'table_name' => Tables::$menu ." as parent ",
                'condition' => 'parent.menu_id = '.$this->table_name().'.men_menu_id',
                'field' => 'parent.menu_name as parent_menu_name',
                'direction' => 'left'
            )
        );
    }

}

?>