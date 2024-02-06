<?php
include_once("functions/string.func.php");
include_once("functions/date.func.php");
$this->load->model("base-app/Crud");
$this->load->model("base-app/Distrik");
$this->load->model("base-app/Asset_Lccm");
$this->load->model("base-app/M_Group_Pm_Lccm");




$appuserkodehak= $this->appuserkodehak;

$pgtitle= $pg;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$arrtabledata= array(
    // array("label"=>"No", "field"=> "NO", "display"=>"1",  "width"=>"20", "colspan"=>"", "rowspan"=>"")
    // , array("label"=>"Unit Mesin", "field"=> "DISTRIK_INFO", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    array("label"=>"PRK Year", "field"=> "PRK_YEAR", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"SITE", "field"=> "SITEID", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"Status", "field"=> "INFO_NAMA", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    // , array("label"=>"Group Pm", "field"=> "GROUP_PM", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    // , array("label"=>"Total Wo PM", "field"=> "TOTAL_TAHUN", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")

    , array("label"=>"fieldid", "field"=> "PRK", "display"=>"1",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"fieldid", "field"=> "GROUP_PM", "display"=>"1",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"fieldid", "field"=> "PRK_YEAR", "display"=>"1",  "width"=>"", "colspan"=>"", "rowspan"=>"")
);

$set= new Crud();
$statement=" AND KODE_MODUL ='0309'";
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

$set= new M_Group_Pm_Lccm();
$arrgroup= [];
$statement="  ";
$set->selectByParams(array(), -1,-1,$statement);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("GROUP_PM");
    $arrdata["text"]= $set->getField("GROUP_PM");
    array_push($arrgroup, $arrdata);
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
        var windowpos = $(window).scrollTop();
        if (windowpos >= pos.top) {
            s.addClass("stick");
            $('#example thead').addClass('stick-datatable');
        } else {
            s.removeClass("stick");
            $('#example thead').removeClass('stick-datatable');
        }
    });
});
</script>

<style>
    thead.stick-datatable th:nth-child(1){  width:440px !important; *border:1px solid cyan;}
    thead.stick-datatable ~ tbody td:nth-child(1){  width:440px !important; *border:1px solid yellow;}
</style>

<div class="col-md-12">
    <div class="judul-halaman"> Data  Prk</div>
    <div class="konten-area">
        <div id="bluemenu" class="aksi-area">
           <?
            if($reqCreate ==1)
            {
            ?>
            <!-- <span><a id="btnAdd"><i class="fa fa-plus-square fa-lg" aria-hidden="true"></i> Tambah</a></span> -->
            <?   
            }
            if($reqUpdate ==1 || $reqCreate ==1 )
            {
            ?>
            <span><a id="btnEdit"><i class="fa fa-check-square fa-lg" aria-hidden="true"></i> View</a></span>
            <!-- <span><a id="btnNavitas"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Navitas</a></span> -->
            <span><a id="btnTemplate"><i class="fa fa-download"></i> Template</a></span>
            <!-- <span><a id="btnImport"><i class="fa fa-file-excel-o fa-lg" aria-hidden="true"></i> Import</a></span> -->
            <?
            }
            if($reqRead ==1)
            {
            ?>
            <span><a id="btnLihat"><i class="fa fa-eye fa-lg" aria-hidden="true"></i> Lihat</a></span>
            <?
            }
            if($reqDelete ==1)
            {
            ?>            
            <!-- <span><a id="btnDelete"><i class="fa fa-times-rectangle fa-lg" aria-hidden="true"></i>Non Aktifkan</a></span> -->
            <!-- <span><a id="btnDeleteNew"><i class="fa fa-times-rectangle fa-lg" aria-hidden="true"></i>Hapus</a></span> -->
            <?
            }
            if($reqCreate ==1)
            {
            ?>
            <span><a id="btnImport"><i class="fa fa-file-excel-o fa-lg" aria-hidden="true"></i> Import</a></span>
            <?
            }
            ?>
            <span style="display: none;" id="spanValid">
                <a id="btnValid"><i class="fa fa-check-circle fa-lg" aria-hidden="true"></i>
                    Set Valid Tahun 
                    <label class="labeltahun"></label>
                </a>
            </span>
            <span style="display: none;" id="spanNotValid">
                <a id="btnNotValid"><i class="fa fa-circle-o fa-lg" aria-hidden="true"></i> 
                    Set Not Valid Tahun 
                    <label class="labeltahun"></label>
                </a>
            </span>
        </div>
        <br>
        <br>
        <br>


        <div class="area-filter"></div>

            
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
    
    });

    $(document).ready(function(){
        $(".divfilter").hide();
        $("#btnfilter").click(function(){
           $(".divfilter").toggle();
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

        varurl= "app/index/prk?reqTahun="+valinfoid;
        document.location.href = varurl;
    });

    $("#btnLihat").on("click", function () {
        btnid= $(this).attr('id');

        if(valinfoid == "" )
        {
            $.messager.alert('Info', "Pilih salah satu data terlebih dahulu.", 'warning');
            return false;
        }
        

        varurl= "app/index/prk_add?reqId="+valinfoid+"&reqLihat=1";
        document.location.href = varurl;
    });

    $('#btnImport').on('click', function () {
        openAdd("app/index/prk_import");
    });

    // $("#btnTemplate").on("click", function () {
    //     varurl= "template/import/prk.xls";
    //     document.location.href = varurl;
    // });

    $('#btnTemplate').on('click', function () {
        openAdd("iframe/index/prk_download_template");
    });

    $('#btnDelete').on('click', function () {
        if(valinfoid == "" )
        {
            $.messager.alert('Info', "Pilih salah satu data terlebih dahulu.", 'warning');
            return false;
        }

        $.messager.confirm('Konfirmasi',pesan,function(r){
            if (r){
                $.getJSON("json-app/prk_json/update_status/?reqId="+valinfoid+"&reqStatus="+reqStatus,
                    function(data){
                        $.messager.alert('Info', data.PESAN, 'info');
                        valinfoid= "";
                        setCariInfo();
                    });

            }
        }); 
    });

     $('#btnDeleteNew').on('click', function () {
        if(valinfoid == "" )
        {
            $.messager.alert('Info', "Pilih salah satu data terlebih dahulu.", 'warning');
            return false;
        }

         var pesan='Apakah anda yakin untuk hapus data terpilih?';

        $.messager.confirm('Konfirmasi',pesan,function(r){
            if (r){
                $.getJSON("json-app/prk_json/delete?reqId="+valinfoid+"&reqBlokId="+valinfoblok+"&reqDistrikId="+valinfodistrik,
                    function(data){
                        $.messager.alert('Info', data.PESAN, 'info');
                        valinfoid= "";
                        setCariInfo();
                    });

            }
        }); 
    });

    $('#btnCari').on('click', function () {
        reqPencarian= $('#example_filter input').val();
        reqKode='';
        reqTahun=$('#reqTahun').val();
        var reqDistrikId=$('#reqDistrikId').val();
        var reqBlokId= $("#reqBlokId").val();
        var reqUnitMesinId= $("#reqUnitMesinId").val();
        var reqGroupPm= $("#reqGroupPm").val();

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
        if (reqGroupPm=='undefined'||reqGroupPm==null) 
        {
            reqGroupPm="";
        }

        jsonurl= "json-app/prk_json/json?reqDistrikId="+reqDistrikId+"&reqBlokId="+reqBlokId+"&reqUnitMesinId="+reqUnitMesinId+"&reqGroupPm="+reqGroupPm;
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
        var jsonurl= "json-app/prk_json/json";
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
                // fieldinfodistrik= arrdata[indexfielddistrik]["field"];
                // valinfoid= dataselected[fieldinfoid];
                // valinfoblok= dataselected[fieldinfoblok];
                // valinfodistrik= dataselected[fieldinfodistrik];

                fieldinfostatus= arrdata[indexfieldstatus]["field"];
                valinfostatus= dataselected[fieldinfostatus];
                // console.log(fieldinfostatus);

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

        $("#btnValid, #btnNotValid").on("click", function () {
            btnid= $(this).attr('id');

            // console.log(dataselected);
            vtahun= dataselected['PRK_YEAR'];
            vsite= dataselected['SITEID'];
            vinfo= "";
            if(btnid=="btnValid")
            {
                value= 1;
                vinfo= "Apakah Anda yakin validasi semua data pada tahun "+vtahun+" ?";
            }
            else if(btnid=="btnNotValid")
            {
                value= 0;
                vinfo= "Apakah Anda yakin non validasi semua data pada tahun "+vtahun+" ?";
            }

            $.messager.confirm('Konfirmasi',vinfo,function(r){
                if (r){
                    $.getJSON("json-app/general_json/preperation_lccm_prk_loss_output?m=PRK&t="+vtahun+"&s="+vsite+"&value="+value,
                        function(data){
                            $.messager.alert('Info', data.PESAN, 'info');
                            valinfoid= "";
                            setCariInfo();
                    });

                }
            });

        });
    } );
</script>