<?php
namespace Model;
class Usuario extends ActiveRecord{
    /**Base de datos**/
    protected static $tabla =  'usuarios';
    protected static $columnasDB = ['id','nombre','apellido','correo','password','telefono','admin','confirmado','token'];

    public $id;
    public $nombre;
    public $apellido;
    public $correo;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    public function __construct($args = []) {
        $this->id=$args['id'] ?? null;
        $this->nombre=$args['nombre'] ?? '';
        $this->apellido=$args['apellido'] ?? '';
        $this->correo=$args['correo'] ?? '';
        $this->password=$args['password'] ?? '';
        $this->telefono=$args['telefono'] ?? '';
        $this->admin=$args['admin'] ?? '0';
        $this->confirmado=$args['confirmado'] ?? '0';
        $this->token=$args['token'] ?? '';
    }
    /**Mensajes de validacion para la creacion de una cuenta**/
    public function validarNuevaCuenta(){
        if (!$this->nombre) {
            self::$alertas['error'][] = "El Nombre es Obligatorio";
        }
        if (!$this->apellido) {
            self::$alertas['error'][] = "El Apellido es Obligatorio";
        }
        if (!$this->correo) {
            self::$alertas['error'][] = "El Correo es Obligatorio";
        }
        if (!$this->password) {
            self::$alertas['error'][] = "La Contraseña es Obligatoria";
        }
        if (!$this->telefono) {
            self::$alertas['error'][] = "El Telefono es Obligatorio";
        }
        if (strlen($this->password) < 6) {
            self::$alertas['error'][] = "La contraseña debe de tener mas de 6 caracteres";
        }
        return self::$alertas;
    }
    /**Mensajes de validacion para iniciar sesión**/
    public function validarLogin(){
        if (!$this->correo) {
            self::$alertas['error'][] = "El Correo es Obligatorio";
        }
        if (!$this->password) {
            self::$alertas['error'][] = "La Contraseña es Obligatoria";
        }
        return self::$alertas;
    }
    /**Validar correo para cambiar password**/
    public function validarCorreo(){
        if (!$this->correo) {
            self::$alertas['error'][] = "El Correo es Obligatorio";
        }
        return self::$alertas;
    }
    public function validarPassword(){
        if (!$this->password) {
            self::$alertas['error'][] = "La Contraseña es Obligatoria";
        }
        if (strlen($this->password)<6) {
            self::$alertas['error'][] = "La contraseña debe de tener mas de 6 caracteres ";
        }
        return self::$alertas;
    }
    /**Revisa si el usuario ya existe**/
    public function existeUsuario(){
        $query = " SELECT * FROM ".self::$tabla." WHERE correo = '". $this->correo ."' LIMIT 1";
        $resultado = self::$db->query($query);
        if ($resultado->num_rows) {
            self::$alertas['error'][] = 'El usuario ya esta registrado';
        }
        return $resultado;
    }
    public function hashPassword(){
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }
    public function crearToken(){
        $this->token = uniqid();
    }
    /**Comprobar y password y validar login */
    public function comprobarPasswordAndVerifiacdo($password){
        $resultado = password_verify($password, $this->password);
        if (!$resultado || !$this->confirmado) {
            self::$alertas['error'][] = 'Password incorrecto o tu cuenta no ha sido confirmada';
        } else {
            return true;
        }
        
    }
    
}
