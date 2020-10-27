<?php

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        define('CURRENT_CONTEXT', base_url() . 'dashboard/');
        $this->data = array();
        init_generic_dao();
        $this->load->library(array('template_admin'));
        $this->load->model(array('m_dashboard','m_karyawan'));
        $this->logged_in();
        $this->data['page_title'] = "Dashboard";
    }
    
    public function index(){
        $jumlah_karyawan[0] =  $this->m_dashboard->getkaryawan();
        if (!empty($jumlah_karyawan)) {
            $this->data['jumlah_karyawan'] = $jumlah_karyawan[0][0]->jumlah_karyawan;
        }

        $jumlah_kontrak[0] =  $this->m_dashboard->getkontrak();
        if (!empty($jumlah_kontrak)) {
            $this->data['jumlah_kontrak'] = $jumlah_kontrak[0][0]->jumlah_kontrak;
        }

        $jumlah_tidak_kontrak[0] =  $this->m_dashboard->getnotkontrak();
        if (!empty($jumlah_tidak_kontrak)) {
            $this->data['jumlah_tidak_kontrak'] = $jumlah_tidak_kontrak[0][0]->jumlah_tidak_kontrak;
        }

        $this->data['getListkontrak'] =  $this->m_dashboard->getListkontrak();
        $this->data['getDiagram'] =  $this->m_dashboard->getDiagram();

        $this->data['getPendidikan'] =  $this->m_dashboard->getPendidikan();
        $this->data['getPernikahan'] =  $this->m_dashboard->getPernikahan();
        $this->data['getJurusan'] =  $this->m_dashboard->getJurusan();

        $this->template_admin->display('dashboard',$this->data);

    }

    public function export_excel(){
        // $this->preload();
        // $bulan = $this->input->post('bln');
        // $tahun = $this->input->post('thn');
        
        $this->data['getListkontrak'] = $this->m_dashboard->getListkontrak();

        // $this->template_admin->display('penagihan/search_rekap_penagihan', $this->data);

        include_once './assets/phpexcel/Classes/PHPExcel.php';
        $objPHPExcel = new PHPExcel();

        $data = $this->m_dashboard->getListkontrak();
        $date = date('d-m-Y');
        $created_by = $this->session->userdata('username');
     
        $objPHPExcel = new PHPExcel(); 
        $objPHPExcel->setActiveSheetIndex(0); 
        $rowCount = 4;
        $i = 1; 

        $objPHPExcel->getActiveSheet()->mergeCells('A1:I1');
        $objPHPExcel->getActiveSheet()->mergeCells('A2:I2');
        

        $objPHPExcel->getActiveSheet()->SetCellValue('A1', "DAFTAR KARYAWAN HABIS KONTRAK");
        $objPHPExcel->getActiveSheet()->SetCellValue('A2', "PT. Puri Makmur Lestari");
        $objPHPExcel->getActiveSheet()->SetCellValue('A4', "NO");
        $objPHPExcel->getActiveSheet()->SetCellValue('B4', "NIP");
        $objPHPExcel->getActiveSheet()->SetCellValue('C4', "NIK");
        $objPHPExcel->getActiveSheet()->SetCellValue('D4', "NAMA");
        $objPHPExcel->getActiveSheet()->SetCellValue('E4', "PENEMPATAN");
        $objPHPExcel->getActiveSheet()->SetCellValue('F4', "NOMOR KONTRAK");
        $objPHPExcel->getActiveSheet()->SetCellValue('G4', "TANGGAL MASUK");
        $objPHPExcel->getActiveSheet()->SetCellValue('H4', "TANGGAL BERAKHIR");
        $objPHPExcel->getActiveSheet()->SetCellValue('I4', "SISA HARI");
        $rowCount++;


        foreach($data as $row){


            // $objPHPExcel->getActiveSheet()->SetCellValue('A1', "DAFTAR KARYAWAN HABIS KONTRAK");
            // $objPHPExcel->getActiveSheet()->SetCellValue('A2', "PT. Puri Makmur Lestari ");
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i++); 
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->nama_karyawan);
            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, ' '.$row->nip);
            $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, ' '.$row->nik); 
            $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row->nama_perusahaan);
            $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row->no_kontrak);
            $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row->tgl_masuk); 
            $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row->tgl_berakhir); 
            $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $row->selisih.' Hari');
            $rowCount++; 
        }
            $rowCount++;
            $rowCount++;
            $rowCount++;
            $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, "Bandung, $date");
            $rowCount++;
            $rowCount++;
            $rowCount++;
            $rowCount++;
            $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, "$created_by");
           

        //Mengatur lebar cell pada document excel
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(24);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(17);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(24);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);

        //Mengatur tinggi cell pada document excel
        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(16);
        $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(16);
        $objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight(2);
        $objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(16);
        // $objPHPExcel->getActiveSheet()->getRowDimension('5')->setRowHeight(26);

        //Mengatur align cell pada document excel
        $center = array();
        $center ['alignment']=array();
        $center ['alignment']['horizontal']=PHPExcel_Style_Alignment::HORIZONTAL_CENTER;
        $objPHPExcel->getActiveSheet()->getStyle ( 'A1:I1' )->applyFromArray ($center);
        $objPHPExcel->getActiveSheet()->getStyle ( 'A2:I2' )->applyFromArray ($center);
        $objPHPExcel->getActiveSheet()->getStyle ( 'A4:I1000' )->applyFromArray ($center);
        // $objPHPExcel->getActiveSheet()->getStyle ( 'A5:A1000' )->applyFromArray ($center);
        // $objPHPExcel->getActiveSheet()->getStyle ( 'F6:H6' )->applyFromArray ($center);
        // $objPHPExcel->getActiveSheet()->getStyle ( 'J6:M6' )->applyFromArray ($center);
        // $objPHPExcel->getActiveSheet()->getStyle ( 'P5' )->applyFromArray ($center);

        // $right=array();
        // $right ['alignment']=array();
        // $right ['alignment']['horizontal']=PHPExcel_Style_Alignment::HORIZONTAL_RIGHT;
        // $objPHPExcel->getActiveSheet()->getStyle ( 'C6:O1000' )->applyFromArray ($right);

        // $left=array();
        // $left ['alignment']=array();
        // $left ['alignment']['horizontal']=PHPExcel_Style_Alignment::HORIZONTAL_LEFT;
        // $objPHPExcel->getActiveSheet()->getStyle ( 'C6:M1000' )->applyFromArray ($left);

        //Mengatur font pada document excel
        $objPHPExcel->getActiveSheet()->getStyle('A1:I2')->getFont()->setName('Calibri');
        $objPHPExcel->getActiveSheet()->getStyle('A1:I2')->getFont()->setSize(9);
        $objPHPExcel->getActiveSheet()->getStyle('A1:I2')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A4:I4')->getFont()->setSize(8);
        $objPHPExcel->getActiveSheet()->getStyle('A4:I4')->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->getStyle('A5:I1000')->getFont()->setSize(8);
        $objPHPExcel->getActiveSheet()->getStyle('A5:I1000')->getFont()->setBold(false);
        $objPHPExcel->getActiveSheet()->getStyle('A5:I1000')->getAlignment()->setWrapText(true);

        // $objPHPExcel->getActiveSheet()->getStyle('P5')->getFont()->setSize(8);
        // $objPHPExcel->getActiveSheet()->getStyle('P5')->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setName('Calibri')->setSize(8);

        // $objPHPExcel->getActiveSheet()->getStyle('N7:N1000')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);

        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
        $objWriter->save('./download/excel/Data Kontrak.xlsx'); 

        $this->load->helper('download');
        force_download('./download/excel/Data Kontrak.xlsx', NULL);

        redirect(CURRENT_CONTEXT);
        $this->template_admin->display('dashboard', $this->data);
    }
    
    function logged_in() {
        if (!($this->session->userdata('logged_in'))) {
            redirect(base_url() . "auth");
        }
    }

}

?>