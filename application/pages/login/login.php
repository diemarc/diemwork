<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-15" />
        <meta name="lang" content="es" />
        <meta name="author" content="iprprevencion.com" />
        <meta name="organization" content="IPR" />
        <meta name="locality" content="Madrid" />
        <title>KeranaFrameWork -</title>
        <link href="<?php __APPFOLDER__; ?>layouts/default/src/css/bootstrap-theme.css" rel="stylesheet" type="text/css">
        <link href="<?php __APPFOLDER__; ?>layouts/default/src/css/bootstrap-theme.css.map" rel="stylesheet" type="text/css">
        <link href="<?php __APPFOLDER__; ?>layouts/default/src/css/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="<?php __APPFOLDER__; ?>layouts/default/src/css/singin.css" rel="stylesheet" type="text/css"> 
        <link href="<?php __APPFOLDER__; ?>layouts/default/src/css/bootstrap.css.map" rel="stylesheet" type="text/css">
        <script src="<?php __APPFOLDER__; ?>layouts/default/src/js/jquery-1.3.2.min" type="text/javascript" language="javascript"></script>
    </head>
    <body>

        <div class="container">
            <form class="form-signin" action="<?php __APPFOLDER__; ?>index.php?mod=sistema&c=login&a=logIn" method="post">
                <h2 class="form-signin-heading">Inicie sesi&oacute;n</h2>
                <label for="f_username" class="sr-only">Usuario</label>
                <input type="text" id="f_username" name="f_username" class="form-control" placeholder="Ingrese su usario" required autofocus>
                <label for="f_password" class="sr-only">Password</label>
                <input type="password" id="f_password" name="f_password" class="form-control" placeholder="Password" required>
                <button class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>
            </form>
            <?php if(!empty($error)){ ?>
            <div class="alert alert-danger" role="alert">
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                <span class="sr-only">Error:</span>
                <?php echo $error; ?>
            </div>
            <?php } ?>

        </div> <!-- /container -->
    </body>
</html>