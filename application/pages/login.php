<?php
session_cache_limiter('nocache');
session_cache_expire(60);
session_start();

require_once($_SERVER['DOCUMENT_ROOT'] . "/../config/app_config.inc");
require_once($_SERVER['DOCUMENT_ROOT'] . "/../config/exceptions.inc");
require_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/securesession.class.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/genericdb.class.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/../includes/utils.class.php");
//echo "Servicio (online) :):):):) ";
$error = '';
// Parametros de entrada
// Verifica si el usuario esta baneado:
if (isset($_SESSION['banned']) && $_SESSION['banned'] > time()) {
    header("Location: http://${_SERVER['HTTP_HOST']}/error/banned.php");
    die();
}
$ip = $_SERVER['REMOTE_ADDR'];
if (isset($_REQUEST['username'])) {
    // Conexi�n a la BBDD
    $conn = new genericDB();

    if (!$r = $conn->connect($sys_cgf_db["db_type"], $sys_cgf_db["hostname"], $sys_cgf_db["port"], $sys_cgf_db["database"], $sys_cgf_db["username"], $sys_cgf_db["password"])) {
        $error = "Error de conexion a la base de datos";
    } else {
        // Verifica las ip bloqueadas
        $sqlstmt = "SELECT A.* "
                . " FROM t_sys_black_ip A "
                . " WHERE A.ip = '$ip' ";

        if (!$rsip = $conn->open_query($sqlstmt)) {
            header("Location: http://${_SERVER['HTTP_HOST']}/logout.php");
            die();
        }
        if (!$rsip->fetch_array()) {
            $ipblock = false;
        } else {
            $ipblock = true;
            header("Location: http://${_SERVER['HTTP_HOST']}/error/ipbanned.php");
            die();
        }
        if (!$ipblock) {

            // Verifica los usuarios bloqueados
            $sqlstmt = "UPDATE t_empleado "
                    . " SET bloqueado = 0"
                    . " WHERE usuario != '${sys_cgf_app['admin_user']}' "
                    . "  AND usuario IN (SELECT s.usuario "
                    . "                  FROM (SELECT t.usuario, t.expire, min(datediff(now(), l.fecha_login)) dias_sin_login "
                    . "                        FROM t_empleado t LEFT JOIN t_sys_login_log l ON (t.usuario = l.usuario) "
                    . "                        WHERE l.fecha_login IS NOT NULL "
                    . "                          AND t.expire > 0 "
                    . "                        GROUP BY t.usuario, t.expire) s "
                    . "                    WHERE s.dias_sin_login > s.expire)";

            if (!$rstemp = $conn->run_query($sqlstmt)) {
                header("Location: http://${_SERVER['HTTP_HOST']}/logout.php");
                die();
            }


            $username = strtoupper($_REQUEST["username"]);
            $user = $_REQUEST["username"];
            // Es el ADMINISTRADOR ?
            $IS_SUPER_ADMIN = ($username == $sys_cgf_app["admin_user"]);

            $sqlstmt = "SELECT A.* FROM t_empleado A WHERE A.usuario = '${username}' ";
            if (!$IS_SUPER_ADMIN)
                $sqlstmt .= " AND A.fecha_baja IS NULL AND A.bloqueado = 0";

            $rs = $conn->open_query($sqlstmt);
            $pass = $_REQUEST["password"];
            $cryptpasswd = sha1($_REQUEST["password"]);

            if ($rs->fetch_array()) {
                // lets verify if user is a webuser.
                $user_web = $rs->query_field("user_web");
                if ($user_web == 1) {
                    header("Location: http://clientes.iprprevencion.com/login.php?username=$user&password=$pass");
                }
                if ($rs->query_field("password") == $cryptpasswd)
                    $loginok = true; else
                    $loginok = false; 
            }
            else {
                if ($IS_SUPER_ADMIN && ($cryptpasswd == $sys_cgf_app['admin_default_password']))
                    $loginok = true;
                else
                    $loginok = false;
            }

            if ($loginok) {
                // Obtener el �ltimo login
                $sqlstmt = "SELECT max(B.fecha_login) lastlogin "
                        . " FROM t_empleado A, t_sys_login_log B "
                        . " WHERE A.usuario = B.usuario "
                        . "   AND A.usuario = '${username}'";
                $rsLog = $conn->open_query($sqlstmt);
                if ($rsLog->fetch_array())
                    $lastlogin = $rsLog->query_field("lastlogin");
                else
                    $lastlogin = $rs->query_field("fecha_alta");

                // Crear una sesi�n segura
                $ss = new SecureSession();
                $ss->check_browser = true;
                $ss->check_ip_blocks = 2;
                $ss->secure_word = $sys_cgf_app['secure_word'];
                $ss->regenerate_id = true;
                $ss->Open();

                // Asignar los valores de las variables de sesi�n a usar en la aplicaci�n
                $_SESSION["S_lastlogin"] = $lastlogin;

                if ($IS_SUPER_ADMIN) {
                    $_SESSION["S_usuario"] = $sys_cgf_app["admin_user"];
                    $_SESSION["S_nombre"] = 'Administrador';
                    $_SESSION["S_apellidos"] = '';
                    $_SESSION["S_admin"] = 1;
                    $_SESSION["S_cambia_password"] = false;
                    $_SESSION["S_modulo_entrada"] = "";
                } else {
                    $_SESSION["S_usuario"] = $username;
                    $_SESSION["S_nombre"] = $rs->query_field("nombre");
                    $_SESSION["S_apellidos"] = $rs->query_field("apellidos");
                    $_SESSION["S_admin"] = 0;
                    // 1 = usuarios normales de aplicacion ; 2= clientes
                    $_SESSION["S_usertype"] = 1;
                    $_SESSION["S_cambia_password"] = $rs->query_field("expire") < 0;
                    $_SESSION["S_modulo_entrada"] = $rs->query_field("modulo_entrada");
                }

                // Fecha/hora del inicio de la sesi�n
                $_SESSION["S_timestamp"] = date("Y-n-j H:i:s");
                //Caducidad de la sesion
                $_SESSION["S_caducidad_sesion"] = $sys_cgf_app["caducidad_sesion"];

                // Otras variables
                $_SESSION["S_empresa"] = "";

                // Grabar el registo del login
                $conn->start_transaction();

                $sqlstmt = "INSERT INTO t_sys_login_log (usuario, fecha_login, origen) VALUES "
                        . " ('" . $_SESSION["S_usuario"] . "', " . $_GENERICDB[$sys_cgf_db['db_type']]['TIMESTAMP']
                        . ", '" . $_SERVER['REMOTE_ADDR'] . "')";
                if ($rstemp = $conn->run_query($sqlstmt)) {
                    $conn->commit();
                    $_SESSION['logged_in'] = true;
                } else {
                    $conn->rollback();
                    $_SESSION['logged_in'] = false;
                }
                if ($user_web == 1) {
                     header("Location: http://clientes.iprprevencion.com/login.php?username=$user&password=$pass");
                }
                else
                    header('Location: index.php');
                die();
            }
            else
                $error = 'Usuario y/o contrase�a incorrecto';
            // Si los intentos supera los 3 intentos le baneamos			
            if (!isset($_SESSION['intentos']))
                $_SESSION['intentos'] = 0;
            // Incrementar el contador
            ++$_SESSION['intentos'];
            if ($_SESSION['intentos'] == 5) {
                // Banear por 15 min
                // Grabar el registo del login de error
                $conn->start_transaction();

                $sqlstmt1 = "INSERT INTO t_sys_error_log (usuario, fecha_intento, origen) VALUES "
                        . " ('$username', " . $_GENERICDB[$sys_cgf_db['db_type']]['TIMESTAMP']
                        . ", '" . $_SERVER['REMOTE_ADDR'] . "')";
                if ($rstempError = $conn->run_query($sqlstmt1)) {
                    $conn->commit();
                    $conn->rollback();
                }


                // bloqueamos la ip
                $conn->start_transaction();

                $sqlstmt1 = "INSERT INTO t_sys_black_ip (id_block, fecha_block, ip) VALUES "
                        . " (id_block, " . $_GENERICDB[$sys_cgf_db['db_type']]['TIMESTAMP']
                        . ", '" . $_SERVER['REMOTE_ADDR'] . "')";
                if ($rstempErrorIP = $conn->run_query($sqlstmt1)) {
                    $conn->commit();
                    $conn->rollback();
                }


                // bloqueamos al usuario
                $sqlstmt = "UPDATE t_empleado "
                        . " SET bloqueado = 1"
                        . " WHERE usuario = '$username'";

                if ($rstempBlock = $conn->run_query($sqlstmt)) {
                    $conn->commit();
                }

                // tambien le baneamos
                $_SESSION['banned'] = time() + 900;
                header("Location: http://${_SERVER['HTTP_HOST']}/error/banned.php");
                die();
            }
        }
    }
    if ($ipblock) {
        header("Location: http://${_SERVER['HTTP_HOST']}/error/ipbanned.php");
        die();
    }
}
?>
<html>
    <head>
        <title>IPR</title>
        <script type="text/javascript">
            function SubmitHandler() {
                document.login_form.username.focus();
                return document.login_form.username.value != "";
            }
        </script>
        <style type="text/css">
            <!--
            .mini {font-family: Arial, Helvetica, sans-serif; font-size: 11px; font-weight: normal; text-decoration: none }
            .btEntrar {
                font-family: Geneva, Arial, Helvetica, sans-serif;
                font-size: 11px;
                color: #006600;
                font-weight: bold;
            }
            .error {
                font-family: Geneva, Arial, Helvetica, sans-serif;
                font-size: 12px;
                font-weight: bold;
                color: #FF0000;
                text-decoration: blink;
            }
            .loginbox {
                border: 1px solid #333333;
            }
            body {
                background-color: #FFFFFF;
            }
            #tblFondo {
                height: 200px;
                width: 400px;
                background-image: url(/img/ipr_big.jpg);
                background-repeat: no-repeat;
                background-position: left top;
            }
            -->
        </style>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
    <body onLoad="javascript:document.login_form.username.focus();">
        <table width="400" border="0" align="center" cellspacing="0" cellpadding="2">
            <tr>
                <td align="right" valign="bottom"><table border="0" cellpadding="0" cellspacing="0" id="tblFondo">
                        <tr>
                            <td width="50%">&nbsp;</td>
                            <td align="right" valign="bottom"><table border="0" cellspacing="4">
                                    <form name="login_form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                        <tr>
                                            <td align="right"><font face="Arial" size="2" color="#000000" class="mini"><strong>Usuario</strong></font></td>
                                            <td align="left"><input name="username" size="15" maxlength="20" class="mini"></td>
                                        </tr>
                                        <tr>
                                            <td align="right"><font face="Arial" size="2" color="#000000" class="mini"><strong>Contrase&ntilde;a</strong></font></td>
                                            <td align="left"><input type="password" name="password" size="15" maxlength="20" class="mini"></td>
                                        </tr>
                                        <tr>
                                            <td align="right">&nbsp;</td>
                                            <td align="right"><input name="submit" type="submit" class="btEntrar" value="Entrar &gt;&gt;" onClick="javascript:return SubmitHandler();" /></td>
                                        </tr>
                                    </form>
                                </table></td>
                        </tr>
                    </table></td>
            </tr>
            <tr>
                <td align="center" class="error"><?php if (!empty($error)) echo $error; else echo "&nbsp;" ?></td>
            </tr>
        </table>
    </body>
</html>
