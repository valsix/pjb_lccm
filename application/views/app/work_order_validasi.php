<?php
include_once("functions/string.func.php");
include_once("functions/date.func.php");
$this->load->model("base-app/Crud");
$this->load->model("base-app/Distrik");

$appuserkodehak= $this->appuserkodehak;

$reqTahun= $this->input->get("reqTahun");
$reqDistrikId= $this->input->get("reqDistrikId");
$reqBlokId= $this->input->get("reqBlokId");
$reqUnitMesinId= $this->input->get("reqUnitMesinId");
$reqAssetNum= $this->input->get("reqAssetNum");


$pgtitle= $pg;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$arrtabledata= array(
    array("label"=>"No", "field"=> "NO", "display"=>"1",  "width"=>"20", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"Asset Num", "field"=> "ASSETNUM", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"Work Order", "field"=> "WONUM", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"WO Description", "field"=> "WO_DESC", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"Work Type", "field"=> "WORKTYPE", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"WO Group", "field"=> "WORK_GROUP", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"Need Downtime", "field"=> "NEEDDOWNTIME", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"Reported Date", "field"=> "REPORTDATE", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    // , array("label"=>"Group Pm", "field"=> "GROUP_PM", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")

    , array("label"=>"fieldid", "field"=> "ASSETNUM", "display"=>"1",  "width"=>"", "colspan"=>"", "rowspan"=>"")
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
        <div class="konten-area ">
            <div class="page-header"><h3><i class="fa fa-file-text fa-lg"></i> Work Order</h3></div>

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
                    <!-- <span><a id="btnImport"><i class="fa fa-file-excel-o fa-lg" aria-hidden="true"></i> Import</a></span> -->
                    <?
                }
                ?>
                <span><a id="btnKembali"><i class="fa fa-arrow-left fa-lg" aria-hidden="true"></i> Kembali</a></span>
                <span><a id="btnProses"><i class="fa fa-check-square fa-lg" aria-hidden="true"></i> Proses</a></span>
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
    });


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

        varurl= "app/index/work_order?reqTahun="+valinfoid;
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

    $("#btnProses").on("click", function () {

        varurl= "app/index/work_order_proses?reqTahun=<?=$reqTahun?>&reqDistrikId=<?=$reqDistrikId?>&reqBlokId=<?=$reqBlokId?>&reqUnitMesinId=<?=$reqUnitMesinId?>&reqAssetNum=<?=$reqAssetNum?>";
        document.location.href = varurl;
    });

     $("#btnKembali").on("click", function () {

        varurl= "app/index/work_order";
        document.location.href = varurl;
    });

    $('#btnImport').on('click', function () {
        openAdd("app/index/work_order_import");
    });

   
    $('#btnTemplate').on('click', function () {
        openAdd("iframe/index/work_order_download_template");
    });


    $('#btnCari').on('click', function () {
        reqPencarian= $('#example_filter input').val();
        reqKode='';
        reqTahun=$('#reqTahun').val();
        var reqDistrikId=$('#reqDistrikId').val();
        var reqBlokId= $("#reqBlokId").val();
        var reqUnitMesinId= $("#reqUnitMesinId").val();
        var reqKks= $("#reqKks").val();

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
        if (reqKks=='undefined'||reqKks==null) 
        {
            reqKks="";
        }

        jsonurl= "json-app/work_order_json/json?reqDistrikId="+reqDistrikId+"&reqBlokId="+reqBlokId+"&reqUnitMesinId="+reqUnitMesinId+"&reqKks="+reqKks;
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
        var jsonurl= "json-app/work_order_json/jsonvalidasi?reqTahun=<?=$reqTahun?>&reqDistrikId=<?=$reqDistrikId?>&reqBlokId=<?=$reqBlokId?>&reqUnitMesinId=<?=$reqUnitMesinId?>&reqAssetNum=<?=$reqAssetNum?>";
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
                

                fieldinfostatus= arrdata[indexfieldstatus]["field"];
                valinfostatus= dataselected[fieldinfostatus];

                $("#spanValid, #spanNotValid").hide();
                if(valinfostatus == "t")
                {
                    $("#spanNotValid").show();
                }
                else
                {
                    $("#spanValid").show();
                }
                $(".labeltahun").text(dataselected['PRK_YEAR']);
            }
        } );

        $('#'+infotableid+' tbody').on( 'dblclick', 'tr', function () {
            $("#btnEdit").click();
        });

        $('#button').click( function () {
            table.row('.selected').remove().draw( false );
        } );

        
    } );
</script>