<?php 
	function query_select($table_name,$field_map ){
		$ci =& get_instance();
		$ci->load->database();
	    $ci->load->library('tables');
	    

		$ci->db->select(field_query($field_map));
		return $ci->db->get($table_name)->result();
	}

	function field_query($field_map){
		$keys = array_keys($field_map);
		$total = count($field_map)-1;
		$count = 0;
		$field_s = '';

		foreach($keys as $key){
			$field_s .= $field_map[$key].' as '.$key; //.' as '.$fields[$key];
			if($count < $total){
				$field_s.=', ';
			}
			$count++;
		}
		return $field_s;
	}

?>