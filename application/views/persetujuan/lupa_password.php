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

    <title>PLNNP LCCM</title>

    <!-- Bootstrap core CSS -->

    <!-- Custom styles for this template -->
    <link href="css/gaya-approval.css" rel="stylesheet">
	

    <!-- The core Firebase JS SDK is always required and must be listed first -->
    <script src="https://www.gstatic.com/firebasejs/5.5.9/firebase.js"></script>
    <script type="text/javascript">
    var base_url = '<?=base_url()?>';
    </script>
    
  </head>

  <body class="beranda">

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <!-- <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button> -->
          <!-- <a class="navbar-brand" href="#"><img src="images/logo-pln-np.png" width="120px"></a> -->
          <div class="nama-aplikasi-wrapper">
            <span class="nama">Reset Password</span>
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
    	<iframe id="lupapass" name="mainFrame" src="persetujuan/loadUrl/persetujuan/lupa_password_detil/?reqToken=<?=$reqToken?>"></iframe>
    	
        <!--<div class="starter-template">
        <h1>Bootstrap starter template</h1>
        <p class="lead">Use this document as a way to quickly start any new project.<br> All you get is this text and a mostly barebones HTML document.</p>
      </div>-->

    </div><!-- /.container -->
    <script type='text/javascript' src="assets/bootstrap/js/jquery-1.12.4.min.js"></script>



    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

  </body>
</html>
