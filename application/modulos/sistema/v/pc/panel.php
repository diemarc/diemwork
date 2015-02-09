<?php (!defined('__APPFOLDER__')) ? exit('No esta permitido el acceso directo a este archivo') : ""; ?>
<!-- Fixed navbar -->
<div class="container theme-showcase" role="main">

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
        <h1>Bienvenido <?php echo $_SESSION['logged_username']; ?></h1>
        <p>.</p>
    </div>


    <div class="page-header">
        <h1></h1>
    </div>


</div> <!-- /container -->


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="../../dist/js/bootstrap.min.js"></script>
<script src="../../assets/js/docs.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>