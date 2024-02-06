<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");
$this->load->model("base-app/Distrik");


$pgreturn= str_replace("_add", "", $pg);

$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

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

<div class="col-md-12">
    
  <div class="judul-halaman"> <a href="app/index/<?=$pgreturn?>"><?=$pgtitle?></a> &rsaquo; Form Template</div>

    <div class="konten-area">
        <div class="konten-inner">
            <div>
                <form id="ff" class="easyui-form form-horizontal" method="post" novalidate enctype="multipart/form-data">

                    <div class="page-header">
                        <h3><i class="fa fa-file-text fa-lg"></i> <?=$pgtitle?></h3>       
                    </div>
                                                                             
                    <div class="form-group">  
                         <div class="card-body">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Distrik</label>
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
                                <label   for="inputEmail3" class="col-sm-2 control-label">Blok Unit</label>
                                <div class="col-sm-4">
                                    <select class="form-control jscaribasicmultiple"   <?=$readonlyfilter?> <?=$readonly?> id="reqBlokId"   name="reqBlokId"  style="width:100%;"  >
                                        <option value="" >Pilih Blok Unit</option>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="form-group" >
                                <label class="control-label col-sm-2">Unit Mesin </label>
                                <div class='col-md-4'>
                                    <select class="form-control jscaribasicmultiple"  id="reqUnitMesinId" <?=$disabled?> name="reqUnitMesinId"  style="width:100%;" >
                                        <option value="" >Pilih Unit Mesin</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="reqId" value="<?=$reqId?>" />
                    <input type="hidden" name="reqMode" value="<?=$reqMode?>" />

                </form>
            </div>
            <div style="text-align:center;padding:5px">
                <br>
                <a href="javascript:void(0)" class="btn btn-success" onclick="downloadfile()">Download Template</a>
            </div>
        </div>
    </div>
</div>

<script>

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
            $("#reqUnitMesinId").append('<option value="" >Pilih Unit Mesin</option>');
            jQuery(data).each(function(i, item){
                $("#reqUnitMesinId").append('<option value="'+item.KODE+'" >'+item.text+'</option>');
            });
        });
    
    });


function downloadfile(){
    var reqDistrikId=reqBlokId=reqUnitMesinId="";

    var reqDistrikId=$("#reqDistrikId").val();
    var reqBlokId=$("#reqBlokId").val();
    var reqUnitMesinId=$("#reqUnitMesinId").val();

    if(reqDistrikId)
    {}
    else
    {
       alert("Pilih Distrik terlebih dahulu");return false; 
    }
    varurl= "app/loadUrl/app/loss_output_template?reqDistrikId="+reqDistrikId+"&reqBlokId="+reqBlokId+"&reqUnitMesinId="+reqUnitMesinId

    $.messager.confirm('Konfirmasi',"Download Template?",function(r){
        $.messager.progress({
            title:'Please waiting',
            msg:'Loading data...'
        });
        if (r){
            $.ajax({
                url: varurl,
                cache: false,
                success: function(data){
                        if(data=="xxx")
                        {
                            $.messager.alert('Info', "Data asset tidak ditemukan, silahkan pilih Distrik/Blok/Unit lain.", 'info');
                            $.messager.progress('close');
                            return false;
                        }
                        else
                        {
                           $.messager.progress('close');
                           window.location =varurl;
                        }
                    }
                });
        }
    }); 



    
}

 
</script>