<?php
include_once("functions/string.func.php");
include_once("functions/date.func.php");
$this->load->model("base-app/Crud");
$this->load->model("base-app/Distrik");

$appuserkodehak= $this->appuserkodehak;

$reqTahun= $this->input->get("reqTahun");
$reqSelected= $this->input->get("reqSelected");
$reqDistrikId= $this->input->get("reqDistrikId");
$reqBlokId= $this->input->get("reqBlokId");
$reqUnitMesinId= $this->input->get("reqUnitMesinId");
$reqAssetNum= $this->input->get("reqAssetNum");


$pgreturn= str_replace("_add", "", $pg);

$pgtitle= $pg;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$arrtabledata= array(
    array("type"=>"text", "title"=> "Asset Num", "width"=>"200")
    ,array("type"=>"text", "title"=> "Asset Desc", "width"=>"100", "readOnly"=>true)
    ,array("type"=>"text", "title"=> "Work Order", "width"=>"100", "readOnly"=>true)
    ,array("type"=>"text", "title"=> "WO Description", "width"=>"200", "readOnly"=>true)
    ,array("type"=>"text", "title"=> "Work Type", "width"=>"100", "readOnly"=>true)
    ,array("type"=>"text", "title"=> "Job Plant ", "width"=>"100", "readOnly"=>true)
    ,array("type"=>"text", "title"=> "Need Downtime", "width"=>"100", "readOnly"=>true)
    ,array("type"=>"text", "title"=> "Reported Date", "width"=>"110", "readOnly"=>true)
    ,array("type"=>"numeric", "title"=> "Downtime", "width"=>"100",  "maxlength"=>1)
    ,array("type"=>"numeric", "title"=> "DOWN 0 & NOT OH", "width"=>"150", "maxlength"=>1)
    ,array("type"=>"text", "title"=> "On Hand Repair", "width"=>"140")
    ,array("type"=>"numeric", "title"=> "Labour", "width"=>"100","mask"=>"0")
    ,array("type"=>"checkbox", "title"=> "Status Validation", "width"=>"130")
    ,array("type"=>"hidden", "title"=> "bg", "width"=>"100")
    ,array("type"=>"hidden", "title"=> "bg", "width"=>"100")
    ,array("type"=>"hidden", "title"=> "bg", "width"=>"100")
    ,array("type"=>"hidden", "title"=> "bg", "width"=>"100")
    ,array("type"=>"hidden", "title"=> "bg", "width"=>"100")
);


$set= new Crud();
$statement=" AND KODE_MODUL ='0312'";
$kode= $appuserkodehak;
$set->selectByParamsMenus(array(), -1, -1, $statement, $kode);
// echo $set->query;exit;
$set->firstRow();
$reqMenu= $set->getField("MENU");
$reqCreate= $set->getField("MODUL_C");
$reqRead= $set->getField("MODUL_R");
$reqUpdate= $set->getField("MODUL_U");
$reqDelete= $set->getField("MODUL_D");

$set= new Distrik();
$arrdistrik= [];
$statement="  ";
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


?>
<script type="text/javascript" language="javascript" class="init">  
</script> 

<style type="text/css">



    .jexcel .invalid {
        background-color: #ff4c42;
    }

    .jexcel > tbody > tr > td.readonly {
        background-color: #F3F3F3;
        color: black !important;
    }

   
</style>

<style type="text/css">
    .loading {
      position: fixed;
      z-index: 999;
      height: 2em;
      width: 2em;
      overflow: show;
      margin: auto;
      top: 0;
      left:12%;
      bottom: 0;
      right: 0;
    }

    /* Transparent Overlay */
    .loading:before {
      content: '';
      display: block;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: radial-gradient(rgba(20, 20, 20,.8), rgba(0, 0, 0, .8));

      background: -webkit-radial-gradient(rgba(20, 20, 20,.8), rgba(0, 0, 0,.8));
    }

    /* :not(:required) hides these rules from IE9 and below */
    .loading:not(:required) {
      /* hide "loading..." text */
      font: 0/0 a;
      color: transparent;
      text-shadow: none;
      background-color: transparent;
      border: 0;
    }

    .loading:not(:required):after {
      content: '';
      display: block;
      font-size: 10px;
      width: 1em;
      height: 1em;
      margin-top: -0.5em;
      -webkit-animation: spinner 150ms infinite linear;
      -moz-animation: spinner 150ms infinite linear;
      -ms-animation: spinner 150ms infinite linear;
      -o-animation: spinner 150ms infinite linear;
      animation: spinner 150ms infinite linear;
      border-radius: 0.5em;
      -webkit-box-shadow: rgba(255,255,255, 0.75) 1.5em 0 0 0, rgba(255,255,255, 0.75) 1.1em 1.1em 0 0, rgba(255,255,255, 0.75) 0 1.5em 0 0, rgba(255,255,255, 0.75) -1.1em 1.1em 0 0, rgba(255,255,255, 0.75) -1.5em 0 0 0, rgba(255,255,255, 0.75) -1.1em -1.1em 0 0, rgba(255,255,255, 0.75) 0 -1.5em 0 0, rgba(255,255,255, 0.75) 1.1em -1.1em 0 0;
      box-shadow: rgba(255,255,255, 0.75) 1.5em 0 0 0, rgba(255,255,255, 0.75) 1.1em 1.1em 0 0, rgba(255,255,255, 0.75) 0 1.5em 0 0, rgba(255,255,255, 0.75) -1.1em 1.1em 0 0, rgba(255,255,255, 0.75) -1.5em 0 0 0, rgba(255,255,255, 0.75) -1.1em -1.1em 0 0, rgba(255,255,255, 0.75) 0 -1.5em 0 0, rgba(255,255,255, 0.75) 1.1em -1.1em 0 0;
    }

    /* Animation */

    @-webkit-keyframes spinner {
      0% {
        -webkit-transform: rotate(0deg);
        -moz-transform: rotate(0deg);
        -ms-transform: rotate(0deg);
        -o-transform: rotate(0deg);
        transform: rotate(0deg);
      }
      100% {
        -webkit-transform: rotate(360deg);
        -moz-transform: rotate(360deg);
        -ms-transform: rotate(360deg);
        -o-transform: rotate(360deg);
        transform: rotate(360deg);
      }
    }
    @-moz-keyframes spinner {
      0% {
        -webkit-transform: rotate(0deg);
        -moz-transform: rotate(0deg);
        -ms-transform: rotate(0deg);
        -o-transform: rotate(0deg);
        transform: rotate(0deg);
      }
      100% {
        -webkit-transform: rotate(360deg);
        -moz-transform: rotate(360deg);
        -ms-transform: rotate(360deg);
        -o-transform: rotate(360deg);
        transform: rotate(360deg);
      }
    }
    @-o-keyframes spinner {
      0% {
        -webkit-transform: rotate(0deg);
        -moz-transform: rotate(0deg);
        -ms-transform: rotate(0deg);
        -o-transform: rotate(0deg);
        transform: rotate(0deg);
      }
      100% {
        -webkit-transform: rotate(360deg);
        -moz-transform: rotate(360deg);
        -ms-transform: rotate(360deg);
        -o-transform: rotate(360deg);
        transform: rotate(360deg);
      }
    }
    @keyframes spinner {
      0% {
        -webkit-transform: rotate(0deg);
        -moz-transform: rotate(0deg);
        -ms-transform: rotate(0deg);
        -o-transform: rotate(0deg);
        transform: rotate(0deg);
      }
      100% {
        -webkit-transform: rotate(360deg);
        -moz-transform: rotate(360deg);
        -ms-transform: rotate(360deg);
        -o-transform: rotate(360deg);
        transform: rotate(360deg);
      }
    }
  </style>
    <style type="text/css">
        .konten-area  .jexcel_container .jexcel_content {
            /*border: 2px solid red;*/
            max-width: 100%;
            width: 100% !important;
        }
        table.jexcel.jexcel_overflow {
            width: 100% !important;
        }
    </style>



<!-- FIXED AKSI AREA WHEN SCROLLING -->
<link rel="stylesheet" href="css/gaya-stick-when-scroll.css" type="text/css">
<script src="assets/js/stick.js" type="text/javascript"></script>

<style>
    thead.stick-datatable th:nth-child(1){  width:440px !important; *border:1px solid cyan;}
    thead.stick-datatable ~ tbody td:nth-child(1){  width:440px !important; *border:1px solid yellow;}
</style>

<div class="col-md-12">
    <div class="judul-halaman"> Data  Work Order</div>
        <div class="konten-area ">
            <div class="page-header"><h3><i class="fa fa-file-text fa-lg"></i> Work Order</h3></div>

            <div id="bluemenu" class="aksi-area">
                <?
                if($reqCreate ==1)
                {
                    ?>
                    <?   
                }
                if($reqUpdate ==1)
                {
                    ?>
                   
                    <?
                }
                if($reqRead ==1)
                {
                    ?>
                    <?
                }
                if($reqDelete ==1)
                {
                    ?>            
                    <!-- <span><a id="btnDeleteNew"><i class="fa fa-times-rectangle fa-lg" aria-hidden="true"></i>Hapus</a></span> -->
                    <?
                }
                if($reqCreate ==1)
                {
                    ?>
                    <!-- <span><a id="btnImport"><i class="fa fa-file-excel-o fa-lg" aria-hidden="true"></i> Import</a></span> -->
                    <?
                }
                ?>
                <span><a id="btnKembali"><i class="fa fa-arrow-left fa-lg" aria-hidden="true"></i> Kembali</a></span>
                <span><a id="btnUpdate"><i class="fa fa-edit fa-lg" aria-hidden="true"></i> Bulk Update</a></span>
                <span id="detaildata" style="display: none"><a id="btnDetail"><i class="fas fa-database"></i>Detail Data</a></span>

                

            </div>
            <div class="form-group" style="display: none">  
                <label class="control-label col-md-1">Status Valid </label>
                <div class='col-md-2'>
                    <select class="form-control jscaribasicmultiple"  <?=$readonly?> required id="reqStatus" <?=$disabled?> name="reqStatus"  style="width:100%;" >
                        <option value="all" >All</option>
                        <option value="CLOSE" <?=$reqSelected?> >Valid</option>
                        <option value="" >Tidak Valid</option>
                    </select>
                </div>
            </div>
             <div class="area-filter">
                 
             </div>
             <!-- <div class="loading" id='vlsxloading' >Loading&#8230;</div> -->

            <div id="spreadsheet"   style="width: 100%;height: 100%"></div>

            <form id="ff" class="easyui-form form-horizontal" method="post" novalidate enctype="multipart/form-data">
                <input type="hidden" id="reqArrValue" name="reqArrValue" value="" />
                <input type="hidden" id="reqArrValueBefore" name="reqArrValueBefore" value="" />
                <input type="hidden" id="reqTahun" name="reqTahun" value="<?=$reqTahun?>" />
                <input type="hidden" id="checkubah"  value="" />
            </form>

            
        </div>
</div>

<a href="#" id="triggercari" style="display:none" title="triggercari">triggercari</a>
<a href="#" id="btnCari" style="display: none;" title="Cari"></a>

<script>
$("#btnKembali").on("click", function () {

    // varurl= "app/index/work_order_validasi?reqTahun=<?=$reqTahun?>&reqDistrikId=<?=$reqDistrikId?>&reqBlokId=<?=$reqBlokId?>&reqUnitMesinId=<?=$reqUnitMesinId?>&reqAssetNum=<?=$reqAssetNum?>";
    varurl= "app/index/work_order";
    document.location.href = varurl;
});


$('#reqStatus').on('change', function() {
    var reqStatus= this.value;
    jexcel.destroy(document.getElementById('spreadsheet'));
    jexcelcall(reqStatus);
});


$(document).ready(function(){  
  jexcelcall('');

});


function jexcelcall(reqStatus)
{

    var arrdata= <?php echo json_encode($arrtabledata); ?>;
    var arrvalue = new Array();

    var changecheck=0;
    var onchanged = function(instance, cell, x, y, value) {
        var data = $('#spreadsheet').jexcel('getData', false);
        var val2=table1.getRowData([y]);
        arrvalue.push(val2);
        // console.log(val2);
        $("#checkubah").val(1);
        // cell.style.backgroundColor = '#ffffff';

        txt = cell.innerText;

        var cellName = jexcel.getColumnNameFromId([x,y]);
        var setdown0 = jexcel.getColumnNameFromId([9,y]);
        var setlabor = jexcel.getColumnNameFromId([11,y]);
        var validdowntime =table1.getValueFromCoords([8], [y]);
        var worktype =table1.getValueFromCoords([4], [y]);
        var jpnum =table1.getValueFromCoords([17], [y]);
        var down0 =table1.getValueFromCoords([9], [y]);
        var labor =table1.getValueFromCoords([11], [y]);

        var txt0="";
         


        if(x==8 )
        {
            if(txt==1 || txt==0)
            {
              
                table1.ignoreEvents = true;
                table1.setStyle(cellName, 'background-color', 'white');
                table1.ignoreEvents = false;
            }
            else
            {
                table1.ignoreEvents = true;
                // table1.setStyle(cellName, 'background-color', 'white');
                table1.setValue(cellName, '');
                table1.ignoreEvents = false;
            } 

                // console.log();
                // rumus down 0 not start
                status_not_oh_not="";
                if(validdowntime=="0" && worktype=="OH" && jpnum=="")
                {
                    status_not_oh_not="0-1";
                }
                else if(validdowntime=="0" && worktype!=="OH" )
                {
                    status_not_oh_not="1-1";
                }
                else 
                {
                    
                    table1.ignoreEvents = true;
                    table1.setStyle(setdown0, 'background-color', 'white');
                    table1.ignoreEvents = false;
                }


                txtcheck = status_not_oh_not.split('-');
                txt0=txtcheck[0];
                txt1=txtcheck[1];
                table1.ignoreEvents = true;

                if(txt0)
                {
                    if(txt1==1)
                    {
                       table1.setStyle(setdown0, 'background-color', '#35f82f');
                    }
                    if(txt1=="0")
                    {
                        table1.setStyle(setdown0, 'background-color', '#35f82f');
                    }
                    // console.log(txt0);
                    table1.setValue(setdown0, txt0);
                }
               
                table1.ignoreEvents = false;
                // rumus down 0 not end
               
                if(validdowntime=="1" && (labor == "0"   ||  labor==""))
                {

                    table1.ignoreEvents = true;
                    if( txt>="0")
                    {}
                    {
                        table1.setValue(setlabor, labor);
                    }
                    table1.setStyle(setlabor, 'background-color', '#f5f82f');
                    
                    table1.ignoreEvents = false;
                }
                else
                {
                    table1.ignoreEvents = true;
                    table1.setStyle(setlabor, 'background-color', 'white');
                    table1.ignoreEvents = false;

                }
            
        }

         changecheck=1;

        getnilai(arrvalue);
    }

    function getnilai(arrvalue)
    {
        var arrvalue = JSON.stringify(arrvalue);

        $("#reqArrValue").val(arrvalue);

        // console.log(arrvalue);
    }

    function getnilaibefore(arrvalue)
    {
        var arrvalue = JSON.stringify(arrvalue);

        $("#reqArrValueBefore").val(arrvalue);

        // console.log(arrvalue);
    }

    var arrvaluebefore = new Array();


    var beforeChange = function(instance, cell, x, y, value) {

       var val2=table1.getRowData([y]);
       arrvaluebefore.push(val2);
       getnilaibefore(arrvaluebefore);

    }

    var selectionActive = function(instance, x1, y1, x2, y2, origin) {

        var cellName = jspreadsheet.getColumnNameFromId([x1, y1]);
        var cellVal =table1.getValueFromCoords([x1], [y1]);

        txta = cellVal;


        if(x1==2 )
        {
            $("#detaildata").show();

            detaildatawo(txta);
        }
        else
        {
           $("#detaildata").hide();
        }
       

        if(x1==8 || x1==9 || x1==10)
        {

            if (x1 == 8 || x1 == 9 || x1 == 10)
            {
               
                // txtcheck=txtcheck[1];
               
                // if(txtcheck==1)
                // {
                //   table1.ignoreEvents = true;
                //   table1.setStyle(cellName, 'background-color', 'white');
                //   table1.ignoreEvents = false;
                // }

                table1.ignoreEvents = true;
                check = txta.split('-');
                // console.log(check);
                table1.setValue(cellName,  check[0]);
                table1.ignoreEvents = false;

            }
            if(txt==1 || txt=="0")
            {
                // console.log(txt);
                // table1.ignoreEvents = true;
                // table1.setValue(cellName, '');
                // table1.ignoreEvents = false;
            }
            else
            {
                // table1.ignoreEvents = true;
                // table1.setValue(cellName, '');
                // table1.ignoreEvents = false;
            } 
        }

    }

    function detaildatawo(data)
    {

        $("#btnDetail").on("click", function () {

            openAdd('iframe/index/detail_wo?reqWoNum='+data);

        });

        

        // console.log(arrvalue);
    }

    var loaded = function(instance) {

        // $('#vlsxloading').hide();
    }


    var reqStatus= $("#reqStatus").val();
    var txtcheck="";
   
    var rowcheck=0;
    var table1 = jspreadsheet(document.getElementById('spreadsheet'), {
        // data:data,
        minDimension:[20,20],
        url: 'json-app/work_order_json/jsonjexcel?reqTahun=<?=$reqTahun?>&reqDistrikId=<?=$reqDistrikId?>&reqBlokId=<?=$reqBlokId?>&reqUnitMesinId=<?=$reqUnitMesinId?>&reqAssetNum=<?=$reqAssetNum?>&reqStatus='+reqStatus,
        search:true,
        pagination:25,
        paginationOptions: [10,25,50,100],
        columns: arrdata,
        defaultColWidth: 100,
        tableOverflow: true,
        tableWidth: "1200px",
        tableHeight: "600px",
        rowResize:true,
        filters: true,
        allowInsertColumn: false,
        allowManualInsertColumn: false,
        allowDeleteColumn: false,
        allowRenameColumn: false,
        onchange:onchanged,
        onbeforechange: beforeChange,
        columnResize: true,
        onselection: selectionActive,
        onload: loaded,
        // lazyLoading:true,
        loadingSpin:true,
        oncreateeditor: function(el, cell, x, y) {
           if (x == 8 || x == 9) {
            var config = el.jexcel.options.columns[x].maxlength;
            cell.children[0].setAttribute('maxlength' , config);
         }
       },
        updateTable:function(instance, cell, col, row, val, label, cellName) {
            // Number formating
            // console.log(col+' - '+cellName);

            if(changecheck==1)
            {}
            else
            {
                if (col == 8) {
                    // Get text
                    txt = cell.innerText;
                    // console.log(txt);
                    var numtxt=txt.replace(/[^0-1]/g, '');
                    $(cell).html(numtxt);
                   
                    txtcheck = txt.split('-');
                    txt0=txtcheck[0];
                    txt1=txtcheck[1];
                   
                    if(txt1==1)
                    {
                        cell.style.backgroundColor = '#35f82f';
                    }
                    if(txt1=="0")
                    {
                       cell.style.backgroundColor = '#f5f82f';
                    }

                    cell.innerHTML = txt0;
                }

                if (col == 9)
                {
                    // Get text
                    txt = cell.innerText;
                    var numtxt=txt.replace(/[^0-1]/g, '');
                    $(cell).html(numtxt);
                    txtcheck = txt.split('-');
                    txt0=txtcheck[0];
                    txt1=txtcheck[1];
                    // console.log(txt1);
                    // console.log(txt);
                    if(txt1==1)
                    {
                        cell.style.backgroundColor = '#35f82f';
                    }
                    if(txt1=="0")
                    {
                         cell.style.backgroundColor = '#35f82f';
                    }
                    cell.innerHTML = txt0;

                    // cell.innerHTML = null;
                }

                if (col == 10)
                {
                    txt = cell.innerText;
                   
                    txtcheck = txt.split('-');
                    txt0=txtcheck[0];
                    txt1=txtcheck[1];
                    // console.log(txtcheck);

                    if(txt1=="1")
                    {
                         cell.style.backgroundColor = '#35f82f';
                    }
                    if(txt1=="0")
                    {
                         cell.style.backgroundColor = '#f5f82f';
                    }

                    cell.innerHTML = txt0;
                }

                if (col == 11)
                {
                    txt = cell.innerText;
                    // console.log(txt);
                    if(txt=="xxx" || txt=="" || txt=="0" )
                    {
                        if( txt>="0"){}
                        else
                        {
                                 cell.innerHTML = '';
                        }
                       
                        cell.style.backgroundColor = '#f5f82f';
                    }
                }

            }
            
     
           
        }
    });
}



 $("#btnUpdate").on("click", function () {

        var checkubah=$("#checkubah").val();
        if(checkubah == "" )
        {
            $.messager.alert('Info', "Ubah salah satu data terlebih dahulu.", 'warning');
            return false;
        }

        $('#ff').form('submit',{
            url:'json-app/work_order_json/addvalidasi',
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
                    $.messager.alertLink('Info', infoSimpan, 'info', "app/index/<?=$pgreturn?>?reqTahun=<?=$reqTahun?>&reqDistrikId=<?=$reqDistrikId?>&reqBlokId=<?=$reqBlokId?>&reqUnitMesinId=<?=$reqUnitMesinId?>&reqAssetNum=<?=$reqAssetNum?>&reqSelected=selected");
            }
        });
       
        
});





</script>

