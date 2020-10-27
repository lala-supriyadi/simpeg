<?php

class Menu_role extends CI_Controller {

    public $data;
    public $filter;
    public $limit = 10;

    public function __construct() {
        parent::__construct();
        define('CURRENT_CONTEXT', base_url() . 'menu_role/');
        $this->data = array();
        init_generic_dao();
        $this->load->model(array('m_role_menu'));
        $this->load->library(array('template_admin'));
        $this->logged_in();
        $this->data['page_title'] = "Menu Role";
    }

    private function validate() {			$this->form_validation->set_rules('role_id', 'Role Id', 'trim|required|max_length[10]|integer');
			$this->form_validation->set_rules('menu_id', 'Menu Id', 'trim|required|max_length[10]|integer');

        return $this->form_validation->run();
    }

    /**
      prepare data for view
     */
    public function preload() {
        $this->data['current_context'] = CURRENT_CONTEXT;
    }

    public function index($page = 1) {
        $this->preload();
        $this->session->set_userdata(array(
            'filter_menu_role' => array(
				'role_id' => '',
				'menu_id' => ''))
        );
        $offset = ($page - 1) * $this->limit;
        $this->get_list($this->limit, $offset);
    }

    public function fetch_record($keys) {
        $this->data['menu_role'] = $this->m_role_menu->by_id($keys);
    }

    private function fetch_data($limit, $offset, $key) {
        $this->data['menu_role'] = $this->m_role_menu->fetch($limit, $offset, null, true,null, null, $key);
        $this->data['total_rows'] = $this->m_role_menu->fetch(null,null, null, true,null, null, $key,true);
    }

    private function fetch_input() {
        $data = array('role_id' => $this->input->post('role_id'),
			'menu_id' => $this->input->post('menu_id'));

        return $data;
    }

    public function add() {
        $obj = $this->fetch_input();
        $obj['created_by'] = $this->session->userdata('username');
        $obj['created_on'] = date('Y-m-d H:i:s');

        if ($this->validate() != false) {
            $this->m_role_menu->insert($obj);
            redirect(CURRENT_CONTEXT);
        } else {
            $this->preload();
            $this->data['edit'] = false;
            #set value
            $this->data['menu_role'] = (object) $obj;
            $this->template_admin->display('menu_role/menu_role_insert', $this->data);
        }
    }

    /**

      @description
      viewing editing form. repopulation for every data needed in form done here.
     */
    public function edit($role_id,$menu_id) {
        $obj = $this->fetch_input();
        $obj['updated_by'] = $this->session->userdata('username');
        $obj['updated_on'] = date('Y-m-d H:i:s');

        $obj_id = array('role_id' => $role_id,'menu_id' => $menu_id);

        if ($this->validate() != false) {
            $this->m_role_menu->update($obj, $obj_id);
            redirect(CURRENT_CONTEXT);
        } else {
            $this->preload();
            $this->data['edit'] = true;
            $this->fetch_record($obj_id);
            $this->template_admin->display('menu_role/menu_role_insert', $this->data);
        }
    }

    /**
      @description
      viewing record. repopulation for every data needed for view.
     */
    public function detail($role_id,$menu_id) {
        $obj_id = array('role_id' => $role_id,'menu_id' => $menu_id);

        $this->preload();
        $this->fetch_record($obj_id);
        $this->template_admin->display('menu_role/menu_role_detail', $this->data);
    }

    public function delete($role_id,$menu_id) {
        $obj_id = array('role_id' => $role_id,'menu_id' => $menu_id);

        $this->m_role_menu->delete($obj_id);
		$this->session->set_flashdata(array('message'=>'Data berhasil dihapus.','type_message'=>'success'));
        redirect(CURRENT_CONTEXT);
    }
	
	public function delete_multiple(){
        $data = file_get_contents('php://input');
        $id = json_decode($data);
		foreach($id->ids as $id){
			$obj_id = array('role_id' => $id->role_id,'menu_id' => $id->menu_id);
			$this->m_role_menu->delete($obj_id);
		}
		$this->session->set_flashdata(array('message'=>'Data berhasil dihapus.','type_message'=>'success'));
        echo json_encode(array('status'=>200));
    }

	public function search($page = 1) {
        $this->preload();
		$key = $this->session->userdata('filter_menu_role');
        if ($this->input->post('search')) {
            $key = array(
                'role_id' => $this->input->post('role_id'),
				'menu_id' => $this->input->post('menu_id')
            );
			$this->session->set_userdata(array('filter_menu_role' => $key));  
        }
        $offset = ($page - 1) * $this->limit;
        $this->get_list($this->limit, $offset, $key);
    }
	
    public function get_list($limit = 10, $offset = 0, $key = null) {
        #generate pagination
        $this->fetch_data($limit, $offset, $key);
        $config['base_url'] = CURRENT_CONTEXT . ((!empty($key))?'search':'index');
        $config['total_rows'] = $this->data['total_rows'];
        $config['per_page'] = $limit;
        $config['uri_segment'] = 3;
        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();
        $this->template_admin->display('menu_role/menu_role_list', $this->data);
    }

    function logged_in() {
        if (!($this->session->userdata('logged_in'))) {
            redirect(base_url() . "auth");
        }
    }

}

?>