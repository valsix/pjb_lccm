<?php
include_once("functions/string.func.php");
include_once("functions/date.func.php");
$this->load->model("base-app/Crud");
$this->load->model("base-app/PerusahaanEksternal");
$this->load->model("base-app/Distrik");
$this->load->model("base-app/T_Energy_Price_Lccm");



$appuserkodehak= $this->appuserkodehak;

$reqTahun= $this->input->get("reqTahun");


$pgtitle= $pg;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$arrtabledata= array(
    array("label"=>"No", "field"=> "NO", "display"=>"",  "width"=>"20", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"Distrik", "field"=> "DISTRIK_INFO", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"Blok Unit", "field"=> "BLOK_INFO", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"Tahun", "field"=> "PRICE_YEAR", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"Energi Price", "field"=> "ENERGY_PRICE", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"Status", "field"=> "STATUS_INFO", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")

   
    , array("label"=>"fieldid", "field"=> "KODE_BLOK", "display"=>"1",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"fieldid", "field"=> "KODE_DISTRIK", "display"=>"1",  "width"=>"", "colspan"=>"", "rowspan"=>"")
);

$set= new Crud();
$statement=" AND KODE_MODUL ='0302'";
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

$set= new T_Energy_Price_Lccm();
$arrtahun= [];
$statement="  ";
$set->selectByParamsTahun(array(), -1,-1,$statement);
 // echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["PRICE_YEAR"]= $set->getField("PRICE_YEAR");
    array_push($arrtahun, $arrdata);
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
    <div class="judul-halaman"> Data Energi Price</div>
    <div class="konten-area">
        <div id="bluemenu" class="aksi-area">
          
        </div>
        

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
                jQuery(data).each(function(i, item){
                    $("#reqBlokId").append('<option value="'+item.KODE+'" >'+item.text+'</option>');
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
    var indexfieldblok= arrdata.length - 2;
    var valinfoid= valinforowid= valinfoblok='';
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

        varurl= "app/index/energi_price_add?reqId="+valinfoid+"&reqBlokId="+valinfoblok;
        document.location.href = varurl;
    });

    $("#btnLihat").on("click", function () {
        btnid= $(this).attr('id');

        if(valinfoid == "" )
        {
            $.messager.alert('Info', "Pilih salah satu data terlebih dahulu.", 'warning');
            return false;
        }
        

        varurl= "app/index/energi_price_add?reqId="+valinfoid+"&reqLihat=1";
        document.location.href = varurl;
    });

    $('#btnImport').on('click', function () {
        openAdd("app/index/energi_price_import");
    });

    $('#btnDelete').on('click', function () {
        if(valinfoid == "" )
        {
            $.messager.alert('Info', "Pilih salah satu data terlebih dahulu.", 'warning');
            return false;
        }

        $.messager.confirm('Konfirmasi',pesan,function(r){
            if (r){
                $.getJSON("json-app/energi_price_json/update_status/?reqId="+valinfoid+"&reqStatus="+reqStatus,
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
                $.getJSON("json-app/energi_price_json/delete/?reqId="+valinfoid,
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

        jsonurl= "json-app/energi_price_json/json?reqPencarian="+reqPencarian+"&reqTahun="+reqTahun+"&reqDistrikId="+reqDistrikId+"&reqBlokId="+reqBlokId;
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
        var jsonurl= "json-app/energi_price_json/json?reqTahun=<?=$reqTahun?>";
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

    $(document).ready(function() {
        var table = $('#example').DataTable();

        $('#example tbody').on( 'click', 'tr', function () {
            if ( $(this).hasClass('selected') ) {
                $(this).removeClass('selected');
            }
            else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');

                var dataselected= datanewtable.DataTable().row(this).data();
                fieldinfoid= arrdata[indexfieldid]["field"];
                fieldinfoblok= arrdata[indexfieldblok]["field"];
                valinfoid= dataselected[fieldinfoid];
                valinfoblok= dataselected[fieldinfoblok];
                
            }
        } );

        $('#'+infotableid+' tbody').on( 'dblclick', 'tr', function () {
            var dataselected= datanewtable.DataTable().row(this).data();
            // console.log(dataselected);
            parent.setEnergy(dataselected);
            top.closePopup();
        });

        $('#button').click( function () {
            table.row('.selected').remove().draw( false );
        } );
    } );
</script>