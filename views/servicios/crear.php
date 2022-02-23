<h1 class="nombre-pagina">Panel de Administracion</h1>
<p class="descripcion-pagina">Crear nuevo servicio</p>
<?php 
    include_once __DIR__.'./../template/barra.php'; 
    include_once __DIR__.'./../template/alertas.php'; 
?>
<form action="/servicios/crear" class="formulario" method="POST">
    <?php include_once __DIR__ . '/formulario.php'; ?>
    <input type="submit" value="Guardar Servicio" class="boton">
</form>