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
        $this->load->model(array('m_divisi','m_penempatan','m_karyawan','m_gaji_karyawan'));
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
        // $this->data['penagihan_list'] = $this->m_penagihan->fetch();
        // $this->data['divisi_list'] = $this->m_divisi->fetch();
        $this->data['penempatan_list'] = $this->m_penempatan->fetch();
        $this->data['karyawan_list'] = $this->m_karyawan->fetch();
        $this->data['gaji_karyawan_list'] = $this->m_gaji_karyawan->fetch();
        // $this->data['Gajikaryawanlist'] = $this->m_penagihan->Gajikaryawanlist();
        // $this->data['getPenagihan'] = $this->m_penagihan->getPenagihan();
        // $this->data['penagihanList'] = $this->m_penagihan->penagihanList();
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
        $this->data['gaji_karyawan'] = $this->m_gaji_karyawan->by_id($keys);
        // $this->data['gaji_karyawan'] = $this->m_gaji_karyawan->by_id($keys);
    }

    private function fetch_data($limit, $offset, $key) {
        $this->data['gaji_karyawan'] = $this->m_gaji_karyawan->fetch($limit, $offset, null, true,null, null, $key);
        // $this->data['gaji_karyawan'] = $this->m_gaji_karyawan->fetch($limit, $offset, null, true,null, null, $key);
        $this->data['total_rows'] = $this->m_gaji_karyawan->fetch(null,null, null, true,null, null, $key,true);
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

        $tgl_awal = $this->input->post('awal_tgl');
        $tgl_akhir = $this->input->post('akhir_tgl');

        $awal = strtotime($tgl_awal);
        $akhir = strtotime($tgl_akhir);

        $libur_nasional= array("2020-01-01","2020-01-25","2020-03-22","2020-03-25",
                               "2020-04-10","2020-05-01","2020-05-07","2020-05-21",
                               "2020-05-24","2020-05-25","2020-06-01","2020-07-31",
                               "2020-08-17","2020-08-20","2020-10-29","2020-12-25",

                               "2021-01-01","2021-02-12","2021-03-11","2021-03-14",
                               "2021-05-01","2021-05-02","2021-05-13","2021-05-15",
                               "2021-05-16","2021-05-26","2021-06-01","2021-07-20",
                               "2021-08-10","2021-08-17","2021-10-18","2021-12-25",

                               "2022-01-01","2022-02-01","2022-03-01","2022-03-03",
                               "2022-04-15","2022-05-01","2022-05-02","2022-05-03",
                               "2022-05-16","2022-05-26","2022-06-01","2022-07-10",
                               "2022-07-30","2022-08-17","2022-10-08","2022-12-25",

                               "2023-01-01","2023-01-22","2023-02-18","2023-03-22",
                               "2023-04-07","2023-04-22","2023-04-23","2023-05-01",
                               "2023-05-06","2023-05-18","2023-06-01","2023-06-29",
                               "2023-07-19","2023-08-17","2023-09-27","2023-12-25",

                               "2024-01-01","2024-01-08","2024-02-10","2024-03-11",
                               "2024-03-29","2024-04-10","2024-04-11","2024-05-01",
                               "2024-05-09","2024-05-23","2024-06-01","2024-06-17",
                               "2024-07-07","2024-08-17","2024-09-15","2024-12-25",

                               "2025-01-01","2025-01-27","2025-01-29","2025-03-29",
                               "2025-03-31","2025-04-01","2025-04-18","2025-05-01",
                               "2025-05-12","2025-05-29","2025-06-01","2025-06-07",
                               "2025-06-27","2025-08-17","2025-09-05","2025-12-25",
                                );

        $hari_kerja = 0;
        for ($i=$awal; $i <= $akhir; $i += (60 * 60 * 24)) {
            //ubah format time ke date
            $i_date=date("Y-m-d",$i);
            //cek apakah hari sabtu, minggu atau hari libur nasional, Jika bukan maka tambahkan hari kerja
            if (date("w",$i) !="0" AND date("w",$i) !="6" AND !in_array($i_date,$libur_nasional)) {
                 $hari_kerja++;
            }
        }

        $jmlh_hari = $hari_kerja;

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
        $status_pernikahan = $this->input->post('status_pernikahan');
        $id_karyawan = $this->input->post('id_karyawan');


        if ($bpjstk_status == 1) {
            $hitung_bpjstk = $gapok * 0.0624;
            $potong_bpjstk = $gapok * 0.0924;
        } else {
            $hitung_bpjstk = $gapok * 0.0624;
            $potong_bpjstk = $gapok * 0.0624;
        }

        if ($bpjskes_status == 1) {
            $hitung_bpjskes = $gapok * 0.04;
            $potong_bpjskes = $gapok * 0.05;
        } else {
            $hitung_bpjskes = $gapok * 0.04;
            $potong_bpjskes = $gapok * 0.04;
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

        $hitungthp = ($gapok + $bpjstk_hitung + $bpjskes_hitung + $dapen_hitung + $tmakan + $tlain) - ($bpjstk_potong + $bpjskes_potong + $dapen_potong + $psimpananwajib + $psekunder + $pdarurat + $ptoko + $plain + $hitung_absen3);


        //hitung jumlah anak
        // $query=$this->db->query("SELECT count(id_anak) FROM anak WHERE id_karyawan='$id_karyawan'");
        // $jum_anak=$query;
        $jum_anak = "SELECT count(id_anak) FROM anak WHERE id_karyawan='$id_karyawan' ";
            $query = $this->db->query($jum_anak);

        if ($jum_anak == 1) {
            $ptkp_anak = 4500000;
        } elseif ($jum_anak == 2) {
            $ptkp_anak == 9000000;
        } elseif ($jum_anak == 3) {
            $ptkp_anak = 13500000;
        } else {
            $ptkp_anak = 0;
        }


        //status pernikahan
        // $query=$this->db->query("SELECT hubungan FROM keluarga WHERE id_karyawan='$id_karyawan'");
        // $cek_hubungan=$query;
        $cek_hubungan = "SELECT hubungan FROM keluarga WHERE id_karyawan='$id_karyawan' ";
            $query = $this->db->query($cek_hubungan);

        if ($status_pernikahan == ("Menikah")) {
            $ptkp_nikah = 4500000;
        } else {
            $ptkp_nikah = 0;
        }

        if ($status_pernikahan == ("Belum Menikah")) {
            $ptkp = 54000000; 
        } elseif ($status_pernikahan == ("Belum Menikah") && $jum_anak == 1) {
            $ptkp = 58500000;
        } elseif ($status_pernikahan == ("Belum Menikah") && $jum_anak == 2) {
            $ptkp = 63000000;
        } elseif ($status_pernikahan == ("Belum Menikah") && $jum_anak == 3) {
            $ptkp = 67500000;
        } elseif ($status_pernikahan == ("Menikah") && $jum_anak == 0) {
            $ptkp = 58500000;
        } elseif ($status_pernikahan == ("Menikah") && $jum_anak == 1) {
            $ptkp = 63000000;
        } elseif ($status_pernikahan == ("Menikah") && $jum_anak == 2) {
            $ptkp = 67500000;
        } elseif ($status_pernikahan == ("Menikah") && $jum_anak == 3) {
            $ptkp = 72000000;
        } else {
            $ptkp = 0;
        }

        //hitung ptkp
        $thp_tahun = $hitungthp * 12;
        $pkp = abs($thp_tahun - $ptkp);
        $pkp1 = $thp_tahun - $ptkp;

        

        $sisa_ptkp_1 = $pkp1;
        $sisa_ptkp_2 = $sisa_ptkp_1 - 50000000;
        $sisa_ptkp_2a = abs($sisa_ptkp_1 - 50000000);
        $sisa_ptkp_3 = $sisa_ptkp_2 - 250000000;
        $sisa_ptkp_4 = $sisa_ptkp_2 - 500000000;


        //cek progresif
        // if ($pkp <= 50000000 ) {
        //     $pajak = $thp_tahun * 0.05;
        // } else { 
        //     $pajak = 0;
        // }

        if ($thp_tahun < 54000000 ) {
            $pajak = 0;
        } else { 
            $pajak = 0;
        }

        if ($pkp1 <= 50000000 && $pkp1 > 0) {
            $pajak1 = $pkp1 * 0.05;
        } elseif ($pkp1 > 50000000 && $sisa_ptkp_2 < 250000000 && $sisa_ptkp_3 <= 0) {
            $pajak1 = (50000000 * 0.05) + ($sisa_ptkp_2 * 0.15);
        } else { 
            $pajak1 = 0 ;
        } 

        if ($pkp1 > 50000000 && $sisa_ptkp_2 > 250000000 && $sisa_ptkp_3 > 0 && $sisa_ptkp_3 <= 500000000) {
            $pajak2 = (50000000 * 0.05) + (250000000 * 0.15) + ($sisa_ptkp_3 * 0.25);
        } else {
            $pajak2 = 0;
        }

        if ($sisa_ptkp_1 > 0 && $sisa_ptkp_2 == 0 && $sisa_ptkp_3 > 500000000) {
            $pajak3 = $sisa_ptkp_3 * 0.3;
        } else { 
            $pajak3 = 0;
        }


        $progresif = $pajak + $pajak1 + $pajak2 + $pajak3;
        $progresif_bulan = $progresif / 12;


        $hitungthp2 = $hitungthp - $progresif_bulan;

        $periode = date('d-m-Y');

        //cek id karyawan
        // $get_id_otomatis = $this->data['get_id_otomatis'] = $this->m_gaji_karyawan->get_id_otomatis();
        // foreach ($get_id_otomatis as $id) {
        //     $id_max = $id->get_gaji_id;
        //     $get_id = $id_max++;
        // }

        // $id_gaji = $get_id+1;

        //input ke ppenagihan
        $rafel = $this->input->post('rafel');
        $thr = $this->input->post('thr');
        $fee = $this->input->post('fee');
        $nip = $this->input->post('nip');
        $id_penempatan = $this->input->post('id_penempatan');
        // $id_gaji_karyawan = $this->input->post('id_gaji_karyawan');
        $created_by = $this->session->userdata('username');
        $created_at = date('Y-m-d H:i:s');
        $pph21b = $progresif_bulan;

        $upah = ($hitungthp2 + $rafel) - $hitung_absen3;
        $fee_pt = ($upah + $bpjstk_hitung + $bpjskes_hitung + $pph21b + $thr);
        $fee_pt1 = ($fee_pt * $fee);
        $pph23 = $fee_pt1 * 0.02;
        $tagihan = $upah + $bpjskes_hitung + $bpjstk_hitung + $pph21b + $thr + $fee_pt1 + $pph23;

        $data = array(
            // 'gaji_id' => $id_gaji,
            'id_karyawan' => $this->input->post('id_karyawan'),
            'nama_karyawan' => $this->input->post('nama_karyawan'),
            'nip' => $this->input->post('nip'),
            'periode' => $this->input->post('akhir_tgl'),
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
            'thp' => $hitungthp2,
            'pph21_bulan' => $progresif_bulan,
            'pph21_tahun' => $progresif,
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
            $this->m_gaji_karyawan->insert($obj);
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
            $this->template_admin->display('penagihan/penagihan_insert', $this->data);
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
        $this->template_admin->display('penagihan/penagihan_detail', $this->data);
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

        $data = $this->m_gaji_karyawan->getPenagihan();
        $total = $this->m_gaji_karyawan->getPenagihantotal();
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
            $this->data['getPenagihansearch'] = $this->m_gaji_karyawan->getPenagihansearch($bulan, $tahun, $penempatan);
            $this->data['getPenagihantotalsearch'] = $this->m_gaji_karyawan->getPenagihantotalsearch($bulan, $tahun, $penempatan);
            $jumlah = $this->m_gaji_karyawan->getPenagihantotalsearch($bulan, $tahun, $penempatan);
            $this->data['jumlah_total'] = $jumlah;

            $this->template_admin->display('penagihan/search_rekap_penagihan', $this->data);
        } else {
            $this->data['getPenagihansearchAll'] = $this->m_gaji_karyawan->getPenagihansearchAll($bulan, $tahun);
            $this->data['getPenagihantotalsearchAll'] = $this->m_gaji_karyawan->getPenagihantotalsearchAll($bulan, $tahun);
            $jumlah = $this->m_gaji_karyawan->getPenagihantotalsearchAll($bulan, $tahun);
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
        
        $this->data['getPenagihansearch'] = $this->m_gaji_karyawan->getPenagihansearch($bulan, $tahun, $penempatan);
        $this->data['getPenagihantotalsearch'] = $this->m_gaji_karyawan->getPenagihantotalsearch($bulan, $tahun, $penempatan);
        $jumlah = $this->m_gaji_karyawan->getPenagihantotalsearch($bulan, $tahun, $penempatan);
        $this->data['jumlah_total'] = $jumlah;

        $this->data['getPenagihansearchAll'] = $this->m_gaji_karyawan->getPenagihansearchAll($bulan, $tahun);
        $this->data['getPenagihantotalsearchAll'] = $this->m_gaji_karyawan->getPenagihantotalsearchAll($bulan, $tahun);

        if($penempatan != 0) {      //data penagihan berdasarkan penempatan

            include_once './assets/phpexcel/Classes/PHPExcel.php';
            $objPHPExcel = new PHPExcel();

            $data = $this->m_gaji_karyawan->getPenagihansearch($bulan, $tahun, $penempatan);
            $total = $this->m_gaji_karyawan->getPenagihantotalsearch($bulan, $tahun, $penempatan);
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
            $objWriter->save('./download/excel/Data Penagihan.xlsx'); 

            $this->load->helper('download');
            force_download('./download/excel/Data Penagihan.xlsx', NULL);

            redirect('penagihan/search_rekap_penagihan');
            $this->template_admin->display('penagihan/search_rekap_penagihan', $this->data);

        } else {        //semua data penagihan

            include_once './assets/phpexcel/Classes/PHPExcel.php';
            $objPHPExcel = new PHPExcel();

            $data = $this->m_gaji_karyawan->getPenagihansearchAll($bulan, $tahun);
            $total = $this->m_gaji_karyawan->getPenagihantotalsearchAll($bulan, $tahun);
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
            $objWriter->save('./download/excel/Data Penagihan.xlsx'); 

            $this->load->helper('download');
            force_download('./download/excel/Data Penagihan.xlsx', NULL);

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