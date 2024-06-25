<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/Distrik");
$this->load->model("base-app/BlokUnit");
$this->load->model("base-app/UnitMesin");
$this->load->model("base-app/T_Preperation_Lccm");



$pgreturn= str_replace("_add", "", $pg);

$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$reqId = $this->input->get("reqId");
$reqLihat = $this->input->get("reqLihat");
$reqStatus = $this->input->get("reqStatus");

$reqDistrikId = $this->input->get("reqDistrikId");
$reqBlokId = $this->input->get("reqBlokId");
$reqUnitMesinId = $this->input->get("reqUnitMesinId");
$reqDelete = $this->input->get("reqDelete");

$tahunnow=date("Y");
$tahunkedepan=date("Y") + 30;


$readonlyunit="";
$readonlymesin="";

if(empty($reqDistrikId))
{
    $reqDistrikId=$this->appdistrikkode;
    if(!empty($reqDistrikId))
    {
        $readonlyunit="readonly";
    }
   
}

if(empty($reqBlokId))
{
    $reqBlokId=$this->appblokunitkode;
    if(!empty($reqBlokId))
    {
        $readonlyunit="readonly";
    }
}



if(empty($reqUnitMesinId))
{
    $reqUnitMesinId=$this->appunitmesinkode;
    if(!empty($reqUnitMesinId))
    {
        $readonlymesin="readonly";
    }
}


$disabled="";

if($reqLihat ==1)
{
    $disabled="disabled";  
}


$set= new Distrik();
$arrdistrik= [];
$statement = " AND A.KODE = '".$reqDistrikId."'";

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

$statement=" AND A.KODE <> ''  AND B.KODE = '".$reqDistrikId."' ";

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


$set= new UnitMesin();
$arrunitmesin= [];
$statement=" AND C.KODE = '".$reqBlokId."' AND  B.KODE = '".$reqDistrikId."'   ";
$set->selectByParams(array(), -1,-1,$statement);
    // echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("UNIT_MESIN_ID");
    $arrdata["text"]= $set->getField("KODE")." - ".$set->getField("NAMA");
    $arrdata["KODE"]= $set->getField("KODE");
    array_push($arrunitmesin, $arrdata);
}
unset($set);



$readonly="";
if(empty($reqStatus))
{
    $readonly="";

}


// print_r($arrproduct);exit;
// print_r($reqPredictionMin);exit;



?>

<script src='assets/multifile-master/jquery.form.js' type="text/javascript" language="javascript"></script> 
<script src='assets/multifile-master/jquery.MetaData.js' type="text/javascript" language="javascript"></script> 
<script src='assets/multifile-master/jquery.MultiFile.js' type="text/javascript" language="javascript"></script> 
<link rel="stylesheet" href="css/gaya-multifile.css" type="text/css">

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

<style type="text/css">
.mbox-wrapper .mbox {
    /*max-width: 300px;*/
    width: 100%;
    position: absolute;
    padding: 15px;
    background: #fff;
    top: 50%;
    left: 50%;
    transform: translateY(-50%) translateX(-50%);
}
.txtsize {
    width: 100%;
    height: 50px;
}
</style>




<div class="col-md-12">
    
    <div class="judul-halaman"> <a href="app/index/<?=$pgreturn?>">Data <?=$pgtitle?></a> &rsaquo; Kelola <?=$pgtitle?></div>


    <div class="konten-area">
        <div class="area-preparation-dashboard">
            <div class="filter">
                <label style="margin-top: 30px">Distrik :</label>
                <select class="select-css form-control jscaribasicmultiple" readonly id="reqDistrikId"  name="reqDistrikId">
                    <option value="" >Pilih Distrik</option>
                    <?
                    foreach($arrdistrik as $item) 
                    {
                        $selectvalid= $item["id"];
                        $selectvaltext= $item["text"];
                        $selectvalkode= $item["KODE"];

                        $selected="";
                        if($selectvalkode == $reqDistrikId)
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
                <select class="select-css form-control jscaribasicmultiple" readonly   id="reqBlokId"   name="reqBlokId" >
                    <option value="" >Pilih Blok Unit</option>
                    <?
                    foreach($arrblok as $item) 
                    {
                        $selectvalid= $item["id"];
                        $selectvaltext= $item["text"];
                        $selectvalkode= $item["KODE"];
                        $selected="";
                        if($selectvalkode==$reqBlokId)
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
                <select class="select-css form-control jscaribasicmultiple" readonly  id="reqUnitMesinId"  name="reqUnitMesinId">
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
                <button class="btn btn-primary btn-sm" id="simpan" style="margin-left: 50px;margin-top: 0px" onclick="submitForm()" > Submit</button>
            </div>
        </div>
        <div class="konten-inner">
            <form id="ff" class="easyui-form form-horizontal" method="post" novalidate enctype="multipart/form-data" >
                    <div class="page-header">
                        <h3><i class="fa fa-file-text fa-lg"></i> <?=$pgtitle?></h3>       
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Tambah Asset </label>
                        <div class='col-md-6'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <a  onclick="openTreeAsset()"><i class="fa fa-plus-square fa-lg" aria-hidden="true"></i> </a> 
                                    <button type='button' class="btn btn-success btn-sm"  style="margin-left: 50px;margin-top: 0px" onclick="addall()" > Add All</button>
                                    <button type='button' class="btn btn-danger btn-sm" id="" style="margin-top: 0px" onclick="removeall()" > Remove All</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">  
                        <label class="control-label col-md-2"> Asset </label>
                        <div class='col-md-6'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <table class="table table-bordered table-striped table-hovered" style="margin-top: 10px;max-width: 10000px !important;width: 125%;">
                                        <thead>
                                            <tr>
                                              <th style="vertical-align : middle;text-align:center;" width="10%">Assetnum</th>
                                              <th style="vertical-align : middle;text-align:center;" >Description</th>
                                              <th style="vertical-align : middle;text-align:center;" width="10%">Hapus</th>
                                          </tr>
                                      </thead>
                                      <tbody id="assetmulti">
                                            <?
                                            if(!empty($arrjabatandetil))
                                            {
                                                foreach ($arrjabatandetil as $key => $value) 
                                                {
                                            ?>
                                                    <tr >
                                                        <td style="display: none"><input type="hidden" name="reqAssetNum[]" id="reqAssetNum" value="<?=$value['ASSETNUM']?>" /></td>
                                                        <td> <?=$value['NAMA']?></td>
                                                        <td style="text-align: center;vertical-align: middle;"><span  class='hapustabel' style='background-color: red; padding: 10px; border-radius: 5px;top: 50%;position: relative;'><a onclick='HapusDetil("<?=$value['PENGGUNA_HAK_JABATAN_ID']?>","<?=$value['POSITION_ID']?>","<?=$reqId?>")'><i class='fa fa-trash fa-lg' style='color: white;' aria-hidden='true'></i></a></span>
                                                        </td>  
                                                    </tr>

                                            <?
                                                }
                                            }
                                            ?>

                                      </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="reqId" value="<?=$reqId?>" />
                    <input type="hidden" name="reqMode" value="<?=$reqMode?>" />
                    <input type="hidden" name="reqProjectNoOld" value="<?=$reqProjectNo?>" />
                </form>
            </div>
        </div>
    </div>
    
</div>

<script>


    $("#assetmulti").on("click", ".btn-remove", function(){
        $(this).closest('tr').remove();
    });

    function removeall()
    {
         $("#assetmulti").empty();
    } 
    
    function openTreeAsset()
    {
        var reqDistrikId= $("#reqDistrikId").val();
        var reqBlokId= $("#reqBlokId").val();
        var reqUnitMesinId= $("#reqUnitMesinId").val();
        openAdd('app/loadUrl/app/lookup_asset_multi?reqDistrikId='+reqDistrikId+'&reqBlokId='+reqBlokId+'&reqUnitMesinId='+reqUnitMesinId);
    } 

    function submitForm(){
        $.messager.confirm('Konfirmasi',"Apakah data yang anda isi sudah valid?",function(r)
        {
            if (r)
            {
                // $('#ff').form('submit',{
                //     url:'json-app/lccm_json/add',
                //     onSubmit:function(){

                //         if($(this).form('validate'))
                //         {
                //             var win = $.messager.progress({
                //                 title:'<?=$this->configtitle["progres"]?>',
                //                 msg:'proses data...'
                //             });
                //         }

                //         return $(this).form('enableValidation').form('validate');
                //     },
                //     success:function(data){
                //         $.messager.progress('close');
                //         // console.log(data);return false;

                //         data = data.split("***");
                //         reqId= data[0];
                //         infoSimpan= data[1];

                //         var reqDistrikId= $("#reqDistrikId").val();
                //         var reqBlokId= $("#reqBlokId").val();
                //         var reqUnitMesinId= $("#reqUnitMesinId").val();

                //         if(reqId == 'xxx')
                //         {
                //             $.messager.alert('Info', infoSimpan, 'warning');
                //         }
                //         else if(reqId == 'zzz')
                //         {
                //             infoSimpan1= data[2];
                //             tahun = infoSimpan1.replace(/\s/g, '');

                //             $.messager.alert('Info', infoSimpan+infoSimpan1, 'warning');
                //         }
                //         else
                //         {
                //              $.messager.alertLink('Info', infoSimpan, 'info', "app/index/<?=$pgreturn?>");
                //         }
                       
                //     }
                // });
            }

        });
    }


    function addmultiarea(id, multiinfonama, multiinfodesc,IDFIELD) 
    {
        batas= id.length;

        if(batas > 0)
        {
            $("#jabatan").show();
            rekursivemultiarea(0, id,multiinfonama,multiinfodesc,IDFIELD);
        }
    }

    function rekursivemultiarea(index, id, multiinfonama, multiinfodesc, IDFIELD) 
    {
        urllink= "app/loadUrl/app/template_asset_multi";
        method= "POST";
        batas= id.length;
        if(index < batas)
        {
            ASSETNUM= id[index];
            NAMA= multiinfonama[index];
            DESC= multiinfodesc[index];

            var rv = true;

            if (rv == true) 
            {
                $.ajax({
                    url: urllink,
                    method: method,
                    data: {
                        reqAssetNum: ASSETNUM,
                        reqNama: NAMA,
                        reqDescription: DESC

                    },
                    success: function (response) {
                        $("#"+IDFIELD+"").append(response);

                        index= parseInt(index) + 1;
                        rekursivemultiarea(index,id, multiinfonama, multiinfodesc,IDFIELD);
                    },
                    error: function (response) {
                    },
                    complete: function () {
                    }
                });
            }
            else
            {
                index= parseInt(index) + 1;
                rekursivemultiarea(index,id,multiinfonama,multiinfodesc, IDFIELD);
            }
        }
    }

 


function clearForm(){
    $('#ff').form('clear');
}   
</script>