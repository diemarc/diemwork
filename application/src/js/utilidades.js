/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * 
 * Realiza una busqueda ejecutando un script php
 * @param {string} url: script php donde se va a ejecutar la busqueda
 * @param {string} f_campobusqueda : campo sobre el que se realizara la consulta
 * @param {type} f_stringbuscar : palabra a buscar
 * @param {type} div: id de la capa donde se va a cargar el resultado
 * @returns {ajax_call_html}
 */
function searchFieldAjax(url, f_campobusqueda, f_stringbuscar, divid) {

    $.ajax({
        type: 'get',
        url: url + '?' + f_campobusqueda + '=' + f_stringbuscar,
        dataType: 'html',
        success: function(data) {
            $('#' + divid).show('fast').html(data);

        }
    });
}
function buscarSugerencias(modulo, controlador, metodo, keyword, params) {

    var url = "index.php?mod" + modulo + "&c=" + controlador + "&a=" + metodo;
    url_completo = url + '&keyword=' + keyword;

    if (params != "") {
        url_completo += '&';
        url_completo += params;
    }
    if (keyword != "") {
        $.ajax({
            type: 'get',
            url: url_completo,
            dataType: 'html',
            success: function(data) {
                $('#resultado').show('fast').html(data);

            }
        });
    }
    else {
        closeDivAjax("resultado");
    }
}

function buscarPalabrasClaves(modulo, controlador, metodo, keyword,div, params) {

    var url = "index.php?mod" + modulo + "&c=" + controlador + "&a=" + metodo;
    url_completo = url + '&keyword=' + keyword;

    if (params != "") {
        url_completo += '&';
        url_completo += params;
    }
    if (keyword != "") {
        $.ajax({
            type: 'get',
            url: url_completo,
            dataType: 'html',
            success: function(data) {
                $('#'+div).show('fast').html(data);

            }
        });
    }
    else {
        closeDivAjax(+div);
    }
}


function buscar(modulo, controlador, metodo, keyword, divmostrar, divocultar, params) {

    var url = "/application/index.php?mod" + modulo + "&c=" + controlador + "&a=" + metodo;
    url_completo = url + '&keyword=' + keyword;

    $('#' + divocultar).hide('fast');
    $('#btnCrear').show('fast');

    if (params != "") {
        url_completo += '&';
        url_completo += params;
    }
    if (keyword != "") {
        $.ajax({
            type: 'get',
            url: url_completo,
            dataType: 'html',
            success: function(data) {
                $('#' + divmostrar).show('fast').html(data);

            }
        });
    }
    else {
        
        closeDivAjax(divmostrar);
        closeDivAjax("btnCrear");
        showDivAjax(divocultar);
    }
}

/*Capturar tabulador*/


function capturarEventoTecla(event)
{
    var t = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
    if (t == 9)
    {
        $("#result1").addClass("stListOver");
    }
    return true;
}





function checkFormAjax(url, form, divid) {

    $.ajax({
        type: 'post',
        url: url,
        data: $('#' + form).serialize(),
        success: function(data) {
            $('#' + divid).show('fast').html(data);

        }
    });
}

/**
 * Oculta/Cierra un div en el cual se ha cargado un contenido via ajax
 * @param {string} divid : id de la capa a cerrar
 * @returns {event_close}
 */
function closeDivAjax(divid) {
    $('#' + divid).css('display', 'none');
}
function cerrarDivSugerencia(id) {
    $('#resultado').css('display', 'none');
    $('#' + id).attr('value', '');
}
function showDivAjax(divid) {
    $('#' + divid).css('display', 'inline');
}

/**
 * carga un script dentro de un div via ajax
 * @param {string} url del script a cargar
 * @param {string} id del div donde se quiere cargar el script
 * @returns {ajax_content}
 */
function openDivAjaxMvc(mod, c, a, params, divid) {
    //armamos el mvc

    url = "index.php?mod" + mod + "&c=" + c + "&a=" + a + "&" + params;

    $.ajax({
        type: 'get',
        url: url,
        dataType: 'html',
        success: function(data) {
            $('#' + divid).css('display', 'inline').html(data);
        }
    });


}
function executeAjaxScriptMvc(mod, c, a, params) {
    //armamos el mvc

    url = "index.php?mod" + mod + "&c=" + c + "&a=" + a + "&" + params;

    $.ajax({
        type: 'get',
        url: url,
        dataType: 'html',
        success: function(data) {
            $('#resultado').css('display', 'inline').html(data);
        }
    });


}




function CalcularEstimacion() {
    var oEstimacion = document.getElementById('f_estimacion');
    var oProbabilidad = document.getElementById('f_probabilidad');
    var oSeveridad = document.getElementById('f_severidad');
    var intValue;
    if (oProbabilidad.value != "" && oSeveridad.value != "") {
        intValue = parseInt(oProbabilidad.value) + parseInt(oSeveridad.value);
        oEstimacion.value = intValue;
    }

    if (intValue > 1) {
        showDivAjax("plan");
    }
    else {
        closeDivAjax("plan");
    }

}


function agregarElement(id, field, idbutton) {
    var nextinput = 0;
    nextinput++;
    campo = '<li id="' + id + '" class="blackFont">' + field + '<input type="checkbox" name="f_acciones[]" id="f_acciones" value="' + id + '" checked " /></li>';
    $("#cursosSeleccionados").append(campo);
    closeDivAjax(idbutton);

}


function limpiarContenido(id){
    $("#"+id).val("");
}