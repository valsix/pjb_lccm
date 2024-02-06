<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/Asset_Lccm");
$this->load->model("base-app/Distrik");
$this->load->model("base-app/BlokUnit");
$this->load->model("base-app/UnitMesin");
$this->load->model("base-app/M_Group_Pm_Lccm");



$pgreturn= str_replace("_add", "", $pg);

$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$reqId = $this->input->get("reqId");
$reqLihat = $this->input->get("reqLihat");
$reqBlokId = $this->input->get("reqBlokId");
$reqDistrikId = $this->input->get("reqDistrikId");

$reqSiteId = $this->input->get("reqBlokId");




$set= new Asset_Lccm();

if($reqId == "")
{
    $reqMode = "insert";
}
else
{
    $reqMode = "update";

    $statement = " AND A1.ASSETNUM = '".$reqId."'  ";
    $set->selectByParams(array(), -1, -1, $statement);
    // echo $set->query;exit;
    $set->firstRow();
    $reqId= $reqId;
    $reqAssetNum= $set->getField("ASSETNUM");
    $reqKksNo= $set->getField("KKSNUM");
    $reqParentName= $set->getField("PARENT");
    $reqParentAsset= $set->getField("M_PARENT");
    $reqDistrikId= $set->getField("KODE_DISTRIK");
    $reqDistrikIdInfo= $set->getField("DISTRIK_ID");
    $reqBlokId= $set->getField("SITEID");
    $reqBlokIdInfo= $set->getField("BLOK_UNIT_ID");
    $reqUnitMesinId= $set->getField("KODE_UNIT_M");
    $reqIsAsset= $set->getField("ASSET_LCCM");
    $reqParentChild= $set->getField("PARENT_CHILD");
    $reqDescription= $set->getField("M_DESCRIPTION");
    $reqGroupPm= $set->getField("GROUP_PM");
    $reqAssetOh= $set->getField("ASSET_OH");
    $reqInstallDate= dateToPageCheck($set->getField("INSTALLDATE"));
    $reqCapitalDate= dateToPageCheck($set->getField("CAPITAL_DATE"));
    $reqRbdId= $set->getField("RBD_ID");
    $reqAssetStatus= $set->getField("M_STATUS");
    $reqCapital= toThousandComma($set->getField("CAPITAL"));

    // var_dump($reqIsAsset);
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


input.combo-text[disabled]{
    background-color:#ccc;
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

                <!-- asset -->

                <div class="form-group" >  
                    <label class="control-label col-md-2">Asset No</label>
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                               <input autocomplete="off"  <?=$readonly?> readonly  class="easyui-validatebox textbox form-control" type="text" name="reqAssetNum"  id="reqAssetNum" value="<?=$reqAssetNum?>" <?=$disabled?> style="width:100%" />
                           </div>
                       </div>
                   </div>
                </div>

                <div class="form-group" >  
                    <label class="control-label col-md-2">Kks No</label>
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                               <input autocomplete="off"  <?=$readonly?> disabled  class="easyui-validatebox textbox form-control" type="text" name="reqKksNo"  id="reqKksNo" value="<?=$reqKksNo?>" <?=$disabled?> style="width:100%" />
                           </div>
                       </div>
                   </div>
                </div>

                <div class="form-group" >  
                    <label class="control-label col-md-2">Description</label>
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                                <textarea  class="easyui-validatebox textbox form-control" disabled name="reqDescription"  id="reqDescription"><?=$reqDescription?></textarea>
                           </div>
                       </div>
                   </div>
                </div>

                <div class="form-group" >  
                    <label class="control-label col-md-2">Rbd Id</label>
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                               <input autocomplete="off"  <?=$readonly?> disabled  class="easyui-validatebox textbox form-control" type="text" name="reqRbdId"  id="reqRbdId" value="<?=$reqRbdId?>" <?=$disabled?> style="width:100%" />
                           </div>
                       </div>
                   </div>
                </div>

                <div class="form-group" >  
                    <label class="control-label col-md-2">Parent Asset</label>
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                               <input autocomplete="off"  <?=$readonly?> disabled  class="easyui-validatebox textbox form-control" type="text" name="reqParentAsset"  id="reqParentAsset" value="<?=$reqParentAsset?>" <?=$disabled?> style="width:100%" />
                           </div>
                       </div>
                   </div>
                </div>

                <div class="form-group" >  
                    <label class="control-label col-md-2">Install Date</label>
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                               <input autocomplete="off" disabled <?=$readonly?> class="easyui-datebox" type="text" name="reqInstallDate"  id="reqInstallDate" value="<?=$reqInstallDate?>" <?=$disabled?> style="width:100%" />
                           </div>
                       </div>
                   </div>
                </div>


                <div class="form-group" >  
                    <label class="control-label col-md-2">Asset Status</label>
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                               <input autocomplete="off"  <?=$readonly?>  disabled class="easyui-validatebox textbox form-control" type="text" name="reqAssetStatus"  id="reqAssetStatus" value="<?=$reqAssetStatus?>" <?=$disabled?> style="width:50%" />
                           </div>
                       </div>
                   </div>
                </div>

                <!-- asset lccm  -->

                <div class="form-group" id="parentname"> 
                    <label class="control-label col-md-2">Parent Name</label>
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <div class='col-md-6'>
                                <input autocomplete="off"  <?=$readonly?> readonly  class="easyui-validatebox textbox form-control" type="text" name="reqParentName"  id="reqParentName" value="<?=$reqParentName?>" <?=$disabled?> style="width:100%" />
                            </div>
                           <div class="col-md-1" id="">
                            <a id="btnAdd" onclick="openEquipment()"><i class="fa fa-plus-square fa-lg" aria-hidden="true"></i> </a>
                           </div>
                       </div>
                   </div>
                </div>


                <div class="form-group">  
                    <label class="control-label col-md-2">Distrik </label>
                    <div class='col-md-6'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                                <select class="form-control jscaribasicmultiple"  <?=$readonly?> required id="reqDistrikId" <?=$disabled?> name="reqDistrikId"  style="width:100%;" >
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
                    <label class="control-label col-md-2">Blok Unit </label>
                    <div class='col-md-6'>
                        <div class='form-group'>
                            <div class='col-md-11' id="blok">
                                <select class="form-control jscaribasicmultiple"   <?=$readonlyfilter?> <?=$readonly?> id="reqBlokId"   name="reqBlokId"  style="width:100%;"  >
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
                    <label class="control-label col-md-2">Unit Mesin </label>
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <div class='col-md-11'  id="unit">
                                <select class="form-control jscaribasicmultiple"  id="reqUnitMesinId" <?=$disabled?> name="reqUnitMesinId"  style="width:100%;" >
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
                    <label class="control-label col-md-2">Asset Lccm</label>
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <div class='col-md-6'>
                                <select  name="reqIsAsset"  class="form-control jscaribasicmultiple"  id="reqIsAsset">
                                    <!-- <option value="">Pilih Status LCCM Asset</option> -->
                                    <option value="false" <? if($reqIsAsset==f) echo 'selected' ?>>NO</option>
                                    <option value="true" <? if($reqIsAsset==t) echo 'selected' ?>>YES</option>
                                </select>
                           </div>
                       </div>
                   </div>
                </div>

                <div class="form-group" >  
                    <label class="control-label col-md-2">Parent / Child </label>
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <div class='col-md-6'>
                                <select  name="reqParentChild"  class="form-control jscaribasicmultiple"  id="reqParentChild">
                                    <!-- <option value="">Pilih Status Parent / Child</option> -->
                                    <option value="Parent" <? if($reqParentChild=="Parent") echo 'selected' ?>>Parent</option>
                                    <option value="child" <? if($reqParentChild=="child") echo 'selected' ?>>Child</option>
                                </select>
                           </div>
                       </div>
                   </div>
                </div>

                <div class="form-group" >  
                    <label class="control-label col-md-2">Group Pm </label>
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                                <select class="form-control jscaribasicmultiple"   id="reqGroupPm"   name="reqGroupPm"  style="width:100%;"  >
                                    <option value="" >Pilih Group Pm</option>
                                    <?
                                    foreach($arrgroup as $item) 
                                    {
                                        $selectvalid= $item["id"];
                                        $selectvaltext= $item["text"];
                                        $selectvalkode= $item["KODE"];
                                        $selected="";
                                        if($selectvaltext==$reqGroupPm)
                                        {
                                            $selected="selected";
                                        }

                                        ?>
                                        <option value="<?=$selectvaltext?>" <?=$selected?>><?=$selectvaltext?></option>

                                        <?
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group" >  
                    <label class="control-label col-md-2">OH</label>
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <div class='col-md-6'>
                                <select  name="reqAssetOh"  class="form-control jscaribasicmultiple"  id="reqAssetOh">
                                    <!-- <option value="">Pilih Status Asset with OH</option> -->
                                    <option value="false" <? if($reqAssetOh==f) echo 'selected' ?>>NO</option>
                                    <option value="true" <? if($reqAssetOh==t) echo 'selected' ?>>YES</option>
                                </select>
                           </div>
                       </div>
                   </div>
                </div>

                <!-- capital -->

                <div class="form-group" >  
                    <label class="control-label col-md-2">Capital Date</label>
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                               <input autocomplete="off"  <?=$readonly?>  class="easyui-datebox form-control" type="text" name="reqCapitalDate"  id="reqCapitalDate" value="<?=$reqCapitalDate?>" <?=$disabled?> style="width:100%" />
                           </div>
                       </div>
                   </div>
                </div>

                <div class="form-group" >  
                    <label class="control-label col-md-2">Capital</label>
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                               <input autocomplete="off"  <?=$readonly?>  required class="easyui-validatebox textbox form-control" type="text" name="reqCapital"  id="reqCapital" value="<?=$reqCapital?>" <?=$disabled?> style="width:50%" />
                           </div>
                       </div>
                   </div>
                </div>




          

       <input type="hidden" name="reqId" value="<?=$reqId?>" />
       <input type="hidden" name="reqMode" value="<?=$reqMode?>" />
       <input type="hidden" name="reqSiteId" value="<?=$reqSiteId?>" />
       <input type="hidden" name="reqAssetNumOld" value="<?=$reqAssetNum?>" />
       <input type="hidden" name="reqCapitalDateOld" value="<?=$reqCapitalDate?>" />


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

   
    $("#reqCapital,#reqValue").keydown(function (event) {
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


    $('#parentname').hide();
    var reqPc="<?=$reqParentChild?>";
    if(reqPc=="Parent")
    {
        $('#parentname').hide();
    }
    else
    {
        $('#parentname').show();
    }
    $('#reqParentChild').on('change', function() {
        var reqParentChild= this.value;

        if(reqParentChild=="Parent")
        {
            $('#parentname').hide();
        }
        else
        {
            $('#parentname').show();
        }

    });



    function openEquipment()
    {
        openAdd('iframe/index/lookup_equipment');
    }

    function setEquipment(values)
    {
        // console.log(values);
        $('#reqParentName').val(values.ASSETNUM);
    }


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
            url:'json-app/asset_lccm_json/add',
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