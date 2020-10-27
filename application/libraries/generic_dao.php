<?php

abstract class Generic_dao {

    public abstract function table_name();

    public abstract function field_map();

    protected $ci;

    private $audit_trail_field = array('created_by','created_at','is_deleted','updated_by','updated_at');

    function __construct() {
        $this->ci = & get_instance();
    }

    public function joined_table(){
        return array(); 
    }

    protected function field_query($except = array()) {
        $fields = $this->field_map();
        $keys = array_keys($fields);
        $total = count($fields) - 1;
        $count = 0;
        $field_s = '';

        foreach ($keys as $key) {
            if(!in_array($key, $except)){
                $field_s .= $this->table_name().".".$fields[$key] . ' as ' . $key; //.' as '.$fields[$key];
                if ($count < $total) {
                    $field_s.=', ';
                }
            }
            $count++;
        }
        return $field_s;
    }

    protected function field_object() {
        $fields = array_flip($this->field_map());
        $keys = array_keys($fields);
        $total = count($fields) - 1;
        $count = 0;
        $field_s = '';

        foreach ($keys as $key) {
            $field_s .= $fields[$key] . ' as ' . $key; //.' as '.$fields[$key];
            if ($count < $total) {
                $field_s.=', ';
            }
            $count++;
        }
        return $field_s;
    }

    /**
      @description
      converting application layer array to
      database layer-understandable array.
      example :

      array('id'=>'007', 'name'=>'Bond, James');

      using child class map:
      array('id'=>'agent_id', 'name'=>'agent_name');

      after processing with this function the result
      array will be :
      array('agent_id'=>'007', 'agent_name'=>'Bond, James');
     */
    protected function to_sql_array($arr, $is_allow_null = false, $tablename = null) {
        $tablename = (empty($tablename))?$this->table_name():$tablename;
        $keys = array_keys($arr);
        $maps = $this->field_map();
        $sql_arr = array();
        foreach ($keys as $key) {
            if ($is_allow_null || (!$is_allow_null && $arr[$key] !== '')) {
                $sql_arr[$tablename.".".$maps[$key]] = $arr[$key];
            }
        }
        return $sql_arr;
    }

    /**
      @param <array> $id_array
      array containing data key. array index
      using object index.
      example :
      altough table representation :
      -----------------------
      |agent_id | agent_name|
      -----------------------
      |007      | James Bond |
      |404      | Not found  |

      but when your map shows :
      array('id'=>'agent_id', 'name'=>'agent_name');

      what you should pass when doing a search by id is :

      array('id','077'); <b>NOT</b> : array('agent_id','077')
     */
    public function by_id($obj_id) {
    $obj_id_o = $this->to_sql_array($obj_id);
        $this->ci->db->select($this->field_query());
        $join_table = $this->joined_table();
        if(!empty($join_table)){
            foreach($join_table as $table){
                if(!empty($table['model_name'])){
                    $this->ci->load->model($table['model_name']);
                    $select2 = $this->ci->{$table['model_name']}->field_query(array_keys($this->field_map()));
                    $this->ci->db->select($select2);
                    if(!empty($table['direction'])){
                        $this->ci->db->join($table['table_name'], $table['condition'], $table['direction']);
                    } else {
                        $this->ci->db->join($table['table_name'], $table['condition']);
                    }
                    $join_table2 = $this->ci->{$table['model_name']}->joined_table();
                    if(!empty($join_table2)){
                        foreach($join_table2 as $table2){
                            $this->ci->db->select($table2['field']);    
                            if(!empty($table2['direction'])){
                                $this->ci->db->join($table2['table_name'], $table2['condition'], $table2['direction']);
                            } else {
                                $this->ci->db->join($table2['table_name'], $table2['condition']);
                            }
                        }        
                    }
                } else {
                    $this->ci->db->select($table['field']);    
                    if(!empty($table['direction'])){
                        $this->ci->db->join($table['table_name'], $table['condition'], $table['direction']);
                    } else {
                        $this->ci->db->join($table['table_name'], $table['condition']);
                    }
                }
            }
        }
        $this->ci->db->where($obj_id_o);
        $q = $this->ci->db->get($this->table_name());
        return $q->row();
    }

    public function fetch($limit = null, $offset = null, $order_by = null, $asc = true, $like_condition = null, $exact_condition = null, $or_condition = null, $iscount = false, $with_delete = true, $usejoin = true) {
        
        $name_asc;
        if ($asc == true) {
            $name_asc = 'asc';
        } else {
            $name_asc = 'desc';
        }
        $this->ci->db->select($this->field_query());
        $join_table = $this->joined_table();
        if(!empty($join_table) && $usejoin){ //konsekuensinya bakal lama 
            foreach($join_table as $table){
                if(!empty($table['model_name'])){
                    $this->ci->load->model($table['model_name']);
                    $select2 = $this->ci->{$table['model_name']}->field_query(array_keys($this->field_map()));
                    $this->ci->db->select($select2);
                    if(!empty($table['direction'])){
                        $this->ci->db->join($table['table_name'], $table['condition'], $table['direction']);
                    } else {
                        $this->ci->db->join($table['table_name'], $table['condition']);
                    }
                    $join_table2 = $this->ci->{$table['model_name']}->joined_table();
                    if(!empty($join_table2)){
                        foreach($join_table2 as $table2){
                            $this->ci->db->select($table2['field']);    
                            if(!empty($table2['direction'])){
                                $this->ci->db->join($table2['table_name'], $table2['condition'], $table2['direction']);
                            } else {
                                $this->ci->db->join($table2['table_name'], $table2['condition']);
                            }
                        }        
                    }
                    $map = array_keys($this->ci->{$table['model_name']}->field_map());
                    foreach((array) $like_condition as $key => $value){
                        if(in_array($key,$map)){
                            $this->ci->db->like($this->ci->{$table['model_name']}->to_sql_array(array($key=>$value), false, $table['table_name']));
                            unset($like_condition[$key]);
                        }
                    }
                    foreach((array) $exact_condition as $key => $value){
                        if(in_array($key,$map) && !in_array($key, $this->audit_trail_field)){
                            $this->ci->db->where($this->ci->{$table['model_name']}->to_sql_array(array($key=>$value), false, $table['table_name']));
                            unset($exact_condition[$key]);
                        }
                    }
                } else {
                    $this->ci->db->select($table['field']);    
                    if(!empty($table['direction'])){
                        $this->ci->db->join($table['table_name'], $table['condition'], $table['direction']);
                    } else {
                        $this->ci->db->join($table['table_name'], $table['condition']);
                    }
                }
                if($with_delete && !empty($table['table_name'])){
                    if(strpos($table['table_name'], ' ') !== false) {
                        $tname = substr($table['table_name'], 0, strpos($table['table_name'], ' '));
                    } else {
                        $tname = $table['table_name'];
                    }
                    $this->ci->db->where("(".$tname.".IS_DELETED = 0 OR ".$tname.".IS_DELETED IS NULL)",null,false);
                }
            }
        }

        if (!empty($like_condition)) {
            $this->ci->db->like($this->to_sql_array($like_condition, false));
        }
        if (!empty($exact_condition)) {
            $this->ci->db->where($this->to_sql_array($exact_condition, false));
        }
        if (!empty($or_condition)) {
            $this->ci->db->or_like($this->to_sql_array($or_condition, false));
        }

        if($with_delete){
            $field_delete = $this->table_name().".IS_DELETED";
            $this->ci->db->where("( {$field_delete} is NULL or {$field_delete} = 0)",null,false);
        }
        if($limit !== null && $offset !== null && !$iscount){
            $this->ci->db->limit($limit, $offset);
        }
        
        $map = $this->field_map();
        if ($order_by != NULL && !$iscount){
            $this->ci->db->order_by($this->table_name().".".$map[$order_by], $name_asc);
        } else {
            $this->ci->db->order_by($this->table_name().".".reset($map), $name_asc);
        }

        $q = $this->ci->db->get($this->table_name());
        if($iscount){
            return $q->num_rows();
        } else {
            return $q->result();
        }

    }

    public function insert($obj) {
        $obj_o = $this->to_sql_array($obj);
        $this->ci->db->insert($this->table_name(), $obj_o);
    }

    public function update($obj, $keys) {
        // fix
        $obj_o = $this->to_sql_array($obj);
        $keys_o = $this->to_sql_array($keys);
        $this->ci->db->where($keys_o);
        $this->ci->db->update($this->table_name(), $obj_o);
    }

    public function delete($keys) {
        // fix
        $keys_o = $this->to_sql_array($keys);
        $this->ci->db->delete($this->table_name(), $keys_o);
    }

    public function count_all( $like_condition = null, $exact_condition = null, $or_condition = null) {
        $this->ci->db->where('(is_deleted is NULL or is_deleted = 0)',null,false);

        if (!empty($like_condition)) {
            $this->ci->db->like($this->to_sql_array($like_condition, false));
        }
        if (!empty($exact_condition)) {
            $this->ci->db->where($this->to_sql_array($exact_condition, false));
        }
        if (!empty($or_condition)) {
            $this->ci->db->or_like($this->to_sql_array($or_condition, false));
        }

        $query = $this->ci->db->get($this->table_name());
        return $query->num_rows();
    }

    public function table_fetch($table_name, $map, $order_by = null, $is_asc = true) {
        $name_asc = "";
        if ($is_asc == true) {
            $name_asc = 'asc';
        } else {
            $name_asc = 'desc';
        }
        $this->ci->db->select($this->field_object());
        if ($order_by != NULL && is_array($order_by)) {
            $this->ci->db->order_by($order_by, $name_asc);
        }
        $q = $this->ci->db->get($table_name);
        return $q->result();
    }

}

?>