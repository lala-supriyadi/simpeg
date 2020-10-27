<?php

class Menu extends CI_Controller {

    public $data;
    public $filter;
    public $limit = 10;

    public function __construct() {
        parent::__construct();
        define('CURRENT_CONTEXT', base_url() . 'menu/');
        $this->data = array();
        init_generic_dao();
        $this->load->model(array('m_menu'));
        $this->load->library(array('template_admin'));
        $this->logged_in();
        $this->data['page_title'] = "Menu";
    }

    private function validate() {			
            // $this->form_validation->set_rules('parent_menu_id', 'Men Menu Id', 'trim|max_length[10]|integer');
			$this->form_validation->set_rules('menu_name', 'Menu Name', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('menu_link', 'Menu Link', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('menu_status', 'Menu Status', 'trim|required|max_length[3]|integer');
			$this->form_validation->set_rules('menu_ismaster', 'Menu Ismaster', 'trim|required|max_length[3]|integer');
			$this->form_validation->set_rules('menu_order', 'Menu Order', 'trim|max_length[10]|integer');
			$this->form_validation->set_rules('created_at', 'Created At', 'trim');
			$this->form_validation->set_rules('updated_at', 'Updated At', 'trim');

        return $this->form_validation->run();
    }

    /**
      prepare data for view
     */
    public function preload() {
        $this->data['current_context'] = CURRENT_CONTEXT;
        $this->data['menu_list'] = $this->m_menu->fetch();

    }

    public function index($page = 1) {
        $this->preload();
        $this->session->set_userdata(array(
            'filter_menu' => array(
				'parent_menu_id' => '',
				'menu_name' => ''))
        );
        $offset = ($page - 1) * $this->limit;
        $this->data['offset'] = $offset;
        $this->get_list($this->limit, $offset);
    }

    public function fetch_record($keys) {
        $this->data['menu'] = $this->m_menu->by_id($keys);
    }

    private function fetch_data($limit, $offset, $key) {
        $this->data['menu'] = $this->m_menu->fetch($limit, $offset, null, true,null, null, $key);
        $this->data['total_rows'] = $this->m_menu->fetch(null,null, null, true,null, null, $key,true);
    }

    private function fetch_input() {
        $data = array('parent_menu_id' => (($this->input->post('parent_menu_id') != '--Select--')?$this->input->post('parent_menu_id') : null),
			'menu_name' => $this->input->post('menu_name'),
			'menu_link' => $this->input->post('menu_link'),
			'menu_status' => $this->input->post('menu_status'),
			'menu_ismaster' => $this->input->post('menu_ismaster'),
			'menu_order' => $this->input->post('menu_order'));
        // print_r($data);die();
        return $data;
    }

    public function add() {
        $obj = $this->fetch_input();
        $obj['created_by'] = $this->session->userdata('username');
        $obj['created_at'] = date('Y-m-d H:i:s');

        if ($this->validate() != false) {
            $this->m_menu->insert($obj);
            redirect(CURRENT_CONTEXT);
        } else {
            $this->preload();
            $this->data['edit'] = false;
            #set value
            $this->data['menu'] = (object) $obj;
            $this->template_admin->display('menu/menu_insert', $this->data);
        }
    }

    /**

      @description
      viewing editing form. repopulation for every data needed in form done here.
     */
    public function edit($menu_id) {
        $obj = $this->fetch_input();
        $obj['updated_by'] = $this->session->userdata('username');
        $obj['updated_at'] = date('Y-m-d H:i:s');

        $obj_id = array('menu_id' => $menu_id);

        if ($this->validate() != false) {
            $this->m_menu->update($obj, $obj_id);
            redirect(CURRENT_CONTEXT);
        } else {
            $this->preload();
            $this->data['edit'] = true;
            $this->fetch_record($obj_id);
            $this->template_admin->display('menu/menu_insert', $this->data);
        }
    }

    /**
      @description
      viewing record. repopulation for every data needed for view.
     */
    public function detail($menu_id) {
        $obj_id = array('menu_id' => $menu_id);
        $obj = array('updated_by' => $this->session->userdata('username'), 'updated_at' => date('Y-m-d H:i:s'),'is_deleted' => 1);
        $this->preload();
        $this->fetch_record($obj, $obj_id);
        $this->template_admin->display('menu/menu_detail', $this->data);
    }

    public function delete($menu_id) {
        $obj_id = array('menu_id' => $menu_id);
        $obj = array('updated_by' => $this->session->userdata('username'), 'updated_at' => date('Y-m-d H:i:s'),'is_deleted' => 1);
        $this->m_menu->update($obj, $obj_id);
		$this->session->set_flashdata(array('message'=>'Data berhasil dihapus.','type_message'=>'success'));
        redirect(CURRENT_CONTEXT);
    }
	
	public function delete_multiple(){
        $data = file_get_contents('php://input');
        $id = json_decode($data);
        $obj = array('updated_by' => $this->session->userdata('username'), 'updated_at' => date('Y-m-d H:i:s'),'is_deleted' => 1);
		foreach($id->ids as $id){
			$obj_id = array('menu_id' => $id->menu_id);
			$this->m_menu->update($obj, $obj_id);
		}
		$this->session->set_flashdata(array('message'=>'Data berhasil dihapus.','type_message'=>'success'));
        echo json_encode(array('status'=>200));
    }

	public function search($page = 1) {
        $this->preload();
		$key = $this->session->userdata('filter_menu');
        if ($this->input->post('search')) {
            $key = array(
                'parent_menu_id' => $this->input->post('parent_menu_id'),
				'menu_name' => $this->input->post('menu_name')
            );
			$this->session->set_userdata(array('filter_menu' => $key));  
        }
        $offset = ($page - 1) * $this->limit;
        $this->data['offset'] = $offset;
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
        $this->template_admin->display('menu/menu_list', $this->data);
    }

    function logged_in() {
        if (!($this->session->userdata('logged_in'))) {
            redirect(base_url() . "auth");
        }
    }

}

?>