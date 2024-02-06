<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/Operation");

$pgreturn= str_replace("_add", "", $pg);

$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$reqTahun= $this->input->get("reqTahun");
$reqAssetNum= $this->input->get("reqAssetNum");


$set= new Operation();
$statement = " AND A.OPR_YEAR = ".$reqTahun." AND A.ASSETNUM = '".$reqAssetNum."'";
$set->selectByParamsDetailNew(array(), -1, -1, $statement);
// echo $set->query;exit;
$set->firstRow();
$reqId= $set->getField("OPR_YEAR");
$reqEmploySalary= $set->getField("EMPLOY_SALARY_ASSET");
$reqAssetNum= $set->getField("ASSETNUM");
$reqAssetName= $set->getField("ASSET_DESC");
$reqElecCostH= $set->getField("ELECT_LOSS");
$reqElecCost= $set->getField("COST_OF_ELECT_LOSS");
$reqEfficencyLoss= $set->getField("EFF_LOSS");
$reqEfficencyCost= $set->getField("COST_OF_EFF_LOSS");
$reqOperationCost= $set->getField("OPERATION_COST");





$reqMode= "insert";
if(!empty($reqId))
    $reqMode= "update";

$disabled="";

if($reqLihat ==1)
{
    $disabled="disabled";  
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
                        <label class="control-label col-md-3">Asset No</label>
                        <div class='col-md-4'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <input autocomplete="off" <?=$readonly?> readonly class="easyui-validatebox textbox form-control" type="text" name="reqAssetNum" id="reqAssetNum" value="<?=$reqAssetNum?>"  />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" >  
                        <label class="control-label col-md-3">Asset Name</label>
                        <div class='col-md-4'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <input autocomplete="off" <?=$readonly?> readonly class="easyui-validatebox textbox form-control" type="text" name="reqAssetName" id="reqAssetName" value="<?=$reqAssetName?>"  />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" >  
                        <label class="control-label col-md-3">Employ Salary</label>
                        <div class='col-md-4'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <input autocomplete="off" <?=$readonly?> readonly class="easyui-validatebox textbox form-control" type="text" name="reqEmploySalary" id="reqEmploySalary" value="<?=toThousandComma($reqEmploySalary)?>"  />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" >  
                        <label class="control-label col-md-3">Electricity Loss per Hour (kWh)</label>
                        <div class='col-md-4'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <input autocomplete="off" <?=$readonly?> required class="easyui-validatebox textbox form-control vangkaglobal" type="text" name="reqElecCostH" id="reqElecCostH" value="<?=$reqElecCostH?>"  />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" >  
                        <label class="control-label col-md-3">Electricity Cost</label>
                        <div class='col-md-4'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <input autocomplete="off" <?=$readonly?> readonly class="easyui-validatebox textbox form-control" type="text" name="reqElecCost" id="reqElecCost" value="<?=toThousandComma($reqElecCost)?>"  />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" >  
                        <label class="control-label col-md-3">Effisiency Loss (kCal/kWh)</label>
                        <div class='col-md-4'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <input autocomplete="off" <?=$readonly?> required  class="easyui-validatebox textbox form-control vangkaglobal" type="text" name="reqEfficencyLoss" id="reqEfficencyLoss" value="<?=$reqEfficencyLoss?>"  />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" >  
                        <label class="control-label col-md-3">Effisiency Cost</label>
                        <div class='col-md-4'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <input autocomplete="off" <?=$readonly?> readonly class="easyui-validatebox textbox form-control" type="text" name="reqEfficencyCost" id="reqEfficencyCost" value="<?=toThousandComma($reqEfficencyCost)?>"  />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" >  
                        <label class="control-label col-md-3">Operation Cost</label>
                        <div class='col-md-4'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <input autocomplete="off" <?=$readonly?> readonly class="easyui-validatebox textbox form-control" type="text" name="reqOperationCost" id="reqOperationCost" value="<?=toThousandComma($reqOperationCost)?>"  />
                                </div>
                            </div>
                        </div>
                    </div>
                   
                    <input type="hidden" name="reqId" value="<?=$reqId?>" />
                    <input type="hidden" name="reqMode" value="<?=$reqMode?>" />
                    <input type="hidden" name="reqTahun" value="<?=$reqTahun?>" />
                    
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
    // $('.vangkaglobal').bind('keyup paste', function(){
    //     this.value = this.value.replace(/[^0-9\,]/g, '');
    // });

    $(document).on("input", ".vangkaglobal", function() {
        this.value = this.value.replace(/\D/g,'');
    });

    $('#reqElecCostH').on('input',function(e){
        var reqEfficencyLoss= $("#reqEfficencyLoss").val();
        $.getJSON("json-app/operation_json/hitung?reqTahun=<?=$reqTahun?>&reqElecCostH="+this.value+"&reqEfficencyLoss="+reqEfficencyLoss,
        function(data){
            
            var reqEffCost=parseFloat(data.reqEffCost);
            var reqElecLoss=parseFloat(data.reqElecLoss);
            var reqOperationCost=parseFloat(data.reqOperationCost);
            // console.log(data.reqEffCost);
            // console.log(FormatCurrencyBaru(reqEffCost));
            $("#reqEfficencyCost").val(reqEffCost);
            $("#reqElecCost").val(reqElecLoss);
            $("#reqOperationCost").val(reqOperationCost);
           
        });
   });

    $('#reqEfficencyLoss').on('input',function(e){
        var reqElecCostH= $("#reqElecCostH").val();
        $.getJSON("json-app/operation_json/hitung?reqTahun=<?=$reqTahun?>&reqEfficencyLoss="+this.value+"&reqElecCostH="+reqElecCostH,
        function(data){
            // console.log(data.reqEffCost);
            var reqEffCost=parseFloat(data.reqEffCost);
            var reqElecLoss=parseFloat(data.reqElecLoss);
            var reqOperationCost=parseFloat(data.reqOperationCost);
            $("#reqEfficencyCost").val(reqEffCost);
            $("#reqElecCost").val(reqElecLoss);
            $("#reqOperationCost").val(reqOperationCost);
           
        });
   });

    function submitForm(){

        $('#ff').form('submit',{
            url:'json-app/operation_json/addasset',
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