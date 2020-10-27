<?php

class Role extends CI_Controller {

    public $data;
    public $filter;
    public $limit = 10;

    public function __construct() {
        parent::__construct();
        define('CURRENT_CONTEXT', base_url() . 'role/');
        $this->data = array();
        init_generic_dao();
        $this->load->model(array('m_role','m_role_menu'));
        $this->load->library(array('template_admin'));
        $this->logged_in();
        $this->data['page_title'] = "Role";
    }

    private function validate() {
        $this->form_validation->set_rules('role_name', 'Role Name', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('role_status', 'Role Status', 'trim|required|max_length[3]|integer');
        $this->form_validation->set_rules('role_canlogin', 'Role Canlogin', 'trim|required|max_length[3]|integer');
        $this->form_validation->set_rules('created_at', 'Created At', 'trim');
        $this->form_validation->set_rules('updated_at', 'Updated At', 'trim');

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
            'filter_role' => array(
                'role_name' => '',
                'role_status' => ''))
        );
        $offset = ($page - 1) * $this->limit;
        $this->data['offset'] = $offset;
        $this->get_list($this->limit, $offset);
    }

    public function fetch_record($keys) {
        $this->data['role'] = $this->m_role->by_id($keys);
    }

    private function fetch_data($limit, $offset, $key) {
        $this->data['role'] = $this->m_role->fetch($limit, $offset, null, true, null, null, $key);
        $this->data['total_rows'] = $this->m_role->fetch(null, null, null, true, null, null, $key, true);
    }

    private function fetch_input() {
        $data = array('role_name' => $this->input->post('role_name'),
            'role_status' => $this->input->post('role_status'),
            'role_canlogin' => $this->input->post('role_canlogin'),
            'created_at' => $this->input->post('created_at'),
            'updated_at' => $this->input->post('updated_at'));

        return $data;
    }

    private function insert_menu($menu_id, $role_id, $edit) {
        foreach ($menu_id as $id) {
            $menu = array(
                'role_id' => $role_id,
                'menu_id' => $id
            );
            $this->m_role_menu->insert($menu);
        }
    }

    public function add() {
        $obj = $this->fetch_input();
        $obj['created_by'] = $this->session->userdata('username');
        $obj['created_at'] = date('Y-m-d H:i:s');

        if ($this->validate() != false) {
            $parent = $this->input->post('parent');
            $child = $this->input->post('child');
            $grandchild = $this->input->post('grandchild');

            $this->m_role->insert($obj);
            $role = $this->m_role->fetch(1, null, 'role_id', false);
            $role_id = $role[0]->role_id;

            //insert menu
            if(!empty($parent)){ $this->insert_menu($parent, $role_id, false); }
            if(!empty($child)){ $this->insert_menu($child, $role_id, false); }
            if(!empty($grandchild)){ $this->insert_menu($grandchild, $role_id, false); }

            redirect(CURRENT_CONTEXT);
        } else {
            $this->preload();
            $this->data['edit'] = false;
            $this->allmenu();
            $this->data['active_menu'] = array();
            #set value
            $this->data['role'] = (object) $obj;
            $this->template_admin->display('role/role_insert', $this->data);
        }
    }

    public function allmenu(){
        $result = $this->m_menu->get_whole_menu(null);
        $i = 0;
        foreach ($result as $menu) {
            $obj_id = $menu->menu_id;
            $child = $this->m_menu->get_whole_menu($obj_id);
            $result[$i]->submenu = $child;
            $j = 0;
            foreach ($child as $submenu) {
                $grandchild = $this->m_menu->get_whole_menu($submenu->menu_id);
                $result[$i]->submenu[$j]->subsubmenu = $grandchild;
                $j++;
            }
            $i++;
        }
        $this->data['menu'] = $result;
    }

    /**

      @description
      viewing editing form. repopulation for every data needed in form done here.
     */
    public function edit($role_id) {
        $obj = $this->fetch_input();
        $obj['updated_by'] = $this->session->userdata('username');
        $obj['updated_at'] = date('Y-m-d H:i:s');

        $obj_id = array('role_id' => $role_id);
        $id = $role_id;
        $this->menu_id($id);
        $parent = $this->input->post('parent');
        $child = $this->input->post('child');
        $grandchild = $this->input->post('grandchild');

        if ($this->validate() != false) {
            $this->m_role->update($obj, $obj_id);
            $this->m_role_menu->delete($obj_id);

            //insert menu
            if(!empty($parent)){ $this->insert_menu($parent, $role_id, true); }
            if(!empty($child)){ $this->insert_menu($child, $role_id, true); }
            if(!empty($grandchild)){ $this->insert_menu($grandchild, $role_id, true); }

            redirect(CURRENT_CONTEXT);
        } else {
            $this->preload();
            $this->data['edit'] = true;
            $this->allmenu();
            $this->fetch_record($obj_id);
            $this->template_admin->display('role/role_insert', $this->data);
        }
    }

    public function menu_id($role_id){
        $result = $this->m_menu->get_menu($role_id);
        $arr = array();
        foreach ($result as $r){
            array_push($arr, $r->menu_id);
        }
        $this->data['active_menu'] = $arr;
    }

    /**
      @description
      viewing record. repopulation for every data needed for view.
     */
    public function detail($role_id) {
        $obj_id = array('role_id' => $role_id);

        $this->preload();
        $this->fetch_record($obj_id);
        $this->menu_role($role_id);

        $this->template_admin->display('role/role_detail', $this->data);
    }

    public function menu_role($role_id) {
            $menu_result = $this->m_menu->get_active_menu($role_id, null, false);
            $i = 0;
            foreach ($menu_result as $menu) {
                $obj_id = $menu->menu_id;
                $child = $this->m_menu->get_active_menu($role_id, $obj_id, false);
                $menu_result[$i]->submenu = $child;

                $i++;
            }
            
            $menu_master = $this->m_menu->get_active_menu($role_id, null, true);
            $i = 0;
            foreach ($menu_master as $menu) {
                $obj_id = $menu->menu_id;
                $child = $this->m_menu->get_active_menu($role_id, $obj_id, true);
                $menu_master[$i]->submenu = $child;
                
                $j = 1;
                foreach ($child as $submenu) {
                    $grandchild = $this->m_menu->get_active_menu($role_id, $submenu->menu_id, true);
                    
                    if(!empty($grandchild[0])){
                        $menu_master[$i]->submenu[$j]->subsubmenu = $grandchild;
                        $j++;
                    }
                }
                $i++;
   
            }
           
            $result = array_merge((array) $menu_result, (array) $menu_master);
            $this->data['menu'] = $result;

    }

    public function delete($role_id) {
        $obj_id = array('role_id' => $role_id);
        $obj = array('updated_by' => $this->session->userdata('username'), 'updated_at' => date('Y-m-d H:i:s'),'is_deleted' => 1);
        $this->m_role->update($obj, $obj_id);
        $this->session->set_flashdata(array('message' => 'Data berhasil dihapus.', 'type_message' => 'success'));
        redirect(CURRENT_CONTEXT);
    }

    public function delete_multiple() {
        $data = file_get_contents('php://input');
        $id = json_decode($data);
        $obj = array('updated_by' => $this->session->userdata('username'), 'updated_at' => date('Y-m-d H:i:s'),'is_deleted' => 1);
        foreach ($id->ids as $id) {
            $obj_id = array('role_id' => $id->role_id);
            $this->m_role->update($obj,$obj_id);
        }
        $this->session->set_flashdata(array('message' => 'Data berhasil dihapus.', 'type_message' => 'success'));
        echo json_encode(array('status' => 200));
    }

    public function search($page = 1) {
        $this->preload();
        $key = $this->session->userdata('filter_role');
        if ($this->input->post('search')) {
            $key = array(
                'role_name' => $this->input->post('role_name'),
                'role_status' => $this->input->post('role_status')
            );
            $this->session->set_userdata(array('filter_role' => $key));
        }
        $offset = ($page - 1) * $this->limit;
        $this->data['offset'] = $offset;
        $this->get_list($this->limit, $offset, $key);
    }

    public function get_list($limit = 10, $offset = 0, $key = null) {
        #generate pagination
        $this->fetch_data($limit, $offset, $key);
        $config['base_url'] = CURRENT_CONTEXT . ((!empty($key)) ? 'search' : 'index');
        $config['total_rows'] = $this->data['total_rows'];
        $config['per_page'] = $limit;
        $config['uri_segment'] = 3;
        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();
        $this->template_admin->display('role/role_list', $this->data);
    }

    function logged_in() {
        if (!($this->session->userdata('logged_in'))) {
            redirect(base_url() . "auth");
        }
    }

}

?>