<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role extends CI_Controller {

	function __construct() {
		parent::__construct();
		//kauth
		
		if($this->session->userdata("appuserid") == "")
		{
			redirect('login');
		}
		
		$this->appuserid= $this->session->userdata("appuserid");
		$this->appusernama= $this->session->userdata("appusernama");
		$this->personaluserlogin= $this->session->userdata("personaluserlogin");
		$this->appusergroupid= $this->session->userdata("appusergroupid");
		$this->appuserpilihankodehak= $this->session->userdata("appuserpilihankodehak");
		$this->appuserkodehak= $this->session->userdata("appuserkodehak");
		$this->appuserroleid= $this->session->userdata("appuserroleid");

		$this->configtitle= $this->config->config["configtitle"];

		$this->appblokunitid= $this->session->userdata("appblokunitid");
		$this->appdistrikid= $this->session->userdata("appdistrikid");
		$this->appdistrikblokunitnama= $this->session->userdata("appdistrikblokunitnama");

		// $this->CABANG = $this->kauth->getInstance()->getIdentity()->CABANG; 
		// print_r($this->configtitle);exit;
	}

	public function index()
	{
		$this->load->view('role/index', $data);
	}
	
	public function entitas()
	{
		$this->load->view('role/entitas', $data);
	}
	
	public function distrik()
	{
		$this->load->view('role/distrik', $data);
	}
	

	public function modul()
	{
		$this->load->view('role/modul', $data);
	}
	
	
}

