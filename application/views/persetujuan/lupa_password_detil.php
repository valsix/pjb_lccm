<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");
$this->load->library("crfs_protect"); $csrf = new crfs_protect('_crfs_role');

$md5key = $this->config->item("md5key");

$reqToken = $this->input->get("reqToken");
$rowResult = $this->db->query(" SELECT nama, email, to_char(current_date, 'dd-mm-yyyy') batas from PENGGUNA_EXTERNAL WHERE MD5(NID ||to_char(current_date, 'dd-mm-yyyy') || '$md5key') = '$reqToken' ")->row();


$reqNama  = $rowResult->nama;
$reqEmail = $rowResult->email;
$reqBatas = $rowResult->batas;

if($reqNama == "")
{
    $result = "Token tidak sesuai atau batas ubah password telah berakhir.";
    redirect("persetujuan/konfirmasi_pesan/?reqPesan=".$result);
}



?>
<!DOCTYPE html>
<html lang="en">
  <head>
  	<base href="<?=base_url()?>">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="images/favicon.ico">

    <title>PLNNP LCCM</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/bootstrap-3.3.7/docs/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/gaya-approval.css" rel="stylesheet">
	
    <style>
	.tablescroll_wrapper{
		height:calc(100vh - 200px) !important;
	}
	@media screen and (max-width:767px) {
		.tablescroll_wrapper{
			height:calc(100vh - 270px) !important;
		}	
	}

    .tombol{
        
        background-color: #708090;
        color: white;
        padding: 0.3em 0.3em;
        text-decoration: none;
        text-transform: uppercase;

    }
	</style>
    
    <link rel="stylesheet" type="text/css" href="assets/font-awesome-4.7.0/css/font-awesome.css"/>
    
    
    
  </head>

  <body>

    <div class="container-fluid">

        <!-- <div class="judul-halaman"></div> -->
        <div class="area-form-inner">
			<form id="myForm" action="persetujuan/lupa_password_submit" method="post" class="form-horizontal">
                <div class="form-group">
                    <label for="inputType" class="col-md-2 control-label">Password Baru</label>
                    <div class="col-md-8">
                       <input class="easyui-validatebox textbox form-control" type="password" name="reqPassword"  id="reqPassword" value="<?=$reqPassword?>"  style="width:100%">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputType" class="col-md-2 control-label">Ulangi Password Baru</label>
                    <div class="col-md-8">
                        <input class="easyui-validatebox textbox form-control" type="password"  name="reqPassword2"  id="reqPassword2" value="<?=$reqPassword2?>"  style="width:100%">
                    </div>
                </div>
                <br>
                <div class="form-group">
                    <div class="col-md-12" style="text-align: center;">
                            <button type="button" class="btn btn-success" onClick="konfirmasi()"><i class="fa fa-check-circle"></i> Reset Password</button>
                    </div>
                </div>
                <input type="submit" name="reqSubmit" id="reqSubmit" style="display:none">
                <input type="hidden" name="reqToken" value="<?=$reqToken?>">
                
            </form>




	</div>
        
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
   <!--  <script src="lib/bootstrap/jquery.js"></script>
    <script src="lib/bootstrap/bootstrap.js"></script> -->
    
    <!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>-->
    
    

    <link rel="stylesheet" type="text/css" href="assets/easyui/themes/default/easyui.css">
	<script type='text/javascript' src="assets/bootstrap/js/jquery-1.12.4.min.js"></script>

    <script type="text/javascript" src="assets/easyui/jquery.easyui.min.js"></script>
    
    <script>
	
	function konfirmasi()
	{

        var reqPassword = $('#reqPassword').val();
        reqPassword = reqPassword.trim();

        var reqPassword2 = $('#reqPassword2').val();
        reqPassword2 = reqPassword2.trim();

        if(reqPassword == "")
        {
            $.messager.alert('Info', "Isikan password baru.", 'warning'); 
            return;
        }

        if(reqPassword2 == "")
        {
            $.messager.alert('Info', "Isikan konfirmasi password baru.", 'warning'); 
            return;
        }

        if(reqPassword == reqPassword2)
        {

    		if(confirm("Lanjutkan proses reset password?"))	
    		{				
    			var win = $.messager.progress({
    				title:'LCCM | PT PLNNP',
    				msg:'proses reset password...'
    			});		
    			$("#reqSubmit").click();
    		}

        }
        else
        {
            $.messager.alert('Info', "Password tidak sesuai.", 'warning'); 
        }
	}

    /*<![CDATA[*/
    
    /*]]>*/
    </script>
    
  </body>
</html>
