<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Article_model extends CI_Model {

    var $table = "mst_surat";
    var $primary_key = "id";
//    var $column_order = array('judul', 'nama', null);
//    var $order = array('nama' => 'desc');

    public function __construct() {
        parent::__construct();
    }
    public function Getdata($id){

        $ret = $this->db->select('mst_submenu.*,mst_menu.bg')
                ->from('mst_submenu')
                ->join('mst_menu','mst_menu.id = mst_submenu.menu_id','left')
                ->where('menu_id',$id)
                ->get()->result();
        return $ret;
    }
    public function getCek($id=""){

        $ret = $this->db->select('count(id) as sum')
                ->from('mst_surat')
                ->where('submenu_id',$id)
                ->get()->row();
        return $ret;
    }
    
    public function getCekURL($id=""){

        $ret = $this->db->select('*')
                ->from('mst_menu')
                ->where('id',$id)
                ->get()->row();
        return $ret;
    }
    public function checkD($id=""){

        $ret = $this->db->select('*')
                ->from('mst_submenu')
                ->where('nama',$id)
                ->get()->result();
        return $ret;
    }
    public function getDataFile($id="",$bulan="",$tahun=""){
        $ret = $this->db->select('*')
            ->from('mst_surat')
            ->where('submenu_id',$id)
            ->where('bulan',$bulan)
            ->where('tahun',$tahun)
            ->get()->result();
        return $ret;
    }
    public function getCekD($id=""){

        $ret = $this->db->select('*')
                ->from('mst_surat')
                ->where('id',$id)
                ->get()->row();
        return $ret;
    }
    public function count_all() {
        $this->db->from('mst_surat');
        return $this->db->count_all_results();
    }
    function count_filtered() {
        $this->_get_datatables_query();
        // if (!empty($nama)) {
        //     $this->db->like("mst_company.code", $nama);
        // }
        $query = $this->db->get();
        return $query->num_rows();
    }
    private function _get_datatables_query() {
        $this->db->select('*');
        $this->db->from('mst_surat');
        $i = 0;


        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    // function get_datatables($id="",$bulan="",$tahun="") {
    //     $this->_get_datatables_query();
    //     $this->db->order_by('mst_surat.bulan ASC');
    //     $this->db->where("mst_surat.submenu_id", $id);
    //     $this->db->where("mst_surat.bulan", $bulan);
    //     $this->db->where("mst_surat.tahun", $tahun);
        
        
    //     $query = $this->db->get();
    //     return $query->result();
    // }

}
