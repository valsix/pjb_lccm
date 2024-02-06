<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/Wo_Pm");
$this->load->model("base-app/Distrik");
$this->load->model("base-app/BlokUnit");
$this->load->model("base-app/UnitMesin");
$this->load->model("base-app/M_Group_Pm_Lccm");




$pgreturn= str_replace("_add", "", $pg);

$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$reqId = $this->input->get("reqId");
$reqTahun = $this->input->get("reqTahun");
$reqBlokId = $this->input->get("reqBlokId");
$reqDistrikId = $this->input->get("reqDistrikId");

$reqSiteId = $this->input->get("reqBlokId");
$reqPmNum = $this->input->get("reqPmNum");
$reqJpNum = $this->input->get("reqJpNum");





$set= new Wo_Pm();

if($reqId == "")
{
    $reqMode = "insert";
}
else
{
    $reqMode = "update";

    $statement = " AND A.ASSETNUM = '".$reqId."' AND A.PM_YEAR = '".$reqTahun."' AND A.PMNUM = '".$reqPmNum."' AND A.JPNUM = '".$reqJpNum."'  ";
    $set->selectByParamsDetail(array(), -1, -1, $statement);
    // echo $set->query;exit;
    $set->firstRow();
    $reqId= $reqId;
    $reqAssetNum= $set->getField("ASSETNUM");
    $reqDistrikId= $set->getField("KODE_DISTRIK");
    $reqDistrikIdInfo= $set->getField("DISTRIK_ID");
    $reqBlokId= $set->getField("SITEID");
    $reqBlokIdInfo= $set->getField("BLOK_UNIT_ID");
    $reqUnitMesinId= $set->getField("KODE_UNIT_M");
    $reqTahun= $set->getField("PM_YEAR");
    $reqDuration= $set->getField("DURATION_HOURS");
    $reqPmCount= $set->getField("PM_IN_YEAR");
    $reqPmNum= $set->getField("PMNUM");
    $reqGroupPm= $set->getField("GROUP_PM");
    $reqJpNum= $set->getField("JPNUM");
    $reqNumberPersonal= $set->getField("NO_PERSONAL");

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
                               <input autocomplete="off" readonly  <?=$readonly?> required  class="easyui-validatebox textbox form-control" type="text" name="reqAssetNum"  id="reqAssetNum" value="<?=$reqAssetNum?>" <?=$disabled?> style="width:100%" />
                            </div>
                            <div class="col-md-1" id="">
                              <a id="btnAdd" onclick="openEquipment()"><i class="fa fa-plus-square fa-lg" aria-hidden="true"></i> </a>
                            </div>
                       </div>
                   </div>
                </div>

               
                <div class="form-group" id="parentname"> 
                    <label class="control-label col-md-2">PM No</label>
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                                <input autocomplete="off"  <?=$readonly?> required   class="easyui-validatebox textbox form-control" type="text" name="reqPmNum"  id="reqPmNum" value="<?=$reqPmNum?>" <?=$disabled?> style="width:100%" />
                            </div>
                       </div>
                   </div>
                </div>

                <div class="form-group" id="parentname"> 
                    <label class="control-label col-md-2">Std Job no</label>
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                                <input autocomplete="off"  <?=$readonly?>   class="easyui-validatebox textbox form-control" type="text" name="reqJpNum"  id="reqJpNum" value="<?=$reqJpNum?>" <?=$disabled?> style="width:100%" />
                            </div>
                       </div>
                   </div>
                </div>

                <div class="form-group" id="parentname"> 
                    <label class="control-label col-md-2">Number Personal</label>
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                                <input autocomplete="off"  <?=$readonly?>  required  class="easyui-validatebox textbox form-control" type="text" name="reqNumberPersonal"  id="reqNumberPersonal" value="<?=$reqNumberPersonal?>" <?=$disabled?> style="width:100%" />
                            </div>
                       </div>
                   </div>
                </div>

                <div class="form-group" id="parentname"> 
                    <label class="control-label col-md-2">Duration (Hours)</label>
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                                <input autocomplete="off"  <?=$readonly?>  required  class="easyui-validatebox textbox form-control" type="text" name="reqDuration"  id="reqDuration" value="<?=$reqDuration?>" <?=$disabled?> style="width:100%" />
                            </div>
                       </div>
                   </div>
                </div>

                <div class="form-group" id="parentname"> 
                    <label class="control-label col-md-2">PM Count (Yearly)</label>
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                                <input autocomplete="off"  <?=$readonly?> required   class="easyui-validatebox textbox form-control" type="text" name="reqPmCount"  id="reqPmCount" value="<?=$reqPmCount?>" <?=$disabled?> style="width:100%" />
                            </div>
                       </div>
                   </div>
                </div>

                <div class="form-group" id="parentname"> 
                    <label class="control-label col-md-2">PM Year</label>
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <div class='col-md-6'>
                                <input autocomplete="off" maxlength="4" readonly <?=$readonly?>   class="easyui-validatebox textbox form-control" type="text" name="reqTahun"  id="reqTahun" value="<?=$reqTahun?>" <?=$disabled?> style="width:100%" />
                            </div>
                       </div>
                   </div>
                </div>

               
       <input type="hidden" name="reqId" value="<?=$reqId?>" />
       <input type="hidden" name="reqMode" value="<?=$reqMode?>" />
       <input type="hidden" name="reqSiteId" value="<?=$reqSiteId?>" />
       <input type="hidden" name="reqAssetNumOld" value="<?=$reqAssetNum?>" />
       <input type="hidden" name="reqTahunOld" value="<?=$reqTahun?>" />
       <input type="hidden" name="reqPmNumOld" value="<?=$reqPmNum?>" />


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

   
    $('#reqTahun,#reqDuration,#reqPmCount,#reqNumberPersonal').on('input blur paste', function(){
        var numeric = $(this).val().replace(/\D/g, '');
        $(this).val(numeric);
    });

    $('#reqDistrikId').on('change', function() {
    // $("#blok").empty();
    var reqDistrikId= this.value;

    $.getJSON("json-app/blok_unit_json/filter_blok?reqDistrikId="+reqDistrikId,
        function(data)
        {
            // console.log(data);
            $("#reqBlokId option").remove();
            $("#reqUnitMesinId option").remove();
            $("#reqBlokId").attr("readonly", false); 
            $("#reqBlokId").append('<option value="" >Pilih Blok Unit</option>');
            jQuery(data).each(function(i, item){
                $("#reqBlokId").append('<option value="'+item.KODE+'" >'+item.text+'</option>');
            });
        });
    
    });

    $('#reqBlokId').on('change', function() {
    // $("#blok").empty();
    var reqDistrikId= $("#reqDistrikId").val();
    var reqBlokId= this.value;

    $.getJSON("json-app/unit_mesin_json/filter_unit?reqDistrikId="+reqDistrikId+"&reqBlokId="+reqBlokId,
        function(data)
        {
            console.log(data);
            $("#reqUnitMesinId option").remove();
            $("#reqUnitMesinId").attr("readonly", false); 
            jQuery(data).each(function(i, item){
                $("#reqUnitMesinId").append('<option value="'+item.KODE+'" >'+item.text+'</option>');
            });
        });
    
    });


    function submitForm(){

        $('#ff').form('submit',{
            url:'json-app/wo_pm_json/add',
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
                    $.messager.alertLink('Info', infoSimpan, 'info', "app/index/<?=$pgreturn?>?reqTahun=<?=$reqTahun?>&reqGroupPm=<?=$reqGroupPm?>");
            }
        });        
    }

    function clearForm(){
        $('#ff').form('clear');
    }   
</script>