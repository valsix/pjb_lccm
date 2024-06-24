<?




$reqAssetNum = $this->input->post("reqAssetNum");
$reqNama = $this->input->post("reqNama");
$reqDescription = $this->input->post("reqDescription");



?>

<?


?>
    <tr id="<?=$reqUniqId?>">
        <td style="display: none"><input type="hidden" name="reqAssetNum[]" id="reqAssetNum" value="<?=$reqAssetNum?>" /></td>
        <td> <?=$reqNama?></td>
        <td> <?=$reqDescription?></td>
        <td style="text-align: center;vertical-align: middle;"><span style='background-color: red; padding: 10px; border-radius: 5px;top: 50%;position: relative;'><a class='btn-remove' ><i class='fa fa-trash fa-lg' style='color: white;' aria-hidden='true'></i></a></span></td>
    </tr>
<?

?>
<script type="text/javascript">
   

    $(document).ready(function(){
        var i=1;

        $('.sno').each(function(){
            $(this).text(i);
            i++;
        });
    });


</script>
