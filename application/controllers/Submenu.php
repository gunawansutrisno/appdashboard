<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Submenu extends MY_Controller {

    var $meta_title = "MOLINDO INCORPORATED | Sub Menu";
    var $meta_desc = "MOLINDO INCORPORATED";
    var $main_title = "Data Sub Menu";
    var $base_url = "";
    var $upload_dir = "";
    var $upload_url = "";
    var $limit = "10";

    public function __construct() {
        parent::__construct();
        $this->base_url = $this->base_url_site . "submenu/";
        $this->load->model("Submenu_model");
        $this->load->model("menu_model");
    }
    public function index() {
        $user_data =  $this->session->get_userdata();
        $id_session = $user_data['user_id'];
        $status_session = $user_data['user_status'];
        if(empty($id_session || $status_session)){
             redirect();
        }
        $dt = array(
            "title" => $this->meta_title,
            "description" => $this->meta_desc,
            "container" => $this->_home(),
            "custom_js" => array(
                ASSETS_JS_URL . "form/submenu.js",
                ASSETS_URL . "plugins/datatables/jquery.dataTables.min.js",
                ASSETS_URL . "plugins/datatables/dataTables.bootstrap.min.js",
                ASSETS_URL . "plugins/datepicker/bootstrap-datepicker.js",
                ASSETS_URL . "plugins/daterangepicker/moment.min.js",
                ASSETS_URL . "plugins/daterangepicker/daterangepicker.js",
                ASSETS_URL . "plugins/select2/select2.full.min.js",
            ),
            "custom_css" => array(
                ASSETS_URL . "plugins/datepicker/datepicker3.css",
                ASSETS_URL . "plugins/daterangepicker/daterangepicker.css",
                ASSETS_URL . "plugins/datatables/dataTables.bootstrap.css",
                ASSETS_URL . "plugins/select2/select2.min.css",
            ),
        );
        $this->_render("default", $dt);
    }

    private function _home() {
        $page = isset($_REQUEST["page"]) ? $_REQUEST["page"] : 1;
        $search = isset($_REQUEST["search"]) ? $_REQUEST["search"] : "";
        $start = ($page - 1) * $this->limit;
        $provinsi = isset($_REQUEST["code"]) ? $_REQUEST["code"] : "";
        $data = $this->Submenu_model->getDataIndex($start, $this->limit, $search);
        $countTotal = $this->Submenu_model->getCountDataIndex($search);
        $arrBreadcrumbs = array(
            "Master Data" => base_url(),
            "Sub Menu" => $this->base_url,
            "List" => "#",
        );
        $dt["breadcrumbs"] = $this->setBreadcrumbs($arrBreadcrumbs);
        $dt["title"] = $this->main_title;
        $dt["data"] = $data;
        $dt['menu'] = $this->menu_model->Getall();        
        $dt["pagination"] = $this->_build_pagination($this->base_url, $countTotal, $this->limit, true, "&search=" . $search);
        $dt["base_url"] = $this->base_url;
        $ret = $this->load->view("submenu/content", $dt, true);
        return $ret;
    }
    public function ajax_list() {
        $post = $this->input->post();
        $nama = $post['IDprovinsi'];
         
        $list = $this->Submenu_model->get_datatables($nama);
//        echoPre($this->db->last_query());exit;
        $data = array();
        $no = 0;
        foreach ($list as $dt) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $dt->dashboard;
            $row[] = $dt->nama;
//            <a href="#" onclick="loadData(' . "'" . $this->base_url . 'edit/' . $dt->id . "'" . ')">' . $dt->name . '</a>
            $row[] = '<a href="#" onclick="loadData(' . "'" . $this->base_url . 'edit/' . $dt->id . "'" . ')" class="btn btn-warning btn-flat" title="Edit"><span class="glyphicon glyphicon-pencil"></span></a>'
                    . '<a href="javascript:void(0)" onclick="deleteData(' . "'" . $dt->id . "'" . ')" class="btn btn-danger btn-flat" title="Delete" data-toggle="modal" data-target="#delete-data"><span class="glyphicon glyphicon-trash"></span></a>';
            $data[] = $row;
        }

        $output = array(
//            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Submenu_model->count_all(),
            "recordsFiltered" => $this->Submenu_model->count_filtered($nama),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
    public function edit($term_id) {
        header('Content-Type: application/json');
        $data = $this->Submenu_model->getDetail($term_id);
        $resData = $data[0];
        echo json_encode($resData);
    }
     public function save() {
        $id = isset($_POST["id"]) ? trim($_POST["id"]) : '';
        $alert = $this->_saveData($id);
        $this->session->set_flashdata("alert_pelanggaran", $alert);
        redirect($this->base_url);
    }
    private function _saveData($id = '') {
         $user_data =  $this->session->get_userdata();
        $id_session = $user_data['user_id'];
        if(empty($id_session)){
             redirect();
        }
        $code = isset($_POST["nama"]) ? trim($_POST["nama"]) : '';
        $menu_id = isset($_POST["menu_id"]) ? trim($_POST["menu_id"]) : '';
        $return = array(
            "status" => "failed",
            "message" => "Failed to save Sub Menu. Please try again."
        );
        $cek = $this->Submenu_model->check($code, $menu_id);
        
        // update category
        if (!empty($code)) {
            if (!empty($id)) {
                $edit = array(
                    "nama" => $code,
                    "menu_id" => $menu_id,
                );
                $res = $this->Submenu_model->updateDetail($edit, $id);
                if ($res['status'] == true) {
                    $return = array(
                        "status" => "success",
                        "message" => "Success to update Sub Menu $code."
                    );
                }
            }
            // insert category
            else {
                if(!empty($cek)){
                    $return = array(
                        "status" => "failed",
                        "message" => "Failed to save, The data you Entered Is Already Registered. Please try again."
                    );
                } else {
                $insert = array(
                   "nama" => $code,
                   "menu_id" => $menu_id,
                   "createddate" => date('Y-m-d H:i:s'),
                   "createdby" => $id_session,
                );
                $res = $this->Submenu_model->saveData($insert);
                if ($res['status'] == true) {
                        $return = array(
                            "status" => "success",
                            "message" => "Success to save Sub Menu $code ."
                        );
                    }
                }
            }
        }
        return $return;
    }
 public function delete($id) {
        $del_author = $this->Submenu_model->delete($id);
        $del_author['status'];
        if ($del_author['status']) {
            $alert = array(
                "status" => "success",
                "message" => "Success to delete Data Jenis Index."
            );
        } else {
            $alert = array(
                "status" => "failed",
                "message" => "Failed to delete Data Jenis Index."
            );
        }

        $this->session->set_flashdata("alert_pelanggaran", $alert);
        redirect($this->base_url);
    }
}

