<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Reportfico_model extends CI_Model {

    var $table = "mst_surat";
    var $primary_key = "id";

    public function __construct() {
        parent::__construct();
    }
	  function search_blog(){
        $this->db->order_by('code', 'ASC');
        $this->db->limit(10);
        return $this->db->get('company_code')->result();
    }
	function GL(){
        $this->db->order_by('code', 'ASC');
        return $this->db->get('mst_gl_account')->result();
    }
    
   public function getDataIndex_file2($code="",$gl="",$tgl="") {
         if($code !=""){
			 
			// $this->db->where('faglb03.document_number','1400000190');
			 $this->db->where('faglb03.company_code',$code);
        }if($tgl !=""){
             $this->db->where("faglb03.posting_date BETWEEN '".$tgl['start']."' AND '".$tgl['end']."'");
        }
		if($gl !=''){
			$this->db->where('faglb03.account',$gl);
		}
		
        $this->db->select('faglb03.company_code, 
				faglb03.account,
				bseg.amount,
				mst_gl_account.name,
				faglb03.document_number,
				faglb03.posting_date,
				faglb03.assignment,
				bkpf.object_key,
				bkpf.fiscal_year,
				bkpf.exchange_rate,
				bkpf.entry_date,
				bkpf.document_number as no_doc,
				bkpf.user_name,
				bkpf.time_of_entry,
				faglb03.posting_period,
				faglb03.amount_in_doc_curr,
				faglb03.document_currency,
				faglb03.offsetting_account,
				faglb03.amount_in_lc,
				faglb03.document_type,
				bkpf.local_currency,
				fbl5n.amount_currency,
				mst_cus.Name1 as cust,
				bseg.currency,');
        $this->db->from('bseg');
        $this->db->join('bkpf','bseg.document_number = bkpf.document_number');
        $this->db->join('fbl5n','fbl5n.document_number = bseg.document_number');
        $this->db->join('faglb03','faglb03.document_number = bseg.document_number');
        $this->db->join('mst_gl_account','mst_gl_account.code = faglb03.account');
        $this->db->join('mst_cus','mst_cus.Customer = faglb03.offsetting_account');
        $this->db->group_by('bseg.amount');
        $this->db->group_by('bseg.document_number');
        $this->db->group_by('faglb03.document_number');
        $data = $this->db->get();
        return $data->result_array();
    }
   
}
