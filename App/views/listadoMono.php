<div class="container cont-listado">
    <h1>V. Mono</h1>
    <div class="header-container">
        <input type="date" name="FechaFiltro" id="FechaFiltroM" class="input-filtro">
        <button type="button" class="btn-primary vmono" id="BtnAddPruebaM">Nuevo</button>
    </div>
    <div class="body-container">
        <table class="t-listado vmono">
            <thead>
                <tr>
                    <th>IPRESS</th>
                    <th>BENEFICIARIO</th>
                    <th>PCR</th>
                    <? session_start();
                    if ($_SESSION['tipouser'] == 'ADMINISTRADOR') { ?>
                        <th>Edit</th>
                        <th>Elim.</th>
                    <? } ?>
                </tr>
            </thead>
            <tbody id="tb-listadoM">
                <!--Ajax-->
                <tr>
                    <td rowspan="2">
                        <h3>IPRESS</h3>
                        <p>Digitaror Nombre, Apellido</p>
                        <p>25/07/2022 16:12</p>
                    </td>
                    <td>Titulares</td>
                    <td>PCR</td>
                    <?
                    if ($_SESSION['tipouser'] == 'ADMINISTRADOR') { ?>
                        <td rowspan="2">Edit</td>
                        <td rowspan="2">Elim.</td>
                    <? } ?>
                </tr>
                <tr>
                    <td>Familiares</td>
                    <td>PCR</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<script>
    FechaFiltroM.max = new Date().toISOString().split('T')[0];
    CargarFechaActual('FechaFiltroM');
    tb = '#tb-listadoM';
    fecha = $('#FechaFiltroM').val();
    CargarListadoHoy(fecha, 'M', tb);
</script>