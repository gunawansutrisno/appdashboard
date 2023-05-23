<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Level extends MY_Controller {

    var $meta_title = "MOLINDO INCORPORATED | Level";
    var $meta_desc = "MOLINDO INCORPORATED";
    var $main_title = "Data Level";
    var $base_url = "";
    var $upload_dir = "";
    var $upload_url = "";
    var $limit = "10";

    public function __construct() {
        parent::__construct();
        $this->base_url = $this->base_url_site . "level/";
        $this->load->model("level_model");
        $this->load->model("levelmenu_model");
        $this->load->model("pengguna_model");
    }

    public function index() {
        $dt = array(
            "title" => $this->meta_title,
            "description" => $this->meta_desc,
            "container" => $this->_home(),
            "custom_js" => array(
                ASSETS_JS_URL . "form/level.js",
            ),
        );
        $this->_render("default", $dt);
    }

    public function save() {
        $id = isset($_POST["id"]) ? trim($_POST["id"]) : '';
        $alert = $this->_saveData($id);
        $this->session->set_flashdata("alert_level", $alert);
        redirect($this->base_url);
    }

    public function delete($id) {
        $pengguna = $this->pengguna_model->getByLevel($id);
//        echoPre($pengguna);exit;
        if($pengguna <= 0){
            $del_author = $this->level_model->delete($id);
            $del_author['status'];
            if ($del_author['status']) {
                $res = $this->levelmenu_model->delete($id);
                $alert = array(
                    "status" => "success",
                    "message" => "Success to delete level."
                );
            } else {
                $alert = array(
                    "status" => "failed",
                    "message" => "Failed to delete level. Please try again."
                );
            }
        }
        else{
            $alert = array(
                    "status" => "failed",
                    "message" => "Failed to delete level. There are penggua using this level."
                );
        }

        $this->session->set_flashdata("alert_level", $alert);
        redirect($this->base_url);
    }

    public function edit($term_id) {
        header('Content-Type: application/json');
        $data = $this->level_model->getDetail($term_id);
        $dataMen = array("allowed_menu" => $this->levelmenu_model->getDataIndex(0, 'all', $term_id));
        $resData = array_merge($data[0],$dataMen);
        echo json_encode($resData);
    }

    private function _home() {
        $page = isset($_REQUEST["page"]) ? $_REQUEST["page"] : 1;
        $search = isset($_REQUEST["search"]) ? $_REQUEST["search"] : "";
        $start = ($page - 1) * $this->limit;

        $data = $this->level_model->getDataIndex($start, $this->limit, $search);
        $countTotal = $this->level_model->getCountDataIndex($search);
        $arrBreadcrumbs = array(
            "Home" => base_url(),
            "Level" => $this->base_url,
            "List" => "#",
        );
        $dt["breadcrumbs"] = $this->setBreadcrumbs($arrBreadcrumbs);
        $dt["title"] = $this->main_title;
        $dt["data"] = $data;
        $dt["menu_list"] = $this->config->item('menu_list');
//        echopre($dt["menu_list"]);exit;
        $dt["menu_default"] = $this->config->item('menu_default'); 
        $dt["pagination"] = $this->_build_pagination($this->base_url, $countTotal, $this->limit, true, "&search=" . $search);
        $dt["base_url"] = $this->base_url;
        $ret = $this->load->view("level/content", $dt, true);
        return $ret;
    }

    private function _saveData($id = '') {

        $level = isset($_POST["nama"]) ? trim($_POST["nama"]) : '';
        $allowed_menu = isset($_POST["allowed_menu"]) ? ($_POST["allowed_menu"]) : '';
        $allowed_menu = array_merge($allowed_menu,$this->config->item('menu_default'));

        $return = array(
            "status" => "failed",
            "message" => "Failed to save Gudang. Please try again."
        );
        $cek = $this->levelmenu_model->check($level);
        // update 
        if (!empty($level) ) {
            if (!empty($id)) {
                $edLevel = array(
                    "nama" => $level
                );
                $res = $this->level_model->updateDetail($edLevel, $id);
                if ($res['status'] == true) {
                    $return = array(
                        "status" => "success",
                        "message" => "Success to update Level."
                    );
                    $res = $this->levelmenu_model->delete($id);
                    if ($res['status'] == true) {
                        foreach ($allowed_menu as $am){
                            $inLevel = array(
                                "id_level" =>  $id,
                                "menu" => $am,
                                "is_insert" => 1,
                                "is_update" => 1,
                                "is_delete" => 1,
                            );

                            $resLev = $this->levelmenu_model->saveData($inLevel);
                        }
                    }
                    
                }
            }
            // insert 
            else {
                if(!empty($cek)){
                     $return = array(
                        "status" => "failed",
                        "message" => "Failed to save, The data you Entered Is Already Registered. Please try again."
                    );
                }else {
                $inLevel = array(
                    "nama" => $level
                );

                $res = $this->level_model->saveData($inLevel);
                if ($res['status'] == true) {
                    $return = array(
                        "status" => "success",
                        "message" => "Success to save Level."
                    );
//                    $id = $res['id'];
//                    foreach ($allowed_menu as $am){
//                        $inLevel = array(
//                            "id_level" =>  $id,
//                            "menu" => $am,
//                            "is_insert" => 1,
//                            "is_update" => 1,
//                            "is_delete" => 1,
//                        );
//                       
//                        $resLev = $this->levelmenu_model->saveData($inLevel);
                    }
                }
            }
        }
        return $return;
    }

}
