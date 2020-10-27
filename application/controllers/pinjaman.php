<?php

class pinjaman extends CI_Controller {

    public $data;
    public $filter;
    public $limit = 10;

    public function __construct() {
        parent::__construct();
        define('CURRENT_CONTEXT', base_url() . 'pinjaman/');
        $this->data = array();
        init_generic_dao();
        $this->load->model(array('m_pinjaman','m_karyawan','m_penempatan','m_gaji_karyawan'));
        $this->load->library(array('template_admin'));
        $this->logged_in();
        $this->data['page_title'] = "pinjaman";
    }

    private function validate() {
            $this->form_validation->set_rules('id_karyawan', 'Id Karyawan', 'trim|required|max_length[11]|integer');			
			$this->form_validation->set_rules('nama_pinjaman', 'nama pinjaman', 'trim|required');

        return $this->form_validation->run();
    }

    /**
      prepare data for view
     */
    public function preload() {
        $this->data['current_context'] = CURRENT_CONTEXT;
        $this->data['pinjaman_list'] = $this->m_pinjaman->fetch();
        $this->data['karyawan_list'] = $this->m_karyawan->fetch();
        $this->data['gaji_karyawan_list'] = $this->m_gaji_karyawan->fetch();
        $this->data['penempatan_list'] = $this->m_penempatan->fetch();
    }    

    public function index($page = 1) {
        $this->preload();
        $this->session->set_userdata(array(
            'filter_pinjaman' => array(
                'tgl_pinjaman' => '',
                'nama_karyawan' => ''
                ))
        );
        $offset = ($page - 1) * $this->limit;
        $this->data['offset'] = $offset;
        $this->get_list($this->limit, $offset);
    }

    public function fetch_record($keys) {
        $this->data['pinjaman'] = $this->m_pinjaman->by_id($keys);
    }

    private function fetch_data($limit, $offset, $key) {
        $this->data['pinjaman'] = $this->m_pinjaman->fetch($limit, $offset, null, true,null, null, $key);
        $this->data['total_rows'] = $this->m_pinjaman->fetch(null,null, null, true,null, null, $key,true);
    }

    private function upload() {
        $config['upload_path'] = './upload/pinjaman_foto';
        $config['allowed_types'] = 'gif|png|jpg|jpeg';
        $config['max_size'] = 100000;
        $this->load->library('upload', $config);   
        $this->upload->do_upload('foto');
        $upload = $this->upload->data();
        return $upload['file_name'];
    }

    private function fetch_input() {
        $data = array(
            'id_karyawan' => $this->input->post('id_karyawan'),
            'nama_karyawan' => $this->input->post('nama_karyawan'),
            'nama_pinjaman' => $this->input->post('nama_pinjaman'),
            'jumlah_pinjaman' => $this->input->post('jumlah_pinjaman'),
            'tgl_pinjaman' => $this->input->post('tgl_pinjaman'),
            'sisa' => $this->input->post('jumlah_pinjaman')
        );
        // print_r($data);die();
        return $data;
    }

    public function add() {
        $obj = $this->fetch_input();
        $obj['created_by'] = $this->session->userdata('username');
        $obj['created_at'] = date('Y-m-d H:i:s');

        if ($this->validate() != false) {
            $this->m_pinjaman->insert($obj);
            redirect(CURRENT_CONTEXT);
        } else {
            $this->preload();
            $this->data['edit'] = false;
            #set value
            $this->data['pinjaman'] = (object) $obj;
            $this->template_admin->display('pinjaman/pinjaman_insert', $this->data);
        }
    }

    /**

      @description
      viewing editing form. repopulation for every data needed in form done here.
     */
    public function edit($id_pinjaman) {
        $obj = $this->fetch_input();
        $obj['updated_by'] = $this->session->userdata('username');
        $obj['updated_at'] = date('Y-m-d H:i:s');

        $obj_id = array('id_pinjaman' => $id_pinjaman);

        if ($this->validate() != false) {
            $this->m_pinjaman->update($obj, $obj_id);
            redirect(CURRENT_CONTEXT);
        } else {
            $this->preload();
            $this->data['edit'] = true;
            $this->fetch_record($obj_id);
            $this->template_admin->display('pinjaman/pinjaman_insert', $this->data);
        }
    }

    /**
      @description
      viewing record. repopulation for every data needed for view.
     */
   

    public function detail($id_pinjaman) {
        $obj_id = array('id_pinjaman' => $id_pinjaman);

        $this->preload();
        $this->fetch_record($obj_id);
        $this->template_admin->display('pinjaman/pinjaman_detail', $this->data);
    }

    public function delete($id_pinjaman) {
        $obj_id = array('id_pinjaman' => $id_pinjaman);
        $obj = array('updated_by' => $this->session->userdata('username'), 'updated_at' => date('Y-m-d H:i:s'),'is_deleted' => 1);
        $this->m_pinjaman->update($obj, $obj_id);
		$this->session->set_flashdata(array('message'=>'Data berhasil dihapus.','type_message'=>'success'));
        redirect(CURRENT_CONTEXT);
    }
	
	public function delete_multiple(){
        $data = file_get_contents('php://input');
        $id = json_decode($data);
        $obj = array('updated_by' => $this->session->userdata('username'), 'updated_at' => date('Y-m-d H:i:s'),'is_deleted' => 1);
		foreach($id->ids as $id){
			$obj_id = array('id_pinjaman' => $id->id_pinjaman);
			$this->m_pinjaman->update($obj, $obj_id);
		}
		$this->session->set_flashdata(array('message'=>'Data berhasil dihapus.','type_message'=>'success'));
        echo json_encode(array('status'=>200));
    }

	public function search($page = 1) {
        $this->preload();
		$key = $this->session->userdata('filter_pinjaman');
        if ($this->input->post('search')) {
            $key = array(
                'tgl_pinjaman' => $this->input->post('tgl_pinjaman'),
                'nama_karyawan' => $this->input->post('nama_karyawan')
            );
			$this->session->set_userdata(array('filter_pinjaman' => $key));  
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
        $this->template_admin->display('pinjaman/pinjaman_list', $this->data);
    }

    public function rekap_pinjaman(){
        $this->preload();
        $this->template_admin->display('pinjaman/rekap_pinjaman', $this->data);
    }

    public function search_rekap_pinjaman(){
        $this->preload();
        $bulan = $this->input->post('bln');
        $tahun = $this->input->post('thn');
        $penempatan = $this->input->post('id_penempatan');

        if($penempatan != 0) {
            $this->data['getPinjamansearch'] = $this->m_pinjaman->getPinjamansearch($bulan, $tahun, $penempatan);
            $this->data['getPinjamantotalsearch'] = $this->m_pinjaman->getPinjamantotalsearch($bulan, $tahun, $penempatan);
            $jumlah = $this->m_pinjaman->getPinjamantotalsearch($bulan, $tahun, $penempatan);
            $this->data['jumlah_total'] = $jumlah;
            
            $this->template_admin->display('pinjaman/search_rekap_pinjaman', $this->data);
        } else {
            $this->data['getPinjamansearchAll'] = $this->m_pinjaman->getPinjamansearchAll($bulan, $tahun);
            $this->data['getPinjamantotalsearchAll'] = $this->m_pinjaman->getPinjamantotalsearchAll($bulan, $tahun);
            $jumlah = $this->m_pinjaman->getPinjamantotalsearchAll($bulan, $tahun);
            $this->data['jumlah_total'] = $jumlah;

            $this->template_admin->display('pinjaman/search_rekap_pinjaman_all', $this->data);
        }
    }

    public function cek(){
        if(isset($_POST['cari'])) {
        $this->search_rekap_pinjaman();
        } else if(isset($_POST['export'])) {
        $this->export_excel();
        }
    }

    public function export_excel(){
        $this->preload();
        $bulan = $this->input->post('bln');
        $tahun = $this->input->post('thn');
        $penempatan = $this->input->post('id_penempatan');
        
        $this->data['getPinjamansearch'] = $this->m_pinjaman->getPinjamansearch($bulan, $tahun, $penempatan);
        $this->data['getPinjamantotalsearch'] = $this->m_pinjaman->getPinjamantotalsearch($bulan, $tahun, $penempatan);
        $jumlah = $this->m_pinjaman->getPinjamantotalsearch($bulan, $tahun, $penempatan);
        $this->data['jumlah_total'] = $jumlah;

        $this->data['getPinjamansearchAll'] = $this->m_pinjaman->getPinjamansearchAll($bulan, $tahun);
        $this->data['getPinjamantotalsearchAll'] = $this->m_pinjaman->getPinjamantotalsearchAll($bulan, $tahun);

        if($penempatan != 0) {      //data penagihan berdasarkan penempatan

            include_once './assets/phpexcel/Classes/PHPExcel.php';
            $objPHPExcel = new PHPExcel();

            $data = $this->m_pinjaman->getPinjamansearch($bulan, $tahun, $penempatan);
            $total = $this->m_pinjaman->getPinjamantotalsearch($bulan, $tahun, $penempatan);
            $date = date('d-m-Y');
            $created_by = $this->session->userdata('username');
         
            $objPHPExcel = new PHPExcel(); 
            $objPHPExcel->setActiveSheetIndex(0); 
            $rowCount = 5;
            $i = 1; 

            $objPHPExcel->getActiveSheet()->mergeCells('A1:G1');
            $objPHPExcel->getActiveSheet()->mergeCells('A2:G2');
            $objPHPExcel->getActiveSheet()->mergeCells('A3:G3');

            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, "NO");
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, "NIP");
            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, "NAMA");
            $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, "JUMLAH PINJAMAN");
            $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, "TANGGAL PINJAM");
            $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, "SISA");
            $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, "KETERANGAN");
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

                $objPHPExcel->getActiveSheet()->SetCellValue('A1', "DAFTAR PINJAMAN KARYAWAN");
                $objPHPExcel->getActiveSheet()->SetCellValue('A2', "PT. Puri Makmur Lestari ");
                $objPHPExcel->getActiveSheet()->SetCellValue('A3', "BULAN $bulan $row->tahun_periode");
                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i++); 
                $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->nip); 
                $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->nama_karyawan);
                $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, number_format($row->jumlah_pinjaman));
                $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row->tgl_pinjaman);
                $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, number_format($row->sisa)); 
                $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row->nama_pinjaman);
                $rowCount++;
                // $rowCount++; 
            }
                $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, "Jumlah Total");
                $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, number_format($raw->total_pinjaman));
                $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, number_format($raw->total_sisa));
                $rowCount++;
                $rowCount++;
                $rowCount++;

                $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, "Bandung, $date");
                $rowCount++;
                $rowCount++;
                $rowCount++;
                $rowCount++;
                $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, "$created_by");

            }

            //Mengatur lebar cell pada document excel
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(6);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(18);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(24);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(24);

            //Mengatur tinggi cell pada document excel
            $objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(2);
            $objPHPExcel->getActiveSheet()->getRowDimension('5')->setRowHeight(26);

            //Mengatur align cell pada document excel
            $center = array();
            $center ['alignment']=array();
            $center ['alignment']['horizontal']=PHPExcel_Style_Alignment::HORIZONTAL_CENTER;
            $objPHPExcel->getActiveSheet()->getStyle ( 'A1:G1' )->applyFromArray ($center);
            $objPHPExcel->getActiveSheet()->getStyle ( 'A2:G2' )->applyFromArray ($center);
            $objPHPExcel->getActiveSheet()->getStyle ( 'A3:G3' )->applyFromArray ($center);
            $objPHPExcel->getActiveSheet()->getStyle ( 'A5:G5' )->applyFromArray ($center);
            $objPHPExcel->getActiveSheet()->getStyle ( 'A' )->applyFromArray ($center);

            $right=array();
            $right ['alignment']=array();
            $right ['alignment']['horizontal']=PHPExcel_Style_Alignment::HORIZONTAL_RIGHT;
            $objPHPExcel->getActiveSheet()->getStyle ( 'C6:G1000' )->applyFromArray ($right);

            // $left=array();
            // $left ['alignment']=array();
            // $left ['alignment']['horizontal']=PHPExcel_Style_Alignment::HORIZONTAL_LEFT;
            // $objPHPExcel->getActiveSheet()->getStyle ( 'C6:M1000' )->applyFromArray ($left);

            //Mengatur font pada document excel
            $objPHPExcel->getActiveSheet()->getStyle('A1:G3')->getFont()->setName('Calibri');
            $objPHPExcel->getActiveSheet()->getStyle('A1:G3')->getFont()->setSize(9);
            $objPHPExcel->getActiveSheet()->getStyle('A1:G3')->getFont()->setBold(true);

            $objPHPExcel->getActiveSheet()->getStyle('A5:G1000')->getFont()->setSize(8);
            $objPHPExcel->getActiveSheet()->getStyle('A5:G5')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('A5:G5')->getAlignment()->setWrapText(true);

            $objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setName('Calibri')->setSize(8);

            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
            $objWriter->save('./download/excel/Data Pinjaman.xlsx'); 

            $this->load->helper('download');
            force_download('./download/excel/Data Pinjaman.xlsx', NULL);

            redirect('pinjaman/search_rekap_pinjaman');
            $this->template_admin->display('pinjaman/search_rekap_pinjaman', $this->data);

        } else {        //semua data penagihan

            include_once './assets/phpexcel/Classes/PHPExcel.php';
            $objPHPExcel = new PHPExcel();

            $data = $this->m_pinjaman->getPinjamansearchAll($bulan, $tahun);
            $total = $this->m_pinjaman->getPinjamantotalsearchAll($bulan, $tahun);
            $date = date('d-m-Y');
            $created_by = $this->session->userdata('username');
         
            $objPHPExcel = new PHPExcel(); 
            $objPHPExcel->setActiveSheetIndex(0); 
            $rowCount = 5;
            $i = 1; 

            $objPHPExcel->getActiveSheet()->mergeCells('A1:G1');
            $objPHPExcel->getActiveSheet()->mergeCells('A2:G2');
            $objPHPExcel->getActiveSheet()->mergeCells('A3:G3');

            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, "NO");
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, "NIP");
            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, "NAMA");
            $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, "JUMLAH PINJAMAN");
            $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, "TANGGAL PINJAM");
            $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, "SISA");
            $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, "KETERANGAN");
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

                $objPHPExcel->getActiveSheet()->SetCellValue('A1', "DAFTAR PINJAMAN KARYAWAN");
                $objPHPExcel->getActiveSheet()->SetCellValue('A2', "PT. Puri Makmur Lestari ");
                $objPHPExcel->getActiveSheet()->SetCellValue('A3', "BULAN $bulan $row->tahun_periode");
                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i++); 
                $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->nip); 
                $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->nama_karyawan);
                $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, number_format($row->jumlah_pinjaman));
                $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row->tgl_pinjaman);
                $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, number_format($row->sisa)); 
                $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row->nama_pinjaman);
                $rowCount++;
                // $rowCount++; 
            }
                $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, "Jumlah Total");
                $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, number_format($raw->total_pinjaman));
                $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, number_format($raw->total_sisa));
                $rowCount++;
                $rowCount++;
                $rowCount++;

                $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, "Bandung, $date");
                $rowCount++;
                $rowCount++;
                $rowCount++;
                $rowCount++;
                $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, "$created_by");

            }

            //Mengatur lebar cell pada document excel
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(6);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(18);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(24);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(24);

            //Mengatur tinggi cell pada document excel
            $objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(2);
            $objPHPExcel->getActiveSheet()->getRowDimension('5')->setRowHeight(26);

            //Mengatur align cell pada document excel
            $center = array();
            $center ['alignment']=array();
            $center ['alignment']['horizontal']=PHPExcel_Style_Alignment::HORIZONTAL_CENTER;
            $objPHPExcel->getActiveSheet()->getStyle ( 'A1:G1' )->applyFromArray ($center);
            $objPHPExcel->getActiveSheet()->getStyle ( 'A2:G2' )->applyFromArray ($center);
            $objPHPExcel->getActiveSheet()->getStyle ( 'A3:G3' )->applyFromArray ($center);
            $objPHPExcel->getActiveSheet()->getStyle ( 'A5:G5' )->applyFromArray ($center);
            $objPHPExcel->getActiveSheet()->getStyle ( 'A' )->applyFromArray ($center);

            $right=array();
            $right ['alignment']=array();
            $right ['alignment']['horizontal']=PHPExcel_Style_Alignment::HORIZONTAL_RIGHT;
            $objPHPExcel->getActiveSheet()->getStyle ( 'C6:G1000' )->applyFromArray ($right);

            // $left=array();
            // $left ['alignment']=array();
            // $left ['alignment']['horizontal']=PHPExcel_Style_Alignment::HORIZONTAL_LEFT;
            // $objPHPExcel->getActiveSheet()->getStyle ( 'C6:M1000' )->applyFromArray ($left);

            //Mengatur font pada document excel
            $objPHPExcel->getActiveSheet()->getStyle('A1:G3')->getFont()->setName('Calibri');
            $objPHPExcel->getActiveSheet()->getStyle('A1:G3')->getFont()->setSize(9);
            $objPHPExcel->getActiveSheet()->getStyle('A1:G3')->getFont()->setBold(true);

            $objPHPExcel->getActiveSheet()->getStyle('A5:G1000')->getFont()->setSize(8);
            $objPHPExcel->getActiveSheet()->getStyle('A5:G5')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('A5:G5')->getAlignment()->setWrapText(true);

            $objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setName('Calibri')->setSize(8);

            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
            $objWriter->save('./download/excel/Data Pinjaman.xlsx'); 

            $this->load->helper('download');
            force_download('./download/excel/Data Pinjaman.xlsx', NULL);

            redirect('pinjaman/search_rekap_pinjaman');
            $this->template_admin->display('pinjaman/search_rekap_pinjaman', $this->data);
        }
    }

    function logged_in() {
        if (!($this->session->userdata('logged_in'))) {
            redirect(base_url() . "auth");
        }
    }

}

?>