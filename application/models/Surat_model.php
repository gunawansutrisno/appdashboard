<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Surat_model extends CI_Model {

    var $table = "mst_surat";
    var $primary_key = "id";
    var $jointTable = "mst_surat";

    public function __construct() {
        parent::__construct();
    }

    public function getDataMainMenu() {
        $ret = $this->db->select('*')
                        ->from('mst_menu')
                        ->get()->result();
        return $ret;
    }
    public function getCompany(){
        $dat = $this->db->select('*')
        ->from('mst_company')->get()->result();
        return $dat ;
    }
     public function getData() {
		 $this->db->select("
            mst_surat.id,
            mst_surat.judul,
            mst_surat.revisi,
            mst_surat.status,
            mst_surat.deskripsi,
            mst_surat.createddate,
            mst_surat.updateddate,
            mst_menu.nama as menu,
            mst_submenu.nama as submenu,
            mst_company.code,
        ");
        
        $this->db->join('mst_menu','mst_menu.id = mst_surat.menu_id','left');
        $this->db->join('mst_submenu', 'mst_submenu.id = mst_surat.submenu_id','left');
        $this->db->join('mst_company','mst_company.id = mst_surat.plant','left');
        return $this->db->get_compiled_select($this->table);
    }
    public function checkData($id='') {

        $ret = $this->db->select('a.*,b.nama as submenu')
                        ->from('mst_surat a')
                        ->join('mst_submenu b','b.id = a.submenu_id','left')
                        ->where('a.id',$id)
                        ->get()->row();
        return $ret;
    }
    public function check($id='') {

        $ret = $this->db->select('*')
                        ->from('mst_surat')
//                        ->join('mst_submenu b','b.id = a.submenu_id','left')
                        ->where('id',$id)
                        ->get()->row();
        return $ret;
    }
     public function checkGetSum($id='') {

        $this->db->select('COUNT(menu_id) as jumlah', FALSE);         
        $this->db->where('menu_id',$id);
        $query = $this->db->get('mst_surat'); 
        $t = $query->row();
        return $t->jumlah;  
    }
    public function delete($id) {
//        echoPre($id);exit;
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
    function kabupaten($provId) {

        $kabupaten = "<option value='0'>-- Pilih --</pilih>";
        $this->db->order_by('nama', 'ASC');
        $kab = $this->db->get_where('mst_submenu', array('menu_id' => $provId));
        foreach ($kab->result_array() as $data) {
            $kabupaten.= "<option value='$data[id]'>" . strtoupper($data[nama]) . "</option>";
        }
        return $kabupaten;
    }
     public function saveDataSiswa($arrData = array(), $debug = false) {

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
        return $retVal;
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
}
