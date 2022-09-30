<div class="container cont-listado">
    <h1>Covid</h1>
    <div class="header-container">
        <!--<h2>Pruebas Realizadas Hoy</h2>-->

        <input type="date" name="FechaFiltro" id="FechaFiltroC" class="input-filtro">
        <button type="button" class="btn-primary" id="BtnAddPruebaC">Nuevo</button>
    </div>
    <div class="body-container">
        <table class="t-listado">
            <thead>
                <tr>
                    <th>IPRESS</th>
                    <th>BENEFICIARIO</th>
                    <th>PCR</th>
                    <th>ANT</th>
                    <th>SER</th>
                    <th>Total</th>
                    <? session_start();
                    if ($_SESSION['tipouser'] == 'ADMINISTRADOR') { ?>
                        <th>Edit</th>
                        <th>Elim.</th>
                    <? } ?>
                </tr>
            </thead>
            <tbody id="tb-listadoC">
                <!--Ajax-->
                <tr>
                    <td rowspan="2">
                        <h3>IPRESS</h3>
                        <p>Digitaror Nombre, Apellido</p>
                        <p>25/07/2022 16:12</p>
                    </td>
                    <td>Titulares</td>
                    <td>PCR</td>
                    <td>ANT</td>
                    <td>SER</td>
                    <td>Total</td>
                    <?
                    if ($_SESSION['tipouser'] == 'ADMINISTRADOR') { ?>
                        <td rowspan="2">Edit</td>
                        <td rowspan="2">Elim.</td>
                    <? } ?>
                </tr>
                <tr>
                    <td>Familiares</td>
                    <td>PCR</td>
                    <td>ANT</td>
                    <td>SER</td>
                    <td>Total</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<script>
    FechaFiltroC.max = new Date().toISOString().split('T')[0]
    CargarFechaActual('FechaFiltroC')
    tb = '#tb-listadoC';
    fecha = $('#FechaFiltroC').val();
    CargarListadoHoy(fecha, 'C', tb);
</script>