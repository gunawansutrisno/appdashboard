<?php

if(!function_exists("passwordEncrypt")){
    function passwordEncrypt($string){
        $pass = str_replace('password', $string, STRING_PASSWORD);
        $encrypt = md5($pass);     
        return $encrypt;
    }
}


if(!function_exists("generateKode")){
    function generateKode($perfix, $num, $pad = 0){
        $number = str_pad($num, $pad, 0, STR_PAD_LEFT);
        $kode = $perfix.$number;
        return $kode;
    }
}


if(!function_exists("echoPre")){
    function echoPre($string){
        echo "<pre>";
        print_r($string);
        echo "</pre>";
    }
}

if(!function_exists("setTanggal")){
    function setTanggal($tanggal){
        $tgl = array();
        if(!empty($tanggal)){
            $t = explode(' - ', $tanggal);
            $tgls = explode("/", $t[0]);
            $tgl['start'] = $tgls[2].'-'.$tgls[1].'-'.$tgls[0].' 00:00:00';
            $tgle = explode("/", $t[1]);
            $tgl['end'] = $tgle[2].'-'.$tgle[1].'-'.$tgle[0].' 23:59:59';
        }
    }
}

if(!function_exists("urlGenerator")){
    function urlGenerator($url){
        # Prep string with some basic normalization
    $url = strtolower($url);
    $url = strip_tags($url);
    $url = stripslashes($url);
    $url = html_entity_decode($url);

    # Remove quotes (can't, etc.)
    $url = str_replace('\'', '', $url);

    # Replace non-alpha numeric with hyphens
    $match = '/[^a-z0-9]+/';
    $replace = '-';
    $url = preg_replace($match, $replace, $url);

    $url = trim($url, '-');
    return $url;
    }
}

if(!function_exists("filterHarga")){
    function filterHarga($strHarga){
        $intHarga = str_replace("." , "" , $strHarga);
        return $intHarga;
    }
}

if(!function_exists("formatHarga")){
    function formatHarga($strHarga){
        $intHarga = number_format($strHarga, 0 , "." , ".");
        return $intHarga;
    }
}

if(!function_exists("extractDate")){
    function extractDate($date){
        //$scheduleNews = isset($arrDataPost['news_schedule']) ? $arrDataPost['news_schedule'] : date("Y-m-d h:i:s");
        $datetime = explode(" ",$date);
        $dateFull = $datetime[0];
        $timeFull = $datetime[1];
        
        $date = explode("-" , $dateFull);
        $time = explode(":" , $timeFull);
        
        $year = $date[0];
        $month = $date[1];
        $date = $date[2];
        
        $hour = $time[0];
        $minute = $time[1];
        $second = $time[2];
        
        $extractedDateTime = array($year , $month , $date , $hour , $minute , $second);
        return $extractedDateTime;
    }
}

if(!function_exists("reverse_date")){
    function reverse_date($date){
        $dateTransaksi = date('Y-m-d H:i:s' , strtotime($date));
        return $dateTransaksi;
    }
}

if(!function_exists("indonesian_date")){
    function indonesian_date ($timestamp = '', $date_format = 'j F Y   H:i', $suffix = '') {
    if (trim ($timestamp) == '')
    {
            $timestamp = time ();
    }
    elseif (!ctype_digit ($timestamp))
    {
        $timestamp = strtotime ($timestamp);
    }
    # remove S (st,nd,rd,th) there are no such things in indonesia :p
    $date_format = preg_replace ("/S/", "", $date_format);
    $pattern = array (
        '/Mon[^day]/','/Tue[^sday]/','/Wed[^nesday]/','/Thu[^rsday]/',
        '/Fri[^day]/','/Sat[^urday]/','/Sun[^day]/','/Monday/','/Tuesday/',
        '/Wednesday/','/Thursday/','/Friday/','/Saturday/','/Sunday/',
        '/Jan[^uary]/','/Feb[^ruary]/','/Mar[^ch]/','/Apr[^il]/','/May/',
        '/Jun[^e]/','/Jul[^y]/','/Aug[^ust]/','/Sep[^tember]/','/Oct[^ober]/',
        '/Nov[^ember]/','/Dec[^ember]/','/January/','/February/','/March/',
        '/April/','/June/','/July/','/August/','/September/','/October/',
        '/November/','/December/',
    );
    $replace = array ( 'Sen','Sel','Rab','Kam','Jum','Sab','Min',
        'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu',
        'Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des',
        'Januari','Februari','Maret','April','Juni','Juli','Agustus','Sepember',
        'Oktober','November','Desember',
    );
    $date = date ($date_format, $timestamp);
    $date = preg_replace ($pattern, $replace, $date);
    $date = "{$date} {$suffix}";
    return $date;
} 
}

if(!function_exists("getNameFile")){
    function getNameFile($fileName){
        $files = explode("." , $fileName);
        $extension = end($files);
        $realname = str_replace(".".$extension,"",$fileName);
        return $realname;
    }
}

if(!function_exists("setDropdownValue")){
    function setListValue($arrDropdown , $index = "" , $value="" , $arrAll = array()){
        $arrReturn = $arrAll;
        if(!empty($arrDropdown)){
            foreach($arrDropdown as $rowDropdown){
                $arrReturn[$rowDropdown[$index]] = $rowDropdown[$value];
            }
        }
        return $arrReturn;
    }
}

?>