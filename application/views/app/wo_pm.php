<?php
include_once("functions/string.func.php");
include_once("functions/date.func.php");
$this->load->model("base-app/Crud");
$this->load->model("base-app/Distrik");
$this->load->model("base-app/Asset_Lccm");

$reqTahun= $this->input->get("reqTahun");
$reqGroupPm= $this->input->get("reqGroupPm");

$appuserkodehak= $this->appuserkodehak;

$pgtitle= $pg;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$arrtabledata= array(
    // array("label"=>"No", "field"=> "NO", "display"=>"",  "width"=>"20", "colspan"=>"", "rowspan"=>"")
    // , array("label"=>"Unit Mesin", "field"=> "DISTRIK_INFO", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
     array("label"=>"Asset No", "field"=> "ASSETNUM", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"PM No", "field"=> "PMNUM", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"Std Job no", "field"=> "JPNUM", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"Number Personal", "field"=> "NO_PERSONAL", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"Duration (Hours)", "field"=> "DURATION_HOURS", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"PM Count (Yearly)", "field"=> "PM_IN_YEAR", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"PM Year", "field"=> "PM_YEAR", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"Group PM", "field"=> "GROUP_PM", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")

    , array("label"=>"fieldid", "field"=> "JPNUM", "display"=>"1",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"fieldid", "field"=> "PMNUM", "display"=>"1",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"fieldid", "field"=> "PM_YEAR", "display"=>"1",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"fieldid", "field"=> "ASSETNUM", "display"=>"1",  "width"=>"", "colspan"=>"", "rowspan"=>"")
);

$set= new Crud();
$statement=" AND KODE_MODUL ='0306'";
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
	thead.stick-datatable th:nth-child(1){	width:440px !important; *border:1px solid cyan;}
	thead.stick-datatable ~ tbody td:nth-child(1){	width:440px !important; *border:1px solid yellow;}
</style>

<div class="col-md-12">
    <div class="judul-halaman"> Data Wo PM</div>
    <div class="konten-area">
    	<div id="bluemenu" class="aksi-area">
           <?
            if($reqCreate ==1)
            {
            ?>
            <span><a id="btnAdd"><i class="fa fa-plus-square fa-lg" aria-hidden="true"></i> Tambah</a></span>
            <?   
            }
            if($reqUpdate ==1)
            {
            ?>
            <span><a id="btnEdit"><i class="fa fa-check-square fa-lg" aria-hidden="true"></i> Edit</a></span>
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
            <span><a id="btnDeleteNew"><i class="fa fa-times-rectangle fa-lg" aria-hidden="true"></i>Hapus</a></span>
            <?
            }
            if($reqCreate ==1)
            {
            ?>
            <!-- <span><a id="btnImport"><i class="fa fa-file-excel-o fa-lg" aria-hidden="true"></i> Import</a></span> -->
            <?
            }
            ?>

            <span><a id="btnKembali"><i class="fa fa-arrow-left" aria-hidden="true"></i>Kembali</a></span>

        </div>
        <br>
        <br>
        <br>

        <div  style=" border: none;  padding: 4px 5px; top: 90px;
        z-index: 10;clear: both;display: none">
            <div class="col-md-12" style="margin-bottom: 20px; border: none;">
                <button id="btnfilter" class="filter btn btn-default pull-left">Filter <i class="fa fa-caret-down" aria-hidden="true"></i></button>
            </div>
            <div class="divfilter filterbaru"  >
                <div class="col-md-12" style="margin-bottom: 20px;" >
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-1 control-label">Distrik</label>
                        <div class="col-sm-4">
                            <select class="form-control jscaribasicmultiple"  <?=$readonly?> required id="reqDistrikId" <?=$disabled?> name="reqDistrikId"  style="width:100%;" >
                                    <option value="" >Pilih Distrik</option>
                                    <?
                                    foreach($arrdistrik as $item) 
                                    {
                                        $selectvalid= $item["id"];
                                        $selectvaltext= $item["text"];
                                        $selectvalkode= $item["KODE"];

                                        $selected="";

                                        ?>
                                        <option value="<?=$selectvalkode?>" <?=$selected?>><?=$selectvaltext?></option>
                                        <?
                                    }
                                    ?>
                            </select>
                        </div>
                        <label for="inputEmail3" class="col-sm-1 control-label">Blok Unit</label>
                        <div class="col-sm-4">
                                <select class="form-control jscaribasicmultiple"   <?=$readonlyfilter?> <?=$readonly?> id="reqBlokId"   name="reqBlokId"  style="width:100%;"  >
                                    <option value="" >Pilih Blok Unit</option>
                                    
                                </select>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="form-group">
                        <label class="control-label col-sm-1">Unit Mesin </label>
                        <div class='col-md-4'>
                            <select class="form-control jscaribasicmultiple"  id="reqUnitMesinId" <?=$disabled?> name="reqUnitMesinId"  style="width:100%;" >
                                <option value="" >Pilih Unit Mesin</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="text-center ">
                  <button class="btn btn-primary btn-sm" onclick="setCariInfo()" ><i class="fas fa-search"></i> Cari</button>
                </div>
                <br>
            </div>
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
    var indexfieldtahun= arrdata.length - 2;
    var indexfieldpmnum= arrdata.length - 3;
    var indexfieldjpnum= arrdata.length - 4;
    var valinfoid= valinfotahun= valinfopmnum= valinfojpnum= '';
	var datainforesponsive= "1";
	var datainfoscrollx= 100;

    var datainfostatesave=1;

	infoscrolly= 50;

	$("#btnAdd, #btnEdit").on("click", function () {
        btnid= $(this).attr('id');

        if(btnid=="btnAdd")
        {
            valinfoid="";
            valinfotahun="<?=$reqTahun?>";
        }
        else
        {
            if(valinfoid == "" )
            {
                $.messager.alert('Info', "Pilih salah satu data terlebih dahulu.", 'warning');
                return false;
            }
        }

        varurl= "app/index/wo_pm_add?reqId="+valinfoid+"&reqTahun="+valinfotahun+"&reqPmNum="+valinfopmnum+"&reqJpNum="+valinfojpnum;
        document.location.href = varurl;
    });

    $("#btnLihat").on("click", function () {
        btnid= $(this).attr('id');

        if(valinfoid == "" )
        {
            $.messager.alert('Info', "Pilih salah satu data terlebih dahulu.", 'warning');
            return false;
        }
        

        varurl= "app/index/wo_pm_add?reqId="+valinfoid+"&reqLihat=1";
        document.location.href = varurl;
    });

    $('#btnImport').on('click', function () {
        openAdd("app/index/wo_pm_import");
    });


    $('#btnKembali').on('click', function () {
        varurl= "app/index/total_wo_pm";
        document.location.href = varurl;
    });

    $('#btnDelete').on('click', function () {
        if(valinfoid == "" )
        {
            $.messager.alert('Info', "Pilih salah satu data terlebih dahulu.", 'warning');
            return false;
        }

   
        $.messager.confirm('Konfirmasi',pesan,function(r){
            if (r){
                $.getJSON("json-app/wo_pm_json/update_status/?reqId="+valinfoid+"&reqStatus="+reqStatus,
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
                $.getJSON("json-app/wo_pm_json/delete?reqId="+valinfoid+"&reqTahun="+valinfotahun+"&reqPmNum="+valinfopmnum+"&reqJpNum="+valinfojpnum,
                    function(data){
                        $.messager.alert('Info', data.PESAN, 'info');
                        valinfoid= "";
                        location.reload();
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

        jsonurl= "json-app/wo_pm_json/json?reqDistrikId="+reqDistrikId+"&reqBlokId="+reqBlokId+"&reqUnitMesinId="+reqUnitMesinId;
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
		var jsonurl= "json-app/wo_pm_json/jsondetail?reqTahun=<?=$reqTahun?>&reqGroupPm=<?=$reqGroupPm?>";
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
                fieldinfotahun= arrdata[indexfieldtahun]["field"];
                fieldinfopmnum= arrdata[indexfieldpmnum]["field"];
                fieldinfojpnum= arrdata[indexfieldjpnum]["field"];
                valinfoid= dataselected[fieldinfoid];
                valinfotahun= dataselected[fieldinfotahun];
                valinfopmnum= dataselected[fieldinfopmnum];
                valinfojpnum= dataselected[fieldinfojpnum];
   
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