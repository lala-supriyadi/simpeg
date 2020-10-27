<?php

class Public_function{

	function __construct(){
		$this->ci=&get_instance();
	}

	public function reArrayFiles(&$file_post, $id = null) {
        $file_ary = array();
        $file_keys = array_keys($file_post);
		if($id === null){
			$file_count = count($file_post['name']);
			for ($i=0; $i<$file_count; $i++) {
				foreach ($file_keys as $key) {
					$file_ary[$i][$key] = $file_post[$key][$i];
				}
			}
		} else {
			$file_count = count($file_post['name'][$id]);
			for ($i=0; $i<$file_count; $i++) {
				foreach ($file_keys as $key) {
					$file_ary[$i][$key] = $file_post[$key][$id][$i];
				}
			}
		}
        return $file_ary;
    }

    public function format_date(&$date){
        $r_bulan = $this->ref_bulan();
        $tahun = (int) substr($date,0,4);
        $bulan = (int) substr($date,5,2);
        $tanggal = (int) substr($date,8,2);
        $jam = (strlen($date) > 10)?date('H:i:s',strtotime($date)):"";
        return ((empty($tanggal))?"":$tanggal." ").((empty($bulan))?"":$r_bulan[$bulan]." ").((empty($tahun))?"":((empty($tanggal) && empty($bulan))?"Tahun ":"").$tahun." ").$jam;
    }

    public function ref_bulan(){
        $r_bulan = array(1=>"Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
        return $r_bulan;
    }
}
?>