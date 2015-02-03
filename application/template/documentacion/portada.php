<page backtop="10mm" backbottom="1mm" backleft="5mm" backright="5mm" style="font-size: 11pt">
    <div class="portada">
        <h1 class="portadaH1"> <?php echo $nombre_documento; ?></h1>
        <h2 class="portadaH2"><?php echo $nombre_empresa; ?></h2>
        <br/>
    </div>
    <table class="tablaPortadaFirma" align="center">
        <tr>
            <th>Aprobado por</th>
            <th>Revisado por</th>
        </tr>
        <tr>
            <td class="size11"><?php echo $nombre_empresa; ?></td>
            <td class="size11"><?php echo $nombre_tecnico; ?></td>
        </tr>
        <tr>
            <td class="size11"></td>
            <td class="size11"><?php echo $fecha_evaluacion; ?></td>
        </tr>
    </table>
</page>

