<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/LossOutput");
$this->load->model("base-app/Distrik");
$this->load->model("base-app/BlokUnit");
$this->load->model("base-app/UnitMesin");
$this->load->model("base-app/M_Group_Pm_Lccm");



$pgreturn= str_replace("_add", "", $pg);

$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$reqId = $this->input->get("reqId");
$reqTahun = $this->input->get("reqTahun");
$reqBlokId = $this->input->get("reqBlokId");
$reqDistrikId = $this->input->get("reqDistrikId");

$reqSiteId = $this->input->get("reqBlokId");
$reqStart = $this->input->get("reqStart");
$reqEnd = $this->input->get("reqEnd");





$set= new LossOutput();

if($reqId == "")
{
    $reqMode = "insert";
}
else
{
    $reqMode = "update";

    $statement = " AND A.ASSETNUM = '".$reqId."' AND A.LO_YEAR = '".$reqTahun."' AND A.START_DATE = '".$reqStart."' AND A.STOP_DATE = '".$reqEnd."'  ";
    $set->selectByParamsDetail(array(), -1, -1, $statement);
    // echo $set->query;exit;
    $set->firstRow();
    $reqId= $reqId;
    $reqAssetNum= $set->getField("ASSETNUM");
    $reqDistrikId= $set->getField("KODE_DISTRIK");
    $reqDistrikIdInfo= $set->getField("DISTRIK_ID");
    $reqBlokId= $set->getField("SITEID");
    $reqBlokIdInfo= $set->getField("BLOK_UNIT_ID");
    $reqUnitMesinId= $set->getField("KODE_UNIT_M");
    $reqTahun= $set->getField("LO_YEAR");
    $reqDuration= toThousandNew($set->getField("DURATION_HOURS"));
    $reqLossOutputCount= $set->getField("PDM_IN_YEAR");
    $reqStart= $set->getField("START_DATE");
    $reqGroupPm= $set->getField("GROUP_PM");
    $reqDescription= $set->getField("PDM_DESC");
    $reqLoadDerating= $set->getField("LOAD_DERATING");
    $reqStatus= $set->getField("STATUS");

    // var_dump($reqIsAsset);
    // $reqTahunAwalReadonly= " readonly ";


}

$disabled="";

if($reqLihat ==1)
{
    $disabled="disabled";  
}



$set= new LossOutput();
$arrstatus= [];
$statement=" AND A.STATUS IS NOT NULL AND A.STATUS <> '' ";
$set->selectByParamsStatus(array(), -1,-1,$statement);
        // echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["text"]= $set->getField("STATUS");
    array_push($arrstatus, $arrdata);
}
unset($set);






$readonly="";
if(!empty($reqId))
{
    // $readonly="readonly";

}


$readonlyfilter="";
if(empty($reqId))
{
    $readonlyfilter="readonly";

}


?>

<script src='assets/multifile-master/jquery.form.js' type="text/javascript" language="javascript"></script> 
<script src='assets/multifile-master/jquery.MetaData.js' type="text/javascript" language="javascript"></script> 
<script src='assets/multifile-master/jquery.MultiFile.js' type="text/javascript" language="javascript"></script> 
<link rel="stylesheet" href="css/gaya-multifile.css" type="text/css">

<link rel="stylesheet" href="assets/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css">
<script src="assets/moment/moment-with-locales.js"></script>
<script src="assets/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>

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

  <div class="judul-halaman"> <a href="javascript:history.back()">Data <?=$pgtitle?></a> &rsaquo; Kelola <?=$pgtitle?></div>

  <div class="konten-area">
    <div class="konten-inner">

        <div>

            <form id="ff" class="easyui-form form-horizontal" method="post" novalidate enctype="multipart/form-data">

                <div class="page-header">
                    <h3><i class="fa fa-file-text fa-lg"></i> <?=$pgtitle?></h3>       
                </div>


               
                <div class="form-group" >  
                    <label class="control-label col-md-2">Asset No</label>
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                               <input autocomplete="off"  <?=$readonly?> required  readonly class="easyui-validatebox textbox form-control" type="text" name="reqAssetNum"  id="reqAssetNum" value="<?=$reqAssetNum?>" <?=$disabled?> style="width:100%" />
                           </div>
                            <div class="col-md-1" id="">
                                <a id="btnAdd" onclick="openEquipment()"><i class="fa fa-plus-square fa-lg" aria-hidden="true"></i> </a>
                            </div>
                       </div>
                   </div>
                </div>

               
                <div class="form-group" id="parentname"> 
                    <label class="control-label col-md-2">Start Date</label>
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                                <input autocomplete="off" readonly <?=$readonly?>  required  class="easyui-validatebox textbox form-control"  type="text" name="reqStart"   onkeydown="return false"  id="reqStart" value="<?=$reqStart?>" <?=$disabled?> style="width:100%" />
                            </div>
                       </div>
                   </div>
                </div>

                <div class="form-group" id="parentname"> 
                    <label class="control-label col-md-2">End Date</label>
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                                <input autocomplete="off"  readonly <?=$readonly?> required   class="easyui-validatebox textbox form-control" type="text" name="reqEnd"  id="reqEnd" value="<?=$reqEnd?>" <?=$disabled?> style="width:100%" />
                            </div>
                       </div>
                   </div>
                </div>


                <div class="form-group" id="parentname"> 
                    <label class="control-label col-md-2">Duration (Hours)</label>
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                                <input autocomplete="off" readonly <?=$readonly?> required   class="easyui-validatebox textbox form-control" type="text" name="reqDuration"  id="reqDuration" value="<?=$reqDuration?>" <?=$disabled?> style="width:100%" />
                            </div>
                       </div>
                   </div>
                </div>

                <div class="form-group" id="parentname"> 
                    <label class="control-label col-md-2">Load Derating</label>
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                                <input autocomplete="off"  <?=$readonly?> required   class="easyui-validatebox textbox form-control" type="text" name="reqLoadDerating"  id="reqLoadDerating" value="<?=$reqLoadDerating?>" <?=$disabled?> style="width:100%" />
                            </div>
                       </div>
                   </div>
                </div>

               
                <div class="form-group" id="parentname"> 
                    <label class="control-label col-md-2">Loss Output Year</label>
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                                <input autocomplete="off" maxlength="4"  <?=$readonly?> readonly   class="easyui-validatebox textbox form-control" type="text" name="reqTahun"  id="reqTahun" value="<?=$reqTahun?>" <?=$disabled?> style="width:100%" />
                            </div>
                       </div>
                   </div>
                </div>

                 <div class="form-group" id="parentname"> 
                    <label class="control-label col-md-2">Loss Output Status</label>
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <div class='col-md-5'>
                                <div id="baru_status" style="display:none">
                                     <input type="text" style="width:225px;"  name="reqStatusBaru" maxlength="4"  placeholder=" Max 4 Character"  id="reqStatusBaru" <?=$read?> value="<?=$reqStatus?>" />
                                </div>
                                <div id="select_status" >
                                    <select class="easyui-validatebox textbox form-control"  name="reqStatus"  id="reqStatus">
                                        <option value="" >Pilih Status</option>
                                        <?
                                        foreach($arrstatus as $item) 
                                        {
                                            $selectvaltext= $item["text"];

                                            $selected="";
                                            if($selectvaltext == $reqStatus)
                                            {
                                                $selected="selected";
                                            }
                                            ?>
                                            <option value="<?=$selectvaltext?>" <?=$selected?>><?=$selectvaltext?></option>
                                            <?
                                        }
                                        ?>
                                    </select>

                                </div>
                            </div>
                            <div class="col-md-1" id="select_button">
                                <img src="images/add.png" style="cursor:pointer" title="Tambah Data" id="image_add" height="15" width="15" onclick="ShowHiddenId('baru')">
                                <img src="images/button_cancel.png" style="cursor:pointer;display:none"   id="image_cancel" onclick="ShowHiddenId('')">
                            </div>
                       </div>
                   </div>
                </div>

             
               
       <input type="hidden" name="reqId" value="<?=$reqId?>" />
       <input type="hidden" name="reqMode" value="<?=$reqMode?>" />
       <input type="hidden" name="reqSiteId" value="<?=$reqSiteId?>" />
       <input type="hidden" name="reqAssetNumOld" value="<?=$reqAssetNum?>" />
       <input type="hidden" name="reqStartOld" value="<?=$reqStart?>" />
       <input type="hidden" name="reqEndOld" value="<?=$reqEnd?>" />


        <?
        if($reqLihat ==1)
        {}
        else
        {
            ?>
            <div style="text-align:center;padding:5px">
                <a href="javascript:void(0)" class="btn btn-primary" onclick="submitForm()">Simpan</a>

            </div>
            <?
        }
        ?>

   </form>

</div>


</div>
</div>

</div>

<script>

    function ShowHiddenId(status){
        if(status=='baru'){
            document.getElementById('baru_status').style.display = '';
            document.getElementById('image_cancel').style.display = '';
            document.getElementById('select_status').style.display = 'none';
            document.getElementById('image_add').style.display = 'none';
            $('#reqStatusBaru').val('');
            $('#reqStatus').val('');
        }else{
            document.getElementById('baru_status').style.display = 'none';
            document.getElementById('image_cancel').style.display = 'none';
            document.getElementById('select_status').style.display = '';
            document.getElementById('image_add').style.display = '';

        }
        // document.getElementById('reqStatusPejabatPenetap').value = status;
    }

    function openEquipment()
    {
        openAdd('iframe/index/lookup_equipment');
    }

    function setEquipment(values)
    {
        $('#reqAssetNum').val(values.ASSETNUM);

    }
    $(function() {
      var bindDatePicker = function() {
        $("#reqStart,#reqEnd").datetimepicker({
            language: 'id',
            locale: 'id',
            format: 'YYYY-MM-DD HH:mm',
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down"
            }

        }).find('input:first').on("blur", function() {
          var date = parseDate($(this).val());

          if (!isValidDate(date)) {
            date = moment().format('YYYY-MM-DD HH:mm');
          }

          $(this).val(date);
        });
      }

      var isValidDate = function(value, format) {
        format = format || false;
        if (format) {
          value = parseDate(value);
        }

        var timestamp = Date.parse(value);

        return isNaN(timestamp) == false;
      }

      var parseDate = function(value) {
        var m = value.match(/^(\d{1,2})(\/|-)?(\d{1,2})(\/|-)?(\d{4})$/);
        if (m)
          value = m[5] + '-' + ("00" + m[3]).slice(-2) + '-' + ("00" + m[1]).slice(-2);

        return value;
      }

      bindDatePicker();

     

    });

    function updateDuration(startTime, endTime) {
        var ms = moment(endTime, 'YYYY/MM/DD HH:mm:ss').diff(moment(startTime, 'YYYY/MM/DD HH:mm:ss')),
            dt = moment.duration(ms),
            h = Math.floor(dt.asHours()),
            m = moment.utc(ms).format('mm');
            $('#reqDuration').val(h + ',' + m );
    }

    $('#reqEnd').on('change', function () {
        if($('#reqStart').val())
        {
             updateDuration($('#reqStart').val(), $('#reqEnd').val());
        }
        else
        {
            alert('Isi Start date terlebih dahulu');return false;
        }
       
    });


    $('#reqTahun,#reqLoadDerating,#reqDuration').on('input blur paste', function(){
        var numeric = $(this).val().replace(/\D/g, '');
        $(this).val(numeric);
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
            console.log(data);
            $("#reqUnitMesinId option").remove();
            $("#reqUnitMesinId").attr("readonly", false); 
            jQuery(data).each(function(i, item){
                $("#reqUnitMesinId").append('<option value="'+item.KODE+'" >'+item.text+'</option>');
            });
        });
    
    });


    function submitForm(){


        $('#ff').form('submit',{
            url:'json-app/loss_output_json/add',
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
                    $.messager.alertLink('Info', infoSimpan, 'info', "app/index/<?=$pgreturn?>?reqTahun=<?=$reqTahun?>");
            }
        });
       
        
    }

    function clearForm(){
        $('#ff').form('clear');
    }   
</script>