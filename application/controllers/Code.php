<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Code extends MY_Controller {

    var $meta_title = "MOLINDO INCORPORATED | Code Perusahaan";
    var $meta_desc = "MOLINDO INCORPORATED";
    var $main_title = "Data Nama Perusahaan";
    var $base_url = "";
    var $upload_dir = "";
    var $upload_url = "";
    var $limit = "10";

    public function __construct() {
        parent::__construct();
        $this->base_url = $this->base_url_site . "code/";
        $this->load->model("code_model");
//        $this->load->model("siswa_model");
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
                ASSETS_JS_URL . "form/icd.js",
                ASSETS_URL . "plugins/datatables/jquery.dataTables.min.js",
                ASSETS_URL . "plugins/datatables/dataTables.bootstrap.min.js",
                ASSETS_URL . "plugins/datepicker/bootstrap-datepicker.js",
                ASSETS_URL . "plugins/daterangepicker/moment.min.js",
                ASSETS_URL . "plugins/daterangepicker/daterangepicker.js",
            ),
            "custom_css" => array(
                ASSETS_URL . "plugins/datepicker/datepicker3.css",
                ASSETS_URL . "plugins/daterangepicker/daterangepicker.css",
                ASSETS_URL . "plugins/datatables/dataTables.bootstrap.css",
            ),
        );
        $this->_render("default", $dt);
    }

    private function _home() {
        $page = isset($_REQUEST["page"]) ? $_REQUEST["page"] : 1;
        $search = isset($_REQUEST["search"]) ? $_REQUEST["search"] : "";
        $start = ($page - 1) * $this->limit;
        $provinsi = isset($_REQUEST["code"]) ? $_REQUEST["code"] : "";
        $data = $this->code_model->getDataIndex($start, $this->limit, $search);
        $countTotal = $this->code_model->getCountDataIndex($search);
        $arrBreadcrumbs = array(
            "Master Data" => base_url(),
            "Perusahaan" => $this->base_url,
            "List" => "#",
        );
        $dt["breadcrumbs"] = $this->setBreadcrumbs($arrBreadcrumbs);
        $dt["title"] = $this->main_title;
        $dt["data"] = $data;
        
        $dt["pagination"] = $this->_build_pagination($this->base_url, $countTotal, $this->limit, true, "&search=" . $search);
        $dt["base_url"] = $this->base_url;
        $ret = $this->load->view("company/content", $dt, true);
        return $ret;
    }
    
    public function ajax_list() {
        $post = $this->input->post();
        $nama = $post['IDprovinsi'] ? $post['IDprovinsi'] : '';
        $list = $this->code_model->get_datatables($nama);
        $data = array();
        $no = 0;
        foreach ($list as $dt) {
            $no++;
            $row = array();
            $row[] =  $no;
            $row[] =  $dt->code;
            $row[] = $dt->in_bahasa;
            $row[] = '<a href="#" onclick="loadData(' . "'" . $this->base_url . 'edit/' . $dt->id . "'" . ')" class="btn btn-warning btn-flat" title="Edit"><span class="glyphicon glyphicon-pencil"></span></a>'
                    . '<a href="javascript:void(0)" onclick="deleteData(' . "'" . $dt->id . "'" . ')" class="btn btn-danger btn-flat" title="Delete" data-toggle="modal" data-target="#delete-data"><span class="glyphicon glyphicon-trash"></span></a>';
            $data[] = $row;
        }
        $output = array(
//            "draw" => $_POST['draw'],
            "recordsTotal" => $this->code_model->count_all(),
            "recordsFiltered" => $this->code_model->count_filtered($nama),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
    public function edit($term_id) {
        header('Content-Type: application/json');
        $data = $this->code_model->getDetail($term_id);
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
        $code = isset($_POST["code"]) ? trim($_POST["code"]) : '';
        $in_bahasa = isset($_POST["in_bahasa"]) ? trim($_POST["in_bahasa"]) : '';
        $return = array(
            "status" => "failed",
            "message" => "Failed to save Data Perusahaan. Please try again."
        );
        $cek = $this->code_model->check($code);
        // update category
        if (!empty($code)) {
            if (!empty($id)) {
                $edit = array(
                    "code" => $code,
                     "in_bahasa" =>  $in_bahasa,
                );

                $res = $this->code_model->updateDetail($edit, $id);
                if ($res['status'] == true) {
                    $return = array(
                        "status" => "success",
                        "message" => "Success to update Data Perusahaan $code $in_bahasa."
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
                       "code" => $code,
                         "in_bahasa" =>  $in_bahasa,
                    );
                $res = $this->code_model->saveData($insert);
                    if ($res['status'] == true) {
                        $return = array(
                            "status" => "success",
                            "message" => "Success to save Perusahaan $code $in_bahasa."
                        );
                    }
                }
            }
        }
        return $return;
    }
 public function delete($id) {
        $del_author = $this->code_model->delete($id);
        $del_author['status'];
        if ($del_author['status']) {
            $alert = array(
                "status" => "success",
                "message" => "Success to delete Data Perusahaan."
            );
        } else {
            $alert = array(
                "status" => "failed",
                "message" => "Failed to delete Data Perusahaan."
            );
        }

        $this->session->set_flashdata("alert_pelanggaran", $alert);
        redirect($this->base_url);
    }
}

