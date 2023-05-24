<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {

    var $meta_title = "MOLINDO INCORPORATED | Login";
    var $meta_desc = "MOLINDO INCORPORATED ";
    var $main_title = "Login";
    var $base_url = "";
    var $upload_dir = "";
    var $upload_url = "";
    var $limit = "10";

    public function __construct() {
        parent::__construct();
        $this->base_url = base_url() . "login/";
        $this->load->model("pengguna_model");
        $this->load->model("levelmenu_model");
    }

    public function index() {
//        $data = [
//                    ['6000000','11','5999989'],
//                    ['6000000','9','599998'],
//                    ['6000000','12','599968'],
//                    ['6000000','1','599967']
//                ];
////      
//foreach($data as $index=>$v)
//{
////    echoPre($index);exit;
//	if( $index == 0 )
//	{
//		$a = $v[0];
//		$c = $v[2];
//	}else{
//		$c = $a - $v[1];
//	}
//	
//	echo number_format($a).' | '. $v[1].' | '.number_format($c);
//	echo '<br/>';
//	
//	$a = $c;
//
//}
//exit;
//         echo(sha1('molindo255'));exit;
        $res = "";
        if (isset($_POST['submit'])) {
            $res = $this->checkLogin();
        }
        
        $dt["alert"] = $res;
        $this->load->view("login/login", $dt);
    }
    public function forgot(){
        $res = "";
        if (isset($_POST['submit'])) {
//            $res = $this->checkLogin();
        }

        $dt["alert"] = $res;
        $this->load->view("login/forgot", $dt);
    }

    public function checkLogin() {
        $res = array();
        $username = $this->security->xss_clean($this->input->post("email"));
        $password = $this->security->xss_clean($this->input->post("password"));
        $userData = $this->pengguna_model->getDataIndex( 0, 1, $username);
        if (count($userData) > 0 ) {
            $user = $userData[0];
            if ($user->status != 0) {
                $password_exist = $user->password;
                $password_user = sha1($password);
                
                if (($password_user == $password_exist)) {
                    $dataMeta = $this->levelmenu_model->getDataIndex(0, 'all', $user->id_level);
                  
                    $arrMeta = array();
                    foreach ($dataMeta as $row) {
                       $arrMeta[] = $row['menu'];
                    }
                    
                    $arrSession = array(
                        "user_id" => $user->id,
                        "user_name" => $user->nama,
                        "user_username" => $user->username,
                        "user_level" => $user->id_level,
                        "user_jabatan" => $user->jabatan,
                        "user_status" => $user->status,
                        "user_name_company" => $user->code,
                        "user_id_company" => $user->id_company,
                         "user_allowed_menu" => $arrMeta,
                        "user_validated" => true,
                    );
                    $redirect_url = base_url()."home/";
                    $this->session->set_userdata($arrSession);
                    redirect($redirect_url);
                } else {
                    $res["status"] = "failed";
                    $res["message"] = "Your Password Is Not Match";
                }
            } else {
                $res["status"] = "failed";
                $res["message"] = "Your Account Has Been Deactivated";
            }
        } else {
            $res["status"] = "failed";
            $res["message"] = "You Don't Have Access To This CMS";
        }
        return $res;
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect("/");
    }

}
