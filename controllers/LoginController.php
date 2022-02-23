<?php 

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController{
    public static function login(Router $router){
        $alertas = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);
            $alertas = $auth->validarLogin();
            if (empty($alertas)) {
                /**comprobar que el usuario exista**/
                $usuario = Usuario::where('correo', $auth->correo);
                if ($usuario) {
                    if ($usuario->comprobarPasswordAndVerifiacdo($auth->password)) {
                        /**Autenticar el usuario**/
                        //session_start();
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre. " ". $usuario->apellido;
                        $_SESSION['correo'] = $usuario->correo;
                        $_SESSION['login'] = true;
                        /**Redireccionamiento**/
                        if ($usuario->admin === "1") {
                            $_SESSION['admin'] = $usuario->admin ?? null;
                            header('location: /admin');
                        } else {
                            header('location: /cita');
                        }
                    } else {
                        Usuario::setAlerta('error', 'usuario no encontrado');
                    }
                    
                } else {
                    Usuario::setAlerta('error','Usuario no encontrado');
                }                
            }
        }
        $alertas = Usuario::getAlertas();
        $router->render('auth/login',[
            'alertas' => $alertas
        ]);
    }
    public static function logout(){
        $_SESSION = [];
        header('Location: /');
    }
    public static function olvidePass(Router $router){
        $alertas = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);
            $alertas = $auth->validarCorreo();
            if (empty($alertas)) {
                $usuario = Usuario::where('correo',$auth->correo);
                if ($usuario && $usuario->confirmado === "1") {
                    /**Generar un nuevo token */
                    $usuario->crearToken();
                    $usuario->guardar();
                    /**ToDo: Enviar Correo**/
                    $email = new Email($usuario->correo, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();
                    /**Alerta de exitos**/
                    Usuario::setAlerta('exito','Instrucciones para recuperar contraseña se enviaron correctamente');
                }else{
                    Usuario::setAlerta('error', 'Usuario no encontrado o Sin confirmacion de correo');
                }
            }
        }
        $alertas = Usuario::getAlertas();
        $router->render('auth/olvidePass', [
            'alertas' => $alertas
        ]);
    }
    public static function recuperarPass(Router $router){
        $alertas = [];
        $error = false;
        $token = s($_GET['token']);
        /**Buscar usuario por su token**/
        $usuario = Usuario::where('token', $token);
        if (empty($usuario)) {
            Usuario::setAlerta('error','Token no Valido');
            $error = true;            
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //leer el nuevo pasword y guardarlo
            $password = new Usuario($_POST);
            $alertas = $password->validarPassword();
            if (empty($alertas)) {
                $usuario->password = null;
                $usuario->password = $password->password;
                $usuario->hashPassword();
                $usuario->token = null;
                $resultado = $usuario->guardar();
                if ($resultado) {
                    header('Location: /');
                }
            }
        }
        $alertas = Usuario::getAlertas();
        $router->render('auth/reuperarPass',[
            'alertas' => $alertas,
            'error' => $error
        ]);
    }
    public static function crearCuenta(Router $router){
        $usuario = new Usuario();
        /**Alertas vacias**/
        $alertas = [];
        if ($_SERVER['REQUEST_METHOD']=== 'POST') {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();
            /**revisar que alertas esté vacio */
            if (empty($alertas)) {
                /**Verificar que el usuario no esté registrado */
                $resultado = $usuario->existeUsuario();
                if ($resultado->num_rows) {
                    $alertas = Usuario::getAlertas();
                }else {
                    /**Hashear el Password**/
                    $usuario->hashPassword();
                    /**Generar un token unico**/
                    $usuario->crearToken();
                    /**Enviar el email con el token de verificacion**/
                    $email = new Email($usuario->correo, $usuario->nombre, $usuario->token);
                    $email->enviarConfirmacion();
                    /**Crear el nuevo usuario**/
                    $resultado = $usuario->guardar();
                    if ($resultado) {
                        header('Location: /mensaje');
                    }
                    //debuguear($usuario);
                }
            }
        }
        $router->render('auth/crearCuenta', [
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }
    public static function confirmarCuenta(Router $router){
        $alertas = [];

        $token = s($_GET['token']);

        $usuario = Usuario::where("token", $token);

        if (empty($usuario)) {
            /**Mostrar Mensaje de error**/
            Usuario::setAlerta('error','Error de confirmación, intenta de nuevo');
        }else {
            /**Modificar a usuario confirmado**/
            $usuario->confirmado = "1";
            $usuario->token = null;
            $usuario->guardar();
            Usuario::setAlerta('exito','Correo electronico confirmado Hola '.$usuario->nombre.'  tedamos la bienvenida');
        }
        /**obtener alertas**/
        $alertas = Usuario::getAlertas();
        /**Reenderizar pagina */
        $router->render('auth/confirmar-cuenta',[
            'alertas' => $alertas
        ]);
    }
    public static function mensaje(Router $router){
        $router->render('auth/mensaje');
    }
}