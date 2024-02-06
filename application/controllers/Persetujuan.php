<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once("functions/string.func.php");
include_once("functions/date.func.php");

class Persetujuan extends CI_Controller {

	function __construct() {
		parent::__construct();
		
		/*if (!$this->kauth->getInstance()->hasIdentity())
		{
			redirect('app');
		}			
				
		$this->HAKAKSES = $this->kauth->getInstance()->getIdentity()->HAKAKSES;
		$this->HAKAKSES_DESC = $this->kauth->getInstance()->getIdentity()->HAKAKSES_DESC;*/
							
		
	}

	
	public function permohonan()
	{
		
		$data = array(
			'reqTipe' => "permohonan"
		);
		$this->load->view('persetujuan/index', $data);
	}


	
	public function lupa_password()
	{
		
		$data = array(
			'reqTipe' => "permohonan"
		);
		$this->load->view('persetujuan/lupa_password', $data);
	}


	public function lupa_password_submit()
	{

		$reqToken = $this->input->post("reqToken");
		$reqPassword = $this->input->post("reqPassword");
		$reqPassword = setQuote($reqPassword);

		$md5key = $this->config->item("md5key");


		$rowResult = $this->db->query(" SELECT PENGGUNA_EXTERNAL_ID from PENGGUNA_EXTERNAL WHERE MD5(NID || to_char(current_date, 'dd-mm-yyyy') || '$md5key') = '$reqToken' ")->row();
		$reqPenggunaId  = $rowResult->pengguna_external_id;


		$sql = " UPDATE PENGGUNA_EXTERNAL SET PASSWORD = md5('$reqPassword') WHERE PENGGUNA_EXTERNAL_ID = '$reqPenggunaId' ";

		$this->db->query($sql);

		$sql = " UPDATE PENGGUNA SET PASS = md5('$reqPassword') WHERE PENGGUNA_EXTERNAL_ID = '$reqPenggunaId' ";

		$this->db->query($sql);


		$result = "Reset password berhasil.";
		
		redirect("persetujuan/konfirmasi_pesan/?reqPesan=".$result);

	}


	public function loadUrl()
	{
		
		$reqFolder = $this->uri->segment(3, "");
		$reqFilename = $this->uri->segment(4, "");
		$reqParse1 = $this->uri->segment(5, "");
		$reqParse2 = $this->uri->segment(6, "");
		$reqParse3 = $this->uri->segment(7, "");
		$reqParse4 = $this->uri->segment(8, "");
		$data = array(
			'reqParse1' => $reqParse1,
			'reqParse2' => $reqParse2,
			'reqParse3' => $reqParse3,
			'reqParse4' => $reqParse4,
			'reqTahunTerpilih'	=> $this->tahun_terpilih
		);
		$this->load->view($reqFolder.'/'.$reqFilename, $data);
	}	
		

	public function konfirmasi_berhasil()
	{
		$data = array(
			'reqPesan' => "Konfirmasi berhasil."
		);
		$this->load->view('persetujuan/konfirmasi', $data);
	}

	public function konfirmasi_pesan()
	{
		
		$reqPesan = $this->uri->segment(3, "");
		
		$data = array(
			'reqPesan' => $reqPesan
		);
		$this->load->view('persetujuan/konfirmasi', $data);
	}

	public function konfirmasi_batal()
	{
		$data = array(
			'reqPesan' => "Permohonan telah dibatalkan oleh Pegawai"
		);
		$this->load->view('persetujuan/konfirmasi', $data);
	}
	
	public function konfirmasi_gagal()
	{
		$data = array(
			'reqPesan' => "Konfirmasi gagal"
		);
		$this->load->view('persetujuan/konfirmasi', $data);
	}
	
	
	public function konfirmasi_sudah_verifikasi()
	{
		$data = array(
			'reqPesan' => "Sudah diverifikasi"
		);
		$this->load->view('persetujuan/konfirmasi', $data);
	}
	
	

}

