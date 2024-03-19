<?
$this->load->model("base-app/T_Preperation_Lccm");

$reqTahunAwal= $this->input->get("reqTahunAwal");
$reqTahunAkhir= $this->input->get("reqTahunAkhir");

$reqDistrikId= $this->input->get("reqDistrikId");
$reqBlokId= $this->input->get("reqBlokId");
$reqUnitMesinId= $this->input->get("reqUnitMesinId");

$set= new T_Preperation_Lccm();
$arrisi= [];
$statement="  ";


if(!empty($reqDistrikId))
{
    $statement .= " AND A.KODE_DISTRIK='".$reqDistrikId."'";
}

if(!empty($reqBlokId))
{
    $statement .= " AND A.KODE_BLOK='".$reqBlokId."'";
}

if(!empty($reqUnitMesinId))
{
    $statement .= " AND A.KODE_UNIT_M='".$reqUnitMesinId."'";
}

if(!empty($reqTahunAwal) && !empty($reqTahunAkhir))
{
    $statement .= " AND A.YEAR_LCCM  between '".$reqTahunAwal."' and '".$reqTahunAkhir."' ";
}
else
{
    if(!empty($reqTahunAwal))
    {
        $statement .= " AND A.YEAR_LCCM='".$reqTahunAwal."'";
    }
    else if(!empty($reqTahunAkhir))
    {
        $statement .= " AND A.YEAR_LCCM='".$reqTahunAkhir."'";
    }
}



$set->selectByParamsDashboardNew(array(), 1,-1,$statement);
// echo $set->query;exit;
while($set->nextRow())
{

    $WO_CR= $set->getField("WO_CR");
    $WO_STANDING= $set->getField("WO_STANDING");
    $WO_PM= $set->getField("WO_PM");
    $WO_PDM= $set->getField("WO_PDM");
    $WO_OH= $set->getField("WO_OH");
    $PRK= $set->getField("PRK");
    $LOSS_OUTPUT= $set->getField("LOSS_OUTPUT");
    $ENERGY_PRICE= $set->getField("ENERGY_PRICE");
    $OPERATION= $set->getField("OPERATION");
    $STATUS_COMPLETE= $set->getField("STATUS_COMPLETE");


    // var_dump($wocr);
    $statuscheckedwocr="";
    $statuscheckedwostanding="";
    $statuscheckedwopm="";
    $statuscheckedwopdm="";
    $statuscheckedwooh="";
    $statuscheckedprk="";
    $statuscheckedlossoutput="";
    $statuscheckedenergy="";
    $statuscheckedoperation="";
    $statuscheckedstatus="";


    if(!empty($WO_CR))
    {

        if($WO_CR=='false' || $WO_CR=='f' || $WO_CR=='0' )
        {
            $WO_CR='<i style="float:right;" class="fa fa-times" aria-hidden="true"></i>';
            $statuscompwocr="Incomplete";
        }
        else
        {
            $statuscheckedwocr="status-checked";
            $WO_CR='<i style="float:right;" class="fa fa-check" aria-hidden="true"></i>';
            $statuscompwocr="Complete";
        }

        if($WO_STANDING=='false' || $WO_STANDING=='f' || $WO_STANDING=='0' )
        {
            $WO_STANDING='<i style="float:right;" class="fa fa-times" aria-hidden="true"></i>';
            $statuscompwostand="Incomplete";
        }
        else
        {
            $statuscheckedwostanding="status-checked";
            $WO_STANDING='<i style="float:right;" class="fa fa-check" aria-hidden="true"></i>';
            $statuscompwostand="Complete";
        }


        if($WO_PM=='false' || $WO_PM=='f' || $WO_PM=='0' )
        {
            $WO_PM='<i style="float:right;" class="fa fa-times" aria-hidden="true"></i>';
            $statuscompwopm="Incomplete";
        }
        else
        {
            $statuscheckedwopm="status-checked";
            $WO_PM='<i style="float:right;" class="fa fa-check" aria-hidden="true"></i>';
            $statuscompwopm="Complete";
        }


        if($WO_PDM=='false' || $WO_PDM=='f' || $WO_PDM=='0' )
        {
            $WO_PDM='<i style="float:right;" class="fa fa-times" aria-hidden="true"></i>';
            $statuscompwopdm="Incomplete";
        }
        else
        {
            $statuscheckedwopdm="status-checked";
            $WO_PDM='<i style="float:right;" class="fa fa-check" aria-hidden="true"></i>';
            $statuscompwopdm="Complete";
        }


        if($WO_OH=='false' || $WO_OH=='f' || $WO_OH=='0' )
        {
            $WO_OH='<i style="float:right;" class="fa fa-times" aria-hidden="true"></i>';
            $statuscompwooh="Incomplete";
        }
        else
        {
            $statuscheckedwooh="status-checked";
            $WO_OH='<i style="float:right;" class="fa fa-check" aria-hidden="true"></i>';
            $statuscompwooh="Complete";
        }

        if($PRK=='false' || $PRK=='f' || $PRK=='0' )
        {
            $PRK='<i style="float:right;" class="fa fa-times" aria-hidden="true"></i>';
            $statuscompwoprk="Incomplete";
        }
        else
        {
            $statuscheckedprk="status-checked";
            $PRK='<i style="float:right;" class="fa fa-check" aria-hidden="true"></i>';
            $statuscompwoprk="Complete";
        }

        if($LOSS_OUTPUT=='false' || $LOSS_OUTPUT=='f' || $LOSS_OUTPUT=='0' )
        {
            $LOSS_OUTPUT='<i style="float:right;" class="fa fa-times" aria-hidden="true"></i>';
            $statuscomploss="Incomplete";
        }
        else
        {
            $statuscheckedlossoutput="status-checked";
            $LOSS_OUTPUT='<i style="float:right;" class="fa fa-check" aria-hidden="true"></i>';
            $statuscomploss="Complete";
        }

        if($ENERGY_PRICE=='false' || $ENERGY_PRICE=='f' || $ENERGY_PRICE=='0' )
        {
            $ENERGY_PRICE='<i style="float:right;" class="fa fa-times" aria-hidden="true"></i>';
            $statuscompenergy="Incomplete";
        }
        else
        {
            $statuscheckedenergy="status-checked";
            $ENERGY_PRICE='<i style="float:right;" class="fa fa-check" aria-hidden="true"></i>';
            $statuscompenergy="Complete";
        }

        if($OPERATION=='false' || $OPERATION=='f' || $OPERATION=='0' )
        {
            $OPERATION='<i style="float:right;" class="fa fa-times" aria-hidden="true"></i>';
            $statuscompoperation="Incomplete";
        }
        else
        {
            $statuscheckedoperation="status-checked";
            $OPERATION='<i style="float:right;" class="fa fa-check" aria-hidden="true"></i>';
            $statuscompoperation="Complete";
        }

    }
}


?>
        <div style="border:1px solid black;">
            <br>

            <div class="col-md-5ths col-xs-6">
                <div class="item">
                    <a href="app/index/wo_standing"><div class="title">Wo Cr</div></a>
                    <div class="status  <?=$statuscheckedwocr?>"><label>Status :  <?=$statuscompwocr?></label>  <?=$WO_CR?></div>
                </div>
            </div>
            <div class="col-md-5ths col-xs-6">
                <div class="item">
                   <a href="app/index/wo_standing"><div class="title">Wo Standing</div></a>
                   <div class="status <?=$statuscheckedwostanding?>"><label>Status : <?=$statuscompwostand?> </label><?=$WO_STANDING?></div>
               </div>
            </div>
            <div class="col-md-5ths col-xs-6">
                <div class="item">
                    <a href="app/index/total_wo_pm"><div class="title">Wo PM</div></a>
                    <div class="status  <?=$statuscheckedwopm?>"><label>Status : <?=$statuscompwopm?> </label><?=$WO_PM?></div>
                </div>
            </div>
            <div class="col-md-5ths col-xs-6">
                <div class="item">
                    <a href="app/index/total_pdm"><div class="title">Wo PDM</div></a>
                    <div class="status  <?=$statuscheckedwopdm?>"><label>Status : <?=$statuscompwopdm?> </label><?=$WO_PDM?></div>
                </div>
            </div>
            <div class="col-md-5ths col-xs-6">
                <div class="item">
                    <div class="title">Wo OH</div>
                    <div class="status  <?=$statuscheckedwooh?>"><label>Status : <?=$statuscompwooh?> </label><?=$WO_OH?></div>
                </div>
            </div>
            <div class="col-md-5ths col-xs-6">
                <div class="item">
                    <a href="app/index/total_prk"><div class="title">PRK</div></a>
                    <div class="status  <?=$statuscheckedprk?>"><label>Status : <?=$statuscompwoprk?> </label><?=$PRK?></div>
                </div>
            </div>
            <div class="col-md-5ths col-xs-6">
                <div class="item">
                   <a href="app/index/total_output"><div class="title">Loss Output</div></a>
                   <div class="status  <?=$statuscheckedlossoutput?>"><label>Status : <?=$statuscomploss?> </label><?=$LOSS_OUTPUT?></div>
                </div>
            </div>
            <div class="col-md-5ths col-xs-6">
                <div class="item">
                    <a href="app/index/energi_price"><div class="title">Energy Price</div></a>
                    <div class="status  <?=$statuscheckedenergy?>"><label>Status :  <?=$statuscompenergy?></label><?=$ENERGY_PRICE?></div>
                </div>
            </div>
            <div class="col-md-5ths col-xs-6">
                <div class="item">
                    <a href="app/index/operation"><div class="title">Operation</div> </a>
                    <div class="status  <?=$statuscheckedoperation?>"><label>Status : <?=$statuscompoperation?> </label><?=$OPERATION?></div>
                </div>
            </div>
            <!-- <div class="col-md-5ths col-xs-6">
                <div class="item">
                    <div class="title">Status Complete</div>
                    <div class="status  <?=$statuscheckedstatus?>"><label>Status : <?=$statuscompstatus?> </label><?=$STATUS_COMPLETE?></div>
                </div>
            </div> -->
        </div>

<?

?>
