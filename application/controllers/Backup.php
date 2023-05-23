<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Backup extends MY_Controller {
   public function index() {
		// Load the DB utility class
        $this->load->dbutil();

        // Backup your entire database and assign it to a variable
        $backup = $this->dbutil->backup();

        // nama file backup
        $namafile = "dbbackup". "-" . date("Y-m-d H:i:s") . ".sql.gz";

        // Load the file helper and write the file to your server
        $this->load->helper('file');

        write_file(FCPATH .'/db_backup/'.$namafile, $backup);

        // Load the download helper and send the file to your desktop
        $this->load->helper('download');
        force_download($namafile, $backup);
	}
} 