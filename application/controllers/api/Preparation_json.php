<?php
 
require APPPATH . '/libraries/REST_Controller.php';
include_once("functions/string.func.php");
include_once("functions/date.func.php");
 
class Preparation_json extends REST_Controller {
 
    function __construct() {
        parent::__construct();

        
    }
 
    // show data entitas
    function index_get() {
        $this->load->model('base-app/T_Preperation_Lccm');


        $user_login_log= new T_Preperation_Lccm;

        $reqToken = $this->input->get("reqToken");
        $reqMode = $this->input->get("reqMode");

        //CEK PEGAWAI ID DARI TOKEN
        // $user_login_log = new UserLoginLog();
        // $user_login_log = new UserLoginMobile();
        // $reqPegawaiId = $user_login_log->getTokenPegawaiId(array("TOKEN" => $reqToken, "STATUS" => '1'));

        $set = new T_Preperation_Lccm();

        $tahun = date("Y") - 1;
      
        if ($set->insertApi()) 
        {
            $this->response(array('status' => 'success', 'message' => 'Data Preparation Tahun '.$tahun.' berhasil disimpan/diperbarui'));
        }
        else 
        {
             $this->response(array('status' => 'fail', 'message' => 'Data Preparation Tahun '.$tahun.' gagal disimpan', 'code' => 502));
        }
          
         


        // $set = new T_Preperation_Lccm;
        // $aColumns = array("KODE_DISTRIK","KODE_BLOK", "KODE_UNIT_M", "SITEID", "YEAR_LCCM", "WO_CR", "WO_STANDING","TANGGAL_SK" );
      
        // $set->selectByParamsMonitoring(array(), -1, -1, $statement);
        //           // echo $set->query;exit();
        // $total = 0;
        // while($set->nextRow())
        // {
        //     $row = array();
        //     for ( $i=0 ; $i<count($aColumns) ; $i++ )
        //     {
        //         $row[trim($aColumns[$i])] = $set->getField(trim($aColumns[$i]));
        //     }
        //     $result[] = $row;

        //     $total++;
        // }

        // if($total == 0)
        // {
        //     for ( $i=0 ; $i<count($aColumns) ; $i++ )
        //     {
        //         $row[trim($aColumns[$i])] = "";
        //     }
        //     $result[] = $row;
        // }

        // print_r($result);exit;

        // $this->response(array('status' => 'success', 'message' => 'success', 'code' => 200, 'count' => count($aColumns) ,'result' => $result));

        

    }

	
    // insert new data to entitas
    function index_post() {
    }
 
    // update data entitas
    function index_put() {
    }
 
    // delete entitas
    function index_delete() {
    }
 
}