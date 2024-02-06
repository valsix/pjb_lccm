<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/M_Inflasi");


$pgreturn= str_replace("_add", "", $pg);

$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$reqId = $this->input->get("reqId");
$reqLihat = $this->input->get("reqLihat");


$set= new M_Inflasi();

if($reqId == "")
{
    $reqMode = "insert";
}
else
{
    $reqMode = "update";

	$statement = " AND A.ID = '".$reqId."' ";
    $set->selectByParamsAll(array(), -1, -1, $statement);
    // echo $set->query;exit;
    $set->firstRow();
    $reqId= $set->getField("ID");
    $reqTahun= $set->getField("TAHUN");
    $reqFP1= $set->getField("FP1");
    $reqStatus= $set->getField("STATUS");
    $reqF= dotToComma($set->getField("F"));


}

$disabled="";

if($reqLihat ==1)
{
    $disabled="disabled";  
}

$tahun = date("Y");




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

<div class="col-md-12">
    
  <div class="judul-halaman"> <a href="iframe/index/<?=$pgreturn?>">Data Inflasi</a> &rsaquo; Kelola Inflasi</div>

    <div class="konten-area">
        <div class="konten-inner">

            <div>

                <form id="ff" class="easyui-form form-horizontal" method="post" novalidate enctype="multipart/form-data">

                    <div class="page-header">
                        <h3><i class="fa fa-file-text fa-lg"></i> Inflasi</h3>       
                    </div>

                    <div class="form-group" >  
                        <label class="control-label col-md-2">Tahun</label>
                        <div class='col-md-4'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                   <input autocomplete="off" maxlength="4"  class="easyui-validatebox textbox form-control" type="text" name="reqTahun"  id="reqTahun" value="<?=$reqTahun?>" <?=$disabled?> style="width:50%" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" >  
                        <label class="control-label col-md-2">F</label>
                        <div class='col-md-4'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                   <input autocomplete="off" maxlength="6"  class="easyui-validatebox textbox form-control" type="text" name="reqF"  id="reqF" value="<?=$reqF?>" <?=$disabled?> style="width:50%" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="form-group" >  
                        <label class="control-label col-md-2">FP1</label>
                        <div class='col-md-4'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                   <input autocomplete="off"  class="easyui-validatebox textbox form-control" type="text" name="reqFP1"  id="reqFP1" value="<?=$reqFP1?>" disabled style="width:50%" />
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <div class="form-group" >  
                        <label class="control-label col-md-2">Status</label>
                        <div class='col-md-4'>
                            <div class='form-group'>
                                <div class='col-md-7'>
                                  <select class="form-control"  name="reqStatus" id="reqStatus">
                                    <option value="" <? if ($reqStatus=="") echo 'selected'?>>Need Update</option>
                                    <option value="1" <? if ($reqStatus=="1") echo 'selected'?>>Sesuai BI</option>
                                  </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="reqId" value="<?=$reqId?>" />
                    <input type="hidden" name="reqMode" value="<?=$reqMode?>" />
                    <input type="hidden" name="reqTahunOld" value="<?=$reqTahun?>" />

                </form>

            </div>
            <?
            if($reqLihat ==1)
            {}
            else
            {
            ?>
            <div style="text-align:center;padding:5px">
                <a href="javascript:void(0)" class="btn btn-primary" onclick="submitForm()">Simpan</a>

              

            </div>
            <?
            }
            ?>
            
        </div>
    </div>
    
</div>

<script>

       $("#reqF").keydown(function (event) {
        if (event.shiftKey == true) {
            event.preventDefault();
        }

        // console.log(event.keyCode);

        if ((event.keyCode >= 48 && event.keyCode <= 57) || 
            (event.keyCode >= 96 && event.keyCode <= 105) || 
            event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 ||
            event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190 || event.keyCode == 188) {

        } else {
            event.preventDefault();
        }

        if($(this).val().indexOf('.') !== -1 && event.keyCode == 190)
            event.preventDefault(); 

    });


function submitForm(){
   
    $('#ff').form('submit',{
        url:'json-app/inflasi_json/addm',
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
                $.messager.alertLink('Info', infoSimpan, 'info', "iframe/index/<?=$pgreturn?>");
        }
    });
}

function clearForm(){
    $('#ff').form('clear');
}   
</script>