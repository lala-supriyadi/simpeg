<?php

class karyawan extends CI_Controller {

    public $data;
    public $filter;
    public $limit = 10;

    public function __construct() {
        parent::__construct();
        define('CURRENT_CONTEXT', base_url() . 'karyawan/');
        $this->data = array();
        init_generic_dao();
        $this->load->model(array('m_karyawan','m_divisi','m_penempatan'));
        $this->load->library(array('template_admin'));
        $this->logged_in();
        $this->data['page_title'] = "karyawan";
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
        $this->data['karyawan_list'] = $this->m_karyawan->fetch();
        $this->data['divisi_list'] = $this->m_divisi->fetch();
        $this->data['penempatan_list'] = $this->m_penempatan->fetch();
    }    

    public function index($page = 1) {
        $this->preload();
        $this->session->set_userdata(array(
            'filter_karyawan' => array(
                'nip' => '',
                'nama_karyawan' => ''
                ))
        );
        $offset = ($page - 1) * $this->limit;
        $this->data['offset'] = $offset;
        $this->get_list($this->limit, $offset);
    }

    public function fetch_record($keys) {
        $this->data['karyawan'] = $this->m_karyawan->by_id($keys);
    }

    private function fetch_data($limit, $offset, $key) {
        $this->data['karyawan'] = $this->m_karyawan->fetch($limit, $offset, null, true,null, null, $key);
        $this->data['total_rows'] = $this->m_karyawan->fetch(null,null, null, true,null, null, $key,true);
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
        $data = array(
            'id_penempatan' => $this->input->post('id_penempatan'),
            'nip' => $this->input->post('nip'),
            'kode_pagu' => $this->input->post('kode_pagu'),
            'nik' => $this->input->post('nik'),
            'no_npwp' => $this->input->post('no_npwp'),
            'nama_karyawan' => $this->input->post('nama_karyawan'),
            'tempat_lahir' => $this->input->post('tempat_lahir'),
            'tgl_lahir' => $this->input->post('tgl_lahir'),
            'foto' => $this->upload(),
            'agama' => $this->input->post('agama'),
            'jenis_kelamin' => $this->input->post('jenis_kelamin'),
            'alamat' => $this->input->post('alamat'),
            'no_telp' => $this->input->post('no_telp'),
            'email' => $this->input->post('email'),
            'bank' => $this->input->post('bank'),
            'no_rekening' => $this->input->post('no_rekening'),
            'status_pernikahan' => $this->input->post('status_pernikahan'),
            'grade' => $this->input->post('grade'),
            'jurusan' => $this->input->post('jurusan'),           
            'nama_kontrak' => $this->input->post('nama_kontrak'),
            'no_kontrak' => $this->input->post('no_kontrak'),
            'tgl_masuk' => $this->input->post('tgl_masuk'),
            'tgl_berakhir' => $this->input->post('tgl_berakhir'),
            'divisi' => $this->input->post('nama_divisi'),
            'jabatan' => $this->input->post('jabatan'),
            'gaji_pokok' => $this->input->post('gaji_pokok')
        );
        // print_r($data);die();
        return $data;
    }

    public function add() {
        $obj = $this->fetch_input();
        $obj['created_by'] = $this->session->userdata('username');
        $obj['created_at'] = date('Y-m-d H:i:s');

        if ($this->validate() != false) {
            $this->m_karyawan->insert($obj);
            redirect(CURRENT_CONTEXT);
        } else {
            $this->preload();
            $this->data['edit'] = false;
            #set value
            $this->data['karyawan'] = (object) $obj;
            $this->template_admin->display('karyawan/karyawan_insert', $this->data);
        }
    }

    /**

      @description
      viewing editing form. repopulation for every data needed in form done here.
     */
    public function edit($id_karyawan) {
        $obj = $this->fetch_input();
        $obj['updated_by'] = $this->session->userdata('username');
        $obj['updated_at'] = date('Y-m-d H:i:s');
        $obj['updated_status'] = ('1');

        $obj_id = array('id_karyawan' => $id_karyawan);

        if ($this->validate() != false) {
            $this->m_karyawan->update($obj, $obj_id);
            redirect(CURRENT_CONTEXT);
        } else {
            $this->preload();
            $this->data['edit'] = true;
            $this->fetch_record($obj_id);
            $this->template_admin->display('karyawan/karyawan_insert', $this->data);
        }
    }

    /**
      @description
      viewing record. repopulation for every data needed for view.
     */
   

    public function detail($id_karyawan) {
        $obj_id = array('id_karyawan' => $id_karyawan);

        $this->preload();
        $this->fetch_record($obj_id);
        $this->template_admin->display('karyawan/karyawan_detail', $this->data);
    }

    public function delete($id_karyawan) {
        $obj_id = array('id_karyawan' => $id_karyawan);
        $obj = array('updated_by' => $this->session->userdata('username'), 'updated_at' => date('Y-m-d H:i:s'),'is_deleted' => 1);
        $this->m_karyawan->update($obj, $obj_id);
		$this->session->set_flashdata(array('message'=>'Data berhasil dihapus.','type_message'=>'success'));
        redirect(CURRENT_CONTEXT);
    }
	
	public function delete_multiple(){
        $data = file_get_contents('php://input');
        $id = json_decode($data);
        $obj = array('updated_by' => $this->session->userdata('username'), 'updated_at' => date('Y-m-d H:i:s'),'is_deleted' => 1);
		foreach($id->ids as $id){
			$obj_id = array('id_karyawan' => $id->id_karyawan);
			$this->m_karyawan->update($obj, $obj_id);
		}
		$this->session->set_flashdata(array('message'=>'Data berhasil dihapus.','type_message'=>'success'));
        echo json_encode(array('status'=>200));
    }

	public function search($page = 1) {
        $this->preload();
		$key = $this->session->userdata('filter_karyawan');
        if ($this->input->post('search')) {
            $key = array(
                'nip' => $this->input->post('nip'),
                'nama_karyawan' => $this->input->post('nama_karyawan')
            );
			$this->session->set_userdata(array('filter_karyawan' => $key));  
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
        $this->template_admin->display('karyawan/karyawan_list', $this->data);
    }

    public function upload_excel(){
        $this->load->library(array('PHPExcel','PHPExcel/IOFactory'));

        //cek jumlah hari
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

        //cek id karyawan
        $get_id_karyawan = $this->data['get_id_karyawan'] = $this->m_karyawan->get_id_karyawan();
        foreach ($get_id_karyawan as $id) {
            $id_max = $id->get_id_karyawan;
            $get_id = $id_max++;
        }

        $id = $get_id+1;
        $id2 = $get_id+1;
        $id3 = $get_id+1;

        //cek id gaji karyawan
        $get_id_gaji_karyawan = $this->data['get_id_gaji_karyawan'] = $this->m_karyawan->get_id_gaji_karyawan();
        foreach ($get_id_gaji_karyawan as $id_gaji) {
            $id_max2 = $id_gaji->get_id_gaji_karyawan;
            $get_id_gaji = $id_max2++;
        }

        $id_gaji = $get_id_gaji+1;
        $id_gaji2 = $get_id_gaji+1;

        //cek id penagihan
        // $get_id_penagihan = $this->data['get_id_penagihan'] = $this->m_karyawan->get_id_penagihan();
        // foreach ($get_id_penagihan as $id_penagih) {
        //     $id_max_penagihan = $id_penagih->get_id_penagihan;
        //     $id_penagihan2 = $id_max_penagihan++;
        // }

        // $penagihan_id = $id_penagihan2+1;

        //import
        // $config['upload_path'] = './upload/karyawan_foto';
        // $config['allowed_types'] = 'gif|png|jpg|jpeg';
        // $config['max_size'] = 100000;
        // $this->load->library('upload', $config);   
        // $this->upload->do_upload('foto');
        // $upload = $this->upload->data();
        // return $upload['file_name'];

        // $fileName = time().$_FILES['excel']['name'];
         
        $config['upload_path'] = './assets/excel/'; //buat folder dengan nama assets di root folder
        // $config['file_name'] = $fileName;
        $config['allowed_types'] = 'xls|xlsx|csv';
        $config['max_size'] = 400000;
         
        // $this->load->library('upload');
        $this->load->library('upload', $config);   
        // $this->upload->initialize($config);

         
        if(! $this->upload->do_upload() )
        $this->upload->display_errors();

             
        $media = $this->upload->data();
        // return $media['file_name'];
        $inputFileName = './assets/excel/'.$media['file_name'];
         
        try {
                $inputFileType = IOFactory::identify($inputFileName);
                $objReader = IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch(Exception $e) {
                die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
            }
 
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
             
            for ($row = 2; $row <= $highestRow; $row++){                  //  Read a row of data into an array                 
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                                NULL,
                                                TRUE,
                                                FALSE);
                $var  = PHPExcel_Style_NumberFormat::toFormattedString($rowData[0][6],  'YYYY-MM-DD');
                $var1  = PHPExcel_Style_NumberFormat::toFormattedString($rowData[0][9],  'YYYY-MM-DD');
                $var2  = PHPExcel_Style_NumberFormat::toFormattedString($rowData[0][10],  'YYYY-MM-DD');
                $created_by = $this->session->userdata('username');
                $created_at = date('Y-m-d H:i:s');
                $nikpen = $rowData[0][2];
                $no_rek = $rowData[0][15];
                $cek_id = $rowData[0][11];
                $cek_kontrak = $rowData[0][19];
                

                if ($cek_id == "LEN INDUSTRI") {
                    $penempatan_id = 4;
                } elseif ($cek_id == "Len Railways System") {
                    $penempatan_id = 5;
                } elseif ($cek_id == "PT Len IOTI Fintech") {
                    $penempatan_id = 2;
                } elseif ($cek_id == "Len Rekaprima Semesta") {
                    $penempatan_id = 6;
                } elseif ($cek_id == "Len Telekomunikasi Indonesia") {
                    $penempatan_id = 7;
                } elseif ($cek_id == "Surya Energy Indonesia") {
                    $penempatan_id = 8;
                } elseif ($cek_id == "PT Eltran") {
                    $penempatan_id = 9;
                } elseif ($cek_id == "Koperasi Karyawan Len") {
                    $penempatan_id = 10;
                } else {
                    $penempatan_id = 3;
                }

                //cek status
                $cek_statuc_bpjs = $rowData[0][8];
                if ($cek_statuc_bpjs == "Aktif") {
                    $status = 1;
                } else {
                    $status = 0;
                }

                //hitung upah. pph23, tagihan
                $upah = $rowData[0][16];
                $upah_kotor = $rowData[0][26];
                $pph21 = $rowData[0][24];

                $cek_fee2 = $this->m_karyawan->cek_fee2();
                    foreach ($cek_fee2 as $cekfee2) {
                    $fee2[] = $cekfee2->nilai_fee2;
                    }
                    $hasil_fee2 = implode(" ", $fee2);
                $cek_fee3 = $this->m_karyawan->cek_fee3();
                    foreach ($cek_fee3 as $cekfee3) {
                    $fee3[] = $cekfee3->nilai_fee3;
                    }
                    $hasil_fee3 = implode(" ", $fee3);
                $cek_fee4 = $this->m_karyawan->cek_fee4();
                    foreach ($cek_fee4 as $cekfee4) {
                    $fee4[] = $cekfee4->nilai_fee4;
                    }
                    $hasil_fee4 = implode(" ", $fee4);
                $cek_fee5 = $this->m_karyawan->cek_fee5();
                    foreach ($cek_fee5 as $cekfee5) {
                    $fee5[] = $cekfee5->nilai_fee5;
                    }
                    $hasil_fee5 = implode(" ", $fee5);
                $cek_fee6 = $this->m_karyawan->cek_fee6();
                    foreach ($cek_fee6 as $cekfee6) {
                    $fee6[] = $cekfee6->nilai_fee6;
                    }
                    $hasil_fee6 = implode(" ", $fee6);
                $cek_fee7 = $this->m_karyawan->cek_fee7();
                    foreach ($cek_fee7 as $cekfee7) {
                    $fee7[] = $cekfee7->nilai_fee7;
                    }
                    $hasil_fee7 = implode(" ", $fee7);
                $cek_fee8 = $this->m_karyawan->cek_fee8();
                    foreach ($cek_fee8 as $cekfee8) {
                    $fee8[] = $cekfee8->nilai_fee8;
                    }
                    $hasil_fee8 = implode(" ", $fee8);
                $cek_fee9 = $this->m_karyawan->cek_fee9();
                    foreach ($cek_fee9 as $cekfee9) {
                    $fee9[] = $cekfee9->nilai_fee9;
                    }
                    $hasil_fee9 = implode(" ", $fee9);
                $cek_fee10 = $this->m_karyawan->cek_fee10();
                    foreach ($cek_fee10 as $cekfee10) {
                    $fee10[] = $cekfee10->nilai_fee10;
                    }
                    $hasil_fee10 = implode(" ", $fee10);

                if ($cek_id == "PT Len IOTI Fintech") {
                    $fee = $hasil_fee2;
                } elseif ($cek_id == "PT Puri Makmur Lestari") {
                    $fee = $hasil_fee3;
                } elseif ($cek_id == "LEN INDUSTRI") {
                    $fee = $hasil_fee4;
                } elseif ($cek_id == "Len Railways System") {
                    $fee = $hasil_fee5;
                } elseif ($cek_id == "Len Rekaprima Semesta") {
                    $fee = $hasil_fee6;
                } elseif ($cek_id == "Len Telekomunikasi Indonesia") {
                    $fee = $hasil_fee7;
                } elseif ($cek_id == "Surya Energy Indonesia") {
                    $fee = $hasil_fee8;
                } elseif ($cek_id == "PT Eltran") {
                    $fee = $hasil_fee9;
                } elseif ($cek_id == "Koperasi Karyawan Len") {
                    $fee = $hasil_fee10;
                } else {
                    $fee = $hasil_fee3;
                }

                // $hasil_fee = implode(" ", $fee);

                // print_r($fee);die();

                
                //pembulatan gaji
                $gaji_bulat = floor($rowData[0][16]);   //Gaji kotor
                $gaji_bulat2 = floor($rowData[0][26]);   //Gaji bersih

                //status pernikahan
                $pernikahan = "Belum Menikah";

                //hitung jumlah anak
                $jum_anak = "SELECT count(id_anak) FROM anak WHERE id_karyawan='$id' ";
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
                if ($pernikahan == ("Menikah")) {
                    $ptkp_nikah = 4500000;
                } else {
                    $ptkp_nikah = 0;
                }

                if ($pernikahan == ("Belum Menikah")) {
                    $ptkp = 54000000; 
                } elseif ($pernikahan == ("Belum Menikah") && $jum_anak == 1) {
                    $ptkp = 58500000;
                } elseif ($pernikahan == ("Belum Menikah") && $jum_anak == 2) {
                    $ptkp = 63000000;
                } elseif ($pernikahan == ("Belum Menikah") && $jum_anak == 3) {
                    $ptkp = 67500000;
                } elseif ($pernikahan == ("Menikah") && $jum_anak == 0) {
                    $ptkp = 58500000;
                } elseif ($pernikahan == ("Menikah") && $jum_anak == 1) {
                    $ptkp = 63000000;
                } elseif ($pernikahan == ("Menikah") && $jum_anak == 2) {
                    $ptkp = 67500000;
                } elseif ($pernikahan == ("Menikah") && $jum_anak == 3) {
                    $ptkp = 72000000;
                } else {
                    $ptkp = 0;
                }

                //hitung ptkp
                $biaya_jabatan = $gaji_bulat2 * 0.05;       //hitung biaya jabatan
                $biaya_jabatan2 = $gaji_bulat2 - $biaya_jabatan;        //hitung biaya jabatan
                $thp_tahun = $biaya_jabatan2 * 12;
                $pkp = abs($thp_tahun - $ptkp);
                $pkp1 = $thp_tahun - $ptkp;

                $sisa_ptkp_1 = $pkp1;
                $sisa_ptkp_2 = $sisa_ptkp_1 - 50000000;
                $sisa_ptkp_2a = abs($sisa_ptkp_1 - 50000000);
                $sisa_ptkp_3 = $sisa_ptkp_2 - 250000000;
                $sisa_ptkp_4 = $sisa_ptkp_2 - 500000000;

                //cek progresif
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


                $pajak_pertahun = $pajak + $pajak1 + $pajak2 + $pajak3;     //pph21 tahun
                $pajak_perbulan = $pajak_pertahun / 12;     //pph21 bukan

                //fee pt
                $fee_pt = $upah_kotor * $fee;
                $pph23 = $fee_pt * 0.02;
                $tagihan = $upah_kotor + $pajak_perbulan + $fee_pt + $pph23;
                // $tagihan = $upah_kotor + $pph21 + $fee_pt + $pph23;

                                                 
                //Sesuaikan sama nama kolom tabel di database                                
                 $data = array(
                    "id_karyawan"=> $id++,
                    "id_penempatan"=> $penempatan_id,
                    "nip"=> $rowData[0][0],
                    "kode_pagu"=> $rowData[0][1],
                    "nik"=> $nikpen,
                    "nama_karyawan"=> $rowData[0][3],
                    "tgl_lahir"=> $var,
                    "jenis_kelamin"=> $rowData[0][4],
                    "alamat"=> $rowData[0][5],
                    "no_telp"=> $rowData[0][14],
                    "no_rekening"=> $no_rek,
                    "status_pernikahan"=> $pernikahan,
                    "grade"=> $rowData[0][12],
                    "jurusan"=> $rowData[0][13],
                    "nama_kontrak"=> $rowData[0][28],
                    "no_kontrak"=> $rowData[0][29],
                    "tgl_masuk"=> $var1,
                    "tgl_berakhir"=> $var2,
                    "divisi"=> $rowData[0][7],
                    "jabatan"=> $rowData[0][30],
                    "gaji_pokok"=> $gaji_bulat,
                    "created_at"=> $created_at,
                    "created_by"=> $created_by
                    
                ); 

                $data2 = array(
                    "id_gaji_karyawan"=> $id_gaji++,
                    "id_karyawan"=> $id2++,
                    "nip"=> $rowData[0][0],
                    "periode"=> $tgl_akhir,
                    "jml_hari"=> $jmlh_hari,
                    // "tunj_jabatan"=> $rowData[0][2],
                    "tunj_bpjstk"=> $rowData[0][17],
                    "tunj_bpjskes"=> $rowData[0][18],
                    // "tunj_dapen"=> $var,
                    "bpjstk_stat_tun"=> $status,
                    "bpjskes_stat_tun"=> $status,
                    // "dapen_stat_tun"=> $status,
                    // "tunj_makan"=> $no_rek,
                    "tunj_lain"=> $rowData[0][19],
                    // "potongan_absensi"=> $rowData[0][14],
                    // "jatah_cuti_mandiri"=> $rowData[0][29],
                    // "jatah_cuti_bersama"=> $rowData[0][30],
                    "potongan_bpjstk"=> $rowData[0][21],
                    "potongan_bpjskes"=> $rowData[0][22],
                    // "potongan_dapen"=> $rowData[0][8],
                    // "potongan_simpanan_wajib"=> $rowData[0][31],
                    // "potongan_sekunder"=> $rowData[0][17],
                    // "potongan_darurat"=> $rowData[0][17],
                    // "potongan_toko"=> $rowData[0][17],
                    "potongan_lain"=> $rowData[0][23],
                    "thp"=> $gaji_bulat2,
                    "pph21_bulan"=> $pajak_perbulan,
                    // "pph21_bulan"=> $rowData[0][25],
                    // "pph21_tahun"=> $rowData[0][17],
                    "upah"=> $rowData[0][26],
                    "fee_bulan"=> $fee_pt,
                    "pph23"=> $pph23,
                    "jml_tagihan"=> $tagihan,
                    "created_at"=> $created_at,
                    "created_by"=> $created_by
                    
                );

                // $data3 = array(
                //     "id_penagihan"=> $penagihan_id++,
                //     "id_karyawan"=> $id3++,
                //     "id_penempatan"=> $penempatan_id,
                //     "id_gaji_karyawan"=> $id_gaji2++,
                //     "nip"=> $rowData[0][0],
                //     "periode"=> $tgl_akhir,
                //     "upah"=> $rowData[0][26],
                //     "fee_bulan"=> $fee_pt,
                //     "pph23"=> $pph23,
                //     "jml_tagihan"=> $tagihan,
                //     "created_at"=> $created_at,
                //     "created_by"=> $created_by
                    
                // );  

                //cek nip
                $cek_nip_excel = $rowData[0][0];

                $cek_nip = $this->m_karyawan->cek_nip();
                foreach ($cek_nip as $ceknip2) {
                    $nonip[] = $ceknip2->nip;
                }
                $hasil_nip = implode(" ", $nonip);
                // $hasil_nip = $nonip;
                // echo $hasil_nip;
                
                // print_r($hasil_nip);die();
                // print_r($cek_nip_excel);die();
                 
                //sesuaikan nama dengan nama tabel
                if ($hasil_nip != $cek_nip_excel) {
                    $this->db->insert("karyawan",$data);
                } else {
                    redirect(CURRENT_CONTEXT);               
                }
                $sql = "delete from karyawan  
                         WHERE nip IN (SELECT dupid FROM (SELECT MAX(nip) AS dupid,COUNT(*) AS dupcnt
                         FROM karyawan 
                         GROUP BY nip HAVING COUNT(*) > 1) AS duptable) AND DAY(created_at) = DAY(NOW())
                    ";
                    $query = $this->db->query($sql);
                // $this->db->insert("karyawan",$data);
                $this->db->insert("gaji_karyawan",$data2);

                $sql = "delete from gaji_karyawan  
                         WHERE nip IN (SELECT dupid FROM (SELECT MAX(nip) AS dupid,COUNT(*) AS dupcnt
                         FROM gaji_karyawan 
                         GROUP BY nip HAVING COUNT(*) > 1) AS duptable) AND DAY(created_at) = DAY(NOW())
                    ";
                    $query = $this->db->query($sql);
                // delete_files($media['file_path']);

                $this->db->insert("penagihan",$data3);

                // $sql = "delete from penagihan  
                //          WHERE nip IN (SELECT dupid FROM (SELECT MAX(nip) AS dupid,COUNT(*) AS dupcnt
                //          FROM penagihan 
                //          GROUP BY nip HAVING COUNT(*) > 1) AS duptable) AND DAY(created_at) = DAY(NOW())
                //     ";
                //     $query = $this->db->query($sql);    
                     
            }
            // $foto = ('default.jpg');
            // $sql = "UPDATE karyawan set foto = '$foto' WHERE no_npwp == 0 ";
            // $query = $this->db->query($sql);
        redirect(CURRENT_CONTEXT);
    }

    public function importExcel(){

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

        //cek id karyawan
        $get_id_karyawan = $this->data['get_id_karyawan'] = $this->m_karyawan->get_id_karyawan();
        foreach ($get_id_karyawan as $id) {
            $id_max = $id->get_id_karyawan;
            $get_id = $id_max++;
        }

        $id = $get_id+1;
        $id2 = $get_id+1;
        $id3 = $get_id+1;

        $get_id_gaji_karyawan = $this->data['get_id_gaji_karyawan'] = $this->m_karyawan->get_id_gaji_karyawan();
        foreach ($get_id_gaji_karyawan as $id_gaji) {
            $id_max2 = $id_gaji->get_id_gaji_karyawan;
            $get_id_gaji = $id_max2++;
        }

        $id_gaji = $get_id_gaji+1;
        $id_gaji2 = $get_id_gaji+1;


        // include APPPATH.'third_party/PHPExcel/PHPExcel.php';
        $this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
        $fileName = $_FILES['file']['name'];
          
        $config['upload_path'] = './upload/excel/'; //path upload
        $config['file_name'] = $fileName;  // nama file
        $config['allowed_types'] = "*"; //tipe file yang diperbolehkan
        $config['max_size'] = 10000; // maksimal sizze
 
        $this->load->library('upload'); //meload librari upload
        $this->upload->initialize($config);
          
        if(! $this->upload->do_upload('file') ){
            echo $this->upload->display_errors();exit();
            $this->session->set_flashdata('msg','Ada kesalah dalam upload'); 
            redirect('gaji_karyawan');
        }
              
        // $inputFileName = './upload/'.$fileName;
        $media = $this->upload->data();
        $inputFileName = 'upload/excel/'.$media['file_name'];
 
        try {
                $inputFileType = IOFactory::identify($inputFileName);
                $objReader = IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch(Exception $e) {
                die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
            }
 
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
 
            for ($row = 2; $row <= $highestRow; $row++){                  //  Read a row of data into an array                 
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                                NULL,
                                                TRUE,
                                                FALSE);
 
                 // Sesuaikan key array dengan nama kolom di database                                                         
                 $var  = PHPExcel_Style_NumberFormat::toFormattedString($rowData[0][6],  'YYYY-MM-DD');
                $var1  = PHPExcel_Style_NumberFormat::toFormattedString($rowData[0][9],  'YYYY-MM-DD');
                $var2  = PHPExcel_Style_NumberFormat::toFormattedString($rowData[0][10],  'YYYY-MM-DD');
                $created_by = $this->session->userdata('username');
                $created_at = date('Y-m-d H:i:s');
                $nikpen = $rowData[0][2];
                $no_rek = $rowData[0][15];
                $cek_id = $rowData[0][11];
                $cek_kontrak = $rowData[0][19];
                

                if ($cek_id == "LEN INDUSTRI") {
                    $penempatan_id = 4;
                } elseif ($cek_id == "Len Railways System") {
                    $penempatan_id = 5;
                } elseif ($cek_id == "PT Len IOTI Fintech") {
                    $penempatan_id = 2;
                } elseif ($cek_id == "Len Rekaprima Semesta") {
                    $penempatan_id = 6;
                } elseif ($cek_id == "Len Telekomunikasi Indonesia") {
                    $penempatan_id = 7;
                } elseif ($cek_id == "Surya Energy Indonesia") {
                    $penempatan_id = 8;
                } elseif ($cek_id == "PT Eltran") {
                    $penempatan_id = 9;
                } elseif ($cek_id == "Koperasi Karyawan Len") {
                    $penempatan_id = 10;
                } else {
                    $penempatan_id = 3;
                }

                //cek status
                $cek_statuc_bpjs = $rowData[0][8];
                if ($cek_statuc_bpjs == "Aktif") {
                    $status = 1;
                } else {
                    $status = 0;
                }

                //hitung upah. pph23, tagihan
                $upah = $rowData[0][16];
                $upah_kotor = $rowData[0][26];
                $pph21 = $rowData[0][24];

                $cek_fee2 = $this->m_karyawan->cek_fee2();
                    foreach ($cek_fee2 as $cekfee2) {
                    $fee2[] = $cekfee2->nilai_fee2;
                    }
                    $hasil_fee2 = implode(" ", $fee2);
                $cek_fee3 = $this->m_karyawan->cek_fee3();
                    foreach ($cek_fee3 as $cekfee3) {
                    $fee3[] = $cekfee3->nilai_fee3;
                    }
                    $hasil_fee3 = implode(" ", $fee3);
                $cek_fee4 = $this->m_karyawan->cek_fee4();
                    foreach ($cek_fee4 as $cekfee4) {
                    $fee4[] = $cekfee4->nilai_fee4;
                    }
                    $hasil_fee4 = implode(" ", $fee4);
                $cek_fee5 = $this->m_karyawan->cek_fee5();
                    foreach ($cek_fee5 as $cekfee5) {
                    $fee5[] = $cekfee5->nilai_fee5;
                    }
                    $hasil_fee5 = implode(" ", $fee5);
                $cek_fee6 = $this->m_karyawan->cek_fee6();
                    foreach ($cek_fee6 as $cekfee6) {
                    $fee6[] = $cekfee6->nilai_fee6;
                    }
                    $hasil_fee6 = implode(" ", $fee6);
                $cek_fee7 = $this->m_karyawan->cek_fee7();
                    foreach ($cek_fee7 as $cekfee7) {
                    $fee7[] = $cekfee7->nilai_fee7;
                    }
                    $hasil_fee7 = implode(" ", $fee7);
                $cek_fee8 = $this->m_karyawan->cek_fee8();
                    foreach ($cek_fee8 as $cekfee8) {
                    $fee8[] = $cekfee8->nilai_fee8;
                    }
                    $hasil_fee8 = implode(" ", $fee8);
                $cek_fee9 = $this->m_karyawan->cek_fee9();
                    foreach ($cek_fee9 as $cekfee9) {
                    $fee9[] = $cekfee9->nilai_fee9;
                    }
                    $hasil_fee9 = implode(" ", $fee9);
                $cek_fee10 = $this->m_karyawan->cek_fee10();
                    foreach ($cek_fee10 as $cekfee10) {
                    $fee10[] = $cekfee10->nilai_fee10;
                    }
                    $hasil_fee10 = implode(" ", $fee10);

                if ($cek_id == "PT Len IOTI Fintech") {
                    $fee = $hasil_fee2;
                } elseif ($cek_id == "PT Puri Makmur Lestari") {
                    $fee = $hasil_fee3;
                } elseif ($cek_id == "LEN INDUSTRI") {
                    $fee = $hasil_fee4;
                } elseif ($cek_id == "Len Railways System") {
                    $fee = $hasil_fee5;
                } elseif ($cek_id == "Len Rekaprima Semesta") {
                    $fee = $hasil_fee6;
                } elseif ($cek_id == "Len Telekomunikasi Indonesia") {
                    $fee = $hasil_fee7;
                } elseif ($cek_id == "Surya Energy Indonesia") {
                    $fee = $hasil_fee8;
                } elseif ($cek_id == "PT Eltran") {
                    $fee = $hasil_fee9;
                } elseif ($cek_id == "Koperasi Karyawan Len") {
                    $fee = $hasil_fee10;
                } else {
                    $fee = $hasil_fee3;
                }

                // $hasil_fee = implode(" ", $fee);

                // print_r($fee);die();

                
                //pembulatan gaji
                $gaji_bulat = floor($rowData[0][16]);   //Gaji kotor
                $gaji_bulat2 = floor($rowData[0][26]);   //Gaji bersih

                //status pernikahan
                $pernikahan = "Belum Menikah";

                //hitung jumlah anak
                $jum_anak = "SELECT count(id_anak) FROM anak WHERE id_karyawan='$id' ";
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
                if ($pernikahan == ("Menikah")) {
                    $ptkp_nikah = 4500000;
                } else {
                    $ptkp_nikah = 0;
                }

                if ($pernikahan == ("Belum Menikah")) {
                    $ptkp = 54000000; 
                } elseif ($pernikahan == ("Belum Menikah") && $jum_anak == 1) {
                    $ptkp = 58500000;
                } elseif ($pernikahan == ("Belum Menikah") && $jum_anak == 2) {
                    $ptkp = 63000000;
                } elseif ($pernikahan == ("Belum Menikah") && $jum_anak == 3) {
                    $ptkp = 67500000;
                } elseif ($pernikahan == ("Menikah") && $jum_anak == 0) {
                    $ptkp = 58500000;
                } elseif ($pernikahan == ("Menikah") && $jum_anak == 1) {
                    $ptkp = 63000000;
                } elseif ($pernikahan == ("Menikah") && $jum_anak == 2) {
                    $ptkp = 67500000;
                } elseif ($pernikahan == ("Menikah") && $jum_anak == 3) {
                    $ptkp = 72000000;
                } else {
                    $ptkp = 0;
                }

                //hitung ptkp
                $biaya_jabatan = $gaji_bulat2 * 0.05;       //hitung biaya jabatan
                $biaya_jabatan2 = $gaji_bulat2 - $biaya_jabatan;        //hitung biaya jabatan
                $thp_tahun = $biaya_jabatan2 * 12;
                $pkp = abs($thp_tahun - $ptkp);
                $pkp1 = $thp_tahun - $ptkp;

                $sisa_ptkp_1 = $pkp1;
                $sisa_ptkp_2 = $sisa_ptkp_1 - 50000000;
                $sisa_ptkp_2a = abs($sisa_ptkp_1 - 50000000);
                $sisa_ptkp_3 = $sisa_ptkp_2 - 250000000;
                $sisa_ptkp_4 = $sisa_ptkp_2 - 500000000;

                //cek progresif
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


                $pajak_pertahun = $pajak + $pajak1 + $pajak2 + $pajak3;     //pph21 tahun
                $pajak_perbulan = $pajak_pertahun / 12;     //pph21 bukan

                //fee pt
                $fee_pt = $upah_kotor * $fee;
                $pph23 = $fee_pt * 0.02;
                $tagihan = $upah_kotor + $pajak_perbulan + $fee_pt + $pph23;
                // $tagihan = $upah_kotor + $pph21 + $fee_pt + $pph23;

                                                 
                //Sesuaikan sama nama kolom tabel di database                                
                 $data = array(
                    "id_karyawan"=> $id++,
                    "id_penempatan"=> $penempatan_id,
                    "nip"=> $rowData[0][0],
                    "kode_pagu"=> $rowData[0][1],
                    "nik"=> $nikpen,
                    "nama_karyawan"=> $rowData[0][3],
                    "tgl_lahir"=> $var,
                    "jenis_kelamin"=> $rowData[0][4],
                    "alamat"=> $rowData[0][5],
                    "no_telp"=> $rowData[0][14],
                    "no_rekening"=> $no_rek,
                    "status_pernikahan"=> $pernikahan,
                    "grade"=> $rowData[0][12],
                    "jurusan"=> $rowData[0][13],
                    "nama_kontrak"=> $rowData[0][28],
                    "no_kontrak"=> $rowData[0][29],
                    "tgl_masuk"=> $var1,
                    "tgl_berakhir"=> $var2,
                    "divisi"=> $rowData[0][7],
                    "jabatan"=> $rowData[0][30],
                    "gaji_pokok"=> $gaji_bulat,
                    "created_at"=> $created_at,
                    "created_by"=> $created_by
                    
                ); 

                $data2 = array(
                    "id_gaji_karyawan"=> $id_gaji++,
                    "id_karyawan"=> $id2++,
                    "nama_karyawan"=> $rowData[0][3],
                    "nip"=> $rowData[0][0],
                    "periode"=> $tgl_akhir,
                    "jml_hari"=> $jmlh_hari,
                    "tunj_bpjstk"=> $rowData[0][17],
                    "tunj_bpjskes"=> $rowData[0][18],
                    "bpjstk_stat_tun"=> $status,
                    "bpjskes_stat_tun"=> $status,
                    "tunj_lain"=> $rowData[0][19],
                    "potongan_bpjstk"=> $rowData[0][21],
                    "potongan_bpjskes"=> $rowData[0][22],
                    "potongan_lain"=> $rowData[0][23],
                    "thp"=> $gaji_bulat2,
                    "pph21_bulan"=> $pajak_perbulan,
                    "upah"=> $rowData[0][26],
                    "fee_bulan"=> $fee_pt,
                    "pph23"=> $pph23,
                    "jml_tagihan"=> $tagihan,
                    "created_at"=> $created_at,
                    "created_by"=> $created_by
                    
                );

                //cek nip
                $cek_nip_excel = $rowData[0][0];

                $cek_nip = $this->m_karyawan->cek_nip();
                foreach ($cek_nip as $ceknip2) {
                    $nonip[] = $ceknip2->nip;
                }
                $hasil_nip = implode(" ", $nonip);
                 
                //sesuaikan nama dengan nama tabel
                if ($hasil_nip != $cek_nip_excel) {
                    $this->db->insert("karyawan",$data);
                } else {
                    redirect(CURRENT_CONTEXT);               
                }
                $sql = "delete from karyawan  
                         WHERE nip IN (SELECT dupid FROM (SELECT MAX(nip) AS dupid,COUNT(*) AS dupcnt
                         FROM karyawan 
                         GROUP BY nip HAVING COUNT(*) > 1) AS duptable) AND DAY(created_at) = DAY(NOW())
                    ";
                    $query = $this->db->query($sql);
                // $this->db->insert("karyawan",$data);
                $this->db->insert("gaji_karyawan",$data2);

                $sql = "delete from gaji_karyawan  
                         WHERE nip IN (SELECT dupid FROM (SELECT MAX(nip) AS dupid,COUNT(*) AS dupcnt
                         FROM gaji_karyawan 
                         GROUP BY nip HAVING COUNT(*) > 1) AS duptable) AND DAY(created_at) = DAY(NOW())
                    ";
                    $query = $this->db->query($sql);
                // delete_files($media['file_path']);

                // $this->db->insert("penagihan",$data3);
                      
            }
            redirect(CURRENT_CONTEXT);
    }


    public function export_excel(){
        // $this->preload();
        // $bulan = $this->input->post('bln');
        // $tahun = $this->input->post('thn');
        
        $this->data['getListkontrak'] = $this->m_karyawan->getListkontrak();

        // $this->template_admin->display('penagihan/search_rekap_penagihan', $this->data);

        include_once './assets/phpexcel/Classes/PHPExcel.php';
        $objPHPExcel = new PHPExcel();

        $data = $this->m_karyawan->getListkontrak();
        $date = date('d-m-Y');
        $created_by = $this->session->userdata('username');
     
        $objPHPExcel = new PHPExcel(); 
        $objPHPExcel->setActiveSheetIndex(0); 
        $rowCount = 4;
        $i = 1; 

        $objPHPExcel->getActiveSheet()->mergeCells('A1:I1');
        $objPHPExcel->getActiveSheet()->mergeCells('A2:I2');
        

        $objPHPExcel->getActiveSheet()->SetCellValue('A1', "DAFTAR KARYAWAN KONTRAK");
        $objPHPExcel->getActiveSheet()->SetCellValue('A2', "PT. Puri Makmur Lestari");
        $objPHPExcel->getActiveSheet()->SetCellValue('A4', "NO");
        $objPHPExcel->getActiveSheet()->SetCellValue('B4', "NAMA");
        $objPHPExcel->getActiveSheet()->SetCellValue('C4', "NIP");
        $objPHPExcel->getActiveSheet()->SetCellValue('D4', "NIK");
        $objPHPExcel->getActiveSheet()->SetCellValue('E4', "PENEMPATAN");
        $objPHPExcel->getActiveSheet()->SetCellValue('F4', "NOMOR KONTRAK");
        $objPHPExcel->getActiveSheet()->SetCellValue('G4', "TANGGAL MASUK");
        $objPHPExcel->getActiveSheet()->SetCellValue('H4', "TANGGAL BERAKHIR");
        // $objPHPExcel->getActiveSheet()->SetCellValue('I4', "SISA HARI");
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
            // $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $row->selisih.' Hari');
            $rowCount++; 
        }
            $rowCount++;
            $rowCount++;
            $rowCount++;
            $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, "Bandung, $date");
            $rowCount++;
            $rowCount++;
            $rowCount++;
            $rowCount++;
            $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, "$created_by");
           

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
        $objWriter->save('./download/excel/Data Karyawan.xlsx'); 

        $this->load->helper('download');
        force_download('./download/excel/Data Karyawan.xlsx', NULL);

        redirect(CURRENT_CONTEXT);
        $this->template_admin->display('karyawan', $this->data);
    }

    function ambil_data(){

    $modul=$this->input->post('modul');
    $id=$this->input->post('id');

    if($modul=="kabupaten"){
    echo $this->m_karyawan->kabupaten($id);
    }
    else if($modul=="kecamatan"){

    }
    else if($modul=="kelurahan"){

    }
    }

    function get_divisi(){
        $id = $this->input->post('id');
        $data = $this->m_karyawan->get_divisi($id);
        echo json_encode($data);
    }

    function get_subkategori(){
        $id=$this->input->post('id');
        $data=$this->m_karyawan->get_subkategori($id);
        echo json_encode($data);
    }

    function logged_in() {
        if (!($this->session->userdata('logged_in'))) {
            redirect(base_url() . "auth");
        }
    }



}

?>