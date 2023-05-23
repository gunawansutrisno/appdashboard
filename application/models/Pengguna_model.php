<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pengguna_model extends CI_Model {

    var $table = "mst_users";
    var $primary_key = "id";

    public function __construct() {
        parent::__construct();
    }

    public function getDataIndex($offset = 0, $limit = 10, $search = "") {

         if (!empty($search)) {
            $this->db->like('username', $search);
        }
        $this->db->select('mst_users.id,mst_users.nama,'
                . 'mst_users.username,mst_users.status,mst_users.id_level,'
                . 'mst_users.password,mst_level.nama as jabatan,mst_company.code,mst_company.id as id_company');
        $this->db->from($this->table);
        $this->db->join('mst_level','mst_level.id = '.$this->table.'.id_level','left');
        $this->db->join('mst_company','mst_company.id = '.$this->table.'.id_company','left');
        $this->db->limit($limit);
        $this->db->offset($offset);
        $this->db->order_by($this->table . ".username ASC");
        $data = $this->db->get();
        return $data->result();
    }
  

    public function getDetail($id) {
        $this->db->where($this->primary_key, $id);
        $query = $this->db->get($this->table, 1);
        $resVal = "";
        if ($query->num_rows() > 0) {
            $resVal = $query->result_array();
        } else {
            $resVal = false;
        }
        return $resVal;
    }
    
    public function getByLevel($id) {
        $this->db->where('id_level', $id);
        $query = $this->db->get($this->table, 1);
        $resVal = "";
        if ($query->num_rows() > 0) {
            $resVal = $query->result_array();
        } else {
            $resVal = false;
        }
        return $resVal;
    }

    public function getCountDataIndex($search = "") {
        if (!empty($search)) {
            $this->db->like('nama', $search);
        }
        $this->db->select($this->table . '.* ');
        $this->db->from($this->table);
        $data = $this->db->count_all_results();
        return $data;
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

    public function updateDetail($array, $id) {

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
                
                if($filename == 'document'){
                    $config['upload_path'] = './assets/file/document/';
                }
                if($filename == 'foto'){
                    $config['upload_path'] = './assets/img/';
                }
		$config['allowed_types'] = '*';
		$config['overwrite'] = true;
		$config['file_name'] = '';
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
