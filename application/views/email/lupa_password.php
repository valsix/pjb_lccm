<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$rowResult = $this->db->query(" SELECT nama, email, to_char(current_date, 'dd-mm-yyyy') batas from PENGGUNA_EXTERNAL WHERE NID = '$reqId' ")->row();
$reqNama  = $rowResult->nama;
$reqEmail = $rowResult->email;
$reqBatas = $rowResult->batas;

// print_r($reqId.$reqBatas.$this->config->item('md5key'));exit;

$reqTahun = date("Y");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="format-detection" content="telephone=no" /> 
		<title>gaji_approval</title>
		<style type="text/css">
			html { background-color:#E1E1E1; margin:0; padding:0; }
			body, #bodyTable, #bodyCell, #bodyCell{height:100% !important; margin:0; padding:0; width:100% !important;font-family:Helvetica, Arial, "Lucida Grande", sans-serif;}
			table{border-collapse:collapse;}
			table[id=bodyTable] {width:100%!important;margin:auto;max-width:500px!important;color:#7A7A7A;font-weight:normal;}
			img, a img{border:0; outline:none; text-decoration:none;height:auto; line-height:100%;}
			a {text-decoration:none !important;border-bottom: 1px solid;}
			h1, h2, h3, h4, h5, h6{color:#5F5F5F; font-weight:normal; font-family:Helvetica; font-size:20px; line-height:125%; text-align:Left; letter-spacing:normal;margin-top:0;margin-right:0;margin-bottom:10px;margin-left:0;padding-top:0;padding-bottom:0;padding-left:0;padding-right:0;}
			.ReadMsgBody{width:100%;} .ExternalClass{width:100%;} 
			.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div{line-height:100%;} 
			#outlook a{padding:0;} 
			img{-ms-interpolation-mode: bicubic;display:block;outline:none; text-decoration:none;} 
			.ExternalClass td[class="ecxflexibleContainerBox"] h3 {padding-top: 10px !important;} 
			h1{display:block;font-size:26px;font-style:normal;font-weight:normal;line-height:100%;}
			h2{display:block;font-size:20px;font-style:normal;font-weight:normal;line-height:120%;}
			h3{display:block;font-size:17px;font-style:normal;font-weight:normal;line-height:110%;}
			h4{display:block;font-size:18px;font-style:italic;font-weight:normal;line-height:100%;}
			.flexibleImage{height:auto;}
			.linkRemoveBorder{border-bottom:0 !important;}
			table[class=flexibleContainerCellDivider] {padding-bottom:0 !important;padding-top:0 !important;}
			body, #bodyTable{background-color:#E1E1E1;}
			#emailHeader{background-color:#E1E1E1;}
			#emailBody{background-color:#FFFFFF;}
			#emailFooter{background-color:#E1E1E1;}
			.nestedContainer{background-color:#F8F8F8; border:1px solid #CCCCCC;}
			.emailButton{background-color:#205478; border-collapse:separate;}
			.buttonContent{color:#FFFFFF; font-family:Helvetica; font-size:18px; font-weight:bold; line-height:100%; padding:15px; text-align:center;}
			.buttonContent a{color:#FFFFFF; display:block; text-decoration:none!important; border:0!important;}
			.emailCalendar{background-color:#FFFFFF; border:1px solid #CCCCCC;}
			.emailCalendarMonth{background-color:#205478; color:#FFFFFF; font-family:Helvetica, Arial, sans-serif; font-size:16px; font-weight:bold; padding-top:10px; padding-bottom:10px; text-align:center;}
			.emailCalendarDay{color:#205478; font-family:Helvetica, Arial, sans-serif; font-size:60px; font-weight:bold; line-height:100%; padding-top:20px; padding-bottom:20px; text-align:center;}
			.imageContentText {margin-top: 10px;line-height:0;}
			.imageContentText a {line-height:0;}
			#invisibleIntroduction {display:none !important;} 
			span[class=ios-color-hack] a {color:#275100!important;text-decoration:none!important;} /
			span[class=ios-color-hack2] a {color:#205478!important;text-decoration:none!important;}
			span[class=ios-color-hack3] a {color:#8B8B8B!important;text-decoration:none!important;}
			
			.a[href^="tel"], a[href^="sms"] {text-decoration:none!important;color:#606060!important;pointer-events:none!important;cursor:default!important;}
			.mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {text-decoration:none!important;color:#606060!important;pointer-events:auto!important;cursor:default!important;}
			@media only screen and (max-width: 480px){
				body{width:100% !important; min-width:100% !important;} 
				table[id="emailBody"],
				table[id="emailFooter"],
				table[class="flexibleContainer"],
				td[class="flexibleContainerCell"] {width:100% !important;}
				td[class="flexibleContainerBox"], td[class="flexibleContainerBox"] table {display: block;width: 100%;text-align: left;}
				
				td[class="imageContent"] img {height:auto !important; width:100% !important; max-width:100% !important; }
				img[class="flexibleImage"]{height:auto !important; width:100% !important;max-width:100% !important;}
				img[class="flexibleImageSmall"]{height:auto !important; width:auto !important;}
				
				table[class="flexibleContainerBoxNext"]{padding-top: 10px !important;}
				
				table[class="emailButton"]{width:100% !important;}
				td[class="buttonContent"]{padding:0 !important;}
				td[class="buttonContent"] a{padding:15px !important;}
			}
			
			@media only screen and (-webkit-device-pixel-ratio:.75){
			}
			@media only screen and (-webkit-device-pixel-ratio:1){
			}
			@media only screen and (-webkit-device-pixel-ratio:1.5){
			}
			@media only screen and (min-device-width : 320px) and (max-device-width:568px) {
			}
		</style>
		
        <style>
			.title-career{
				text-align:center;
				font-weight:normal;
				font-family:Helvetica,Arial,sans-serif;
				font-size:22px;
				margin-bottom:15px;
				color:#205478;
				line-height:135%; 
				border-top:1px solid #2b8dce; 
				border-bottom:1px solid #2b8dce; 
				padding-top:10px; 
				padding-bottom:7px;
			}
			.title-career img{
				vertical-align:middle;
				display:inline-block;
				margin-right:5px;
			}
			
			.note-perhatian{
				text-align:left;
				font-family:Helvetica,Arial,sans-serif;
				font-size:15px;
				margin-bottom:0;
				color:#FFFFFF;
				line-height:135%;
			}
			.note-perhatian ul{
				*border:1px solid red;
				padding:0 0;
				list-style-position:inside;
				list-style:none;
			}
			.note-perhatian ul li {
				*list-style-type: disc;
				*list-style-position: inside;
				*text-indent: -1em;
				*padding-left: 1em;
				padding:10px;
				background:#575757;
				margin-bottom:1px;
			}
			.note-perhatian ul li:nth-child(1) {
				*background:#575757;
			}
		</style>
	</head>
	<body bgcolor="#E1E1E1" leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">

		
		<center style="background-color:#E1E1E1;">
			<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable" style="table-layout: fixed;max-width:100% !important;width: 100% !important;min-width: 100% !important;">
				<tr>
					<td align="center" valign="top" id="bodyCell">


					
						<table bgcolor="#FFFFFF"  border="0" cellpadding="0" cellspacing="0" width="500" id="emailBody">

							
							<tr>
								<td align="center" valign="top">
								
									<table border="0" cellpadding="0" cellspacing="0" width="100%" style="color:#FFFFFF;" bgcolor="#0099BC">
										<tr>
											<td align="center" valign="top">
												
												<table border="0" cellpadding="0" cellspacing="0" width="500" class="flexibleContainer">
													<tr>
														<td align="center" valign="top" width="500" class="flexibleContainerCell">

														
															<table border="0" cellpadding="30" cellspacing="0" width="100%">
																<tr>
																	<td align="center" valign="top" class="textContent">
																		<h1 style="color:#FFFFFF;line-height:100%;font-family:Helvetica,Arial,sans-serif;font-size:35px;font-weight:normal;margin-bottom:5px;text-align:center;"><img src="<?=$this->config->item('publish_url')?>images/logo-pjb.png" style="margin:0 auto; height: 50px;" /></h1>
																		
                                                                        <h2 class="title-career" style="text-align:center;font-weight:normal;font-family:Helvetica,Arial,sans-serif;font-size:22px;margin-bottom:15px;color:#205478;line-height:135%; border-top:1px solid #2b8dce; border-bottom:1px solid #2b8dce; padding-top:10px;padding-bottom:7px;">LCCM</h2>
                                                                        
																		<div style="text-align:center;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;color:#FFF; text-transform:uppercase; letter-spacing:2px; line-height:135%;">PLN NUSANTARA POWER</div>
																	</td>
																</tr>
															</table>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>

							<tr>
								<td align="center" valign="top">
									<table border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#F8F8F8">
										<tr>
											<td align="center" valign="top">
												<table border="0" cellpadding="0" cellspacing="0" width="500" class="flexibleContainer">
													<tr>
														<td align="center" valign="top" width="500" class="flexibleContainerCell">
															<table border="0" cellpadding="30" cellspacing="0" width="100%">
																<tr>
																	<td align="center" valign="top">

																		<table border="0" cellpadding="0" cellspacing="0" width="100%">
																			<tr>
																				<td valign="top" class="textContent">
																					
																					<h3 mc:edit="header" style="color:#5F5F5F;line-height:125%;font-family:Helvetica,Arial,sans-serif;font-size:15px;font-weight:normal;margin-top:0;margin-bottom:3px;text-align:left;">Reset Password Akun Aplikasi LCCM</h3>
																					<div mc:edit="body" style="text-align:left;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;color:#5F5F5F;line-height:135%;">
																					  <p>Yth. <?=$reqNama?>,</p>
																					  <p> Terdapat permintaan Reset Password pada Aplikasi Online Maintenance Monitoring (LCCM) dengan data sebagai berikut.																				      </p>
                                                                                      <table style="text-align:left;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;color:#5F5F5F;">
                                                                                      	<tr>
                                                                                        	<td valign="top">NID</td>
                                                                                        	<td valign="top">:</td>
                                                                                        	<td valign="top"><?=$reqId?></td>
                                                                                        </tr>
                                                                                      	<tr>
                                                                                        	<td valign="top">Nama</td>
                                                                                        	<td valign="top">:</td>
                                                                                        	<td valign="top"><?=$reqNama?></td>
                                                                                        </tr>
                                                                                      </table>

                                                                                      <p>Silahkan klik link di bawah ini untuk memberikan konfirmasi.</p>
                                                                                      
																					  <table border="0" cellpadding="0" cellspacing="0" width="50%" class="emailButton" style="background-color: #235A81; border-collapse:collapse; width:100%; text-align:center; margin:0 auto">
                                                                                          <tr>
                                                                                              <td align="center" valign="middle" class="buttonContent" style="padding-top:15px;padding-bottom:15px;padding-right:15px;padding-left:15px;">
                                                                                                  <a style="color:#FFFFFF;text-decoration:none;font-family:Helvetica,Arial,sans-serif;font-size:20px;line-height:135%;" href="<?=$this->config->item('publish_url')?>persetujuan/lupa_password/?reqToken=<?=md5($reqId.$reqBatas.$this->config->item('md5key'))?>" target="_blank">Reset Password</a>
                                                                                              </td>
                                                                                          </tr>
                                                                                      </table>

																					</div>
																				</td>
																			</tr>
																		</table>

																	</td>
																</tr>
															</table>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>

							<tr>
								<td align="center" valign="top">
									<table border="0" cellpadding="0" cellspacing="0" width="100%">
										<tr>
											<td align="center" valign="top">
												<table border="0" cellpadding="0" cellspacing="0" width="500" class="flexibleContainer">
													<tr>
														<td align="center" valign="top" width="500" class="flexibleContainerCell">
															<table class="flexibleContainerCellDivider" border="0" cellpadding="30" cellspacing="0" width="100%">
																<tr>
																	<td align="center" valign="top" style="padding-top:0px;padding-bottom:0px;">

																		<table border="0" cellpadding="0" cellspacing="0" width="100%">
																			<tr>
																				<td align="center" valign="top" style="border-top:1px solid #C8C8C8;"></td>
																			</tr>
																		</table>

																	</td>
																</tr>
															</table>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>

							<tr>
								<td align="center" valign="top">
									<table border="0" cellpadding="0" cellspacing="0" width="100%">
										<tr>
											<td align="center" valign="top">
												<table border="0" cellpadding="0" cellspacing="0" width="500" class="flexibleContainer">
													<tr>
														<td valign="top" width="500" class="flexibleContainerCell">

														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>


						<table bgcolor="#E1E1E1" border="0" cellpadding="0" cellspacing="0" width="500" id="emailFooter">

						
							<tr>
								<td align="center" valign="top">
									<table border="0" cellpadding="0" cellspacing="0" width="100%">
										<tr>
											<td align="center" valign="top">
												<table border="0" cellpadding="0" cellspacing="0" width="500" class="flexibleContainer">
													<tr>
														<td align="center" valign="top" width="500" class="flexibleContainerCell">
															<table border="0" cellpadding="30" cellspacing="0" width="100%">
																<tr>
																	<td valign="top" bgcolor="#E1E1E1">

																		<div style="font-family:Helvetica,Arial,sans-serif;font-size:13px;color:#828282;text-align:center;line-height:120%;">
																			<div>Copyright &#169; <?=$reqTahun?> <a href="<?=$this->config->item('publish_url')?>" target="_blank" style="text-decoration:none;color:#828282;"><span style="color:#828282;">LCCM - PLN NUSANTARA POWER</span></a>. All&nbsp;rights&nbsp;reserved.</div>
																		</div>

																	</td>
																</tr>
															</table>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>

						</table>

					</td>
				</tr>
			</table>
		</center>
	</body>
</html>