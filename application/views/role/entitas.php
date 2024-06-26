<?
// echo $this->appuserid."<br>";
// echo $this->appusernama."<br>";
// echo $this->personaluserlogin."<br>";
// echo $this->appusergroupid."<br>";
// echo $this->appuserpilihankodehak."<br>";
// echo $this->appuserkodehak."<br>";
// echo $this->appuserroleid."<br>";exit();
// echo "sasa";exit();
$this->load->library("crfs_protect"); $csrf = new crfs_protect('_crfs_role');

// if(stristr($this->USER_TYPE, "ADMIN") || stristr($this->USER_TYPE, "VIEWER") || stristr($this->USER_TYPE, "REVIEW"))
// {}
// else
// 	redirect("app");
$appuserkodehak= $this->appuserkodehak;


$pgold = $this->input->get("pgold");

?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<base href="<?=base_url();?>">
<title>Pilih Role Entitas</title>

<style>
html, body{
	height:100%;
}
body{
	font-family:Arial;
	padding-left:20px;
	padding-right:20px;
	
	margin:0 0;
	padding:0 0;
	
	display: flex;
	justify-content: center; /* align horizontal */
	align-items: center; /* align vertical */
	
	background:rgba(0,0,0,0.3);

	
}
.pilihan-wrapper{
	width:50%;
	margin:0 auto;
	*border:1px solid #0099BC;
	
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	border-radius: 4px;
	
	-webkit-box-shadow: 0 8px 6px -6px black;
	   -moz-box-shadow: 0 8px 6px -6px black;
	        box-shadow: 0 8px 6px -6px black;
}
.logo{
	text-align:center;
	padding-top:30px;
	padding-bottom:30px;
	
	background:rgba(255,255,255,0.3);
	
	-webkit-border-top-left-radius: 4px;
	-webkit-border-top-right-radius: 4px;
	-moz-border-radius-topleft: 4px;
	-moz-border-radius-topright: 4px;
	border-top-left-radius: 4px;
	border-top-right-radius: 4px;
}
@media screen and (max-width:767px) {
	.pilihan-wrapper{
				
		width: -moz-calc(100% - 40px);
		width: -webkit-calc(100% - 40px);
		width: -o-calc(100% - 40px);
		width: calc(100% - 40px); 
	}
	.logo{
		padding-left:15px;
		padding-right:15px;
		padding-top:15px;
		padding-bottom:10px;
	}
	.logo img{
		width:100%;
	}
}
.judul{
	text-align:center;	 
	*background:#7ba4db;
	background:#0099BC;
	color:#FFF;
	padding-top:9px;
	padding-bottom:9px;
	
	border-bottom:4px solid rgba(0,0,0,0.2);
}

.pilihan{
	border:1px solid #f4f4f4;
	background:#f4f4f4;
	padding:0px 20px 10px;
	
	-webkit-border-bottom-right-radius: 4px;
	-webkit-border-bottom-left-radius: 4px;
	-moz-border-radius-bottomright: 4px;
	-moz-border-radius-bottomleft: 4px;
	border-bottom-right-radius: 4px;
	border-bottom-left-radius: 4px;
	
}
.pilihan ul{
	padding:0 0 ;
}
.pilihan ul li{
	list-style:none;
	border-bottom:1px solid rgba(0,0,0,0.2);
	padding-top:8px;
	padding-bottom:8px;
	
}
.pilihan ul li input[type=radio] {
	
}
.pilihan .aksi{
	text-align:center;
}
.pilihan input[type=submit]{
	background-color: #0099BC; background: url(images/linear_bg_2.png); background-repeat: repeat-x; 	
	background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#0099BC), to(#094c6c)); 	
	background: -webkit-linear-gradient(top, #0099BC, #094c6c); 	
	background: -moz-linear-gradient(top, #0099BC, #094c6c); 	
	background: -ms-linear-gradient(top, #0099BC, #094c6c); 	
	background: -o-linear-gradient(top, #0099BC, #094c6c);
	
	color:#FFF;
	padding:18px 60px;
	
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	border-radius: 4px;
	
	border:none;
	text-transform:uppercase;
	letter-spacing:5px;
	font-size:14px;
	
}
@media screen and (max-width:767px) {
	.pilihan input[type=button]{
		padding:18px 20px;
	}
}

</style>

 <script type='text/javascript' src="assets/bootstrap/js/jquery-1.12.4.min.js"></script>

</head>

<body>
<div class="pilihan-wrapper" style=" height: 500px">
	
    <div class="logo"><img src="images/logo-pln-np.png" height="50"></div>
    <div class="judul">Silahkan pilih Entitas</div>
    <div class="pilihan">
		<form id="myForm" action="login/multi_entitas?pgold=<?=$pgold?>" method="post">
        <ul>
        <?

		// if($this->USER_TYPE == "ADMINAPP" || $this->USER_TYPE == "VIEWER_ALL" || $this->USER_TYPE == "REVIEW")
		// {}
		// else
		// 	$statement .= "AND A.DISTRIK_ID = '".$this->DISTRIK_ID."' ";

        if (!empty($this->appuserkodehak)) 
        {
        	$statement= " AND d.kode_hak = '".$this->appuserkodehak."'";
        }
        
        $querynya= "
        	SELECT 
        		a.pengguna_hak_distrik_id, a.pengguna_hak_id, b.distrik_id, b.nama distrik_nama, c.blok_unit_id, c.nama blok_unit_nama
			FROM pengguna_hak_distrik a
			left join distrik b on b.distrik_id = a.distrik_id
			left join blok_unit c on c.distrik_id = b.distrik_id
			inner join pengguna_hak d on d.pengguna_hak_id = a.pengguna_hak_id
			where 1=1
			".$statement."
			ORDER BY pengguna_hak_id ASC 
        ";

			$distrik = "";
			$query = $this->db->query($querynya);

		
		$i = 0;

		if(empty($query->result_array()))
		{
			$statement= " AND a.pengguna_id = '".$this->appuserid."'";
			$querynya= "
        	SELECT 
        		a.pengguna_id, b.distrik_id, b.nama distrik_nama, c.blok_unit_id, c.nama blok_unit_nama
			FROM pengguna a
			inner join distrik b on b.kode = a.kode_distrik
			inner join blok_unit c on c.kode = a.kode_blok
			where 1=1
			".$statement."
			ORDER BY pengguna_id ASC 
        ";

			$distrik = "";
			$query = $this->db->query($querynya);
		}

		// print_r($querynya);exit;

		$checked='';
		if ($this->appblokunitid=='') 
		{
			$checked= 'checked';
		}

		echo '<li><input class="parentall" type="checkbox" name="reqBlokUnitId" value="all" '.$checked.'> All</li>';

		foreach ($query->result_array() as $row)
		{
			if($distrik == $row["distrik_nama"])
			{}
			else
				echo "<li>".$row["distrik_nama"]."</li>";
			?>
            <li><input type="checkbox" class="parent" name="reqBlokUnitId" value="<?=$row["blok_unit_id"]?>" <? if($row["blok_unit_id"] == $this->appblokunitid) { ?> checked <? } ?>> <?=$row["blok_unit_nama"]?>
            <?
            $querydetil= "
	        	SELECT 
	        	*
				FROM Unit_mesin a
				where 1=1
				and blok_unit_id =".$row["blok_unit_id"];

				$query1 = $this->db->query($querydetil);

			foreach ($query1->result_array() as $row1)
			{?>
				<ul><li style="padding-left: 30px"><label>&nbsp;&nbsp;&nbsp;&nbsp;<input class="anak" type="checkbox" name="reqUnitMesinId" value="<?=$row1["unit_mesin_id"]?>" <? if($row1["unit_mesin_id"] == $this->appunitmesinid) { ?> checked <? } ?>> <?=$row1["nama"]?></label>
				</li></ul>

	           
        	<?
        	}
        	$distrik = $row["distrik_nama"];
        	$i++;
        	?>
        	</li>
        	<?
		}
		?>	
        </ul>
        <div class="aksi">
        	<input type="submit" value="Pilih">
            <?=$csrf->echoInputField();?>
        </div>
        </form>
    </div>

</div>
<script type="text/javascript">
$(function () {

	$(document).on('change','.anak',function(){
    	$('input[name="' + this.name + '"]').not(this).prop('checked', false);
    	$('.parentall').not(this).prop('checked', false);
    	// $(this).closest('ul').siblings('input:checkbox').attr('checked', true);

    	// var checked1= $('input[name="reqBlokUnitId"]').is(':checked');
    	// if(checked1==true)
    	// {
    	// 	$('input[name="reqBlokUnitId"]').not(this).prop('checked', false);
    	// }
    });

    $(document).on('change','.parent',function(){
    	$('input[name="' + this.name + '"]').not(this).prop('checked', false);
    	$('input[name="reqUnitMesinId"]').not(this).prop('checked', false);

    });

   

    $(':checkbox').on('change', function() {
     	var $this = $(this),
     	checked = $this.is(':checked');

     	toggleParents($this, checked);
     });

	function toggleParents(checkbox, checked) {
	  checkbox.parents('li').each(function() {
	    var $parent = $(this);
	    $parent.children(':checkbox').prop('checked', checked);
	  });
	}

	function toggleChildren(checkbox, checked) {
	  checkbox.siblings('ul').find(':checkbox').each(function() {
	    $(this).prop('checked', checked);
	  });
	}

});
</script>
</body>
</html>