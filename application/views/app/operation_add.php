<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/Prk");
$this->load->model("base-app/Distrik");
$this->load->model("base-app/BlokUnit");
$this->load->model("base-app/UnitMesin");
$this->load->model("base-app/M_Group_Pm_Lccm");



$pgreturn= str_replace("_add", "", $pg);

$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$reqId = $this->input->get("reqId");
$reqTahun = $this->input->get("reqTahun");
$reqCost = $this->input->get("reqCost");





$set= new Prk();

if($reqId == "")
{
    $reqMode = "insert";
}
else
{
    $reqMode = "update";

    $statement = " AND A.ASSETNUM = '".$reqId."' AND A.COST_ON_ASSET = '".$reqCost."' AND A.PRK_YEAR = '".$reqTahun."' ";
    $set->selectByParamsDetail(array(), -1, -1, $statement);
    // echo $set->query;exit;
    $set->firstRow();
    $reqId= $reqId;
    $reqAssetNum= $set->getField("ASSETNUM");
    $reqTahun= $set->getField("PRK_YEAR");
    $reqDistric= $set->getField("DURATION_HOURS");
    $reqPrkCount= $set->getField("PDM_IN_YEAR");
    $reqStart= $set->getField("START_DATE");
    $reqCost= number_format( $set->getField("COST_ON_ASSET"), 0, '', '.' );
    $reqDescription= $set->getField("PDM_DESC");
    $reqAccount= $set->getField("LOAD_DERATING");
    $reqApprovalDate= dateToPageCheck($set->getField("LAST_APPR_DATE"));

    // var_dump($reqIsAsset);
    // $reqTahunAwalReadonly= " readonly ";


}

$disabled="";

if($reqLihat ==1)
{
    $disabled="disabled";  
}



$set= new M_Group_Pm_Lccm();
$arrgroup= [];
$statement="";
if(!empty($reqId))
{
   // $statement=" AND A.KODE_UNIT= '".$reqSiteId."' AND A.DISTRIK_KODE= '".$reqDistrikId."'  ";
}


$set->selectByParams(array(), -1,-1,$statement);
        // echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["text"]= $set->getField("GROUP_PM");
    array_push($arrgroup, $arrdata);
}
unset($set);





$readonly="";
if(!empty($reqId))
{
    // $readonly="readonly";

}


$readonlyfilter="";
if(empty($reqId))
{
    $readonlyfilter="readonly";

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

select[readonly].select2-hidden-accessible + .select2-container {
    pointer-events: none;
    touch-action: none;
}

select[readonly].select2-hidden-accessible + .select2-container .select2-selection {
    background: #eee;
    box-shadow: none;
}

select[readonly].select2-hidden-accessible + .select2-container .select2-selection__arrow, select[readonly].select2-hidden-accessible + .select2-container .select2-selection__clear {
    display: none;
}




</style>

<div class="col-md-12">

  <div class="judul-halaman"> <a href="javascript:history.back()">Data <?=$pgtitle?></a> &rsaquo; Kelola <?=$pgtitle?></div>

  <div class="konten-area">
    <div class="konten-inner">

        <div>

            <form id="ff" class="easyui-form form-horizontal" method="post" novalidate enctype="multipart/form-data">

                <div class="page-header">
                    <h3><i class="fa fa-file-text fa-lg"></i> <?=$pgtitle?></h3>       
                </div>


               
                <div class="form-group" >  
                    <label class="control-label col-md-2">Asset No</label>
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                               <input autocomplete="off"  <?=$readonly?> required class="easyui-validatebox textbox form-control" type="text" name="reqAssetNum"  id="reqAssetNum" value="<?=$reqAssetNum?>" <?=$disabled?> style="width:100%" />
                           </div>
                       </div>
                   </div>
                </div>

               
                <div class="form-group" id="parentname"> 
                    <label class="control-label col-md-2">PRK Year</label>
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                                <input autocomplete="off"  <?=$readonly?> readonly  maxlength="4"    class="easyui-validatebox textbox form-control" type="text" name="reqTahun"  id="reqTahun" value="<?=$reqTahun?>" <?=$disabled?> style="width:100%" />
                            </div>
                       </div>
                   </div>
                </div>

                <div class="form-group" id="parentname"> 
                    <label class="control-label col-md-2">Cost On Asset</label>
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                                <input autocomplete="off"  <?=$readonly?>    class="easyui-validatebox textbox form-control" type="text" name="reqCost"  id="reqCost" value="<?=$reqCost?>" <?=$disabled?> style="width:100%" />
                            </div>
                       </div>
                   </div>
                </div>


                <div class="form-group" id="parentname"> 
                    <label class="control-label col-md-2">Distric Code</label>
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                                <input autocomplete="off"  <?=$readonly?>    class="easyui-validatebox textbox form-control" type="text" name="reqDistric"  id="reqDistric" value="<?=$reqDistric?>" <?=$disabled?> style="width:100%" />
                            </div>
                       </div>
                   </div>
                </div>

                <div class="form-group" id="parentname"> 
                    <label class="control-label col-md-2">Account Code</label>
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                                <input autocomplete="off"  <?=$readonly?>    class="easyui-validatebox textbox form-control" type="text" name="reqAccount"  id="reqAccount" value="<?=$reqAccount?>" <?=$disabled?> style="width:100%" />
                            </div>
                       </div>
                   </div>
                </div>

                <div class="form-group" id="parentname"> 
                    <label class="control-label col-md-2">Project No</label>
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                                <input autocomplete="off"  <?=$readonly?>    class="easyui-validatebox textbox form-control" type="text" name="reqProjectNo"  id="reqProjectNo" value="<?=$reqProjectNo?>" <?=$disabled?> style="width:100%" />
                            </div>
                       </div>
                   </div>
                </div>

                <div class="form-group" id="parentname"> 
                    <label class="control-label col-md-2">Project Description</label>
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                                <textarea name="reqProjectDesc"  class="easyui-validatebox textbox form-control" id="reqProjectDesc"><?=$reqProjectDesc?></textarea>
                            </div>
                       </div>
                   </div>
                </div>

                <div class="form-group" id="parentname"> 
                    <label class="control-label col-md-2">PO No</label>
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                                <input autocomplete="off"  <?=$readonly?>    class="easyui-validatebox textbox form-control" type="text" name="reqPoNo"  id="reqPoNo" value="<?=$reqPoNo?>" <?=$disabled?> style="width:100%" />
                            </div>
                       </div>
                   </div>
                </div>


                <div class="form-group" id="parentname"> 
                    <label class="control-label col-md-2">Value Paid</label>
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                                <input autocomplete="off"  <?=$readonly?>    class="easyui-validatebox textbox form-control" type="text" name="reqValue"  id="reqValue" value="<?=$reqValue?>" <?=$disabled?> style="width:100%" />
                            </div>
                       </div>
                   </div>
                </div>

                <div class="form-group" id="parentname"> 
                    <label class="control-label col-md-2">Last Approval Date</label>
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                                <input autocomplete="off"  <?=$readonly?>  class="easyui-datebox form-control" type="text" name="reqApprovalDate"  id="reqApprovalDate" value="<?=$reqApprovalDate?>" <?=$disabled?> style="width:100%" />
                            </div>
                       </div>
                   </div>
                </div>


               
       <input type="hidden" name="reqId" value="<?=$reqId?>" />
       <input type="hidden" name="reqMode" value="<?=$reqMode?>" />
       <input type="hidden" name="reqAssetNumOld" value="<?=$reqAssetNum?>" />
       <input type="hidden" name="reqTahunOld" value="<?=$reqTahun?>" />
       <input type="hidden" name="reqCostOld" value="<?=$reqCost?>" />


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

   </form>

</div>


</div>
</div>

</div>

<script>

     var format = function(num){
        var str = num.toString().replace("", ""), parts = false, output = [], i = 1, formatted = null;
        if(str.indexOf(",") > 0) {
            parts = str.split(",");
            str = parts[0];
        }
        str = str.split("").reverse();
        for(var j = 0, len = str.length; j < len; j++) {
            if(str[j] != ".") {
                output.push(str[j]);
                if(i%3 == 0 && j < (len - 1)) {
                    output.push(".");
                }
                i++;
            }
        }
        formatted = output.reverse().join("");
        return( formatted + ((parts) ? "," + parts[1].substr(0, 2) : ""));
    };

    $('#reqCost,#reqValue').on('input blur paste', function(){
        var numeric = $(this).val().replace(/[^0-9\.]/g,'', '');
        $(this).val(format(numeric));
    });


     $('#reqTahun').on('input blur paste', function(){
        var numeric = $(this).val().replace(/\D/g, '');
        $(this).val(numeric);
    });

    function submitForm(){


        $('#ff').form('submit',{
            url:'json-app/prk_json/add',
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
                    $.messager.alertLink('Info', infoSimpan, 'info', "app/index/<?=$pgreturn?>?reqTahun=<?=$reqTahun?>");
            }
        });
       
        
    }

    function clearForm(){
        $('#ff').form('clear');
    }   
</script>