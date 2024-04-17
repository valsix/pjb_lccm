<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/T_Energy_Price_Lccm");
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

if(empty($reqDistrikId))
{
    $reqDistrikId=$this->appdistrikkode;
}

if(empty($reqBlokId))
{
    $reqBlokId=$this->appblokunitkode;
}


$set= new T_Energy_Price_Lccm();

if($reqId == "")
{
    $reqMode = "insert";
}
else
{
    $reqMode = "update";

    $statement = " AND A.PRICE_YEAR = '".$reqId."' AND A.KODE_DISTRIK = '".$reqDistrikId."'  AND A.KODE_BLOK = '".$reqBlokId."'";
    $set->selectByParams(array(), -1, -1, $statement);
    // echo $set->query;exit;
    $set->firstRow();
    $reqId= $set->getField("PRICE_YEAR");
    $reqTahun= $set->getField("PRICE_YEAR");
    $reqDistrikId= $set->getField("KODE_DISTRIK");
    // $reqEnergyPrice= $set->getField("ENERGY_PRICE");
    $reqBlokId= $set->getField("KODE_BLOK");
    $reqUnitMesinId= $set->getField("KODE_UNIT_M");
    $reqStatus= $set->getField("STATUS");
    $reqEnergyPrice= toThousandComma($set->getField("ENERGY_PRICE"));
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

if(!empty($reqDistrikId))
{
    $statement = " AND A.KODE = '".$reqDistrikId."'";
}

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
    if(empty($reqBlokId))
    {
        $statement=" AND 1=2 ";
    }
    else
    {
         $statement = " AND A.KODE = '".$reqBlokId."'";
    }
    
}
else
{
    $statement="  ";
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


$set= new UnitMesin();
$arrunitmesin= [];
if(empty($reqId))
{
    $statement=" AND 1=2 ";
}
else
{
    $statement="  ";
}

$set->selectByParams(array(), -1,-1,$statement);
    // echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("UNIT_MESIN_ID");
    $arrdata["text"]= $set->getField("KODE")." - ".$set->getField("NAMA");
    array_push($arrunitmesin, $arrdata);
}
unset($set);


$readonly="";
if(!empty($reqId))
{
    $readonly="readonly";

}


$readonlyfilter="";
if(empty($reqId))
{
    $readonlyfilter="readonly";

}


$readonlydisses="";
if(!empty($reqDistrikId))
{
    $readonlydisses="readonly";

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
                    <label class="control-label col-md-2">Distrik </label>
                    <div class='col-md-6'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                                <select class="form-control jscaribasicmultiple"  <?=$readonly?> <?=$readonlydisses?> required id="reqDistrikId" <?=$disabled?> name="reqDistrikId"  style="width:100%;" >
                                    <option value="" >Pilih Distrik</option>
                                    <?
                                    foreach($arrdistrik as $item) 
                                    {
                                        $selectvalid= $item["id"];
                                        $selectvaltext= $item["text"];
                                        $selectvalkode= $item["KODE"];

                                        $selected="";
                                        if($selectvalkode==$reqDistrikId)
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

               

            <div class="form-group" >  
                <label class="control-label col-md-2">Tahun </label>
                <div class='col-md-4'>
                    <div class='form-group'>
                        <div class='col-md-11'>
                           <input autocomplete="off" maxlength="4" <?=$readonly?>  class="easyui-validatebox textbox form-control" type="text" name="reqTahun"  id="reqTahun" value="<?=$reqTahun?>" <?=$disabled?> style="width:50%" />
                       </div>
                   </div>
               </div>
            </div>

            <div class="form-group" >  
                <label class="control-label col-md-2">Energy Price (Rp) </label>
                <div class='col-md-4'>
                    <div class='form-group'>
                        <div class='col-md-11'>
                           <input autocomplete="off"  class="easyui-validatebox textbox form-control" type="text" name="reqEnergyPrice"  id="reqEnergyPrice" value="<?=$reqEnergyPrice?>" <?=$disabled?> style="width:50%" />
                       </div>
                   </div>
               </div>
            </div>

            <div class="form-group" >  
                <label class="control-label col-md-2">Status </label>
                <div class='col-md-4'>
                    <div class='form-group'>
                        <div class='col-md-10'>
                           <select  class="form-control" name="reqStatus" id="reqStatus">
                               <option value=""> Pilih Status</option>
                               <option value="1" <? if ($reqStatus=="1") echo 'selected' ?>> Valid</option>
                               <option value="2" <? if ($reqStatus=="2") echo 'selected' ?>> Tidak Valid</option>
                           </select>
                        </div>
                   </div>
               </div>
            </div>


       <input type="hidden" name="reqId" value="<?=$reqId?>" />
       <input type="hidden" name="reqMode" value="<?=$reqMode?>" />

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


    $("#reqEnergyPrice").keydown(function (event) {
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
    $('#reqTahun').on('input blur paste', function(){
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

    $.getJSON("json-app/unit_mesin_json/filter_unit?reqDistrikId="+reqDistrikId,
        function(data)
        {
            // console.log(data);
            $("#reqUnitMesinId option").remove();
            $("#reqUnitMesinId").attr("readonly", false); 
            jQuery(data).each(function(i, item){
                $("#reqUnitMesinId").append('<option value="'+item.id+'" >'+item.text+'</option>');
            });
        });
    
    });


    function submitForm(){

        $.messager.confirm('Konfirmasi',"Apakah data yang anda isi sudah valid?",function(r)
        {
            if (r)
            {
                $('#ff').form('submit',{
                        url:'json-app/energi_price_json/add',
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
        });

        
    }

    function clearForm(){
        $('#ff').form('clear');
    }   
</script>