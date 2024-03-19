<?php
include_once("functions/string.func.php");
include_once("functions/date.func.php");
$this->load->model("base-app/Crud");
$this->load->model("base-app/PerusahaanEksternal");
$this->load->model("base-app/Distrik");
$this->load->model("base-app/T_Energy_Price_Lccm");
$this->load->model("base-app/BlokUnit");
$this->load->model("base-app/UnitMesin");
$this->load->model("base-app/T_Preperation_Lccm");
$this->load->model("base/Users");


$appuserkodehak= $this->appuserkodehak;
$reqPenggunaid= $this->appuserid;
$appdistrikid= $this->appdistrikid;
$appdistrikkode= $this->appdistrikkode;
$appblokunitid= $this->appblokunitid;
$appblokunitkode= $this->appblokunitkode;


$pgtitle= $pg;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));
$tahunskg= date('Y');


// YEAR_LCCM, WO_CR, WO_STANDING, WO_PM, WO_PDM, WO_OH, PRK, LOSS_OUTPUT, ENERGY_PRICE, OPERATION, STATUS_COMPLETE

$arrtabledata= array(
    array("label"=>"No", "field"=> "NO", "display"=>"",  "width"=>"20", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"Distrik", "field"=> "NAMA_DISTRIK", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"Blok", "field"=> "BLOK_UNIT_NAMA", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"Unit", "field"=> "UNIT_MESIN_NAMA", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"Year Lccm ", "field"=> "YEAR_LCCM", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"Wo Cr", "field"=> "WO_CR_INFO", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"Wo Standing", "field"=> "WO_STANDING_INFO", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"Wo PM", "field"=> "WO_PM_INFO", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"Wo PDM", "field"=> "WO_PDM_INFO", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"Wo OH", "field"=> "WO_OH_INFO", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"PRK", "field"=> "PRK_INFO", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"Loss Output", "field"=> "LOSS_OUTPUT_INFO", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"Energy Price", "field"=> "ENERGY_PRICE_INFO", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"Operation", "field"=> "OPERATION_INFO", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"Status Complete", "field"=> "STATUS_COMPLETE_INFO", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")

    // , array("label"=>"fieldid", "field"=> "KODE_BLOK", "display"=>"1",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    // , array("label"=>"fieldid", "field"=> "KODE_DISTRIK", "display"=>"1",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    // , array("label"=>"fieldid", "field"=> "KODE_UNIT", "display"=>"1",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    // , array("label"=>"fieldid", "field"=> "GROUP_PM", "display"=>"1",  "width"=>"", "colspan"=>"", "rowspan"=>"")
);

$set= new Crud();
$statement=" AND KODE_MODUL ='0313'";
$kode= $appuserkodehak;
$set->selectByParamsMenus(array(), -1, -1, $statement, $kode);
// echo $set->query;exit;
$set->firstRow();
$reqMenu= $set->getField("MENU");
$reqCreate= $set->getField("MODUL_C");
$reqRead= $set->getField("MODUL_R");
$reqUpdate= $set->getField("MODUL_U");
$reqDelete= $set->getField("MODUL_D");

$set= new T_Preperation_Lccm();
$arrtahun= [];
$statement="  ";
$set->selectByParamsTahun(array(), -1,-1,$statement);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("YEAR_LCCM");
    $arrdata["text"]= $set->getField("YEAR_LCCM");
    array_push($arrtahun, $arrdata);
}
unset($set);

$tahunch=$tahunskg-1;
$searchthn = array_search($tahunch, array_column($arrtahun, 'id'));

if(empty($searchthn))
{
    $arrdata= array();
    $arrdata["id"]= $tahunch;
    $arrdata["text"]= $tahunch;
    array_push($arrtahun, $arrdata);
}

// print_r($arrtahun);exit;


$arridDistrik=[];
$usersdistrik = new Users();
$usersdistrik->selectByPenggunaDistrik($reqPenggunaid);
// echo $usersdistrik->query;exit;
while($usersdistrik->nextRow())
{
    $arridDistrik[]= $usersdistrik->getField("DISTRIK_ID"); 
   
}

$idDistrik = implode(",",$arridDistrik);  




$set= new Distrik();
$arrdistrik= [];
$statement.="  ";
if(!empty($appdistrikid))
{
    $statement=" AND A.DISTRIK_ID IN (".$appdistrikid.") AND A.STATUS IS NULL AND A.NAMA IS NOT NULL 
    ";
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

$statement=" AND 1=2 ";

if(!empty($appblokunitid))
{
    $statement=" AND A.BLOK_UNIT_ID IN (".$appblokunitid.") AND A.STATUS IS NULL AND A.NAMA IS NOT NULL 
    ";
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




?>
<script type="text/javascript" language="javascript" class="init">  
</script> 

<!-- FIXED AKSI AREA WHEN SCROLLING -->
<link rel="stylesheet" href="css/gaya-stick-when-scroll.css" type="text/css">
<script src="assets/js/stick.js" type="text/javascript"></script>
<script>
$(document).ready(function() {
    var s = $("#bluemenu");
    
    var pos = s.position();
    $(window).scroll(function() {
        // var windowpos = $(window).scrollTop();
        // if (windowpos >= pos.top) {
        //     s.addClass("stick");
        //     $('#example thead').addClass('stick-datatable');
        // } else {
        //     s.removeClass("stick");
        //     $('#example thead').removeClass('stick-datatable');
        // }
    });
});
</script>

<style type="text/css">
    .select-css {
        /*display: block;*/
        /*font-size: 16px;*/
        font-size: 14px;
        padding-left: 8px;
        width: auto !important;

        font-family: 'Verdana', sans-serif;
        font-weight: 400;
        color: #444;
        line-height: 1.3;
        padding: .4em 1.4em .3em .8em;
        width: 100px;
        max-width: 100%; 
        box-sizing: border-box;
     margin: 20px auto;
        border: 1px solid #aaa;
        box-shadow: 0 1px 0 1px rgba(0,0,0,.03);
        border-radius: .3em;
        -moz-appearance: none;
        -webkit-appearance: none;
        appearance: none;
        background-color: #fff;
        background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23007CB2%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'),
          linear-gradient(to bottom, #ffffff 0%,#f7f7f7 100%);
        background-repeat: no-repeat, repeat;
        background-position: right .7em top 50%, 0 0;
        background-size: .65em auto, 100%;
    }
    .select-css::-ms-expand {
        display: none;
    }
    .select-css:hover {
        border-color: #888;
    }
    .select-css:focus {
        border-color: #aaa;
        box-shadow: 0 0 1px 3px rgba(59, 153, 252, .7);
        box-shadow: 0 0 0 3px -moz-mac-focusring;
        color: #222; 
        outline: none;
    }
    .select-css option {
        font-weight:normal;
    }


    .classOfElementToColor:hover {background-color:red; color:black}

    .select-css option[selected] {
        background-color: orange;
    }


    /* OTROS ESTILOS*/
    .styled-select { width: 240px; height: 34px; overflow: hidden; background: url(new_arrow.png) no-repeat right #ddd; border: 1px solid #ccc; }

     

    .sidebar-box select{
    display:block;
    padding: 5px 10px;
    height:42px;
    margin:10px auto;
    min-width: 225px;
    -webkit-appearance: none;
    height: 34px;
    /* background-color: #ffffff; */
    background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23007CB2%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'),
          linear-gradient(to bottom, #ffffff 0%,#f7f7f7 100%);
        background-repeat: no-repeat, repeat;
        background-position: right .7em top 50%, 0 0;
        background-size: .65em auto, 100%;}
</style>

<style>
    thead.stick-datatable th:nth-child(1){  width:440px !important; *border:1px solid cyan;}
    thead.stick-datatable ~ tbody td:nth-child(1){  width:440px !important; *border:1px solid yellow;}
</style>

<div class="col-md-12">
    <div class="judul-halaman"> Dashboard Preparation</div>
    <div class="konten-area">
        <div class="area-preparation-dashboard">
            <div class="filter">
                
                <label>Distrik :</label>
                <select class="select-css " style="width: 15%" id="reqDistrikId"  name="reqDistrikId">
                    <option value="" >Pilih Distrik</option>
                    <?
                    foreach($arrdistrik as $item) 
                    {
                        $selectvalid= $item["id"];
                        $selectvaltext= $item["text"];
                        $selectvalkode= $item["KODE"];

                        $selected="";
                        if($selectvalkode == $appdistrikkode)
                        {
                            $selected="selected";
                        }
                        ?>
                        <option value="<?=$selectvalkode?>" <?=$selected?>><?=$selectvaltext?></option>
                        <?
                    }
                    ?>
                </select>
                <label>Blok :</label>
                <select class="select-css" style="width: 15%"  id="reqBlokId"   name="reqBlokId" >
                    <option value="" >Pilih Blok Unit</option>
                    <?
                    foreach($arrblok as $item) 
                    {
                        $selectvalid= $item["id"];
                        $selectvaltext= $item["text"];
                        $selectvalkode= $item["KODE"];
                        $selected="";
                        if($selectvalkode==$appblokunitkode)
                        {
                            $selected="selected";
                        }

                        ?>
                        <option value="<?=$selectvalkode?>" <?=$selected?>><?=$selectvaltext?></option>

                        <?
                    }
                    ?>
                </select>
                <label>Unit :</label>
                <select class="select-css" style="width: 15%" id="reqUnitMesinId"  name="reqUnitMesinId">
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
                <label>Year LCCM :</label>
                <select class="select-css " style="width: 10%" id="reqTahunAwal">
                    <option value="">Pilih Tahun</option>
                    <?
                    foreach($arrtahun as $item) 
                    {
                        $selectvalid= $item["id"];
                        $selectvaltext= $item["text"];

                        $selected="";
                        
                        ?>
                        <option value="<?=$selectvalid?>" <?=$selected?>><?=$selectvaltext?></option>
                        <?
                    }
                    ?>
                </select>
                <label>S.d</label>
                <select class="select-css " style="width: 10%" id="reqTahunAkhir">
                    <option value="">Pilih Tahun</option>
                    <?
                    foreach($arrtahun as $item) 
                    {
                        $selectvalid= $item["id"];
                        $selectvaltext= $item["text"];

                        $selected="";
                        if($selectvalid==$tahunskg-1)
                        {
                             $selected="selected";
                        }

                       
                        
                        ?>
                        <option value="<?=$selectvalid?>" <?=$selected?>><?=$selectvaltext?></option>
                        <?
                    }
                    ?>
                </select>
                <button class="btn btn-success btn-sm" style="margin-left: 50px;margin-top: -10px" onclick="setCariInfo()" ><i class="fas fa-search"></i> Cari</button>
            </div>
            <div class="inner row" id="isi">
                
            </div>
        </div>
       
    </div>
</div>

<a href="#" id="triggercari" style="display:none" title="triggercari">triggercari</a>
<a href="#" id="btnCari" style="display: none;" title="Cari"></a>

<script type="text/javascript">

   var reqDistrikId= $("#reqDistrikId").val();
   var reqBlokId= $("#reqBlokId").val();
   
   $.getJSON("json-app/unit_mesin_json/filter_unit?reqDistrikId="+reqDistrikId+"&reqBlokId="+reqBlokId,
    function(data)
    {
        $("#reqUnitMesinId option").remove();
        $("#reqUnitMesinId").attr("readonly", false); 
        $("#reqUnitMesinId").append('<option value="" >Pilih Unit Mesin</option>');
        jQuery(data).each(function(i, item){
            $("#reqUnitMesinId").append('<option value="'+item.KODE+'" >'+item.text+'</option>');
        });
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
            $("#reqGroupPm option").remove();
            $("#reqBlokId").attr("readonly", false); 
            $("#reqBlokId").append('<option value="" >Pilih Blok Unit</option>');
            $("#reqUnitMesinId").append('<option value="" >Pilih Unit Mesin</option>');
            $("#reqGroupPm").append('<option value="" >Pilih Group Pm</option>');
            jQuery(data).each(function(i, item){
                $("#reqBlokId").append('<option value="'+item.KODE+'" >'+item.text+'</option>');
            });
        });
    
    });

    $('#reqBlokId').on('change', function() {
        var reqDistrikId= $("#reqDistrikId").val();
        var reqBlokId= this.value;

        if(reqBlokId)
        {

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

            $.getJSON("json-app/group_pm_json/filter_group?reqDistrikId="+reqDistrikId+"&reqBlokId="+reqBlokId,
            function(data)
            {
                $("#reqGroupPm option").remove();
                $("#reqGroupPm").attr("readonly", false); 
                $("#reqGroupPm").append('<option value="" >Pilih Group Pm</option>');
                jQuery(data).each(function(i, item){
                    $("#reqGroupPm").append('<option value="'+item.text+'" >'+item.text+'</option>');
                });            
            });

        }
        else
        {
            $("#reqUnitMesinId option").remove();
            $("#reqUnitMesinId").append('<option value="" >Pilih Unit Mesin</option>');
            $("#reqGroupPm option").remove();
            $("#reqGroupPm").append('<option value="" >Pilih Group Pm</option>');
        }

       
    });

    $('#reqUnitMesinId').on('change', function() {
        var reqDistrikId= $("#reqDistrikId").val();
        var reqBlokId=  $("#reqBlokId").val();
        var reqUnitMesinId= this.value;

        $.getJSON("json-app/group_pm_json/filter_group?reqDistrikId="+reqDistrikId+"&reqBlokId="+reqBlokId+"&reqUnitMesinId="+reqUnitMesinId,
            function(data)
            {
                $("#reqGroupPm option").remove();
                $("#reqGroupPm").attr("readonly", false); 
                $("#reqGroupPm").append('<option value="" >Pilih Group Pm</option>');
                jQuery(data).each(function(i, item){
                    $("#reqGroupPm").append('<option value="'+item.text+'" >'+item.text+'</option>');
                });            
            });
    });



    $('#btnCari').on('click', function () {
        reqPencarian= $('#example_filter input').val();
        reqKode='';
        reqTahunAwal=$('#reqTahunAwal').val();
        reqTahunAkhir=$('#reqTahunAkhir').val();
        var reqDistrikId=$('#reqDistrikId').val();
        var reqBlokId= $("#reqBlokId").val();
        var reqUnitMesinId= $("#reqUnitMesinId").val();
        // console.log('xxx');
        if(parseInt(reqTahunAwal)>parseInt(reqTahunAkhir))
        {
            alert('Tahun Awal tidak boleh lebih dari tahun akhir');return false;
        }
        $("#isi").empty();
       

        $('#isi').load("app/loadUrl/app/preparation_isi?reqDistrikId="+reqDistrikId+"&reqBlokId="+reqBlokId+"&reqUnitMesinId="+reqUnitMesinId+"&reqTahunAwal="+reqTahunAwal+"&reqTahunAkhir="+reqTahunAkhir);

        // $.getJSON("json-app/preparation_json/json?reqDistrikId="+reqDistrikId+"&reqBlokId="+reqBlokId+"&reqUnitMesinId="+reqUnitMesinId+"&reqTahun="+reqTahun,
        //     function(data)
        //     {

        //         $("#isi").append(data);
        //         // // console.log(data);
        //         // $("#reqUnitMesinId option").remove();
        //         // $("#reqUnitMesinId").attr("readonly", false); 
        //         // $("#reqUnitMesinId").append('<option value="" >Pilih Unit Mesin</option>');
        //         // jQuery(data).each(function(i, item){
        //         //     $("#reqUnitMesinId").append('<option value="'+item.KODE+'" >'+item.text+'</option>');
        //         // });
        //     });

    });

    $(document).ready( function () {
        setCariInfo();
        $("#reqTahunAwal").prop("selectedIndex", 1).change();

    });

    function setCariInfo()
    {
        $(document).ready( function () {
            $("#btnCari").click();
        });
    }

   
</script>