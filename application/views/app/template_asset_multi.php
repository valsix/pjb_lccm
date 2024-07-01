<?


$reqMode = $this->input->get("reqMode");
$reqProjectNo = $this->input->get("reqProjectNo");
$reqDistrikId = $this->input->get("reqDistrikId");
$reqBlokId = $this->input->get("reqBlokId");
$reqUnitMesinId = $this->input->get("reqUnitMesinId");



if($reqMode=='all')
{

    $this->load->model("base-app/Asset_Lccm");
    $set= new Asset_Lccm();
    $arrset= [];
    $statement = " AND A1.ASSET_LCCM =true AND A1.PARENT_CHILD ILIKE '%parent%' ";


    if(!empty($reqDistrikId))
    {
        $statement .= " AND A1.KODE_DISTRIK ='".$reqDistrikId."'";
    }

    if(!empty($reqBlokId))
    {
        $statement .= " AND A1.KODE_BLOK ='".$reqBlokId."'";
    }

    if(!empty($reqUnitMesinId))
    {
        $statement .= " AND A1.KODE_UNIT_M ='".$reqUnitMesinId."'";
    }

    $set->selectByParamstree(array(), -1,-1,$statement);
    // echo $set->query;exit;
    $jml=0;
    while($set->nextRow())
    {
        $arrdata= array();
        $arrdata["id"]=  trim($set->getField("ASSETNUM"));
        $arrdata["ASSETNUM"]= $set->getField("ASSETNUM");
        $arrdata["DESCRIPTION"]= $set->getField("DESCRIPTION");
        $reqCapitalDate= $set->getField("CAPITAL_DATE");
        $reqCapital= $set->getField("CAPITAL");
        $jml++;
        array_push($arrset, $arrdata);
    }

    $reqJumlah = $jml;

    unset($set);

}
else
{

    $reqAssetNum = $this->input->post("reqAssetNum");
    $reqNama = $this->input->post("reqNama");
    $reqDescription = $this->input->post("reqDescription");
    $reqCapitalDate = $this->input->post("reqCapitalDate");
    $reqCapital = $this->input->post("reqCapital");
    $reqJumlah = $this->input->get("reqJumlah");
}

?>

<?
if($reqMode=='all')
{
    foreach($arrset as $item) 
    {
        $reqAssetNum= $item["id"];
        $reqNama= $item["ASSETNUM"];
        $reqDescription= $item["DESCRIPTION"];
        $reqCapitalDate= $item["CAPITAL_DATE"];
        $reqCapital= $item["CAPITAL"];

?>
    <tr >
        <td style="display: none"><input type="hidden" name="reqAssetNum[]" id="reqAssetNum" value="<?=$reqAssetNum?>" /></td>
        <td style="display: none"><input type="hidden" name="reqCapital[]" id="reqCapital" value="<?=$reqCapital?>" /></td>
        <td style="display: none"><input type="hidden" name="reqCapitalDate[]" id="reqCapitalDate" value="<?=$reqCapitalDate?>" /></td>
        <td> <?=$reqNama?></td>
        <td> <?=$reqDescription?></td>
        <td style="text-align: center;vertical-align: middle;"><span style='background-color: red; padding: 10px; border-radius: 5px;top: 50%;position: relative;'><a class='btn-remove' ><i class='fa fa-trash fa-lg' style='color: white;' aria-hidden='true'></i></a></span></td>
        <td style="display: none"><input type="hidden" name="reqJumlah" id="reqJumlah" value="<?=$reqJumlah?>" /></td>
        <input type="hidden" name="reqProjectNo" value="<?=$reqProjectNo?>" />
        <input type="hidden" name="reqDistrikId" value="<?=$reqDistrikId?>" />
        <input type="hidden" name="reqBlokId" value="<?=$reqBlokId?>" />
        <input type="hidden" name="reqUnitMesinId" value="<?=$reqUnitMesinId?>" />
    </tr>
<?
    }
}
else
{
?>
    <tr >
        <td style="display: none"><input type="hidden" name="reqAssetNum[]" id="reqAssetNum" value="<?=$reqAssetNum?>" /></td>
        <td style="display: none"><input type="hidden" name="reqCapital[]" id="reqCapital" value="<?=$reqCapital?>" /></td>
        <td style="display: none"><input type="hidden" name="reqCapitalDate[]" id="reqCapitalDate" value="<?=$reqCapitalDate?>" /></td>
        <td> <?=$reqNama?></td>
        <td> <?=$reqDescription?></td>
        <td style="text-align: center;vertical-align: middle;"><span style='background-color: red; padding: 10px; border-radius: 5px;top: 50%;position: relative;'><a class='btn-remove' ><i class='fa fa-trash fa-lg' style='color: white;' aria-hidden='true'></i></a></span></td>
        <td style="display: none"><input type="hidden" name="reqJumlah" id="reqJumlah" value="<?=$reqJumlah?>" /></td>
        <input type="hidden" name="reqProjectNo" value="<?=$reqProjectNo?>" />
        <input type="hidden" name="reqDistrikId" value="<?=$reqDistrikId?>" />
        <input type="hidden" name="reqBlokId" value="<?=$reqBlokId?>" />
        <input type="hidden" name="reqUnitMesinId" value="<?=$reqUnitMesinId?>" />
    </tr>
<?
}
?>
