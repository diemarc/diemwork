
function loadController(param_module, param_controlador, param_action, params) {

    var url = "/application/index.php";
    url_formado = url + '?mod=' + param_module + '&c=' + param_controlador + '&a=' + param_action;

    if (params != "") {
        url_formado += '&';
        url_formado += params;
    }

    return window.open(url_formado, '_self');

}

