<?php
include_once("functions/string.func.php");
include_once("functions/date.func.php");
$this->load->model("base-app/Crud");
$this->load->model("base-app/Distrik");
$this->load->model("base-app/Asset_Lccm");
$this->load->model("base-app/WorkOrder");



$appuserkodehak= $this->appuserkodehak;

$pgtitle= $pg;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$arrtabledata= array(
    // array("label"=>"No", "field"=> "NO", "display"=>"1",  "width"=>"20", "colspan"=>"", "rowspan"=>"")
    // , array("label"=>"Unit Mesin", "field"=> "DISTRIK_INFO", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    array("label"=>"Tahun", "field"=> "YEAR_INFO", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"Status", "field"=> "STATUS_INFO", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")

    , array("label"=>"fieldid", "field"=> "YEAR_INFO", "display"=>"1",  "width"=>"", "colspan"=>"", "rowspan"=>"")
);

$set= new Crud();
$statement=" AND KODE_MODUL ='0312'";
$kode= $appuserkodehak;
$set->selectByParamsMenus(array(), -1, -1, $statement, $kode);
// echo $set->query;exit;
$set->firstRow();
$reqMenu= $set->getField("MENU");
$reqCreate= $set->getField("MODUL_C");
$reqRead= $set->getField("MODUL_R");
$reqUpdate= $set->getField("MODUL_U");
$reqDelete= $set->getField("MODUL_D");

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

$set= new WorkOrder();
$statement=" ";
$set->jumlahasset(array(), -1, -1, $statement);
// echo $set->query;exit;
$set->firstRow();
$reqJmlAsset= $set->getField("JUMLAH");
unset($set);

$set= new WorkOrder();

$statement=" AND WOSTATUS IS NULL";
$set->jumlahwo(array(), -1, -1, $statement);
// echo $set->query;exit;
$set->firstRow();
$reqJmlNon= $set->getField("JUMLAH");
unset($set);


$set= new WorkOrder();
$statement=" ";
$set->jumlahassetlccm(array(), -1, -1, $statement);
// echo $set->query;exit;
$set->firstRow();
$reqJmlAssetLccm= $set->getField("JUMLAH");
unset($set);


$set= new WorkOrder();
$statement=" ";
$set->jumlahassetwo(array(), -1, -1, $statement);
// echo $set->query;exit;
$set->firstRow();
$reqJmlAssetWo= $set->getField("JUMLAH");
unset($set);



?>
<script type="text/javascript" language="javascript" class="init">  
</script> 

<!-- FIXED AKSI AREA WHEN SCROLLING -->
<link rel="stylesheet" href="css/gaya-stick-when-scroll.css" type="text/css">
<script src="assets/js/stick.js" type="text/javascript"></script>

<style>
    thead.stick-datatable th:nth-child(1){  width:440px !important; *border:1px solid cyan;}
    thead.stick-datatable ~ tbody td:nth-child(1){  width:440px !important; *border:1px solid yellow;}
</style>

<div class="col-md-12">
    <div class="judul-halaman"> Data  Work Order</div>
    <div class="page-header"><h3><i class="fa fa-file-text fa-lg"></i> Filter</h3></div>
        <div class="konten-area ">
            <div class="konten-inner">
                <form id="ff" class="easyui-form form-horizontal" method="post" novalidate enctype="multipart/form-data">
                    <div class="divfilter">
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
                                           
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group" >  
                               <label class="control-label col-md-2">Unit Mesin </label>
                               <div class='col-md-6'>
                                    <div class='form-group'>
                                        <div class='col-md-11'  id="unit">
                                            <select class="form-control jscaribasicmultiple"  <?=$readonly?> <?=$readonlyfilter?> id="reqUnitMesinId" <?=$disabled?> name="reqUnitMesinId"  style="width:100%;" >
                                                <option value="" >Pilih Unit Mesin</option>
                                               
                                            </select>
                                        </div>
                                    </div>
                            </div>
                        </div>

                        <div class="form-group" >  
                            <label class="control-label col-md-2">Asset Number </label>
                            <div class='col-md-5'>
                                <div class='form-group'>
                                    <div class='col-md-5' >
                                       <div id="">
                                          <a id="open" onclick="openEquipment()"><i class="fa fa-plus-square fa-lg" aria-hidden="true"></i> </a>
                                       </div>
                                       <div id="listasset">
                                       </div>
                                       <input autocomplete="off"  <?=$readonly?>  type="hidden" name="reqAssetNum"  id="reqAssetNum"  <?=$disabled?> style="width:50%" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group" >  
                               <label class="control-label col-md-2">Jumlah Asset </label>
                               <div class='col-md-6'>
                                    <div class='form-group'>
                                        <div class='col-md-11'  >
                                            <span id="reqJmlAsset"><?=$reqJmlAsset?></span>
                                        </div>
                                    </div>
                            </div>
                        </div>

                        <div class="form-group" >  
                               <label class="control-label col-md-2">Jumlah Asset LCCM</label>
                               <div class='col-md-6'>
                                    <div class='form-group'>
                                        <div class='col-md-11'  >
                                            <span id="reqJmlAssetLccm"><?=$reqJmlAssetLccm?></span>
                                        </div>
                                    </div>
                            </div>
                        </div>

                        <div class="form-group" >  
                               <label class="control-label col-md-2">Jumlah WO</label>
                               <div class='col-md-6'>
                                    <div class='form-group'>
                                        <div class='col-md-11' >
                                            <span id="reqJmlAssetWo"><?=$reqJmlAssetWo?></span>
                                        </div>
                                    </div>
                            </div>
                        </div>

                        <div class="form-group" >  
                               <label class="control-label col-md-2">Jumlah WO yang belum divalidasi</label>
                               <div class='col-md-6'>
                                    <div class='form-group'>
                                        <div class='col-md-11' >
                                            <span id="reqJmlNon"><?=$reqJmlNon?></span>
                                        </div>
                                    </div>
                            </div>
                        </div>

                    </div>  
                    <div style="text-align:center;padding:5px">
                        <a href="javascript:void(0)" class="btn btn-primary" id="btnCari">Cari</a>
                        <a href="javascript:void(0)" class="btn btn-success" id="btnfilter">Hide Filter</a>

                    </div> 

                </form>
            </div>

            <div class="page-header"><h3><i class="fa fa-file-text fa-lg"></i> Monitoring Data</h3></div>

            <div id="bluemenu" class="aksi-area">
                <?
                if($reqCreate ==1)
                {
                    ?>
                    <?   
                }
                if($reqUpdate ==1)
                {
                    ?>
                    <span><a id="btnEdit"><i class="fa fa-check-square fa-lg" aria-hidden="true"></i> Validasi Downtime</a></span>
                    <span><a id="btnValid"><i class="fa fa-check-square fa-lg" aria-hidden="true"></i> View</a></span>
                    <?
                }
                if($reqRead ==1)
                {
                    ?>
                    <?
                }
                if($reqDelete ==1)
                {
                    ?>            
                    <!-- <span><a id="btnDeleteNew"><i class="fa fa-times-rectangle fa-lg" aria-hidden="true"></i>Hapus</a></span> -->
                    <?
                }
                if($reqCreate ==1)
                {
                    ?>
                    <span><a id="btnTemplate"><i class="fa fa-download"></i> Template</a></span>
                    <span><a id="btnImport"><i class="fa fa-file-excel-o fa-lg" aria-hidden="true"></i> Import</a></span>
                    <?
                }
                ?>
            </div>

            <table id="example" class="table table-striped table-hover dt-responsive" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <?php
                        foreach($arrtabledata as $valkey => $valitem) 
                        {
                            $infotablelabel= $valitem["label"];
                            $infotablecolspan= $valitem["colspan"];
                            $infotablerowspan= $valitem["rowspan"];

                            $infowidth= "";
                            if(!empty($infotablecolspan))
                            {
                            }

                            if(!empty($infotablelabel))
                            {
                        ?>
                            <th style="text-align:center; width: <?=$infowidth?>%" colspan='<?=$infotablecolspan?>' rowspan='<?=$infotablerowspan?>'><?=$infotablelabel?></th>
                        <?
                            }
                        }
                        ?>
                    </tr>
                 </thead>
            </table>
            
        </div>
</div>

<a href="#" id="triggercari" style="display:none" title="triggercari">triggercari</a>
<a href="#" id="btnCari" style="display: none;" title="Cari"></a>

<script type="text/javascript">

    var datanewtable;
    var infotableid= "example";
    var carijenis= "";
    var arrdata= <?php echo json_encode($arrtabledata); ?>;
    var indexfieldid= arrdata.length - 1;
    var indexfieldgroup= arrdata.length - 2;
    // var indexfielddistrik= arrdata.length - 3;
    var indexfieldstatus= arrdata.length - 3;
    var valinfoid= valinforowid= valinfoblok= valinfodistrik='';
    var datainforesponsive= "1";
    var datainfoscrollx= 100;

    var datainfostatesave=1;

    infoscrolly= 50;


    $('#reqDistrikId').on('change', function() {
        var reqDistrikId= this.value;

        $.getJSON("json-app/blok_unit_json/filter_blok?reqDistrikId="+reqDistrikId,
            function(data)
            {
                $("#reqBlokId option").remove();
                $("#reqUnitMesinId option").remove();

                $("#reqBlokId").attr("readonly", false); 
                $("#reqBlokId").append('<option value="" >Pilih Blok Unit</option>');
                $("#reqUnitMesinId").append('<option value="" >Pilih Unit Mesin</option>');
                jQuery(data).each(function(i, item){
                    $("#reqBlokId").append('<option value="'+item.KODE+'" >'+item.text+'</option>');
                });
            });

        rekapwo();
    });

    $('#reqBlokId').on('change', function() {
    var reqDistrikId= $("#reqDistrikId").val();
    var reqBlokId= this.value;

    $.getJSON("json-app/unit_mesin_json/filter_unit?reqDistrikId="+reqDistrikId+"&reqBlokId="+reqBlokId,
        function(data)
        {
            // console.log(data);
            $("#reqUnitMesinId option").remove();
            $("#reqUnitMesinId").attr("readonly", false); 
            jQuery(data).each(function(i, item){
                $("#reqUnitMesinId").append('<option value="'+item.KODE+'" >'+item.text+'</option>');
            });
        });
     rekapwo();

    });

    $(document).ready(function(){
        $(".divfilter").show();
        $("#btnCari").show();
        $("#btnfilter").click(function(){
            $(".divfilter").toggle();
            if ($(".divfilter").is(':hidden')) {
                $("#btnCari").hide();
                $("#btnfilter").text('Show Filter');
            }
            else
            {
                $("#btnCari").show();
                $("#btnfilter").text('Hide Filter');
            }
       });
        $('#btnValid').hide();
    });


    function openEquipment()
    {
        var reqDistrikId=$('#reqDistrikId').val();
        var reqBlokId= $("#reqBlokId").val();
        var reqUnitMesinId= $("#reqUnitMesinId").val();
        $('#SortMe').empty();

        openAdd("iframe/index/lookup_equipment_multi?reqDistrikId="+reqDistrikId+"&reqBlokId="+reqBlokId+"&reqUnitMesinId="+reqUnitMesinId);
    }


    function rekapwo()
    {
        var reqDistrikId=$('#reqDistrikId').val();
        var reqBlokId= $("#reqBlokId").val();
        var reqUnitMesinId= $("#reqUnitMesinId").val();

        if (reqUnitMesinId=='undefined'||reqUnitMesinId==null) 
        {
            reqUnitMesinId="";
        }

        $.getJSON("json-app/work_order_json/rekapwo?reqDistrikId="+reqDistrikId+"&reqBlokId="+reqBlokId+"&reqUnitMesinId="+reqUnitMesinId,
        function(data)
        {

            $("#reqJmlAsset").text(data.reqJmlAsset);
            $("#reqJmlAssetWo").text(data.reqJmlAssetWo);
           
        });
    }

    $("#btnAdd, #btnEdit").on("click", function () {
        btnid= $(this).attr('id');

        if(btnid=="btnAdd")
        {
            valinfoid="";
        }
        else
        {
            if(valinfoid == "" )
            {
                $.messager.alert('Info', "Pilih salah satu data terlebih dahulu.", 'warning');
                return false;
            }
        }

        var reqDistrikId=$('#reqDistrikId').val();
        var reqBlokId= $("#reqBlokId").val();
        var reqUnitMesinId= $("#reqUnitMesinId").val();
        var reqAssetNum= $("#reqAssetNum").val();

        varurl= "app/index/work_order_proses?reqTahun="+valinfoid+"&reqDistrikId="+reqDistrikId+"&reqBlokId="+reqBlokId+"&reqUnitMesinId="+reqUnitMesinId+"&reqAssetNum="+reqAssetNum;
        document.location.href = varurl;
    });

     $("#btnValid").on("click", function () {
        btnid= $(this).attr('id');

        if(btnid=="btnAdd")
        {
            valinfoid="";
        }
        else
        {
            if(valinfoid == "" )
            {
                $.messager.alert('Info', "Pilih salah satu data terlebih dahulu.", 'warning');
                return false;
            }
        }

        varurl= "app/index/work_order_valid?reqTahun="+valinfoid;
        document.location.href = varurl;
    });

    $("#btnLihat").on("click", function () {
        btnid= $(this).attr('id');

        if(valinfoid == "" )
        {
            $.messager.alert('Info', "Pilih salah satu data terlebih dahulu.", 'warning');
            return false;
        }
        

        varurl= "app/index/work_order_add?reqId="+valinfoid+"&reqLihat=1";
        document.location.href = varurl;
    });

    $('#btnImport').on('click', function () {
        openAdd("app/index/wo_import");
    });

   
    $('#btnTemplate').on('click', function () {
        openAdd("iframe/index/work_order_download_template");
    });

    function setEquipment(values)
    {
        var arrvalue = values.split(',');
        infodetilparaf= "<ol id='SortMe'>";
        $.each(arrvalue , function(index, val) { 
            infodetilparaf+= "<li class='ListItem'>"+val+" <a id='open'><i class='fa fa-trash fa-lg deleteli' aria-hidden='true'></i> </a></li>";

        });
        infodetilparaf+= "</ol>";
        // console.log(values);
        // console.log(arrvalue);
        $('#listasset').append(infodetilparaf);
        $('#reqAssetNum').val(values);
    }

    $(document).on('click','.deleteli', function () {
       // console.log('delete');
       $(this).closest("li").remove();
   });


    $('#btnCari').on('click', function () {
        reqPencarian= $('#example_filter input').val();
        reqKode='';
        reqTahun=$('#reqTahun').val();
        var reqDistrikId=$('#reqDistrikId').val();
        var reqBlokId= $("#reqBlokId").val();
        var reqUnitMesinId= $("#reqUnitMesinId").val();
        var reqAssetNum= $("#reqAssetNum").val();

        if (reqDistrikId=='undefined'||reqDistrikId==null) 
        {
            reqDistrikId="";
        }
        if (reqBlokId=='undefined'||reqBlokId==null) 
        {
            reqBlokId="";
        }
        if (reqUnitMesinId=='undefined'||reqUnitMesinId==null) 
        {
            reqUnitMesinId="";
        }
        if (reqAssetNum=='undefined'||reqAssetNum==null) 
        {
            reqAssetNum="";
        }

        jsonurl= "json-app/work_order_json/json?reqDistrikId="+reqDistrikId+"&reqBlokId="+reqBlokId+"&reqUnitMesinId="+reqUnitMesinId+"&reqAssetNum="+reqAssetNum;
        datanewtable.DataTable().ajax.url(jsonurl).load();
    });

    $("#triggercari").on("click", function () {
        if(carijenis == "1")
        {
            pencarian= $('#'+infotableid+'_filter input').val();
            datanewtable.DataTable().search( pencarian ).draw();
        }
        else
        {
            
        }
    });

    jQuery(document).ready(function() {
        var jsonurl= "json-app/work_order_json/json";
        ajaxserverselectsingle.init(infotableid, jsonurl, arrdata);
    });

    function calltriggercari()
    {
        $(document).ready( function () {
          $("#triggercari").click();      
        });
    }

    function setCariInfo()
    {
        $(document).ready( function () {
            $("#btnCari").click();
        });
    }

    var dataselected= "";
    $(document).ready(function() {
        var table = $('#example').DataTable();

        $('#example tbody').on( 'click', 'tr', function () {
            if ( $(this).hasClass('selected') ) {
                $(this).removeClass('selected');
            }
            else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');

                dataselected= datanewtable.DataTable().row(this).data();
                fieldinfoid= arrdata[indexfieldid]["field"];
                fieldinfogroup= arrdata[indexfieldgroup]["field"];
                valinfoid= dataselected[fieldinfoid];
                valinfogroup= dataselected[fieldinfogroup];
                // console.log(valinfogroup);

                if(valinfogroup=="Valid")
                {
                    $('#btnValid').show();
                    $('#btnEdit').hide();
                }
                else
                {
                    $('#btnValid').hide(); 
                    $('#btnEdit').show(); 
                }
                
            }
        } );

        $('#'+infotableid+' tbody').on( 'dblclick', 'tr', function () {
            // console.log(valinfogroup);return false;
            if(valinfogroup=="Valid")
            {
                $('#btnValid').click();
            }
            else
            {
                $("#btnEdit").click();
            }
        });

        $('#button').click( function () {
            table.row('.selected').remove().draw( false );
        } );

        
    } );
</script>