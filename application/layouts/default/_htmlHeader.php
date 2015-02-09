<?php (!defined('__APPFOLDER__')) ? exit('No esta permitido el acceso directo a este archivo') : ""; ?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-15" />
        <meta name="lang" content="es" />
        <meta name="author" content="iprprevencion.com" />
        <meta name="organization" content="IPR" />
        <meta name="locality" content="Madrid" />
        <title>KeranaWork -</title>
        <link href="<?php __APPFOLDER__; ?>layouts/default/src/css/bootstrap-theme.css" rel="stylesheet" type="text/css">
        <link href="<?php __APPFOLDER__; ?>layouts/default/src/css/bootstrap-theme.css.map" rel="stylesheet" type="text/css">
        <link href="<?php __APPFOLDER__; ?>layouts/default/src/css/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="<?php __APPFOLDER__; ?>layouts/default/src/css/bootstrap.css.map" rel="stylesheet" type="text/css">
        <script src="<?php __APPFOLDER__; ?>layouts/default/src/js/jquery-1.3.2.min" type="text/javascript" language="javascript"></script>
    </head>
    <body>
        <?php if($_SESSION["logged_in"] == 1) { ?>
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Administraci&oacute;n de Kerana</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="#">Home</a></li>
                        <li><a href="#about">About</a></li>
                        <li><a href="#contact">Contact</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Dropdown <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">Action</a></li>
                                <li><a href="#">Another action</a></li>
                                <li><a href="#">Something else here</a></li>
                                <li class="divider"></li>
                                <li class="dropdown-header">Nav header</li>
                                <li><a href="#">Separated link</a></li>
                                <li><a href="#">One more separated link</a></li>
                            </ul>
                        </li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </nav>
        <?php } ?>

