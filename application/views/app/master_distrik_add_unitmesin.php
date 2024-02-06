<?
$reqUniqId= $this->input->get("reqUniqId");
$reqUniqMesinId= $this->input->get("reqUniqMesinId");
$infokey= $reqUniqId."-".$reqUniqMesinId;

$this->load->model("base-app/Eam");


$set= new Eam();
$arrjenis= [];
$set->selectByParams(array(), -1,-1," AND A.STATUS IS NULL");
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("EAM_ID");
    $arrdata["text"]= $set->getField("NAMA");
    array_push($arrjenis, $arrdata);
}
unset($set);

?>
<div class="form-group infogroupunitmesin<?=$infokey?>"> 
    <label class="control-label col-md-4">
        Kode Unit Mesin
    </label>
    <div class='col-md-6'>
        <div class='form-group'>

            <div class='col-md-11'>
                <input autocomplete="off" class="easyui-validatebox textbox form-control itemblokunit" type="text" name="reqKodeDinamis[]" id="reqKodeDinamis" data-options="required:true" style="width:100%" />
            </div>
        </div>
    </div>
   
    <label class="control-label col-md-4">
        Kode Eam Unit Mesin
    </label>
    <div class='col-md-6'>
        <div class='form-group'>
            <div class='col-md-11'>
                <input autocomplete="off" class="easyui-validatebox textbox form-control " type="text" name="reqKodeEam[]" style="width:100%" />
            </div>
        </div>
    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
  
    <label class="control-label col-md-4">Nama Unit Mesin</label>
    <div class='col-md-6'>
        <div class='form-group'>
            <div class='col-md-11'>
            	<input autocomplete="off" class="easyui-validatebox textbox form-control itemblokunit" type="text" name="reqNamaDinamis[]" data-options="required:true" style="width:100%" />
            	<input type="hidden" name="reqUnitKe[]" value="<?="unitke".$reqUniqId?>" />
            	<input type="hidden" name="reqModeDinamis[]" value="unitmesin" />
            	
            </div>
        </div>
    </div>

    <div class="form-group" >  
            <label class="control-label col-md-4">Jenis Eam</label>
            <div class='col-md-8'>
                <div class='form-group'>
                    <div class='col-md-11'>
                        <select class="form-control jscaribasicmultiple edittext" id="reqJenisUnitKerjaId" <?=$disabled?> name="reqJenisUnitKerjaId[]" style="width:100%;"  >
                            <option value="" >Pilih Jenis Eam</option>
                            <?
                            foreach($arrjenis as $item) 
                            {
                                $selectvalid= $item["id"];
                                $selectvaltext= $item["text"];

                                $selected="";
                                if(in_array($selectvalid, $reqJenisUnitKerjaId))
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
        </div>

        <label class="control-label col-md-4">
            Url
        </label>
        <div class='col-md-8'>
            <div class='form-group'>
                <div class='col-md-11'>
                    <input autocomplete="off" class="easyui-validatebox textbox form-control " type="text" name="reqUrlDinamis[]"  style="width:100%" />
                    <br>
                    <a href="javascript:void(0)" class="btn btn-danger btn-remove" onclick="unitmesinhapus('<?=$infokey?>')">Hapus</a>
               </div>
           </div>
        </div>

        <script type="text/javascript">

            $(document).on('keydown', '#reqKodeDinamis', function(e) {
                if (e.keyCode == 32) return false;
            });

        </script>
</div>