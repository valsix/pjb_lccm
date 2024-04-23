<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/T_Lccm_Prj");
$this->load->model("base-app/Distrik");
$this->load->model("base-app/BlokUnit");
$this->load->model("base-app/UnitMesin");


$pgreturn= str_replace("_add", "", $pg);

$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$reqId = $this->input->get("reqId");
$reqLihat = $this->input->get("reqLihat");


$set= new T_Lccm_Prj();

if($reqId == "")
{
    $reqMode = "insert";
}
else
{
    $reqMode = "update";

	$statement = " AND A.PROJECT_NAME = '".$reqId."' ";
    $set->selectByParams(array(), -1, -1, $statement);
    // echo $set->query;exit;
    $set->firstRow();
    $reqId= $set->getField("PROJECT_NAME");
    $reqDistrikId= $set->getField("KODE_DISTRIK");
    $reqBlokId= $set->getField("KODE_BLOK");
    $reqUnitMesinId= $set->getField("KODE_UNIT_M");
    $reqProjectNo= $set->getField("PROJECT_NAME");

    $reqProjectDesc= $set->getField("PROJECT_DESC");
    $reqHistoryYearStart= $set->getField("LCCM_START_HIST_YEAR");
    $reqHistoryYearEnd= $set->getField("LCCM_END_HIST_YEAR");
    $reqPrediction= $set->getField("LCCM_PREDICT_YEAR");

    $reqDiscount= $set->getField("DISC_RATE");
    $reqPlant= toThousandComma($set->getField("PLANT_CAPITAL_COST"));

    $reqHistoryRate= $set->getField("HIST_INFLASI_RATE");
    $reqAnnualRate= $set->getField("ANNUAL_INFLASI_RATE");
   

}

$disabled="";

if($reqLihat ==1)
{
    $disabled="disabled";  
}

$tahun = date("Y");



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

$set= new BlokUnit();
$arrblok= [];

if(empty($reqId))
{
    if(empty($reqBlokId))
    {
        $statement=" AND 1=2 ";
    }
    else
    {
         $statement = " AND A.KODE = '".$reqBlokId."'";
    }
}
else
{
    $statement=" AND A.KODE <> ''  AND B.KODE = '".$reqDistrikId."' ";
}


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
if(empty($reqBlokId))
{
    $statement=" AND 1=2";
}
else
{
    $statement=" AND C.KODE = '".$reqBlokId."' AND  B.KODE = '".$reqDistrikId."'   ";
}

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


$set= new T_Lccm_Prj();
$arrprojectno= [];
$statement="  ";

$set->selectByParamsProjectNo(array(), -1,-1,$statement);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("PROJECT_NAME");
    $arrdata["text"]= $set->getField("PROJECT_NAME");
    array_push($arrprojectno, $arrdata);
}
unset($set);

$readonly="";
if(!empty($reqId))
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
    
    <div class="judul-halaman"> <a href="app/index/<?=$pgreturn?>">Data <?=$pgtitle?></a> &rsaquo; Kelola <?=$pgtitle?></div>


    <div class="konten-area">
        <div class="konten-inner">

            <div>

                <form id="ff" class="easyui-form form-horizontal" method="post" novalidate enctype="multipart/form-data" >

                    <div class="page-header">
                        <h3><i class="fa fa-file-text fa-lg"></i> <?=$pgtitle?></h3>       
                    </div>

                        <div class="form-group">  
                            <label class="control-label col-md-2">Distrik </label>
                            <div class='col-md-6'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                        <select class="form-control jscaribasicmultiple"  <?=$readonly?> <?=$readonlyblok?>  required id="reqDistrikId" <?=$disabled?> name="reqDistrikId"  style="width:100%;" >
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
                                                <option value="<?=$selectvalkode?>" <?=$selected?>><?=$selectvalkode?> - <?=$selectvaltext?></option>
                                                <?
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">  
                            <label class="control-label col-md-2">Blok Unit </label>
                            <div class='col-md-6'>
                                <div class='form-group'>
                                    <div class='col-md-11' id="blok">
                                         <select class="form-control jscaribasicmultiple"   <?=$readonlyfilter?> required  <?=$readonlyblok?> <?=$readonly?> readonly id="reqBlokId"   name="reqBlokId"  style="width:100%;"  >
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
                                                <option value="<?=$selectvalkode?>" <?=$selected?>><?=$selectvalkode?> - <?=$selectvaltext?></option>

                                                <?
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="form-group" >  
                            <label class="control-label col-md-2">Unit Mesin </label>
                            <div class='col-md-6'>
                                <div class='form-group'>
                                    <div class='col-md-11'  id="unit">
                                        <select class="form-control jscaribasicmultiple"  <?=$readonly?> <?=$readonlyfilter?> required  readonly id="reqUnitMesinId" <?=$disabled?> name="reqUnitMesinId"  style="width:100%;" >
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
                                                <option value="<?=$selectvalkode?>" <?=$selected?>><?=$selectvalkode?> - <?=$selectvaltext?></option>

                                                <?
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group" >  
                            <label class="control-label col-md-2">History Year </label>
                            <div class='col-md-4'>
                                <div class='form-group'>
                                    <div class='col-md-6'>
                                       <input  maxlength="4" <?=$readonly?>  class="easyui-validatebox textbox form-control" required  type="text" name="reqHistoryYearStart"  id="reqHistoryYearStart" value="<?=$reqHistoryYearStart?>" <?=$disabled?> style="width:50%" />
                                   </div>
                                   <div class='col-md-6'>
                                       <input  maxlength="4" <?=$readonly?>  class="easyui-validatebox textbox form-control" required  type="text" name="reqHistoryYearEnd"  id="reqHistoryYearEnd" value="<?=$reqHistoryYearEnd?>" <?=$disabled?> style="width:50%" />
                                   </div>
                                </div>
                            </div>
                        </div>


                        <div class="form-group" >  
                            <label class="control-label col-md-2">Prediction Year </label>
                            <div class='col-md-4'>
                                <div class='form-group'>
                                    <div class='col-md-6'>
                                       <input  maxlength="4" <?=$readonly?>  class="easyui-validatebox textbox form-control" required  type="text" name="reqPrediction"  id="reqPrediction" value="<?=$reqPrediction?>" <?=$disabled?> style="width:50%" />
                                   </div>
                               </div>
                           </div>
                       </div>

                       <div class="form-group" >  
                            <label class="control-label col-md-2">Discount Rate </label>
                            <div class='col-md-4'>
                                <div class='form-group'>
                                    <div class='col-md-4'>
                                       <input  maxlength="4" <?=$readonly?>  class="easyui-validatebox textbox form-control" required  type="text" name="reqDiscount"  id="reqDiscount" value="<?=$reqDiscount?>" <?=$disabled?> style="width:50%" />
                                   </div>
                               </div>
                           </div>
                       </div>

                       <div class="form-group" >  
                            <label class="control-label col-md-2">Plant Capital Cost </label>
                            <div class='col-md-4'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                       <input   <?=$readonly?>  class="easyui-validatebox textbox form-control" required  type="text" name="reqPlant"  id="reqPlant" value="<?=$reqPlant?>" <?=$disabled?> style="width:50%" />
                                   </div>
                               </div>
                           </div>
                       </div>

                       
                           
                        <div id="selectno">
                            <div class="form-group" >  
                                <label class="control-label col-md-2">Project No </label>
                                <div class='col-md-4'>
                                    <div class='form-group'>
                                        <div class='col-md-6'>
                                          <!--  <input  <?=$readonly?> required  class="easyui-validatebox textbox form-control" readonly type="text" name="reqProjectNo"  id="reqProjectNo" value="<?=$reqProjectNo?>" <?=$disabled?> style="width:50%" /> -->
                                          <?
                                          if(!empty($reqId))
                                          {
                                            ?>
                                                <select class="form-control jscaribasicmultiple"  <?=$readonly?> <?=$readonlyfilter?> class="prono"   id="reqProjectNoSelect" <?=$disabled?> name="reqProjectNo"  style="width:100%;" >
                                                    <!-- <option value="" >Pilih Project No</option> -->
                                                    <?
                                                    foreach($arrprojectno as $item) 
                                                    {
                                                        $selectvalid= $item["id"];
                                                        $selectvaltext= $item["text"];
                                                        $selected="";
                                                        if($selectvalid == $reqProjectNo)
                                                        {
                                                            $selected="selected";
                                                        }


                                                        ?>
                                                        <option value="<?=$selectvalid?>" <?=$selected?>><?=$selectvaltext?></option>

                                                        <?
                                                    }
                                                    ?>
                                                </select>
                                            <?
                                            }
                                            else
                                            {
                                            ?>
                                                <input  <?=$readonly?> required  class="easyui-validatebox textbox form-control" maxlength="2"  type="text" name="reqProjectNo"  id="reqProjectNo" value="<?=$reqProjectNo?>" <?=$disabled?> style="width:50%" />
                                            <?
                                            }
                                            ?>
                                        </div>
                                    </div>
                               </div>
                            </div>

                            <div class="form-group" >  
                                <label class="control-label col-md-2">Project Desc </label>
                                <div class='col-md-4'>
                                    <div class='form-group'>
                                        <div class='col-md-11'>
                                           <input   <?=$readonly?>  class="easyui-validatebox textbox form-control" required    type="text" name="reqProjectDesc"  id="reqProjectDesc" value="<?=$reqProjectDesc?>" <?=$disabled?> style="width:50%" />
                                        </div>
                                    </div>
                               </div>
                            </div>

                        </div>




                    <input type="hidden" name="reqId" value="<?=$reqId?>" />
                    <input type="hidden" name="reqMode" value="<?=$reqMode?>" />
                    <input type="hidden" name="reqProjectNoOld" value="<?=$reqProjectNo?>" />

                </form>

            </div>
            <?
            if($reqLihat ==1)
            {}
            else
            {
            ?>
            <div style="text-align:center;padding:5px">
                
                <?
                if(!empty($reqId))
                {
                ?>
                <a href="javascript:void(0)" class="btn btn-warning" id="new" onclick="formnew('formbaru')">New</a>
                <!-- <a href="javascript:void(0)" class="btn btn-success"  id="edit" onclick="formkondisi('<?=$reqId?>')">Edit</a> -->
                <?
                }
                ?>
                <a href="javascript:void(0)" class="btn btn-primary" id="simpan" onclick="submitForm()">Simpan</a>
                <a href="javascript:void(0)" class="btn btn-danger" id="delete" onclick="deleteData('<?=$reqId?>')">Delete</a>
            </div>
            <?
            }
            ?>
            
        </div>
    </div>
    
</div>

<script>

    // $('#reqPrediction').on('change keyup blur', function(e){ 
    //       id_arr = $(this).attr('id');

    //       var fullPay = $('#reqPrediction').val();
    //       var advancePay = '<?=$reqPredictionMin?>';

    //       console.log(fullPay);
    //       console.log(advancePay);

    //       if (parseInt(fullPay) < parseInt(advancePay)) {
    //         console.log(1);
    //         e.preventDefault();     
    //         $(this).val("");
    //      }
    //  });

    $('#reqPlant').keyup(function(event) {
      if (event.which >= 37 && event.which <= 40) return;
      $(this).val(function(index, value) {
        return value
          // Keep only digits and decimal points:
          .replace(/[^\d.]/g, "")
          // Remove duplicated decimal point, if one exists:
          .replace(/^(\d*\.)(.*)\.(.*)$/, '$1$2$3')
          // Keep only two digits past the decimal point:
          .replace(/\.(\d{2})\d+/, '.$1')
          // Add thousands separators:
          .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
      });
    });


    // $('#simpan').hide();
    
    $('#delete').hide();
    $('#edit').show();
    $('#new').show();

    var reqId='<?=$reqId?>';

    if(reqId)
    {
        $('#edit').show(); 
        $('#new').show();
        $('#delete').show();
        $('#simpan').show();

    }

    function formnew(){
        window.location.href = 'app/index/<?=$pgreturn?>';
    }

    function formkondisi(id)
    {
        $('#simpan').show();
       
        $('#simpan').show();
        // console.log(id);
        if(id=="formbaru")
        {
            $('#new').hide();
            $('#edit').hide();
            $(':input').removeAttr('readonly');
            $('#ff').form('clear');

            $("#reqDistrikId").val("").trigger( "change" );
            $("#reqId").val("").trigger( "change" );
            $('#delete').hide();
            $("#selectno").hide();
            $("#reqProjectNo").val("").trigger( "change" );
            // $('#ff').trigger("reset");
        }
        else
        {
            $('#edit').hide();
            $('#new').hide();
             $(":input").removeAttr('readonly');
            $("#reqProjectNo").removeAttr('readonly');
            $("#selectno").show();
            $('#simpan').show();
        }
    }


    $("#reqDiscount").keydown(function (event) {
        if (event.shiftKey == true) {
            event.preventDefault();
        }

        // console.log(event.keyCode);

        if ((event.keyCode >= 48 && event.keyCode <= 57) || 
            (event.keyCode >= 96 && event.keyCode <= 105) || 
            event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 ||
            event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190 || event.keyCode == 188) {

        } else {
            event.preventDefault();
        }

        if($(this).val().indexOf('.') !== -1 && event.keyCode == 190)
            event.preventDefault(); 

    });


    $("#reqHistoryYearStart,#reqHistoryYearEnd,#reqPrediction,#reqPlant").keydown(function (event) {
        if (event.shiftKey == true) {
            event.preventDefault();
        }

        // console.log(event.keyCode);

        if ((event.keyCode >= 48 && event.keyCode <= 57) || 
            (event.keyCode >= 96 && event.keyCode <= 105) || 
            event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 ||
            event.keyCode == 39 || event.keyCode == 46 ) {

        } else {
            event.preventDefault();
        }

       
    });



    $('#reqDistrikId').on('change', function() {
    // $("#blok").empty();
    var reqDistrikId= this.value;

    $.getJSON("json-app/blok_unit_json/filter_blok?reqDistrikId="+reqDistrikId,
        function(data)
        {
            // console.log(data);
            $("#reqBlokId option").remove();
            $("#reqUnitMesinId option").remove();
            $("#reqBlokId").attr("readonly", false); 
            $("#reqBlokId").append('<option value="" >Pilih Blok Unit</option>');
            jQuery(data).each(function(i, item){
                $("#reqBlokId").append('<option value="'+item.KODE+'" >'+item.text+'</option>');
            });
        });
    
    });

    $('#reqBlokId').on('change', function() {
    // $("#blok").empty();
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

    $('#reqProjectNoSelect').on('change', function() {
        var reqId= this.value;
        window.location.href = "app/index/<?=$pgreturn?>?reqId="+reqId;

    });

    function deleteData(valinfoid){

        if(valinfoid == "" )
        {
            $.messager.alert('Info', "Pilih salah satu data terlebih dahulu.", 'warning');
            return false;
        }

        var pesan='Apakah anda yakin untuk hapus data Project No '+valinfoid+' ?';

        $.messager.confirm('Konfirmasi',pesan,function(r){
            if (r){
                $.getJSON("json-app/lccm_json/delete?reqId="+valinfoid,
                    function(data){
                        // $.messager.alert('Info', data.PESAN, 'info');
                        // valinfoid= "";
                        $.messager.alertLink('Info', data.PESAN, 'info', "app/index/<?=$pgreturn?>");
                    });

            }
        }); 
   
   }

function submitForm(){
   
    $('#ff').form('submit',{
        url:'json-app/lccm_json/add',
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
                $.messager.alertLink('Info', infoSimpan, 'info', "app/index/<?=$pgreturn?>?reqId="+reqId);
            // $.messager.alertLink('Info', infoSimpan, 'info', "app/index/<?=$pgreturn?>");
        }
    });
}

function clearForm(){
    $('#ff').form('clear');
}   
</script>