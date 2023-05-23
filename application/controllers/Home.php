<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

    var $meta_title = "MOLINDO INCORPORATED | Home";
    var $meta_desc = "MOLINDO INCORPORATED";
    var $main_title = "Home";
    var $base_url = "";
    var $upload_dir = "";
    var $upload_url = "";
    var $limit = "10";

    public function __construct() {
        parent::__construct();
        $this->base_url = $this->base_url_site . "home/";
        $this->load->model("menu_model");
        $this->load->model("surat_model");
    }

    public function index() {
        
        $user_data =  $this->session->get_userdata();
        $id_session = $user_data['user_id'];
       
        $status_session = $user_data['user_status'];
        if(empty($id_session)){
             redirect();
        }
        $dt = array(
            "title" => $this->meta_title,
            "cms_title" => $this->meta_desc,
            "description" => $this->meta_desc,
            "container" => $this->_home(),
            "custom_js" => array(
                ASSETS_JS_URL . "form/home.js",
               ASSETS_URL . "plugins/chart.js/chart.js",
            ),
        );
        
        $this->_render("default", $dt);
        
    }
    
    private function _home() {
        
        $arrBreadcrumbs = array(
            "Home" => base_url(),
            "Dashboard" => $this->base_url,
        );
//        $data = $this->pasien_model->getdata();
//        $dt['surat_masuk'] = $this->pasien_model->getcountsuratmasuk(); 
//        $dt['surat_keluar'] = $this->pasien_model->getcountsuratkeluar(); 
        $dt['menu'] = $this->menu_model->Getall(); 
//        $dt['data'] = json_encode($data); 
        $dt["menu_list"] = $this->config->item('menu_list');
        $dt["breadcrumbs"] = $this->setBreadcrumbs($arrBreadcrumbs);
        $dt["title"] = $this->main_title;
        $dt["base_url"] = $this->base_url;
        $ret = $this->load->view("home/content", $dt, True);
        return $ret;
       
    }

}
