<?php
error_reporting(0);

class gaji_karyawan extends CI_Controller {

    public $data;
    public $filter;
    public $limit = 10;

    // setlocale(LC_ALL, 'id_ID.utf8');

    public function __construct() {
        parent::__construct();
        define('CURRENT_CONTEXT', base_url() . 'gaji_karyawan/');
        $this->data = array();
        init_generic_dao();
        $this->load->model(array('m_gaji_karyawan', 'm_karyawan', 'm_penempatan','m_penagihan','m_pinjaman','m_detail_pinjam'));
        $this->load->library(array('template_admin'));
        $this->logged_in();
        $this->data['page_title'] = "gaji_karyawan";
    }

    private function validate() {	
            // $this->form_validation->set_rules('id_karyawan', 'Id Karyawan', 'trim|required|max_length[11]|integer');		
			$this->form_validation->set_rules('nama_karyawan', 'nama karyawan', 'nip', 'trim|required');

        return $this->form_validation->run();
    }

    /**
      prepare data for view
     */
    public function preload() {
        $this->data['current_context'] = CURRENT_CONTEXT;
        $this->data['gaji_karyawan_list'] = $this->m_gaji_karyawan->fetch();
        $this->data['karyawan_list'] = $this->m_karyawan->fetch();
        $this->data['penempatan_list'] = $this->m_penempatan->fetch();
    }    

    public function index($page = 1) {
        $this->preload();
        $this->session->set_userdata(array(
            'filter_gaji_karyawan' => array(
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
        $potongan_absen = $this->input->post('absen');
        $status_pernikahan = $this->input->post('status_pernikahan');
        $id_karyawan = $this->input->post('id_karyawan');


        //cek id detail pinjam
        $get_id_detail_pinjam = $this->data['get_id_detail_pinjam'] = $this->m_gaji_karyawan->get_id_detail_pinjam();
        foreach ($get_id_detail_pinjam as $id_det) {
            $id_max = $id_det->get_id_detail_pinjam;
            $get_id = $id_max++;
        }

        $id_detail = $get_id+1;

        //cek id pinjaman
        $get_id_pinjaman = $this->data['get_id_pinjaman'] = $this->m_gaji_karyawan->get_id_pinjaman();
        foreach ($get_id_pinjaman as $pinjam) {
            $pinjam_id = $pinjam->id_pinjaman;
            $jumlah_pinjam = $pinjam->jumlah_pinjaman;
            $sisa_cek = $pinjam->sisa;
        }

        //cek cicilan ke
        $get_cicilan = $this->data['get_cicilan'] = $this->m_gaji_karyawan->get_cicilan();
        foreach ($get_cicilan as $cicil) {
            $cicilan = $cicil->get_cicilan;
        }


        // hitung pembayaran dan sisa
        $sisa = $sisa_cek - $plain;


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
            'absen' => $this->input->post('absen'),
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
            'upah' => $upah,
            'fee_bulan' => $fee_pt1,
            'rafel' => $this->input->post('rafel'),
            'thr' => $this->input->post('thr'),
            'pph23' => $pph23,
            'jml_tagihan' => $tagihan
        );
        // print_r($data);die();
        return $data;

        // $data2 = array(
        //     'id_pinjaman' => $pinjam_id,
        //     'id_karyawan' => $this->input->post('id_karyawan'),
        //     'tgl_bayar' => date('Y-m-d'),
        //     'cicilan_ke' => $cicilan,
        //     'bayar' => $this->input->post('potongan_lain')
        // );
        // // print_r($data);die();
        // return $data2;
    }

    private function fetch_input2() {

        $plain = $this->input->post('potongan_lain');
        $id_karyawan = $this->input->post('id_karyawan');
        $updated_by = $this->session->userdata('username');
        $updated_at = date('Y-m-d H:i:s');


        //cek id detail pinjam
        $get_id_detail_pinjam = $this->data['get_id_detail_pinjam'] = $this->m_gaji_karyawan->get_id_detail_pinjam();
        foreach ($get_id_detail_pinjam as $id_det) {
            $id_max = $id_det->get_id_detail_pinjam;
            $get_id = $id_max++;
        }

        $id_detail = $get_id+1;

        //cek id pinjaman
        $get_id_pinjaman = $this->data['get_id_pinjaman'] = $this->m_gaji_karyawan->get_id_pinjaman();
        foreach ($get_id_pinjaman as $pinjam) {
            $pinjam_id = $pinjam->id_pinjaman;
            $jumlah_pinjam = $pinjam->jumlah_pinjaman;
            $sisa_cek = $pinjam->sisa;
        }

        //cek cicilan ke
        $get_cicilan = $this->data['get_cicilan'] = $this->m_gaji_karyawan->get_cicilan();
        foreach ($get_cicilan as $cicil) {
            $cicilan = $cicil->get_cicilan;

            if ($cicilan == 0) {
            $cicilanke_ = '1';
            } else{
                $cicilanke_ = $cicilan++;
            }
        }
        $cicilanke = $cicilanke_+1;

        // hitung pembayaran dan sisa
        $sisa = $sisa_cek - $plain;

        $data = array(
            'id_pinjaman' => $pinjam_id,
            'id_karyawan' => $this->input->post('id_karyawan'),
            'tgl_bayar' => date('Y-m-d'),
            'cicilan_ke' => $cicilanke,
            'bayar' => $this->input->post('potongan_lain')
        );
        $sql = "UPDATE pinjaman set sisa = '$sisa', updated_at = '$updated_at', updated_by = '$updated_by' WHERE id_karyawan='$id_karyawan' AND id_pinjaman='$pinjam_id' ";
            $query = $this->db->query($sql);
        // print_r($data);die();
        return $data;
    }

    private function fetch_input3() {

        $plain = $this->input->post('potongan_lain');
        $id_karyawan = $this->input->post('id_karyawan');
        // $id_gaji_kar = array('id_gaji_karyawan' => $id_gaji_karyawan);
        $id_gaji_kar=$this->uri->segment(3);
        $updated_by = $this->session->userdata('username');
        $updated_at = date('Y-m-d H:i:s');

        //cek id detail pinjam
        $get_id_detail_pinjam = $this->data['get_id_detail_pinjam'] = $this->m_gaji_karyawan->get_id_detail_pinjam();
        foreach ($get_id_detail_pinjam as $id_det) {
            $id_max = $id_det->get_id_detail_pinjam;
            $get_id = $id_max++;
        }

        $id_detail = $get_id+1;

        //cek id pinjaman
        $get_id_pinjaman = $this->data['get_id_pinjaman'] = $this->m_gaji_karyawan->get_id_pinjaman();
        foreach ($get_id_pinjaman as $pinjam) {
            $pinjam_id = $pinjam->id_pinjaman;
            $jumlah_pinjam = $pinjam->jumlah_pinjaman;
            $sisa_cek = $pinjam->sisa;
        }

        //cek cicilan ke
        $get_cicilan = $this->data['get_cicilan'] = $this->m_gaji_karyawan->get_cicilan();
        foreach ($get_cicilan as $cicil) {
            $cicilan = $cicil->get_cicilan;

            if ($cicilan == 0) {
            $cicilanke_ = '1';
            } else{
                $cicilanke_ = $cicilan++;
            }
        }
        $cicilanke = $cicilanke_+1;

        //cek potongan
        $get_potongan = $this->data['get_potongan'] = $this->m_gaji_karyawan->get_potongan($id_gaji_kar);
        foreach ($get_potongan as $cek_potongan) {
            $potongan_lain_cek = $cek_potongan->potongan_lain;
        }
        $potongan_cek = $potongan_lain_cek;
        // print_r($potongan_lain_cek);die();

        // hitung pembayaran dan sisa
        $sisa = ($sisa_cek + $potongan_cek) - $plain;

        $data = array(
            'id_pinjaman' => $pinjam_id,
            'id_karyawan' => $this->input->post('id_karyawan'),
            'tgl_bayar' => date('Y-m-d'),
            'cicilan_ke' => $cicilanke,
            'bayar' => $this->input->post('potongan_lain')
        );

        if ($plain != $potongan_cek) {
            $sql = "UPDATE pinjaman set sisa = '$sisa', updated_at = '$updated_at', updated_by = '$updated_by' WHERE id_karyawan='$id_karyawan' AND id_pinjaman='$pinjam_id' ";
            $query = $this->db->query($sql);
        } else {
            $sql = "UPDATE pinjaman set updated_at = '$updated_at', updated_by = '$updated_by' WHERE id_karyawan='$id_karyawan' AND id_pinjaman='$pinjam_id' ";
            $query = $this->db->query($sql);
        }
        
        // print_r($data);die();
        return $data;
    }

    public function add() {
        $plain = $this->input->post('potongan_lain');
        $id_karyawan = $this->input->post('id_karyawan');

        $obj = $this->fetch_input();
        $obj['created_by'] = $this->session->userdata('username');
        $obj['created_at'] = date('Y-m-d H:i:s');

        $obj2 = $this->fetch_input2();
        $obj2['created_by'] = $this->session->userdata('username');
        $obj2['created_at'] = date('Y-m-d H:i:s');

        if ($this->validate() != false) {
            $this->m_gaji_karyawan->insert($obj);
            if ($plain != 0 ) {
                $this->m_detail_pinjam->insert($obj2);
            } else {
                redirect(CURRENT_CONTEXT);
            }
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
        $plain = $this->input->post('potongan_lain');
        $id_karyawan = $this->input->post('id_karyawan');

        $obj2 = $this->fetch_input3();
        $obj2['created_by'] = $this->session->userdata('username');
        $obj2['created_at'] = date('Y-m-d H:i:s');

        $obj = $this->fetch_input();
        $obj['updated_by'] = $this->session->userdata('username');
        $obj['updated_at'] = date('Y-m-d H:i:s');

        $obj_id = array('id_gaji_karyawan' => $id_gaji_karyawan);
        // $data_id = array('gaji_id' => $id_gaji2);

        if ($this->validate() != false) {
            $this->m_gaji_karyawan->update($obj, $obj_id);
            if ($plain != 0 || $plain != $potongan_cek) {
                $this->m_detail_pinjam->insert($obj2);
            } else {
                redirect(CURRENT_CONTEXT);
            }
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
                'periode' => $this->input->post('periode'),
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
        $penempatan = $this->input->post('id_penempatan');
        
        // $this->data['getGaji'] = $this->m_gaji_karyawan->getGaji($bulan, $tahun);
        // $this->data['getGajikaryawan'] = $this->m_gaji_karyawan->getGajikaryawan($bulan, $tahun, $penempatan);
        // $this->data['getTotal'] = $this->m_gaji_karyawan->getTotal($bulan, $tahun, $penempatan);
        // $jumlah = $this->m_gaji_karyawan->getTotal($bulan, $tahun, $penempatan);
        // $this->data['jumlah_total'] = $jumlah;
        // $this->data['getGajikaryawanAll'] = $this->m_gaji_karyawan->getGajikaryawanAll($bulan, $tahun);
        // $this->data['getTotalAll'] = $this->m_gaji_karyawan->getTotalAll($bulan, $tahun);

        if($penempatan != 0) {
            $this->data['getGajikaryawan'] = $this->m_gaji_karyawan->getGajikaryawan($bulan, $tahun, $penempatan);
            $this->data['getTotal'] = $this->m_gaji_karyawan->getTotal($bulan, $tahun, $penempatan);
            $jumlah = $this->m_gaji_karyawan->getTotal($bulan, $tahun, $penempatan);
            $this->data['jumlah_total'] = $jumlah;
            
            $this->template_admin->display('gaji_karyawan/search_rekap_gaji_karyawan', $this->data);
        } else {
            $this->data['getGajikaryawanAll'] = $this->m_gaji_karyawan->getGajikaryawanAll($bulan, $tahun);
            $this->data['getTotalAll'] = $this->m_gaji_karyawan->getTotalAll($bulan, $tahun);
            $jumlah = $this->m_gaji_karyawan->getTotalAll($bulan, $tahun);
            $this->data['jumlah_total'] = $jumlah;

            $this->template_admin->display('gaji_karyawan/search_rekap_gaji_karyawan_all', $this->data);
        }
    }

    public function slip_gaji($id_gaji_karyawan) {
        $obj_id = array('id_gaji_karyawan' => $id_gaji_karyawan);

        $this->preload();
        $this->fetch_record($obj_id);
        // $this->template_admin->display('gaji_karyawan/slip', $this->data);
        $this->load->view('gaji_karyawan/slip', $this->data);
    }


    public function cek(){
        if(isset($_POST['cari'])) {
        $this->search_rekap_gaji();
        } else if(isset($_POST['export'])) {
        $this->export_excel();
        }
    }

    public function export_excel(){
        $this->preload();
        $bulan = $this->input->post('bln');
        $tahun = $this->input->post('thn');
        $penempatan = $this->input->post('id_penempatan');
        
        $this->data['getGajikaryawan'] = $this->m_gaji_karyawan->getGajikaryawan($bulan, $tahun, $penempatan);
        $this->data['getTotal'] = $this->m_gaji_karyawan->getTotal($bulan, $tahun, $penempatan);
        $jumlah = $this->m_gaji_karyawan->getTotal($bulan, $tahun, $penempatan);
        $this->data['jumlah_total'] = $jumlah;

        $this->data['getGajikaryawanAll'] = $this->m_gaji_karyawan->getGajikaryawanAll($bulan, $tahun);
        $this->data['getTotalAll'] = $this->m_gaji_karyawan->getTotalAll($bulan, $tahun);

        if($penempatan != 0) {      //data gaji berdasarkan penempatan

            include_once './assets/phpexcel/Classes/PHPExcel.php';
            $objPHPExcel = new PHPExcel();

            $data = $this->m_gaji_karyawan->getGajikaryawan($bulan, $tahun, $penempatan);
            $total = $this->m_gaji_karyawan->getTotal($bulan, $tahun, $penempatan);
            $date = date('d-m-Y');
         
            $objPHPExcel = new PHPExcel(); 
            $objPHPExcel->setActiveSheetIndex(0); 
            $rowCount = 6;
            $i = 1; 

            $objPHPExcel->getActiveSheet()->mergeCells('A1:P1');
            $objPHPExcel->getActiveSheet()->mergeCells('A2:P2');
            $objPHPExcel->getActiveSheet()->mergeCells('A3:P3');
            $objPHPExcel->getActiveSheet()->mergeCells('A5:A6');
            $objPHPExcel->getActiveSheet()->mergeCells('B5:B6');
            $objPHPExcel->getActiveSheet()->mergeCells('C5:C6');
            $objPHPExcel->getActiveSheet()->mergeCells('D5:D6');
            $objPHPExcel->getActiveSheet()->mergeCells('E5:E6');
            $objPHPExcel->getActiveSheet()->mergeCells('F5:H5');
            $objPHPExcel->getActiveSheet()->mergeCells('I5:I6');
            $objPHPExcel->getActiveSheet()->mergeCells('J5:M5');
            $objPHPExcel->getActiveSheet()->mergeCells('N5:N6');
            $objPHPExcel->getActiveSheet()->mergeCells('O5:O6');
            $objPHPExcel->getActiveSheet()->mergeCells('P5:P6');
            

            // $objPHPExcel->getActiveSheet()->SetCellValue('A1', "DAFTAR KWT TAMBAHAN JASA BORONGAN");
            // $objPHPExcel->getActiveSheet()->SetCellValue('A2', "PT. Puri Makmur Lestari (PT. LEN REKAPRIMA SEMESTA) ");
            // $objPHPExcel->getActiveSheet()->SetCellValue('A3', "BULAN $bulan $periode->tahun1");

            $objPHPExcel->getActiveSheet()->SetCellValue('A5', "NO");
            $objPHPExcel->getActiveSheet()->SetCellValue('B5', "NAMA");
            $objPHPExcel->getActiveSheet()->SetCellValue('C5', "NIP");
            $objPHPExcel->getActiveSheet()->SetCellValue('D5', "NIK");
            $objPHPExcel->getActiveSheet()->SetCellValue('E5', "GAJI");
            $objPHPExcel->getActiveSheet()->SetCellValue('F5', "TUNJANGAN");
            $objPHPExcel->getActiveSheet()->SetCellValue('F6', "BPJS-TK");
            $objPHPExcel->getActiveSheet()->SetCellValue('G6', "BPJS-KES");
            $objPHPExcel->getActiveSheet()->SetCellValue('H6', "LAIN-LAIN");
            $objPHPExcel->getActiveSheet()->SetCellValue('I5', "JUMLAH");
            $objPHPExcel->getActiveSheet()->SetCellValue('J5', "POTONGAN");
            $objPHPExcel->getActiveSheet()->SetCellValue('J6', "BPJS-TK");
            $objPHPExcel->getActiveSheet()->SetCellValue('K6', "BPJS-KES");
            $objPHPExcel->getActiveSheet()->SetCellValue('L6', "LAIN-LAIN");
            $objPHPExcel->getActiveSheet()->SetCellValue('M6', "PPH P 21");
            $objPHPExcel->getActiveSheet()->SetCellValue('N5', "JUMLAH POTONGAN");
            $objPHPExcel->getActiveSheet()->SetCellValue('O5', "JUMLAH");
            $objPHPExcel->getActiveSheet()->SetCellValue('P5', "REKENING");
            $rowCount++;

            foreach($total as $raw){
                // $total_ = $raw->jumlah_tunjangan - $raw->potongan;

            foreach($data as $row){

                    if ($row->bulan_gaji == "1") {
                        $bulan = "JANUARI";
                    } elseif ($row->bulan_gaji == "2") {
                        $bulan = "FEBRUARI";
                    } elseif ($row->bulan_gaji == "3") {
                        $bulan = "MARET";
                    } elseif ($row->bulan_gaji == "4") {
                        $bulan = "APRIL";
                    } elseif ($row->bulan_gaji == "5") {
                        $bulan = "MEI";
                    } elseif ($row->bulan_gaji == "6") {
                        $bulan = "JUNI";
                    } elseif ($row->bulan_gaji == "7") {
                        $bulan = "JULI";
                    } elseif ($row->bulan_gaji == "8") {
                        $bulan = "AGUSTUS";
                    } elseif ($row->bulan_gaji == "9") {
                        $bulan = "SEPTEMBER";
                    } elseif ($row->bulan_gaji == "10") {
                        $bulan = "OTKOBER";
                    } elseif ($row->bulan_gaji == "11") {
                        $bulan = "NOPEMBER";
                    } else {
                        $bulan = "DESEMBER";
                    }

                $objPHPExcel->getActiveSheet()->SetCellValue('A1', "DAFTAR GAJI KWT");
                $objPHPExcel->getActiveSheet()->SetCellValue('A2', "PT. Puri Makmur Lestari ");
                $objPHPExcel->getActiveSheet()->SetCellValue('A3', "BULAN $bulan $row->tahun_gaji");
                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i++); 
                $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->nama_karyawan);
                $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, ' '.$row->nip);
                $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, ' '.$row->nik); 
                $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, number_format($row->gaji_pokok));
                $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, number_format($row->tunj_bpjstk));
                $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, number_format($row->tunj_bpjskes)); 
                $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, number_format($row->jml_lain)); 
                $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, number_format($row->jumlah_tunjangan)); 
                $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, number_format($row->potongan_bpjstk));
                $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, number_format($row->potongan_bpjskes));
                $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, number_format($row->jml_potongan_lain));
                $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, number_format($row->pph21_bulan));
                $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, number_format($row->potongan));
                $objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, number_format($row->cek_thp));
                $objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, ' '.$row->no_rekening);
                $rowCount++;
                // $rowCount++; 
            }
                $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, "Jumlah Total");
                $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, number_format($raw->total_gapok));
                $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, number_format($raw->total_bpjstk));
                $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, number_format($raw->total_bpjskes)); 
                $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, number_format($raw->total_lain)); 
                $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, number_format($raw->total_jumlah_tunjangan)); 
                $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, number_format($raw->total_pot_bpjstk));
                $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, number_format($raw->total_pot_bpjskes));
                $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, number_format($raw->jml_total_potongan_lain));
                $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, number_format($raw->total_pph21));
                $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, number_format($raw->total_potongan));
                $objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, number_format($raw->jumlah_jumlah));
                $rowCount++;
                $rowCount++;
                $rowCount++;

                $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, "Bandung, $date");
                $rowCount++;
                $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, "Dir. Utama");
                $rowCount++;
                $rowCount++;
                $rowCount++;
                $rowCount++;
                $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, "Mulyono Supardi");

            }

            //Mengatur lebar cell pada document excel
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(6);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(24);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(17);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(24);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(12);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(12);
            $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(12);
            $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(12);
            $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(12);
            $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(12);
            $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(20);

            //Mengatur tinggi cell pada document excel
            $objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(2);
            // $objPHPExcel->getActiveSheet()->getRowDimension('5')->setRowHeight(26);

            //Mengatur align cell pada document excel
            $center = array();
            $center ['alignment']=array();
            $center ['alignment']['horizontal']=PHPExcel_Style_Alignment::HORIZONTAL_CENTER;
            $objPHPExcel->getActiveSheet()->getStyle ( 'A1:P1' )->applyFromArray ($center);
            $objPHPExcel->getActiveSheet()->getStyle ( 'A2:P2' )->applyFromArray ($center);
            $objPHPExcel->getActiveSheet()->getStyle ( 'A3:P3' )->applyFromArray ($center);
            $objPHPExcel->getActiveSheet()->getStyle ( 'A5:P5' )->applyFromArray ($center);
            $objPHPExcel->getActiveSheet()->getStyle ( 'A5:A1000' )->applyFromArray ($center);
            $objPHPExcel->getActiveSheet()->getStyle ( 'F6:H6' )->applyFromArray ($center);
            $objPHPExcel->getActiveSheet()->getStyle ( 'J6:M6' )->applyFromArray ($center);
            $objPHPExcel->getActiveSheet()->getStyle ( 'P5' )->applyFromArray ($center);

            $right=array();
            $right ['alignment']=array();
            $right ['alignment']['horizontal']=PHPExcel_Style_Alignment::HORIZONTAL_RIGHT;
            $objPHPExcel->getActiveSheet()->getStyle ( 'C6:O1000' )->applyFromArray ($right);

            // $left=array();
            // $left ['alignment']=array();
            // $left ['alignment']['horizontal']=PHPExcel_Style_Alignment::HORIZONTAL_LEFT;
            // $objPHPExcel->getActiveSheet()->getStyle ( 'C6:M1000' )->applyFromArray ($left);

            //Mengatur font pada document excel
            $objPHPExcel->getActiveSheet()->getStyle('A1:P3')->getFont()->setName('Calibri');
            $objPHPExcel->getActiveSheet()->getStyle('A1:P3')->getFont()->setSize(9);
            $objPHPExcel->getActiveSheet()->getStyle('A1:P3')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('F6:M6')->getFont()->setBold(true);

            $objPHPExcel->getActiveSheet()->getStyle('A5:O1000')->getFont()->setSize(8);
            $objPHPExcel->getActiveSheet()->getStyle('A5:O5')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('A5:O5')->getAlignment()->setWrapText(true);

            $objPHPExcel->getActiveSheet()->getStyle('P5')->getFont()->setSize(8);
            $objPHPExcel->getActiveSheet()->getStyle('P5')->getFont()->setBold(true);

            $objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setName('Calibri')->setSize(8);

            // $objPHPExcel->getActiveSheet()->getStyle('N7:N1000')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);

            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
            $objWriter->save('./download/excel/Data Gaji.xlsx'); 

            $this->load->helper('download');
            force_download('./download/excel/Data Gaji.xlsx', NULL);

            redirect('gaji_karyawan/search_rekap_gaji');
            $this->template_admin->display('gaji_karyawan/search_rekap_gaji_karyawan', $this->data);

        } else {        //semua data gaji

            include_once './assets/phpexcel/Classes/PHPExcel.php';
            $objPHPExcel = new PHPExcel();

            $data = $this->m_gaji_karyawan->getGajikaryawanAll($bulan, $tahun);
            $total = $this->m_gaji_karyawan->getTotalAll($bulan, $tahun);
            $date = date('d-m-Y');
         
            $objPHPExcel = new PHPExcel(); 
            $objPHPExcel->setActiveSheetIndex(0); 
            $rowCount = 6;
            $i = 1; 

            $objPHPExcel->getActiveSheet()->mergeCells('A1:P1');
            $objPHPExcel->getActiveSheet()->mergeCells('A2:P2');
            $objPHPExcel->getActiveSheet()->mergeCells('A3:P3');
            $objPHPExcel->getActiveSheet()->mergeCells('A5:A6');
            $objPHPExcel->getActiveSheet()->mergeCells('B5:B6');
            $objPHPExcel->getActiveSheet()->mergeCells('C5:C6');
            $objPHPExcel->getActiveSheet()->mergeCells('D5:D6');
            $objPHPExcel->getActiveSheet()->mergeCells('E5:E6');
            $objPHPExcel->getActiveSheet()->mergeCells('F5:H5');
            $objPHPExcel->getActiveSheet()->mergeCells('I5:I6');
            $objPHPExcel->getActiveSheet()->mergeCells('J5:M5');
            $objPHPExcel->getActiveSheet()->mergeCells('N5:N6');
            $objPHPExcel->getActiveSheet()->mergeCells('O5:O6');
            $objPHPExcel->getActiveSheet()->mergeCells('P5:P6');
            

            // $objPHPExcel->getActiveSheet()->SetCellValue('A1', "DAFTAR KWT TAMBAHAN JASA BORONGAN");
            // $objPHPExcel->getActiveSheet()->SetCellValue('A2', "PT. Puri Makmur Lestari (PT. LEN REKAPRIMA SEMESTA) ");
            // $objPHPExcel->getActiveSheet()->SetCellValue('A3', "BULAN $bulan $periode->tahun1");

            $objPHPExcel->getActiveSheet()->SetCellValue('A5', "NO");
            $objPHPExcel->getActiveSheet()->SetCellValue('B5', "NAMA");
            $objPHPExcel->getActiveSheet()->SetCellValue('C5', "NIP");
            $objPHPExcel->getActiveSheet()->SetCellValue('D5', "NIK");
            $objPHPExcel->getActiveSheet()->SetCellValue('E5', "GAJI");
            $objPHPExcel->getActiveSheet()->SetCellValue('F5', "TUNJANGAN");
            $objPHPExcel->getActiveSheet()->SetCellValue('F6', "BPJS-TK");
            $objPHPExcel->getActiveSheet()->SetCellValue('G6', "BPJS-KES");
            $objPHPExcel->getActiveSheet()->SetCellValue('H6', "LAIN-LAIN");
            $objPHPExcel->getActiveSheet()->SetCellValue('I5', "JUMLAH");
            $objPHPExcel->getActiveSheet()->SetCellValue('J5', "POTONGAN");
            $objPHPExcel->getActiveSheet()->SetCellValue('J6', "BPJS-TK");
            $objPHPExcel->getActiveSheet()->SetCellValue('K6', "BPJS-KES");
            $objPHPExcel->getActiveSheet()->SetCellValue('L6', "LAIN-LAIN");
            $objPHPExcel->getActiveSheet()->SetCellValue('M6', "PPH P 21");
            $objPHPExcel->getActiveSheet()->SetCellValue('N5', "JUMLAH POTONGAN");
            $objPHPExcel->getActiveSheet()->SetCellValue('O5', "JUMLAH");
            $objPHPExcel->getActiveSheet()->SetCellValue('P5', "REKENING");
            $rowCount++;

            foreach($total as $raw){
                // $total_ = $raw->jumlah_tunjangan - $raw->potongan;

            foreach($data as $row){

                    if ($row->bulan_gaji == "1") {
                        $bulan = "JANUARI";
                    } elseif ($row->bulan_gaji == "2") {
                        $bulan = "FEBRUARI";
                    } elseif ($row->bulan_gaji == "3") {
                        $bulan = "MARET";
                    } elseif ($row->bulan_gaji == "4") {
                        $bulan = "APRIL";
                    } elseif ($row->bulan_gaji == "5") {
                        $bulan = "MEI";
                    } elseif ($row->bulan_gaji == "6") {
                        $bulan = "JUNI";
                    } elseif ($row->bulan_gaji == "7") {
                        $bulan = "JULI";
                    } elseif ($row->bulan_gaji == "8") {
                        $bulan = "AGUSTUS";
                    } elseif ($row->bulan_gaji == "9") {
                        $bulan = "SEPTEMBER";
                    } elseif ($row->bulan_gaji == "10") {
                        $bulan = "OTKOBER";
                    } elseif ($row->bulan_gaji == "11") {
                        $bulan = "NOPEMBER";
                    } else {
                        $bulan = "DESEMBER";
                    }

                $objPHPExcel->getActiveSheet()->SetCellValue('A1', "DAFTAR GAJI KWT");
                $objPHPExcel->getActiveSheet()->SetCellValue('A2', "PT. Puri Makmur Lestari ");
                $objPHPExcel->getActiveSheet()->SetCellValue('A3', "BULAN $bulan $row->tahun_gaji");
                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i++); 
                $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->nama_karyawan);
                $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, ' '.$row->nip);
                $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, ' '.$row->nik); 
                $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, number_format($row->gaji_pokok));
                $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, number_format($row->tunj_bpjstk));
                $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, number_format($row->tunj_bpjskes)); 
                $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, number_format($row->jml_lain)); 
                $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, number_format($row->jumlah_tunjangan)); 
                $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, number_format($row->potongan_bpjstk));
                $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, number_format($row->potongan_bpjskes));
                $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, number_format($row->jml_potongan_lain));
                $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, number_format($row->pph21_bulan));
                $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, number_format($row->potongan));
                $objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, number_format($row->cek_thp));
                $objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, ' '.$row->no_rekening);
                $rowCount++;
                // $rowCount++; 
            }
                $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, "Jumlah Total");
                $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, number_format($raw->total_gapok));
                $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, number_format($raw->total_bpjstk));
                $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, number_format($raw->total_bpjskes)); 
                $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, number_format($raw->total_lain)); 
                $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, number_format($raw->total_jumlah_tunjangan)); 
                $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, number_format($raw->total_pot_bpjstk));
                $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, number_format($raw->total_pot_bpjskes));
                $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, number_format($raw->jml_total_potongan_lain));
                $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, number_format($raw->total_pph21));
                $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, number_format($raw->total_potongan));
                $objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, number_format($raw->jumlah_jumlah));
                $rowCount++;
                $rowCount++;
                $rowCount++;

                $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, "Bandung, $date");
                $rowCount++;
                $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, "Dir. Utama");
                $rowCount++;
                $rowCount++;
                $rowCount++;
                $rowCount++;
                $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, "Mulyono Supardi");

            }

            //Mengatur lebar cell pada document excel
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(6);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(24);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(17);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(24);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(12);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(12);
            $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(12);
            $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(12);
            $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(12);
            $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(12);
            $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(20);

            //Mengatur tinggi cell pada document excel
            $objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(2);
            // $objPHPExcel->getActiveSheet()->getRowDimension('5')->setRowHeight(26);

            //Mengatur align cell pada document excel
            $center = array();
            $center ['alignment']=array();
            $center ['alignment']['horizontal']=PHPExcel_Style_Alignment::HORIZONTAL_CENTER;
            $objPHPExcel->getActiveSheet()->getStyle ( 'A1:P1' )->applyFromArray ($center);
            $objPHPExcel->getActiveSheet()->getStyle ( 'A2:P2' )->applyFromArray ($center);
            $objPHPExcel->getActiveSheet()->getStyle ( 'A3:P3' )->applyFromArray ($center);
            $objPHPExcel->getActiveSheet()->getStyle ( 'A5:P5' )->applyFromArray ($center);
            $objPHPExcel->getActiveSheet()->getStyle ( 'A5:A1000' )->applyFromArray ($center);
            $objPHPExcel->getActiveSheet()->getStyle ( 'F6:H6' )->applyFromArray ($center);
            $objPHPExcel->getActiveSheet()->getStyle ( 'J6:M6' )->applyFromArray ($center);
            $objPHPExcel->getActiveSheet()->getStyle ( 'P5' )->applyFromArray ($center);

            $right=array();
            $right ['alignment']=array();
            $right ['alignment']['horizontal']=PHPExcel_Style_Alignment::HORIZONTAL_RIGHT;
            $objPHPExcel->getActiveSheet()->getStyle ( 'C6:O1000' )->applyFromArray ($right);

            // $left=array();
            // $left ['alignment']=array();
            // $left ['alignment']['horizontal']=PHPExcel_Style_Alignment::HORIZONTAL_LEFT;
            // $objPHPExcel->getActiveSheet()->getStyle ( 'C6:M1000' )->applyFromArray ($left);

            //Mengatur font pada document excel
            $objPHPExcel->getActiveSheet()->getStyle('A1:P3')->getFont()->setName('Calibri');
            $objPHPExcel->getActiveSheet()->getStyle('A1:P3')->getFont()->setSize(9);
            $objPHPExcel->getActiveSheet()->getStyle('A1:P3')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('F6:M6')->getFont()->setBold(true);

            $objPHPExcel->getActiveSheet()->getStyle('A5:O1000')->getFont()->setSize(8);
            $objPHPExcel->getActiveSheet()->getStyle('A5:O5')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('A5:O5')->getAlignment()->setWrapText(true);

            $objPHPExcel->getActiveSheet()->getStyle('P5')->getFont()->setSize(8);
            $objPHPExcel->getActiveSheet()->getStyle('P5')->getFont()->setBold(true);

            $objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setName('Calibri')->setSize(8);

            // $objPHPExcel->getActiveSheet()->getStyle('N7:N1000')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);

            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
            $objWriter->save('./download/excel/Data Gaji.xlsx'); 

            $this->load->helper('download');
            force_download('./download/excel/Data Gaji.xlsx', NULL);

            redirect('gaji_karyawan/search_rekap_gaji');
            $this->template_admin->display('gaji_karyawan/search_rekap_gaji_karyawan', $this->data);

        }
    }


    public function search_rekap_gaji_print(){
        $this->preload();
        $this->search_rekap_gaji();
        $this->data['getGajikaryawan'] = $this->m_gaji_karyawan->getGajikaryawan($bulan, $tahun);
        $this->data['getTotal'] = $this->m_gaji_karyawan->getTotal($bulan, $tahun);

        $this->template_admin->display('gaji_karyawan/rekap_gaji', $this->data);
    }

    public function rekap_pajak(){
        $this->preload();
        $this->template_admin->display('gaji_karyawan/rekap_pajak_karyawan', $this->data);
    }

    public function search_rekap_pajak(){
        $this->preload();
        $bulan = $this->input->post('bln');
        $tahun = $this->input->post('thn');
        
        // $this->data['getGaji'] = $this->m_gaji_karyawan->getGaji($bulan, $tahun);
        $this->data['getPajakkaryawan'] = $this->m_gaji_karyawan->getPajakkaryawan($bulan, $tahun);
        $this->data['getTotalpajak'] = $this->m_gaji_karyawan->getTotalpajak($bulan, $tahun);
        $jumlah = $this->m_gaji_karyawan->getTotalpajak($bulan, $tahun);
        $this->data['jumlah_total'] = $jumlah;

        $this->template_admin->display('gaji_karyawan/search_rekap_pajak_karyawan', $this->data);
    }

    public function rekap_gaji_pekerja(){
        $this->preload();
        $this->template_admin->display('gaji_karyawan/rekap_gaji_pekerja', $this->data);
    }

    public function search_rekap_gaji_pekerja(){
        $this->preload();
        $bulan = $this->input->post('bln');
        $tahun = $this->input->post('thn');
        $penempatan = $this->input->post('id_penempatan');
        
        // $this->data['getGaji'] = $this->m_gaji_karyawan->getGaji($bulan, $tahun);
        $this->data['getGajipekerja'] = $this->m_gaji_karyawan->getGajipekerja($bulan, $tahun, $penempatan);
        $this->data['getTotalpekerja'] = $this->m_gaji_karyawan->getTotalpekerja($bulan, $tahun, $penempatan);
        $jumlah = $this->m_gaji_karyawan->getTotalpekerja($bulan, $tahun, $penempatan);
        $this->data['jumlah_total'] = $jumlah;

        $this->template_admin->display('gaji_karyawan/search_rekap_gaji_pekerja', $this->data);
    }

    public function input_gaji(){
        $this->preload();
        
        $created_by = $this->session->userdata('username');
        $created_at = date('Y-m-d H:i:s');
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

        // $get_id_otomatis = $this->data['get_id_otomatis'] = $this->m_gaji_karyawan->get_id_otomatis();
        // foreach ($get_id_otomatis as $id) {
        //     $id_max = $id->get_gaji_id;
        //     $get_id = $id_max++;
        // }

        // $id_gaji = $get_id+1;
        // $id_gaji2 = $get_id+1;

        //cek id pinjaman
        $get_id_pinjaman = $this->data['get_id_pinjaman'] = $this->m_gaji_karyawan->get_id_pinjaman();
        foreach ($get_id_pinjaman as $pinjam) {
            $pinjam_id = $pinjam->id_pinjaman;
            $jumlah_pinjam = $pinjam->jumlah_pinjaman;
            $sisa_cek = $pinjam->sisa;
        }

        //cek cicilan ke
        // $get_cicilan = $this->data['get_cicilan'] = $this->m_gaji_karyawan->get_cicilan();
        // foreach ($get_cicilan as $cicil) {
        //     $cicilan = $cicil->get_cicilan;

        //     if ($cicilan == 0) {
        //     $cicilanke_ = '1';
        //     } else{
        //         $cicilanke_ = $cicilan++;
        //     }
        // }
        // $cicilanke = $cicilanke_+1;

        // hitung pembayaran dan sisa
        // $sisa = $sisa_cek - $plain;

        // $data4 = array(
        //     'id_pinjaman' => $pinjam_id,
        //     'id_karyawan' => $this->input->post('id_karyawan'),
        //     'tgl_bayar' => date('Y-m-d'),
        //     'cicilan_ke' => $cicilanke,
        //     'bayar' => $this->input->post('potongan_lain')
        // );
        // $sql = "UPDATE pinjaman set sisa = '$sisa' WHERE id_karyawan='$id_karyawan' AND id_pinjaman='$pinjam_id' ";
        //     $query = $this->db->query($sql);
        // print_r($data);die();
        // return $data4;

        $get_karyawan = $this->data['getKaryawan'] = $this->m_gaji_karyawan->getKaryawan();
        foreach ($get_karyawan as $get) {

            $data3 = array(
                    'id_karyawan' => $get->id_karyawan,
                    'nama_karyawan' => $get->nama_karyawan,
                    'nip' => $get->nip,
                    'periode' => $tgl_akhir,
                    'jml_hari' => $jmlh_hari,
                    'tunj_jabatan' => $get->tunj_jabatan,
                    'tunj_bpjstk' => $get->tunj_bpjstk,
                    'tunj_bpjskes' => $get->tunj_bpjskes,
                    'tunj_dapen' => $get->tunj_dapen,
                    'bpjstk_stat_tun' => $get->bpjstk_stat_tun,
                    'bpjskes_stat_tun' => $get->bpjskes_stat_tun,
                    'dapen_stat_tun' => $get->dapen_stat_tun,
                    'tunj_makan' => $get->tunj_makan,
                    'tunj_lain' => $get->tunj_lain,
                    'absen' => $get->absen,
                    'potongan_absensi' => $get->potongan_absensi,
                    'jatah_cuti_bersama' => $get->jatah_cuti_bersama,
                    'jatah_cuti_mandiri' => $get->jatah_cuti_mandiri,
                    'potongan_bpjstk' => $get->potongan_bpjstk,
                    'potongan_bpjskes' => $get->potongan_bpjskes,
                    'potongan_dapen' => $get->potongan_dapen,
                    'potongan_simpanan_wajib' => $get->potongan_simpanan_wajib,
                    'potongan_sekunder' => $get->potongan_sekunder,
                    'potongan_darurat' => $get->potongan_darurat,
                    'potongan_toko' => $get->potongan_toko,
                    'potongan_lain' => $get->potongan_lain,
                    'thp' => $get->thp,
                    'pph21_bulan' => $get->pph21_bulan,
                    'pph21_tahun' => $get->pph21_tahun,
                    'upah' => $get->upah,
                    'fee_bulan' => $get->fee_bulan,
                    'rafel' => $get->rafel,
                    'thr' => $get->thr,
                    'pph23' => $get->pph23,
                    'jml_tagihan' => $get->jml_tagihan,
                    "created_at"=> $created_at,
                    "created_by"=> $created_by
                );
            $this->db->insert("gaji_karyawan",$data3);

        };

        redirect(CURRENT_CONTEXT);
               
        // print_r($get);die();

    }

    function logged_in() {
        if (!($this->session->userdata('logged_in'))) {
            redirect(base_url() . "auth");
        }
    }

}

?>