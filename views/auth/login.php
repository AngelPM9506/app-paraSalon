
    <h1 class="nombre-pagina">inicio de sesión</h1>
    <p class="descripcion-pagina">Inicia sesión con tus datos</p>
    <?php include_once __DIR__.'/../template/alertas.php' ?>
    <form method="POST" action="/" class="formulario">
        <div class="campo">
            <label for="correo">Email</label>
            <input type="email" id="correo" name="correo" placeholder="Tu Email, correo electronico, etc.">
        </div>
        <div class="campo">
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" placeholder="Tu Contraseña">
        </div>
        <input type="submit" class="boton" value="Iniciar Sesión">
    </form>
    <div class="acciones">
        <a href="/crear-cuenta">¿Aun no tienes una cuenta? Crea Cuenta</a>
        <a href="/olvide_pass">¿Olvidate tu contraseña? Recupera tu contraseña</a>
    </div>