<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/WoStanding");
$this->load->model("base-app/Distrik");
$this->load->model("base-app/BlokUnit");
$this->load->model("base-app/M_Group_Pm_Lccm");
$this->load->model("base-app/UnitMesin");



$pgreturn= str_replace("_add", "", $pg);

$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$reqSiteId = $this->input->get("reqSiteId");
$reqLihat = $this->input->get("reqLihat");
$reqBlokId = $this->input->get("reqBlokId");
$reqParent = $this->input->get("reqParent");
$reqDistrikId = $this->input->get("reqDistrikId");
$reqGroupPm = $this->input->get("reqGroupPm");
$reqMode = $this->input->get("reqMode");
$reqTahun = $this->input->get("reqTahun");
$reqUnitMesinId = $this->input->get("reqUnitMesinId");

$readonlyent="";
$readonlyu="readonly";
if(empty($reqBlokId))
{
    $reqBlokId=$this->appblokunitkode;
    if(!empty($reqBlokId))
    {
      $readonlyent="readonly";
      $readonlyu="";
    }
}

if(empty($reqDistrikId))
{
    $reqDistrikId=$this->appdistrikkode;
    if(!empty($reqBlokId))
    {
      $readonlyent="readonly";
      $readonlyu="";  
    }
}

$set= new WoStanding();

if($reqMode == "insert")
{
    $reqMode = "insert";
}
else
{
    $reqMode = "update";

    if($reqParent=="parent")
    {
        $statement = " AND A.KODE_BLOK = '".$reqSiteId."' ";
    }
    else if ($reqParent =="group") 
    {
        $statement = " AND A.KODE_BLOK = '".$reqSiteId."' AND A.KODE_DISTRIK = '".$reqDistrikId."'";
    }
     else if ($reqParent =="tahun") 
    {
        $statement = " AND A.KODE_BLOK = '".$reqSiteId."' AND A.KODE_DISTRIK = '".$reqDistrikId."' AND A.GROUP_PM = '".$reqGroupPm."' AND A.PM_YEAR = '".$reqTahun."'";
    }


    $set->selectByParamsEdit(array(), -1, -1, $statement);
    // echo $set->query;exit;
    $set->firstRow();
    $reqSiteId= $set->getField("KODE_BLOK");
    $reqTahun= $set->getField("PM_YEAR");
    $reqDistrikId= $set->getField("KODE_DISTRIK");
    $reqBlokId= $set->getField("KODE_BLOK");
    $reqUnitMesinId= $set->getField("KODE_UNIT_M");
    $reqCost= toThousandComma($set->getField("COST_PM_YEARLY"));
    $reqGroupPm= $set->getField("GROUP_PM");
    // print_r($reqDistrikId);exit;
    // $reqTahunAwalReadonly= " readonly ";



}


if(empty($reqBlokId))
{
    $reqBlokId=$reqSiteId;
}


$disabled="";

if($reqLihat ==1)
{
    $disabled="disabled";  
}


$set= new Distrik();
$arrdistrik= [];
$statement="  ";

if(!empty($reqDistrikId))
{
    $statement = " AND A.KODE = '".$reqDistrikId."'";
}

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

if(empty($reqSiteId))
{
    if(empty($reqParent))
    {
        $statement=" AND 1=2 ";
    }
    else
    {
         $statement=" AND A.KODE <> '' ";
    }
    
}
else
{

    if(!empty($reqBlokId))
    {
        $statement = " AND A.KODE = '".$reqBlokId."'";
    }
    else
    {
        $statement="  AND A.KODE <> '' ";
    }
}

if($reqMode=="update")
{

    if($reqParent=="parent")
    {
       $statement=" AND B.KODE= '".$reqDistrikId."'  ";
    }
    else
    {
        $statement="  AND B.KODE= '".$reqDistrikId."'  ";
    }

}
else
{
    $statement=" AND A.KODE= '".$reqBlokId."' AND B.KODE= '".$reqDistrikId."'  ";
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




$readonly="";
if(!empty($reqSiteId))
{
    $readonly="readonly";

}


$readonlyfilter="";
if(empty($reqSiteId))
{
    $readonlyfilter="readonly";

}


$set= new M_Group_Pm_Lccm();
$arrgroup= [];
$statement="";
if($reqParent=="group")
{
   $statement=" AND A.KODE_BLOK= '".$reqSiteId."' AND A.KODE_DISTRIK= '".$reqDistrikId."'  ";
}
if($reqParent=="utama")
{
   $statement=" AND A.KODE_BLOK= '".$reqSiteId."' AND A.KODE_DISTRIK= '".$reqDistrikId."'  ";
}
if($reqParent=="parent")
{
   $statement=" AND A.KODE_BLOK= '".$reqSiteId."' AND A.KODE_DISTRIK= '".$reqDistrikId."'  ";
}



$set->selectByParams(array(), -1,-1,$statement);
        // echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["text"]= $set->getField("GROUP_PM");
    array_push($arrgroup, $arrdata);
}
unset($set);


$set= new UnitMesin();
$arrunitmesin= [];
$statement="";
if(empty($reqUnitMesinId))
{
    if(empty($reqParent))
    {
        $statement=" AND 1=2 ";
    }
    else
    {
         $statement=" AND A.KODE <> '' ";
    }
    
}
else
{
    $statement="  AND A.KODE <> '' ";
}

if($reqMode=="update")
{

    $statement=" AND B.KODE= '".$reqDistrikId."' AND C.KODE= '".$reqSiteId."' AND A.KODE= '".$reqUnitMesinId."'  ";

}
else
{
    $statement="  AND B.KODE= '".$reqDistrikId."' AND C.KODE= '".$reqBlokId."'    ";
}

$arrunitmesin= [];
$set->selectByParams(array(), -1,-1,$statement);
    // echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("UNIT_MESIN_ID");
    $arrdata["text"]= $set->getField("NAMA");
    $arrdata["KODE"]= $set->getField("KODE");
    array_push($arrunitmesin, $arrdata);
}
unset($set);



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

            <form id="ff" class="easyui-form form-horizontal" method="post" novalidate enctype="multipart/form-data">

                <div class="page-header">
                    <h3><i class="fa fa-file-text fa-lg"></i> <?=$pgtitle?></h3>       
                </div>

                <?
                if($reqParent=="utama")
                {

                ?>
                 <div class="form-group">  
                        <label class="control-label col-md-2">Distrik </label>
                        <div class='col-md-6'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <select class="form-control jscaribasicmultiple"  <?=$readonlyent?>  required id="reqDistrikId" <?=$disabled?> name="reqDistrikId"  style="width:100%;" >
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
                                </div>
                            </div>
                        </div>
                    </div>

                <div class="form-group">  
                    <label class="control-label col-md-2">Blok </label>
                    <div class='col-md-6'>
                        <div class='form-group'>
                            <div class='col-md-11' id="blok">
                                <select class="form-control jscaribasicmultiple"  <?=$readonlyfilter?> <?=$readonly?>    id="reqBlokId"   name="reqBlokId"  style="width:100%;"  >
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
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">Unit Mesin </label>
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <div class='col-md-11'  id="unit">
                                <select class="form-control jscaribasicmultiple" <?=$readonlyu?> id="reqUnitMesinId" <?=$disabled?> name="reqUnitMesinId"  style="width:100%;" >
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
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group" >  
                        <label class="control-label col-md-2">Group Pm </label>
                        <div class='col-md-4'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <select class="form-control jscaribasicmultiple" readonly   id="reqGroupPm"   name="reqGroupPm"  style="width:100%;"  >
                                        <option value="" >Pilih Group Pm</option>
                                        <?
                                        foreach($arrgroup as $item) 
                                        {
                                            $selectvalid= $item["id"];
                                            $selectvaltext= $item["text"];
                                            $selectvalkode= $item["KODE"];
                                            $selected="";
                                            if($selectvaltext==$reqGroupPm)
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
                       </div>
                </div>

                <div class="form-group" >  
                        <label class="control-label col-md-2">Tahun </label>
                        <div class='col-md-4'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                 <input autocomplete="off" maxlength="4"  class="easyui-validatebox textbox form-control"  required type="text" name="reqTahun"  id="reqTahun" value="<?=$reqTahun?>" style="width:50%" />
                                </div>
                            </div>
                        </div>
                 </div>

                 <div class="form-group" >  
                        <label class="control-label col-md-2">Cost Pm Yearly </label>
                        <div class='col-md-4'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                 <input autocomplete="off"  class="easyui-validatebox textbox form-control" required type="text" name="reqCost"  id="reqCost" value="<?=$reqCost?>"  style="width:50%" />
                                </div>
                            </div>
                        </div>
                 </div>
                <?
                }
                else if($reqParent=="parent")
                {
                    if($reqMode=="update")
                    {

                        $readonlyg="";
                    }
                    else
                    {
                         $readonlyg="readonly";
                    }
                ?>
                <div class="form-group">  
                        <label class="control-label col-md-2">Distrik </label>
                        <div class='col-md-6'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <select class="form-control jscaribasicmultiple"   readonly id="reqDistrikId" <?=$disabled?> name="reqDistrikId"  style="width:100%;" >
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
                                </div>
                            </div>
                        </div>
                    </div>

                <div class="form-group">  
                    <label class="control-label col-md-2">Blok </label>
                    <div class='col-md-6'>
                        <div class='form-group'>
                            <div class='col-md-11' id="blok">
                                <select class="form-control jscaribasicmultiple"  <?=$readonlyg?>    id="reqBlokId"   name="reqBlokId"  style="width:100%;"  >
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
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">Unit Mesin </label>
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <div class='col-md-11'  id="unit">
                                <select class="form-control jscaribasicmultiple" <?=$readonlyg?>  id="reqUnitMesinId" <?=$disabled?> name="reqUnitMesinId"  style="width:100%;" >
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
                            </div>
                        </div>
                    </div>
                </div>

                

                    <?
                    if($reqMode=="insert")
                    {

                        $readonly="";
                    ?>

                        <div class="form-group" >  
                            <label class="control-label col-md-2">Group Pm </label>
                            <div class='col-md-4'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                        <select class="form-control jscaribasicmultiple" readonly  id="reqGroupPm"   name="reqGroupPm"  style="width:100%;"  >
                                            <option value="" >Pilih Group Pm</option>
                                            <?
                                            foreach($arrgroup as $item) 
                                            {
                                                $selectvalid= $item["id"];
                                                $selectvaltext= $item["text"];
                                                $selectvalkode= $item["KODE"];
                                                $selected="";
                                                if($selectvaltext==$reqGroupPm)
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
                            </div>
                        </div>

                        <div class="form-group" >  
                                <label class="control-label col-md-2">Tahun </label>
                                <div class='col-md-4'>
                                    <div class='form-group'>
                                        <div class='col-md-11'>
                                         <input autocomplete="off" maxlength="4" class="easyui-validatebox textbox form-control" required  type="text" name="reqTahun"  id="reqTahun" value="<?=$reqTahun?>" <?=$disabled?> style="width:50%" />
                                        </div>
                                    </div>
                                </div>
                         </div>

                         <div class="form-group" >  
                                <label class="control-label col-md-2">Cost Pm Yearly </label>
                                <div class='col-md-4'>
                                    <div class='form-group'>
                                        <div class='col-md-11'>
                                         <input autocomplete="off"  class="easyui-validatebox textbox form-control" type="text" required name="reqCost"  id="reqCost" value="<?=$reqCost?>" <?=$disabled?> style="width:50%" />
                                        </div>
                                    </div>
                                </div>
                         </div>
                    <?
                    }
                    ?>
                <?
                }
                else if($reqParent=="group")
                {

                     if($reqMode=="update")
                    {

                        $readonlyg="";
                    }
                    else
                    {
                         $readonlyg="readonly";
                    }

                ?>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Distrik </label>
                        <div class='col-md-6'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <select class="form-control jscaribasicmultiple"  <?=$readonly?> required id="reqDistrikId" <?=$disabled?> name="reqDistrikId"  style="width:100%;" >
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
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Blok </label>
                        <div class='col-md-6'>
                            <div class='form-group'>
                                <div class='col-md-11' id="blok">
                                    <select class="form-control jscaribasicmultiple"   <?=$readonlyg?>   id="reqBlokId"   name="reqBlokId"  style="width:100%;"  >
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
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2">Unit Mesin </label>
                        <div class='col-md-4'>
                            <div class='form-group'>
                                <div class='col-md-11'  id="unit">
                                    <select class="form-control jscaribasicmultiple" <?=$readonlyg?>  id="reqUnitMesinId" <?=$disabled?> name="reqUnitMesinId"  style="width:100%;" >
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
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" >  
                        <label class="control-label col-md-2">Group Pm </label>
                        <div class='col-md-4'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <select class="form-control jscaribasicmultiple" readonly  <?=$readonlyg?> id="reqGroupPm"   name="reqGroupPm"  style="width:100%;"  >
                                        <option value="" >Pilih Group Pm</option>
                                        <?
                                        foreach($arrgroup as $item) 
                                        {
                                            $selectvalid= $item["id"];
                                            $selectvaltext= $item["text"];
                                            $selectvalkode= $item["KODE"];
                                            $selected="";
                                            if($selectvaltext==$reqGroupPm)
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
                       </div>
                    </div>

                    <?
                    if($reqMode=="insert")
                    {
                        ?>
                        <div class="form-group" >  
                            <label class="control-label col-md-2">Tahun </label>
                            <div class='col-md-4'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                     <input autocomplete="off" maxlength="4" class="easyui-validatebox textbox form-control" type="text" required="" name="reqTahun"  id="reqTahun" value="<?=$reqTahun?>" <?=$disabled?> style="width:50%" />
                                    </div>
                                </div>
                            </div>
                         </div>

                        <div class="form-group" >  
                            <label class="control-label col-md-2">Cost Pm Yearly </label>
                            <div class='col-md-4'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                       <input autocomplete="off"  class="easyui-validatebox textbox form-control" type="text" name="reqCost"  required id="reqCost" value="<?=$reqCost?>" <?=$disabled?> style="width:50%" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?
                    }
                    ?>


                <?
                }
                else if($reqParent=="tahun")
                {

                    
                ?>

                <div class="form-group">  
                        <label class="control-label col-md-2">Distrik </label>
                        <div class='col-md-6'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <select class="form-control jscaribasicmultiple" readonly required id="reqDistrikId" <?=$disabled?> name="reqDistrikId"  style="width:100%;" >
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
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Blok </label>
                        <div class='col-md-6'>
                            <div class='form-group'>
                                <div class='col-md-11' id="blok">
                                    <select class="form-control jscaribasicmultiple"   readonly id="reqBlokId"   name="reqBlokId"  style="width:100%;"  >
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
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2">Unit Mesin </label>
                        <div class='col-md-4'>
                            <div class='form-group'>
                                <div class='col-md-11'  id="unit">
                                    <select class="form-control jscaribasicmultiple"   readonly  id="reqUnitMesinId" <?=$disabled?> name="reqUnitMesinId"  style="width:100%;" >
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
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" >  
                        <label class="control-label col-md-2">Group Pm </label>
                        <div class='col-md-4'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <select class="form-control jscaribasicmultiple"  readonly id="reqGroupPm"   name="reqGroupPm"  style="width:100%;"  >
                                        <option value="" >Pilih Group Pm</option>
                                        <?
                                        foreach($arrgroup as $item) 
                                        {
                                            $selectvalid= $item["id"];
                                            $selectvaltext= $item["text"];
                                            $selectvalkode= $item["KODE"];
                                            $selected="";
                                            if($selectvaltext==$reqGroupPm)
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
                       </div>
                    </div>

                    

                    <div class="form-group" >  
                        <label class="control-label col-md-2">Tahun </label>
                        <div class='col-md-4'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                   <input autocomplete="off" maxlength="4" class="easyui-validatebox textbox form-control" type="text" required="" name="reqTahun"  id="reqTahun" value="<?=$reqTahun?>" <?=$disabled?> style="width:50%" />
                               </div>
                           </div>
                       </div>
                   </div>

                    <div class="form-group" >  
                        <label class="control-label col-md-2">Cost Pm Yearly </label>
                        <div class='col-md-4'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                 <input autocomplete="off"  class="easyui-validatebox textbox form-control" type="text" name="reqCost"  required id="reqCost" value="<?=$reqCost?>" <?=$disabled?> style="width:70%" />
                            </div>
                            </div>
                        </div>
                    </div>
                <?
                }
                ?>


               
           
           <input type="hidden" name="reqSiteId" value="<?=$reqSiteId?>" />
           <input type="hidden" name="reqMode" value="<?=$reqMode?>" />
           <input type="hidden" name="reqParent" value="<?=$reqParent?>" />
           <input type="hidden" name="reqGroupPmOld" value="<?=$reqGroupPm?>" />
            <input type="hidden" name="reqTahunOld" value="<?=$reqTahun?>" />
            <input type="hidden" name="reqCostOld" value="<?=$reqCost?>" />

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



    $('#reqTahun').on('input blur paste', function(){
        var numeric = $(this).val().replace(/\D/g, '');
        $(this).val(numeric);
    });

    $('#reqCost').keyup(function(event) {
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


    // $('#reqCost').keyup(function(event) {
    //     if(event.which >= 37 && event.which <= 40) return;
    //     $(this).val(function(index, value) {
    //       return value
    //       .replace(/\D/g, "")
    //       .replace(/\B(?=(\d{3})+(?!\d))/g, ".")
    //       ;
    //   });
    // });

    // $("#reqCost").keydown(function (event) {
    //     if (event.shiftKey == true) {
    //         event.preventDefault();
    //     }

    //     console.log(event.keyCode);

    //     if ((event.keyCode >= 48 && event.keyCode <= 57) || 
    //         (event.keyCode >= 96 && event.keyCode <= 105) || 
    //         event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 ||
    //         event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190 || event.keyCode == 188) {

    //     } else {
    //         event.preventDefault();
    //     }

    //     if($(this).val().indexOf('.') !== -1 && event.keyCode == 190)
    //         event.preventDefault(); 

    // });


  
    $('#reqDistrikId').on('change', function() {
    // $("#blok").empty();
    var reqDistrikId= this.value;

    $.getJSON("json-app/blok_unit_json/filter_blok?reqDistrikId="+reqDistrikId,
        function(data)
        {
            // console.log(data);
            $("#reqBlokId option").remove();
            $("#reqUnitMesinId option").remove();
            $("#reqGroupPm option").remove();
            $("#reqBlokId").attr("readonly", false); 
            $("#reqBlokId").append('<option value="" >Pilih Blok Unit</option>');
            $("#reqUnitMesinId").append('<option value="" >Pilih Unit Mesin</option>');
            $("#reqGroupPm").append('<option value="" >Pilih Group Pm</option>');
            jQuery(data).each(function(i, item){
                $("#reqBlokId").append('<option value="'+item.KODE+'" >'+item.text+'</option>');
            });
        });
    
    });

    $('#reqBlokId').on('change', function() {
        var reqDistrikId= $("#reqDistrikId").val();
        var reqBlokId= this.value;

        if(reqBlokId)
        {

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

            $.getJSON("json-app/group_pm_json/filter_group?reqDistrikId="+reqDistrikId+"&reqBlokId="+reqBlokId,
            function(data)
            {
                $("#reqGroupPm option").remove();
                $("#reqGroupPm").attr("readonly", false); 
                $("#reqGroupPm").append('<option value="" >Pilih Group Pm</option>');
                jQuery(data).each(function(i, item){
                    $("#reqGroupPm").append('<option value="'+item.text+'" >'+item.text+'</option>');
                });            
            });

        }
        else
        {
            $("#reqUnitMesinId option").remove();
            $("#reqUnitMesinId").append('<option value="" >Pilih Unit Mesin</option>');
            $("#reqGroupPm option").remove();
            $("#reqGroupPm").append('<option value="" >Pilih Group Pm</option>');
        }

       
    });

    $('#reqUnitMesinId').on('change', function() {
        var reqDistrikId= $("#reqDistrikId").val();
        var reqBlokId=  $("#reqBlokId").val();
        var reqUnitMesinId= this.value;

        $.getJSON("json-app/group_pm_json/filter_group?reqDistrikId="+reqDistrikId+"&reqBlokId="+reqBlokId+"&reqUnitMesinId="+reqUnitMesinId,
            function(data)
            {
                $("#reqGroupPm option").remove();
                $("#reqGroupPm").attr("readonly", false); 
                $("#reqGroupPm").append('<option value="" >Pilih Group Pm</option>');
                jQuery(data).each(function(i, item){
                    $("#reqGroupPm").append('<option value="'+item.text+'" >'+item.text+'</option>');
                });            
            });
    });


    function submitForm(){

        $('#ff').form('submit',{
            url:'json-app/wo_standing_json/add',
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
                reqSiteId= data[0];
                infoSimpan= data[1];

                if(reqSiteId == 'xxx')
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