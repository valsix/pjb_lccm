<?php
include_once("functions/string.func.php");
include_once("functions/date.func.php");
$this->load->model("base-app/Crud");
$this->load->model("base-app/PerusahaanEksternal");
$this->load->model("base-app/Distrik");
$this->load->model("base-app/ScheduleOh");



$appuserkodehak= $this->appuserkodehak;

$reqBlokId=$this->appblokunitkode;
$reqDistrikId=$this->appdistrikkode;
$reqUnitMesinId=$this->appunitmesinkode;

$pgtitle= $pg;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$arrtabledata= array(
    array("label"=>"No", "field"=> "NO", "display"=>"1",  "width"=>"20", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"Distrik", "field"=> "DISTRIK_INFO", "display"=>"",  "width"=>"500", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"Blok", "field"=> "BLOK_INFO", "display"=>"",  "width"=>"500", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"Unit Mesin", "field"=> "UNIT_INFO", "display"=>"",  "width"=>"300", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"OH Year", "field"=> "OH_YEAR", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"OH Type", "field"=> "OH_TYPE_INFO", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"Status", "field"=> "INFO_NAMA", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")

    , array("label"=>"fieldid", "field"=> "KODE_UNIT_M", "display"=>"1",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"fieldid", "field"=> "KODE_BLOK", "display"=>"1",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"fieldid", "field"=> "KODE_DISTRIK", "display"=>"1",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"fieldid", "field"=> "WO_OH", "display"=>"1",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"fieldid", "field"=> "OH_YEAR", "display"=>"1",  "width"=>"", "colspan"=>"", "rowspan"=>"")
);

$set= new Crud();
$statement=" AND KODE_MODUL ='0308'";
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

$set= new ScheduleOh();
$arrtahun= [];
$statement="  ";
$set->selectByParamsTahun(array(), -1,-1,$statement);
 // echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["OH_YEAR"]= $set->getField("OH_YEAR");
    array_push($arrtahun, $arrdata);
}
unset($set);

if(empty($reqBlokId))
{

    $readonlyblok="";
}
else
{
    $readonlyblok="readonly";
}


if(empty($reqUnitMesinId))
{
    $readonlymesin="";
}
else
{
    $readonlymesin="readonly";
}





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
    <div class="judul-halaman"> Schedule Oh</div>
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

        <div  style=" border: none;  padding: 4px 5px; top: 90px;
        z-index: 10;clear: both;">
            <div class="col-md-12" style="margin-bottom: 20px; border: none;">
                <button id="btnfilter" class="filter btn btn-default pull-left">Filter <i class="fa fa-caret-down" aria-hidden="true"></i></button>
            </div>
            <div class="divfilter filterbaru"  >
                <div class="col-md-12" style="margin-bottom: 20px;" >
                    <div class="form-group">
                         <label for="inputEmail3" class="col-sm-1 control-label">Tahun</label>
                        <div class="col-sm-4">
                           <select class="form-control jscaribasicmultiple"  <?=$readonly?> required id="reqTahun" <?=$disabled?> name="reqTahun"  style="width:100%;" >
                                    <option value="" >Pilih Tahun</option>
                                    <?
                                    foreach($arrtahun as $item) 
                                    {
                                        $selectvalid= $item["OH_YEAR"];
                                        $selectvaltext= $item["OH_YEAR"];

                                        $selected="";

                                        ?>
                                        <option value="<?=$selectvalid?>" <?=$selected?>><?=$selectvaltext?></option>
                                        <?
                                    }
                                    ?>
                            </select>
                        </div>
                        <br>
                        <br>
                       
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-1 control-label">Distrik</label>
                        <div class="col-sm-4">
                            <select class="form-control jscaribasicmultiple"  <?=$readonly?> <?=$readonlyblok?> required id="reqDistrikId" <?=$disabled?> name="reqDistrikId"  style="width:100%;" >
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
                        <label for="inputEmail3" class="col-sm-1 control-label">Blok Unit</label>
                        <div class="col-sm-4">
                                <select class="form-control jscaribasicmultiple"   <?=$readonlyfilter?> <?=$readonly?> <?=$readonlyblok?> id="reqBlokId"   name="reqBlokId"  style="width:100%;"  >
                                    <option value="" >Pilih Blok Unit</option>
                                    <?
                                    foreach($arrblok as $item) 
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

    $(document).ready(function(){
      blok('<?=$reqDistrikId?>','<?=$reqBlokId?>','<?=$reqUnitMesinId?>');
    });

    function blok(reqDistrikId,reqBlokId,reqUnitMesinId)
    {
        $.getJSON("json-app/blok_unit_json/filter_blok?reqDistrikId="+reqDistrikId,
            function(data)
            {
                $("#reqBlokId option").remove();
                // $("#reqUnitMesinId option").remove();

                // $("#reqBlokId").attr("readonly", false); 
                $("#reqBlokId").append('<option value="" >Pilih Blok Unit</option>');
                // $("#reqUnitMesinId").append('<option value="" >Pilih Unit Mesin</option>');
                var selected='';

                if('<?=$reqBlokId?>')
                {
                    selected='selected';
                }
                // console.log(selected);
                jQuery(data).each(function(i, item){
                    $("#reqBlokId").append('<option value="'+item.KODE+'" '+selected+' >'+item.text+'</option>');
                });
            });

    }


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

    var elselect='<select id="reqStatus"  class="statusgen" style="color: #000000;" ><option value="">Semua</option><option value="TRUE">Valid</option><option value="FALSE">Tidak Valid</option></select>';

    $('.table').on('init.dt', function() {
        $('.selectstatus ').html(elselect);
        $('#reqStatus').on('change', function() {
            reqStatus=$('#reqStatus').val();
            jsonurl= "json-app/schedule_oh_json/json?reqStatus="+reqStatus;
            datanewtable.DataTable().ajax.url(jsonurl).load();
        });
    });


    var datanewtable;
    var infotableid= "example";
    var carijenis= "";
    var arrdata= <?php echo json_encode($arrtabledata); ?>;
    var indexfieldid= arrdata.length - 1;
    var indexfieldstatus= arrdata.length - 2;
    var indexfielddistrik= arrdata.length - 3;
    var indexfieldblok= arrdata.length - 4;
    var indexfieldunit= arrdata.length - 5;

    var valinfoid= valinforowid= valinfodistrik=valinfoblok=valinfounit='';
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

        varurl= "app/index/schedule_oh_add?reqId="+valinfoid+"&reqDistrikId="+valinfodistrik+"&reqBlokId="+valinfoblok+"&reqUnitMesinId="+valinfounit;
        document.location.href = varurl;
    });

    $("#btnLihat").on("click", function () {
        btnid= $(this).attr('id');

        if(valinfoid == "" )
        {
            $.messager.alert('Info', "Pilih salah satu data terlebih dahulu.", 'warning');
            return false;
        }
        

        varurl= "app/index/schedule_oh_add?reqId="+valinfoid+"&reqLihat=1";
        document.location.href = varurl;
    });

    $('#btnImport').on('click', function () {
        openAdd("app/index/schedule_oh_import");
    });

    $('#btnDelete').on('click', function () {
        if(valinfoid == "" )
        {
            $.messager.alert('Info', "Pilih salah satu data terlebih dahulu.", 'warning');
            return false;
        }

        $.messager.confirm('Konfirmasi',pesan,function(r){
            if (r){
                $.getJSON("json-app/schedule_oh_json/update_status/?reqId="+valinfoid+"&reqStatus="+reqStatus,
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
                $.getJSON("json-app/schedule_oh_json/delete/?reqId="+valinfoid+"&reqDistrikId="+valinfodistrik+"&reqBlokId="+valinfoblok+"&reqUnitMesinId="+valinfounit,
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

        jsonurl= "json-app/schedule_oh_json/json?reqPencarian="+reqPencarian+"&reqTahun="+reqTahun+"&reqDistrikId="+reqDistrikId+"&reqBlokId="+reqBlokId;
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
		var jsonurl= "json-app/schedule_oh_json/json";
	    ajaxserverselectsingle.init(infotableid, jsonurl, arrdata,'',6);
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
                fieldinfodistrik= arrdata[indexfielddistrik]["field"];
                fieldinfoblok= arrdata[indexfieldblok]["field"];
                fieldinfounit= arrdata[indexfieldunit]["field"];
                valinfoid= dataselected[fieldinfoid];
                valinfodistrik= dataselected[fieldinfodistrik];
                valinfoblok= dataselected[fieldinfoblok];
                valinfounit= dataselected[fieldinfounit];

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
                $(".labeltahun").text(dataselected['OH_YEAR']);
                
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
            vtahun= dataselected['OH_YEAR'];
            vdistrik= dataselected['KODE_DISTRIK'];
            vblok= dataselected['KODE_BLOK'];
            vunit= dataselected['KODE_UNIT_M'];
            if(vunit==null)
            {
                vunit="";
            }
            vinfo= "";
            if(btnid=="btnValid")
            {
                value= 1;
                vinfo= "Apakah Anda yakin validasi data yang dipilih ?";
            }
            else if(btnid=="btnNotValid")
            {
                value= 0;
                vinfo= "Apakah Anda yakin non validasi data yang dipilih ?";
            }

            $.messager.confirm('Konfirmasi',vinfo,function(r){
                if (r){
                    $.getJSON("json-app/general_json/preperation_lccm_new?m=WO_OH&t="+vtahun+"&value="+value+"&vdistrik="+vdistrik+"&vblok="+vblok+"&vunit="+vunit,
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