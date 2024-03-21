<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/Crud");
$this->load->model("base-app/Distrik");


$pgreturn= str_replace("_add", "", $pg);

$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("setting_", "", $pgtitle)));

$reqId = $this->input->get("reqId");
$reqLihat = $this->input->get("reqLihat");


$set= new Crud();

if($reqId == "")
{
    $reqMode = "insert";
    $reqKodeHak='';
    $arrkemungkinan= [];
}
else
{
    $reqMode = "update";

    $statement = " AND A.PENGGUNA_HAK_ID = '".$reqId."' ";
    $set->selectByParams(array(), -1, -1, $statement);
    // echo $set->query;exit;
    $set->firstRow();
    $reqId= $set->getField("PENGGUNA_HAK_ID");
    $reqKodeHak= $set->getField("KODE_HAK");
    $reqNamaHak= $set->getField("NAMA_HAK");
    $reqDeskripsi= $set->getField("DESKRIPSI");
    $reqDistrik= getmultiseparator($set->getField("DISTRIK_ID_INFO"));
    $reqStatusAll= getmultiseparator($set->getField("STATUS_ALL_INFO"));

    $jabatandetil= new Crud();
    $arrjabatandetil= [];
    $statementjabatan=" AND A.PENGGUNA_HAK_ID= ".$reqId;
    $jabatandetil->selectByParamsJabatan(array(), -1,-1,$statementjabatan);
    // echo $jabatandetil->query;exit;
    while($jabatandetil->nextRow())
    {
        $arrdata= array();
        $arrdata["PENGGUNA_HAK_ID"]= $jabatandetil->getField("PENGGUNA_HAK_ID");
        $arrdata["PENGGUNA_HAK_JABATAN_ID"]= $jabatandetil->getField("PENGGUNA_HAK_JABATAN_ID");
        $arrdata["POSITION_ID"]= $jabatandetil->getField("POSITION_ID");
        $arrdata["NAMA"]= $jabatandetil->getField("NAMA_POSISI");

        array_push($arrjabatandetil, $arrdata);
    }

    // print_r($arrjabatandetil);exit;
    unset($jabatandetil);
    // $reqKodeReadonly= " readonly ";
}

$kode= $reqKodeHak;
$set->selectByParamsMenus(array(), -1, -1, ' AND STATUS_SUB_APPR IS NULL', $kode);
// echo $set->query;exit;
while ($set->nextRow()) 
{
    $table[] = array(
        'kode'  => $set->getField('kode_modul'),
        'nama'  => $set->getField('menu_modul'),
        'level' => $set->getField('level_modul'),
        'level2' => $set->getField('depth'),
        'grup'  => $set->getField('group_modul'),
        'menu'  => $set->getField('menu'),
        'create' => $set->getField('modul_c'),
        'create_anak' => $set->getField('modul_anak_c'),
        'read'  => $set->getField('modul_r'),
        'read_anak'  => $set->getField('modul_anak_r'),
        'update' => $set->getField('modul_u'),
        'update_anak' => $set->getField('modul_anak_u'),
        'delete' => $set->getField('modul_d'),
        'delete_anak' => $set->getField('modul_anak_d')
    );
}
// print_r($table);exit;


$set= new Distrik();
$statement=" AND A.NAMA IS NOT NULL ";
$arrdistrik= [];
$set->selectByParams(array(), 30,-1,$statement);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("DISTRIK_ID");
    $arrdata["kode"]=  $set->getField("KODE");
    $arrdata["text"]=  $set->getField("NAMA");
    array_push($arrdistrik, $arrdata);
}
unset($set);




$disabled="";


if($reqLihat ==1)
{
    $disabled="disabled";  
}

?>

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
</style>

<script src='assets/multifile-master/jquery.form.js' type="text/javascript" language="javascript"></script> 
<script src='assets/multifile-master/jquery.MetaData.js' type="text/javascript" language="javascript"></script> 
<script src='assets/multifile-master/jquery.MultiFile.js' type="text/javascript" language="javascript"></script> 
<link rel="stylesheet" href="css/gaya-multifile.css" type="text/css">

<style type="text/css">
    .tdcenter{
        text-align: center;
        border: 1px solid black !important;
        vertical-align: top;;
    }

    .tdleft{
        border: 1px solid black !important;
        vertical-align: top;;
    }

    /*table { border-collapse: collapse; width: 100%; }
    th, td { background: #fff; padding: 8px 16px; }

    .tableFixHead {
        overflow: auto;
        height: 100vh;
    }

    .tableFixHead thead th {
        position: sticky;
        top: 0;
    }*/

    .table-sticky>thead>tr>th,
    .table-sticky>thead>tr>td {
        background: #009688;
        color: #fff;
        /*top: 0px;
        position: sticky;*/
    }
    .table-sticky>thead {
        top: -10px;
        position: sticky;   
    }
    .table-height {
        height: 100vh;
        display: block;
        overflow: scroll;
        width: 100%;
    }

    table {
        border-collapse: collapse;
        border-spacing: 0;
    }

    .table-bordered>thead>tr>th,
    .table-bordered>tbody>tr>th,
    .table-bordered>thead>tr>td,
    .table-bordered>tbody>tr>td {
        border: 1px solid #ddd;
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
                                                                             
                    <div class="form-group">  
                        <label class="control-label col-md-2">Kode Hak</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqKodeHak" id="reqKodeHak" value="<?=$reqKodeHak?>" data-options="required:true" style="width:100%" <?=$disabled?>  />
                                     <!-- <? if($reqId!="") {echo "readonly"; } ?>  -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Nama Hak</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqNamaHak"  id="reqNamaHak" value="<?=$reqNamaHak?>" data-options="required:true" style="width:100%"  <?=$disabled?> />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Deskripsi</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <!-- <input   name="reqDeskripsi" class="easyui-combobox form-control" id="reqDeskripsi"
                                    data-options="width:'300',editable:false,valueField:'id',textField:'text',url:'json-app/Combo_json/combostatusaktif'" value="<?=$reqDeskripsi?>" required /> -->
                                    <textarea name="reqDeskripsi" class="easyui-validatebox form-control" id="reqDeskripsi" data-options="required:true" <?=$disabled?>  ><?=$reqDeskripsi?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="form-group">  
                            <label class="control-label col-md-2">Distrik</label>
                            <div class='col-md-4'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                        <select class="form-control jscaribasicmultiple" id="reqDistrik" <?=$disabled?> name="reqDistrik[]" style="width:100%;" multiple="multiple">
                                            <?
                                            $selected="";
                                            if($reqStatusAll[0]=="0")
                                            {
                                                $selected="selected";

                                            }
                                           
                                            ?>
                                            <option value="0" <?=$selected?>>All Distrik</option>
                                            <?
                                            foreach($arrdistrik as $item) 
                                            {
                                                $selectvalid= $item["id"];
                                                $selectvaltext= $item["text"];

                                                $selected="";
                                                if($reqStatusAll[0]=="0")
                                                {
                                                }
                                                else
                                                {
                                                    if(in_array($selectvalid, $reqDistrik))
                                                    {
                                                        $selected="selected";
                                                    }
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

                        <div class="form-group" id="tambaharea">  
                            <label class="control-label col-md-2">Tambah Jabatan</label>
                            <div class='col-md-4'>
                                <div class='form-group'>
                                    <div class='col-md-11' id="blok">
                                         <a id="btnAdd" onclick="openJabatan()"><i class="fa fa-plus-square fa-lg" aria-hidden="true"></i> </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group" id="jabatan">  
                            <label class="control-label col-md-2">Jabatan</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <table id="tabel" class="table table-bordered" style="width: 100%;" >
                                        <thead >
                                            <tr>
                                                <th class="text-center" style="display: none">Position Id</th>
                                                <th class="text-center" style="vertical-align: middle;">Jabatan</th>

                                                <th class="text-center" style="width: 5%;text-align: center;vertical-align: middle;">Hapus </th>
                                            </tr>
                                        </thead>
                                        <tbody id="jabatanmulti">
                                            <?
                                            if(!empty($arrjabatandetil))
                                            {
                                                foreach ($arrjabatandetil as $key => $value) 
                                                {
                                            ?>
                                                    <tr >
                                                        <td style="display: none"><input type="hidden" name="reqPositionId[]" id="reqPositionId" value="<?=$value['POSITION_ID']?>" /></td>
                                                        <td> <?=$value['NAMA']?></td>
                                                        <td style="text-align: center;vertical-align: middle;"><span  class='hapustabel' style='background-color: red; padding: 10px; border-radius: 5px;top: 50%;position: relative;'><a onclick='HapusDetil("<?=$value['PENGGUNA_HAK_JABATAN_ID']?>","<?=$value['POSITION_ID']?>","<?=$reqId?>")'><i class='fa fa-trash fa-lg' style='color: white;' aria-hidden='true'></i></a></span>
                                                        </td>  
                                                    </tr>

                                            <?
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                    <input type="hidden" name="reqId" value="<?=$reqId?>" />
                    <input type="hidden" name="reqMode" value="<?=$reqMode?>" />
                    
                    <?
                    if($reqLihat ==1)
                    {}
                    else
                    {
                    ?>
                    <div style="text-align:center;padding:5px">
                        <a href="javascript:void(0)" class="btn btn-primary" onclick="submitForm()">Submit</a>

                    </div>
                    <?
                    }
                    ?>

                    <div class="page-header">
                        <h3><i class="fa fa-file-text fa-lg"></i> <?=$pgtitle?></h3>       
                    </div>
            
                    <div class="box-body table-height">
                        <table class="table table-hover table-sticky">
                            <thead>
                                <tr>
                                    <th style="vertical-align: top;" class="tdcenter" rowspan="2" width="600px">Modul</th>
                                    <th style="vertical-align: top;" class="tdcenter" rowspan="2" width="10px">
                                        Menu<br/>
                                        <input id="reqRadioHeadCheck-menu" type="checkbox" />
                                    </th>
                                    <th class="tdcenter" colspan="2" width="10px">Create</th>
                                    <th class="tdcenter" colspan="2" width="10px">Read</th>
                                    <th class="tdcenter" colspan="2" width="10px">Update</th>
                                    <th class="tdcenter" colspan="2" width="10px">Delete</th>
                                </tr>
                                <tr>
                                    <th class="tdcenter" width="5px" colspan="2">
                                        Hak<br/>
                                        <input id="reqRadioHeadCheck-create" type="checkbox" />
                                    </th>
                                  <!--   <th class="tdcenter" width="5px">
                                        Hak Anak<br/>
                                        <input id="reqRadioHeadCheck-create_anak" type="checkbox" />
                                    </th> -->
                                    <th class="tdcenter" width="5px" colspan="2">
                                        Hak<br/>
                                        <input id="reqRadioHeadCheck-read" type="checkbox" />
                                    </th>
                                   <!--  <th class="tdcenter" width="5px">
                                        Hak Anak<br/>
                                        <input id="reqRadioHeadCheck-read_anak" type="checkbox" />
                                    </th> -->
                                    <th class="tdcenter" width="5px" colspan="2">
                                        Hak<br/>
                                        <input id="reqRadioHeadCheck-update" type="checkbox" />
                                    </th>
                                   <!--  <th class="tdcenter" width="5px">
                                        Hak Anak<br/>
                                        <input id="reqRadioHeadCheck-update_anak" type="checkbox" />
                                    </th> -->
                                    <th class="tdcenter" width="5px" colspan="2">
                                        Hak<br/>
                                        <input id="reqRadioHeadCheck-delete" type="checkbox" />
                                    </th>
                                    <!-- <th class="tdcenter" width="5px">
                                        Hak Anak<br/>
                                        <input id="reqRadioHeadCheck-delete_anak" type="checkbox" />
                                    </th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                // print_r($table); exit;
                                $i = 0;
                                foreach($table as $key=>$value)
                                {
                                    if($value['level2']==1)
                                    {
                                        $keyinfoid= $value['grup']."-".str_replace(".", "", $value['kode']);
                                        ?>
                                        <tr>
                                            <td class="tdleft">
                                                <b><?=$value['nama']?></b>
                                                <!-- <b><?=$keyinfoid?></b> -->
                                                <input name="modul[<?=$i?>]" type="hidden" value="<?=$value['kode']?>" class="span3" readonly="readonly" />

                                                <input id="reqRadioCheck-<?=$keyinfoid?>" type="checkbox" />
                                            </td>
                                            <td class="tdcenter">
                                                <input id="reqRadioCheck-<?=$keyinfoid?>-menu" name="menu[<?=$i?>]" type="checkbox" value="1" <?=($value['menu']==1)?'checked="checked"':''?>/>
                                            </td>
                                            <td class="tdcenter" colspan="2">
                                                <input id="reqRadioCheck-<?=$keyinfoid?>-create" name="create[<?=$i?>]" type="checkbox" value="1" <?=($value['create']==1)?'checked="checked"':''?>/>
                                            </td>
                                           <!--  <td class="tdcenter">
                                                <input id="reqRadioCheck-<?=$keyinfoid?>-create_anak" name="create_anak[<?=$i?>]" type="checkbox" value="1" <?=($value['create_anak']==1)?'checked="checked"':''?>/>
                                            </td> -->
                                            <td class="tdcenter" colspan="2">
                                                <input id="reqRadioCheck-<?=$keyinfoid?>-read" name="read[<?=$i?>]" type="checkbox" value="1" <?=($value['read']==1)?'checked="checked"':''?>/>
                                            </td>
                                           <!--  <td class="tdcenter">
                                                <input id="reqRadioCheck-<?=$keyinfoid?>-read_anak" name="read_anak[<?=$i?>]" type="checkbox" value="1" <?=($value['read_anak']==1)?'checked="checked"':''?>/>
                                            </td> -->
                                            <td class="tdcenter" colspan="2">
                                                <input id="reqRadioCheck-<?=$keyinfoid?>-update" name="update[<?=$i?>]" type="checkbox" value="1" <?=($value['update']==1)?'checked="checked"':''?>/>
                                            </td>
                                           <!--  <td class="tdcenter">
                                                <input id="reqRadioCheck-<?=$keyinfoid?>-update_anak" name="update_anak[<?=$i?>]" type="checkbox" value="1" <?=($value['update_anak']==1)?'checked="checked"':''?>/>
                                            </td> -->
                                            <td class="tdcenter" colspan="2">
                                                <input id="reqRadioCheck-<?=$keyinfoid?>-delete" name="delete[<?=$i?>]" type="checkbox" value="1" <?=($value['delete']==1)?'checked="checked"':''?>/>
                                            </td>
                                            <!-- <td class="tdcenter">
                                                <input id="reqRadioCheck-<?=$keyinfoid?>-delete_anak" name="delete_anak[<?=$i?>]" type="checkbox" value="1" <?=($value['delete_anak']==1)?'checked="checked"':''?>/>
                                            </td> -->
                                        </tr>
                                        <?php 
                                        $i++;
                                        foreach($table as $key2=>$value2)
                                        {
                                            if($value2['level2'] >=2 AND $value['grup']==$value2['grup'])
                                            {
                                                $keyinfoid= $value2['grup']."-".str_replace(".", "", $value2['kode']);
                                        ?>
                                        <tr>
                                            <td class="tdleft">
                                                <?php 
                                                    if($value2['level2']==2 )
                                                    {
                                                        echo '---'.$value2['nama'];
                                                    }
                                                    else
                                                    {
                                                        echo '------'.$value2['nama'];
                                                    }
                                                ?>
                                                <!-- <b><?=$keyinfoid?></b> -->
                                                <input name="modul[<?=$i?>]" type="hidden" value="<?=$value2['kode']?>" class="span3" readonly="readonly">

                                                <input id="reqRadioCheck-<?=$keyinfoid?>" type="checkbox" />
                                            </td>
                                            <td class="tdcenter">
                                                <input id="reqRadioCheck-<?=$keyinfoid?>-menu" name="menu[<?=$i?>]" type="checkbox" value="1" <?=($value2['menu']==1)?'checked="checked"':''?>/>
                                            </td>
                                            <td class="tdcenter" colspan="2">
                                                <input id="reqRadioCheck-<?=$keyinfoid?>-create" name="create[<?=$i?>]" type="checkbox" value="1" <?=($value2['create']==1)?'checked="checked"':''?>/>
                                            </td>
                                          <!--   <td class="tdcenter">
                                                <input id="reqRadioCheck-<?=$keyinfoid?>-create_anak" name="create_anak[<?=$i?>]" type="checkbox" value="1" <?=($value2['create_anak']==1)?'checked="checked"':''?>/>
                                            </td> -->
                                            <td class="tdcenter" colspan="2">
                                                <input id="reqRadioCheck-<?=$keyinfoid?>-read" name="read[<?=$i?>]" type="checkbox" value="1" <?=($value2['read']==1)?'checked="checked"':''?>/>
                                            </td>
                                            <!-- <td class="tdcenter">
                                                <input id="reqRadioCheck-<?=$keyinfoid?>-read_anak" name="read_anak[<?=$i?>]" type="checkbox" value="1" <?=($value2['read_anak']==1)?'checked="checked"':''?>/>
                                            </td> -->
                                            <td class="tdcenter" colspan="2">
                                                <input id="reqRadioCheck-<?=$keyinfoid?>-update" name="update[<?=$i?>]" type="checkbox" value="1" <?=($value2['update']==1)?'checked="checked"':''?>/>
                                            </td>
                                            <!-- <td class="tdcenter">
                                                <input id="reqRadioCheck-<?=$keyinfoid?>-update_anak" name="update_anak[<?=$i?>]" type="checkbox" value="1" <?=($value2['update_anak']==1)?'checked="checked"':''?>/>
                                            </td> -->
                                            <td class="tdcenter" colspan="2">
                                                <input id="reqRadioCheck-<?=$keyinfoid?>-delete" name="delete[<?=$i?>]" type="checkbox" value="1" <?=($value2['delete']==1)?'checked="checked"':''?>/>
                                            </td>
                                           <!--  <td class="tdcenter">
                                                <input id="reqRadioCheck-<?=$keyinfoid?>-delete_anak" name="delete_anak[<?=$i?>]" type="checkbox" value="1" <?=($value2['delete_anak']==1)?'checked="checked"':''?>/>
                                            </td> -->
                                        </tr>
                                        <?php
                                            $i++;
                                            }
                                        }
                                    }
                                }
                                ?>
                                <tr>
                                    <th rowspan="2" class="tdcenter">Modul</th>
                                    <th rowspan="2" class="tdcenter">Menu</th>
                                    <th class="tdcenter" colspan="2">Hak</th>
                                    <!-- <th class="tdcenter">Hak Anak</th> -->
                                    <th class="tdcenter" colspan="2">Hak</th>
                                    <!-- <th class="tdcenter">Hak Anak</th> -->
                                    <th class="tdcenter" colspan="2">Hak</th>
                                    <!-- <th class="tdcenter">Hak Anak</th> -->
                                    <th class="tdcenter" colspan="2">Hak</th>
                                    <!-- <th class="tdcenter">Hak Anak</th> -->
                                </tr>
                                <tr>
                                    <th class="tdcenter" colspan="2">Create</th>
                                    <th class="tdcenter" colspan="2">Read</th>
                                    <th class="tdcenter" colspan="2">Update</th>
                                    <th class="tdcenter" colspan="2">Delete</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </form>
            </div>
            
        </div>

        <div class="konten-inner">
            
        </div>
    </div>
    
</div>

<script>

var reqId= '<?=$reqId?>';
var reqDistrikId= '<?=$reqDistrik[0]?>';
var arrDistrikCheck = $('#reqDistrik').val(); 
var discheck="";
if(jQuery.inArray("0", arrDistrikCheck) != -1) {
    discheck=1;
} 

if(reqId !== '')
{
    if(reqDistrikId !== '')
    {
        var validasipengukuran= <?php echo json_encode($arrdistrik); ?>;
        validasipengukuran.forEach(function(e) {
            // console.log(discheck);
            if(discheck==1)
            {
                $("#reqDistrik>option[value='"+e.id+"']").attr('disabled','disabled');
            }
            else
            {
                if (e.id != '0' ) 
                { 
                   $("#reqDistrik>option[value='"+e.id+"']").removeAttr('disabled');
                   $("#reqDistrik>option[value='0']").attr('disabled','disabled');   
                }
                else
                {
                    $("#reqDistrik>option[value='"+e.id+"']").attr('disabled','disabled');
                }           
            }            
             
        });
    }
}

var tipe = $("#reqDistrik");
tipe.on("select2:select", function(event) {

    var selected=$(this).val();
    var values = [];

    $(event.currentTarget).find("option:selected").each(function(i, selected)
    { 
       values[i] = selected.value;
    });

    jQuery.each(values, function(index, value) {
        var selected=value;
        $("#reqDistrik option").each(function()
        {
            console.log(selected);
            if(selected==0)
            {
               if ($(this).val() != '0' ) 
               { 

                $("#reqDistrik>option[value='"+$(this).val()+"']").attr('disabled','disabled');
               }
            }
            else
            {

                if ($(this).val() != '0' ) 
                { 
                     $("#reqDistrik>option[value='"+$(this).val()+"']").removeAttr('disabled');   

                }
                else
                {
                    $("#reqDistrik>option[value='"+$(this).val()+"']").attr('disabled','disabled');
                }
               
            }  
        });
    });

});

   $('#reqDistrik').on("select2:unselecting", function(event){
       var value = event.params.args.data.id;
       var keterangan = event.params.args.data.text;

       var values = [];

       $(event.currentTarget).find("option:selected").each(function(i, selected)
       { 
         values[i] = selected.value;
       });

       var selectedlength=values.length;

       if(selectedlength==1)
       {
            $("#reqDistrik>option[value='0']").removeAttr('disabled');
       }

       jQuery.each(values, function(index, value) {
        var selected=value;
            $("#reqDistrik option").each(function()
            {
                if(selected==0)
                {
                    if ($(this).val() != '0' ) 
                    { 
                        $("#reqDistrik>option[value='"+$(this).val()+"']").removeAttr('disabled'); 
                    }
                }
            });
        });
    }).trigger('change');


function submitForm(){
    
    $('#ff').form('submit',{
        url:'json-app/crud_json/add',
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
                $.messager.alertLink('Info', infoSimpan, 'info', "app/index/<?=$pgreturn?>");
        }
    });
}

function clearForm(){
    $('#ff').form('clear');
}

function openJabatan()
{
    var reqPositionId = $("input[name='reqPositionId[]']")
              .map(function(){return $(this).val();}).get();
    reqPositionId = reqPositionId.join(",");

    openAdd('app/loadUrl/app/lookup_jabatan_multi?reqId=<?=$reqId?>&reqPositionId='+reqPositionId);
} 

function HapusDetil(iddetil,positionid,reqId) {
    $.messager.confirm('Konfirmasi',"Hapus data terpilih?",function(r){
        if (r){
            $.getJSON("json-app/crud_json/deletedetil?reqDetilId="+iddetil+"&reqPositionId="+positionid+"&reqId="+reqId,
                function(data){
                    // console.log(data);return false;
                    $.messager.alert('Info', data.PESAN, 'info');                    
                    location.reload();
                });
        }
    }); 
}  
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('[id^="reqRadioHeadCheck"]').click(function() {
            var tempId= $(this).attr('id');
            infochecked= $(this).prop('checked');

            arrTempId= String(tempId);
            arrTempId= arrTempId.split('-');
            reqCheckHeadGrup= arrTempId[1];
            // console.log(reqCheckHeadGrup);
            
            $('[id^="reqRadioCheck"]').each(function(){

                var tempId= $(this).attr('id');

                arrTempId= String(tempId);
                arrTempId= arrTempId.split('-');
                // console.log(arrTempId);

                reqCheckGrup= arrTempId[1];
                reqCheckKode= arrTempId[2];
                reqCheckDetil= arrTempId[3];

                if(typeof reqCheckDetil == "undefined")
                    reqCheckDetil= "";

                // console.log(reqCheckGrup+"-"+reqCheckKode+"-"+reqCheckDetil);

                if(reqCheckDetil == reqCheckHeadGrup)
                {
                    if(infochecked == true)
                    {
                        $(this).attr('checked', true);
                        $(this).prop('checked', true);
                    }
                    else
                    {
                        $(this).attr('checked', false);
                        $(this).prop('checked', false); 
                    }
                }

           });

        });

        $('[id^="reqRadioCheck"]').click(function() {
            var tempId= $(this).attr('id');
            infochecked= $(this).prop('checked');

            arrTempId= String(tempId);
            arrTempId= arrTempId.split('-');
            // console.log(arrTempId);

            reqCheckGrup= arrTempId[1];
            reqCheckKode= arrTempId[2];
            reqCheckDetil= arrTempId[3];

            if(typeof reqCheckDetil == "undefined")
                reqCheckDetil= "";

            // reqCheckKodePanjang= reqCheckKode.length;
            // +"-"+reqCheckKodePanjang
            // console.log(reqCheckGrup+"-"+reqCheckKode+"-"+reqCheckDetil);

            if(reqCheckDetil == "")
            {
                if(infochecked == true)
                {
                    $('[id^="reqRadioCheck-'+reqCheckGrup+'-'+reqCheckKode+'"]').attr('checked', true);
                    $('[id^="reqRadioCheck-'+reqCheckGrup+'-'+reqCheckKode+'"]').prop('checked', true);
                }
                else
                {
                    $('[id^="reqRadioCheck-'+reqCheckGrup+'-'+reqCheckKode+'"]').attr('checked', false);
                    $('[id^="reqRadioCheck-'+reqCheckGrup+'-'+reqCheckKode+'"]').prop('checked', false);
                }
            }

         });

        $("#jabatanmulti").on("click", ".btn-remove", function(){
            $(this).closest('tr').remove();
        });
    });


    function addmultiarea(id, multiinfonama, IDFIELD) 
    {
        batas= id.length;

        if(batas > 0)
        {
            $("#jabatan").show();
            rekursivemultiarea(0, id,multiinfonama,IDFIELD);
        }
    }

    function rekursivemultiarea(index, id, multiinfonama, IDFIELD) 
    {
        urllink= "app/loadUrl/app/template_jabatan_multi";
        method= "POST";
        batas= id.length;
        if(index < batas)
        {
            POSITION_ID= id[index];
            NAMA= multiinfonama[index];

            var rv = true;

            if (rv == true) 
            {
                $.ajax({
                    url: urllink,
                    method: method,
                    data: {
                        reqPositionId: POSITION_ID,
                        reqNama: NAMA
                       
                    },
                    success: function (response) {
                        $("#"+IDFIELD+"").append(response);

                        index= parseInt(index) + 1;
                        rekursivemultiarea(index,id, multiinfonama, IDFIELD);
                    },
                    error: function (response) {
                    },
                    complete: function () {
                    }
                });
            }
            else
            {
                index= parseInt(index) + 1;
                rekursivemultiarea(index,id,multiinfonama, IDFIELD);
            }
        }
    }
</script>