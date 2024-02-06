<?
$reqId = $this->input->get("reqId");
$reqToken = $this->input->get("reqToken");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
  	<base href="<?=base_url()?>">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="images-approval/favicon.ico">

    <title>ESSA APPROVAL SYSTEM</title>

    <!-- Bootstrap core CSS -->
    <link href="lib-approval/bootstrap/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/gaya-approval.css" rel="stylesheet">
	
    <link href="lib-approval/font-awesome-4.7.0/css/font-awesome.css" rel="stylesheet" type="text/css">

    <!-- The core Firebase JS SDK is always required and must be listed first -->
    <script src="https://www.gstatic.com/firebasejs/5.5.9/firebase.js"></script>
    <script type="text/javascript">
    var base_url = '<?=base_url()?>';
    </script>
    <script type='text/javascript' src="js/firebase.js"></script>
    
  </head>

  <body class="beranda">

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#"><img src="images-approval/logo-header.png"><!--Payroll Approval--></a>
          <div class="nama-aplikasi-wrapper">
            <span class="nama">Approval</span>
          </div>
          
        </div>
        <!-- <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="index.php">Home</a></li>
            <li><a href="app/loadurl/persetujuan/approval_form" target="mainFrame">Approval</a></li>
            <li><a href="app/loadurl/persetujuan/not_approval_form" target="mainFrame">Not Approval</a></li>
          </ul>
        </div> --><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container-fluid area-konten">
    	<iframe name="mainFrame" src="persetujuan/loadUrl/persetujuan/<?=$reqTipe?>/?reqId=<?=$reqId?>&reqToken=<?=$reqToken?>"></iframe>
    	
        <!--<div class="starter-template">
        <h1>Bootstrap starter template</h1>
        <p class="lead">Use this document as a way to quickly start any new project.<br> All you get is this text and a mostly barebones HTML document.</p>
      </div>-->

    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="lib-approval/bootstrap/jquery.js"></script>
    <script src="lib-approval/bootstrap/bootstrap.js"></script>
    
    <!-- EMODAL -->
    <script src="lib-approval/emodal/eModal.js"></script>
	<script>
    function openPopup(linkUrl) {
		//alert("cek emodal");
        eModal.iframe(linkUrl, 'Payroll Approval')
    }
    function closePopup() {
        eModal.close();
    }
    </script>
    
    <script type="
  </body>
</html>
