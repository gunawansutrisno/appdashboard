<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Article extends MY_Controller {

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

    public function index() {
        $url = $this->uri->segment('2');
        $urisegment =  str_replace("-", " ", $url);
        

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
            "container" => $this->_home($urisegment),
            "custom_js" => array(
                ASSETS_JS_URL . "form/home.js",
               ASSETS_URL . "plugins/chart.js/chart.js",
            ),
        );
        
        $this->_render("default", $dt);
    }
    private function _home($urisegment) {
        $tahun = isset($_POST["tahun"]) ? $_POST["tahun"] : "";
        $bulan = isset($_POST["bulan"]) ? $_POST["bulan"] : "";
        $name = isset($_POST["name"]) ? $_POST["name"] : "";
        $dt['bulan'] = $bulan;
        $dt['tahun'] = $tahun;
        
        $dt['post'] = json_encode($_POST);

        if(!empty($name)){
            $cek = $this->menu_model->check($name);    
            
        }else {
            $cek = $this->menu_model->check($urisegment);      
        }
       
        if(empty($cek)){           
            if(empty($urisegment)){
                $cek = $this->article_model->checkD($name);
                
            }else{
               $cek = $this->article_model->checkD($urisegment);     
            }
            $id = $cek[0]->id ? $cek[0]->id : '';   
            
            $menuid = $cek[0]->menu_id ? $cek[0]->menu_id : '';
            $d =  $this->article_model->getCekURL($menuid) ;          
            
            $dt['judul'] =  $cek[0]->nama ? $cek[0]->nama : '' ; 
            $sb =  $cek[0]->nama ? $cek[0]->nama : ''; 
            $dt['urisegment'] = $sb;
            $arrBreadcrumbs = array(
                $d->nama => base_url(),
                $cek[0]->nama ? $cek[0]->nama : '' => "#",
            );

        } else { 
            $id = $cek[0]->id;            
            $dt['menu'] = $this->article_model->Getdata($id); 
            $dt['judul'] = $this->article_model->getCekURL($id);
            $arrBreadcrumbs = array(
                "Home" => base_url(),
                $cek[0]->nama => "#",
            );
          
        
        }
       
        $dt["menu_list"] = $this->config->item('menu_list');
        $dt["breadcrumbs"] = $this->setBreadcrumbs($arrBreadcrumbs);
        $dt["title"] = $this->main_title;
        if(!empty($sb)){
            $dt["base_url"] = $this->base_url_site . "article/". url_title(strtolower($sb));
        }else{
            $dt["base_url"] = $this->base_url;
        }
        if(!empty($dt['menu'])){
           
            $ret = $this->load->view("article/content", $dt, True);
        }else{
            $dt['id'] = $id;
            if(!empty($tahun) || !empty($bulan)){
                    $data = $this->article_model->getDataFile($id,$bulan,$tahun);
                    
                          if(empty($data)){

                                $urls = url_title(strtolower($sb));
                                // echopre($urls);
                                // exit;
                                echo"  <script>
                                alert('No matching records found. Please try again');
                                window.location.href='article/".$urls."';
                                </script>";
                            }
                         
                            $dt["data"] = $data;
            }
           
            $ret = $this->load->view("article/content_detail", $dt, True);
        }
        return $ret;
       
    }
    public function detail() {
        $url = $this->uri->segment('3');
        $urisegment =  str_replace("-", " ", $url);
        
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
            "container" => $this->_detail_home($urisegment),
            "custom_js" => array(
                ASSETS_JS_URL . "form/home.js",
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
    private function _detail_home($urisegment){

        $tahun = isset($_POST["tahun"]) ? $_POST["tahun"] : "";
        $bulan = isset($_POST["bulan"]) ? $_POST["bulan"] : "";
        $name = isset($_POST["name"]) ? $_POST["name"] : "";
        $dt['bulan'] = $bulan;
        $dt['tahun'] = $tahun;
        $dat = str_replace('-',' ',$name);
        // echopre($urisegment);exit;
        $getid = $this->article_model->checkD($urisegment);
        $id = $getid[0]->id;
   
        $dt['data'] = $this->article_model->getDataFile($id,$bulan,$tahun);
        // echopre($this->db->last_query());exit;
        $url = $this->base_url_site."article/detail/".url_title($urisegment);
      
        $arrBreadcrumbs = array(
            "dashboard" => base_url(),
            "article" => $url,
            $urisegment => "#",
        );
        $dt["breadcrumbs"] = $this->setBreadcrumbs($arrBreadcrumbs);
        $dt["title"] = "Searching";
        $dt["urisegment"] = url_title($urisegment);
        $dt["base_url"] = $url;
        // $dt['post'] = json_encode($post);
        $ret = $this->load->view("article/content_detail", $dt, true);
        return $ret;
    }
    
    // public function getDataview() {
    //     $user_data = $this->session->get_userdata();
    //     $id_session = $user_data['user_level'];
    //     $id = $_POST['rowid'];
    //     $data = $this->surat_model->check($id);
    //     echopre($id);exit;
    //     $dt['data'] = $data;
    //     $dt['session'] = $id_session;
    //     $ret = $this->load->view("surat/detail", $dt);
    // }
}
