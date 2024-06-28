<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/WorkOrder");


$pgreturn= str_replace("_add", "", $pg);

$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$reqWoNum = $this->input->get("reqWoNum");


$set= new WorkOrder();


$statement = "  AND A.WONUM = '".$reqWoNum."' ";
$set->selectByParamsDetail(array(), -1, -1, $statement);
    // echo $set->query;exit;
$set->firstRow();
$reqWoNum= $set->getField("WONUM");
$reqWoDesc= $set->getField("WO_DESC");
$reqTaskStatus= $set->getField("WO_TASK_STATUS");
$reqLongDesc= $set->getField("LONG_DESCRIPTION");
$reqWorkLog= $set->getField("WORKLOG");
$reqCompletion= $set->getField("WO_COMPLT_COMMENT");
$reqTaskDesc= $set->getField("TASK_DESC");
$reqTaskComp= $set->getField("TASK_COMPLETION_COMMENTS");
$reqWoGroup= $set->getField("WORK_GROUP");
$reqTaskWoGroup= $set->getField("TASK_WORK_GROUP");
$reqReportDate= $set->getField("REPORTDATE");
$reqActStart= $set->getField("ACTSTART");
$reqActFinish= $set->getField("ACTFINISH");
$reqServiceCost= $set->getField("SERV_COST");
$reqMaterialCost= $set->getField("MAT_COST");
$reqTotalCost= $set->getField("TOTAL_COST");







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

  <div class="judul-halaman" style="border-bottom : 0px"> </div>

  <div class="konten-area">
    <div class="konten-inner">

        <div>

            <form id="ff" class="easyui-form form-horizontal" method="post" novalidate enctype="multipart/form-data">

                <div class="page-header">
                    <h3><i class="fa fa-file-text fa-lg"></i> <?=$pgtitle?></h3>       
                </div>

             
                <div class="form-group" id="parentname"> 
                    <label class="control-label col-md-2">WO Num</label>
                    <div class='col-md-2'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                                <input autocomplete="off"  readonly   class="easyui-validatebox textbox form-control" type="text" name="reqWoNum"  id="reqWoNum" value="<?=$reqWoNum?>" <?=$disabled?> style="width:100%" />
                            </div>
                       </div>
                   </div>
                </div>

                <div class="form-group" id="parentname"> 
                    <label class="control-label col-md-2">WO Description</label>
                    <div class='col-md-10'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                                <textarea autocomplete="off"  readonly   class="easyui-validatebox textbox form-control" name="reqWoDesc"  id="reqWoDesc" ><?=$reqWoDesc?></textarea>
                            </div>
                       </div>
                   </div>
                </div>

                <div class="form-group" id="parentname"> 
                    <label class="control-label col-md-2">Long Description</label>
                    <div class='col-md-10'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                                <textarea autocomplete="off"  readonly   class="easyui-validatebox textbox form-control" name="reqLongDesc"  id="reqLongDesc" ><?=$reqLongDesc?></textarea>
                            </div>
                       </div>
                   </div>
                </div>

                <div class="form-group" id="parentname"> 
                    <label class="control-label col-md-2">Work log</label>
                    <div class='col-md-10'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                                <textarea autocomplete="off"  readonly   class="easyui-validatebox textbox form-control" name="reqWorkLog"  id="reqWorkLog" ><?=$reqWorkLog?></textarea>
                            </div>
                       </div>
                   </div>
                </div>

                <div class="form-group" id="parentname"> 
                    <label class="control-label col-md-2">Completion Comment</label>
                    <div class='col-md-10'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                                <textarea autocomplete="off"  readonly   class="easyui-validatebox textbox form-control" name="reqCompletion"  id="reqCompletion" ><?=$reqCompletion?></textarea>
                            </div>
                       </div>
                   </div>
                </div>

                <div class="form-group" id="parentname"> 
                    <label class="control-label col-md-2">Task Description</label>
                    <div class='col-md-10'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                                <textarea autocomplete="off"  readonly   class="easyui-validatebox textbox form-control" name="reqTaskDesc"  id="reqTaskDesc" ><?=$reqTaskDesc?></textarea>
                            </div>
                       </div>
                   </div>
                </div>

               
                <div class="form-group" id="parentname"> 
                    <label class="control-label col-md-2">Task Completion Comments</label>
                    <div class='col-md-10'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                                <textarea autocomplete="off"  readonly   class="easyui-validatebox textbox form-control" name="reqTaskComp"  id="reqTaskComp" ><?=$reqTaskComp?></textarea>
                            </div>
                       </div>
                   </div>
                </div>


                <div class="form-group" id="parentname"> 
                    <label class="control-label col-md-2">WO Group</label>
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                                <input autocomplete="off"  readonly   class="easyui-validatebox textbox form-control" type="text" name="reqWoGroup"  id="reqWoGroup" value="<?=$reqWoGroup?>" <?=$disabled?> style="width:100%" />
                            </div>
                       </div>
                   </div>
                </div>

                <div class="form-group" id="parentname"> 
                    <label class="control-label col-md-2">Task WO Group</label>
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                                <input autocomplete="off"  readonly   class="easyui-validatebox textbox form-control" type="text" name="reqTaskWoGroup"  id="reqTaskWoGroup" value="<?=$reqTaskWoGroup?>" <?=$disabled?> style="width:100%" />
                            </div>
                       </div>
                   </div>
                </div>

                <div class="form-group" id="parentname"> 
                    <label class="control-label col-md-2">Report Date</label>
                    <div class='col-md-2'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                                <input autocomplete="off"  readonly   class="easyui-validatebox textbox form-control" type="text" name="reqReportDate"  id="reqReportDate" value="<?=$reqReportDate?>" <?=$disabled?> style="width:100%" />
                            </div>
                       </div>
                   </div>
                </div>

                <div class="form-group" id="parentname"> 
                    <label class="control-label col-md-2">ActStart</label>
                    <div class='col-md-2'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                                <input autocomplete="off"  readonly   class="easyui-validatebox textbox form-control" type="text" name="reqActStart"  id="reqActStart" value="<?=$reqActStart?>" <?=$disabled?> style="width:100%" />
                            </div>
                       </div>
                   </div>
                </div>

                <div class="form-group" id="parentname"> 
                    <label class="control-label col-md-2">ActFinish</label>
                    <div class='col-md-2'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                                <input autocomplete="off"  readonly   class="easyui-validatebox textbox form-control" type="text" name="reqActFinish"  id="reqActFinish" value="<?=$reqActFinish?>" <?=$disabled?> style="width:100%" />
                            </div>
                       </div>
                   </div>
                </div>

                <div class="form-group" id="parentname"> 
                    <label class="control-label col-md-2">Service Cost</label>
                    <div class='col-md-1'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                                <input autocomplete="off"  readonly   class="easyui-validatebox textbox form-control" type="text" name="reqServiceCost"  id="reqServiceCost" value="<?=$reqServiceCost?>" <?=$disabled?> style="width:100%" />
                            </div>
                       </div>
                   </div>
                </div>

                <div class="form-group" id="parentname"> 
                    <label class="control-label col-md-2">Material Cost</label>
                    <div class='col-md-1'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                                <input autocomplete="off"  readonly   class="easyui-validatebox textbox form-control" type="text" name="reqMaterialCost"  id="reqMaterialCost" value="<?=$reqMaterialCost?>" <?=$disabled?> style="width:100%" />
                            </div>
                       </div>
                   </div>
                </div>

                <div class="form-group" id="parentname"> 
                    <label class="control-label col-md-2">Total Cost</label>
                    <div class='col-md-1'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                                <input autocomplete="off"  readonly   class="easyui-validatebox textbox form-control" type="text" name="reqTotalCost"  id="reqTotalCost" value="<?=$reqTotalCost?>" <?=$disabled?> style="width:100%" />
                            </div>
                       </div>
                   </div>
                </div>




   </form>

</div>


</div>
</div>

</div>

<script>

   
</script>