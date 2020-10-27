<?php

class User extends CI_Controller {

    public $data;
    public $filter;
    public $limit = 10;

    public function __construct() {
        parent::__construct();
        define('CURRENT_CONTEXT', base_url() . 'user/');
        $this->data = array();
        init_generic_dao();
        $this->load->model(array('m_user', 'm_role'));
        $this->load->library(array('template_admin'));
        $this->logged_in();
        $this->data['page_title'] = "User";
    }

    private function validate() {
        // $this->form_validation->set_rules('role_id', 'Role Id', 'trim|required|max_length[10]|integer');
        $this->form_validation->set_rules('username', 'Username', 'trim|max_length[10]');
        $this->form_validation->set_rules('password', 'Password', 'trim|max_length[255]');
        $this->form_validation->set_rules('full_name', 'Full Name', 'trim|max_length[50]');
        // $this->form_validation->set_rules('foto', 'Foto', 'trim|max_length[50]');
        $this->form_validation->set_rules('created_at', 'Created At', 'trim');
        $this->form_validation->set_rules('updated_at', 'Updated At', 'trim');

        return $this->form_validation->run();
    }

    /**
      prepare data for view
     */
    public function preload() {
        $this->data['current_context'] = CURRENT_CONTEXT;
        $this->data['role'] = $this->m_role->fetch();
    }

    public function index($page = 1) {
        $this->preload();
        $this->session->set_userdata(array(
            'filter_user' => array(
                'role_id' => '',
                'username' => ''))
        );
        $offset = ($page - 1) * $this->limit;
        $this->data['offset'] = $offset;
        $this->get_list($this->limit, $offset);
    }

    public function fetch_record($keys) {
        $this->data['user'] = $this->m_user->by_id($keys);
    }

    private function fetch_data($limit, $offset, $key) {
        $this->data['user'] = $this->m_user->fetch($limit, $offset, null, true, null, null, $key);
        $this->data['total_rows'] = $this->m_user->fetch(null, null, null, true, null, null, $key, true);
    }

    private function upload() {
        $config['upload_path'] = './upload/user_photo';
        $config['allowed_types'] = 'gif|png|jpg|jpeg';
        $config['max_size'] = 100000;
        $this->load->library('upload', $config);   
        $this->upload->do_upload('gambar');
        $upload = $this->upload->data();
        return $upload['file_name'];
    }

    private function fetch_input() {
        $data = array(
            'role_id' => $this->input->post('role_id'),
            'username' => $this->input->post('username'),
            'password' => md5($this->input->post('password')),
            'full_name' => $this->input->post('full_name'),
            'gambar' => $this->upload(),
            'created_at' => $this->input->post('created_at'),
            'updated_at' => $this->input->post('updated_at'));

        return $data;
    }

    public function add() {
        $obj = $this->fetch_input();
        $obj['created_by'] = $this->session->userdata('username');
        $obj['created_at'] = date('Y-m-d H:i:s');

        if ($this->validate() != false) {
            $this->m_user->insert($obj);
            redirect(CURRENT_CONTEXT);
        } else {
            $this->preload();
            $this->data['edit'] = false;
            #set value
            $this->data['user'] = (object) $obj;
            $this->template_admin->display('user/user_insert', $this->data);
        }
    }

    /**

      @description
      viewing editing form. repopulation for every data needed in form done here.
     */
    public function edit($id_user) {
        $obj = $this->fetch_input();
        $obj['updated_by'] = $this->session->userdata('username');
        $obj['updated_at'] = date('Y-m-d H:i:s');

        $obj_id = array('id_user' => $id_user);

        if ($this->validate() != false) {
            $this->m_user->update($obj, $obj_id);
            if ($id_user == $this->session->userdata('id_user')) {
                redirect(base_url() . "auth/logout");
            } else {
                redirect(CURRENT_CONTEXT);
            }
        } else {
            $this->preload();
            $this->data['edit'] = true;
            $this->fetch_record($obj_id);
            $this->template_admin->display('user/user_insert', $this->data);
        }
    }

    /**
      @description
      viewing record. repopulation for every data needed for view.
     */
    public function detail($id_user) {
        $obj_id = array('id_user' => $id_user);

        $this->preload();
        $this->fetch_record($obj_id);
        $this->template_admin->display('user/user_detail', $this->data);
    }

    public function delete($id_user) {
        $obj_id = array('id_user' => $id_user);
        $obj = array('updated_by' => $this->session->userdata('username'), 'updated_at' => date('Y-m-d H:i:s'),'is_deleted' => 1);
        $this->m_user->update($obj,$obj_id);
        $this->session->set_flashdata(array('message' => 'Data berhasil dihapus.', 'type_message' => 'success'));
        redirect(CURRENT_CONTEXT);
    }

    public function delete_multiple() {
        $data = file_get_contents('php://input');
        $id = json_decode($data);
        $obj = array('updated_by' => $this->session->userdata('username'), 'updated_at' => date('Y-m-d H:i:s'),'is_deleted' => 1);
        foreach ($id->ids as $id) {
            $obj_id = array('id_user' => $id->id_user);
            $this->m_user->update($obj, $obj_id);
        }
        $this->session->set_flashdata(array('message' => 'Data berhasil dihapus.', 'type_message' => 'success'));
        echo json_encode(array('status' => 200));
    }

    public function search($page = 1) {
        $this->preload();
        $key = $this->session->userdata('filter_user');
        if ($this->input->post('search')) {
            $key = array(
                'role_id' => $this->input->post('role_id'),
                'username' => $this->input->post('username')
            );
            $this->session->set_userdata(array('filter_user' => $key));
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
        $this->template_admin->display('user/user_list', $this->data);
    }

    private function fetch_update() {
        $data = array(
            'username' => $this->input->post('username'),
            'password' => md5($this->input->post('password'))
            // 'password_konf' => md5($this->input->post('password_konf')),
            // 'password_lama' => md5($this->input->post('password_lama'))
            
        );
        // print_r($data);die();
        return $data;
    }

    public function update() {
        $obj = $this->fetch_update();
        $obj['updated_by'] = $this->session->userdata('username');
        $obj['updated_at'] = date('Y-m-d H:i:s');
        $this->load->library('encrypt'); 

        $pass = $this->session->userdata('password');
        $pass_lama = md5($this->input->post('password_lama'));

        $obj_id = array('id_user' => $this->session->userdata('id_user'));

        if ($this->validate() != false) {

            if (md5($this->input->post('password_lama')) == $this->userdata->password) {
            // if ($pass_lama = $pass) {    
                if ($this->input->post('password') != $this->input->post('password_konf')) {
                    $this->session->set_flashdata(array('message'=>'Kata Sandi Baru dan Konfirmasi Kata Sandi harus sama','type_message'=>'error'));
                    redirect('user/update');
                    } else {

                    $this->m_pelanggan->update($obj, $obj_id);
                    $this->session->set_flashdata(array('message'=>'Kata Sandi berhasil dirubah.','type_message'=>'success'));
                    redirect('user/update');
                    }
       
                } else {
                    $this->session->set_flashdata(array('message'=>'Kata Sandi Salah.','type_message'=>'error'));
                    redirect('user/update');
                    }
        } else {

            $this->preload();
            $this->data['update'] = true;
            $this->fetch_record($obj_id);
            $this->template_admin->display('user/profile_edit', $this->data);
        }
           
    }

    function logged_in() {
        if (!($this->session->userdata('logged_in'))) {
            redirect(base_url() . "auth");
        }
    }

}

?>