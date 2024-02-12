var ajaxserverselectsingle = function() {
    var cekreturn = function(checkvaldata) {
        valreturn= true;
        if(checkvaldata == "1")
            valreturn= false;

        return valreturn;
    };

    var initdynamistable = function(valtableid, valjsonurl, valarrdata, valgroup,valstatus) {
        // console.log(valstatus);
        if(typeof datadefaultorder == "undefined")
        {
            datadefaultorder= 2;
        }
        infodefaultorder= datadefaultorder;
        // console.log(infodefaultorder);

        if(typeof datastateduration == "undefined")
        {
            // Set state duration to 1 day
            datastateduration= 60 * 60 * 24;
        }
        infostateduration= datastateduration;

        infocolumnsdef= [];
        infocolumns= [];
        infotargets= [];
        valarrdata.forEach(function (item, index) {
            infofield= item["field"];
            infodisplay= item["display"];
            infowidth= item["width"];

            infocolumnsdef.push(infofield);

            setdisplay= true;
            if(infodisplay == "1")
            {
                infotargets.push(index);
                setdisplay= false;
            }



            var infodetil= {};
            infodetil.data= infofield;
            infodetil.visible= setdisplay;
            if(infowidth)
            {
               infodetil.width= infowidth;
            }
           
            infocolumns.push(infodetil);
        });
        infogroupfield= valarrdata[0]["field"];
        // console.log(valarrdata[0]["field"]);
        // console.log(infocolumns);
        // console.log(infotargets);
        // console.log(infocolumnsdef);

        if(typeof dataaligncenter == "undefined" || dataaligncenter == "")
        {
            indexLastColumn= 0;
        }
        else
        {
             var indexLastColumn = $("#example").find('tr')[0].cells.length-dataaligncenter;
        }

       

        var valorderdefault= valarrdata.length - infodefaultorder;
        var table; var groupColumn = valorderdefault;
        var collapsedGroups = {};
        datanewtable= $('#'+valtableid);

        if(typeof datainforesponsive == "undefined")
        {
            datainforesponsive= "";
        }
        inforesponsive= cekreturn(datainforesponsive);

        if(typeof datainfostatesave == "undefined")
        {
            // datainfostatesave= "1";
            datainfostatesave= "";
        }
        infostatesave= cekreturn(datainfostatesave);

        if(typeof carijenis == "undefined" || carijenis == "")
        {
            carijenis= "1";
        }

        if(typeof datainfoscrollx == "undefined")
        {
            datainfoscrollx= "";
        }
        infoscrollx= cekreturn(datainfoscrollx);

        if(typeof datapagelength == "undefined")
        {
            pagelength= 10;
        }
        else
        {
            pagelength= datapagelength;
        }

        if(typeof datalengthmenu == "undefined")
        {
            lengthmenu= [ [10, 20, 50, -1], [10, 20, 50, "All"] ];
        }
        else
        {
            lengthmenu= datalengthmenu;
        }


        if(valgroup == "1")
        {
            // console.log(infogroupfield);
            table= datanewtable.DataTable({
                bLengthChange : true
                // , bInfo : false 
                , pageLength: pagelength
                , responsive: inforesponsive
                , "scrollY": infoscrolly+"vh"
                , "scrollX": infoscrollx
                , "stateSave": infostatesave
                , "stateDuration": infostateduration
                // , responsive: true
                // , searchDelay: 500
                , processing: true
                , serverSide: true
                , rowGroup: {
                    className: 'table-group',
                    dataSrc: infogroupfield,
                    startRender: function ( rows, group ) {
                        var collapsed = !!collapsedGroups[group];
                        rows.nodes().each(function (r) {
                            r.style.display = collapsed ? 'none' : '';
                        });
                        return $('<tr/>')
                            .append('<td colspan="'+valarrdata.length+'">' + group + '</td>')
                            // .append('<td colspan="'+valarrdata.length+'">' + group + ' (' + rows.count() + ')</td>')
                            .attr('data-name', group)
                            .toggleClass('collapsed', collapsed);
                      },
                }
                , order: [[ valorderdefault, "desc" ]]
                , columnDefs: [
                    { className: 'never', targets: infotargets }
                ]

                , ajax: 
                {
                    url: valjsonurl
                    , type: 'POST'
                    , data: {columnsDef: infocolumnsdef},
                }
                , columns: infocolumns
                , "fnDrawCallback": function( oSettings ) {
                    $('#'+infotableid+'_filter input').unbind();
                    $('#'+infotableid+'_filter input').bind('keyup', function(e) {
                        if(e.keyCode == 13) {
                            // carijenis= "1";
                            calltriggercari();
                        }
                    });

                    reloadglobalklikcheck();
                }
                , "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                    // console.log(aData);
                    /*var valueStyle= loopIndex= "";
                    valueStyle= nRow % 2;
                    loopIndex= 6;
                    
                    if( aData[7] == '1')
                    {
                        $($(nRow).children()).attr('class', 'hukumanstyle');
                    }
                    else if( aData[7] == '2')
                    {
                        $($(nRow).children()).attr('class', 'hukumanpernahstyle');
                    }*/
                    
                    // $($(nRow).children()).attr('class', 'warnatandamerah');
                }

            });

            $('#'+valtableid+' tbody').on('click', 'tr.dtrg-start', function() {
                var name = $(this).data('name');
                collapsedGroups[name] = !collapsedGroups[name];
                table.draw(false);
            });
        }
        else
        {
            table= datanewtable.DataTable({
                bLengthChange : true
                // , bInfo : false 
                , pageLength: pagelength
                , lengthMenu: lengthmenu
                // , sScrollX: 100,
                // , sScrollXInner: 100
                , "scrollY": infoscrolly+"vh"
                , "scrollX": infoscrollx
                , "stateSave": infostatesave
                , "stateDuration": infostateduration
                , responsive: inforesponsive
                // , searchDelay: 500
                , processing: true
                , serverSide: true
                , order: []
                // , order: [[ valorderdefault, "desc" ]]
                , columnDefs: [
                    { className: 'never', targets: infotargets },
                    { className: 'text-center', targets: [0,indexLastColumn] },
                    { className: 'dt-center', targets: "_all" },
                    { "orderable": false, "targets": 0 },
                     // {"className": "dt-center", "targets": "_all"}
                    // {targets: 2,className: "text-center"},
                ]
                , ajax: 
                {
                    url: valjsonurl
                    , type: 'POST'
                    , data: {columnsDef: infocolumnsdef},
                }
                , columns: infocolumns
                , orderCellsTop: true
                , fixedHeader: true
                , "fnDrawCallback": function( oSettings ) {
                    $('#'+infotableid+'_filter input').unbind();
                    $('#'+infotableid+'_filter input').bind('keyup', function(e) {
                        if(e.keyCode == 13) {
                            // carijenis= "1";
                            calltriggercari();
                        }
                    });

                    reloadglobalklikcheck();
                }
                , "createdRow": function (row, data, dataIndex) {
                    if (data["KODE_WARNA"] !== '') {
                        $('td:eq(2)', row).css('background-color', '#'+data["KODE_WARNA"]);
                    }
                }
                , "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                    // console.log(aData);
                    // console.log(infocolor);
                    color= bold= "";
                    if(typeof infobold == "undefined"){}
                    else
                    {
                        vbold= aData[valarrdata[infobold]["field"]];
                        bold= "bold";
                        if(vbold == "1")
                        {
                            bold= "";
                        }
                    }

                    if(aData["KODE_WARNA"] == "" || aData["KODE_WARNA"] == "undefined"  )
                    {
                        if(typeof infocolor == "undefined"){}
                            else
                            {
                                vcolor= aData[valarrdata[infocolor]["field"]];
                                if( vcolor == 'Rahasia')
                                {
                                    color= "fdd6d6";
                                }
                                else if( vcolor == 'Sangat Segera')
                                {
                                    color= "ffeeba";
                                }
                                else if( vcolor == 'Segera')
                                {
                                    color= "b4ebff";
                                }
                            }
                        $($(nRow).children()).attr('style', 'font-weight:'+bold+'; background-color:#'+color);
                    }

                    if(aData["WO_CR_INFO"] || aData["WO_STANDING_INFO"] || aData["WO_PM_INFO"] || aData["WO_PDM_INFO"] || aData["WO_OH_INFO"] || aData["PRK_INFO"]
                     || aData["LOSS_OUTPUT_INFO"] || aData["ENERGY_PRICE_INFO"] || aData["OPERATION_INFO"] || aData["STATUS_COMPLETE_INFO"])
                    {

                        if(typeof infocolor == "undefined"){}
                            else
                            {

                                if(aData["WO_CR_INFO"])
                                {
                                    infocolor = 2;
                                    kolom= infocolor;
                                    vcolor= aData[valarrdata[infocolor]["field"]];
                                    if( vcolor == '&#10004')
                                    {
                                        color= "35f82f";
                                    }
                                    else  
                                    {
                                        color= "f5f82f";
                                    }
                                    $(nRow).find('td:eq('+kolom+')').attr('style', 'font-weight:'+bold+'; background-color:#'+color);
                                }
                                if(aData["WO_STANDING_INFO"])
                                {
                                    infocolor = 3;
                                    kolom= infocolor;
                                    vcolor= aData[valarrdata[infocolor]["field"]];
                                    if( vcolor == '&#10004')
                                    {
                                        color= "35f82f";
                                    }
                                    else  
                                    {
                                        color= "f5f82f";
                                    }
                                     console.log(infocolor);
                                    $(nRow).find('td:eq('+kolom+')').attr('style', 'font-weight:'+bold+'; background-color:#'+color);
                                }
                                if(aData["WO_PM_INFO"])
                                {
                                    infocolor = 4;
                                    kolom= infocolor;
                                    vcolor= aData[valarrdata[infocolor]["field"]];
                                    if( vcolor == '&#10004')
                                    {
                                        color= "35f82f";
                                    }
                                    else  
                                    {
                                        color= "f5f82f";
                                    }
                                    $(nRow).find('td:eq('+kolom+')').attr('style', 'font-weight:'+bold+'; background-color:#'+color);
                                }
                                if(aData["WO_PDM_INFO"])
                                {
                                    infocolor = 5;
                                    kolom= infocolor;
                                    vcolor= aData[valarrdata[infocolor]["field"]];
                                    if( vcolor == '&#10004')
                                    {
                                        color= "35f82f";
                                    }
                                    else  
                                    {
                                        color= "f5f82f";
                                    }
                                    $(nRow).find('td:eq('+kolom+')').attr('style', 'font-weight:'+bold+'; background-color:#'+color);
                                }
                                if(aData["WO_OH_INFO"])
                                {
                                    infocolor = 6;
                                    kolom= infocolor;
                                    vcolor= aData[valarrdata[infocolor]["field"]];
                                    if( vcolor == '&#10004')
                                    {
                                        color= "35f82f";
                                    }
                                    else  
                                    {
                                        color= "f5f82f";
                                    }
                                    $(nRow).find('td:eq('+kolom+')').attr('style', 'font-weight:'+bold+'; background-color:#'+color);
                                }
                                if(aData["PRK_INFO"])
                                {
                                    infocolor = 7;
                                    kolom= infocolor;
                                    vcolor= aData[valarrdata[infocolor]["field"]];
                                    if( vcolor == '&#10004')
                                    {
                                        color= "35f82f";
                                    }
                                    else  
                                    {
                                        color= "f5f82f";
                                    }
                                    $(nRow).find('td:eq('+kolom+')').attr('style', 'font-weight:'+bold+'; background-color:#'+color);
                                }
                                if(aData["LOSS_OUTPUT_INFO"])
                                {
                                    infocolor = 8;
                                    kolom= infocolor;
                                    vcolor= aData[valarrdata[infocolor]["field"]];
                                    if( vcolor == '&#10004')
                                    {
                                        color= "35f82f";
                                    }
                                    else  
                                    {
                                        color= "f5f82f";
                                    }
                                    $(nRow).find('td:eq('+kolom+')').attr('style', 'font-weight:'+bold+'; background-color:#'+color);
                                }
                                if(aData["ENERGY_PRICE_INFO"])
                                {
                                    infocolor = 9;
                                    kolom= infocolor;
                                    vcolor= aData[valarrdata[infocolor]["field"]];
                                    if( vcolor == '&#10004')
                                    {
                                        color= "35f82f";
                                    }
                                    else  
                                    {
                                        color= "f5f82f";
                                    }
                                    $(nRow).find('td:eq('+kolom+')').attr('style', 'font-weight:'+bold+'; background-color:#'+color);
                                }
                                if(aData["OPERATION_INFO"])
                                {
                                    infocolor = 10;
                                    kolom= infocolor;
                                    vcolor= aData[valarrdata[infocolor]["field"]];
                                    if( vcolor == '&#10004')
                                    {
                                        color= "35f82f";
                                    }
                                    else  
                                    {
                                        color= "f5f82f";
                                    }
                                    $(nRow).find('td:eq('+kolom+')').attr('style', 'font-weight:'+bold+'; background-color:#'+color);
                                }
                                if(aData["STATUS_COMPLETE_INFO"])
                                {
                                    infocolor = 11;
                                    kolom= infocolor;
                                    vcolor= aData[valarrdata[infocolor]["field"]];
                                    if( vcolor == '&#10004')
                                    {
                                        color= "35f82f";
                                    }
                                    else  
                                    {
                                        color= "f5f82f";
                                    }
                                    $(nRow).find('td:eq('+kolom+')').attr('style', 'font-weight:'+bold+'; background-color:#'+color);
                                }

                               
                                
                            }
                        //     kolom= infocolor;
                        // // $($(nRow).children()).attr('style', 'font-weight:'+bold+'; background-color:#'+color);
                        // $(nRow).find('td:eq('+kolom+')').attr('style', 'font-weight:'+bold+'; background-color:#'+color);
            
                    }

                    // if(aData["ON_HAND_INFO"])
                    // {

                    //     if(typeof infocoloron == "undefined"){}
                    //         else
                    //         {
                    //             vcolor= aData[valarrdata[infocoloron]["field"]];
                    //             // console.log(vcolor);
                    //             if( vcolor == 'f')
                    //             {
                    //                 color= "f5f82f ";
                    //             }
                    //             else  
                    //             {
                    //                 color= "35f82f";
                    //             }
                                
                    //         }
                    //         kolom= infocoloron-1;
                    //     // $($(nRow).children()).attr('style', 'font-weight:'+bold+'; background-color:#'+color);
                    //     $(nRow).find('td:eq('+kolom+')').attr('style', 'font-weight:'+bold+'; background-color:#'+color);
            
                    // }

                    // if(aData["LABOUR_INFO"])
                    // {

                    //     if(typeof infocoloron == "undefined"){}
                    //         else
                    //         {
                    //             vcolor= aData[valarrdata[infocolorlab]["field"]];
                    //             // console.log(vcolor);
                    //             if( vcolor == '0')
                    //             {
                    //                 color= "f5f82f ";
                    //             }
                    //             else  
                    //             {
                    //                 color= "";
                    //             }
                                
                    //         }
                    //         kolom= infocolorlab-1;
                    //     // $($(nRow).children()).attr('style', 'font-weight:'+bold+'; background-color:#'+color);
                    //     $(nRow).find('td:eq('+kolom+')').attr('style', 'font-weight:'+bold+'; background-color:#'+color);
            
                    // }

                    var index = iDisplayIndex +1;
                    //buat nomor
                    // $('td:eq(0)',nRow).html(index);
                    // console.log(nRow);
                    return nRow;
                    
                },
                initComplete: function () 
                {
                    var api = this.api();
                    // For each column
                    api.columns().eq(0).each(function(colIdx) {
                        // Set the header cell to contain the input element
                        var cell = $('.filters th').eq($(api.column(colIdx).header()).index());
                        var title = $(cell).text();

                        if(title !== "Pilih")
                        {
                            if ($(api.column(colIdx).header()).index() >= 0) {
                               $(cell).html('<input type="text" style="color: #000000;" placeholder="' + title + '"/>');
                            }
                            // On every keypress in this input
                            $('input', $('.filters th').eq($(api.column(colIdx).header()).index()) )
                                .off('keyup change')
                                .on('keyup change', function (e) {
                                    e.stopPropagation();
                                    // Get the search value
                                    $(this).attr('title', $(this).val());
                                    var regexr = '({search})'; //$(this).parents('th').find('select').val();
                                    var cursorPosition = this.selectionStart;
                                    // Search the column for that value
                                    api
                                    .column(colIdx)
                                    .search((this.value != "") ? regexr.replace('{search}', '((('+this.value+')))') : "", this.value != "", this.value == "")
                                    .draw();
                                $(this).focus()[0].setSelectionRange(cursorPosition, cursorPosition);
                            });
                        }
                        else
                        {
                            $(cell).html('');
                        }
                    });

                    if(valstatus!=''){
                        api.columns().columns(valstatus).each(function(colIdx) {
                            // Set the header cell to contain the input element
                            var cell = $('.filters th').eq($(api.column(colIdx).header()).index());
                            var title = $(cell).text();
                            if ($(api.column(colIdx).header()).index() >= 0) {
                                   // $(cell).html('<input type="text" style="color: #000000;" placeholder="aaaaaaaaaaaaaaaaaaa"/>');
                                   $(cell).html('<select style="color: #000000;"><option value="">Semua<option >Aktif</option><option>Tidak Aktif</option></select>');
                                }
                            // On every keypress in this input
                            $('select', $('.filters th').eq($(api.column(colIdx).header()).index()) )
                                .off('keyup change')
                                .on('keyup change', function (e) {
                                    e.stopPropagation();
                                    // Get the search value
                                    $(this).attr('title', $(this).val());
                                    var regexr = '({search})'; //$(this).parents('th').find('select').val();
                                    var cursorPosition = this.selectionStart;
                                    console.log(this.value);
                                    // Search the column for that value
                                    api
                                        .column(colIdx)
                                        .search((this.value != "") ? regexr.replace('{search}', '((('+this.value+')))') : "", this.value != "", this.value == "")
                                        .draw();
                                    // $(this).focus()[0].setSelectionRange(cursorPosition, cursorPosition);
                                });
                        });
                    }
                },

            });
        }
    };

    return {
        init: function(valtableid, valjsonurl, valarrdata, valgroup, valstatus) {
            if(typeof valgroup==='undefined' || valgroup===null || valgroup == "") 
            {
                valgroup= "";
            }

            if(typeof valstatus==='undefined' || valstatus===null || valstatus == "") 
            {
                valstatus= "";
            }

            initdynamistable(valtableid, valjsonurl, valarrdata, valgroup, valstatus);
        },
    };

}();

$(document).ready(function(){
    $('#example thead tr')
    .clone(true)
    .addClass('filters')
    .appendTo('#example thead');
});
   

function reloadglobalklikcheck()
{
    if(typeof infoglobalarrid == "undefined")
    {
        return false;
    }
    
    reqinfoglobalid= String($("#reqGlobalValidasiCheck").val());
    // console.log(reqinfoglobalid);
    arrinfoglobalid= reqinfoglobalid.split(',');

    var i= "";
    if(reqinfoglobalid == ""){}
    else
    {
        infoglobalarrid= arrinfoglobalid;

        for(var i=0; i<infoglobalarrid.length; i++) 
        {
            $("#reqPilihCheck"+infoglobalarrid[i]).prop('checked', true);
            // console.log("#reqPilihCheck"+infoglobalarrid[i]);
        }
    }   
}

function setglobalklikcheck()
{
    if(typeof infoglobalarrid == "undefined")
    {
        return false;
    }

    reqinfoglobalid= String($("#reqGlobalValidasiCheck").val());
    // console.log(reqinfoglobalid);
    arrinfoglobalid= reqinfoglobalid.split(',');

    var i= "";
    if(reqinfoglobalid == ""){}
    else
    {
        infoglobalarrid= arrinfoglobalid;
        i= infoglobalarrid.length - 1;
        i= infoglobalarrid.length;
    }

    reqPilihCheck= reqpilihcheckval= reqNominalBantuan= reqNominalBantuanVal= reqCatatan= reqCatatanVal= "";
    $('input[id^="reqPilihCheck"]:checkbox:checked').each(function(i){
        reqPilihCheck= $(this).val();
        var id= $(this).attr('id');
        id= id.replace("reqPilihCheck", "");

        if(reqpilihcheckval == "")
        {
            reqpilihcheckval= reqPilihCheck;
            // reqNominalBantuanVal= reqNominalBantuan;
            // reqCatatanVal= reqCatatan;
        }
        else
        {
            reqpilihcheckval= reqpilihcheckval+","+reqPilihCheck;
            // reqNominalBantuanVal= reqNominalBantuanVal+","+reqNominalBantuan;
            // reqCatatanVal= reqCatatanVal+"||"+reqCatatan;
        }

        var elementRow= infoglobalarrid.indexOf(reqPilihCheck);
        if(elementRow == -1)
        {
            i= infoglobalarrid.length;

            infoglobalarrid[i]= reqPilihCheck;
        }

    });

    $('input[id^="reqPilihCheck"]:checkbox:not(:checked)').each(function(i){
        reqPilihCheck= $(this).val();
        var id= $(this).attr('id');
        id= id.replace("reqPilihCheck", "");

        var elementRow= infoglobalarrid.indexOf(reqPilihCheck);
        if(parseInt(elementRow) >= 0)
        {
            infoglobalarrid.splice(elementRow, 1);
        }
    });

    reqPilihCheck= reqpilihcheckval= reqNominalBantuan= reqNominalBantuanVal= reqCatatan= reqCatatanVal= "";
    reqTotalNominal= reqTotalOrang= 0;

    for(var i=0; i<infoglobalarrid.length; i++) 
    {
        if(reqpilihcheckval == "")
        {
            reqpilihcheckval= infoglobalarrid[i];
        }
        else
        {
            reqpilihcheckval= reqpilihcheckval+","+infoglobalarrid[i];
        }
    }
    // console.log(reqpilihcheckval);

    $("#reqGlobalValidasiCheck").val(reqpilihcheckval);
    // $("#reqValidasiForm").val(reqPilihCheckForm);
}