<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");
$pgtitle= $pg;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$this->load->model("base-app/Distrik");
$this->load->model("base-app/M_Group_Pm_Lccm");

$reqBlokId=$this->appblokunitkode;
$reqDistrikId=$this->appdistrikkode;



$statement= " ";

if(!empty($reqDistrikId))
{
    $statement = " AND A.KODE = '".$reqDistrikId."'";
}


$sOrder=" ";
$set= new Distrik();
$set->selectByParams(array(), -1, -1, $statement, $sOrder);
$arrset= [];

while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("DISTRIK_ID");
    $arrdata["text"]= $set->getField("NAMA");
    $arrdata["KODE"]= $set->getField("KODE");
    array_push($arrset, $arrdata);
}

$statement= " ";

$sOrder=" ";
$set= new M_Group_Pm_Lccm();
$set->selectByParamsFilter(array(), -1, -1, $statement, $sOrder);
$arrgroup= [];

while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("GROUP_PM");
    array_push($arrgroup, $arrdata);
} 

if(empty($reqBlokId))
{

   $readonlyblok="";
}
else
{
    $readonlyblok="readonly";
}




?>


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

    <div class="judul-halaman"> Data <?=$pgtitle?></div>

    <div id="bluemenu" class="aksi-area">
        <span><a id="btnAdd"><i class="fa fa-plus-square fa-lg" aria-hidden="true"></i> Tambah</a></span>
        <span><a id="btnImport"><i class="fa fa-file-excel-o  fa-lg" aria-hidden="true"></i> Import Parent Eksternal</a></span>
    </div>
    
    <div class="konten-area">
        <div  style=" border: none;  padding: 4px 5px; top: 90px;
        z-index: 10;clear: both;">
            <div class="col-md-12" style="margin-bottom: 20px; border: none;">
                <button id="btnfilter" class="filter btn btn-default pull-left">Filter <i class="fa fa-caret-down" aria-hidden="true"></i></button>
            </div>
            <div class="divfilter filterbaru"  >
                <div class="col-md-12" style="margin-bottom: 20px;" >
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Distrik</label>
                        <div class="col-sm-3">
                            <select class="form-control jscaribasicmultiple" id="reqDistrikId"   <?=$readonlyblok?> <?=$disabled?> name="reqDistrikId"  style="width:100%;" >
                                <option value="" >Pilih Distrik</option>
                                <? 
                                foreach($arrset as $item) 
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
                        <label for="inputEmail3" class="col-sm-2 control-label">Blok</label>
                        <div class="col-sm-3">
                            <select class="form-control jscaribasicmultiple" id="reqBlokId" <?=$disabled?>  <?=$readonlyblok?>  name="reqBlokId"  style="width:100%;" >
                                <option value="" >Pilih Blok</option>
                            </select>
                        </div>
                    </div>
                </div>


                <div class="col-md-12" style="margin-bottom: 20px;" >
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Unit Mesin</label>
                        <div class="col-sm-3">
                            <select class="form-control jscaribasicmultiple" id="reqUnitMesinId" <?=$disabled?> name="reqUnitMesinId"  style="width:100%;" >
                                <option value="" >Pilih Unit Mesin</option>
                            </select>
                        </div>
                        <label for="inputEmail3" class="col-sm-2 control-label">Group PM</label>
                        <div class="col-sm-3">
                            <select class="form-control jscaribasicmultiple" id="reqGroupPm" <?=$disabled?> name="reqGroupPm"  style="width:100%;" >
                                <option value="" >Pilih Group PM</option>
                                <? 
                                foreach($arrgroup as $item) 
                                {
                                    $selectvalid= $item["id"];
                                    $selectvaltext= $item["id"];

                                    $selected="";
                                    if(in_array($selectvalid, $reqGroupPm))
                                    {
                                        $selected="selected";
                                    }
                                    ?>
                                    <option value="<?=$selectvalid?>" <?=$selected?>><?=$selectvaltext?></option>
                                    <?
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="text-center ">
                  <button class="btn btn-primary btn-sm" onclick="searchtree('')" ><i class="fas fa-search"></i> Cari</button>
                </div>
                <br>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="area-tabel-rekap-pemenuhan-ftk"> 
                    <div class="inner">
                        <table id="tt" class="easyui-treegrid" fitColumns="true" 
                            data-options=
                            "
                                url: 'json-app/wo_standing_json/tree'
                                , rownumbers: false
                                , pagination: false
                                , idField: 'ID'
                                , treeField: 'NAMA'
                                , onSelect:function(node){
                                    selectedNodeId = node.ID;
                                }
                                , onLoadSuccess: function(row, data){
                                    loadstate(row, data)
                               
                               
                                   // 
                               }
                               , onBeforeLoad: function(row,param){
                                if (!row) {
                                    param.id = 0;
                                    }
                                },
                                onExpand: function(row)
                                {
                                    savestate(row.state,row.ID,row.KODE_DISTRIK,row.KODE_BLOK,row.KODE_UNIT_M);
                                }
                                ,
                                onCollapse: function(row)
                                {
                                    savestate(row.state,row.ID,row.KODE_DISTRIK,row.KODE_BLOK,row.KODE_UNIT_M);
                                }
                                                       
                            " style="width:100%;height:470px">
                            <thead>
                                <tr>
                                    <!-- <th data-options="field:'ID'" width="100">Kode Jabatan</th> -->
                                    <th data-options="field:'NAMA'" width="400">Nama</th>
                                    <th data-options="field:'COST_PM_YEARLY'" width="300">Total Cost</th>
                                    <th data-options="field:'DISTRIK_NAMA'" width="450">Distrik</th>
                                    <th data-options="field:'BLOK_NAMA'" width="450">Blok</th>
                                    <th data-options="field:'UNIT_NAMA'" width="450">Unit Mesin</th>
                                    <th field="LINK_URL_INFO" width="100" align="center">Aksi</th>
                                </tr>
                            </thead>
                            
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    
</div>

<script type="text/javascript">

    $(document).ready(function(){
      blok('<?=$reqDistrikId?>','<?=$reqBlokId?>');

  });

function blok(reqDistrikId,reqBlokId)
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

        var reqDistrikId= reqDistrikId;
        var reqBlokId= reqBlokId;

        $.getJSON("json-app/unit_mesin_json/filter_unit?reqDistrikId="+reqDistrikId+"&reqBlokId="+reqBlokId,
            function(data)
            {
                // console.log(data);
                // $("#reqUnitMesinId option").remove();
                // $("#reqUnitMesinId").attr("readonly", false); 
                jQuery(data).each(function(i, item){
                    $("#reqUnitMesinId").append('<option value="'+item.KODE+'" >'+item.text+'</option>');
                });
            });

}

function loadstate(row,data)
{
    object = Object.assign({}, data.rows);

    $.each(object, function(key,valueObj){

        console.log(valueObj.STATE_STATUS);
        if(valueObj.STATE_STATUS=='open')
        {
            $('#tt').treegrid('expand', valueObj.ID);
        }
        else
        {
            $('#tt').treegrid('collapse', valueObj.ID);
        }

    });
}

function searchtree(value)
{
    reqDistrikId=$('#reqDistrikId').val();
    reqBlokId=$('#reqBlokId').val();
    reqGroupPm=$('#reqGroupPm').val();
    reqUnitMesinId=$('#reqUnitMesinId').val();
    
    // console.log(reqStatus);
    $('#tt').treegrid({
        url: 'json-app/wo_standing_json/tree?reqDistrikId='+reqDistrikId+'&reqBlokId='+reqBlokId+'&reqGroupPm='+reqGroupPm+'&reqUnitMesinId='+reqUnitMesinId
        , rownumbers: false
        , pagination: false
        , idField: 'ID'
        , treeField: 'NAMA'
        , onSelect:function(node){
            selectedNodeId = node.ID;
        }
        , onLoadSuccess: function(row, data){
        }
        , onBeforeLoad: function(row,param){
            if (!row) {
                param.id = 0;
            }
        }
    });
}

var reloadunit= "";
$(function(){

    $(".divfilter").hide();
      $("#btnfilter").click(function(){
         $(".divfilter").toggle();
    });

    $("#btnAdd").on("click", function () {
        varurl= "app/index/wo_standing_add?reqMode=insert&reqSiteId=&reqParent=utama";
        document.location.href = varurl;
    });

    $('#btnImport').on('click', function () {
        openAdd("app/index/wo_standing_parent_import?reqSuperiorId=TOP");
    });

    $('#reqDistrikId').on('change', function() {
    var reqDistrikId= this.value;

        $.getJSON("json-app/blok_unit_json/filter_blok?reqDistrikId="+reqDistrikId,
            function(data)
            {
                $("#reqBlokId option").remove();
                $("#reqUnitMesinId option").remove();
                $("#reqUnitMesinId").append('<option value="" >Pilih Unit Mesin</option>');
                $("#reqBlokId").attr("readonly", false); 
                $("#reqBlokId").append('<option value="" >Pilih Blok Unit</option>');
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

});

function openurl(varurl)
{
    document.location.href = varurl;
}

function savestate(state,id,distrik,blok,unit)
{

   $.getJSON("json-app/wo_standing_json/savestate/?reqState="+state+"&reqGroupPm="+id+"&reqDistrikId="+distrik+"&reqBlokId="+blok+"&reqUnitMesinId="+unit,
    function(data){
        // console.log(data.PESAN);
    });
}

function delete_parent(valinfoid)
{
    if(valinfoid == "")
        return false; 

    $.messager.confirm('Konfirmasi',"Hapus data terpilih?",function(r){
        if (r){
            $.getJSON("json-app/wo_standing_json/deleteparent/?reqBlokId="+valinfoid,
                function(data){
                    $.messager.alert('Info', data.PESAN, 'info');
                    location.reload();
                });

        }
    }); 
}

function delete_group(valinfoid,distrik,group,unit)
{
    if(valinfoid == "")
    {
        return false; 
    }

    if(unit==undefined)
    {
        unit="";
    }

    $.messager.confirm('Konfirmasi',"Hapus data terpilih?",function(r){
        if (r){
            $.getJSON("json-app/wo_standing_json/deletegroup/?reqBlokId="+valinfoid+"&reqDistrikId="+distrik+"&reqGroupPm="+group+"&reqUnitMesinId="+unit,
                function(data){
                    // console.log(data);return false;
                    $.messager.alert('Info', data.PESAN, 'info');
                    location.reload();
                });

        }
    }); 
}

function delete_tahun(valinfoid,distrik,group,tahun,unit)
{
    if(valinfoid == "")
    {
        return false; 
    }

    if(unit==undefined)
    {
        unit="";
    }

    $.messager.confirm('Konfirmasi',"Hapus data terpilih?",function(r){
        if (r){
            $.getJSON("json-app/wo_standing_json/deletetahun/?reqBlokId="+valinfoid+"&reqDistrikId="+distrik+"&reqGroupPm="+group+"&reqTahun="+tahun+"&reqUnitMesinId="+unit,
                function(data){
                    // console.log(data);return false;
                    $.messager.alert('Info', data.PESAN, 'info');
                    location.reload();
                });

        }
    }); 
}


function import_child(valinfoid)
{
    if(valinfoid == "")
        return false; 

    openAdd("app/index/wo_standing_anak_import?reqMode=anak&reqSuperiorId="+valinfoid);
}

</script>