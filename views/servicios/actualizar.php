<h1 class="nombre-pagina">Panel de Administracion</h1>
<p class="descripcion-pagina">Actualizar Servicio</p>
<?php 
    include_once __DIR__.'./../template/barra.php'; 
    include_once __DIR__.'./../template/alertas.php'; 
?>
<form class="formulario" method="POST">
    <?php include_once __DIR__ . '/formulario.php'; ?>
    <input type="submit" value="Actualizar Servicio" class="boton">
</form>