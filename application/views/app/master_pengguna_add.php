<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/RoleApproval");
$this->load->model("base-app/Pengguna");
$this->load->model("base-app/Crud");
$this->load->model("base-app/PenggunaEksternal");
$this->load->model("base-app/Distrik");


$pgreturn= str_replace("_add", "", $pg);

$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$reqId = $this->input->get("reqId");
$reqLihat = $this->input->get("reqLihat");


$set= new Pengguna();

if($reqId == "")
{
    $reqMode = "insert";
    $reqExpiredDate=date('d-m-Y', strtotime('+1 year'));
}
else
{
    $reqMode = "update";

    $statement = " AND A.PENGGUNA_ID = '".$reqId."' ";
    $set->selectByParams(array(), -1, -1, $statement);
    // echo $set->query;exit;
    $set->firstRow();
    $reqId= $set->getField("PENGGUNA_ID");
    $reqUsername= $set->getField("USERNAME");
    $reqNama= $set->getField("NAMA");
    $reqRoleApprId= $set->getField("ROLE_ID");
    $reqPenggunaEksternalId= $set->getField("PENGGUNA_EXTERNAL_ID");
    $reqPenggunaEksternalNama =$set->getField("PENGGUNA_EKSTERNAL_INFO");
    $reqInternalId= $set->getField("PENGGUNA_INTERNAL_ID");
    $reqInternalNama =$set->getField("PENGGUNA_INTERNAL_INFO");
    $reqTipe =$set->getField("TIPE");
    $reqJabatan =$set->getField("JABATAN");

    $reqHakAkses= getmultiseparator($set->getField("PENGGUNA_HAK_ID_INFO"));
    $reqDistrik= getmultiseparator($set->getField("DISTRIK_ID_INFO"));
    $reqStatusAll= getmultiseparator($set->getField("STATUS_ALL_INFO"));


    $reqNid= $set->getField("NID");
    $reqKodeBagian= $set->getField("KODE_BAGIAN");
    $reqBagian= $set->getField("BAGIAN");
    $reqKodeDitbid= $set->getField("KODE_DITBID");
    $reqDitbid= $set->getField("DITBID");
    $reqKodeUnit= $set->getField("KODE_UNIT");
    $reqUnit= $set->getField("UNIT");
    $reqKodeKlasifikasi= $set->getField("KODE_KLASIFIKASI_UNIT");
    $reqKlasifikasi= $set->getField("KLASIFIKASI_UNIT");
    $reqPosisi= $set->getField("NAMA_POSISI");
    $reqEmail= $set->getField("EMAIL");

    $reqNoTelpon= $set->getField("NO_TELP");
    $reqDistrikId= $set->getField("DISTRIK_ID");

    $reqPositionId= $set->getField("POSITION_ID");
    $reqRoleId= $set->getField("ROLE_ID");
    $reqPerusahaanId= $set->getField("PERUSAHAAN_EKSTERNAL_ID");
    $reqStatus= $set->getField("STATUS_AKTIF");
    $reqLinkFoto= $set->getField("FOTO");
    $reqExpiredDate= dateToPageCheck($set->getField("EXPIRED_DATE"));
    $reqPositionNama= $set->getField("JABATAN_INFO");
    // var_dump( $reqDistrik);exit;
    // print_r( $reqStatusAll);exit();
}   

$set= new Crud();
$arrHak= [];
$set->selectByParams(array(), -1,-1);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("PENGGUNA_HAK_ID");
    $arrdata["text"]= $set->getField("NAMA_HAK");
    array_push($arrHak, $arrdata);
}
unset($set);

$set= new RoleApproval();
$arrRoleAppr= [];
$set->selectByParams(array(), -1,-1);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("ROLE_ID");
    $arrdata["text"]= $set->getField("ROLE_NAMA");
    array_push($arrRoleAppr, $arrdata);
}
unset($set);

$set= new PenggunaEksternal();
$statement=" ";
$arreksternal= [];
$set->selectByParams(array(), 30,-1,$statement);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("PENGGUNA_EXTERNAL_ID");
    $arrdata["text"]= $set->getField("NID") .' - '. $set->getField("NAMA");
    array_push($arreksternal, $arrdata);
}
unset($set);

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
$readonly="";
$namareadonly="";



if($reqLihat ==1 )
{
    $disabled="disabled"; 
}

if($reqTipe ==1 ||  $reqTipe ==2)
{
    $readonly="disabled"; 
} 

if($reqTipe ==1)
{
    $namareadonly="readonly"; 
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
                        <label class="control-label col-md-2">Tipe</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <select class="form-control " id="reqTipe" <?=$disabled?> <?=$readonly?> name="reqTipe" style="width:100%;" >
                                        <option value="" >Pilih Tipe</option>
                                        <?
                                        if($reqTipe == 1 && !empty($reqId))
                                        {
                                        ?>
                                        <option value="1" <? if($reqTipe == 1) echo 'selected'?>>Internal</option>
                                        <?
                                        }
                                        // else
                                        // {
                                        ?>
                                        <option value="2" <? if($reqTipe == 2) echo 'selected'?>>Eksternal</option>
                                        <?
                                        // }
                                        ?>
                                        
                                    </select>
                                    <input autocomplete="off"type="hidden" name="reqTipeId"  id="reqTipeId" value="<?=$reqTipe?>"  style="width:100%;" />
                                </div>
                            </div>
                        </div>
                    </div>
                                                                             
                    <div class="form-group">  
                        <label class="control-label col-md-2">Username</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input autocomplete="new-password" <?=$disabled?>  data-options="required:true"  class="easyui-validatebox textbox form-control" type="text" name="reqUsername"  id="reqUsername" value="<?=$reqUsername?>"  style="width:100%" <?if($reqUsername){echo "readonly";}?> />
                                </div>
                            </div>
                        </div>
                    </div>

                    <?
                    if(empty($reqId))
                    {   
                    ?>
                    <div id="pass">
                        <div class="form-group">  
                            <label class="control-label col-md-2">Password</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                       <input autocomplete="new-password" <?=$disabled?>   data-options="required:true" class="easyui-validatebox textbox form-control" type="password" name="reqPass"  id="reqPass" value=""  style="width:100%" />
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
                    <?

                    }
                    ?>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Nama User</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input autocomplete="off" <?=$disabled?>  class="easyui-validatebox textbox form-control" type="text" name="reqNama"  id="reqNama"  <?=$namareadonly?> value="<?=$reqNama?>" style="width:100%" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Hak Akses Menu</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                <select class="form-control jscaribasicmultiple" id="reqHakAkses" <?=$disabled?> name="reqHakAkses[]" style="width:100%;" multiple="multiple">
                                    <?
                                    foreach($arrHak as $item) 
                                    {
                                        $selectvalid= $item["id"];
                                        $selectvaltext= $item["text"];

                                        $selected="";
                                        if(in_array($selectvalid, $reqHakAkses))
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

                   <!--  <div class="form-group" style="display: none">  
                        <label class="control-label col-md-2">Role Approval</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                  <input  name="reqRoleApprId" class="easyui-combobox form-control" id="reqRoleApprId"
                                  data-options="width:'300',editable:false,valueField:'id',textField:'text',url:'json-app/combo_json/comboroleappr'" value="<?=$reqRoleApprId?>"  <?=$disabled?>  />
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <!-- <div class="form-group" id="eksternal">  
                        <label class="control-label col-md-2">Pengguna Eksternal</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                               <div class='col-md-11'>
                                    <input type="hidden" name="reqPenggunaEksternalId" id="reqPenggunaEksternalId" value="<?=$reqPenggunaEksternalId?>" style="width:100%" />
                                    <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqPenggunaEksternalNama"  id="reqPenggunaEksternalNama" value="<?=$reqPenggunaEksternalNama?>" style="width:100%" readonly />
                                </div>
                                <div class="col-md-1">
                                    <a id="btnAdd" onclick="openEksternal()"><i class="fa fa-plus-square fa-lg" aria-hidden="true"></i> </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" id="internal">  
                        <label class="control-label col-md-2">Pengguna Internal</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <input type="hidden" name="reqInternalId" id="reqInternalId" value="<?=$reqInternalId?>" style="width:100%" />
                                    <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqInternalNama"  id="reqInternalNama" value="<?=$reqInternalNama?>" style="width:100%" readonly />
                                </div>
                                <?/*
                                if($reqLihat ==1 || $reqMode=="update")
                                {}
                                else
                                {
                                    ?>
                                <div class="col-md-1" id="btninternal">
                                    <a id="btnAdd" onclick="openInternal()"><i class="fa fa-plus-square fa-lg" aria-hidden="true"></i> </a>
                                </div>
                                    <?
                                }
                                */?>
                            </div>
                        </div>
                    </div> -->
                   <!--  <div id="jabatan" style="display: none">
                        <div class="form-group">  
                            <label class="control-label col-md-2">Jabatan</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                       <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqJabatan"  id="reqJabatan" value="<?=$reqJabatan?>"  style="width:100%" readonly />
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div >

                    <div class="form-group" style="display: none">  
                        <label class="control-label col-md-2">Distrik</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                <select class="form-control jscaribasicmultiple" id="reqDistrik" <?=$disabled?> name="reqDistrik[]" style="width:100%;" multiple="multiple">
                                    <?/*
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
                                    */?>
                                </select>
                                </div>
                            </div>
                        </div>
                    </div>
 -->
                    <div id="internal"> 
                        <div class="form-group">  
                            <label class="control-label col-md-2">NID</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                       <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqNid"  id="reqNid" value="<?=$reqNid?>" readonly style="width:100%" />
                                   </div>
                               </div>
                           </div>
                       </div>

                       <!--  <div class="form-group">  
                            <label class="control-label col-md-2">Nama Lengkap</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                         <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqNama" readonly id="reqNama" value="<?=$reqNama?>" style="width:100%" />
                                    </div>
                                </div>
                            </div>
                        </div> -->

                        <div class="form-group">  
                            <label class="control-label col-md-2">Email</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                       <input autocomplete="off" readonly class="easyui-validatebox textbox form-control" type="text" name="reqEmail"  id="reqEmail" value="<?=$reqEmail?>"  style="width:100%" />
                                   </div>
                               </div>
                           </div>
                       </div>


                        <div class="form-group">  
                            <label class="control-label col-md-2">Bagian</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                       <input autocomplete="off" readonly class="easyui-validatebox textbox form-control" type="text" name="reqBagian"  id="reqBagian" value="<?=$reqBagian?>"  style="width:100%" />
                                   </div>
                               </div>
                           </div>
                       </div>

                        <div class="form-group">  
                            <label class="control-label col-md-2">Ditbid</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                       <input autocomplete="off" readonly class="easyui-validatebox textbox form-control" type="text" name="reqDitbid"  id="reqDitbid" value="<?=$reqDitbid?>"  style="width:100%" />
                                   </div>
                               </div>
                           </div>
                       </div>

                        <div class="form-group">  
                            <label class="control-label col-md-2">Unit</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                       <input autocomplete="off" readonly class="easyui-validatebox textbox form-control" type="text" name="reqUnit"  id="reqUnit" value="<?=$reqUnit?>"  style="width:100%" />
                                   </div>
                               </div>
                           </div>
                       </div>
                    </div>
                    <div id ="eksternal">
                                                                                 
                        <div class="form-group">  
                            <label class="control-label col-md-2">NID</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                         <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" required name="reqNid"  id="reqNid" value="<?=$reqNid?>" style="width:100%" <?=$disabled?> />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="form-group">  
                            <label class="control-label col-md-2">Nama Lengkap</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                         <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqNama"  id="reqNama" value="<?=$reqNama?>" style="width:100%" <?=$disabled?>/>
                                    </div>
                                </div>
                            </div>
                        </div> -->

                        <div class="form-group">  
                            <label class="control-label col-md-2">No Telpon</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                         <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqNoTelpon"  id="reqNoTelpon" value="<?=$reqNoTelpon?>"  style="width:50%" <?=$disabled?>/>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">  
                            <label class="control-label col-md-2">Email</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                       <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqEmail"  id="reqEmail" value="<?=$reqEmail?>"  style="width:100%" <?=$disabled?>/>
                                   </div>
                               </div>
                           </div>
                       </div>

                        <div class="form-group">  
                            <label class="control-label col-md-2">Distrik</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                       <input   name="reqDistrikId" class="easyui-combobox form-control" id="reqDistrikId"
                                        data-options="width:'300',editable:false,valueField:'id',textField:'text',url:'json-app/Combo_json/combodistrik'" value="<?=$reqDistrikId?>"  <?=$disabled?>/>

                                   </div>
                               </div>
                           </div>
                       </div>

                       <div class="form-group">  
                            <label class="control-label col-md-2">Jabatan</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                      <input type="hidden" name="reqPositionId" id="reqPositionId" value="<?=$reqPositionId?>" style="width:100%" />
                                      <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqPositionNama"  id="reqPositionNama" value="<?=$reqPositionNama?>" style="width:60%" readonly />
                                      <a id="btnAdd" onclick="openJabatan()"><i class="fa fa-plus-square fa-lg" aria-hidden="true"></i>&nbsp; </a>
                                    </div>
                                      <!-- <a><input type="checkbox" id="reqSemuaPemeriksa" /> &nbsp;Semua Distrik</a> -->
                               </div>
                           </div>
                       </div>

                       <div class="form-group" style="display: none">  
                            <label class="control-label col-md-2">Role</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                     <select class="form-control jscaribasicmultiple" id="reqRoleId" <?=$disabled?> name="reqRoleId" style="width:300px;" >
                                        <?
                                        foreach($arrset as $item) 
                                        {
                                            $selectvalid= $item["id"];
                                            $selectvaltext= $item["text"];

                                            $selected="";
                                            if($selectvalid==$reqRoleId)
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

                        <div class="form-group">  
                            <label class="control-label col-md-2">Perusahaan</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                        <input   name="reqPerusahaanId" class="easyui-combobox form-control" id="reqPerusahaanId"
                                        data-options="width:'300',editable:false,valueField:'id',textField:'text',url:'json-app/Combo_json/comboperusahaan'" value="<?=$reqPerusahaanId?>"  <?=$disabled?>/>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">  
                            <label class="control-label col-md-2">Status</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                        <input   name="reqStatus" class="easyui-combobox form-control" id="reqStatus"
                                        data-options="width:'300',editable:false,valueField:'id',textField:'text',url:'json-app/Combo_json/combostatusaktifpengguna'" value="<?=$reqStatus?>" required <?=$disabled?>/>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">  
                                <label class="control-label col-md-2">Foto</label>
                                <div class='col-md-8'>
                                    <div class='form-group'>
                                        <div class='col-md-12'>
                                        <input type="file" name="reqLinkFoto" accept="image/*" <?=$disabled?>>
                                        <?
                                        if(!empty($reqLinkFoto))
                                        {
                                            ?>
                                            <a onclick="delete_gambar()"><img src="images/delete-icon.png"></a> 
                                            <br>
                                            <img src="<?=$reqLinkFoto?>" width=150 height=200>
                                            <?
                                        }
                                        ?>
                                       </div>
                                   </div>
                               </div>
                        </div>


                        <div class="form-group">  
                            <label class="control-label col-md-2">Expired Date</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                       <input autocomplete="off" class="easyui-datebox  form-control"  name="reqExpiredDate"  id="reqExpiredDate"  style="width:100%" value="<?=$reqExpiredDate?>" <?=$disabled?> />
                                    </div>
                                </div>
                           </div>
                        </div>
                    </div>



                    <input type="hidden" name="reqId" value="<?=$reqId?>" />
                    <input type="hidden" name="reqMode" value="<?=$reqMode?>" />

                </form>

            </div>
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
        </div>
    </div>
</div>

<script>

$(document).ready(function(){

    $(document).on("input", "#reqNoTelpon", function() {
        this.value = this.value.replace(/\D/g,'');
    });

    $('#check').click(function(){
        if ($("#reqPassword").attr("type") === "password" || $("#reqKonfirmasiPassword").attr("type") === "password" ) {
            $("#reqPassword").attr("type", "text");
            $("#reqKonfirmasiPassword").attr("type", "text");
        } else {
            $("#reqPassword").attr("type", "password");
            $("#reqKonfirmasiPassword").attr("type", "password");
        }
   });
    $('#reqDistrikId').combobox({
        onChange: function(value){
            $('#reqDistrikId').val(value);
            $('#reqPositionId').val('');
            $('#reqPositionNama').val('');

        }
    })

});

function openJabatan()
{
    
    var distrikid = $('#reqDistrikId').val();
    
   
    openAdd('app/index/lookup_jabatan?reqDistrikId='+distrikid);
}

function setJabatan(values)
{
    $('#reqPositionId').val(values.POSITION_ID);
    $('#reqPositionNama').val(values.NAMA_POSISI);
} 

var reqTipe= '<?=$reqTipe?>';
if(reqTipe==1)
{
    $('#internal').show();
    $('#eksternal').hide();
    $('#pass').hide();
    $('#reqPass').val("");
    $('#btninternal').show();
    $("#reqNama").attr("readonly", true); 
    $('#jabatan').hide();
    // $('#reqPass').val("");
    $('#reqUsername').prop('readonly', true);
    $('#reqUsername').prop('required', false);
}
else if(reqTipe==2)
{
    $('#eksternal').show();
    $('#internal').hide(); 
    $('#pass').show(); 
    // $('#reqPass').val("");
    $("#reqNama").attr("readonly", false); 
    $('#jabatan').hide();
    $('#reqUsername').prop('readonly', false);
}
else
{
    $('#eksternal').hide();
    $('#internal').hide(); 
    $('#pass').show();
    $("#reqNama").attr("readonly", false);
    $('#jabatan').hide();
    $('#reqUsername').prop('readonly', false);

}


$('#reqTipe').on('change', function() {
    var reqTipe= this.value;

    // console.log(reqTipe);

    if(reqTipe==1)
    {
        $('#internal').show();
        $('#eksternal').hide();
        $('#reqPenggunaEksternalId').val("");
        $('#reqPenggunaEksternalNama').val("");
        $('#pass').hide();
        $('#reqPass').val("");
        $('#btninternal').show();
        $("#reqNama").attr("readonly", true); 
        $('#jabatan').hide();
        $('#reqUsername').prop('readonly', true);
        $('#reqUsername').prop('required', false);

    }
    else if(reqTipe==2)
    {
        $('#eksternal').show();
        $('#internal').hide(); 
        $('#reqInternalId').val("");
        $('#reqInternalNama').val(""); 
        $('#pass').show();
        // $('#reqPass').val("");
        $("#reqNama").attr("readonly", false);
        $('#jabatan').hide(); 
        $('#reqUsername').prop('readonly', false);
    }
    else
    {
       $('#eksternal').hide();
       $('#internal').hide(); 
       $('#pass').show();
       $('#btninternal').hide();
       $("#reqNama").attr("readonly", false);
       $('#jabatan').hide(); 
       $('#reqUsername').prop('readonly', false);
    }

    $('#reqJabatan').val("");

});

if(reqTipe=="")
{
    $("#reqTipe").val("2").change();

}

function submitForm(){
    
    $('#ff').form('submit',{
        url:'json-app/pengguna_json/add',
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

function openEksternal()
{
    openAdd('app/index/lookup_user_eksternal');
}

function setEksternal(values)
{
    // console.log(values);
    $('#reqPenggunaEksternalId').val(values.PENGGUNA_EXTERNAL_ID);
    $('#reqPenggunaEksternalNama').val(values.NAMA);
    $('#reqNama').val(values.NAMA);
    $('#reqJabatan').val(values.JABATAN_INFO);
  

}

function openInternal()
{
    openAdd('app/index/lookup_user_internal');
}

function setInternal(values)
{
    // console.log(values);
    $('#reqUsername').val(values.NID);
    $('#reqInternalId').val(values.PENGGUNA_INTERNAL_ID);
    $('#reqInternalNama').val(values.NAMA_LENGKAP);
    $('#reqNama').val(values.NAMA_LENGKAP);
    $('#reqJabatan').val(values.NAMA_POSISI);   
}

function delete_gambar()
{
    $.messager.confirm('Konfirmasi',"Hapus gambar?",function(r){
        if (r){
            $.getJSON("json-app/pengguna_json/delete_gambar/?reqId=<?=$reqId?>",
                function(data){
                    $.messager.alert('Info', data.PESAN, 'info');
                    valinfoid= "";
                    location.reload();
                });
        }
    }); 
}






</script>