<h1 class="nombre-pagina">Panel de Administracion</h1>
<p class="descripcion-pagina">Panel del administrador a la app</p>
<?php include_once __DIR__.'./../template/barra.php'; ?>
<h2>Buscar Citas</h2>
<div class="busqueda">
    <form action="" class="formulario">
        <div class="campo">
            <label for="fecha">Fecha</label>
            <input type="date" id="fecha" name="fecha" value="<?php echo $fecha; ?>">
        </div>
    </form>
</div>
<?php 
    if (count($citas) === 0) {
        echo "<h2>No hay Citas para estes día</h2>";
    }
?>
<div id="citas-admin">
    <ul class="citas">
        <?php 
            $idCita = 0;
            foreach ($citas as $key => $cita) {
                if ($idCita !== $cita->id) { 
                    $total = 0;
        ?>
            <li>
                    <div class="datos-cliente">
                        <p>ID: <br><span><?php echo $cita->id ?></span></p>
                        <p>Hora: <br><span><?php echo $cita->hora ?></span></p>
                        <p>Cliente: <br><span><?php echo $cita->cliente ?></span></p>
                        <p>Datos de Contacto: <br><span><?php echo $cita->datos ?></span></p>
                    </div>
                    <h3>Servicios</h3>
                <?php 
                    $idCita = $cita->id;
                    } /**fin de for */
                    $total += $cita->precio;
                ?>
                <div class="datoServicio">
                    <p class="servicio"> Servicio: <span><?php echo $cita->servicio; ?> </span></p>
                    <p class="servicio">$<?php echo $cita->precio;?>MXN</p>
                </div>
        <?php 
                $actual = $cita->id;
                $proximo = $citas[$key + 1]->id ?? 0;
                if (esUltimo($actual, $proximo)) {
        ?>
                    <p class="total">Total: <span>$<?php echo $total; ?> MXN</span></p>
                    <form action="/api/eliminar" method="POST">
                        <input type="hidden" name="id" value="<?php echo $cita->id; ?>">
                        <input type="submit" class="boton-eliminar" value="Eliminar">
                    </form>
        <?php        }
            } /**fin de foreach */
        ?>
    </ul>
</div> 
<?php
    $script = "<script src='build/js/buscador.js'></script>";
?>