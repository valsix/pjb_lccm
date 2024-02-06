<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/M_Group_Pm_Lccm");
$this->load->model("base-app/Distrik");
$this->load->model("base-app/BlokUnit");
$this->load->model("base-app/UnitMesin");


$pgreturn= str_replace("_add", "", $pg);

$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$reqId = $this->input->get("reqId");
$reqLihat = $this->input->get("reqLihat");
$reqBlokId = $this->input->get("reqBlokId");
$reqDistrikId = $this->input->get("reqDistrikId");
$reqUnitId = $this->input->get("reqUnitId");


$reqSiteId = $this->input->get("reqBlokId");



$set= new M_Group_Pm_Lccm();

if($reqId == "")
{
    $reqMode = "insert";
}
else
{
    $reqMode = "update";

    $statement = " AND A.GROUP_PM = '".$reqId."' AND A.KODE_BLOK = '".$reqBlokId."' AND A.KODE_DISTRIK = '".$reqDistrikId."'  AND A.KODE_UNIT = '".$reqUnitId."' ";
    $set->selectByParams(array(), -1, -1, $statement);
    // echo $set->query;exit;
    $set->firstRow();
    $reqId= $reqId;
    $reqGroupPM= $set->getField("GROUP_PM");
    $reqDistrikId= $set->getField("KODE_DISTRIK");
    $reqDistrikIdInfo= $set->getField("DISTRIK_ID");
    $reqBlokId= $set->getField("KODE_BLOK");
    $reqBlokIdInfo= $set->getField("BLOK_UNIT_ID");
    $reqUnitMesinId= $set->getField("KODE_UNIT");
    // $reqTahunAwalReadonly= " readonly ";


}

$disabled="";

if($reqLihat ==1)
{
    $disabled="disabled";  
}


$set= new Distrik();
$arrdistrik= [];
$statement="  ";
$set->selectByParamsAreaDistrik(array(), -1,-1,$statement);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("DISTRIK_ID");
    $arrdata["text"]= $set->getField("NAMA");
    $arrdata["KODE"]= $set->getField("KODE");
    array_push($arrdistrik, $arrdata);
}
unset($set);

$set= new BlokUnit();
$arrblok= [];

if(empty($reqId))
{
    $statement=" AND 1=2 ";
}
else
{
    $statement=" AND A.KODE <> ''  AND A.DISTRIK_ID = '".$reqDistrikIdInfo."' ";
}


$set->selectByParams(array(), -1,-1,$statement);
    // echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("BLOK_UNIT_ID");
    $arrdata["text"]= $set->getField("KODE")." - ".$set->getField("NAMA");
    $arrdata["KODE"]= $set->getField("KODE");
    array_push($arrblok, $arrdata);
}
unset($set);

if(empty($reqBlokId))
{
    $statement=" AND 1=2";
}
else
{
    $statement=" AND A.KODE <> ''  AND A.BLOK_UNIT_ID = '".$reqBlokIdInfo."'  AND A.DISTRIK_ID = '".$reqDistrikIdInfo."' ";
}

$set= new UnitMesin();
$arrunitmesin= [];
$set->selectByParams(array(), -1,-1,$statement);
    // echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("UNIT_MESIN_ID");
    $arrdata["text"]= $set->getField("NAMA");
    $arrdata["KODE"]= $set->getField("KODE");
    array_push($arrunitmesin, $arrdata);
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

  <div class="judul-halaman"> <a href="app/index/<?=$pgreturn?>">Data <?=$pgtitle?></a> &rsaquo; Kelola <?=$pgtitle?></div>

  <div class="konten-area">
    <div class="konten-inner">

        <div>

            <form id="ff" class="easyui-form form-horizontal" method="post" novalidate enctype="multipart/form-data">

                <div class="page-header">
                    <h3><i class="fa fa-file-text fa-lg"></i> <?=$pgtitle?></h3>       
                </div>


                <div class="form-group">  
                    <label class="control-label col-md-2 ">Distrik <span class="required-field"></span></label>
                    <div class='col-md-6'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                                <select class="form-control jscaribasicmultiple"   <?=$readonly?> required id="reqDistrikId" <?=$disabled?> name="reqDistrikId"  style="width:100%;" >
                                    <option value="" >Pilih Distrik</option>
                                    <?
                                    foreach($arrdistrik as $item) 
                                    {
                                        $selectvalid= $item["id"];
                                        $selectvaltext= $item["text"];
                                        $selectvalkode= $item["KODE"];

                                        $selected="";
                                        if($selectvalkode == $reqDistrikId)
                                        {
                                            $selected="selected";
                                        }
                                        ?>
                                        <option value="<?=$selectvalkode?>" <?=$selected?>><?=$selectvaltext?></option>
                                        <?
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">  
                    <label class="control-label col-md-2">Blok <span class="required-field"></span></label>
                    <div class='col-md-6'>
                        <div class='form-group'>
                            <div class='col-md-11' id="blok">
                                <select class="form-control jscaribasicmultiple"  required  <?=$readonlyfilter?> <?=$readonly?> id="reqBlokId"   name="reqBlokId"  style="width:100%;"  >
                                    <option value="" >Pilih Blok Unit</option>
                                    <?
                                    foreach($arrblok as $item) 
                                    {
                                        $selectvalid= $item["id"];
                                        $selectvaltext= $item["text"];
                                        $selectvalkode= $item["KODE"];
                                        $selected="";
                                        if($selectvalkode==$reqBlokId)
                                        {
                                            $selected="selected";
                                        }

                                        ?>
                                        <option value="<?=$selectvalkode?>" <?=$selected?>><?=$selectvaltext?></option>

                                        <?
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">Unit Mesin <span class="required-field"></span> </label>
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <div class='col-md-11'  id="unit">
                                <select class="form-control jscaribasicmultiple"  required id="reqUnitMesinId" <?=$disabled?> name="reqUnitMesinId"  style="width:100%;" >
                                    <option value="" >Pilih Unit Mesin</option>
                                    <?
                                    foreach($arrunitmesin as $item) 
                                    {
                                        $selectvalid= $item["id"];
                                        $selectvaltext= $item["text"];
                                        $selectvalkode= $item["KODE"];
                                        $selected="";
                                        if($selectvalkode == $reqUnitMesinId)
                                        {
                                            $selected="selected";
                                        }

                                        ?>
                                        <option value="<?=$selectvalkode?>" <?=$selected?>><?=$selectvaltext?></option>

                                        <?
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

               

            <div class="form-group" >  
                <label class="control-label col-md-2">Group PM </label>
                <div class='col-md-4'>
                    <div class='form-group'>
                        <div class='col-md-11'>
                           <input autocomplete="off"  <?=$readonly?>  class="easyui-validatebox textbox form-control" type="text" name="reqGroupPM"  id="reqGroupPM" required value="<?=$reqGroupPM?>" <?=$disabled?> style="width:100%" />
                       </div>
                   </div>
               </div>
            </div>

          

       <input type="hidden" name="reqId" value="<?=$reqId?>" />
       <input type="hidden" name="reqMode" value="<?=$reqMode?>" />
       <input type="hidden" name="reqSiteId" value="<?=$reqSiteId?>" />
       <input type="hidden" name="reqGroupPMOld" value="<?=$reqGroupPM?>" />
       <input type="hidden" name="reqUnitMesinOld" value="<?=$reqUnitMesinId?>" />
       <input type="hidden" name="reqDistrikIdOld" value="<?=$reqDistrikId?>" />


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
            $("#reqBlokId").append('<option value="" >Pilih Blok</option>');
            $("#reqUnitMesinId").append('<option value="" >Pilih Unit Mesin</option>');
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
            $("#reqUnitMesinId").append('<option value="" >Pilih Unit Mesin</option>');
            jQuery(data).each(function(i, item){
                $("#reqUnitMesinId").append('<option value="'+item.KODE+'" >'+item.text+'</option>');
            });
        });
    
    });


    function submitForm(){


        $('#ff').form('submit',{
            url:'json-app/group_pm_json/add',
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