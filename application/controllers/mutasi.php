<?php

class mutasi extends CI_Controller {

    public $data;
    public $filter;
    public $limit = 10;

    public function __construct() {
        parent::__construct();
        define('CURRENT_CONTEXT', base_url() . 'mutasi/');
        $this->data = array();
        init_generic_dao();
        $this->load->model(array('m_mutasi','m_karyawan','m_divisi','m_penempatan'));
        $this->load->library(array('template_admin'));
        $this->logged_in();
        $this->data['page_title'] = "mutasi";
    }

    private function validate() {	
            $this->form_validation->set_rules('id_karyawan', 'Id Karyawan', 'trim|required|max_length[11]|integer');		
			$this->form_validation->set_rules('id_mutasi', 'trim|required');

        return $this->form_validation->run();
    }

    /**
      prepare data for view
     */
    public function preload() {
        $this->data['current_context'] = CURRENT_CONTEXT;
        $this->data['mutasi_list'] = $this->m_mutasi->fetch();
        $this->data['divisi_list'] = $this->m_divisi->fetch();
        $this->data['karyawan_list'] = $this->m_karyawan->fetch();
        $this->data['penempatan_list'] = $this->m_penempatan->fetch();
    }    

    public function index($page = 1) {
        $this->preload();
        $this->session->set_userdata(array(
            'filter_mutasi' => array(
                'no_kontrak' => ''
                ))
        );
        $offset = ($page - 1) * $this->limit;
        $this->data['offset'] = $offset;
        $this->get_list($this->limit, $offset);
    }

    public function fetch_record($keys) {
        $this->data['mutasi'] = $this->m_mutasi->by_id($keys);
    }

    private function fetch_data($limit, $offset, $key) {
        $this->data['mutasi'] = $this->m_mutasi->fetch($limit, $offset, null, true,null, null, $key);
        $this->data['total_rows'] = $this->m_mutasi->fetch(null,null, null, true,null, null, $key,true);
    }

    private function upload() {
        $config['upload_path'] = './upload/mutasi_foto';
        $config['allowed_types'] = 'gif|png|jpg|jpeg';
        $config['max_size'] = 100000;
        $this->load->library('upload', $config);   
        $this->upload->do_upload('foto');
        $upload = $this->upload->data();
        return $upload['file_name'];
    }

    private function fetch_input() {
        $penempatan_baru = $this->input->post('id_penempatan');
        $id_karyawan = $this->input->post('id_karyawan');
        $no_kontrak = $this->input->post('no_kontrak');
        $tgl_masuk = $this->input->post('tgl_masuk');
        $tgl_berakhir = $this->input->post('tgl_berakhir');
        $data = array(
            'id_karyawan' => $this->input->post('id_karyawan'),
            'id_penempatan' => $this->input->post('id_penempatan'),
            'penempatan_awal' => $this->input->post('penempatan_awal'),
            'no_kontrak' => $this->input->post('no_kontrak'),
            'tgl_masuk' => $this->input->post('tgl_masuk'),
            'tgl_berakhir' => $this->input->post('tgl_berakhir')
        );
        // print_r($data);die();
        $sql = "UPDATE karyawan set id_penempatan = '$penempatan_baru', no_kontrak = '$no_kontrak', tgl_masuk = '$tgl_masuk', tgl_berakhir = '$tgl_berakhir' WHERE id_karyawan = '$id_karyawan' ";
            $query = $this->db->query($sql);
        return $data;
    }

    public function add() {
        $obj = $this->fetch_input();
        $obj['created_by'] = $this->session->userdata('username');
        $obj['created_at'] = date('Y-m-d H:i:s');

        if ($this->validate() != false) {
            $this->m_mutasi->insert($obj);
            redirect(CURRENT_CONTEXT);
        } else {
            $this->preload();
            $this->data['edit'] = false;
            #set value
            $this->data['mutasi'] = (object) $obj;
            $this->template_admin->display('mutasi/mutasi_insert', $this->data);
        }
    }

    /**

      @description
      viewing editing form. repopulation for every data needed in form done here.
     */
    public function edit($id_mutasi) {
        $obj = $this->fetch_input();
        $obj['updated_by'] = $this->session->userdata('username');
        $obj['updated_at'] = date('Y-m-d H:i:s');

        $obj_id = array('id_mutasi' => $id_mutasi);

        if ($this->validate() != false) {
            $this->m_mutasi->update($obj, $obj_id);
            redirect(CURRENT_CONTEXT);
        } else {
            $this->preload();
            $this->data['edit'] = true;
            $this->fetch_record($obj_id);
            $this->template_admin->display('mutasi/mutasi_insert', $this->data);
        }
    }

    /**
      @description
      viewing record. repopulation for every data needed for view.
     */
   

    public function detail($id_mutasi) {
        $obj_id = array('id_mutasi' => $id_mutasi);

        $this->preload();
        $this->fetch_record($obj_id);
        $this->template_admin->display('mutasi/mutasi_detail', $this->data);
    }

    public function delete($id_mutasi) {
        $obj_id = array('id_mutasi' => $id_mutasi);
        $obj = array('updated_by' => $this->session->userdata('username'), 'updated_at' => date('Y-m-d H:i:s'),'is_deleted' => 1);
        $this->m_mutasi->update($obj, $obj_id);
		$this->session->set_flashdata(array('message'=>'Data berhasil dihapus.','type_message'=>'success'));
        redirect(CURRENT_CONTEXT);
    }
	
	public function delete_multiple(){
        $data = file_get_contents('php://input');
        $id = json_decode($data);
        $obj = array('updated_by' => $this->session->userdata('username'), 'updated_at' => date('Y-m-d H:i:s'),'is_deleted' => 1);
		foreach($id->ids as $id){
			$obj_id = array('id_mutasi' => $id->id_mutasi);
			$this->m_mutasi->update($obj, $obj_id);
		}
		$this->session->set_flashdata(array('message'=>'Data berhasil dihapus.','type_message'=>'success'));
        echo json_encode(array('status'=>200));
    }

	public function search($page = 1) {
        $this->preload();
		$key = $this->session->userdata('filter_mutasi');
        if ($this->input->post('search')) {
            $key = array(
                'no_kontrak' => $this->input->post('no_kontrak')
            );
			$this->session->set_userdata(array('filter_mutasi' => $key));  
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
        $this->template_admin->display('mutasi/mutasi_list', $this->data);
    }

    function logged_in() {
        if (!($this->session->userdata('logged_in'))) {
            redirect(base_url() . "auth");
        }
    }

}

?>