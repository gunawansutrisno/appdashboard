<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Idcard_model extends CI_Model {

    var $table = "mst_idcard";
    var $primary_key = "id";
    var $jointTable = "mst_idcard";

    public function __construct() {
        parent::__construct();
    }

    public function All($id = "") {
        $ret = $this->db->select('*')
                        ->from($this->table)
                        ->get()->result_array();
        return $ret;
    }
    public function checkEdit($id = "") {
        $ret = $this->db->select('*')
                        ->from($this->table)
                        ->where($this->table.'.id', $id)
                        ->get()->row_array();
        return $ret;
    }
    public function CekData($id = "") {
        $ret = $this->db->select('*')
                        ->from($this->table)
                        ->where($this->table.'.nik', $id)
                        ->get()->row();
        return $ret;
    }
    public function checkdata($id = "") {
        $ret = $this->db->select('*')
                        ->from('mst_email')
                        ->get()->row_array();
        return $ret;
    }
    public function getCekIdcard($id = "") {
        $ret = $this->db->select('a.*')
                        ->from($this->table.' a')
//                        ->join('tr_idcard b','b.card_id = a.id','left')
                        ->where('a.nik', $id)
                        ->get()->row_array();
        return $ret;
    }
    public function getCekIdcard_tr($id = "") {
        $ret = $this->db->select('*')
                        ->from('tr_idcard')
                        ->where('card_id', $id)
                        ->order_by('id desc')
                        ->get()->row_array();
        return $ret;
    }
    public function cekTr($id="") {
        $ret = $this->db->select('*')
                        ->from('tr_idcard')
                        ->where('card_id', $id)
                        ->get()->row_array();
        return $ret;
    }
    public function getDataPrint($get = "",$surat="",$tahun="",$kop="") {
         
        $ret = $this->db->select('*')
                        ->from($this->table)
                        ->where($this->table.'.no', $get)
                        ->get()->result_array();
        return $ret;
    }
    public function upload_file_ktp(){
         
                $this->load->library('upload'); // Load librari upload
                
                $config['upload_path'] = './assets/img/idcard/';
		$config['allowed_types'] = '*';
		$config['overwrite'] = true;
		$config['file_name'] = '';
                $this->upload->initialize($config); // Load konfigurasi uploadnya
                if($this->upload->do_upload('file_ktp')){ // Lakukan upload dan Cek jika proses upload berhasil
			// Jika berhasil :
			$return = array('result' => 'success', 'file_ktp' => $this->upload->data(), 'error' => '');
			return $return;
		}else{
			// Jika gagal :
			$return = array('result' => 'failed', 'file_ktp' => '', 'error' => $this->upload->display_errors());
			return $return;
		}
	}
            public function check($id) {

        $ret = $this->db->select('*')
                        ->from($this->table)
                        ->where('id', $id)
                        ->get()->row();
        return $ret;
    }
    public function upload_file_images(){
         
                $this->load->library('upload'); // Load librari upload
                
                $config['upload_path'] = './assets/img/idcard/';
		$config['allowed_types'] = '*';
		$config['overwrite'] = true;
		$config['file_name'] = '';
                $this->upload->initialize($config); // Load konfigurasi uploadnya
                if($this->upload->do_upload('file_images')){ // Lakukan upload dan Cek jika proses upload berhasil
			// Jika berhasil :
			$return = array('result' => 'success', 'file_images' => $this->upload->data(), 'error' => '');
			return $return;
		}else{
			// Jika gagal :
			$return = array('result' => 'failed', 'file_images' => '', 'error' => $this->upload->display_errors());
			return $return;
		}
	}
    public function getDataPasien($nama = "") {
		
        $this->db->order_by('id ASC');
        return $this->db->get_compiled_select($this->table);
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
        return $retVal;
    }
    public function saveDataCheck($arrData = array(), $debug = false) {

        $this->db->set($arrData);
        if ($debug) {
            $retVal = $this->db->get_compiled_insert('tr_idcard');
        } else {
            $res = $this->db->insert('tr_idcard');
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

    public function saveUpdateCheck($array, $id) {

        $this->db->where('id', $id);
        $query = $this->db->update('tr_idcard', $array);
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

    public function getKategori() {

        $ret = $this->db->select('*')
                        ->from('mst_jenis_index')
                        ->get()->result();
        return $ret;
    }

    public function delete($id) {
      
        
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
    public function upload_file($filename){
        $this->load->library('upload'); // Load librari upload
		
		$config['upload_path'] = './excel/';
		$config['allowed_types'] = 'xlsx';
		$config['max_size']	= '20480';
		$config['overwrite'] = true;
		$config['file_name'] = $filename;
	
		$this->upload->initialize($config); // Load konfigurasi uploadnya
        
		if($this->upload->do_upload('file')){ // Lakukan upload dan Cek jika proses upload berhasil
			// Jika berhasil :
			$return = array('result' => 'success', 'file' => $this->upload->data(), 'error' => '');
			return $return;
		}else{
			// Jika gagal :
			$return = array('result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors());
			return $return;
		}
	}
}
