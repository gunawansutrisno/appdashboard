<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Articles extends MY_Controller {

    var $meta_title = "MOLINDO INCORPORATED | Kontak";
    var $meta_desc = "MOLINDO INCORPORATED ";
    var $main_title = "Dashboard";
    var $base_url = "";
    var $redirect = "";
    var $upload_dir = "";
    var $upload_url = "";
    var $limit = "10";

    public function __construct() {
        parent::__construct();
        $this->redirect = $this->base_url_site . "article";
        $this->base_url = $this->base_url_site . "article";
        $this->load->model("menu_model");
        $this->load->model("article_model");
        $this->load->helper('url');
    }

    
    public function getDataview() {
        $user_data = $this->session->get_userdata();
        $id_session = $user_data['user_level'];
        $id = $_POST['rowid'];
        $data = $this->article_model->getCekD($id);
        // echopre($data);exit;
        $dt['data'] = $data;
        $dt['session'] = $id_session;
        $ret = $this->load->view("surat/detail", $dt);
    }
    public function ajax_list() {
         
        $post = $this->input->post();
        $tahun = isset($_POST["tahun"]) ? $_POST["tahun"] : "";
        $bulan = isset($_POST["bulan"]) ? $_POST["bulan"] : "";
        $url = isset($_POST["url"]) ? $_POST["url"] : "";
        $dt['bulan'] = $bulan;
        $dt['tahun'] = $tahun;
        $dat = str_replace('-',' ',$url);
        $getid = $this->article_model->checkD($dat);
  
        $id = $getid[0]->id;
        // echopre($id);
        $list = $this->article_model->getDataFile($id,$bulan,$tahun);
        
        $data = array();
        $no = 0;
        foreach ($list as $dt) {
            $no++;
            $row = array();
            // $row[] =  $no;
            $row[] =  $dt->judul;
            $row[] = $dt->deskripsi;
            $row[] = date('d m Y',strtotime($dt->createddate));
            $row[] = '<a href="#"  data-id="'. $dt->id.'" class="btn btn-flat btn-success btn-sm" data-toggle="modal" data-target="#detail-data" title="Preview File PDF"><span class="glyphicon glyphicon-search"></span></a>';
            $data[] = $row;
        }
        $output = array(
            "recordsTotal" => $this->article_model->count_all(),
            "recordsFiltered" => $this->article_model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
}
