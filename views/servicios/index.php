<h1 class="nombre-pagina">Panel de Administracion</h1>
<h2>Servicios</h2>
<p class="descripcion-pagina">Control de Servicios</p>
<?php 
    include_once __DIR__.'./../template/barra.php';
?>

<ul class="servicios">
    <?php foreach ($servicios as $servicio) { ?>
        <li class="servicio">
            <div class="datos">
                <p>Nombre: <span><?php echo $servicio->nombre; ?></span></p>
                <p>Precio: <span>$<?php echo $servicio->precio; ?></span></p>
            </div>
            <div class="accciones">
                <a href="/servicios/actualizar?id=<?php echo $servicio->id;?>" class="boton">Actualizar</a>
                <form action="/servicios/eliminar" method="post">
                    <input type="hidden" name="id" value="<?php echo $servicio->id;?>">
                    <input type="submit" value="Eliminar" class="boton-eliminar">
                </form>
            </div>
        </li>
    <?php } ?>
</ul>