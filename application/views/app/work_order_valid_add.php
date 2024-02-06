<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/WorkOrder");


$pgreturn= str_replace("_add", "", $pg);

$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$reqAssetNum = $this->input->get("reqAssetNum");
$reqTahun = $this->input->get("reqTahun");
$reqWoNum = $this->input->get("reqWoNum");

$reqLihat = $this->input->get("reqLihat");


$set= new WorkOrder();

if($reqTahun == "")
{
    $reqMode = "insert";
}
else
{
    $reqMode = "update";

	$statement = " AND A.WO_YEAR= '".$reqTahun."' AND A.ASSETNUM= '".$reqAssetNum."'  AND A.WONUM= '".$reqWoNum."' ";
    $set->selectByParamsDetail(array(), -1, -1, $statement);
    // echo $set->query;exit;
    $set->firstRow();
    $reqAssetNum= $set->getField("ASSETNUM");
    $reqDesc= $set->getField("EQUIPMENT_DESC");
    $reqWoNum= $set->getField("WONUM");
    $reqWoDesc= $set->getField("WO_DESC");
    $reqWorkType= $set->getField("WORKTYPE");
    $reqWoGroup= $set->getField("WORK_GROUP");
    $reqDowntime= $set->getField("VALIDATION_DOWNTIME");
    $reqDownNot= $set->getField("STATUS_NOT_OH_NOT_DOWNTIME");
    $reqOnHandRepair= $set->getField("ON_HAND_REPAIR");
    $reqLabor= $set->getField("JUMLAH_LABOR");


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
    
  <div class="judul-halaman"> <a href="app/index/<?=$pgreturn?>?reqTahun=<?=$reqTahun?>">Data Work Order</a> &rsaquo; Kelola Work Order</div>

    <div class="konten-area">
        <div class="konten-inner">

            <div>

                <form id="ff" class="easyui-form form-horizontal" method="post" novalidate enctype="multipart/form-data">

                    <div class="page-header">
                        <h3><i class="fa fa-file-text fa-lg"></i> Work Order</h3>       
                    </div>

                    <div class="form-group" >  
                        <label class="control-label col-md-2">Asset Number</label>
                        <div class='col-md-4'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                   <input autocomplete="off" required   class="easyui-validatebox textbox form-control" readonly type="text" name="reqAssetNum"  id="reqAssetNum" value="<?=$reqAssetNum?>" <?=$disabled?> style="width:100%" />
                                </div>
                                <div class="col-md-1" id="">
                                  <a id="btnAdd" onclick="openEquipment()"><i class="fa fa-plus-square fa-lg" aria-hidden="true"></i> </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" >  
                        <label class="control-label col-md-2">Description Asset</label>
                        <div class='col-md-4'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <textarea class="easyui-validatebox textbox form-control"  name="reqDesc" readonly id="reqDesc" ><?=$reqDesc?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" >  
                        <label class="control-label col-md-2">Work Order Number</label>
                        <div class='col-md-4'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                   <input autocomplete="off"  class="easyui-validatebox textbox form-control" required type="text" name="reqWoNum"  id="reqWoNum" value="<?=$reqWoNum?>" <?=$disabled?> style="width:100%" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" >  
                        <label class="control-label col-md-2">Work Order Description</label>
                        <div class='col-md-4'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <textarea class="easyui-validatebox textbox form-control" required  name="reqWoDesc"  id="reqWoDesc" ><?=$reqWoDesc?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" >  
                        <label class="control-label col-md-2">Work Type</label>
                        <div class='col-md-4'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                   <input autocomplete="off" required class="easyui-validatebox textbox form-control" type="text" name="reqWorkType"  id="reqWorkType" value="<?=$reqWorkType?>" <?=$disabled?> style="width:50%" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" >  
                        <label class="control-label col-md-2">Work Order Group</label>
                        <div class='col-md-4'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                   <input autocomplete="off" required  class="easyui-validatebox textbox form-control" type="text" name="reqWoGroup"  id="reqWoGroup" value="<?=$reqWoGroup?>" <?=$disabled?> style="width:60%" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" >  
                        <label class="control-label col-md-2">Downtime</label>
                        <div class='col-md-4'>
                            <div class='form-group'>
                                <div class='col-md-3'>
                                  <select class="form-control"  required  name="reqDowntime" id="reqDowntime">
                                    <option value="0" <? if ($reqDowntime=="0") echo 'selected'?>>0</option>
                                    <option value="1" <? if ($reqDowntime=="1") echo 'selected'?>>1</option>
                                  </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" >  
                        <label class="control-label col-md-2">DOWN 0 & NOT OH</label>
                        <div class='col-md-4'>
                            <div class='form-group'>
                                <div class='col-md-3'>
                                  <select class="form-control" required name="reqDownNot" id="reqDownNot">
                                    <option value="0" <? if ($reqDownNot=="0") echo 'selected'?>>0</option>
                                    <option value="1" <? if ($reqDownNot=="1") echo 'selected'?>>1</option>
                                  </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" >  
                        <label class="control-label col-md-2">Oh Hand Repair</label>
                        <div class='col-md-4'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                   <input autocomplete="off" required class="easyui-validatebox textbox form-control numeric" type="text" name="reqOnHandRepair"  id="reqOnHandRepair" value="<?=$reqOnHandRepair?>" <?=$disabled?> style="width:50%" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" >  
                        <label class="control-label col-md-2">Labor</label>
                        <div class='col-md-4'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                   <input autocomplete="off" required  class="easyui-validatebox textbox form-control numeric" type="text" name="reqLabor"  id="reqLabor" value="<?=$reqLabor?>" <?=$disabled?> style="width:50%" />
                                </div>
                            </div>
                        </div>
                    </div>

                

                    <input type="hidden" name="reqTahun" value="<?=$reqTahun?>" />
                    <input type="hidden" name="reqMode" value="<?=$reqMode?>" />
                    <input type="hidden" name="reqAssetNumOld" value="<?=$reqAssetNum?>" />
                    <input type="hidden" name="reqWoNumOld" value="<?=$reqWoNum?>" />


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

$(document).on("input", ".numeric", function() {
    this.value = this.value.replace(/\D/g,'');
});

function openEquipment()
{
    openAdd('iframe/index/lookup_equipment');
}

function setEquipment(values)
{
    $('#reqAssetNum').val(values.ASSETNUM);
    $('#reqDesc').val(values.M_DESCRIPTION);
}


function submitForm(){
   
    $('#ff').form('submit',{
        url:'json-app/work_order_json/addview',
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
            reqTahun= data[0];
            infoSimpan= data[1];

            if(reqTahun == 'xxx')
                $.messager.alert('Info', infoSimpan, 'warning');
            else
                $.messager.alertLink('Info', infoSimpan, 'info', "app/index/<?=$pgreturn?>?reqTahun=<?=$reqTahun?>");
        }
    });
}

function clearForm(){
    $('#ff').form('clear');
}   
</script>