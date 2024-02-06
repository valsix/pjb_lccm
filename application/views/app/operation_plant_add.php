<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/Operation");
$this->load->model("base-app/Distrik");
$this->load->model("base-app/BlokUnit");
$this->load->model("base-app/UnitMesin");
$this->load->model("base-app/T_Energy_Price_Lccm");



$pgreturn= str_replace("_add", "", $pg);

$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$reqTahun= $this->input->get("reqTahun");

$set= new Operation();
$statement = " AND A.OPR_YEAR = ".$reqTahun;
$set->selectplant(array(), -1, -1, $statement);
// echo $set->query;exit;
$set->firstRow();
$reqId= $set->getField("OPR_YEAR");
$reqEmploySalary= $set->getField("EMPLOY_SALARY");
$reqOperationHourYear= $set->getField("OPR_HOURS_IN_YEAR");
$reqGrosProdHourYear= $set->getField("PROD_IN_YEAR");
$reqEffCost= $set->getField("EFF_PRICE");
$reqEnergyPrice= $set->getField("ENERGY_PRICE");
$reqDistrikIdInfo= $set->getField("DISTRIK_ID");
$reqDistrik= $set->getField("KODE_DISTRIK");
$reqBlokIdInfo= $set->getField("BLOK_UNIT_ID");
$reqBlok= $set->getField("KODE_BLOK");

$reqUnitMesin= $set->getField("KODE_UNIT_M");

$reqMode= "insert";
if(!empty($reqId))
    $reqMode= "update";

$disabled="";

if($reqLihat ==1)
{
    $disabled="disabled";  
}

$readonlyunit="readonly";
if(!empty($reqId))
{
    $readonlyunit="";

}

$statement="";

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
    $statement=" AND A.KODE <> '' AND A.DISTRIK_ID = '".$reqDistrikIdInfo."' ";
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

if(empty($reqId))
{
    $statement=" AND 1=2";
}
else
{
    $statement=" AND B.KODE= '".$reqDistrik."' AND C.KODE= '".$reqBlok."'  ";

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

                    <div class="form-group">  
                        <label class="control-label col-md-3 ">Distrik <span class="required-field"></span></label>
                        <div class='col-md-6'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <select class="form-control jscaribasicmultiple"   <?=$readonly?> required id="reqDistrikId" <?=$disabled?> name="reqDistrik"  style="width:100%;" >
                                        <option value="" >Pilih Distrik</option>
                                        <?
                                        foreach($arrdistrik as $item) 
                                        {
                                            $selectvalid= $item["id"];
                                            $selectvaltext= $item["text"];
                                            $selectvalkode= $item["KODE"];

                                            $selected="";
                                            if($selectvalkode == $reqDistrik)
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
                        <label class="control-label col-md-3">Blok <span class="required-field"></span></label>
                        <div class='col-md-6'>
                            <div class='form-group'>
                                <div class='col-md-11' id="blok">
                                    <select class="form-control jscaribasicmultiple"  required  <?=$readonlyfilter?> <?=$readonly?> id="reqBlokId"   name="reqBlok"  style="width:100%;"  >
                                        <option value="" >Pilih Blok Unit</option>
                                        <?
                                        foreach($arrblok as $item) 
                                        {
                                            $selectvalid= $item["id"];
                                            $selectvaltext= $item["text"];
                                            $selectvalkode= $item["KODE"];
                                            $selected="";
                                            if($selectvalkode==$reqBlok)
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
                        <label class="control-label col-md-3">Unit Mesin <span class="required-field"></span> </label>
                        <div class='col-md-4'>
                            <div class='form-group'>
                                <div class='col-md-11'  id="unit">
                                    <select class="form-control jscaribasicmultiple"  required id="reqUnitMesinId" <?=$disabled?> name="reqUnitMesin"  style="width:100%;" >
                                        <option value="" >Pilih Unit Mesin</option>
                                        <?
                                        foreach($arrunitmesin as $item) 
                                        {
                                            $selectvalid= $item["id"];
                                            $selectvaltext= $item["text"];
                                            $selectvalkode= $item["KODE"];
                                            $selected="";
                                            if($selectvalkode == $reqUnitMesin)
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
                        <label class="control-label col-md-3">Employ Salary</label>
                        <div class='col-md-4'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <input autocomplete="off" <?=$readonly?> required class="easyui-validatebox textbox form-control" type="text" name="reqEmploySalary" id="reqEmploySalary" value="<?=toThousandComma($reqEmploySalary)?>" <?=$disabled?> style="width:100%"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" >  
                        <label class="control-label col-md-3">Operation Hour in 1 year</label>
                        <div class='col-md-4'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <input autocomplete="off" <?=$readonly?> required class="vangkaglobal easyui-validatebox textbox form-control" type="text" name="reqOperationHourYear" id="reqOperationHourYear" value="<?=$reqOperationHourYear?>" <?=$disabled?> style="width:100%"  />
                                </div>
                            </div>
                        </div>
                    </div>
                   
                    <div class="form-group" > 
                        <label class="control-label col-md-3">Price Electricity</label>
                        <div class='col-md-4'>
                            <div class='form-group'>
                                <div class='col-md-6'>
                                    <input autocomplete="off"  <?=$readonly?> readonly  class="easyui-validatebox textbox form-control" type="text" name="reqEnergyPrice"  id="reqEnergyPrice" value="<?=$reqEnergyPrice?>" <?=$disabled?> style="width:100%" />
                                </div>
                                <div id="energykosong">
                                    <p> <span class="required-field"></span> Data Energy Price belum ada</p>
                                </div>
                              <!--  <div class="col-md-1" id="">
                                <a id="btnAdd" onclick="openEnergy()"><i class="fa fa-plus-square fa-lg" aria-hidden="true"></i> </a>
                               </div> -->
                           </div>
                       </div>
                    </div>

                    <div class="form-group" >  
                        <label class="control-label col-md-3">Gross Production Hour in 1 year </label>
                        <div class='col-md-4'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <input autocomplete="off" <?=$readonly?> required class="vangkaglobal easyui-validatebox textbox form-control" type="text" name="reqGrosProdHourYear" id="reqGrosProdHourYear" value="<?=$reqGrosProdHourYear?>" <?=$disabled?> style="width:100%" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" >  
                        <label class="control-label col-md-3">Effisiency Cost</label>
                        <div class='col-md-4'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <input autocomplete="off" <?=$readonly?> required class=" easyui-validatebox textbox form-control" type="text" name="reqEffCost" id="reqEffCost" value="<?=toThousandComma($reqEffCost)?>" <?=$disabled?> style="width:100%"/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="reqId" value="<?=$reqId?>" />
                    <input type="hidden" name="reqMode" value="<?=$reqMode?>" />
                    <input type="hidden" name="reqTahun" value="<?=$reqTahun?>" />
                    
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
    $("#energykosong").hide();
    $('#reqDistrikId').on('change', function() {
    // $("#blok").empty();
    var reqDistrikId= this.value;
    $("#reqEnergyPrice").val('');

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
            // console.log(data);
            $("#reqUnitMesinId option").remove();
            $("#reqUnitMesinId").attr("readonly", false); 
            $("#reqUnitMesinId").append('<option value="" >Pilih Unit Mesin</option>');
            jQuery(data).each(function(i, item){
                $("#reqUnitMesinId").append('<option value="'+item.KODE+'" >'+item.text+'</option>');
            });
        });


    $.getJSON("json-app/energi_price_json/filter_unit?reqTahun=<?=$reqTahun?>&reqDistrikId="+reqDistrikId+"&reqBlokId="+reqBlokId,
        function(data)
        {
            // console.log(data);
            $("#reqEnergyPrice").val('');
            // console.log(data.length);
            if(data.length > 0)
            {
               $("#energykosong").hide();
                jQuery(data).each(function(i, item){
                    $("#reqEnergyPrice").val(item.text);
                });
            }
            else
            {
                $("#energykosong").show();
                $("#reqEnergyPrice").val('');
            }
        });
    
    });

    function openEnergy()
    {
        openAdd('iframe/index/lookup_energy?reqTahun=<?=$reqTahun?>');
    }

    function setEnergy(values)
    {
        // console.log(values);
        $('#reqEnergyPrice').val(values.ENERGY_PRICE);
        $('#reqDistrik').val(values.KODE_DISTRIK);
        $('#reqBlok').val(values.KODE_BLOK);

        $.getJSON("json-app/unit_mesin_json/filter_unit?reqDistrikId="+values.KODE_DISTRIK+"&reqBlokId="+values.KODE_BLOK,
            function(data)
            {
                // console.log(data);
                $("#reqUnitMesin option").remove();
                $("#reqUnitMesin").attr("readonly", false); 
                $("#reqUnitMesin").append('<option value="" >Pilih Unit Mesin</option>');
                jQuery(data).each(function(i, item){
                    $("#reqUnitMesin").append('<option value="'+item.KODE+'" >'+item.text+'</option>');
                });
            });

    }

    $("#reqEmploySalary,#reqEffCost").keydown(function (event) {
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

    $('.vangkaglobal').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9\,]/g, '');
    });

    function submitForm(){

        $('#ff').form('submit',{
            url:'json-app/operation_json/addplant',
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
                    $.messager.alertLink('Info', infoSimpan, 'info', "app/index/<?=$pgreturn?>_add?reqTahun=<?=$reqTahun?>");
            }
        });        
    }

    function clearForm(){
        $('#ff').form('clear');
    }   
</script>