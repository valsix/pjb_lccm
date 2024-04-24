<?
    $this->load->model("base-app/T_Lccm_Prj");
    $reqDistrikId = $this->input->get("reqDistrikId");
    $reqBlokId = $this->input->get("reqBlokId");
    $reqUnitMesinId = $this->input->get("reqUnitMesinId");
    $reqId = $this->input->get("reqId");




    $set= new T_Lccm_Prj();
    $arrprojectno= [];
    $statement=" AND A.KODE_DISTRIK = '".$reqDistrikId."' AND A.KODE_BLOK = '".$reqBlokId."' AND A.KODE_UNIT_M = '".$reqUnitMesinId."'  ";

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



?>

    <div class="form-group" >  
        <label class="control-label col-md-2">History Year </label>
        <div class='col-md-4'>
            <div class='form-group'>
                <div class='col-md-6'>
                   <input  maxlength="4" <?=$readonly?>  class="easyui-validatebox textbox form-control" required readonly  type="text" name="reqHistoryYearStart"  id="reqHistoryYearStart" value="<?=$reqHistoryYearStart?>" <?=$disabled?> style="width:50%" />
               </div>
               <div class='col-md-6'>
                   <input  maxlength="4" <?=$readonly?>  class="easyui-validatebox textbox form-control" required  readonly type="text" name="reqHistoryYearEnd"  id="reqHistoryYearEnd" value="<?=$reqHistoryYearEnd?>" <?=$disabled?> style="width:50%" />
               </div>
           </div>
       </div>
    </div>


    <div class="form-group" >  
        <label class="control-label col-md-2">Prediction Year </label>
        <div class='col-md-4'>
            <div class='form-group'>
                <div class='col-md-6'>
                   <input  maxlength="4" <?=$readonly?>  class="easyui-validatebox textbox form-control" required readonly  type="text" name="reqPrediction"  id="reqPrediction" value="<?=$reqPrediction?>" <?=$disabled?> style="width:50%" />
               </div>
           </div>
       </div>
   </div>

    <div class="form-group" >  
        <label class="control-label col-md-2">Discount Rate </label>
        <div class='col-md-4'>
            <div class='form-group'>
                <div class='col-md-4'>
                   <input  maxlength="4" <?=$readonly?>  class="easyui-validatebox textbox form-control" required readonly  type="text" name="reqDiscount"  id="reqDiscount" value="<?=$reqDiscount?>" <?=$disabled?> style="width:50%" />
               </div>
           </div>
       </div>
    </div>

    <div class="form-group" >  
        <label class="control-label col-md-2">Plant Capital Cost </label>
        <div class='col-md-4'>
            <div class='form-group'>
                <div class='col-md-11'>
                   <input   <?=$readonly?>  class="easyui-validatebox textbox form-control" required readonly  type="text" name="reqPlant"  id="reqPlant" value="<?=$reqPlant?>" <?=$disabled?> style="width:50%" />
               </div>
           </div>
       </div>
   </div>



    <div class="form-group" >  
        <label class="control-label col-md-2">Project No </label>
        <div class='col-md-4'>
            <div class='form-group'>
                <div class='col-md-6'>
                    <select class="form-control jscaribasicmultiple"  <?=$readonly?> <?=$readonlyfilter?> class="prono"    id="reqProjectNoSelect" <?=$disabled?> name="reqProjectNo"  style="width:100%;" >
                        <option value="" >Pilih Project No</option>
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


                </div>
            </div>
        </div>
    </div>

    <div class="form-group" >  
        <label class="control-label col-md-2">Project Desc </label>
        <div class='col-md-4'>
            <div class='form-group'>
                <div class='col-md-11'>
                   <input   <?=$readonly?>  class="easyui-validatebox textbox form-control" required readonly    type="text" name="reqProjectDesc"  id="reqProjectDesc" value="<?=$reqProjectDesc?>" <?=$disabled?> style="width:50%" />
               </div>
           </div>
       </div>
   </div>



<script type="text/javascript">
      $('#reqProjectNoSelect').on('change', function() {
        var reqId= this.value;
        window.location.href = "app/index/lccm?reqStatus=edit&reqId="+reqId;

    });
</script>    
<?



?>
