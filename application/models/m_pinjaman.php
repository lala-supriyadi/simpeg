<?php
class m_pinjaman extends Generic_dao {

    public function table_name() {
        return Tables::$pinjaman;
    }

    public function field_map() {
        return array(
            'id_pinjaman' => 'id_pinjaman',
            'id_karyawan' => 'id_karyawan',
            'nama_karyawan' => 'nama_karyawan',
            'nama_pinjaman' => 'nama_pinjaman',
            'jumlah_pinjaman' => 'jumlah_pinjaman',
            'tgl_pinjaman' => 'tgl_pinjaman',
            'sisa' => 'sisa',
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
                'field' => 'nip, karyawan.nama_karyawan'
            )
        );
    }

    public function getPinjaman() {
        $sql = "SELECT
                    *, YEAR(a.tgl_pinjaman) AS tahun_pinjam, MONTH(a.tgl_pinjaman) AS bulan_pinjam
                FROM
                    pinjaman AS a
                JOIN 
                    karyawan AS b ON b.id_karyawan = a.id_karyawan
                -- JOIN
                --     detail_pinjam AS c on a.id_pinjaman = c.id_pinjaman 
                JOIN 
                    penempatan AS d ON b.id_penempatan = d.id_penempatan          
                WHERE 
                    a.id_karyawan = b.id_karyawan
                AND
                    a.id_pinjaman = c.id_pinjaman     
                AND
                    a.is_deleted = 0
                AND
                    b.is_deleted = 0 
                AND
                    c.is_deleted = 0
                ORDER BY
                    a.tgl_pinjaman, a.id_karyawan   
                    ";
        $query = $this->ci->db->query($sql);
        return $query->result();
    }

    public function getPinjamantotal() {
        $sql = "SELECT
                    *, sum(a.jumlah_pinjaman) as total_pinjaman, sum(a.sisa) as total_sisa
                FROM
                    pinjaman AS a
                JOIN 
                    karyawan AS b ON b.id_karyawan = a.id_karyawan    
                -- JOIN 
                --     detail_pinjam AS c on a.id_pinjaman = c.id_pinjaman
                JOIN 
                    penempatan AS d ON b.id_penempatan = d.id_penempatan   
                WHERE 
                    a.id_karyawan = b.id_karyawan
                AND
                    a.id_pinjaman = c.id_pinjaman     
                AND
                    a.is_deleted = 0
                AND
                    b.is_deleted = 0 
                AND
                    c.is_deleted = 0
                ORDER BY
                    a.tgl_pinjaman, a.id_karyawan
                    ";
        $query = $this->ci->db->query($sql);
        return $query->result();
    }

    public function getPinjamansearch($bulan,$tahun,$penempatan) {
        $sql = "SELECT
                    *, YEAR(a.tgl_pinjaman) AS tahun_pinjam, MONTH(a.tgl_pinjaman) AS bulan_pinjam
                FROM
                    pinjaman AS a
                JOIN 
                    karyawan AS b ON b.id_karyawan = a.id_karyawan    
                -- JOIN 
                --     detail_pinjam AS c on a.id_pinjaman = c.id_pinjaman   
                JOIN 
                    penempatan AS d ON b.id_penempatan = d.id_penempatan     
                WHERE 
                    a.id_karyawan = b.id_karyawan
                and    
                    MONTH(a.tgl_pinjaman) = '$bulan'
                and 
                    YEAR(a.tgl_pinjaman) = '$tahun'
                and 
                    b.id_penempatan = '$penempatan'
                and 
                    a.is_deleted = 0
                -- GROUP BY
                --     b.id_karyawan          
                ORDER BY
                    a.tgl_pinjaman, a.id_karyawan
                    ";
        $query = $this->ci->db->query($sql);
        return $query->result();
    }

    public function getPinjamantotalsearch($bulan,$tahun,$penempatan) {
        $sql = "SELECT
                    *, sum(a.jumlah_pinjaman) as total_pinjaman, sum(a.sisa) as total_sisa
                FROM
                    pinjaman AS a
                JOIN 
                    karyawan AS b ON b.id_karyawan = a.id_karyawan    
                -- JOIN 
                --     detail_pinjam AS c on a.id_pinjaman = c.id_pinjaman   
                JOIN 
                    penempatan AS d ON b.id_penempatan = d.id_penempatan  
                WHERE 
                    a.id_karyawan = b.id_karyawan
                and    
                    MONTH(a.tgl_pinjaman) = '$bulan'
                and 
                    YEAR(a.tgl_pinjaman) = '$tahun' 
                and 
                    b.id_penempatan = '$penempatan'
                and 
                    a.is_deleted = 0  
                -- GROUP BY
                --     b.id_karyawan, a.id_pinjaman       
                ORDER BY
                    a.tgl_pinjaman, a.id_karyawan
                    ";
        $query = $this->ci->db->query($sql);
        return $query->result();
    }

    public function getPinjamansearchAll($bulan,$tahun) {
        $sql = "SELECT
                    *, YEAR(a.tgl_pinjaman) AS tahun_periode, MONTH(a.tgl_pinjaman) AS bulan_periode
                FROM
                    pinjaman AS a
                JOIN 
                    karyawan AS b ON b.id_karyawan = a.id_karyawan    
                JOIN 
                    penempatan AS c ON b.id_penempatan = c.id_penempatan        
                WHERE 
                    a.id_karyawan = b.id_karyawan
                and    
                    MONTH(a.tgl_pinjaman) = '$bulan'
                and 
                    YEAR(a.tgl_pinjaman) = '$tahun'
                and 
                    a.is_deleted = 0   
                ORDER BY
                    a.tgl_pinjaman, a.id_karyawan    
                    ";
        $query = $this->ci->db->query($sql);
        return $query->result();
    }

    public function getPinjamantotalsearchAll($bulan,$tahun) {
        $sql = "SELECT
                    *, sum(a.jumlah_pinjaman) as total_pinjaman, sum(a.sisa) as total_sisa
                FROM
                    pinjaman AS a
                JOIN 
                    karyawan AS b ON b.id_karyawan = a.id_karyawan    
                -- JOIN 
                --     detail_pinjam AS c on a.id_pinjaman = c.id_pinjaman   
                JOIN 
                    penempatan AS d ON b.id_penempatan = d.id_penempatan  
                WHERE 
                    a.id_karyawan = b.id_karyawan
                and    
                    MONTH(a.tgl_pinjaman) = '$bulan'
                and 
                    YEAR(a.tgl_pinjaman) = '$tahun'
                and 
                    a.is_deleted = 0  
                ORDER BY
                    a.tgl_pinjaman, a.id_karyawan
                    ";
        $query = $this->ci->db->query($sql);
        return $query->result();
    }

}

?>