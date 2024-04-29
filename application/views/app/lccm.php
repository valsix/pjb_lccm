<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/T_Lccm_Prj");
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


$set= new T_Lccm_Prj();

if($reqId == "")
{
    $reqMode = "insert";
    $reqDiscount="12";
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

if(empty($reqId) && empty($reqDelete) )
{
    $statement=" AND 1=2";
}
else
{
    if(!empty($reqDistrikId) && !empty($reqBlokId)  && !empty($reqUnitMesinId))
    {
       $statement=" AND A.KODE_DISTRIK = '".$reqDistrikId."' AND A.KODE_BLOK = '".$reqBlokId."' AND A.KODE_UNIT_M = '".$reqUnitMesinId."' ";
    }

}

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

.select2-selection.required {
   background-color: yellow !important;
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
                                         <select class="form-control jscaribasicmultiple"   <?=$readonlyfilter?> required  <?=$readonlyblok?> <?=$readonly?>  id="reqBlokId"   name="reqBlokId"  style="width:100%;"  >
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
                                        <select class="form-control jscaribasicmultiple"  <?=$readonly?> <?=$readonlyfilter?> required   id="reqUnitMesinId" <?=$disabled?> name="reqUnitMesinId"  style="width:100%;" >
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
                    <div id="datadetil">
                        
                        <div class="form-group" >  
                            <label class="control-label col-md-2">History Year </label>
                            <div class='col-md-4'>
                                <div class='form-group'>
                                    <div class='col-md-5'>
                                        <select class="form-control jscaribasicmultiple" name="reqHistoryYearStart" required  id="reqHistoryYearStart">
                                            <option value="" >Pilih Tahun Awal</option>
                                        </select>
                                      <!--  <input  maxlength="5" <?=$readonly?> readonly  class="easyui-validatebox textbox form-control" required  type="text" name="reqHistoryYearStart"  id="reqHistoryYearStart" value="<?=$reqHistoryYearStart?>" <?=$disabled?> /> -->
                                    </div>
                                    <div class='col-md-1' style="margin-top: 5px">-</div>
                                    <div class='col-md-5'>
                                       <!-- <input  maxlength="4" <?=$readonly?>  class="easyui-validatebox textbox form-control" required  type="text" name="reqHistoryYearEnd"  id="reqHistoryYearEnd" value="<?=$reqHistoryYearEnd?>" <?=$disabled?>  /> -->
                                       <select class="form-control jscaribasicmultiple" name="reqHistoryYearEnd" required  id="reqHistoryYearEnd">
                                            <option value="" >Pilih Tahun Akhir</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="form-group" >  
                            <label class="control-label col-md-2">Prediction Year </label>
                            <div class='col-md-4'>
                                <div class='form-group'>
                                    <div class='col-md-5'>
                                       <!-- <input  maxlength="4" <?=$readonly?>  class="easyui-validatebox textbox form-control" required  type="text" name="reqPrediction"  id="reqPrediction" value="<?=$reqPrediction?>" <?=$disabled?> style="width:50%" /> -->

                                        <select class="form-control jscaribasicmultiple" name="reqPrediction" required  id="reqPrediction">
                                            <option value="" >Pilih Prediction</option>
                                            <?
                                            for ($x = $tahunnow; $x <= $tahunkedepan; $x++) 
                                            {
                                                $selected="";

                                                if($tahunnow == $x)
                                                {
                                                    $selected="selected";
                                                }
                                            ?>
                                            <option value="<?=$x?>" <?=$selected?>><?=$x?></option>
                                            <? 
                                                
                                            }
                                            ?>
                                            
                                        </select>
                                   </div>
                               </div>
                           </div>
                       </div>

                       <div class="form-group" >  
                            <label class="control-label col-md-2">Discount Rate </label>
                            <div class='col-md-4'>
                                <div class='form-group'>
                                    <div class='col-md-3'>
                                       <input  maxlength="5" <?=$readonly?>  class="easyui-validatebox textbox form-control" required  type="text" name="reqDiscount"  id="reqDiscount" value="<?=$reqDiscount?>" <?=$disabled?> style="width:95%"  />
                                    </div>
                                    %
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

                        <div class="form-group" >  
                            <label class="control-label col-md-2">Project No </label>
                            <div class='col-md-10'>
                                <div class='form-group'>
                                    <div class='col-md-2'>
                                        <input  <?=$readonly?> readonly  class="easyui-validatebox textbox form-control"   type="text" name="reqProjectNoR"  id="reqProjectNoR" value="<?=$reqProjectNoR?>" <?=$disabled?>  />
                                    </div>
                                    <div class='col-md-2'>
                                        <select class="form-control jscaribasicmultiple"  <?=$readonly?> <?=$readonlyfilter?> class="prono"   id="reqProjectNo" <?=$disabled?> name="reqProjectNo"  style="width:100%;" >
                                            <?
                                            foreach (range('A', 'Z') as $column)
                                            {
                                                $selected="";
                                                if($reqProjectNo == $column)
                                                {
                                                    $selected="selected";
                                                }
                                            ?>
                                            <option value="<?=$column ?>" <?=$selected?>><?=$column ?></option>
                                            <?
                                            }

                                            ?>
                                        </select>
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

                        <div class="form-group" >  
                            <label class="control-label col-md-2">History Inflation Rate </label>
                            <div class='col-md-4'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                       <input   <?=$readonly?>  class="easyui-validatebox textbox form-control"  readonly    type="text" name="reqHistoryInflasi"  id="reqHistoryInflasi" value="<?=$reqHistoryInflasi?>" <?=$disabled?> style="width:50%" />
                                   </div>
                               </div>
                           </div>
                        </div>

                        <div class="form-group" >  
                            <label class="control-label col-md-2">Annual Inflation Rate </label>
                            <div class='col-md-4'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                       <input   <?=$readonly?>  class="easyui-validatebox textbox form-control"  readonly    type="text" name="reqAnnual"  id="reqAnnual" value="<?=$reqAnnual?>" <?=$disabled?> style="width:50%" />
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
                <!-- <a href="javascript:void(0)" class="btn btn-warning" id="new" onclick="formnew('new')">New</a> -->
                <!-- <a href="javascript:void(0)" class="btn btn-success"  id="edit" onclick="formnew('edit')">Edit</a> -->
                <a href="javascript:void(0)" class="btn btn-primary" id="simpan" onclick="submitForm()">Simpan</a>
                
                <?
                if(!empty($reqStatus))
                {
                ?>
                        <?
                        if($reqStatus=="new")
                        {
                            ?>

                            <!-- <a href="javascript:void(0)" class="btn btn-primary" id="simpan" onclick="submitForm()">Simpan</a> -->
                            <?
                        }
                        ?>

                        <?
                        if($reqStatus=="edit" && !empty($reqId))
                        {
                            ?>

                           <!--  <a href="javascript:void(0)" class="btn btn-primary" id="simpan" onclick="submitForm()">Simpan</a>
                            <a href="javascript:void(0)" class="btn btn-danger" id="delete" onclick="deleteData('<?=$reqId?>')">Delete</a> -->
                            <?
                        }
                        ?>
                <?
                }
                ?>
                
            </div>
            <?
            }
            ?>
            
        </div>
    </div>
    
</div>

<script>
$('select').select2({
  placeholder: 'This is my placeholder',
  allowClear: false
});
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
    var reqStatus='<?=$reqStatus?>';

    if(reqId)
    {
        $('#edit').show(); 
        $('#new').show();
        $('#delete').show();
        $('#simpan').show();

    }


    if(reqStatus=='new')
    {
        $('#new').hide();
       

    }

    if(reqStatus=='edit' &&  reqId=="")
    {
        $(":input").not('#reqDistrikId,#reqBlokId,#reqUnitMesinId,#reqProjectNoSelect').attr('disabled', 'disabled');
        $('#edit').hide();
        // $('#reqProjectNoSelect').attr('readonly', 'readonly');

    }

    function formnew(status){
        var reqDistrikId= $("#reqDistrikId").val();
        var reqBlokId= $("#reqBlokId").val();
        var reqUnitMesinId= $("#reqUnitMesinId").val();
        if(status=='kembali')
        {
             window.location.href = 'app/index/<?=$pgreturn?>?reqStatus=edit&reqDistrikId='+reqDistrikId+'&reqBlokId='+reqBlokId+'&reqUnitMesinId='+reqUnitMesinId;
        }
        else
        {
             window.location.href = 'app/index/<?=$pgreturn?>?reqStatus='+status;
        }
       
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

        var reqDistrikId= $("#reqDistrikId").val();
        var reqBlokId= $("#reqBlokId").val();
        var reqUnitMesinId= $("#reqUnitMesinId").val();
        var reqHistoryYearStart= $("#reqHistoryYearStart").val();
        var reqHistoryYearEnd= $("#reqHistoryYearEnd").val();
        var reqPrediction= $("#reqPrediction").val();
        var reqProjectNoR= reqDistrikId +'-'+ reqBlokId +'-'+ reqUnitMesinId +'-'+ reqHistoryYearStart +'-'+ reqHistoryYearEnd +'-'+reqPrediction+'-';
        $("#reqProjectNoR").val(reqProjectNoR);
    
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
            $("#reqUnitMesinId").append('<option value="" >Pilih Unit Mesin</option>');
            jQuery(data).each(function(i, item){
                $("#reqUnitMesinId").append('<option value="'+item.KODE+'" >'+item.text+'</option>');
            });
        });

    var reqDistrikId= $("#reqDistrikId").val();
    var reqBlokId= $("#reqBlokId").val();
    var reqUnitMesinId= $("#reqUnitMesinId").val();
    if(reqUnitMesinId==null)
    {
        reqUnitMesinId="";
    }
    var reqHistoryYearStart= $("#reqHistoryYearStart").val();
    var reqHistoryYearEnd= $("#reqHistoryYearEnd").val();
    var reqPrediction= $("#reqPrediction").val();
    var reqProjectNoR= reqDistrikId +'-'+ reqBlokId +'-'+ reqUnitMesinId +'-'+ reqHistoryYearStart +'-'+ reqHistoryYearEnd +'-'+reqPrediction+'-';
    $("#reqProjectNoR").val(reqProjectNoR);

    
    });


    $('#reqUnitMesinId').on('change', function() {
    // $("#blok").empty();
        var reqDistrikId= $("#reqDistrikId").val();
        var reqBlokId= $("#reqBlokId").val();
        var reqUnitMesinId= this.value;
        var reqStatus= '<?=$reqStatus?>';
        if(reqStatus=='new')
        {

        }
        else if(reqStatus=='edit')
        {
            $.get("app/loadUrl/app/template_lccm_add?reqDistrikId="+reqDistrikId+"&reqBlokId="+reqBlokId+"&reqUnitMesinId="+reqUnitMesinId, function(data) {
                 $("#datadetil").empty();
                $("#datadetil").append(data);
            });

        }

        $.getJSON("json-app/lccm_json/filter_history?reqMode=awal&reqDistrikId="+reqDistrikId+"&reqBlokId="+reqBlokId+"&reqUnitMesinId="+reqUnitMesinId,
        function(data)
        {
            // console.log(data);
            $("#reqHistoryYearStart option").remove();
            $("#reqHistoryYearStart").attr("readonly", false); 
            $("#reqHistoryYearStart").append('<option value="" >Pilih Tahun Awal</option>');
            var selected='';
            var selectedval='';
            jQuery(data).each(function(i, item){
                // console.log(item.selected +' - '+item.id);
                if(item.selected==item.id)
                {
                    selected='selected';
                    selectedval=item.selected;
                    
                }
                else
                {
                    selected='';
                }
                $("#reqHistoryYearStart").append('<option value="'+item.id+'" '+selected+' >'+item.text+'</option>');
            });
            if(selectedval)
            {
                $('#reqHistoryYearStart').val(selectedval).trigger('change');
            }
        });

        $.getJSON("json-app/lccm_json/filter_history?reqMode=akhir&reqDistrikId="+reqDistrikId+"&reqBlokId="+reqBlokId+"&reqUnitMesinId="+reqUnitMesinId,
        function(data)
        {
            // console.log(data);
            $("#reqHistoryYearEnd option").remove();
            $("#reqHistoryYearEnd").attr("readonly", false); 
            var tahunsekarang=new Date().getFullYear() -1;
            $("#reqHistoryYearEnd").append('<option value="" >Pilih Tahun Akhir</option>');
            var selected='';
            var selectedval='';
            jQuery(data).each(function(i, item){

                if(item.id==tahunsekarang)
                {
                    selected='selected';
                    selectedval=tahunsekarang;
                }
                else
                {
                    selected='';
                }
                $("#reqHistoryYearEnd").append('<option value="'+item.id+'" '+selected+' >'+item.text+'</option>');
            });
            if(selectedval)
            {
                $('#reqHistoryYearEnd').val(selectedval).trigger('change');
            }
        });

        $('#reqHistoryYearEnd').attr("required", "required" );

        var reqDistrikId= $("#reqDistrikId").val();
        var reqBlokId= $("#reqBlokId").val();
        var reqUnitMesinId= $("#reqUnitMesinId").val();
        var reqHistoryYearStart= $("#reqHistoryYearStart").val();
        var reqHistoryYearEnd= $("#reqHistoryYearEnd").val();
        var reqPrediction= $("#reqPrediction").val();
        var reqProjectNoR= reqDistrikId +'-'+ reqBlokId +'-'+ reqUnitMesinId +'-'+ reqHistoryYearStart +'-'+ reqHistoryYearEnd +'-'+reqPrediction+'-';
        $("#reqProjectNoR").val(reqProjectNoR);

    
    });



    $('#reqProjectNoSelect').on('change', function() {
        var reqId= this.value;
        window.location.href = "app/index/<?=$pgreturn?>?reqStatus=edit&reqId="+reqId;

    });

    $('#reqHistoryYearStart,#reqHistoryYearEnd').on('change', function() {
        var reqDistrikId= $("#reqDistrikId").val();
        var reqBlokId= $("#reqBlokId").val();
        var reqUnitMesinId= $("#reqUnitMesinId").val();
        var reqHistoryYearStart= $("#reqHistoryYearStart").val();
        var reqHistoryYearEnd= $("#reqHistoryYearEnd").val();
        var reqPrediction= $("#reqPrediction").val();
        var reqProjectNoR= reqDistrikId +'-'+ reqBlokId +'-'+ reqUnitMesinId +'-'+ reqHistoryYearStart +'-'+ reqHistoryYearEnd +'-'+reqPrediction+'-';
        $("#reqProjectNoR").val(reqProjectNoR);

    });

    $('#reqPrediction').on('change', function() {
        var reqDistrikId= $("#reqDistrikId").val();
        var reqBlokId= $("#reqBlokId").val();
        var reqUnitMesinId= $("#reqUnitMesinId").val();
        var reqHistoryYearStart= $("#reqHistoryYearStart").val();
        var reqHistoryYearEnd= $("#reqHistoryYearEnd").val();
        var reqPrediction= $("#reqPrediction").val();
        var reqProjectNoR= reqDistrikId +'-'+ reqBlokId +'-'+ reqUnitMesinId +'-'+ reqHistoryYearStart +'-'+ reqHistoryYearEnd +'-'+reqPrediction+'-';
        $("#reqProjectNoR").val(reqProjectNoR);

    });

    $('#reqProjectNo').on('change', function() {
        var reqDistrikId= $("#reqDistrikId").val();
        var reqBlokId= $("#reqBlokId").val();
        var reqUnitMesinId= $("#reqUnitMesinId").val();
        var reqHistoryYearStart= $("#reqHistoryYearStart").val();
        var reqHistoryYearEnd= $("#reqHistoryYearEnd").val();
        var reqPrediction= $("#reqPrediction").val();
        var reqProjectNoR= reqDistrikId +'-'+ reqBlokId +'-'+ reqUnitMesinId +'-'+ reqHistoryYearStart +'-'+ reqHistoryYearEnd +'-'+reqPrediction+'-';
        $("#reqProjectNoR").val(reqProjectNoR);

    });

    $('#reqHistoryYearStart,#reqHistoryYearEnd').on('change', function() {
        var reqHistoryYearStart = $("#reqHistoryYearStart").val();
        var reqHistoryYearEnd = $("#reqHistoryYearEnd").val();
        var reqPrediction = $("#reqPrediction").val();
      
        $.ajax({
              type: "GET",
              url: "json-app/inflasi_json/kalkulasi?reqTahunAwal="+reqHistoryYearStart+"&reqTahunAkhir="+reqHistoryYearEnd,
              cache: false,
              success: function(data){
                $("#reqHistoryInflasi").val(data);
            }
         });

        $.ajax({
              type: "GET",
              url: "json-app/inflasi_json/kalkulasi?reqTahunAwal="+reqHistoryYearStart+"&reqTahunAkhir="+reqPrediction,
              cache: false,
              success: function(data){
                $("#reqAnnual").val(data);
            }
         });
    });


    function deleteData(valinfoid){

        if(valinfoid == "" )
        {
            $.messager.alert('Info', "Pilih salah satu data terlebih dahulu.", 'warning');
            return false;
        }

        var reqDistrikId= $("#reqDistrikId").val();
        var reqBlokId= $("#reqBlokId").val();
        var reqUnitMesinId= $("#reqUnitMesinId").val();

        var pesan='Apakah anda yakin untuk hapus data Project No '+valinfoid+' ?';

        $.messager.confirm('Konfirmasi',pesan,function(r){
            if (r){
                $.getJSON("json-app/lccm_json/delete?reqStatus=edit&reqId="+valinfoid,
                    function(data){
                        // $.messager.alert('Info', data.PESAN, 'info');
                        // valinfoid= "";
                        $.messager.alertLink('Info', data.PESAN, 'info', "app/index/<?=$pgreturn?>?reqDelete=1&reqStatus=edit&reqDistrikId="+reqDistrikId+"&reqBlokId="+reqBlokId+"&reqUnitMesinId="+reqUnitMesinId);
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
            infoSimpan1= data[2];

            tahun = infoSimpan1.replace(/\s/g, '');

            var reqDistrikId= $("#reqDistrikId").val();
            var reqBlokId= $("#reqBlokId").val();
            var reqUnitMesinId= $("#reqUnitMesinId").val();

            if(reqId == 'xxx')
            {
                $.messager.alert('Info', infoSimpan, 'warning');
            }
            else if(reqId == 'zzz')
            {
                mbox.custom({
                    message: infoSimpan+infoSimpan1,
                    options: {},
                    buttons: [
                        {
                            label: 'Lihat Data',
                            color: 'btn-warning',
                            callback: function() {
                                window.open('app/index/prep_monitoring?reqDistrikId='+reqDistrikId+'&reqBlokId='+reqBlokId+'&reqUnitMesinId='+reqUnitMesinId+'&reqTahun='+tahun, '_blank'); 
                            }
                        },
                        {
                            label: 'Tutup',
                            color: 'btn-danger',
                            callback: function() {
                                mbox.close();
                            }  
                        }
                    ]
                    
                })
            }
            else
            {
                 $.messager.alertLink('Info', infoSimpan, 'info', "app/index/<?=$pgreturn?>");
            }
           
        }
    });
}

 


function clearForm(){
    $('#ff').form('clear');
}   
</script>