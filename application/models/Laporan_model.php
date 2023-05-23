<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_model extends CI_Model {

    var $table = "mst_surat";
    var $primary_key = "id";
//    var $jointTable = "mst_pasien";
//    var $jointTableDokter = "mst_siswa";

    public function __construct() {
        parent::__construct();
    }

    public function getDataIndex($offset = 0, $limit = 10, $status_pembayaran = "", $tanggal = array()) {
       
            if ($status_pembayaran != "") {
                $this->db->where($this->table.'.status', $status_pembayaran);
            }
          
            if (!empty($tanggal) && isset($tanggal['start']) && isset($tanggal['end'])) {
                $this->db->where($this->table.'.tgl BETWEEN "' . $tanggal['start'] . '" AND "' .$tanggal['end'].'"');
           }
        $this->db->from($this->table);
        if($limit != 'all'){
            $this->db->limit($limit);
        
        }
        $this->db->offset($offset);
        $this->db->order_by($this->table . ".tgl ASC");
        $data = $this->db->get();
        return $data->result();
    }
    public function getCountDataIndex( $status = "",$tanggal = array()) {

            if ($status != "") {
                $this->db->where('status', $status_pembayaran);
            }
            
            if (!empty($tanggal) && isset($tanggal['start']) && isset($tanggal['end'])) {
                $this->db->where('tgl_tindakan BETWEEN "' . $tanggal['start'] . '" AND "' .$tanggal['end'].'"');
         
            }
        $this->db->select($this->table . '.* ');
        $this->db->from($this->table);
        $this->db->order_by("mst_diagnostik.tgl_tindakan DESC");
        $data = $this->db->count_all_results();
        return $data;
    }
    public function getDataIndexexport($status_pembayaran = "", $tanggal = array()) {
       
       
           
            if ($status_pembayaran != "") {
                $this->db->where('mst_diagnostik.status', $status_pembayaran);
            }
          
            if (!empty($tanggal) && isset($tanggal['start']) && isset($tanggal['end'])) {
                $this->db->where('tgl_tindakan BETWEEN "' . $tanggal['start'] . '" AND "' .$tanggal['end'].'"');
            }
            
        $this->db->select("
            mst_diagnostik.id,
            mst_diagnostik.status,
            mst_diagnostik.jenis_tindakan,
            DATE_FORMAT(mst_diagnostik.tgl_tindakan,'%d %b %Y') AS tanggal,
            mst_diagnostik.createdby,
            mst_diagnostik.createddate,
            mst_diagnostik.notes,
            mst_diagnostik.updatedate,
            mst_diagnostik.jk,
            mst_siswa.nama_siswa AS dokter,
            mst_siswa.kode_dokter,
            mst_pasien.noka,
            mst_pasien.nama AS pasien,
            mst_pemeriksaan.nosep,
            mst_pemeriksaan.jenis_rawat,
            mst_jenis_tindakan_op.name
        ");
        $this->db->join("mst_siswa" , "mst_siswa.id = mst_diagnostik.dokter_id","left");
        $this->db->join("mst_pasien" , "mst_pasien.id = mst_diagnostik.pasien_id","left");
        $this->db->join("mst_pemeriksaan" , "mst_pemeriksaan.pasien_id = mst_pasien.id","left"); 
        $this->db->join("mst_jenis_tindakan_op" , "mst_diagnostik.jenis_tindakan = mst_jenis_tindakan_op.id","left"); 
        $this->db->from($this->table);
        $this->db->order_by($this->table . ".tgl_tindakan DESC");
        $data = $this->db->get();
        return $data;
    }
    public function getCountDataIndexexport( $status_pembayaran = "",$tanggal = array(), $id_agen = "") {
        
         if(!empty($id_agen)){
                 $this->db->where('id_agen', $id_agen);
               
        }else {
           
            if ($status_pembayaran != "") {
                $this->db->where('status_pembayaran', $status_pembayaran);
            }
            
            if (!empty($tanggal) && isset($tanggal['start']) && isset($tanggal['end'])) {
                $this->db->where('tanggal_transaksi BETWEEN "' . $tanggal['start'] . '" AND "' .$tanggal['end'].'"');
         
            }
        }
        $this->db->select($this->table . '.*, master_agen.nama_agen ');
        $this->db->join('master_agen','master_agen.id_agen = '.$this->table.'.id_agen');
        $this->db->from($this->table);
        $data = $this->db->count_all_results();
        return $data;
    }
    public function getBarangDetail($id) {
        
        $this->db->select( $this->jointTable .' .*, master_barang.*');
        $this->db->from( $this->jointTable);
        $this->db->join('master_barang', 'master_barang.id_barang = '.$this->jointTable.'.id_barang');
        if(is_array($id)){
            $this->db->where_in($this->jointTable.".id_trans_barang", $id);
            $this->db->order_by($this->jointTable.".id_trans_barang", "asc");
        }
        else{
            $this->db->where($this->jointTable.".id_trans_barang", $id);
        }
        
        $query = $this->db->get();
        $resVal = "";
        if ($query->num_rows() > 0) {
            $resVal = $query->result_array();
        } else {
            $resVal = false;
        }
        return $resVal;
    }

   public function getDataTrans($kode = "", $nomor = "",$isi_ringkasan="", $tanggal=""){
       
        if($kode !=""){
              $this->db->like("kode" , $kode);           
        } 
        if($nomor !=""){
              $this->db->like("nomor" , $nomor);           
        }           
         if($isi_ringkasan !=""){
              $this->db->like("isi" , $isi_ringkasan);           
        } 
        if($tanggal !=""){
                $this->db->where("tgl1 BETWEEN '".$tanggal['start']."' AND '".$tanggal['end']."'");
        }
        $this->db->order_by("tgl ASC"); 
        return $this->db->get_compiled_select($this->table);
    }
    public function getAkt($id=""){
       
        $query = $this->db->select('*')
                ->from('akt')
                ->join('acct','akt.acc = acct.acct')
                ->where('akt.acc', $id)
//                ->group_by('acct.FSSubClasses')
                ->get()->result();       
        return $query;
    }
    public function getKeuangan($bulan="",$tahun=""){
       
        $query = $this->db->select('*')
                ->from('acct')
                ->join('akt','akt.acc = acct.acct')
                ->where('akt.bulan',$bulan)
                ->where('akt.tahun',$tahun)
                ->group_by('acct.FSSubClasses')
                ->get()->result();       
        return $query;
    }
    public function getKeuanganneraca($bulan="",$tahun=""){
       
        $query = $this->db->select('sum(Kas_dan_Bank) as Kas_dan_Bank,sum(TKas_dan_Bank) as TKas_dan_Bank,sum(Utang_deviden) as Utang_deviden,'
                . 'sum(TUtang_deviden) as TUtang_deviden, sum(Piutang_Deviden) as Piutang_Deviden, sum(TPiutang_Deviden) as TPiutang_Deviden,'
                . 'sum(Piutang_Usaha) as Piutang_Usaha, sum(TPiutang_Usaha) as TPiutang_Usaha, sum(Piutang_lain_lain) as Piutang_lain_lain,'
                . 'sum(TPiutang_lain_lain) as TPiutang_lain_lain, sum(Persediaan) as Persediaan,sum(TPersediaan) as TPersediaan, sum(Uang_muka_pada_pemasok) as Uang_muka_pada_pemasok,'
                . 'sum(TUang_muka_pada_pemasok) as TUang_muka_pada_pemasok, sum(Pajak_dibayar_dimuka) as Pajak_dibayar_dimuka,sum(TPajak_dibayar_dimuka) as TPajak_dibayar_dimuka,'
                . 'sum(Biaya_dibayar_dimuka) as Biaya_dibayar_dimuka, sum(TBiaya_dibayar_dimuka) as TBiaya_dibayar_dimuka,sum(Aset_tetap) as Aset_tetap,sum(TAset_tetap) as TAset_tetap,'
                . 'sum(Properti_investasi) as Properti_investasi,sum(TProperti_investasi) as TProperti_investasi,sum(Investasi_penyertaan_saham) as Investasi_penyertaan_saham,'
                . 'sum(TInvestasi_penyertaan_saham) as TInvestasi_penyertaan_saham,sum(Aset_pengampunan_pajak) as Aset_pengampunan_pajak,sum(TAset_pengampunan_pajak) as TAset_pengampunan_pajak,'
                . 'sum(Taksiran_Tagihan_Pajak) as Taksiran_Tagihan_Pajak,sum(TTaksiran_Tagihan_Pajak) as TTaksiran_Tagihan_Pajak,sum(Aktiva_lain_lain) as Aktiva_lain_lain,sum(TAktiva_lain_lain) as TAktiva_lain_lain,'
                . 'sum(Utang_usaha) as Utang_usaha,sum(TUtang_usaha) as TUtang_usaha,sum(Utang_lain_lain) as Utang_lain_lain,sum(TUtang_lain_lain) as TUtang_lain_lain,sum(Utang_pajak) as Utang_pajak,'
                . 'sum(TUtang_pajak) as TUtang_pajak,sum(Biaya_masih_harus_dibayar) as Biaya_masih_harus_dibayar,sum(TBiaya_masih_harus_dibayar) as TBiaya_masih_harus_dibayar,'
                . 'sum(Uang_Muka_Pelanggan) as Uang_Muka_Pelanggan,sum(TUang_Muka_Pelanggan) as TUang_Muka_Pelanggan,sum(Pinjaman_antar_perusahaan) as Pinjaman_antar_perusahaan,'
                . 'sum(TPinjaman_antar_perusahaan) as TPinjaman_antar_perusahaan,sum(Utang_bank) as Utang_bank,sum(TUtang_bank) as TUtang_bank,sum(Liabilitas_diestimasi_atas_imbalan_kerja) as Liabilitas_diestimasi_atas_imbalan_kerja,'
                . 'sum(TLiabilitas_diestimasi_atas_imbalan_kerja) as TLiabilitas_diestimasi_atas_imbalan_kerja,sum(Liabilitas_Pajak_Tangguhan) as Liabilitas_Pajak_Tangguhan,sum(TLiabilitas_Pajak_Tangguhan) as TLiabilitas_Pajak_Tangguhan,'
                . 'sum(Modal_saham) as Modal_saham,sum(TModal_saham) as TModal_saham,sum(Uang_muka_penyertaan_saham) as Uang_muka_penyertaan_saham,sum(TUang_muka_penyertaan_saham) as TUang_muka_penyertaan_saham,'
                . 'sum(Tambahan_Modal_Disetor) as Tambahan_Modal_Disetor,sum(TTambahan_Modal_Disetor) as TTambahan_Modal_Disetor,sum(Komponen_ekuitas_lainnya) as Komponen_ekuitas_lainnya,'
                . 'sum(TKomponen_ekuitas_lainnya) as TKomponen_ekuitas_lainnya,sum(Saldo_laba) as Saldo_laba,sum(TSaldo_laba) as TSaldo_laba,'
                . 'sum(Utang_bank_jangka_panjang) as Utang_bank_jangka_panjang,sum(TUtang_bank_jangka_panjang) as TUtang_bank_jangka_panjang')
                ->from('neraca')
//                ->join('akt','akt.acc = acct.acct')
                ->where('neraca.bulan',$bulan)
                ->where('neraca.tahun',$tahun)
//                ->group_by('acct.FSSubClasses')
                ->get()->row();       
        return $query;
    }
    public function getKeuanganData($id=""){
       
        $query = $this->db->select('sum(akt.value) as value,acct.FSLines,acct.acct,acct.FSSubClasses')
                ->from('acct')
                ->join('akt','akt.acc = acct.acct','left')
                
                ->like('acct.FSSubClasses',$id)                
                ->order_by('acct.acct','asc')
                ->group_by('acct.FSLines')
                ->get()->result();       
        return $query;
    }
    public function gethutanglain(){
       
        $query = $this->db->select('sum(MIG) as MIG')
                ->from('hutang_lain')            
//                ->order_by('acct.acct','asc')
//                ->group_by('acct.FSLines')
                ->get()->result();       
        return $query;
    }
}
//where `acct`.`FSSubClasses` like '%aset lancar%'
//group BY 