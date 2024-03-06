<?
$this->load->model("base-app/T_Preperation_Lccm");

$reqTahun= $this->input->get("reqTahun");
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

if(!empty($reqTahun))
{
    $statement .= " AND A.YEAR_LCCM='".$reqTahun."'";
}


$set->selectByParamsDashboard(array(), -1,-1,$statement);
// echo $set->query;exit;
while($set->nextRow())
{
    $NAMA_DISTRIK= $set->getField("NAMA_DISTRIK");
    $BLOK_UNIT_NAMA= $set->getField("BLOK_UNIT_NAMA");
    $UNIT_MESIN_NAMA= $set->getField("UNIT_MESIN_NAMA");
    $YEAR_LCCM= $set->getField("YEAR_LCCM");

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
            $WO_CR='<i class="fa fa-times" aria-hidden="true"></i>';
        }
        else
        {
            $statuscheckedwocr="status-checked";
            $WO_CR='<i class="fa fa-check" aria-hidden="true"></i>';
        }

        if($WO_STANDING=='false' || $WO_STANDING=='f' || $WO_STANDING=='0' )
        {
            $WO_STANDING='<i class="fa fa-times" aria-hidden="true"></i>';
        }
        else
        {
            $statuscheckedwostanding="status-checked";
            $WO_STANDING='<i class="fa fa-check" aria-hidden="true"></i>';
        }


        if($WO_PM=='false' || $WO_PM=='f' || $WO_PM=='0' )
        {
            $WO_PM='<i class="fa fa-times" aria-hidden="true"></i>';
        }
        else
        {
            $statuscheckedwopm="status-checked";
            $WO_PM='<i class="fa fa-check" aria-hidden="true"></i>';
        }


        if($WO_PDM=='false' || $WO_PDM=='f' || $WO_PDM=='0' )
        {
            $WO_PDM='<i class="fa fa-times" aria-hidden="true"></i>';
        }
        else
        {
            $statuscheckedwopdm="status-checked";
            $WO_PDM='<i class="fa fa-check" aria-hidden="true"></i>';
        }


        if($WO_OH=='false' || $WO_OH=='f' || $WO_OH=='0' )
        {
            $WO_OH='<i class="fa fa-times" aria-hidden="true"></i>';
        }
        else
        {
            $statuscheckedwooh="status-checked";
            $WO_OH='<i class="fa fa-check" aria-hidden="true"></i>';
        }

        if($PRK=='false' || $PRK=='f' || $PRK=='0' )
        {
            $PRK='<i class="fa fa-times" aria-hidden="true"></i>';
        }
        else
        {
            $statuscheckedprk="status-checked";
            $PRK='<i class="fa fa-check" aria-hidden="true"></i>';
        }

        if($LOSS_OUTPUT=='false' || $LOSS_OUTPUT=='f' || $LOSS_OUTPUT=='0' )
        {
            $LOSS_OUTPUT='<i class="fa fa-times" aria-hidden="true"></i>';
        }
        else
        {
            $statuscheckedlossoutput="status-checked";
            $LOSS_OUTPUT='<i class="fa fa-check" aria-hidden="true"></i>';
        }

        if($ENERGY_PRICE=='false' || $ENERGY_PRICE=='f' || $ENERGY_PRICE=='0' )
        {
            $ENERGY_PRICE='<i class="fa fa-times" aria-hidden="true"></i>';
        }
        else
        {
            $statuscheckedenergy="status-checked";
            $ENERGY_PRICE='<i class="fa fa-check" aria-hidden="true"></i>';
        }

        if($OPERATION=='false' || $OPERATION=='f' || $OPERATION=='0' )
        {
            $OPERATION='<i class="fa fa-times" aria-hidden="true"></i>';
        }
        else
        {
            $statuscheckedoperation="status-checked";
            $OPERATION='<i class="fa fa-check" aria-hidden="true"></i>';
        }

        if($STATUS_COMPLETE=='false' || $STATUS_COMPLETE=='f' || $STATUS_COMPLETE=='0' )
        {
            $STATUS_COMPLETE='<i class="fa fa-times" aria-hidden="true"></i>';
        }
        else
        {
            $statuscheckedstatus="status-checked";
            $STATUS_COMPLETE='<i class="fa fa-check" aria-hidden="true"></i>';
        }

?>
        <div style="border:1px solid black;">
            <br>
            <!-- <div class="col-md-2ths col-xs-6">
                <div class="item" >
                    <div class="title" style="background-color:green">Distrik</div>
                    <div class="status "> <?=$NAMA_DISTRIK?></div>
                </div>
            </div>
            <div class="col-md-2ths col-xs-6">
                <div class="item">
                    <div class="title" style="background-color:blue">Blok</div>
                    <div class="status  "><?=$BLOK_UNIT_NAMA?></div>
                </div>
            </div>
            <div class="col-md-2ths col-xs-6">
                <div class="item">
                    <div class="title" style="background-color:brown">Unit</div>
                    <div class="status "> <?=$UNIT_MESIN_NAMA?></div>
                </div>
            </div>
            <div class="col-md-2ths col-xs-6">
                <div class="item">
                    <div class="title" style="background-color:#11af9c ">Tahun</div>
                    <div class="status "> <?=$YEAR_LCCM?></div>
                </div>
            </div> -->
            <div class="col-md-5ths col-xs-6">
                <div class="item">
                    <div class="title">Wo Cr</div>
                    <div class="status  <?=$statuscheckedwocr?>"><span>Status : </span> <?=$WO_CR?></div>
                </div>
            </div>
            <div class="col-md-5ths col-xs-6">
                <div class="item">
                   <a href="app/index/wo_standing"><div class="title">Wo Standing</div></a>
                   <div class="status <?=$statuscheckedwostanding?>"><span>Status : </span><?=$WO_STANDING?></i></div>
               </div>
            </div>
            <div class="col-md-5ths col-xs-6">
                <div class="item">
                    <a href="app/index/total_wo_pm"><div class="title">Wo PM</div></a>
                    <div class="status  <?=$statuscheckedwopm?>"><span>Status : </span><?=$WO_PM?></i></div>
                </div>
            </div>
            <div class="col-md-5ths col-xs-6">
                <div class="item">
                    <a href="app/index/total_pdm"><div class="title">Wo PDM</div></a>
                    <div class="status  <?=$statuscheckedwopdm?>"><span>Status : </span><?=$WO_PDM?></i></div>
                </div>
            </div>
            <div class="col-md-5ths col-xs-6">
                <div class="item">
                    <div class="title">Wo OH</div>
                    <div class="status  <?=$statuscheckedwooh?>"><span>Status : </span><?=$WO_OH?></i></div>
                </div>
            </div>
            <div class="col-md-5ths col-xs-6">
                <div class="item">
                    <a href="app/index/total_prk"><div class="title">PRK</div></a>
                    <div class="status  <?=$statuscheckedprk?>"><span>Status : </span><?=$PRK?></i></div>
                </div>
            </div>
            <div class="col-md-5ths col-xs-6">
                <div class="item">
                   <a href="app/index/total_output"><div class="title">Loss Output</div></a>
                   <div class="status  <?=$statuscheckedlossoutput?>"><span>Status : </span><?=$LOSS_OUTPUT?></div>
                </div>
            </div>
            <div class="col-md-5ths col-xs-6">
                <div class="item">
                    <a href="app/index/energi_price"><div class="title">Energy Price</div></a>
                    <div class="status  <?=$statuscheckedenergy?>"><span>Status : </span><?=$ENERGY_PRICE?></div>
                </div>
            </div>
            <div class="col-md-5ths col-xs-6">
                <div class="item">
                    <a href="app/index/operation"><div class="title">Operation</div> </a>
                    <div class="status  <?=$statuscheckedoperation?>"><span>Status : </span><?=$OPERATION?></div>
                </div>
            </div>
            <div class="col-md-5ths col-xs-6">
                <div class="item">
                    <div class="title">Status Complete</div>
                    <div class="status  <?=$statuscheckedstatus?>"><span>Status : </span><?=$STATUS_COMPLETE?></div>
                </div>
            </div>
        </div>

<?
    }
}
?>
