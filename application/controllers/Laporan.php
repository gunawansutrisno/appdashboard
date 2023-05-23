<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends MY_Controller {

    var $meta_title = "APPMOLINDO | Laporan Keuangan";
    var $meta_desc = "APPMOLINDO";
    var $main_title = "Laporan Keuangan";
    var $base_url = "";
    var $upload_dir = "";
    var $upload_url = "";
    var $limit = "10";

    public function __construct() {
        parent::__construct();
        $this->base_url = $this->base_url_site . "laporan";
        $this->load->model("laporan_model");
    }
    public function index() {
        $user_data = $this->session->get_userdata();
        $id_session = $user_data['user_id'];
        $status_session = $user_data['user_status'];
        if(empty($id_session || $status_session)){
             redirect();
        }
        $dt = array(
            "title" => $this->meta_title,
            "description" => $this->meta_desc,
            "container" => $this->_home_index(),
            "custom_js" => array(
                ASSETS_JS_URL . "form/laporanoprasi.js",
                ASSETS_URL . "plugins/select2/select2.full.min.js", 
                ASSETS_URL . "plugins/datatables/jquery.dataTables.min.js",
                ASSETS_URL . "plugins/datatables/dataTables.bootstrap.min.js",
                ASSETS_URL . "plugins/datepicker/bootstrap-datepicker.js",                
                ASSETS_URL . "plugins/daterangepicker/moment.min.js",
                ASSETS_URL . "plugins/daterangepicker/daterangepicker.js",
            ),
            "custom_css" => array(
                ASSETS_URL . "plugins/select2/select2.min.css",
                ASSETS_URL . "plugins/datepicker/datepicker3.css",
                ASSETS_URL . "plugins/daterangepicker/daterangepicker.css",
                ASSETS_URL . "plugins/datatables/dataTables.bootstrap.css",
            ),
        );
        
        $this->_render("default", $dt);
    }
    private function _home_index(){
        
        $tahun = isset($_POST["tahun"]) ? $_POST["tahun"] : "";
        $bulan = isset($_POST["bulan"]) ? $_POST["bulan"] : "";
       
        $url = $this->base_url_site."laporan/";
        $arrBreadcrumbs = array(
            "Laporan" => base_url(),
            "Data Keuangan" => $url,
            "Form" => "#",
        );
        if(!empty($tahun) || !empty($bulan)){
             $neraca = $this->laporan_model->getKeuanganneraca($bulan,$tahun);
            if(empty($neraca)){
                 $alert = array(
                        "status" => "failed",
                        "message" => "No matching records found. Please try again."
                    );
                $this->session->set_flashdata("alert_laporan", $alert);
                redirect($this->base_url);
            }
            $dt["neraca"] = $neraca;
//             $dt["data"] = $data;
        }
       
        $dt["breadcrumbs"] = $this->setBreadcrumbs($arrBreadcrumbs);
        $dt["title"] = "Laporan Neraca";
        $dt['bulan'] = $bulan;
        $dt['tahun'] = $tahun;
        $dt["base_url"] = $url;
        $ret = $this->load->view("laporan/laporan_index", $dt, true);
        return $ret;
    }
     public function export(){
        $tahun = isset($_POST["tahun"]) ? $_POST["tahun"] : "";
        $bulan = isset($_POST["bulan"]) ? $_POST["bulan"] : "";
        $dt['bulan'] = $bulan;
        $dt['tahun'] = $tahun;
        $url = $this->base_url_site."laporan/";
        $rl = $this->laporan_model->getKeuanganneraca($bulan,$tahun);
//        echoPre($rl);exit
        $dt["neraca"] = $rl;
//        echoPre($dt["keuangan"]);exit;
        $dt["title"] = "Laporan Neraca";
        $dt["base_url"] = $url;
        $ret = $this->load->view("laporan/neraca_pdf", $dt);
        return $ret;
    }

}
