<?php

class penagihan extends CI_Controller {

    public $data;
    public $filter;
    public $limit = 10;

    public function __construct() {
        parent::__construct();
        define('CURRENT_CONTEXT', base_url() . 'penagihan/');
        $this->data = array();
        init_generic_dao();
        $this->load->model(array('m_penagihan','m_divisi','m_penempatan','m_karyawan','m_gaji_karyawan'));
        $this->load->library(array('template_admin'));
        $this->logged_in();
        $this->data['page_title'] = "penagihan";
    }

    private function validate() {           
            $this->form_validation->set_rules('id_penagihan', 'trim|required');

        return $this->form_validation->run();
    }

    /**
      prepare data for view
     */
    public function preload() {
        $this->data['current_context'] = CURRENT_CONTEXT;
        $this->data['penagihan_list'] = $this->m_penagihan->fetch();
        // $this->data['divisi_list'] = $this->m_divisi->fetch();
        $this->data['penempatan_list'] = $this->m_penempatan->fetch();
        $this->data['karyawan_list'] = $this->m_karyawan->fetch();
        $this->data['gaji_karyawan_list'] = $this->m_gaji_karyawan->fetch();
        // $this->data['Gajikaryawanlist'] = $this->m_penagihan->Gajikaryawanlist();
        // $this->data['getPenagihan'] = $this->m_penagihan->getPenagihan();
        $this->data['penagihanList'] = $this->m_penagihan->penagihanList();
    }    

    public function index($page = 1) {
        $this->preload();
        $this->session->set_userdata(array(
            'filter_penagihan' => array(
                'periode' => '',
                'nama_karyawan' => ''
                ))
        );
        $offset = ($page - 1) * $this->limit;
        $this->data['offset'] = $offset;
        $this->get_list($this->limit, $offset);
    }

    public function fetch_record($keys) {
        $this->data['penagihan'] = $this->m_penagihan->by_id($keys);
        // $this->data['gaji_karyawan'] = $this->m_gaji_karyawan->by_id($keys);
    }

    private function fetch_data($limit, $offset, $key) {
        $this->data['penagihan'] = $this->m_penagihan->fetch($limit, $offset, null, true,null, null, $key);
        // $this->data['gaji_karyawan'] = $this->m_gaji_karyawan->fetch($limit, $offset, null, true,null, null, $key);
        $this->data['total_rows'] = $this->m_penagihan->fetch(null,null, null, true,null, null, $key,true);
    }

    private function upload() {
        $config['upload_path'] = './upload/penagihan_foto';
        $config['allowed_types'] = 'gif|png|jpg|jpeg';
        $config['max_size'] = 100000;
        $this->load->library('upload', $config);   
        $this->upload->do_upload('foto');
        $upload = $this->upload->data();
        return $upload['file_name'];
    }

    private function fetch_input() {
        $fee = $this->input->post('fee');
        $gaji = $this->input->post('thp');
        $premi_bpjstk = $this->input->post('tunj_bpjstk');
        $premi_bpjskes = $this->input->post('tunj_bpjskes');
        $pph21 = $this->input->post('pph21_bulan');
        $periode = $this->input->post('periode');
        $rafel = $this->input->post('rafel');
        $thr = $this->input->post('thr');
        $absen = $this->input->post('potongan_absensi');

        //hitung fee
        $upah = ($gaji + $rafel) - $absen;
        $fee_pt = ($upah + $premi_bpjstk + $premi_bpjskes + $pph21 + $thr);
        $fee_pt1 = ($fee_pt * $fee);
        $pph23 = $fee_pt1 * 0.02;
        $tagihan = $upah + $premi_bpjskes + $premi_bpjstk + $pph21 + $thr + $fee_pt1 + $pph23;

        $get_id_otomatis = $this->data['get_id_otomatis'] = $this->m_gaji_karyawan->get_id_otomatis();
        foreach ($get_id_otomatis as $id) {
            $id_max = $id->get_gaji_id;
            $get_id = $id_max++;
        }

        $id_gaji = $get_id+1;


        $data = array(
            'id_karyawan' => $this->input->post('id_karyawan'),
            'id_penempatan' => $this->input->post('id_penempatan'),
            'gaji_id' => $id_gaji,
            // 'id_gaji_karyawan' => $this->input->post('id_gaji_karyawan'),
            'periode' => $this->input->post('periode'),
            'upah' => $upah,
            'fee_bulan' => $fee_pt1,
            'rafel' => $this->input->post('rafel'),
            'thr' => $this->input->post('thr'),
            'pph23' => $pph23,
            'jml_tagihan' => $tagihan
        );
        // print_r($data);die();
        return $data;
    }

    public function add() {
        $obj = $this->fetch_input();
        $obj['created_by'] = $this->session->userdata('username');
        $obj['created_at'] = date('Y-m-d H:i:s');

        if ($this->validate() != false) {
            $this->m_penagihan->insert($obj);
            redirect(CURRENT_CONTEXT);
        } else {
            $this->preload();
            $this->data['edit'] = false;
            #set value
            $this->data['penagihan'] = (object) $obj;
            $this->template_admin->display('penagihan/penagihan_insert', $this->data);
        }
    }

    /**

      @description
      viewing editing form. repopulation for every data needed in form done here.
     */
    public function edit($id_penagihan) {
        $obj = $this->fetch_input();
        $obj['updated_by'] = $this->session->userdata('username');
        $obj['updated_at'] = date('Y-m-d H:i:s');
        $obj['updated_status'] = ('1');

        $obj_id = array('id_penagihan' => $id_penagihan);

        if ($this->validate() != false) {
            $this->m_penagihan->update($obj, $obj_id);
            redirect(CURRENT_CONTEXT);
        } else {
            $this->preload();
            $this->data['edit'] = true;
            $this->fetch_record($obj_id);
            $this->template_admin->display('penagihan/penagihan_insert', $this->data);
        }
    }

    /**
      @description
      viewing record. repopulation for every data needed for view.
     */
   

    public function detail($id_penagihan) {
        $obj_id = array('id_penagihan' => $id_penagihan);

        $this->preload();
        $this->fetch_record($obj_id);
        $this->template_admin->display('penagihan/penagihan_detail', $this->data);
    }

    public function delete($id_penagihan) {
        $obj_id = array('id_penagihan' => $id_penagihan);
        $obj = array('updated_by' => $this->session->userdata('username'), 'updated_at' => date('Y-m-d H:i:s'),'is_deleted' => 1);
        $this->m_penagihan->update($obj, $obj_id);
        $this->session->set_flashdata(array('message'=>'Data berhasil dihapus.','type_message'=>'success'));
        redirect(CURRENT_CONTEXT);
    }
    
    public function delete_multiple(){
        $data = file_get_contents('php://input');
        $id = json_decode($data);
        $obj = array('updated_by' => $this->session->userdata('username'), 'updated_at' => date('Y-m-d H:i:s'),'is_deleted' => 1);
        foreach($id->ids as $id){
            $obj_id = array('id_penagihan' => $id->id_penagihan);
            $this->m_penagihan->update($obj, $obj_id);
        }
        $this->session->set_flashdata(array('message'=>'Data berhasil dihapus.','type_message'=>'success'));
        echo json_encode(array('status'=>200));
    }

    public function search($page = 1) {
        $this->preload();
        $key = $this->session->userdata('filter_penagihan');
        if ($this->input->post('search')) {
            $key = array(
                'periode' => $this->input->post('periode'),
                'nama_karyawan' => $this->input->post('nama_karyawan')
            );
            $this->session->set_userdata(array('filter_penagihan' => $key));  
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
        $this->template_admin->display('penagihan/penagihan_list', $this->data);
    }

    public function export() {

        // error_reporting(E_ALL);
    
        include_once './assets/phpexcel/Classes/PHPExcel.php';
        $objPHPExcel = new PHPExcel();

        $data = $this->m_penagihan->getPenagihan();
        $total = $this->m_penagihan->getPenagihantotal();
        $date = date('d-m-Y');
     
        $objPHPExcel = new PHPExcel(); 
        $objPHPExcel->setActiveSheetIndex(0); 
        $rowCount = 5;
        $i = 1; 

        $objPHPExcel->getActiveSheet()->mergeCells('A1:M1');
        $objPHPExcel->getActiveSheet()->mergeCells('A2:M2');
        $objPHPExcel->getActiveSheet()->mergeCells('A3:M3');

        // $objPHPExcel->getActiveSheet()->SetCellValue('A1', "DAFTAR KWT TAMBAHAN JASA BORONGAN");
        // $objPHPExcel->getActiveSheet()->SetCellValue('A2', "PT. Puri Makmur Lestari (PT. LEN REKAPRIMA SEMESTA) ");
        // $objPHPExcel->getActiveSheet()->SetCellValue('A3', "BULAN $bulan $periode->tahun1");

        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, "No");
        $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, "Nama");
        $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, "Gaji");
        $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, "Rafel");
        $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, "Pot. Absen");
        $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, "Jumlah Upah");
        $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, "Premi BPJS Ketenagakerjaan");
        $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, "Premi BPJS Kesehatan");
        $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, "PPH PSL 21 (5%)");
        $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, "THR");
        $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, "Fee PT");
        $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, "PPH PSL 23");
        $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, "Jumlah Tagihan/Bulan");
        $rowCount++;

        foreach($total as $raw){

        foreach($data as $row){

                if ($row->bulan_periode == "1") {
                    $bulan = "JANUARI";
                } elseif ($row->bulan_periode == "2") {
                    $bulan = "FEBRUARI";
                } elseif ($row->bulan_periode == "3") {
                    $bulan = "MARET";
                } elseif ($row->bulan_periode == "4") {
                    $bulan = "APRIL";
                } elseif ($row->bulan_periode == "5") {
                    $bulan = "MEI";
                } elseif ($row->bulan_periode == "6") {
                    $bulan = "JUNI";
                } elseif ($row->bulan_periode == "7") {
                    $bulan = "JULI";
                } elseif ($row->bulan_periode == "8") {
                    $bulan = "AGUSTUS";
                } elseif ($row->bulan_periode == "9") {
                    $bulan = "SEPTEMBER";
                } elseif ($row->bulan_periode == "10") {
                    $bulan = "OTKOBER";
                } elseif ($row->bulan_periode == "11") {
                    $bulan = "NOPEMBER";
                } else {
                    $bulan = "DESEMBER";
                }

            $objPHPExcel->getActiveSheet()->SetCellValue('A1', "DAFTAR KWT TAMBAHAN JASA BORONGAN");
            $objPHPExcel->getActiveSheet()->SetCellValue('A2', "PT. Puri Makmur Lestari ");
            $objPHPExcel->getActiveSheet()->SetCellValue('A3', "BULAN $bulan $row->tahun_periode");
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i++); 
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->nama_karyawan); 
            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, number_format($row->thp));
            $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, number_format($row->rafel));
            $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, number_format($row->potongan_absensi)); 
            $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, number_format($row->upah)); 
            $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, number_format($row->tunj_bpjstk)); 
            $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, number_format($row->tunj_bpjskes));
            $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, number_format($row->pph21_bulan));
            $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, number_format($row->thr));
            $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, number_format($row->fee_bulan));
            $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, number_format($row->pph23));
            $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, number_format($row->jml_tagihan));
            $rowCount++;
            // $rowCount++; 
        }
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, "Jumlah Total");
            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, number_format($raw->total_thp));
            $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, number_format($raw->total_rafel));
            $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, number_format($raw->total_absen)); 
            $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, number_format($raw->total_upah)); 
            $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, number_format($raw->total_bpjstk)); 
            $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, number_format($raw->total_bpjskes));
            $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, number_format($raw->total_pph21));
            $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, number_format($raw->total_thr));
            $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, number_format($raw->total_fee));
            $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, number_format($raw->total_pph23));
            $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, number_format($raw->total_tagihan));
            $rowCount++;
            $rowCount++;
            $rowCount++;

            $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, "Bandung, $date");
            $rowCount++;
            $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, "Manager");
            $rowCount++;
            $rowCount++;
            $rowCount++;
            $rowCount++;
            $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, "Asep Sopian");

        }

        //Mengatur lebar cell pada document excel
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(24);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);

        //Mengatur tinggi cell pada document excel
        $objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(2);
        $objPHPExcel->getActiveSheet()->getRowDimension('5')->setRowHeight(26);

        //Mengatur align cell pada document excel
        $center = array();
        $center ['alignment']=array();
        $center ['alignment']['horizontal']=PHPExcel_Style_Alignment::HORIZONTAL_CENTER;
        $objPHPExcel->getActiveSheet()->getStyle ( 'A1:M1' )->applyFromArray ($center);
        $objPHPExcel->getActiveSheet()->getStyle ( 'A2:M2' )->applyFromArray ($center);
        $objPHPExcel->getActiveSheet()->getStyle ( 'A3:M3' )->applyFromArray ($center);
        $objPHPExcel->getActiveSheet()->getStyle ( 'A5:M5' )->applyFromArray ($center);
        $objPHPExcel->getActiveSheet()->getStyle ( 'A' )->applyFromArray ($center);

        $right=array();
        $right ['alignment']=array();
        $right ['alignment']['horizontal']=PHPExcel_Style_Alignment::HORIZONTAL_RIGHT;
        $objPHPExcel->getActiveSheet()->getStyle ( 'C6:M1000' )->applyFromArray ($right);

        // $left=array();
        // $left ['alignment']=array();
        // $left ['alignment']['horizontal']=PHPExcel_Style_Alignment::HORIZONTAL_LEFT;
        // $objPHPExcel->getActiveSheet()->getStyle ( 'C6:M1000' )->applyFromArray ($left);

        //Mengatur font pada document excel
        $objPHPExcel->getActiveSheet()->getStyle('A1:M3')->getFont()->setName('Calibri');
        $objPHPExcel->getActiveSheet()->getStyle('A1:M3')->getFont()->setSize(9);
        $objPHPExcel->getActiveSheet()->getStyle('A1:M3')->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->getStyle('A5:M1000')->getFont()->setSize(8);
        $objPHPExcel->getActiveSheet()->getStyle('A5:M5')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A5:M5')->getAlignment()->setWrapText(true);

        $objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setName('Calibri')->setSize(8);

        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
        $objWriter->save('./assets/excel/Data Penagihan.xlsx'); 

        $this->load->helper('download');
        force_download('./assets/excel/Data Penagihan.xlsx', NULL);

        redirect(CURRENT_CONTEXT);
    }

    public function rekap_penagihan(){
        $this->preload();
        $this->template_admin->display('penagihan/rekap_penagihan', $this->data);
    }

    public function search_rekap_penagihan(){
        $this->preload();
        $bulan = $this->input->post('bln');
        $tahun = $this->input->post('thn');
        $penempatan = $this->input->post('id_penempatan');
        
        // $this->data['getPenagihansearch'] = $this->m_penagihan->getPenagihansearch($bulan, $tahun, $penempatan);
        // $this->data['getPenagihantotalsearch'] = $this->m_penagihan->getPenagihantotalsearch($bulan, $tahun, $penempatan);
        // $jumlah = $this->m_penagihan->getPenagihantotalsearch($bulan, $tahun, $penempatan);
        // $this->data['jumlah_total'] = $jumlah;

        // $this->template_admin->display('penagihan/search_rekap_penagihan', $this->data);

        if($penempatan != 0) {
            $this->data['getPenagihansearch'] = $this->m_penagihan->getPenagihansearch($bulan, $tahun, $penempatan);
            $this->data['getPenagihantotalsearch'] = $this->m_penagihan->getPenagihantotalsearch($bulan, $tahun, $penempatan);
            $jumlah = $this->m_penagihan->getPenagihantotalsearch($bulan, $tahun, $penempatan);
            $this->data['jumlah_total'] = $jumlah;

            $this->template_admin->display('penagihan/search_rekap_penagihan', $this->data);
        } else {
            $this->data['getPenagihansearchAll'] = $this->m_penagihan->getPenagihansearchAll($bulan, $tahun);
            $this->data['getPenagihantotalsearchAll'] = $this->m_penagihan->getPenagihantotalsearchAll($bulan, $tahun);
            $jumlah = $this->m_penagihan->getPenagihantotalsearchAll($bulan, $tahun);
            $this->data['jumlah_total'] = $jumlah;

            $this->template_admin->display('penagihan/search_rekap_penagihan_all', $this->data);
        }

    }

    public function cek(){
        if(isset($_POST['cari'])) {
        $this->search_rekap_penagihan();
        } else if(isset($_POST['export'])) {
        $this->export_excel();
        }
    }

    public function export_excel(){
        $this->preload();
        $bulan = $this->input->post('bln');
        $tahun = $this->input->post('thn');
        $penempatan = $this->input->post('id_penempatan');
        
        $this->data['getPenagihansearch'] = $this->m_penagihan->getPenagihansearch($bulan, $tahun, $penempatan);
        $this->data['getPenagihantotalsearch'] = $this->m_penagihan->getPenagihantotalsearch($bulan, $tahun, $penempatan);
        $jumlah = $this->m_penagihan->getPenagihantotalsearch($bulan, $tahun, $penempatan);
        $this->data['jumlah_total'] = $jumlah;

        $this->data['getPenagihansearchAll'] = $this->m_penagihan->getPenagihansearchAll($bulan, $tahun);
        $this->data['getPenagihantotalsearchAll'] = $this->m_penagihan->getPenagihantotalsearchAll($bulan, $tahun);

        if($penempatan != 0) {      //data penagihan berdasarkan penempatan

            include_once './assets/phpexcel/Classes/PHPExcel.php';
            $objPHPExcel = new PHPExcel();

            $data = $this->m_penagihan->getPenagihansearch($bulan, $tahun, $penempatan);
            $total = $this->m_penagihan->getPenagihantotalsearch($bulan, $tahun, $penempatan);
            $date = date('d-m-Y');
         
            $objPHPExcel = new PHPExcel(); 
            $objPHPExcel->setActiveSheetIndex(0); 
            $rowCount = 5;
            $i = 1; 

            $objPHPExcel->getActiveSheet()->mergeCells('A1:M1');
            $objPHPExcel->getActiveSheet()->mergeCells('A2:M2');
            $objPHPExcel->getActiveSheet()->mergeCells('A3:M3');

            // $objPHPExcel->getActiveSheet()->SetCellValue('A1', "DAFTAR KWT TAMBAHAN JASA BORONGAN");
            // $objPHPExcel->getActiveSheet()->SetCellValue('A2', "PT. Puri Makmur Lestari (PT. LEN REKAPRIMA SEMESTA) ");
            // $objPHPExcel->getActiveSheet()->SetCellValue('A3', "BULAN $bulan $periode->tahun1");

            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, "No");
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, "Nama");
            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, "Gaji");
            $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, "Rafel");
            $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, "Pot. Absen");
            $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, "Jumlah Upah");
            $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, "Premi BPJS Ketenagakerjaan");
            $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, "Premi BPJS Kesehatan");
            $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, "PPH PSL 21 (5%)");
            $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, "THR");
            $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, "Fee PT");
            $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, "PPH PSL 23");
            $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, "Jumlah Tagihan/Bulan");
            $rowCount++;

            foreach($total as $raw){

            foreach($data as $row){

                    if ($row->bulan_periode == "1") {
                        $bulan = "JANUARI";
                    } elseif ($row->bulan_periode == "2") {
                        $bulan = "FEBRUARI";
                    } elseif ($row->bulan_periode == "3") {
                        $bulan = "MARET";
                    } elseif ($row->bulan_periode == "4") {
                        $bulan = "APRIL";
                    } elseif ($row->bulan_periode == "5") {
                        $bulan = "MEI";
                    } elseif ($row->bulan_periode == "6") {
                        $bulan = "JUNI";
                    } elseif ($row->bulan_periode == "7") {
                        $bulan = "JULI";
                    } elseif ($row->bulan_periode == "8") {
                        $bulan = "AGUSTUS";
                    } elseif ($row->bulan_periode == "9") {
                        $bulan = "SEPTEMBER";
                    } elseif ($row->bulan_periode == "10") {
                        $bulan = "OTKOBER";
                    } elseif ($row->bulan_periode == "11") {
                        $bulan = "NOPEMBER";
                    } else {
                        $bulan = "DESEMBER";
                    }

                $objPHPExcel->getActiveSheet()->SetCellValue('A1', "DAFTAR KWT TAMBAHAN JASA BORONGAN");
                $objPHPExcel->getActiveSheet()->SetCellValue('A2', "PT. Puri Makmur Lestari ");
                $objPHPExcel->getActiveSheet()->SetCellValue('A3', "BULAN $bulan $row->tahun_periode");
                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i++); 
                $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->nama_karyawan); 
                $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, number_format($row->thp));
                $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, number_format($row->rafel));
                $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, number_format($row->potongan_absensi)); 
                $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, number_format($row->upah)); 
                $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, number_format($row->tunj_bpjstk)); 
                $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, number_format($row->tunj_bpjskes));
                $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, number_format($row->pph21_bulan));
                $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, number_format($row->thr));
                $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, number_format($row->fee_bulan));
                $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, number_format($row->pph23));
                $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, number_format($row->jml_tagihan));
                $rowCount++;
                // $rowCount++; 
            }
                $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, "Jumlah Total");
                $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, number_format($raw->total_thp));
                $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, number_format($raw->total_rafel));
                $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, number_format($raw->total_absen)); 
                $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, number_format($raw->total_upah)); 
                $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, number_format($raw->total_bpjstk)); 
                $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, number_format($raw->total_bpjskes));
                $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, number_format($raw->total_pph21));
                $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, number_format($raw->total_thr));
                $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, number_format($raw->total_fee));
                $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, number_format($raw->total_pph23));
                $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, number_format($raw->total_tagihan));
                $rowCount++;
                $rowCount++;
                $rowCount++;

                $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, "Bandung, $date");
                $rowCount++;
                $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, "Manager");
                $rowCount++;
                $rowCount++;
                $rowCount++;
                $rowCount++;
                $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, "Asep Sopian");

            }

            //Mengatur lebar cell pada document excel
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(6);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(24);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(12);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(12);
            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(12);
            $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(12);
            $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(12);
            $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);

            //Mengatur tinggi cell pada document excel
            $objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(2);
            $objPHPExcel->getActiveSheet()->getRowDimension('5')->setRowHeight(26);

            //Mengatur align cell pada document excel
            $center = array();
            $center ['alignment']=array();
            $center ['alignment']['horizontal']=PHPExcel_Style_Alignment::HORIZONTAL_CENTER;
            $objPHPExcel->getActiveSheet()->getStyle ( 'A1:M1' )->applyFromArray ($center);
            $objPHPExcel->getActiveSheet()->getStyle ( 'A2:M2' )->applyFromArray ($center);
            $objPHPExcel->getActiveSheet()->getStyle ( 'A3:M3' )->applyFromArray ($center);
            $objPHPExcel->getActiveSheet()->getStyle ( 'A5:M5' )->applyFromArray ($center);
            $objPHPExcel->getActiveSheet()->getStyle ( 'A' )->applyFromArray ($center);

            $right=array();
            $right ['alignment']=array();
            $right ['alignment']['horizontal']=PHPExcel_Style_Alignment::HORIZONTAL_RIGHT;
            $objPHPExcel->getActiveSheet()->getStyle ( 'C6:M1000' )->applyFromArray ($right);

            // $left=array();
            // $left ['alignment']=array();
            // $left ['alignment']['horizontal']=PHPExcel_Style_Alignment::HORIZONTAL_LEFT;
            // $objPHPExcel->getActiveSheet()->getStyle ( 'C6:M1000' )->applyFromArray ($left);

            //Mengatur font pada document excel
            $objPHPExcel->getActiveSheet()->getStyle('A1:M3')->getFont()->setName('Calibri');
            $objPHPExcel->getActiveSheet()->getStyle('A1:M3')->getFont()->setSize(9);
            $objPHPExcel->getActiveSheet()->getStyle('A1:M3')->getFont()->setBold(true);

            $objPHPExcel->getActiveSheet()->getStyle('A5:M1000')->getFont()->setSize(8);
            $objPHPExcel->getActiveSheet()->getStyle('A5:M5')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('A5:M5')->getAlignment()->setWrapText(true);

            $objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setName('Calibri')->setSize(8);

            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
            $objWriter->save('./assets/excel/Data Penagihan.xlsx'); 

            $this->load->helper('download');
            force_download('./assets/excel/Data Penagihan.xlsx', NULL);

            redirect('penagihan/search_rekap_penagihan');
            $this->template_admin->display('penagihan/search_rekap_penagihan', $this->data);

        } else {        //semua data penagihan

            include_once './assets/phpexcel/Classes/PHPExcel.php';
            $objPHPExcel = new PHPExcel();

            $data = $this->m_penagihan->getPenagihansearchAll($bulan, $tahun);
            $total = $this->m_penagihan->getPenagihantotalsearchAll($bulan, $tahun);
            $date = date('d-m-Y');
         
            $objPHPExcel = new PHPExcel(); 
            $objPHPExcel->setActiveSheetIndex(0); 
            $rowCount = 5;
            $i = 1; 

            $objPHPExcel->getActiveSheet()->mergeCells('A1:M1');
            $objPHPExcel->getActiveSheet()->mergeCells('A2:M2');
            $objPHPExcel->getActiveSheet()->mergeCells('A3:M3');

            // $objPHPExcel->getActiveSheet()->SetCellValue('A1', "DAFTAR KWT TAMBAHAN JASA BORONGAN");
            // $objPHPExcel->getActiveSheet()->SetCellValue('A2', "PT. Puri Makmur Lestari (PT. LEN REKAPRIMA SEMESTA) ");
            // $objPHPExcel->getActiveSheet()->SetCellValue('A3', "BULAN $bulan $periode->tahun1");

            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, "No");
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, "Nama");
            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, "Gaji");
            $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, "Rafel");
            $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, "Pot. Absen");
            $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, "Jumlah Upah");
            $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, "Premi BPJS Ketenagakerjaan");
            $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, "Premi BPJS Kesehatan");
            $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, "PPH PSL 21 (5%)");
            $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, "THR");
            $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, "Fee PT");
            $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, "PPH PSL 23");
            $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, "Jumlah Tagihan/Bulan");
            $rowCount++;

            foreach($total as $raw){

            foreach($data as $row){

                    if ($row->bulan_periode == "1") {
                        $bulan = "JANUARI";
                    } elseif ($row->bulan_periode == "2") {
                        $bulan = "FEBRUARI";
                    } elseif ($row->bulan_periode == "3") {
                        $bulan = "MARET";
                    } elseif ($row->bulan_periode == "4") {
                        $bulan = "APRIL";
                    } elseif ($row->bulan_periode == "5") {
                        $bulan = "MEI";
                    } elseif ($row->bulan_periode == "6") {
                        $bulan = "JUNI";
                    } elseif ($row->bulan_periode == "7") {
                        $bulan = "JULI";
                    } elseif ($row->bulan_periode == "8") {
                        $bulan = "AGUSTUS";
                    } elseif ($row->bulan_periode == "9") {
                        $bulan = "SEPTEMBER";
                    } elseif ($row->bulan_periode == "10") {
                        $bulan = "OTKOBER";
                    } elseif ($row->bulan_periode == "11") {
                        $bulan = "NOPEMBER";
                    } else {
                        $bulan = "DESEMBER";
                    }

                $objPHPExcel->getActiveSheet()->SetCellValue('A1', "DAFTAR KWT TAMBAHAN JASA BORONGAN");
                $objPHPExcel->getActiveSheet()->SetCellValue('A2', "PT. Puri Makmur Lestari ");
                $objPHPExcel->getActiveSheet()->SetCellValue('A3', "BULAN $bulan $row->tahun_periode");
                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i++); 
                $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->nama_karyawan); 
                $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, number_format($row->thp));
                $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, number_format($row->rafel));
                $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, number_format($row->potongan_absensi)); 
                $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, number_format($row->upah)); 
                $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, number_format($row->tunj_bpjstk)); 
                $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, number_format($row->tunj_bpjskes));
                $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, number_format($row->pph21_bulan));
                $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, number_format($row->thr));
                $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, number_format($row->fee_bulan));
                $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, number_format($row->pph23));
                $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, number_format($row->jml_tagihan));
                $rowCount++;
                // $rowCount++; 
            }
                $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, "Jumlah Total");
                $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, number_format($raw->total_thp));
                $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, number_format($raw->total_rafel));
                $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, number_format($raw->total_absen)); 
                $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, number_format($raw->total_upah)); 
                $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, number_format($raw->total_bpjstk)); 
                $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, number_format($raw->total_bpjskes));
                $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, number_format($raw->total_pph21));
                $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, number_format($raw->total_thr));
                $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, number_format($raw->total_fee));
                $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, number_format($raw->total_pph23));
                $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, number_format($raw->total_tagihan));
                $rowCount++;
                $rowCount++;
                $rowCount++;

                $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, "Bandung, $date");
                $rowCount++;
                $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, "Manager");
                $rowCount++;
                $rowCount++;
                $rowCount++;
                $rowCount++;
                $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, "Asep Sopian");

            }

            //Mengatur lebar cell pada document excel
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(6);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(24);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(12);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(12);
            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(12);
            $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(12);
            $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(12);
            $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);

            //Mengatur tinggi cell pada document excel
            $objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(2);
            $objPHPExcel->getActiveSheet()->getRowDimension('5')->setRowHeight(26);

            //Mengatur align cell pada document excel
            $center = array();
            $center ['alignment']=array();
            $center ['alignment']['horizontal']=PHPExcel_Style_Alignment::HORIZONTAL_CENTER;
            $objPHPExcel->getActiveSheet()->getStyle ( 'A1:M1' )->applyFromArray ($center);
            $objPHPExcel->getActiveSheet()->getStyle ( 'A2:M2' )->applyFromArray ($center);
            $objPHPExcel->getActiveSheet()->getStyle ( 'A3:M3' )->applyFromArray ($center);
            $objPHPExcel->getActiveSheet()->getStyle ( 'A5:M5' )->applyFromArray ($center);
            $objPHPExcel->getActiveSheet()->getStyle ( 'A' )->applyFromArray ($center);

            $right=array();
            $right ['alignment']=array();
            $right ['alignment']['horizontal']=PHPExcel_Style_Alignment::HORIZONTAL_RIGHT;
            $objPHPExcel->getActiveSheet()->getStyle ( 'C6:M1000' )->applyFromArray ($right);

            // $left=array();
            // $left ['alignment']=array();
            // $left ['alignment']['horizontal']=PHPExcel_Style_Alignment::HORIZONTAL_LEFT;
            // $objPHPExcel->getActiveSheet()->getStyle ( 'C6:M1000' )->applyFromArray ($left);

            //Mengatur font pada document excel
            $objPHPExcel->getActiveSheet()->getStyle('A1:M3')->getFont()->setName('Calibri');
            $objPHPExcel->getActiveSheet()->getStyle('A1:M3')->getFont()->setSize(9);
            $objPHPExcel->getActiveSheet()->getStyle('A1:M3')->getFont()->setBold(true);

            $objPHPExcel->getActiveSheet()->getStyle('A5:M1000')->getFont()->setSize(8);
            $objPHPExcel->getActiveSheet()->getStyle('A5:M5')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('A5:M5')->getAlignment()->setWrapText(true);

            $objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setName('Calibri')->setSize(8);

            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
            $objWriter->save('./assets/excel/Data Penagihan.xlsx'); 

            $this->load->helper('download');
            force_download('./assets/excel/Data Penagihan.xlsx', NULL);

            redirect('penagihan/search_rekap_penagihan');
            $this->template_admin->display('penagihan/search_rekap_penagihan', $this->data);
        }
    }

    function logged_in() {
        if (!($this->session->userdata('logged_in'))) {
            redirect(base_url() . "auth");
        }
    }

}

?>