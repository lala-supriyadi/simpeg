<?php
class m_karyawan extends Generic_dao {

    public function table_name() {
        return Tables::$karyawan;
    }

    public function field_map() {
        return array(
            'id_karyawan' => 'id_karyawan',
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
            'nama_kontrak' => 'nama_kontrak',
            'no_kontrak' => 'no_kontrak',
            'tgl_masuk' => 'tgl_masuk',
            'tgl_berakhir' => 'tgl_berakhir',
            'divisi' => 'divisi',
            'jabatan' => 'jabatan',
            'gaji_pokok' => 'gaji_pokok',
            'created_by' => 'created_by',
            'created_at' => 'created_at',
            'updated_by' => 'updated_by',
            'updated_at' => 'updated_at',
            'is_deleted' => 'is_deleted',
            'updated_status' => 'updated_status'
        );
    }

    public function __construct() {
        parent::__construct();
    }

    public function joined_table() {
        return array(
            array(
                'table_name' => Tables::$penempatan,
                'condition' => Tables::$penempatan . '.id_penempatan = ' . $this->table_name() . '.id_penempatan',
                'field' => 'nama_perusahaan, penempatan.alamat, penempatan.fee'
            )
        );
    }

    public function getnotif() {
        $sql = "SELECT count(id_karyawan) as jumlah_update, updated_at as update_pada, updated_by as updated_oleh FROM karyawan WHERE updated_by != null";
        $query = $this->ci->db->query($sql);
        return $query->result();
    }

    public function getkaryawan() {
        $sql = "SELECT * FROM karyawan";
        $query = $this->ci->db->query($sql);
        return $query->result();
    }

    public function insert_batch($data) {
        $this->db->insert_batch('karyawan', $data);
        
        return $this->db->affected_rows();
    }

    public function check_nama($nama_karyawan) {
        $this->db->where('nama_karyawan', $nama_karyawan);
        $data = $this->db->get('karyawan');

        return $data->num_rows();
    }

    public function get_id_karyawan() {
        $sql = "SELECT MAX(id_karyawan) as get_id_karyawan
                FROM 
                    karyawan  
                ";
        $query = $this->ci->db->query($sql);
        return $query->result();
    }

    public function get_id_gaji_karyawan() {
        $sql = "SELECT MAX(id_gaji_karyawan) as get_id_gaji_karyawan
                FROM 
                    gaji_karyawan  
                ";
        $query = $this->ci->db->query($sql);
        return $query->result();
    }

    public function get_id_penagihan() {
        $sql = "SELECT MAX(id_penagihan) as get_id_penagihan
                FROM 
                    penagihan  
                ";
        $query = $this->ci->db->query($sql);
        return $query->result();
    }

    public function cek_nip() {
        $sql = "SELECT *
                FROM 
                    karyawan  
                ";
        $query = $this->ci->db->query($sql);
        return $query->result();
    } 

    public function cek_fee2() {
        $sql = "SELECT fee as nilai_fee2
                FROM 
                    penempatan
                WHERE 
                    nama_perusahaan = 'PT Len IOTI Fintech'      
                ";
        $query = $this->ci->db->query($sql);
        return $query->result();
    }

    public function cek_fee3() {
        $sql = "SELECT fee as nilai_fee3
                FROM 
                    penempatan
                WHERE 
                    nama_perusahaan = 'PT Puri Makmur Lestari'      
                ";
        $query = $this->ci->db->query($sql);
        return $query->result();
    }

    public function cek_fee4() {
        $sql = "SELECT fee as nilai_fee4
                FROM 
                    penempatan
                WHERE 
                    nama_perusahaan = 'LEN INDUSTRI'      
                ";
        $query = $this->ci->db->query($sql);
        return $query->result();
    }

    public function cek_fee5() {
        $sql = "SELECT fee as nilai_fee5
                FROM 
                    penempatan
                WHERE 
                    nama_perusahaan = 'Len Railways System'      
                ";
        $query = $this->ci->db->query($sql);
        return $query->result();
    }

    public function cek_fee6() {
        $sql = "SELECT fee as nilai_fee6
                FROM 
                    penempatan
                WHERE 
                    nama_perusahaan = 'Len Rekaprima Semesta'      
                ";
        $query = $this->ci->db->query($sql);
        return $query->result();
    }

    public function cek_fee7() {
        $sql = "SELECT fee as nilai_fee7
                FROM 
                    penempatan
                WHERE 
                    nama_perusahaan = 'Len Telekomunikasi Indonesia'      
                ";
        $query = $this->ci->db->query($sql);
        return $query->result();
    }

    public function cek_fee8() {
        $sql = "SELECT fee as nilai_fee8
                FROM 
                    penempatan
                WHERE 
                    nama_perusahaan = 'Surya Energy Indonesia'      
                ";
        $query = $this->ci->db->query($sql);
        return $query->result();
    }

    public function cek_fee9() {
        $sql = "SELECT fee as nilai_fee9
                FROM 
                    penempatan
                WHERE 
                    nama_perusahaan = 'PT Eltran'      
                ";
        $query = $this->ci->db->query($sql);
        return $query->result();
    }

    public function cek_fee10() {
        $sql = "SELECT fee as nilai_fee10
                FROM 
                    penempatan
                WHERE 
                    nama_perusahaan = 'Koperasi Karyawan Len'      
                ";
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
                    a.is_deleted = 0 
                ";
        $query = $this->ci->db->query($sql);
        return $query->result();
    }

    function kabupaten($id){

    $kabupaten="<option value='0'>--pilih--</pilih>";

    $this->db->order_by('id_divisi','ASC');
    $kab= $this->db->get_where('divisi',array('id_penempatan'=>$id));

    foreach ($kab->result_array() as $data ){
    // $kabupaten.= "<option value='$data[id_divisi]'>$data[nama_divisi]</option>";
        $kabupaten.= "<option value='$data->id_divisi'> $data->nama_divisi</option>";
    }

    return $kabupaten;

    }


    // function kabupaten($provId){

    // $kabupaten="<option value='0'>--pilih--</pilih>";

    // $this->db->order_by('id_dokter','ASC');
    // $kab= $this->db->get_where('dokter',array('id_poliklinik'=>$provId));

    // foreach ($kab->result_array() as $data ){
    // $kabupaten.= "<option value='$data[id_dokter]'>$data[nama_dokter]</option>";
    // }

    // return $kabupaten;

    // }

    // function get_divisi($id_penempatan){
    //     $query = $this->db->get_where('divisi', array('id_penempatan' => $id_penempatan));
    //     return $query;
    // }

    public function get_divisi($id) {
        $sql = "SELECT * FROM divisi WHERE'id_penempatan' = '$id' ";
        $query = $this->ci->db->query($sql);
        return $query->result();
    }

    function get_divisi2($id){
        $hasil=$this->db->query("SELECT * FROM divisi WHERE id_penempatan='$id'");
        return $hasil->result();
    }

    function get_subkategori($id){
        $hasil=$this->db->query("SELECT * FROM divisi WHERE id_penempatan='$id'");
        return $hasil->result();
    }

    function GetDivisi($where){
    
        $kabupaten="<option value='0'>--pilih--</pilih>";
        
        $this->db->order_by('id_divisi','ASC');
        $kab= $this->db->get_where('divisi',array('id_penempatan'=>$where));
        
        foreach ($kab->result_array() as $data ){
            $kabupaten.= "<option value = $data->id_divisi>$data->nama_divisi</option>";
        }       
        return $kabupaten;
    
    }

    // function get_subkategori($id){
    //     $hasil=$this->db->query("SELECT * FROM subkategori WHERE subkategori_kategori_id='$id'");
    //     return $hasil->result();
    // }

    // function GetDokter($where){
    
    //     $kabupaten="<option value='0'>--pilih--</pilih>";
        
    //     $this->db->order_by('id_dokter','ASC');
    //     $kab= $this->db->get_where('dokter',array('id_poliklinik'=>$where));
        
    //     foreach ($kab->result_array() as $data ){
    //         $kabupaten.= "<option value='$data[id_dokter]'>$data[nama_dokter]</option>";
    //     }       
    //     return $kabupaten;
    
    // }

    

}

?>