<h1 class="nombre-pagina">Reestablecer Contraseña</h1>
<p class="descripcion-pagina">Ingresa la nueva Contraseña</p>

<?php include_once __DIR__.'/../template/alertas.php' ?>
<?php if($error) {return;} ?> 
<form class="formulario" method="POST">
    <div class="campo">
        <label for="password">Nueca Contraseña</label>
        <input type="password" id="password" name="password" placeholder="Nueva Contraseñana">
    </div>
    <input type="submit" value="Reestablecer Contraseñam" class="boton">
</form>
<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia sesión</a>
    <a href="/crear-cuenta">¿No tienes una cuenta? Crea una cuenta</a>
</div>