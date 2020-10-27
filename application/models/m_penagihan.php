<?php
class m_penagihan extends Generic_dao {

    public function table_name() {
        return Tables::$penagihan;
    }

    public function field_map() {
        return array(
            'id_penagihan' => 'id_penagihan',
            'id_karyawan' => 'id_karyawan',
            'id_penempatan' => 'id_penempatan',
            // 'id_gaji_karyawan' => 'id_gaji_karyawan',
            'gaji_id' => 'gaji_id',
            'nama_karyawan' => 'nama_karyawan',
            'nip' => 'nip',
            'periode' => 'periode',
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
                'table_name' => Tables::$gaji_karyawan,
                'condition' => Tables::$gaji_karyawan . '.gaji_id = ' . $this->table_name() . '.gaji_id',
                'field' => 'potongan_absensi, thp, tunj_bpjskes, tunj_bpjstk, pph21_bulan'
            ),
            array(
                'table_name' => Tables::$karyawan,
                'condition' => Tables::$karyawan . '.nip = ' . $this->table_name() . '.nip',
                'field' => 'karyawan.id_karyawan, karyawan.nama_karyawan, karyawan.nip, karyawan.gaji_pokok'
            ),
            array(
                'table_name' => Tables::$penempatan,
                'condition' => Tables::$penempatan . '.id_penempatan = ' . $this->table_name() . '.id_penempatan',
                'field' => 'nama_perusahaan, penempatan.alamat, penempatan.fee'
            ),

        );
    }

    public function penagihanList() {
        $sql = "SELECT
                    *
                FROM
                    penagihan AS a
                JOIN 
                    gaji_karyawan AS b ON b.gaji_id = a.gaji_id
                JOIN 
                    karyawan AS c ON b.nip = c.nip    
                WHERE
                    a.nip = b.nip
                AND
                    a.is_deleted = 0
                AND
                    b.is_deleted = 0              
                GROUP BY
                    a.nip, a.periode
                ORDER BY
                    a.id_penagihan ASC    
                    ";
        $query = $this->ci->db->query($sql);
        return $query->result();
    }

    public function Gajikaryawanlist() {
        $sql = "SELECT
                    *
                FROM
                    karyawan AS a
                JOIN 
                    gaji_karyawan AS b ON b.nip = a.nip
                JOIN 
                    penempatan AS c ON a.id_penempatan = c.id_penempatan        
             
                    ";
        $query = $this->ci->db->query($sql);
        return $query->result();
    }

    public function getPenagihan() {
        $sql = "SELECT
                    *, YEAR(A.periode) AS tahun_periode, MONTH(A.periode) AS bulan_periode
                FROM
                    penagihan AS a
                JOIN 
                    karyawan AS b ON b.nip = a.nip    
                JOIN 
                    gaji_karyawan AS c ON c.id_karyawan = b.id_karyawan
                -- JOIN 
                --     penempatan AS d ON b.id_penempatan = d.id_penempatan        
                WHERE 
                    a.nip = b.nip 
                AND
                    b.nip = c.nip
                AND
                    a.is_deleted = 0
                AND
                    b.is_deleted = 0                        
                -- GROUP BY
                --     a.nip
                ORDER BY
                    a.periode, a.nip   
                    ";
        $query = $this->ci->db->query($sql);
        return $query->result();
    }

    public function getPenagihantotal() {
        $sql = "SELECT
                    *, sum(c.thp) as total_thp, sum(c.potongan_absensi) as total_absen, sum(c.tunj_bpjstk) as total_bpjstk, sum(c.tunj_bpjskes) as total_bpjskes, sum(c.pph21_bulan) as total_pph21, sum(a.fee_bulan) as total_fee, sum(a.jml_tagihan) as total_tagihan, sum(a.rafel) as total_rafel, sum(a.thr) as total_thr, sum(a.pph23) as total_pph23, sum(a.upah) as total_upah
                FROM
                    penagihan AS a
                LEFT JOIN 
                    karyawan AS b ON b.nip = a.nip    
                LEFT JOIN 
                    gaji_karyawan AS c ON b.nip = b.nip
                LEFT JOIN 
                    penempatan AS d ON b.id_penempatan = d.id_penempatan
                WHERE 
                    a.nip = c.nip
                AND
                    a.periode = c.periode            
                -- GROUP BY
                --     a.periode
                ORDER BY
                    a.periode, a.nip     
                    ";
        $query = $this->ci->db->query($sql);
        return $query->result();
    }

    public function getPenagihansearch($bulan,$tahun,$penempatan) {
        $sql = "SELECT
                    *, YEAR(A.periode) AS tahun_periode, MONTH(A.periode) AS bulan_periode
                FROM
                    penagihan AS a
                JOIN 
                    karyawan AS b ON b.nip = a.nip    
                JOIN 
                    gaji_karyawan AS c ON b.nip = b.nip
                JOIN 
                    penempatan AS d ON b.id_penempatan = d.id_penempatan        
                WHERE 
                    a.nip = c.nip
                and    
                    MONTH(A.periode) = '$bulan'
                and 
                    YEAR(A.periode) = '$tahun'
                and 
                    A.id_penempatan = '$penempatan'
                AND
                    a.periode = c.periode 
                and a.is_deleted = 0                        
                -- GROUP BY
                --     a.periode
                ORDER BY
                    a.periode, a.nip    
                    ";
        $query = $this->ci->db->query($sql);
        return $query->result();
    }

    public function getPenagihantotalsearch($bulan,$tahun,$penempatan) {
        $sql = "SELECT
                    *, sum(c.thp) as total_thp, sum(c.potongan_absensi) as total_absen, sum(c.tunj_bpjstk) as total_bpjstk, sum(c.tunj_bpjskes) as total_bpjskes, sum(c.pph21_bulan) as total_pph21, sum(a.fee_bulan) as total_fee, sum(a.jml_tagihan) as total_tagihan, sum(a.rafel) as total_rafel, sum(a.thr) as total_thr, sum(a.pph23) as total_pph23, sum(a.upah) as total_upah
                FROM
                    penagihan AS a
                LEFT JOIN 
                    karyawan AS b ON b.nip = a.nip    
                LEFT JOIN 
                    gaji_karyawan AS c ON b.nip = b.nip
                LEFT JOIN 
                    penempatan AS d ON b.id_penempatan = d.id_penempatan
                WHERE 
                    a.nip = c.nip
                and    
                    MONTH(A.periode) = '$bulan'
                and 
                    YEAR(A.periode) = '$tahun' 
                and 
                    A.id_penempatan = '$penempatan'
                AND
                    a.periode = c.periode
                and a.is_deleted = 0                        
                -- GROUP BY
                --     a.periode
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
                    penagihan AS a
                JOIN 
                    karyawan AS b ON b.nip = a.nip    
                JOIN 
                    gaji_karyawan AS c ON b.nip = b.nip
                JOIN 
                    penempatan AS d ON b.id_penempatan = d.id_penempatan        
                WHERE 
                    a.nip = c.nip
                and    
                    MONTH(A.periode) = '$bulan'
                and 
                    YEAR(A.periode) = '$tahun'
                AND
                    a.periode = c.periode 
                and a.is_deleted = 0                        
                -- GROUP BY
                --     a.periode
                ORDER BY
                    a.periode, a.nip    
                    ";
        $query = $this->ci->db->query($sql);
        return $query->result();
    }

    public function getPenagihantotalsearchAll($bulan,$tahun) {
        $sql = "SELECT
                    *, sum(c.thp) as total_thp, sum(c.potongan_absensi) as total_absen, sum(c.tunj_bpjstk) as total_bpjstk, sum(c.tunj_bpjskes) as total_bpjskes, sum(c.pph21_bulan) as total_pph21, sum(a.fee_bulan) as total_fee, sum(a.jml_tagihan) as total_tagihan, sum(a.rafel) as total_rafel, sum(a.thr) as total_thr, sum(a.pph23) as total_pph23, sum(a.upah) as total_upah
                FROM
                    penagihan AS a
                LEFT JOIN 
                    karyawan AS b ON b.nip = a.nip    
                LEFT JOIN 
                    gaji_karyawan AS c ON b.nip = b.nip
                LEFT JOIN 
                    penempatan AS d ON b.id_penempatan = d.id_penempatan
                WHERE 
                    a.nip = c.nip
                and    
                    MONTH(A.periode) = '$bulan'
                and 
                    YEAR(A.periode) = '$tahun' 
                AND
                    a.periode = c.periode
                and a.is_deleted = 0                        
                -- GROUP BY
                --     a.periode
                ORDER BY
                    a.periode, a.nip   
                    ";
        $query = $this->ci->db->query($sql);
        return $query->result();
    }

    public function getGaji($bulan,$tahun) {

        $sql = "SELECT A.nip, A.id_karyawan, MONTH(A.periode) AS bulan_gaji, YEAR(A.periode) AS tahun_gaji, A.jml_hari, A.tunj_jabatan, A.tunj_bpjstk, A.tunj_bpjskes, A.tunj_dapen, A.tunj_makan, A.tunj_lain, A.potongan_absensi, A.potongan_bpjstk, A.potongan_bpjskes, A.potongan_dapen, A.potongan_simpanan_wajib, A.potongan_sekunder, A.potongan_darurat, A.potongan_toko, A.potongan_lain, A.thp FROM gaji_karyawan AS A LEFT JOIN karyawan AS B ON B.id_karyawan = A.id_karyawan WHERE MONTH (A.periode) = '$bulan' AND YEAR (A.periode) = '$tahun' ORDER BY A.id_karyawan ASC";
        $query = $this->ci->db->query($sql);
        return $query;
    }

    public function getGajikaryawan($bulan,$tahun) {
        $sql = "SELECT
                    *,  MONTH(A.periode) as bulan_gaji, YEAR(A.periode) as tahun_gaji, a.potongan_bpjstk + a.potongan_bpjskes + a.potongan_absensi + a.potongan_dapen + a.potongan_simpanan_wajib + a.potongan_sekunder + a.potongan_darurat + a.potongan_lain + a.potongan_toko  as potongan, a.tunj_bpjstk + a.tunj_bpjskes + a.tunj_makan + a.tunj_jabatan + a.tunj_dapen + a.tunj_lain as tunjangan, a.pph21_bulan, a.pph21_tahun
                FROM
                    gaji_karyawan AS a
                JOIN 
                    karyawan AS b ON a.nip = b.nip
                WHERE
                    MONTH(A.periode) = '$bulan'
                and YEAR(A.periode) = '$tahun'
                and a.is_deleted = 0
                ORDER BY a.nip 
                    ";
        $query = $this->ci->db->query($sql);
        return $query->result();
    }

    public function getTotal($bulan,$tahun) {
        $sql = "SELECT
                    *, sum(a.potongan_bpjstk + a.potongan_bpjskes + a.potongan_absensi + a.potongan_dapen + a.potongan_simpanan_wajib + a.potongan_sekunder + a.potongan_darurat + a.potongan_lain + a.potongan_toko) as total_potongan, sum(a.tunj_bpjstk + a.tunj_bpjskes + a.tunj_makan + a.tunj_jabatan + a.tunj_dapen + a.tunj_lain) as total_tunjangan, sum(a.thp) as total_thp
                FROM
                    gaji_karyawan AS a
                JOIN 
                    karyawan AS b ON a.nip = b.nip
                WHERE
                    MONTH(A.periode) = '$bulan'
                and YEAR(A.periode) = '$tahun'
                and a.is_deleted = 0
                ORDER BY a.nip 
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
                ORDER BY a.nip 
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
                ORDER BY a.nip 
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
                ORDER BY a.nip 
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
                ORDER BY a.nip 
                    ";
        $query = $this->ci->db->query($sql);
        return $query->result();
    }

    

}

?>