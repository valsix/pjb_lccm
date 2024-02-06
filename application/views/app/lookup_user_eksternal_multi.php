<?php
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$pgtitle= $pg;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$arrtabledata= array(
    array("label"=>"No", "field"=> "NO", "display"=>"",  "width"=>"10", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"Nid", "field"=> "NID", "display"=>"",  "width"=>"20", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"Nama Lengkap", "field"=> "NAMA", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"Email", "field"=> "EMAIL", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"Role", "field"=> "ROLE_INFO", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"Perusahaan", "field"=> "PERUSAHAAN_EKSTERNAL_INFO", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")
    , array("label"=>"Status", "field"=> "INFO_STATUS", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")

    , array("label"=>"Pilih", "field"=> "CHECK", "display"=>"",  "width"=>"", "colspan"=>"", "rowspan"=>"")

    , array("label"=>"fieldid", "field"=> "PENGGUNA_EXTERNAL_ID", "display"=>"1",  "width"=>"", "colspan"=>"", "rowspan"=>"")
);
?>
<script type="text/javascript" language="javascript" class="init">	
</script> 

 
<div class="col-md-12">
    <div class="judul-halaman"> Data <?=$pgtitle?></div>
    <div class="konten-area">
    	<div id="bluemenu" class="aksi-area">
        </div>

        <div class="area-filter">
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

                    	// $infowidth= "";
                        $infowidth= $valitem["width"];
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
        <input type="hidden" id="reqValidasiCheck" name="reqValidasiCheck" />
        <input type="hidden" id="reqValidasiForm" name="reqValidasiForm" />
        
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
	var valinfoid= valinforowid='';
	var datainforesponsive= "1";
	var datainfoscrollx= 100;

	var infoarrid= [];
	var infoarrnama= [];
	var arrChecked = [];
	var arrCheckedForm = [];

	infoscrolly= 50;

	$('#btnCari').on('click', function () {
		reqPencarian= $('#example_filter input').val();

        jsonurl= "json-app/lookup_json/jsoneksternal?reqPencarian="+reqPencarian;
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
		var jsonurl= "json-app/lookup_json/jsoneksternal";
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
                valinfoid= dataselected[fieldinfoid];
                
            }
        } );

        $('#'+infotableid+' tbody').on( 'dblclick', 'tr', function () {
        	var dataselected= datanewtable.DataTable().row(this).data();
            // console.log(dataselected);
            // parent.setEksternal(dataselected);
            // top.closePopup();
        });

        $('#button').click( function () {
            table.row('.selected').remove().draw( false );
        } );
    } );

    function setKlikCheck()
    {
    	var i= "";
    	var x= "";

    	reqPilihCheck= reqpilihcheckval= reqPilihCheckNama=  "";
    	$('input[id^="reqPilihCheck"]:checkbox:checked').each(function(i){
    		$('#reqCheckAll').prop('checked',false);
    		reqPilihCheck= $(this).val();

    		var id= $(this).attr('id');
    		reqForm= id.replace("reqPilihCheck"+reqPilihCheck+"-", "");

    		id= id.replace("reqPilihCheck", "");

    		var elementRow= infoarrid.indexOf(reqPilihCheck);
    		if(elementRow == -1)
    		{
    			i= infoarrid.length;

    			infoarrid[i]= reqPilihCheck;
    		}

            var elementRowNama= infoarrnama.indexOf(reqForm);
                // console.log(elementRowNama);
            if(elementRow == -1)
            {
                i= infoarrnama.length;

                infoarrnama[i]= reqForm;
            } 



    	});

    	$('input[id^="reqPilihCheck"]:checkbox:not(:checked)').each(function(i){
    		reqPilihCheck= $(this).val();

    		var id= $(this).attr('id');
    		reqForm= id.replace("reqPilihCheck"+reqPilihCheck+"-", "");
    		id= id.replace("reqPilihCheck", "");

    		var elementRow= infoarrid.indexOf(reqPilihCheck);
    		if(parseInt(elementRow) >= 0)
    		{
    			infoarrid.splice(elementRow, 1);
    		}

    		var elementRowNama= infoarrnama.indexOf(reqForm);
            if(parseInt(elementRow) >= 0)
            {
                infoarrnama.splice(elementRowNama, 1);
            }

    	
    	});

    	reqPilihCheck= reqpilihcheckval= reqPilihCheckNama= "";

    	for(var i=0; i<infoarrid.length; i++) 
    	{

    		if(reqpilihcheckval == "")
    		{
    			reqpilihcheckval= infoarrid[i];
    		}
    		else
    		{
    			reqpilihcheckval= reqpilihcheckval+","+infoarrid[i];
    		}

    	}

    	 for(var i=0; i<infoarrnama.length; i++) 
        {
            if(reqPilihCheckNama == "")
            {
                reqPilihCheckNama= infoarrnama[i];
            }
            else
            {
                reqPilihCheckNama= reqPilihCheckNama+","+infoarrnama[i];
            }
          
        }

    	parent.setEksternal(reqpilihcheckval,reqPilihCheckNama);
    	// top.closePopup();
    	// console.log(reqpilihcheckval);


	}

</script>