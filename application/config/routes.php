<?php
defined('BASEPATH') OR exit('No direct script access allowed');


// APPS START HERE //

$route['Manage/Import/File/Fico'] = 'Import_Fico/index';
$route['Manage/Import/Fico/Save'] = 'Import_Fico/forms_save';
$route['Manage/Import/Save_fico'] = 'Import_Fico/save';
$route['Manage/Report/File'] = 'View_fico/index';
$route['Manage/Report/getData'] = 'View_fico/getData';
$route['Manage/Report/Ekspor'] = 'View_fico/exports';

$route['setarakas/ekport/persediaan'] = 'setarakas/export_persediaan';
$route['tambahan/rugilaba'] = 'tambahan/index_rugilaba';

//report tangki
$route['Manage/Import/File'] = 'Import/index_file';
$route['Manage/Import/Save'] = 'Import/save_as';
$route['Manage/Preview/getData'] = 'View/getData';
$route['Manage/Preview/Ekspor'] = 'Import/exports';
$route['Manage/Preview/File'] = 'View/index_file';



// idcard
$route['download/master/data'] = 'idcard/download';
// import
$route['/import'] = 'Import/index';
$route['/import/form'] = 'Import/from';
$route['/import/save'] = 'Import/save';
//$route['/import/files'] = 'Import/send';


$route['/icd'] = 'Code/index';
$route['/icd/save'] = 'pelanggaran/save';
$route['/icd/edit/(:num)'] = function($param , $id){
    return 'icd/edit/'.$id;
};
$route['/icd/delete/(:num)'] = function($param , $id){
      return 'icd/delete/'.$id;
};
//jenis oprasi
$route['/jenisoprasi'] = 'JenisOprasi/index';
$route['/jenisoprasi/save'] = 'JenisOprasi/save';
$route['/jenisoprasi/edit/(:num)'] = function($param , $id){
    return 'JenisOprasi/edit/'.$id;
};
$route['/jenisoprasi/delete/(:num)'] = function($param , $id){
      return 'JenisOprasi/delete/'.$id;
};

//$route['/kwintansi/preview/(:num)'] = function($param , $id){
//      return 'kwintansi/preview/'.$id;
//};
//$route['/suratkeluar'] = 'Suratkeluar/index';
//$route['/kwintansi/searching'] = 'Kwintansi/searching';

 // Laporan
//$route['laporan/penerimaan'] = "Penerimaan/index";
//$route['laporan/export'] = "Laporan/export";
//$route['laporan'] = "Laporan";
//$route['laporan/oprasi/export'] = "LaporanTindakan/export";
// // Laporan
//$route['idcard/cek'] = "idcard/cek";
//$route['idcard/save'] = "idcard/save";

//// Barang Routes
//$route['/oprasi'] = 'Oprasi/index';
//$route['/oprasi/save'] = 'oprasi/save';
//$route['/oprasi/edit/(:num)'] = function($param , $id){
//    return 'oprasi/edit/'.$id;
//};
//$route['/oprasi/delete/(:num)'] = function($param , $id){
//      return 'oprasi/delete/'.$id;
//};
$route['article/detail/(:any)'] = 'article/detail';
$route['article/(:any)'] = 'article/index';
 $route['manage'] = 'surat/index';
 $route['surat/save'] = 'surat/save';
 $route['surat/add'] = 'surat/edit';
 $route['/surat/edit'] = 'surat/edit';
 $route['/surat/delete'] = 'surat/delete';
//$route['/surat/edit/(:num)'] = function($param , $id){
//      return 'surat/edit/'.$id;
//};
// Pengguna Routes
$route['/pengguna'] = 'pengguna/index';
$route['/pengguna/add'] = 'pengguna/add';
$route['/pengguna/save'] = 'pengguna/save';
$route['/pengguna/edit/(:num)'] = function($param , $id){
    return 'pengguna/edit/'.$id;
};
//home
$route['/home/'] ='home/index/';
//profile
$route['/pengguna/delete'] = 'pengguna/delete';
$route['/profile/save_profile'] = 'profile/save_profile';
$route['/profile/edit/(:num)'] = function($param , $id){
    return 'profile/edit/'.$id;
};

// Level Routers
$route['/level'] = 'level/index';
$route['/level/add'] = 'level/add';
$route['/level/save'] = 'level/save';
$route['/level/edit/(:num)'] = function($param , $id){
    return 'level/edit/'.$id;
};

$route['/level/delete/(:num)'] = function($param , $id){
      return 'pengguna/delete/'.$id;
};
// Login Routes

$route['login'] = 'login/index';
$route['logout'] = 'login/logout';

$route['default_controller'] = 'login/index';
//$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

