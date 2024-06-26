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
$reqTaskDesc= $set->getField("TASK_DESC");
$reqTaskWork= $set->getField("TASK_WORK_GROUP");
$reqTaskComp= $set->getField("TASK_COMPLETION_COMMENTS");
$reqTaskStatus= $set->getField("WO_TASK_STATUS");




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
                    <label class="control-label col-md-2">Wo Num</label>
                    <div class='col-md-10'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                                <input autocomplete="off"  readonly   class="easyui-validatebox textbox form-control" type="text" name="reqWoNum"  id="reqWoNum" value="<?=$reqWoNum?>" <?=$disabled?> style="width:100%" />
                            </div>
                       </div>
                   </div>
                </div>

                <div class="form-group" id="parentname"> 
                    <label class="control-label col-md-2">Description</label>
                    <div class='col-md-10'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                                <textarea autocomplete="off"  readonly   class="easyui-validatebox textbox form-control" name="reqWoDesc"  id="reqWoDesc" ><?=$reqWoDesc?></textarea>
                            </div>
                       </div>
                   </div>
                </div>

                <div class="form-group" id="parentname"> 
                    <label class="control-label col-md-2">Task Desc</label>
                    <div class='col-md-10'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                                <textarea autocomplete="off"  readonly   class="easyui-validatebox textbox form-control" name="reqTaskDesc"  id="reqTaskDesc" ><?=$reqTaskDesc?></textarea>
                            </div>
                       </div>
                   </div>
                </div>

                <div class="form-group" id="parentname"> 
                    <label class="control-label col-md-2">Task Work Group</label>
                    <div class='col-md-10'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                                <input autocomplete="off"  readonly   class="easyui-validatebox textbox form-control" type="text" name="reqTaskWork"  id="reqTaskWork" value="<?=$reqTaskWork?>" <?=$disabled?> style="width:100%" />
                            </div>
                       </div>
                   </div>
                </div>

                <div class="form-group" id="parentname"> 
                    <label class="control-label col-md-2">Task Completion Comments</label>
                    <div class='col-md-10'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                                <input autocomplete="off"  readonly   class="easyui-validatebox textbox form-control" type="text" name="reqTaskComp"  id="reqTaskComp" value="<?=$reqTaskComp?>" <?=$disabled?> style="width:100%" />
                            </div>
                       </div>
                   </div>
                </div>


                <div class="form-group" id="parentname"> 
                    <label class="control-label col-md-2">Task Status</label>
                    <div class='col-md-10'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                                <input autocomplete="off"  readonly   class="easyui-validatebox textbox form-control" type="text" name="reqTaskStatus"  id="reqTaskStatus" value="<?=$reqTaskStatus?>" <?=$disabled?> style="width:100%" />
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