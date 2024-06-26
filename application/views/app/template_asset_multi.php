<?


$reqMode = $this->input->get("reqMode");

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
    while($set->nextRow())
    {
        $arrdata= array();
        $arrdata["id"]=  trim($set->getField("ASSETNUM"));
        $arrdata["ASSETNUM"]= $set->getField("ASSETNUM");
        $arrdata["DESCRIPTION"]= $set->getField("DESCRIPTION");
        array_push($arrset, $arrdata);
    }
    unset($set);

}
else
{

    $reqAssetNum = $this->input->post("reqAssetNum");
    $reqNama = $this->input->post("reqNama");
    $reqDescription = $this->input->post("reqDescription");
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

?>
    <tr >
        <td style="display: none"><input type="hidden" name="reqAssetNum[]" id="reqAssetNum" value="<?=$reqAssetNum?>" /></td>
        <td> <?=$reqNama?></td>
        <td> <?=$reqDescription?></td>
        <td style="text-align: center;vertical-align: middle;"><span style='background-color: red; padding: 10px; border-radius: 5px;top: 50%;position: relative;'><a class='btn-remove' ><i class='fa fa-trash fa-lg' style='color: white;' aria-hidden='true'></i></a></span></td>
    </tr>
<?
    }
}
else
{
?>
    <tr >
        <td style="display: none"><input type="hidden" name="reqAssetNum[]" id="reqAssetNum" value="<?=$reqAssetNum?>" /></td>
        <td> <?=$reqNama?></td>
        <td> <?=$reqDescription?></td>
        <td style="text-align: center;vertical-align: middle;"><span style='background-color: red; padding: 10px; border-radius: 5px;top: 50%;position: relative;'><a class='btn-remove' ><i class='fa fa-trash fa-lg' style='color: white;' aria-hidden='true'></i></a></span></td>
    </tr>
<?
}
?>
