<?php
namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email{
    public $email;
    public $nombre;
    public $token;
    public function __construct($email, $nombre, $token){
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }
    public function enviarConfirmacion(){
        /**Crear el objeto de email**/
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'c7b828b122b28e';
        $mail->Password = 'dc0e0ebf71a10d';

        /**Datos para envio**/
        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress($this->email,'AppSalon.com');
        $mail->Subject = 'confirma tu cuenta';

        /**set HTML **/
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        /**cuerpo del mensaje**/
        $contenido = "<html>";
        $contenido .= "<p><strong>Hola ".$this->nombre."</strong> Has creado tu cuenta en App Salon, Solo debes confirmarla presionando el siguiente enlace</p>";
        $contenido .= "<p>Presiona aquí: <a href='http://127.0.0.1:8000/confirmar-cuenta?token=". $this->token ."'>Confirmar cuenta</a></p>";
        $contenido .= "<p>Si tu no hiciste el registro puedes ignorar este mensaje</p>";
        $contenido .= "</html>";
        /**Asignacion del contenido */
        $mail->Body = $contenido;
        /**enviar correo**/
        $mail->send();
    }
    public function enviarInstrucciones(){
        /**Crear el objeto de email**/
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'c7b828b122b28e';
        $mail->Password = 'dc0e0ebf71a10d';

        /**Datos para envio**/
        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress($this->email,'AppSalon.com');
        $mail->Subject = 'Restablece tu password';

        /**set HTML **/
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        /**cuerpo del mensaje**/
        $contenido = "<html>";
        $contenido .= "<p><strong>Hola ".$this->nombre."</strong> Has solicitado restablecer tu contraseña</p>";
        $contenido .= "<p>Sigue el siguiente enlace para restablecer tu contraseña...</p>";
        $contenido .= "<p>Presiona aquí: <a href='http://127.0.0.1:8000/recuperar_pass?token=". $this->token ."'>Restablecer contraseña</a></p>";
        $contenido .= "<p>Si tu no solicitaste restablecer tu contraseña ignora este mensaje</p>";
        $contenido .= "</html>";
        /**Asignacion del contenido */
        $mail->Body = $contenido;
        /**enviar correo**/
        $mail->send();        
    }
}
