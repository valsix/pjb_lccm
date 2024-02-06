<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");
$pgtitle= $pg;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

?>


<div class="col-md-12">

    <div class="judul-halaman"> Data <?=$pgtitle?></div>
    
    <div class="konten-area">
        <div id="bluemenu" class="aksi-area">
            <!-- <span><a id="btnAdd"><i class="fa fa-plus-square fa-lg" aria-hidden="true"></i> Tambah</a></span>
            <span><a id="btnImport"><i class="fa fa-file-excel-o  fa-lg" aria-hidden="true"></i> Import Parent Eksternal</a></span>
            <span><a id="btnGenerate"><i class="fa fa-refresh  fa-lg" aria-hidden="true"></i> Generate</a></span> -->
            <span><a id="btnRefresh"><i class="fa fa-refresh  fa-lg" aria-hidden="true"></i> Refresh</a></span>

        </div>

        <div class="area-filter">
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div class="area-tabel-rekap-pemenuhan-ftk"> 
                    <div class="inner">
                        <table id="tt" class="easyui-treegrid"
                            data-options=
                            "
                                url: 'json-app/hirarki_perusahaan_json/tree'
                                , rownumbers: false
                                , pagination: false
                                // , height: 'auto'
                                , idField: 'ID'
                                , treeField: 'NAMA'
                                , onSelect:function(node){
                                    // console.log(node);
                                    selectedNodeId = node.ID;
                                    //console.log(selectedNodeId);
                                }
                                , onLoadSuccess: function(row, data){
                                }
                                , onBeforeLoad: function(row,param){
                                    if (!row) {
                                        param.id = 0;
                                    }
                                }
                            " style="width:100%;height:470px">
                            <thead>
                                <tr>
                                    <!-- <th data-options="field:'ID'" width="100">Kode Jabatan</th> -->
                                    <th data-options="field:'NAMA'" width="1500">Nama</th>
                                    <!-- <th field="LINK_URL_INFO" width="90" align="center">Aksi</th> -->
                                </tr>
                            </thead>
                            
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    
</div>

<script type="text/javascript">

var reloadunit= "";
$(function(){

    $('#btnRefresh').on('click', function () {

        $('#tt').treegrid({
            url: 'json-app/hirarki_perusahaan_json/tree'
            , rownumbers: false
            , pagination: false
            , idField: 'ID'
            , treeField: 'NAMA'
            , onSelect:function(node){
                selectedNodeId = node.ID;
            }
            , onLoadSuccess: function(row, data){
            }
            , onBeforeLoad: function(row,param){
                if (!row) {
                    param.id = 0;
                }
            }
        });
    });
 
});

function openurl(varurl)
{
    document.location.href = varurl;
}

function delete_detail(valinfoid)
{
    if(valinfoid == "")
        return false; 

    $.messager.confirm('Konfirmasi',"Hapus data terpilih?",function(r){
        if (r){
            $.getJSON("json-app/hirarki_perusahaan_json/delete/?reqId="+valinfoid,
                function(data){
                    $.messager.alert('Info', data.PESAN, 'info');
                    location.reload();
                });

        }
    }); 
}

function import_child(valinfoid)
{
    if(valinfoid == "")
        return false; 

    openAdd("app/index/master_jabatan_import?reqMode=anak&reqSuperiorId="+valinfoid);
}

</script>