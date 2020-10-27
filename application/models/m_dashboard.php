<?php
class m_dashboard extends Generic_dao {

    public function table_name() {
        return Tables::$karyawan;
    }

    public function field_map() {
        return array(
            'id_karyawan' => 'id_karyawan',
            'id_divisi' => 'id_divisi',
            'id_penempatan' => 'id_penempatan',
            'nip' => 'nip',
            'kode_pagu' => 'kode_pagu',
            'nik' => 'nik',
            'no_npwp' => 'no_npwp',
            'nama_karyawan' => 'nama_karyawan',
            'tempat_lahir' => 'tempat_lahir',
            'tgl_lahir' => 'tgl_lahir',
            'foto' => 'foto',
            'agama' => 'agama',
            'jenis_kelamin' => 'jenis_kelamin',
            'alamat' => 'alamat',
            'no_telp' => 'no_telp',
            'email' => 'email',
            'bank' => 'bank',
            'no_rekening' => 'no_rekening',
            'status_pernikahan' => 'status_pernikahan',
            'grade' => 'grade',
            'jurusan' => 'jurusan',
            'no_kontrak' => 'no_kontrak',
            'tgl_masuk' => 'tgl_masuk',
            'tgl_berakhir' => 'tgl_berakhir',
            'jabatan' => 'jabatan',
            'gaji_pokok' => 'gaji_pokok',
            'created_by' => 'created_by',
            'created_at' => 'created_at',
            'updated_by' => 'updated_by',
            'updated_at' => 'updated_at',
            'is_deleted' => 'is_deleted'
        );
    }

    public function getKaryawan() {
        $sql = "SELECT COUNT(id_karyawan) as jumlah_karyawan FROM karyawan WHERE is_deleted = 0";
        $query = $this->ci->db->query($sql);
        return $query->result();
    }

    public function getKontrak() {
        $sql = "SELECT COUNT(id_karyawan) as jumlah_kontrak FROM karyawan WHERE datediff(tgl_berakhir, NOW()) <= 30 AND datediff(tgl_berakhir, NOW()) > 0";
        $query = $this->ci->db->query($sql);
        return $query->result();
    }

    public function getListkontrak() {
        $sql = "SELECT 
                    a.*, datediff(a.tgl_berakhir, NOW()) as selisih, b.nama_perusahaan 
                FROM 
                    karyawan as a
                JOIN 
                    penempatan AS b ON a.id_penempatan = b.id_penempatan
                WHERE 
                    datediff(a.tgl_berakhir, NOW()) <= 30 
                AND 
                    datediff(a.tgl_berakhir, NOW()) > 0";
        $query = $this->ci->db->query($sql);
        return $query->result();
    }

    public function getNotkontrak() {
        $sql = "SELECT COUNT(id_karyawan) as jumlah_tidak_kontrak FROM karyawan WHERE datediff(tgl_berakhir, NOW()) < 0";
        $query = $this->ci->db->query($sql);
        return $query->result();
    }

    public function getDiagram() {
        $sql = "SELECT COUNT(id_karyawan) AS jenis, jenis_kelamin FROM karyawan GROUP BY jenis_kelamin";
        $query = $this->ci->db->query($sql);
        return $query->result();
    }

    public function getPendidikan() {
        $sql = "SELECT COUNT(id_karyawan) AS pendidikan, grade FROM karyawan GROUP BY grade";
        $query = $this->ci->db->query($sql);
        return $query->result();
    }

    public function getPernikahan() {
        $sql = "SELECT COUNT(id_karyawan) AS pernikahan, status_pernikahan FROM karyawan GROUP BY status_pernikahan";
        $query = $this->ci->db->query($sql);
        return $query->result();
    }

    public function getJurusan() {
        $sql = "SELECT COUNT(id_karyawan) AS jurusan_grade, jurusan, grade FROM karyawan GROUP BY jurusan";
        $query = $this->ci->db->query($sql);
        return $query->result();
    }

   

    // public function getDiagram2() {
    //     $sql = "SELECT CONCAT( jenis_pesanan ) AS pesanan, jml_pesanan AS jumlah, date_format(tgl_pesanan, '%M') AS month FROM pesanan WHERE jenis_pesanan='sosis'";
    //     $query = $this->ci->db->query($sql);
    //     return $query->result();
    // }
    // public function getPie() {
    //     $sql = "SELECT jml_pesanan AS jumlah, jenis_pesanan AS pesanan, isi AS isi FROM pesanan GROUP BY isi";
    //     $query = $this->ci->db->query($sql);
    //     return $query->result();
    // }

    public function __construct() {
        parent::__construct();
    }

}

?>