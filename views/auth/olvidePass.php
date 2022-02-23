<h1 class="nombre-pagina">Recuperar Contraseña</h1>
<p class="descripcion-pagina">Ingresa tu E-mail para recuperar tu contraseña</p>

<?php include_once __DIR__.'/../template/alertas.php' ?>
<form action="/olvide_pass" class="formulario" method="POST">
    <div class="campo">
        <label for="correo">Correo</label>
        <input type="email" id="correo" name="correo" placeholder="Tu correo">
    </div>
    <input type="submit" value="Enviar instrucciones" class="boton">
</form>
<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia sesión</a>
    <a href="/crear-cuenta">¿No tienes una cuenta? Crea una cuenta</a>
</div>