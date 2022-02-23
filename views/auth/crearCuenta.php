<h1 class="nombre-pagina" >Crear Cuenta de Ususario</h1>
<p class="descripcion-pagina">Ingresa Los datos solicitados para crear una cuenta nueva</p>
<?php 
    include_once __DIR__.'/../template/alertas.php';
?>
<form action="/crear-cuenta" class="formulario" method="POST">
    <div class="campo">
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre" placeholder="Tu nombre" value="<?php echo s($usuario->nombre); ?>">
    </div>
    <div class="campo">
        <label for="apellido">Apellido</label>
        <input type="text" id="apellido" name="apellido" placeholder="Tu apellido" value="<?php echo s($usuario->apellido); ?>">
    </div>
    <div class="campo">
        <label for="telefono">Telefono</label>
        <input type="tel" id="telefono" name="telefono" placeholder="Tu Telefono" value="<?php echo s($usuario->telefono); ?>">
    </div>
    <div class="campo">
        <label for="correo">Correo</label>
        <input type="email" id="correo" name="correo" placeholder="Tu Correo" value="<?php echo s($usuario->correo); ?>">
    </div>
    <div class="campo">
        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" placeholder="Tu Contraseña" value="<?php echo s($usuario->password); ?>">
    </div>
    <input type="submit" value="Crear Cuenta" class="boton">
</form>
<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia sesión</a>
    <a href="/olvide_pass">¿Olvidate tu contraseña? Recupera tu contraseña</a>
</div>