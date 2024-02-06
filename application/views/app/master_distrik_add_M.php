<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/M_Distrik");
$this->load->library('libapproval');

$pgreturn= str_replace("_add", "", $pg);

$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$reqId = $this->input->get("reqId");

$set= new M_Distrik();
if($reqId == "")
{
    $reqMode = "insert";
}
else
{
    $reqMode = "update";

	$statement = " AND A.DISTRICT_CODE = '".$reqId."' ";
    $set->selectByParams(array(), -1, -1, $statement);
    // echo $set->query;exit;
    $set->firstRow();
    $reqDistrictCode= $set->getField("DISTRICT_CODE");
    $reqEllCode= $set->getField("ELL_CODE");
    $reqMaxCode= $set->getField("MAX_CODE");
    $reqDistrictName= $set->getField("DISTRICT_NAME");
    $reqLastModDate= $set->getField("LAST_MOD_DATE");
    $reqLastModTime= $set->getField("LAST_MOD_TIME");
    $reqLongitude= $set->getField("LONGITUDE");
    $reqLatitude= $set->getField("LATITUDE");
    $reqAkronim= $set->getField("AKRONIM");

}


$disabled="";


if($reqLihat ==1)
{
    $disabled="disabled";  
}


?>
<script src='assets/multifile-master/jquery.form.js' type="text/javascript" language="javascript"></script> 
<script src='assets/multifile-master/jquery.MetaData.js' type="text/javascript" language="javascript"></script> 
<script src='assets/multifile-master/jquery.MultiFile.js' type="text/javascript" language="javascript"></script> 
<link rel="stylesheet" href="css/gaya-multifile.css" type="text/css">

<style type="text/css">
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
  color: #000000;
}
.select2-container--default .select2-search--inline .select2-search__field:focus {
  outline: 0;
  border: 1px solid #ffff;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice__display {
  cursor: default;
  padding-left: 6px;
  padding-right: 5px;
}

.select2-selection__rendered {
    line-height: 31px !important;
}
.select2-container .select2-selection--single {
    height: 35px !important;
}
.select2-selection__arrow {
    height: 34px !important;
}
</style>

<div class="col-md-12" >
    
    <div class="judul-halaman"> <a href="app/index/<?=$pgreturn?>">Data Distrik</a> &rsaquo; Kelola Distrik</div>

    <div class="konten-area">
        <div class="konten-inner" >

            <form id="ff" class="easyui-form form-horizontal" method="post" novalidate enctype="multipart/form-data">

                <div class="page-header">
                    <h3><i class="fa fa-file-text fa-lg"></i> <?=$pgtitle?></h3>       
                </div>


                <div class="form-group">  
                    <label class="control-label col-md-2">District Code</label>
                    <div class='col-md-8'>
                        <div class='form-group'>
                            <div class='col-md-4'>
                                 <input autocomplete="off" placeholder="" class="easyui-validatebox textbox form-control " type="text" name="reqDistrictCode"  id="reqDistrictCode" value="<?=$reqDistrictCode?>"  <?=$disabled?> data-options="required:true" style="width:100%" />
                            </div>
                        </div>
                    </div>
                </div>
                                                                         
                <div class="form-group">  
                    <label class="control-label col-md-2">Ell Code</label>
                    <div class='col-md-8'>
                        <div class='form-group'>
                            <div class='col-md-4'>
                                 <input autocomplete="off" class="easyui-validatebox textbox form-control " type="text" name="reqEllCode"  id="reqEllCode" value="<?=$reqEllCode?>" <?=$disabled?>  style="width:100%" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">  
                    <label class="control-label col-md-2">Max Code</label>
                    <div class='col-md-8'>
                        <div class='form-group'>
                            <div class='col-md-4'>
                                 <input autocomplete="off" class="easyui-validatebox textbox form-control " type="text" name="reqMaxCode"  id="reqMaxCode" value="<?=$reqMaxCode?>" <?=$disabled?>  style="width:100%" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">  
                    <label class="control-label col-md-2">District Name</label>
                    <div class='col-md-8'>
                        <div class='form-group'>
                            <div class='col-md-12'>
                                 <input autocomplete="off" class="easyui-validatebox textbox form-control " type="text" name="reqDistrictName"  id="reqDistrictName" value="<?=$reqDistrictName?>" <?=$disabled?> data-options="required:true" style="width:100%" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">  
                    <label class="control-label col-md-2">Last Mod Date</label>
                    <div class='col-md-8'>
                        <div class='form-group'>
                            <div class='col-md-4'>
                                 <input autocomplete="off" class="easyui-validatebox textbox form-control " type="text" name="reqLastModDate"  id="reqLastModDate" value="<?=$reqLastModDate?>" <?=$disabled?>   />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">  
                    <label class="control-label col-md-2">Last Mod Time</label>
                    <div class='col-md-8'>
                        <div class='form-group'>
                            <div class='col-md-4'>
                                 <input autocomplete="off" class="easyui-validatebox textbox form-control " type="text" name="reqLastModTime"  id="reqLastModTime" value="<?=$reqLastModTime?>" <?=$disabled?>   />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">  
                    <label class="control-label col-md-2">Longitude</label>
                    <div class='col-md-8'>
                        <div class='form-group'>
                            <div class='col-md-6'>
                                 <input autocomplete="off" class="easyui-validatebox textbox form-control " type="text" name="reqLongitude"  id="reqLongitude" value="<?=$reqLongitude?>" <?=$disabled?>  style="width:100%" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">  
                    <label class="control-label col-md-2">Latitude</label>
                    <div class='col-md-8'>
                        <div class='form-group'>
                            <div class='col-md-6'>
                                 <input autocomplete="off" class="easyui-validatebox textbox form-control " type="text" name="reqLatitude"  id="reqLatitude" value="<?=$reqLatitude?>" <?=$disabled?>  style="width:100%" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">  
                    <label class="control-label col-md-2">Akronim</label>
                    <div class='col-md-8'>
                        <div class='form-group'>
                            <div class='col-md-4'>
                                 <input autocomplete="off" class="easyui-validatebox textbox form-control " type="text" name="reqAkronim"  id="reqAkronim" value="<?=$reqAkronim?>" <?=$disabled?>  style="width:100%" />
                            </div>
                        </div>
                    </div>
                </div>
      
                <input type="hidden" name="reqId" value="<?=$reqId?>" />
                <input type="hidden" name="reqMode" value="<?=$reqMode?>" />

                <input type="hidden" name="infopg" value="<?=$pg?>" />


                <div style="text-align:center;padding:5px">
                    <a href="javascript:void(0)" class="btn btn-primary" id="reqSimpan"  onclick="submitForm()">Submit</a>
                </div>

            </form>

        </div>
    </div>
    
</div>

<script>
$(function(){
});

$(document).on('keydown', '#reqDistrictCode,#reqEllCode,#reqMaxCode', function(e) {
    if (e.keyCode == 32) return false;
});

$('#reqLastModDate').bind('keyup paste', function(){
    this.value = this.value.replace(/[^0-9]/g, '');
});



function submitForm(){
    
    $('#ff').form('submit',{
        url:'json-app/distrik_json/add',
        onSubmit:function(){

            if($(this).form('validate'))
            {
                var win = $.messager.progress({
                    title:'<?=$this->configtitle["progres"]?>',
                    msg:'proses data...'
                });
            }

            return $(this).form('enableValidation').form('validate');
        },
        success:function(data){
            $.messager.progress('close');
            // console.log(data);return false;

            data = data.split("***");
            reqId= data[0];
            infoSimpan= data[1];

            if(reqId == 'xxx')
                $.messager.alert('Info', infoSimpan, 'warning');
            else
                $.messager.alertLink('Info', infoSimpan, 'info', "app/index/<?=$pgreturn?>");
        }
    });
}

function clearForm(){
    $('#ff').form('clear');
} 
</script>