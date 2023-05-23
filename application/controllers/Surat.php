<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Surat extends MY_Controller {

    var $meta_title = "MOLINDO INCORPORATED | Manage File MasterData";
    var $meta_desc = "MOLINDO INCORPORATED";
    var $main_title = "Data ";
    var $base_url = "";
    var $upload_dir = "";
    var $upload_url = "";
    var $limit = "10";
    private $filename = "document";
    
    public function __construct() {
        parent::__construct();
        $this->base_url = $this->base_url_site . "surat/";
        $this->load->model("surat_model");
        $this->load->model("suratkeluar_model");
        $this->load->model("pengguna_model");
        
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
            "container" => $this->_home(),
            "custom_js" => array(
                ASSETS_JS_URL . "form/diagnostik.js",
                ASSETS_URL . "plugins/datatables/jquery.dataTables.min.js",
                ASSETS_URL . "plugins/datatables/dataTables.bootstrap.min.js",
                ASSETS_URL . "plugins/datatables/dataTables.responsive.js",
                ASSETS_URL . "plugins/select2/select2.full.min.js",
                ASSETS_URL . "plugins/validate/jquery.validate_1.11.1.min.js",
                ASSETS_URL . "plugins/datetimepicker/js/moment.js",
                ASSETS_URL . "plugins/datetimepicker/js/bootstrap-datetimepicker.min.js",
                ASSETS_URL . "plugins/autocomplete/js/jquery.autocomplete.js",
                ASSETS_URL . "plugins/daterangepicker/daterangepicker.js",
                ASSETS_URL . "plugins/datepicker/bootstrap-datepicker.js",
                ASSETS_URL . "plugins/ckeditor/ckeditor.js",
            ),
            "custom_css" => array(
                ASSETS_URL . "plugins/autocomplete/css/jquery.autocomplete.css",
                ASSETS_URL . "plugins/datepicker/datepicker3.css",
                ASSETS_URL . "plugins/daterangepicker/daterangepicker.css",
                ASSETS_URL . "plugins/datatables/dataTables.bootstrap.css",
                ASSETS_URL . "plugins/datatables/dataTables.responsive.css",
                ASSETS_URL . "plugins/select2/select2.min.css",
                ASSETS_URL . "plugins/datetimepicker/css/bootstrap-datetimepicker.min.css",
            ),
        );
        $this->_render("default", $dt);
    }

    public function save() {
        $id = isset($_POST["id"]) ? trim($_POST["id"]) : '';

        $alert = $this->_saveData($id);
        $this->session->set_flashdata("alert_diagnostik", $alert);
        redirect($this->base_url);
    }

    private function _home() {
          $user_data = $this->session->get_userdata();
        $id_session = $user_data['user_id'];
        $arrBreadcrumbs = array(
            "Manage" => base_url(),
            "File Dashboard" => $this->base_url,
            "List" => "#",
        );
        $dt["breadcrumbs"] = $this->setBreadcrumbs($arrBreadcrumbs);
        $dt["title"] = $this->main_title;
         $dt['session'] = $id_session;
        $dt['base_url'] = $this->base_url;
        $ret = $this->load->view("surat/add", $dt, true);
        return $ret;
    }

    private function _saveData($id = '') {
       $user_data =  $this->session->get_userdata();
        $id_session = $user_data['user_id'];
        $id = isset($_POST["id"]) ? trim($_POST["id"]) : '';
        $judul = isset($_POST["title"]) ? trim($_POST["title"]) : '';
        $status = isset($_POST["status"]) ? trim($_POST["status"]) : '';
        $kategori = isset($_POST["kategori"]) ? trim($_POST["kategori"]) : '';
        $subkategori = isset($_POST["subkategori"]) ? trim($_POST["subkategori"]) : '';
        $deskripsi = isset($_POST["deskripsi"]) ? trim($_POST["deskripsi"]) : '';
        $tahun = isset($_POST["tahun"]) ? trim($_POST["tahun"]) : '';
        $bulan = isset($_POST["bulan"]) ? trim($_POST["bulan"]) : '';
        $plant = isset($_POST['plant']) ? trim($_POST['plant']) : '';
        $return = array(
            "status" => "failed",
            "message" => "Failed to save Article. Please try again."
        );
        $file="";
        $upload = $this->pengguna_model->upload_file($this->filename);
       
              if ($upload['result'] == "success") { // Jika proses upload sukses
                 $file = $upload['file']['file_name'];

              } else { // Jika proses upload gagal
                  $data['upload_error'] = $upload['error']; // Ambil pesan error uploadnya untuk dikirim ke file form dan ditampilkan
              }
             
        // update 
            if (!empty($id)) {
                
//                update siswa
                $cek = $this->surat_model->check($id);
                $edSiswa = array(
                    "deskripsi" => $deskripsi,
                    "judul" => $judul,
                   "plant" => $plant,
                    "menu_id" => $kategori,
                    "submenu_id" => $subkategori,
                    "revisi" => $cek->revisi + 1,
                    "file" => $file,
                    "tahun" => $tahun,
                    "bulan" => $bulan,
                    "status" => $status,
                    "updateddate" => date('Y-m-d h:i:s'),
                    "updatedby" => $id_session,
                );
                if(empty($subkategori)){
                     unset($edSiswa['submenu_id']);
                }
                if(empty($file)){
                    unset($edSiswa['file']);
                } else {
                    unlink("./assets/file/document/$cek->file");
                }
//                 echoPre($edSiswa);exit;
              $res=  $this->surat_model->update($edSiswa, $id);
              if($res['status_cek'] == false){
                    $return = array(
                            "status" => "failed",
                            "message" => "Failed to save"
                        );
                }
                if ($res['status'] == true) {
                    $return = array(
                        "status" => "success",
                        "message" => "Success to update Master Data Article $judul."
                    );
                }
            }
            // insert 
            else {
                $edSiswa = array(
                    "deskripsi" => $deskripsi,
                    "judul" => $judul,
                    "plant" => $plant,
                    "menu_id" => $kategori,
                    "submenu_id" => $subkategori,
                    "file" => $file,
                    "tahun" => $tahun,
                    "bulan" => $bulan,
                    "status" => $status,
                    "createddate" => date('Y-m-d h:i:s'),
                    "createdby" => $id_session,
                );
//                echopre($edSiswa);exit;
                $ids = $this->surat_model->saveDataSiswa($edSiswa);
                if($ids['status_cek'] == false){
                    $return = array(
                            "status" => "failed",
                            "message" => "Failed to save."
                        );
                }
                if ($ids['status'] == true) {
                    $return = array(
                        "status" => "success",
                        "message" => "Success to save Article $judul."
                    );
                }  
                
        }
        return $return;
    }
   
    public function edit() {
         $id = isset($_POST["id"]) ? trim($_POST["id"]) : '';
        $user_data = $this->session->get_userdata();
        $id_session = $user_data['user_id'];
        if (empty($id_session)) {
            redirect();
        }
        $dt = array(
            "title" => $this->meta_title,
            "description" => $this->meta_desc,
            "container" => $this->_homeEdit($id),
            "custom_js" => array(
                ASSETS_URL . "plugins/validate/jquery.validate_1.11.1.min.js",
                ASSETS_JS_URL . "form/surat.js",
                ASSETS_URL . "plugins/datatables/jquery.dataTables.min.js",
                ASSETS_URL . "plugins/datatables/dataTables.bootstrap.min.js",
                ASSETS_URL . "plugins/datatables/dataTables.responsive.js",
                ASSETS_URL . "plugins/select2/select2.full.min.js",
                ASSETS_URL . "plugins/validate/jquery.validate_1.11.1.min.js",
                ASSETS_URL . "plugins/datetimepicker/js/moment.js",
                ASSETS_URL . "plugins/datepicker/bootstrap-datepicker.js",
                ASSETS_URL . "plugins/datetimepicker/js/bootstrap-datetimepicker.min.js",
                ASSETS_URL . "plugins/daterangepicker/daterangepicker.js",
                ASSETS_URL . "plugins/ckeditor/ckeditor.js",
                ASSETS_URL . "plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js",
            ),
            "custom_css" => array(
                ASSETS_URL . "plugins/datepicker/datepicker3.css",
                ASSETS_URL . "plugins/daterangepicker/daterangepicker.css",
                ASSETS_URL . "plugins/datatables/dataTables.bootstrap.css",
                ASSETS_URL . "plugins/datatables/dataTables.responsive.css",
                ASSETS_URL . "plugins/select2/select2.min.css",
                ASSETS_URL . "plugins/datetimepicker/css/bootstrap-datetimepicker.min.css",
                ASSETS_URL . "plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css",
            ),
        );
        $this->_render("default", $dt);
    }

    private function _homeEdit($id) {
        $data = $this->surat_model->checkData($id);
        $arrBreadcrumbs = array(
            "Manage" => base_url(),
            "Diagnostik" => $this->base_url,
            "List" => "#",
        );
        $dt["breadcrumbs"] = $this->setBreadcrumbs($arrBreadcrumbs);
        $dt["title"] = $this->main_title;
        $jenis_mainmenu = $this->surat_model->getDataMainMenu();
        $dt["kategori"] = $jenis_mainmenu;
        $dt["company"] =  $this->surat_model->getCompany();
        $dt['data'] = $data;
        if(empty($id)){
            $dt['title'] = 'Create File Dashboard';
        }else{
            $dt['title'] = 'Edit File Dashboard';
        }
        $dt['base_url'] = $this->base_url;
        $ret = $this->load->view("surat/form", $dt, true);
       
        return $ret;
    }

    public function delete() {
        $id = isset($_POST["id"]) ? trim($_POST["id"]) : '';
        $alert = array(
            "status" => "failed",
            "message" => "Failed to delete Data. Please try again."
        );
        $res = $this->surat_model->delete($id);
        if ($res['status'] == TRUE) {
            $alert = array(
                "status" => "success",
                "message" => "Success to delete Data."
            );
        }
        $this->session->set_flashdata("alert_diagnostik", $alert);
        redirect($this->base_url);
    }
    public function getDataview() {
        $user_data = $this->session->get_userdata();
        $id_session = $user_data['user_level'];
        $id = $_POST['rowid'];
        $data = $this->surat_model->check($id);
        $dt['data'] = $data;
        $dt['session'] = $id_session;
        $ret = $this->load->view("surat/detail", $dt);
    }
    public function getambil_data(){

        $modul=$this->input->post('modul');
        $id=$this->input->post('id');
        if($modul=="kabupaten"){
             echo $this->surat_model->kabupaten($id);
        }
        else if($modul=="kecamatan"){
             echo $this->surat_model->kecamatan($id);
        }
   }

    public function getData() {
        $user_data = $this->session->get_userdata();
        $id_session = $user_data['user_level'];
        $this->isAjaxPost();
        $this->load->library('datatables');
        $post = $this->input->post();
        $dataSiswa = $this->surat_model->getData();
            $response = $this->datatables->collection($dataSiswa)
                     ->addColumn('status', function($row) {
                        $status = $row->status == 0 ? '<span class="label label-danger">Unpublished</span>' : '<span class="label label-success">Published</span>';
                        return $status;
                    })
                    ->addColumn('action', function($row) {
                        $btnAksi = '<a href=""  data-id="' . $row->id . '" '
                                . 'class="btn btn-flat btn-danger btn-sm"  data-toggle="modal" data-target="#delete-data" title="Delete"><span class="glyphicon glyphicon-trash"></span></a>'
                                . '<a href=""  class="btn btn-flat btn-warning btn-sm del" data-id="' . $row->id . '" data-toggle="modal" data-target="#edit-data" title="Edit"><span class="glyphicon glyphicon-pencil"></span></a>'
                                . '<a href=""  data-id="' . $row->id . '" class="btn btn-flat btn-success btn-sm" data-toggle="modal" data-target="#detail-data" title="Preview File PDF"><span class="glyphicon glyphicon-search"></span></a>';
//                                . '<a href="' . base_url('surat/getPrint/' . $row->id) . '"   class="btn btn-flat btn-primary btn-sm"  target="_blank" title="Print"><span class="glyphicon glyphicon-print"></span></a>';
                        return $btnAksi;
                    })
                    ->render();
        echo json_encode($response);
    }

   

}
