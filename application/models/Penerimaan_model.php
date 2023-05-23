<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Penerimaan_model extends CI_Model {

    var $table = "mst_idcard";
    var $primary_key = "id";
    var $jointTable = "tr_idcard";

    public function __construct() {
        parent::__construct();
    }

    public function getDataIndex($offset = 0, $limit = 10, $status_pembayaran = "", $tanggal = array()) {
       
            if ($status_pembayaran != "") {
                $this->db->where($this->table.'.status', $status_pembayaran);
            }
          
            if (!empty($tanggal) && isset($tanggal['start']) && isset($tanggal['end'])) {
                $this->db->where($this->table.'.tgl BETWEEN "' . $tanggal['start'] . '" AND "' .$tanggal['end'].'"');
           }
        $this->db->from($this->table);
        if($limit != 'all'){
            $this->db->limit($limit);
        
        }
        $this->db->offset($offset);
//        $this->db->order_by($this->table . ".tgl ASC");
        $data = $this->db->get();
        return $data->result();
    }
    public function getDataIndexexport($tanggal = array()) {
       
            if (!empty($tanggal) && isset($tanggal['start']) && isset($tanggal['end'])) {
                $this->db->where("tr_idcard.createddate BETWEEN '".$tanggal['start']."' AND '".$tanggal['end']."'");
            }
            
        $this->db->select("mst_idcard.nik,mst_idcard.nama,mst_idcard.transportasi,"
                . "mst_idcard.nomor,mst_idcard.nopol,tr_idcard.createddate,tr_idcard.checkin_date,tr_idcard.check_out,tr_idcard.status,tr_idcard.status_checkout");
        $this->db->join("mst_idcard" , "tr_idcard.card_id = mst_idcard.id","left");
        $this->db->from($this->jointTable);  
//        $this->db->order_by("tr_idcard.createddate ASC"); 
        $data = $this->db->get();
        return $data->result_array();
    }
   
   
   public function getDataTrans($tanggal=""){
       
        if($tanggal !=""){
                $this->db->where("tr_idcard.createddate BETWEEN '".$tanggal['start']."' AND '".$tanggal['end']."'");
        }
        $this->db->select("mst_idcard.nik,mst_idcard.nama,mst_idcard.transportasi,"
                . "mst_idcard.nomor,mst_idcard.nopol,tr_idcard.createddate,tr_idcard.checkin_date,tr_idcard.check_out,tr_idcard.status,tr_idcard.status_checkout");
        $this->db->join("mst_idcard" , "mst_idcard.id = tr_idcard.card_id","left");
//        $this->db->order_by("tr_idcard.createddate ASC"); 
        return $this->db->get_compiled_select($this->jointTable);
    }
   
}
