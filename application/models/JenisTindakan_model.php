<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class JenisTindakan_model extends CI_Model {

    var $table = "mst_jenis_tindakan_op";
    var $primary_key = "id";
    var $column_order = array('name', 'name', null);
//	var $column_search = array('txtProvinsi','txtKabupaten'); 
    var $order = array('name' => 'desc');

    public function __construct() {
        parent::__construct();
    }
    public function check(){

        $ret = $this->db->select('*')
                ->from($this->table)
                ->where('status =',1)
                ->get()->result();
        return $ret;
    }
    public function getDataIndex($offset = 0, $limit = 10, $search = "") {

        if (!empty($search)) {
            $this->db->like('name', $search);
        }
        $this->db->select($this->table . '.* ');
        $this->db->from($this->table);
        if ($limit != "all") {
            $this->db->limit($limit);
        }
        $this->db->offset($offset);
        $this->db->order_by($this->table . ".name ASC");
        $this->db->where($this->table.".status =",1);
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

    public function getCountDataIndex($search = "") {
        if (!empty($search)) {
            $this->db->like('name', $search);
        }
        $this->db->select($this->table . '.* ');
        $this->db->from($this->table);
         $this->db->where($this->table.".status =",1);
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
    private function _get_datatables_query() {
        $this->db->select($this->table . '.*,
       id,name');
        $this->db->from($this->table);
        $i = 0;


        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    function get_datatables($nama = "") {
        $this->_get_datatables_query();
        $this->db->order_by('mst_jenis_tindakan_op.name ASC');
         $this->db->where($this->table.".status =",1);
        if (!empty($nama)) {
            $this->db->like("mst_jenis_tindakan_op.name", $nama);
        }
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        
        $query = $this->db->get();
        return $query->result();
    }
    function getdataSiswa($idnama = "") {
        $this->_get_datatabless_query();
        $this->db->order_by('mst_jenis_tindakan_op.name ASC');
        if (!empty($nama)) {
            $this->db->like("mst_jenis_tindakan_op.name", $nama);
        }
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
         $this->db->where($this->table.".status =",1);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($nama = "") {
        $this->_get_datatables_query();
        if (!empty($nama)) {
            $this->db->like("mst_jenis_tindakan_op.name", $nama);
        }
        $this->db->where('mst_jenis_tindakan_op.status =',1);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function count_all() {
        $this->db->from($this->table);
        $this->db->where('mst_jenis_tindakan_op.status =',1);
        return $this->db->count_all_results();
    }
}
