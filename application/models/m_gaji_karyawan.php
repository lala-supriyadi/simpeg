<?php
class m_gaji_karyawan extends Generic_dao {

    public function table_name() {
        return Tables::$gaji_karyawan;
    }

    public function field_map() {
        return array(
            'id_gaji_karyawan' => 'id_gaji_karyawan',
            'id_karyawan' => 'id_karyawan',
            'nama_karyawan' => 'nama_karyawan',
            'nip' => 'nip',
            'periode' => 'periode',
            'jml_hari' => 'jml_hari',
            'tunj_jabatan' => 'tunj_jabatan',
            'tunj_bpjstk' => 'tunj_bpjstk',
            'tunj_bpjskes' => 'tunj_bpjskes',
            'tunj_dapen' => 'tunj_dapen',
            'bpjstk_stat_tun' => 'bpjstk_stat_tun',
            'bpjskes_stat_tun' => 'bpjskes_stat_tun',
            'dapen_stat_tun' => 'dapen_stat_tun',
            'tunj_makan' => 'tunj_makan',
            'tunj_lain' => 'tunj_lain',
            'absen' => 'absen',
            'potongan_absensi' => 'potongan_absensi',
            'jatah_cuti_mandiri' => 'jatah_cuti_mandiri',
            'jatah_cuti_bersama' => 'jatah_cuti_bersama',
            'potongan_bpjstk' => 'potongan_bpjstk',
            'potongan_bpjskes' => 'potongan_bpjskes',
            'potongan_dapen' => 'potongan_dapen',
            'potongan_simpanan_wajib' => 'potongan_simpanan_wajib',
            'potongan_sekunder' => 'potongan_sekunder',
            'potongan_darurat' => 'potongan_darurat',
            'potongan_toko' => 'potongan_toko',
            'potongan_lain' => 'potongan_lain',
            'thp' => 'thp',
            'pph21_bulan' => 'pph21_bulan',
            'pph21_tahun' => 'pph21_tahun',
            'upah' => 'upah',
            'fee_bulan' => 'fee_bulan',
            'rafel' => 'rafel',
            'thr' => 'thr',
            'pph23' => 'pph23',
            'jml_tagihan' => 'jml_tagihan',
            'created_by' => 'created_by',
            'created_at' => 'created_at',
            'updated_by' => 'updated_by',
            'updated_at' => 'updated_at',
            'is_deleted' => 'is_deleted'
        );
    }

    public function __construct() {
        parent::__construct();
    }

    public function joined_table() {
        return array(
            array(
                'table_name' => Tables::$karyawan,
                'condition' => Tables::$karyawan . '.id_karyawan = ' . $this->table_name() . '.id_karyawan',
                'field' => 'karyawan.id_karyawan, karyawan.nama_karyawan, karyawan.nip, gaji_pokok'
            )
        );
    }

    // public function get_id_otomatis() {
    //     $sql = "SELECT MAX(gaji_id) as get_gaji_id
    //             FROM 
    //                 gaji_karyawan  
    //             ";
    //     $query = $this->ci->db->query($sql);
    //     return $query->result();
    // }

    public function getGaji($bulan,$tahun) {

        $sql = "SELECT A.id_gaji_karyawan, A.id_karyawan, MONTH(A.periode) AS bulan_gaji, YEAR(A.periode) AS tahun_gaji, A.jml_hari, A.tunj_jabatan, A.tunj_bpjstk, A.tunj_bpjskes, A.tunj_dapen, A.tunj_makan, A.tunj_lain, A.potongan_absensi, A.potongan_bpjstk, A.potongan_bpjskes, A.potongan_dapen, A.potongan_simpanan_wajib, A.potongan_sekunder, A.potongan_darurat, A.potongan_toko, A.potongan_lain, A.thp FROM gaji_karyawan AS A LEFT JOIN karyawan AS B ON B.nip = A.nip WHERE MONTH (A.periode) = '$bulan' AND YEAR (A.periode) = '$tahun' ORDER BY A.nip ASC";
        $query = $this->ci->db->query($sql);
        return $query;
    }

    public function getGajikaryawan($bulan,$tahun,$penempatan) {
        $sql = "SELECT
                    *,  MONTH(A.periode) as bulan_gaji, YEAR(A.periode) as tahun_gaji, a.pph21_bulan, a.pph21_tahun, a.potongan_bpjstk + a.potongan_bpjskes + a.potongan_lain + a.pph21_bulan + a.potongan_dapen + a.potongan_sekunder + a.potongan_darurat + a.potongan_toko + a.potongan_absensi + a.potongan_simpanan_wajib as potongan, a.tunj_bpjstk + a.tunj_bpjskes + a.tunj_makan + a.tunj_jabatan + a.tunj_dapen + a.tunj_lain as tunjangan, a.tunj_bpjstk + a.tunj_makan + a.tunj_jabatan + a.tunj_dapen + a.tunj_bpjskes + a.tunj_lain + b.gaji_pokok as jumlah_tunjangan, b.no_rekening, a.tunj_bpjstk + a.tunj_bpjskes + a.tunj_lain + b.gaji_pokok - a.potongan_bpjstk - a.potongan_bpjskes - a.potongan_lain - a.pph21_bulan as jumlah, a.potongan_lain + a.potongan_dapen + a.potongan_sekunder + a.potongan_darurat + a.potongan_toko + a.potongan_absensi as jml_potongan_lain, (a.tunj_bpjstk + a.tunj_bpjskes + a.tunj_makan + a.tunj_jabatan + a.tunj_dapen + a.tunj_lain + b.gaji_pokok) - (a.potongan_bpjstk + a.potongan_bpjskes + a.potongan_absensi + a.potongan_dapen + a.potongan_simpanan_wajib + a.potongan_sekunder + a.potongan_darurat + a.potongan_lain + a.potongan_toko + a.pph21_bulan) as cek_thp, a.tunj_makan + a.tunj_jabatan + a.tunj_dapen + a.tunj_lain as jml_lain
                FROM
                    gaji_karyawan AS a
                JOIN 
                    karyawan AS b ON a.nip = b.nip
                JOIN 
                    penempatan AS c ON b.id_penempatan = c.id_penempatan    
                WHERE
                    MONTH(A.periode) = '$bulan'
                and YEAR(A.periode) = '$tahun'
                and a.is_deleted = 0
                and 
                    b.id_penempatan = '$penempatan'
                -- GROUP BY a.nip, a.periode
                ORDER BY a.nip, a.periode 
                    ";
        $query = $this->ci->db->query($sql);
        return $query->result();
    }

    public function getTotal($bulan,$tahun,$penempatan) {
        $sql = "SELECT
                    *, sum(a.potongan_bpjstk + a.potongan_bpjskes + a.potongan_absensi + a.potongan_dapen + a.potongan_simpanan_wajib + a.potongan_sekunder + a.potongan_darurat + a.potongan_lain + a.potongan_toko + a.pph21_bulan) as total_potongan, sum(a.tunj_bpjstk + a.tunj_bpjskes + a.tunj_makan + a.tunj_jabatan + a.tunj_dapen + a.tunj_lain + b.gaji_pokok) as total_tunjangan, sum(a.thp) as total_thp, sum(a.potongan_bpjstk) as total_bpjstk, sum(a.potongan_bpjskes) as total_bpjskes, sum(b.gaji_pokok) as total_gapok, sum(a.tunj_makan + a.tunj_jabatan + a.tunj_dapen + a.tunj_lain) as total_lain, sum(a.potongan_bpjstk) as total_pot_bpjstk, sum(a.potongan_bpjskes) as total_pot_bpjskes, sum(a.potongan_lain) as total_pot_lain, sum(a.pph21_bulan) as total_pph21, sum(a.tunj_bpjstk + a.tunj_bpjskes + a.tunj_makan + a.tunj_jabatan + a.tunj_dapen + a.tunj_lain + b.gaji_pokok) as total_jumlah_tunjangan, sum(a.tunj_bpjstk + a.tunj_bpjskes + a.tunj_lain + b.gaji_pokok - a.potongan_bpjstk - a.potongan_bpjskes - a.potongan_lain - a.pph21_bulan) as total_jumlah, sum(a.potongan_lain + a.potongan_dapen + a.potongan_sekunder + a.potongan_darurat + a.potongan_toko + a.potongan_absensi) as jml_total_potongan_lain, sum((a.tunj_bpjstk + a.tunj_bpjskes + a.tunj_makan + a.tunj_jabatan + a.tunj_dapen + a.tunj_lain + b.gaji_pokok) - (a.potongan_bpjstk + a.potongan_bpjskes + a.potongan_absensi + a.potongan_dapen + a.potongan_simpanan_wajib + a.potongan_sekunder + a.potongan_darurat + a.potongan_lain + a.potongan_toko + a.pph21_bulan)) as jumlah_jumlah
                FROM
                    gaji_karyawan AS a
                JOIN 
                    karyawan AS b ON a.nip = b.nip
                JOIN 
                    penempatan AS c ON b.id_penempatan = c.id_penempatan    
                WHERE
                    MONTH(A.periode) = '$bulan'
                and YEAR(A.periode) = '$tahun'
                and a.is_deleted = 0
                and 
                    b.id_penempatan = '$penempatan'
                -- GROUP BY a.nip, a.periode
                ORDER BY a.nip, a.periode
                    ";
        $query = $this->ci->db->query($sql);
        return $query->result();
    }

    public function getGajikaryawanAll($bulan,$tahun) {
        $sql = "SELECT
                    *,  MONTH(A.periode) as bulan_gaji, YEAR(A.periode) as tahun_gaji, a.pph21_bulan, a.pph21_tahun, a.potongan_bpjstk + a.potongan_bpjskes + a.potongan_lain + a.pph21_bulan + a.potongan_dapen + a.potongan_sekunder + a.potongan_darurat + a.potongan_toko + a.potongan_absensi + a.potongan_simpanan_wajib as potongan, a.tunj_bpjstk + a.tunj_bpjskes + a.tunj_makan + a.tunj_jabatan + a.tunj_dapen + a.tunj_lain as tunjangan, a.tunj_bpjstk + a.tunj_makan + a.tunj_jabatan + a.tunj_dapen + a.tunj_bpjskes + a.tunj_lain + b.gaji_pokok as jumlah_tunjangan, b.no_rekening, a.tunj_bpjstk + a.tunj_bpjskes + a.tunj_lain + b.gaji_pokok - a.potongan_bpjstk - a.potongan_bpjskes - a.potongan_lain - a.pph21_bulan as jumlah, a.potongan_lain + a.potongan_dapen + a.potongan_sekunder + a.potongan_darurat + a.potongan_toko + a.potongan_absensi as jml_potongan_lain, (a.tunj_bpjstk + a.tunj_bpjskes + a.tunj_makan + a.tunj_jabatan + a.tunj_dapen + a.tunj_lain + b.gaji_pokok) - (a.potongan_bpjstk + a.potongan_bpjskes + a.potongan_absensi + a.potongan_dapen + a.potongan_simpanan_wajib + a.potongan_sekunder + a.potongan_darurat + a.potongan_lain + a.potongan_toko + a.pph21_bulan) as cek_thp, a.tunj_makan + a.tunj_jabatan + a.tunj_dapen + a.tunj_lain as jml_lain
                FROM
                    gaji_karyawan AS a
                JOIN 
                    karyawan AS b ON a.nip = b.nip
                JOIN 
                    penempatan AS c ON b.id_penempatan = c.id_penempatan    
                WHERE
                    MONTH(A.periode) = '$bulan'
                and YEAR(A.periode) = '$tahun'
                and a.is_deleted = 0
                -- GROUP BY a.nip, a.periode
                ORDER BY a.nip, a.periode 
                    ";
        $query = $this->ci->db->query($sql);
        return $query->result();
    }

    public function getTotalAll($bulan,$tahun) {
        $sql = "SELECT
                    *, sum(a.potongan_bpjstk + a.potongan_bpjskes + a.potongan_absensi + a.potongan_dapen + a.potongan_simpanan_wajib + a.potongan_sekunder + a.potongan_darurat + a.potongan_lain + a.potongan_toko + a.pph21_bulan) as total_potongan, sum(a.tunj_bpjstk + a.tunj_bpjskes + a.tunj_makan + a.tunj_jabatan + a.tunj_dapen + a.tunj_lain + b.gaji_pokok) as total_tunjangan, sum(a.thp) as total_thp, sum(a.potongan_bpjstk) as total_bpjstk, sum(a.potongan_bpjskes) as total_bpjskes, sum(b.gaji_pokok) as total_gapok, sum(a.tunj_makan + a.tunj_jabatan + a.tunj_dapen + a.tunj_lain) as total_lain, sum(a.potongan_bpjstk) as total_pot_bpjstk, sum(a.potongan_bpjskes) as total_pot_bpjskes, sum(a.potongan_lain) as total_pot_lain, sum(a.pph21_bulan) as total_pph21, sum(a.tunj_bpjstk + a.tunj_bpjskes + a.tunj_makan + a.tunj_jabatan + a.tunj_dapen + a.tunj_lain + b.gaji_pokok) as total_jumlah_tunjangan, sum(a.tunj_bpjstk + a.tunj_bpjskes + a.tunj_lain + b.gaji_pokok - a.potongan_bpjstk - a.potongan_bpjskes - a.potongan_lain - a.pph21_bulan) as total_jumlah, sum(a.potongan_lain + a.potongan_dapen + a.potongan_sekunder + a.potongan_darurat + a.potongan_toko + a.potongan_absensi) as jml_total_potongan_lain, sum((a.tunj_bpjstk + a.tunj_bpjskes + a.tunj_makan + a.tunj_jabatan + a.tunj_dapen + a.tunj_lain + b.gaji_pokok) - (a.potongan_bpjstk + a.potongan_bpjskes + a.potongan_absensi + a.potongan_dapen + a.potongan_simpanan_wajib + a.potongan_sekunder + a.potongan_darurat + a.potongan_lain + a.potongan_toko + a.pph21_bulan)) as jumlah_jumlah
                FROM
                    gaji_karyawan AS a
                JOIN 
                    karyawan AS b ON a.nip = b.nip
                JOIN 
                    penempatan AS c ON b.id_penempatan = c.id_penempatan    
                WHERE
                    MONTH(A.periode) = '$bulan'
                and YEAR(A.periode) = '$tahun'
                and a.is_deleted = 0
                -- GROUP BY a.nip, a.periode
                ORDER BY a.nip, a.periode
                    ";
        $query = $this->ci->db->query($sql);
        return $query->result();
    }

    public function getPajakkaryawan($bulan,$tahun) {
        $sql = "SELECT
                    *, a.pph21_bulan, a.pph21_tahun
                FROM
                    gaji_karyawan AS a
                JOIN 
                    karyawan AS b ON a.nip = b.nip
                WHERE
                    MONTH(A.periode) = '$bulan'
                and YEAR(A.periode) = '$tahun'
                and a.is_deleted = 0
                ORDER BY a.nip, a.periode 
                    ";
        $query = $this->ci->db->query($sql);
        return $query->result();
    }

    public function getTotalpajak($bulan,$tahun) {
        $sql = "SELECT
                    *, sum(a.pph21_bulan) as total_pph_bulan, sum(a.pph21_tahun) as total_pph_tahun
                FROM
                    gaji_karyawan AS a
                JOIN 
                    karyawan AS b ON a.nip = b.nip
                WHERE
                    MONTH(A.periode) = '$bulan'
                and YEAR(A.periode) = '$tahun'
                and a.is_deleted = 0
                ORDER BY a.nip, a.periode 
                    ";
        $query = $this->ci->db->query($sql);
        return $query->result();
    }

    public function getGajipekerja($bulan,$tahun,$penempatan) {
        $sql = "SELECT
                    *,  MONTH(A.periode) as bulan_gaji, YEAR(A.periode) as tahun_gaji, a.potongan_bpjstk + a.potongan_bpjskes + a.potongan_absensi + a.potongan_dapen + a.potongan_simpanan_wajib + a.potongan_sekunder + a.potongan_darurat + a.potongan_lain + a.potongan_toko  as potongan, a.tunj_bpjstk + a.tunj_bpjskes + a.tunj_makan + a.tunj_jabatan + a.tunj_dapen + a.tunj_lain as tunjangan, a.pph21_bulan, a.pph21_tahun
                FROM
                    gaji_karyawan AS a
                JOIN 
                    karyawan AS b ON a.nip = b.nip
                JOIN 
                    penempatan AS c ON b.id_penempatan = c.id_penempatan    
                WHERE
                    MONTH(A.periode) = '$bulan'
                and YEAR(A.periode) = '$tahun'
                and C.id_penempatan = '$penempatan'
                and A.is_deleted = 0
                ORDER BY a.nip, a.periode
                -- GROUP BY a.periode
                    ";
        $query = $this->ci->db->query($sql);
        return $query->result();
    }

    public function getTotalpekerja($bulan,$tahun,$penempatan) {
        $sql = "SELECT
                    *, sum(a.potongan_bpjstk + a.potongan_bpjskes + a.potongan_absensi + a.potongan_dapen + a.potongan_simpanan_wajib + a.potongan_sekunder + a.potongan_darurat + a.potongan_lain + a.potongan_toko) as total_potongan, sum(a.tunj_bpjstk + a.tunj_bpjskes + a.tunj_makan + a.tunj_jabatan + a.tunj_dapen + a.tunj_lain) as total_tunjangan, sum(a.thp) as total_thp
                FROM
                    gaji_karyawan AS a
                JOIN 
                    karyawan AS b ON a.nip = b.nip
                JOIN 
                    penempatan AS c ON b.id_penempatan = c.id_penempatan    
                WHERE
                    MONTH(A.periode) = '$bulan'
                and YEAR(A.periode) = '$tahun'
                and C.id_penempatan = '$penempatan'
                and A.is_deleted = 0
                ORDER BY a.nip, a.periode 
                    ";
        $query = $this->ci->db->query($sql);
        return $query->result();
    }

    public function getKaryawan() {
        $sql = "SELECT *
                FROM 
                    gaji_karyawan AS a
                JOIN 
                    karyawan AS b ON a.nip = b.nip    
                WHERE
                    datediff(b.tgl_berakhir, NOW()) > 0
                AND
                    a.is_deleted = 0
                AND
                    b.is_deleted = 0
                GROUP BY
                    a.nip                 
                ";
        $query = $this->ci->db->query($sql);
        return $query->result();
    }

    public function getPenagihan2() {
        $sql = "SELECT *
                FROM 
                    penagihan AS a 
                JOIN 
                    karyawan AS b ON a.nip = b.nip    
                WHERE
                    datediff(b.tgl_berakhir, NOW()) > 0
                AND
                    a.is_deleted = 0
                AND
                    b.is_deleted = 0   
                GROUP BY
                    a.nip                 
                ";
        $query = $this->ci->db->query($sql);
        return $query->result();
    }

    public function getPenagihansearch($bulan,$tahun,$penempatan) {
        $sql = "SELECT
                    *, YEAR(A.periode) AS tahun_periode, MONTH(A.periode) AS bulan_periode
                FROM
                    gaji_karyawan AS a
                JOIN 
                    karyawan AS b ON b.nip = a.nip    
                JOIN 
                    penempatan AS c ON b.id_penempatan = c.id_penempatan        
                WHERE 
                    a.nip = b.nip
                and    
                    MONTH(A.periode) = '$bulan'
                and 
                    YEAR(A.periode) = '$tahun'
                and 
                    b.id_penempatan = '$penempatan'
                and 
                    a.is_deleted = 0      
                ORDER BY
                    a.periode, a.nip    
                    ";
        $query = $this->ci->db->query($sql);
        return $query->result();
    }

    public function getPenagihantotalsearch($bulan,$tahun,$penempatan) {
        $sql = "SELECT
                    *, sum(a.thp) as total_thp, sum(a.potongan_absensi) as total_absen, sum(a.tunj_bpjstk) as total_bpjstk, sum(a.tunj_bpjskes) as total_bpjskes, sum(a.pph21_bulan) as total_pph21, sum(a.fee_bulan) as total_fee, sum(a.jml_tagihan) as total_tagihan, sum(a.rafel) as total_rafel, sum(a.thr) as total_thr, sum(a.pph23) as total_pph23, sum(a.upah) as total_upah
                FROM
                    gaji_karyawan AS a
                JOIN 
                    karyawan AS b ON b.nip = a.nip    
                JOIN 
                    penempatan AS c ON b.id_penempatan = c.id_penempatan
                WHERE 
                    a.nip = b.nip
                and    
                    MONTH(A.periode) = '$bulan'
                and 
                    YEAR(A.periode) = '$tahun' 
                and 
                    b.id_penempatan = '$penempatan'
                and 
                    a.is_deleted = 0  
                ORDER BY
                    a.periode, a.nip   
                    ";
        $query = $this->ci->db->query($sql);
        return $query->result();
    }

    public function getPenagihansearchAll($bulan,$tahun) {
        $sql = "SELECT
                    *, YEAR(A.periode) AS tahun_periode, MONTH(A.periode) AS bulan_periode
                FROM
                    gaji_karyawan AS a
                JOIN 
                    karyawan AS b ON b.nip = a.nip    
                JOIN 
                    penempatan AS c ON b.id_penempatan = c.id_penempatan        
                WHERE 
                    a.nip = b.nip
                and    
                    MONTH(A.periode) = '$bulan'
                and 
                    YEAR(A.periode) = '$tahun'
                and 
                    a.is_deleted = 0   
                ORDER BY
                    a.periode, a.nip    
                    ";
        $query = $this->ci->db->query($sql);
        return $query->result();
    }

    public function getPenagihantotalsearchAll($bulan,$tahun) {
        $sql = "SELECT
                    *, sum(a.thp) as total_thp, sum(a.potongan_absensi) as total_absen, sum(a.tunj_bpjstk) as total_bpjstk, sum(a.tunj_bpjskes) as total_bpjskes, sum(a.pph21_bulan) as total_pph21, sum(a.fee_bulan) as total_fee, sum(a.jml_tagihan) as total_tagihan, sum(a.rafel) as total_rafel, sum(a.thr) as total_thr, sum(a.pph23) as total_pph23, sum(a.upah) as total_upah
                FROM
                    gaji_karyawan AS a
                JOIN 
                    karyawan AS b ON b.nip = a.nip    
                JOIN 
                    penempatan AS c ON b.id_penempatan = c.id_penempatan
                WHERE 
                    a.nip = b.nip
                and    
                    MONTH(A.periode) = '$bulan'
                and 
                    YEAR(A.periode) = '$tahun' 
                and 
                    a.is_deleted = 0   
                ORDER BY
                    a.periode, a.nip   
                    ";
        $query = $this->ci->db->query($sql);
        return $query->result();
    }

    public function getPenagihan() {
        $sql = "SELECT
                    *, YEAR(A.periode) AS tahun_periode, MONTH(A.periode) AS bulan_periode
                FROM
                    gaji_karyawan AS a
                JOIN 
                    karyawan AS b ON b.nip = a.nip         
                WHERE 
                    a.nip = b.nip 
                AND
                    a.is_deleted = 0
                AND
                    b.is_deleted = 0 
                ORDER BY
                    a.periode, a.nip   
                    ";
        $query = $this->ci->db->query($sql);
        return $query->result();
    }

    public function getPenagihantotal() {
        $sql = "SELECT
                    *, sum(a.thp) as total_thp, sum(a.potongan_absensi) as total_absen, sum(a.tunj_bpjstk) as total_bpjstk, sum(a.tunj_bpjskes) as total_bpjskes, sum(a.pph21_bulan) as total_pph21, sum(a.fee_bulan) as total_fee, sum(a.jml_tagihan) as total_tagihan, sum(a.rafel) as total_rafel, sum(a.thr) as total_thr, sum(a.pph23) as total_pph23, sum(a.upah) as total_upah
                FROM
                    gaji_karyawan AS a
                LEFT JOIN 
                    karyawan AS b ON b.nip = a.nip    
                LEFT JOIN 
                    penempatan AS c ON b.id_penempatan = c.id_penempatan
                WHERE 
                    a.nip = b.nip    
                ORDER BY
                    a.periode, a.nip     
                    ";
        $query = $this->ci->db->query($sql);
        return $query->result();
    }

    public function get_id_detail_pinjam() {
        $sql = "SELECT MAX(id_detail_pinjam) as get_id_detail_pinjam
                FROM 
                    detail_pinjam  
                ";
        $query = $this->ci->db->query($sql);
        return $query->result();
    }

    public function get_id_pinjaman() {
        $sql = "SELECT a.*
                FROM 
                    pinjaman as a
                JOIN
                    karyawan as b on a.id_karyawan = b.id_karyawan
                WHERE
                    a.sisa > 0
                AND
                    a.id_karyawan = b.id_karyawan
                AND
                    a.is_deleted = 0          
                ";
        $query = $this->ci->db->query($sql);
        return $query->result();
    }

    public function get_cicilan() {
        $sql = "SELECT MAX(a.cicilan_ke) as get_cicilan
                FROM 
                    detail_pinjam as a
                JOIN
                    pinjaman as b on a.id_pinjaman = b.id_pinjaman    
                WHERE
                    a.id_pinjaman = b.id_pinjaman
                AND
                    a.id_karyawan = b.id_karyawan
                AND
                    b.sisa > 0
                AND
                    b.is_deleted = 0            
                ";
        $query = $this->ci->db->query($sql);
        return $query->result();
    }

    public function get_potongan($id_gaji_kar) {
        $sql = "SELECT a.potongan_lain
                FROM 
                    gaji_karyawan as a 
                JOIN
                    karyawan as b on a.id_karyawan = b.id_karyawan  
                WHERE 
                    a.id_karyawan = b.id_karyawan
                AND
                    a.id_gaji_karyawan = '$id_gaji_kar'            
                ";
        $query = $this->ci->db->query($sql);
        return $query->result();
    }

    

}

?>