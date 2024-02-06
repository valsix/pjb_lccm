<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/M_Inflasi_Calculate");
$this->load->model("base-app/M_Inflasi");


$pgreturn= str_replace("_add", "", $pg);

$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$reqId = $this->input->get("reqId");
$reqLihat = $this->input->get("reqLihat");


$set= new M_Inflasi_Calculate();

if($reqId == "")
{
    $reqMode = "insert";
}
else
{
    $reqMode = "update";

	$statement = " AND A.M_INFLASI_CALCULATE_ID = '".$reqId."' ";
    $set->selectByParams(array(), -1, -1, $statement);
    // echo $set->query;exit;
    $set->firstRow();
    $reqId= $set->getField("M_INFLASI_CALCULATE_ID");
    $reqTahunAwal= $set->getField("TAHUN_AWAL");
    $reqTahunAkhir= $set->getField("TAHUN_AKHIR");
    $reqRata= $set->getField("INFLASI");
    // $reqTahunAwalReadonly= " readonly ";


}

$disabled="";

if($reqLihat ==1)
{
    $disabled="disabled";  
}

$tahun = date("Y");

$set= new M_Inflasi();
$arrset= [];

$statement=" ";
$set->selectByParams(array(), -1,-1,$statement);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["ID"]= $set->getField("ID");
    $arrdata["TAHUN"]= $set->getField("TAHUN");
    $arrdata["F"]= $set->getField("F");
    $arrdata["FP1"]= $set->getField("FP1");
    $arrdata["STATUS"]= $set->getField("STATUS");
    array_push($arrset, $arrdata);
}
unset($set);

$set= new M_Inflasi();
$arrproduct= [];

$statement="  ";
$set->selectByParamsAll(array(), -1,-1,$statement);
        // echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["FP1"]=  $set->getField("FP1");

    array_push($arrproduct, $arrdata);
}
unset($set);

// print_r($arrproduct);exit;




?>

<script src='assets/multifile-master/jquery.form.js' type="text/javascript" language="javascript"></script> 
<script src='assets/multifile-master/jquery.MetaData.js' type="text/javascript" language="javascript"></script> 
<script src='assets/multifile-master/jquery.MultiFile.js' type="text/javascript" language="javascript"></script> 
<link rel="stylesheet" href="css/gaya-multifile.css" type="text/css">

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



</style>

<div class="col-md-12">
    
  <div class="judul-halaman"> Data Kalkulator <?=$pgtitle?> &rsaquo; Kelola Kalkulator <?=$pgtitle?></div>

    <div class="konten-area">
        <div class="konten-inner">

            <div>

                <form id="ff" class="easyui-form form-horizontal" method="post" novalidate enctype="multipart/form-data">

                    <div class="page-header">
                        <h3><i class="fa fa-file-text fa-lg"></i> Kalkulator <?=$pgtitle?></h3>       
                    </div>
                    <div id="calculator">
                        <div class="form-group">  
                            <label class="control-label col-md-2">Tahun Awal </label>
                            <div class='col-md-4'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                      <select class="form-control jscaribasicmultiple " id="reqTahunAwal" <?=$disabled?> name="reqTahunAwal"  style="width:100%;" >
                                        <option value="" >Pilih Tahun Awal</option>
                                            <? 
                                            foreach($arrset as $item) 
                                            {
                                                $selectvalid= $item["ID"];
                                                $selectvaltext= $item["TAHUN"];

                                                $selected="";
                                                if(empty($reqTahunAwal))
                                                {
                                                    // if($selectvaltext==$tahun)
                                                    // {
                                                    //     $selected="selected";
                                                    // }
                                                }
                                                else
                                                {
                                                    if($selectvaltext==$reqTahunAwal)
                                                    {
                                                        $selected="selected";
                                                    }
                                                }
                                               
                                                ?>
                                                <option value="<?=$selectvaltext?>" <?=$selected?>><?=$selectvaltext?></option>
                                                <?
                                            }
                                            ?>
                                        </select>
                                   </div>
                               </div>
                           </div>
                        </div>

                        <div class="form-group">  
                            <label class="control-label col-md-2">Tahun Akhir </label>
                            <div class='col-md-4'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                       <select class="form-control jscaribasicmultiple " id="reqTahunAkhir" <?=$disabled?> name="reqTahunAkhir"  style="width:100%;" >
                                        <option value="" >Pilih Tahun Akhir</option>
                                            <? 
                                            foreach($arrset as $item) 
                                            {
                                                $selectvalid= $item["ID"];
                                                $selectvaltext= $item["TAHUN"];

                                                $selected="";
                                                if(empty($reqTahunAkhir))
                                                {
                                                    if($selectvaltext==$tahun)
                                                    {
                                                        $selected="selected";
                                                    }
                                                }
                                                else
                                                {
                                                    if($selectvaltext==$reqTahunAkhir)
                                                    {
                                                        $selected="selected";
                                                    }
                                                }
                                                ?>
                                                <option value="<?=$selectvaltext?>" <?=$selected?>><?=$selectvaltext?></option>
                                                <?
                                            }
                                            ?>
                                        </select>
                                   </div>
                               </div>
                           </div>
                        </div>
                                                                                 
                        <div class="form-group" >  
                            <label class="control-label col-md-2">Inflasi Rata Rata (%)</label>
                            <div class='col-md-4'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                       <input autocomplete="off" readonly  class="easyui-validatebox textbox form-control" type="text" name="reqRata"  id="reqRata" value="<?=$reqRata?>" <?=$disabled?> style="width:100%" />
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <input type="hidden" name="reqId" value="<?=$reqId?>" />
                    <input type="hidden" name="reqMode" value="<?=$reqMode?>" />

                </form>

            </div>
            <?
            if($reqLihat ==1)
            {}
            else
            {
            ?>
            <div style="text-align:center;padding:5px">
                <a href="javascript:void(0)" class="btn btn-success" id="tombolcal" onclick="hideshow()">Hide Calculator</a>

                <br>
                <br>
                <br>

                <iframe src="iframe/index/m_inflasi?reqDistrikId=<?=$reqId?>" width="100%" height="800"></iframe>

            </div>
            <?
            }
            ?>
            
        </div>
    </div>
    
</div>

<script>
function hideshow()
{
    $("#calculator").toggle();
    if ($("#calculator").is(':hidden')) {
        $("#tombolcal").text('Show Calculator');
    }
    else
    {
        $("#tombolcal").text('Hide Calculator');
    }
}
$('#reqTahunAwal,#reqTahunAkhir').on('change', function() {
    var reqTahunAwal = $("#reqTahunAwal").val();
    var reqTahunAkhir = $("#reqTahunAkhir").val();
    if(reqTahunAwal==reqTahunAkhir)
    {
         $("#reqRata").val('');
        alert("Tahun Awal / Tahun Akhir tidak boleh sama");return false;
    }

    if(reqTahunAwal > reqTahunAkhir)
    {
        $("#reqRata").val('');
       alert("Tahun Awal tidak boleh lebih dari Tahun Akhir");return false;
    }
    $.ajax({
          type: "GET",
          url: "json-app/inflasi_json/kalkulasi?reqTahunAwal="+reqTahunAwal+"&reqTahunAkhir="+reqTahunAkhir,
          cache: false,
          success: function(data){
            $("#reqRata").val(data);
        }
     });
});

function submitForm(){
   
    $('#ff').form('submit',{
        url:'json-app/inflasi_json/add',
        onSubmit:function(){

            if($(this).form('validate'))
            {
                var win = $.messager.progress({
                    title:'<?=$this->configtitle["progres"]?>',
                    msg:'proses data...'
                });
            }

            return $(this).form('enableValidation').form('validate');
        },
        success:function(data){
            $.messager.progress('close');
            // console.log(data);return false;

            data = data.split("***");
            reqId= data[0];
            infoSimpan= data[1];

            if(reqId == 'xxx')
                $.messager.alert('Info', infoSimpan, 'warning');
            else
                $.messager.alertLink('Info', infoSimpan, 'info', "app/index/<?=$pgreturn?>");
        }
    });
}

function clearForm(){
    $('#ff').form('clear');
}   
</script>