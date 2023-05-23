<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends MY_Controller {

    var $meta_title = "APPMOLINDO | Profil";
    var $meta_desc = "APPMOLINDO";
    var $main_title = "Profil Pengguna";
    var $base_url = "";
    var $upload_dir = "";
    var $upload_url = "";
    var $limit = "10";

    public function __construct() {
        parent::__construct();
        $this->base_url = $this->base_url_site . "profile/";
        $this->load->model("pengguna_model");
       // $this->load->model("level_model");
    }

    public function index() {
        
    }
    
    public function edit($id) {
        
        $dt = array(
            "title" => $this->meta_title,
            "description" => $this->meta_desc,
            "container" => $this->_profile($id),
            "custom_js" => array(
                ASSETS_JS_URL . "form/profile.js",
            ),
        );
        $this->_render("default", $dt);
    }

    private function _profile($id) {
        
        $data = $this->pengguna_model->getDetail($id);
        
        $arrBreadcrumbs = array(
            "Home" => base_url(),
            "Profile" => $this->base_url,
            "Ubah" => "#",
        );
        $dt["breadcrumbs"] = $this->setBreadcrumbs($arrBreadcrumbs);
        $dt["title"] = $this->main_title;
        $dt["data"] = $data[0];
        $dt["base_url"] = $this->base_url;
        $ret = $this->load->view("pengguna/profile", $dt, true);
      
//          echoPre($dt["data"]);
//          echoPre($ret);
//          exit;
        return $ret;
    }
    
    
    public function save_profile() {
        $id = isset($_POST["id"]) ? trim($_POST["id"]) : '';
        $alert = $this->_saveData($id, true);
        $this->session->set_flashdata("alert_pengguna", $alert);
        redirect($this->base_url."edit/".$id);
    }
    
    private function _saveData($id = '') {

        $fullname = isset($_POST["fullname"]) ? trim($_POST["fullname"]) : '';
        $username = isset($_POST["username"]) ? trim($_POST["username"]) : '';
        $oldpassword = isset($_POST["old_password"]) ? $_POST["old_password"] : '';
        $password = isset($_POST["password"]) ? $_POST["password"] : '';
        
        $oldpasswordEn = passwordEncrypt($oldpassword);
        $passwordEn = passwordEncrypt($password);

        $data = $this->pengguna_model->getDetail($id);
        
        if(!empty($oldpassword) && $data[0]['password'] != $oldpasswordEn){
            $return = array(
                "status" => "failed",
                "message" => "Failed to save Profile. Wrong Old Password."
            );
            
            return $return;
        }
        
        $return = array(
            "status" => "failed",
            "message" => "Failed to save Profile. Please try again."
        );

        // update 
        if (!empty($fullname) && !empty($username) ) {
            if (!empty($id)) {
                $edPengguna = array(
                    "fullname" => $fullname,
                    "username" => $username,
                );
                
                if($password != ""){
                    $edPengguna['password'] = $passwordEn;
                }
                
                $res = $this->pengguna_model->updateDetail($edPengguna, $id);
                if ($res['status'] == true) {
                    $return = array(
                        "status" => "success",
                        "message" => "Success to update Profile $fullname."
                    );
                }
            }
        }
        return $return;
    }

 

}
