<?php

class lembur extends CI_Controller {

    public $data;
    public $filter;
    public $limit = 10;

    // setlocale(LC_ALL, 'id_ID.utf8');

    public function __construct() {
        parent::__construct();
        define('CURRENT_CONTEXT', base_url() . 'lembur/');
        $this->data = array();
        init_generic_dao();
        $this->load->model(array('m_gaji_karyawan', 'm_karyawan'));
        $this->load->library(array('template_admin'));
        $this->logged_in();
        $this->data['page_title'] = "lembur";
    }

    private function validate() {			
			$this->form_validation->set_rules('nama_karyawan', 'nama karyawan', 'nik', 'trim|required');

        return $this->form_validation->run();
    }

    /**
      prepare data for view
     */
    public function preload() {
        $this->data['current_context'] = CURRENT_CONTEXT;
        $this->data['gaji_karyawan_list'] = $this->m_gaji_karyawan->fetch();
        $this->data['karyawan_list'] = $this->m_karyawan->fetch();
    }    

    public function index($page = 1) {
        $this->preload();
        $this->session->set_userdata(array(
            'filter_gaji_karyawan' => array(
				'id_gaji_karyawan' => '',
                'id_karyawan' => '',
                'nip' => '',
                'nama_karyawan' => ''
                ))
        );
        $offset = ($page - 1) * $this->limit;
        $this->data['offset'] = $offset;
        $this->get_list($this->limit, $offset);
    }

    public function fetch_record($keys) {
        $this->data['gaji_karyawan'] = $this->m_gaji_karyawan->by_id($keys);
    }

    private function fetch_data($limit, $offset, $key) {
        $this->data['gaji_karyawan'] = $this->m_gaji_karyawan->fetch($limit, $offset, null, true,null, null, $key);
        $this->data['total_rows'] = $this->m_gaji_karyawan->fetch(null,null, null, true,null, null, $key,true);
    }

    private function upload() {
        $config['upload_path'] = './upload/karyawan_foto';
        $config['allowed_types'] = 'gif|png|jpg|jpeg';
        $config['max_size'] = 100000;
        $this->load->library('upload', $config);   
        $this->upload->do_upload('foto');
        $upload = $this->upload->data();
        return $upload['file_name'];
    }

    private function fetch_input() {

        $gapok = $this->input->post('gaji_pokok');
        $bpjstk_status = $this->input->post('bpjstk_stat_tun');
        $bpjskes_status = $this->input->post('bpjskes_stat_tun');
        $dapen_status = $this->input->post('dapen_stat_tun');
        $gapok = $this->input->post('gaji_pokok');
        $tmakan = $this->input->post('tunj_makan');
        $tlain = $this->input->post('tunj_lain');
        $psimpananwajib = $this->input->post('potongan_simpanan_wajib');
        $psekunder = $this->input->post('potongan_sekunder');
        $pdarurat = $this->input->post('potongan_darurat');
        $ptoko = $this->input->post('potongan_toko');
        $plain = $this->input->post('potongan_lain');
        $bulan_gaji = $this->input->post('periode');
        $potongan_absen = $this->input->post('potongan_absensi');


        if ($bpjstk_status == 1) {
            $hitung_bpjstk = $gapok * 0.04;
            $potong_bpjstk = $gapok * 0.05;
        } else {
            $hitung_bpjstk = $gapok * 0.04;
            $potong_bpjstk = $gapok * 0.04;
        }

        if ($bpjskes_status == 1) {
            $hitung_bpjskes = $gapok * 0.0624;
            $potong_bpjskes = $gapok * 0.0924;
        } else {
            $hitung_bpjskes = $gapok * 0.0624;
            $potong_bpjskes = $gapok * 0.0624;
        }

        if ($dapen_status == 1) {
            $hitung_dapen = $gapok * 0.0424;
            $potong_dapen = $gapok * 0.0624;
        } else {
            $hitung_dapen = $gapok * 0.0424;
            $potong_dapen = $gapok * 0.0424;
        }

        $bpjstk_hitung = $hitung_bpjstk;
        $bpjskes_hitung = $hitung_bpjskes;
        $dapen_hitung = $hitung_dapen;

        $bpjstk_potong = $potong_bpjstk;
        $bpjskes_potong = $potong_bpjskes;
        $dapen_potong = $potong_dapen;

        $hitung_absen = $gapok / $jmlh_hari;
        $hitung_absen2 = $hitung_absen * $potongan_absen;
        $hitung_absen3 = $hitung_absen2;

        $hitungthp = $gapok + $bpjstk_hitung + $bpjskes_hitung + $dapen_hitung + $tmakan + $tlain - $bpjstk_potong - $bpjskes_potong - $dapen_potong - $psimpananwajib - $psekunder - $pdarurat - $ptoko - $plain - $hitung_absen3;

        $bulan = date('m');
        // if ($bulan == 1) {
        //     $bulan1 = "Januari";
        // } elseif ($bulan == 2) {
        //     $bulan1 = "Februari";
        // } elseif ($bulan == 3) {
        //     $bulan1 = "Maret";
        // } elseif ($bulan == 4) {
        //     $bulan1 = "April";
        // } elseif ($bulan == 5) {
        //     $bulan1 = "Mei";
        // } elseif ($bulan == 6) {
        //     $bulan1 = "Juni";
        // } elseif ($bulan == 7) {
        //     $bulan1 = "Juli";
        // } elseif ($bulan == 8) {
        //     $bulan1 = "Agustus";
        // } elseif ($bulan == 9) {
        //     $bulan1 = "September";
        // } elseif ($bulan == 10) {
        //     $bulan1 = "Oktober";
        // } elseif ($bulan == 11) {
        //     $bulan1 = "Nopember";
        // } else {
        //     $bulan1 = "Desember";
        // }

        $tahun = date('Y');
        $periode = date('d-m-Y');


        $data = array(
            'id_karyawan' => $this->input->post('id_karyawan'),
            'periode' => $bulan,
            'tahun' => $tahun,
            'jml_hari' => $jmlh_hari,
            'tunj_jabatan' => $this->input->post('tunj_jabatan'),
            'tunj_bpjstk' => $bpjstk_hitung,
            'tunj_bpjskes' => $bpjskes_hitung,
            'tunj_dapen' => $dapen_hitung,
            'bpjstk_stat_tun' => $this->input->post('bpjstk_stat_tun'),
            'bpjskes_stat_tun' => $this->input->post('bpjskes_stat_tun'),
            'dapen_stat_tun' => $this->input->post('dapen_stat_tun'),
            'tunj_makan' => $this->input->post('tunj_makan'),
            'tunj_lain' => $this->input->post('tunj_lain'),
            'potongan_absensi' => $hitung_absen3,
            'jatah_cuti_bersama' => $this->input->post('jatah_cuti_bersama'),
            'jatah_cuti_mandiri' => $this->input->post('jatah_cuti_mandiri'),
            'potongan_bpjstk' => $bpjstk_potong,
            'potongan_bpjskes' => $bpjskes_potong,
            'potongan_dapen' => $dapen_potong,
            'potongan_simpanan_wajib' => $this->input->post('potongan_simpanan_wajib'),
            'potongan_sekunder' => $this->input->post('potongan_sekunder'),
            'potongan_darurat' => $this->input->post('potongan_darurat'),
            'potongan_toko' => $this->input->post('potongan_toko'),
            'potongan_lain' => $this->input->post('potongan_lain'),
            'thp' => $hitungthp
        );
        // print_r($data);die();
        return $data;
    }

    public function add() {
        $obj = $this->fetch_input();
        $obj['created_by'] = $this->session->userdata('username');
        $obj['created_at'] = date('Y-m-d H:i:s');

        if ($this->validate() != false) {
            $this->m_gaji_karyawan->insert($obj);
            redirect(CURRENT_CONTEXT);
        } else {
            $this->preload();
            $this->data['edit'] = false;
            #set value
            $this->data['gaji_karyawan'] = (object) $obj;
            $this->template_admin->display('gaji_karyawan/gaji_karyawan_insert', $this->data);
        }
    }

    /**

      @description
      viewing editing form. repopulation for every data needed in form done here.
     */
    public function edit($id_gaji_karyawan) {
        $obj = $this->fetch_input();
        $obj['updated_by'] = $this->session->userdata('username');
        $obj['updated_at'] = date('Y-m-d H:i:s');

        $obj_id = array('id_gaji_karyawan' => $id_gaji_karyawan);

        if ($this->validate() != false) {
            $this->m_gaji_karyawan->update($obj, $obj_id);
            redirect(CURRENT_CONTEXT);
        } else {
            $this->preload();
            $this->data['edit'] = true;
            $this->fetch_record($obj_id);
            $this->template_admin->display('gaji_karyawan/gaji_karyawan_insert', $this->data);
        }
    }

    /**
      @description
      viewing record. repopulation for every data needed for view.
     */
   

    public function detail($id_gaji_karyawan) {
        $obj_id = array('id_gaji_karyawan' => $id_gaji_karyawan);

        $this->preload();
        $this->fetch_record($obj_id);
        $this->template_admin->display('gaji_karyawan/gaji_karyawan_detail', $this->data);
    }

    public function delete($id_gaji_karyawan) {
        $obj_id = array('id_gaji_karyawan' => $id_gaji_karyawan);
        $obj = array('updated_by' => $this->session->userdata('username'), 'updated_at' => date('Y-m-d H:i:s'),'is_deleted' => 1);
        $this->m_gaji_karyawan->update($obj, $obj_id);
		$this->session->set_flashdata(array('message'=>'Data berhasil dihapus.','type_message'=>'success'));
        redirect(CURRENT_CONTEXT);
    }
	
	public function delete_multiple(){
        $data = file_get_contents('php://input');
        $id = json_decode($data);
        $obj = array('updated_by' => $this->session->userdata('username'), 'updated_at' => date('Y-m-d H:i:s'),'is_deleted' => 1);
		foreach($id->ids as $id){
			$obj_id = array('id_gaji_karyawan' => $id->id_gaji_karyawan);
			$this->m_gaji_karyawan->update($obj, $obj_id);
		}
		$this->session->set_flashdata(array('message'=>'Data berhasil dihapus.','type_message'=>'success'));
        echo json_encode(array('status'=>200));
    }

	public function search($page = 1) {
        $this->preload();
		$key = $this->session->userdata('filter_gaji_karyawan');
        if ($this->input->post('search')) {
            $key = array(
                'id_gaji_karyawan' => $this->input->post('id_gaji_karyawan'),
                'nip' => $this->input->post('nip'),
                'nama_karyawan' => $this->input->post('nama_karyawan')
            );
			$this->session->set_userdata(array('filter_gaji_karyawan' => $key));  
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
        $this->template_admin->display('gaji_karyawan/gaji_karyawan_list', $this->data);
    }

    public function rekap_gaji(){
        $this->preload();
        $this->template_admin->display('gaji_karyawan/rekap_gaji_karyawan', $this->data);
    }

    public function search_rekap_gaji(){
        $this->preload();
        $bulan = $this->input->post('bln');
        $tahun = $this->input->post('thn');
        
        // $this->data['getGaji'] = $this->m_gaji_karyawan->getGaji($bulan, $tahun);
        $this->data['getGajikaryawan'] = $this->m_gaji_karyawan->getGajikaryawan($bulan, $tahun);
        $this->data['getTotal'] = $this->m_gaji_karyawan->getTotal($bulan, $tahun);
        $jumlah = $this->m_gaji_karyawan->getTotal($bulan, $tahun);
        $this->data['jumlah_total'] = $jumlah;

        $this->template_admin->display('gaji_karyawan/search_rekap_gaji_karyawan', $this->data);
    }

    public function slip_gaji($id_gaji_karyawan) {
        $obj_id = array('id_gaji_karyawan' => $id_gaji_karyawan);

        $this->preload();
        $this->fetch_record($obj_id);
        // $this->template_admin->display('gaji_karyawan/slip', $this->data);
        $this->load->view('gaji_karyawan/slip', $this->data);
    }

    public function search_rekap_gaji_print(){
        $this->preload();
        $this->search_rekap_gaji();
        $this->data['getGajikaryawan'] = $this->m_gaji_karyawan->getGajikaryawan($bulan, $tahun);
        $this->data['getTotal'] = $this->m_gaji_karyawan->getTotal($bulan, $tahun);

        $this->template_admin->display('gaji_karyawan/rekap_gaji', $this->data);
    }

    function logged_in() {
        if (!($this->session->userdata('logged_in'))) {
            redirect(base_url() . "auth");
        }
    }

}

?>