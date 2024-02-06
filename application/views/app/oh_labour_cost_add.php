<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/OhLabourCost");
$this->load->model("base-app/Asset_Lccm");
$this->load->model("base-app/OhType");


$pgreturn= str_replace("_add", "", $pg);

$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$reqId = $this->input->get("reqId");
$reqOh = $this->input->get("reqOh");
$reqAssetNum = $this->input->get("reqAssetNum");
$reqLihat = $this->input->get("reqLihat");


$set= new OhLabourCost();

if($reqId == "")
{
    $reqMode = "insert";
}
else
{
    $reqMode = "update";

    $statement = "  AND A.OH_TYPE = '".$reqId."' AND A.ASSETNUM = '".$reqAssetNum."' ";
    $set->selectByParams(array(), -1, -1, $statement);
    // echo $set->query;exit;
    $set->firstRow();
    $reqAssetNum= $set->getField("ASSETNUM");
    $reqOhType= $set->getField("OH_TYPE");
    $reqDuration= $set->getField("DURATION_HOURS");
    $reqNumberPersonal= $set->getField("NO_PERSONAL");

}

$disabled="";

if($reqLihat ==1)
{
    $disabled="disabled";  
}

$readonly="";
if(!empty($reqId))
{
    // $readonly="readonly";

}


$set= new OhType();
$arrohtype= [];

$statement=" ";
$set->selectByParams(array(), -1,-1,$statement);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("OH_TYPE");
    $arrdata["text"]= $set->getField("OH_TYPE");
    array_push($arrohtype, $arrdata);
}
unset($set);



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

  <div class="judul-halaman"> <a href="app/index/<?=$pgreturn?>">Data Master Oh Labor</a> &rsaquo; Kelola Master Oh Labor</div>

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
                            <div class='col-md-9'>
                              <input autocomplete="off" readonly  <?=$readonly?> required  class="easyui-validatebox textbox form-control" type="text" name="reqAssetNum"  id="reqAssetNum" value="<?=$reqAssetNum?>" <?=$disabled?> style="width:100%" />
                            </div>
                            <div class="col-md-1" id="">
                              <a id="btnAdd" onclick="openEquipment()"><i class="fa fa-plus-square fa-lg" aria-hidden="true"></i> </a>
                            </div>

                       </div>
                   </div>
                </div>


                <div class="form-group">  
                    <label class="control-label col-md-2">Oh Type  </label>
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                                <select class="form-control jscaribasicmultiple " id="reqOhType" <?=$disabled?> name="reqOhType"  style="width:100%;" >
                                    <option value="" >Pilih Oh Type </option>
                                    <?
                                    foreach($arrohtype as $item) 
                                    {
                                        $selectvalid= $item["id"];
                                        $selectvaltext= $item["text"];

                                        $selected="";
                                        if($selectvalid==$reqOhType)
                                        {
                                            $selected="selected";
                                        }
                                        ?>
                                        <option value="<?=$selectvalid?>" <?=$selected?>><?=$selectvaltext?></option>
                                        <?
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- <div class="form-group" >  
                    <label class="control-label col-md-2">Oh Type </label>
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                               <input autocomplete="off" required=""class="easyui-validatebox textbox form-control" type="text" name="reqOhType"  id="reqOhType" value="<?=$reqOhType?>" <?=$disabled?> style="width:50%" />
                           </div>
                       </div>
                   </div>
                </div> -->

                <div class="form-group" id="parentname"> 
                    <label class="control-label col-md-2">Duration (Hours)</label>
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                                <input autocomplete="off"  <?=$readonly?>   class="easyui-validatebox textbox form-control" type="text" name="reqDuration"  id="reqDuration" value="<?=$reqDuration?>" <?=$disabled?> style="width:100%" />
                            </div>
                       </div>
                   </div>
                </div>

                <div class="form-group" id="parentname"> 
                    <label class="control-label col-md-2">Number Personal</label>
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                                <input autocomplete="off"  <?=$readonly?>    class="easyui-validatebox textbox form-control" type="text" name="reqNumberPersonal"  id="reqNumberPersonal" value="<?=$reqNumberPersonal?>" <?=$disabled?> style="width:100%" />
                            </div>
                       </div>
                   </div>
                </div>



       <input type="hidden" name="reqId" value="<?=$reqId?>" />
       <input type="hidden" name="reqMode" value="<?=$reqMode?>" />
       <input type="hidden" name="reqAssetNumOld" value="<?=$reqAssetNum?>" />
       <input type="hidden" name="reqOhTypeOld" value="<?=$reqOhType?>" />

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

    function openEquipment()
    {
        openAdd('iframe/index/lookup_equipment');
    }


    function setEquipment(values)
    {
        // console.log(values);
        $('#reqAssetNum').val(values.ASSETNUM);
    }

    $('#reqDuration,#reqNumberPersonal').on('input blur paste', function(){
        var numeric = $(this).val().replace(/\D/g, '');
        $(this).val(numeric);
    });


    function submitForm(){
        $('#ff').form('submit',{
            url:'json-app/oh_labour_cost_json/add',
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