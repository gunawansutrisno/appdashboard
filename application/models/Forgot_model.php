<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Forgot_model extends CI_Model {

    var $table = "mst_users";
    var $primary_key = "id";

    public function __construct() {
        parent::__construct();
    }

    public function getDataIndex($offset = 0, $limit = 10, $search = "") {

         if (!empty($search)) {
            $this->db->like('email', $search);
        }
        $this->db->select('mst_users.id,mst_users.nama,'
                . 'mst_users.username,mst_users.status,mst_users.id_level,'
                . 'mst_users.password,mst_level.nama as jabatan');
        $this->db->from($this->table);
        $this->db->join('mst_level','mst_level.id = '.$this->table.'.id_level','left');
        $this->db->limit($limit);
        $this->db->offset($offset);
        $this->db->order_by($this->table . ".username ASC");
        $data = $this->db->get();
        return $data->result();
    }
  

    

}
