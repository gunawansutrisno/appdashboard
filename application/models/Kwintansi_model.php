<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Kwintansi_model extends CI_Model {

    var $table = "mst_kwintansi";
    var $primary_key = "id";

    public function __construct() {
        parent::__construct();
    }

     public function checkppk($title=""){
$this->db->like('NMPPK', $title , 'both');
		$this->db->order_by('NMPPK', 'ASC');
		$this->db->limit(10);
		return $this->db->get('refppk')->result();
//                     $nama = $nm;
//      $this->db->select("*");
//             if($nama!= ""){
//                $this->db->or_like('NMPPK' , $nama);
//            }   
//        $this->db->order_by('NMPPK DESC');
//       $query = $this->db->get('refppk');
//       return $query;
    }
    public function getDataSearch($sep=""){
        $result =$this->db->select('*')
                ->from('mst_pemeriksaan')
                ->where('nosep =',$sep)
                ->join('mst_pasien','mst_pasien.id = mst_pemeriksaan.pasien_id','left')
                ->get()->row_array();
        return $result;
    }
    public function getSearch($sep=""){
        $result =$this->db->select('mst_pemeriksaan.nosep,
                    mst_pasien.nama AS pasien,
                    mst_pemeriksaan.tgl_periksa as tgl,
                    mst_pasien.id as id_pasien,
                    mst_pasien.noka,
                    mst_pasien.kode_pasien,
                    mst_siswa.nama_siswa as dokter,
                    mst_siswa.id as id_dokter,
                    refppk.KDPPK,
                    refppk.NMPPK,
                    mst_jenis_tindakan_op.name AS tindakan,
                    mst_jenis_tindakan_op.id AS id_tindakan,
                    mst_kwintansi.price_inacbg,
                    mst_kwintansi.operator_dokter_id,
                    mst_kwintansi.price,
                    mst_kwintansi.id,
              ')
                ->from('mst_kwintansi')
                ->where('mst_pemeriksaan.nosep =',$sep)
                ->join('mst_pasien','mst_pasien.id = mst_kwintansi.pasien_id','left')
                ->join('mst_siswa','mst_siswa.id = mst_kwintansi.dokter_id','left')
                ->join('refppk','refppk.KDPPK = mst_kwintansi.ppk_id','left')
                ->join('mst_jenis_tindakan_op','mst_jenis_tindakan_op.id= mst_kwintansi.kategori','left')
                ->join('mst_pemeriksaan','mst_pasien.id = mst_pemeriksaan.pasien_id','left')
                ->get()->row_array();
        return $result;
    }

    public function JenisTindakan(){

        $ret = $this->db->select('*')
                ->from('mst_jenis_tindakan_op')
                ->get()->result();
        return $ret;
    }
    public function getkw($tgl ="", $id=""){
        $result =$this->db->select('*')
                ->from($this->table)
                ->where('date =',$tgl)
                ->where('pasien_id =',$id)
                ->get()->row_array();
        return $result;
    }
    public function getcheckkwintansi($id=""){
        $result =$this->db->select('mst_kwintansi.faktur as no_kwintansi,
            mst_siswa.nama_siswa AS dokter,
            mst_siswa.kode_dokter,
            mst_pasien.noka,
            mst_pasien.nama AS pasien,
            mst_pemeriksaan.nosep,
            mst_pemeriksaan.jenis_rawat,
            DATE_FORMAT(mst_pemeriksaan.tgl_periksa,"%d %M %Y") AS tanggal,
            mst_pemeriksaan.diagnosa, 
            mst_kwintansi.status,
            mst_kwintansi.acc,
            mst_kwintansi.createddate,
            mst_kwintansi.price,
            mst_jenis_tindakan_op.name as kategori,
            mst_kwintansi.faktur,')
                ->from($this->table)
                ->join("mst_siswa" , "mst_siswa.id = mst_kwintansi.dokter_id","left")
                ->join("mst_pasien" , "mst_pasien.id = mst_kwintansi.pasien_id","left")
                ->join("refppk" , "refppk.KDPPK = mst_kwintansi.ppk_id","left")
                ->join("mst_pemeriksaan" , "mst_pemeriksaan.pasien_id = mst_pasien.id","left")  
                ->join("mst_jenis_tindakan_op" , "mst_kwintansi.kategori = mst_jenis_tindakan_op.id","left")  
                ->where('mst_kwintansi.id =',$id)
                ->get()->row_array();
        return $result;
    }
    public function getcek_search($noka=""){
        $ret=$this->db->from('mst_pasien')
                ->where('noka', $noka)->get()->row_array();
        return $ret;
    }
    public function getKode(){
         $this->db->select('MAX(RIGHT(mst_kwintansi.id,4)) as kode', FALSE);
        $this->db->order_by('id','DESC');    
        $this->db->limit(1);    
        $query = $this->db->get('mst_kwintansi'); 
//        echoPre($query);exit;
        if($query->num_rows() <> 0){       
         $data = $query->row(); 
         $kode = intval($data->kode) + 1;    
        }
        else {          
         $kode = 1;    
        }
        $kodemax = str_pad($kode, 6, "0", STR_PAD_LEFT); 
        $kodejadi = "No: ".$kodemax." B ";    
        return $kodejadi;  
    }
    public function saveData($arrData = array(), $debug = false) {

        $this->db->set($arrData);
            if ($debug) {
                $retVal = $this->db->get_compiled_insert($this->table);
            } else {
                $res = $this->db->insert($this->table);
                if (!$res) {
                    $retVal['error_stat'] = "Failed To Insert";
                    $retVal['status'] = false;
                } else {
                    $retVal['error_stat'] = "Success To Insert";
                    $retVal['status'] = true;
                    $retVal['id'] = $this->db->insert_id();
                }
            }
//        }
        return $retVal;
    }
    public function delete($id) {
//        echoPre($id);exit;
//        delete siswa
        $this->db->where($this->primary_key, $id);
        $q = $this->db->delete($this->table);

        if (!$q) {
            $retVal['error_stat'] = "Failed To Delete";
            $retVal['status'] = false;
        } else {
            $retVal['error_stat'] = "Success To Delete";
            $retVal['status'] = true;
        }

        return $retVal;
    }
     public function getDataIndex($offset = 0, $limit = 10, $status_pembayaran = "", $tanggal = array()) {
       
            if ($status_pembayaran != "") {
                $this->db->where($this->table.'.status', $status_pembayaran);
            }
          
            if (!empty($tanggal) && isset($tanggal['start']) && isset($tanggal['end'])) {
                  $this->db->where("mst_pemeriksaan.tgl_periksa BETWEEN '".$tanggal['start']."' AND '".$tanggal['end']."'");
        }
        $this->db->select('mst_kwintansi.faktur as no_kwintansi,
            mst_siswa.nama_siswa AS dokter,
            mst_siswa.kode_dokter,
            mst_pasien.noka,
            mst_pasien.nama AS pasien,
            mst_pemeriksaan.nosep,
            mst_pemeriksaan.jenis_rawat,
            mst_pemeriksaan.tgl_periksa as tanggal,
            mst_pemeriksaan.diagnosa, 
            mst_kwintansi.status,
            mst_kwintansi.acc,
            mst_kwintansi.faktur,
       ');
       $this->db->join("mst_siswa" , "mst_siswa.id = mst_kwintansi.dokter_id","left");
        $this->db->join("mst_pasien" , "mst_pasien.id = mst_kwintansi.pasien_id","left");
        $this->db->join("refppk" , "refppk.KDPPK = mst_kwintansi.ppk_id","left");
        $this->db->join("mst_pemeriksaan" , "mst_pemeriksaan.pasien_id = mst_pasien.id","left");
        $this->db->from($this->table);
        if($limit != 'all'){
            $this->db->limit($limit);
        
        }
        $this->db->offset($offset);
        $this->db->order_by("mst_pemeriksaan.nosep ASC");
        $this->db->order_by("mst_pemeriksaan.tgl_periksa ASC");
        $data = $this->db->get();
        return $data->result();
    }
    public function getDataIndexexport($status_pembayaran = "", $tanggal = array()) {
       
       
           if ($status_pembayaran != "") {
                $this->db->where($this->table.'.status', $status_pembayaran);
            }
          
            if (!empty($tanggal) && isset($tanggal['start']) && isset($tanggal['end'])) {
                  $this->db->where("mst_pemeriksaan.tgl_periksa BETWEEN '".$tanggal['start']."' AND '".$tanggal['end']."'");
        }
        $this->db->select('
                mst_kwintansi.faktur as no_kwintansi,
                mst_siswa.nama_siswa AS dokter,
                mst_siswa.kode_dokter,
                mst_pasien.noka,
                mst_pasien.nama AS pasien,
                mst_pemeriksaan.nosep,
                mst_pemeriksaan.jenis_rawat,
                mst_pemeriksaan.tgl_periksa as tanggal,
                mst_pemeriksaan.diagnosa,
                mst_kwintansi.status,
                mst_kwintansi.price,
                mst_kwintansi.price_inacbg,
                mst_kwintansi.acc,
                refppk.NMPPK,
                mst_kwintansi.faktur,
                mst_jenis_tindakan_op.name as kategori
           ');
        $this->db->join("mst_siswa" , "mst_siswa.id = mst_kwintansi.dokter_id","left");
        $this->db->join("mst_pasien" , "mst_pasien.id = mst_kwintansi.pasien_id","left");
        $this->db->join("refppk" , "refppk.KDPPK = mst_kwintansi.ppk_id","left");
        $this->db->join("mst_pemeriksaan" , "mst_pemeriksaan.pasien_id = mst_pasien.id","left");
        $this->db->join("mst_jenis_tindakan_op" , "mst_kwintansi.kategori= mst_jenis_tindakan_op.id","left");
        $this->db->from($this->table);
        $this->db->order_by("mst_pemeriksaan.nosep ASC");
        $this->db->order_by("mst_pemeriksaan.tgl_periksa ASC");
        $data = $this->db->get();
        return $data;
    }
    public function getDataKwin( $status_pembayaran = "",  $tanggal =""){
         $this->db->select("
            mst_siswa.nama_siswa AS dokter,
            mst_siswa.kode_dokter,
            mst_pasien.noka,
            mst_pasien.nama AS pasien,
            mst_pemeriksaan.nosep,
            mst_pemeriksaan.jenis_rawat,
            mst_pemeriksaan.tgl_periksa as tanggal,
            mst_pemeriksaan.diagnosa,
            mst_kwintansi.status,
            mst_kwintansi.price,
            mst_kwintansi.acc,
            refppk.NMPPK,
            mst_kwintansi.faktur,
            mst_jenis_tindakan_op.name as kategori
        ");
        $this->db->join("mst_siswa" , "mst_siswa.id = mst_kwintansi.dokter_id","left");
//        $this->db->join("mst_siswa" , "mst_siswa.id = mst_kwintansi.operator_dokter_id","left");
        $this->db->join("mst_pasien" , "mst_pasien.id = mst_kwintansi.pasien_id","left");
        $this->db->join("refppk" , "refppk.KDPPK = mst_kwintansi.ppk_id","left");
        $this->db->join("mst_pemeriksaan" , "mst_pemeriksaan.pasien_id = mst_pasien.id","left");
        $this->db->join("mst_jenis_tindakan_op" , "mst_kwintansi.kategori= mst_jenis_tindakan_op.id","left");
        if($status_pembayaran !=""){
              $this->db->where("mst_kwintansi.status" , $status_pembayaran);           
        } 
        if($tanggal !=""){
                $this->db->where("mst_pemeriksaan.tgl_periksa BETWEEN '".$tanggal['start']."' AND '".$tanggal['end']."'");
        }
        $this->db->order_by("mst_pemeriksaan.nosep DESC"); 
        return $this->db->get_compiled_select($this->table);
    }
    public function update($array, $id) {

        $this->db->where($this->primary_key, $id);
        $query = $this->db->update($this->table, $array);
        if (!$query) {

            $retVal['error_stat'] = "Failed To Insert";
            $retVal['status'] = false;
        } else {
            $retVal['error_stat'] = "Success To Update";
            $retVal['status'] = true;
            $retVal['id'] = $id;
        }

        return $retVal;
    }
    public function updatedrm($array, $id) {

        $this->db->where("nama", $id);
        $query = $this->db->update('mst_pasien', $array);
        if (!$query) {

            $retVal['error_stat'] = "Failed To Insert";
            $retVal['status'] = false;
        } else {
            $retVal['error_stat'] = "Success To Update";
            $retVal['status'] = true;
            $retVal['id'] = $id;
        }

        return $retVal;
    }
   
}
