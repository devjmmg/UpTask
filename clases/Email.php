<?php

namespace Clases;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class Email {
    
    protected $nombre;
    protected $apellidos;
    protected $email;
    protected $token;
    
    public function __construct($nombre, $apellidos, $email, $token)
    {
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->email = $email;
        $this->token = $token;
    }
    
    public function enviarEmailRegistro() {
        
        $mail = new PHPMailer(true);
        
        try{
            
            //Server settings
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'sandbox.smtp.mailtrap.io';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'f9278cf9864807';                     //SMTP username
            $mail->Password   = '0c78a827b2a3f6';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;           //Enable implicit TLS encryption
            $mail->Port       = 2525;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            
            //Recipients
            $mail->setFrom('admin@correo.com', 'UpTask');
            $mail->addAddress('admin@correo.com', 'UpTask');     //Add a recipient
            
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->CharSet = "UTF-8"; //Mensajes con acentos
            $mail->Subject = 'Confirmar cuenta de UpTask';
            
            $contenido = "
                            <html>
                                <head>
                                    <style>
                                        .container {
                                            padding: 20px;
                                            background-color: #f9f9f9;
                                            font-family: Arial, sans-serif;
                                        }
                                        .content {
                                            padding: 20px;
                                        }
                                        .content p {
                                            margin-bottom: 15px;
                                        }
                                        .content strong {
                                            color: #0da6f3;
                                        }
                                        .btn {
                                            display: inline-block;
                                            padding: 8px 16px;
                                            background-color: #0da6f3;
                                            color: #fff;
                                            text-decoration: none;
                                            border-radius: 4px;
                                        }
                                        .btn:hover {
                                            background-color: #0c95db;
                                        }
                                    </style>
                                </head>
                                <body>
                                    <div class='container'>
                                        <div class='content'>
                                            <p><strong>Hola:</strong> " . htmlspecialchars($this->nombre) . " " . htmlspecialchars($this->apellidos) .  "</p>
                                            <p>Has creado tu cuenta en UpTask. Por favor, confírmala haciendo clic en el siguiente enlace:</p>
                                            <p><a class='btn' href='http://localhost:3000/confirm_account?token=".urlencode($this->token)."'>Confirmar cuenta</a></p>
                                            <p>Si no creaste esta cuenta, puedes ignorar este mensaje.</p>
                                        </div>
                                    </div>
                                </body>
                            </html>
                            ";
            
            $mail->Body    = $contenido;
            
            $mail->send();

            return true;
            
        } catch (Exception $e) {
            
            //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";

            return false;
            
        }
        
    }

    public function enviarEmailRestablecer() {

        $mail = new PHPMailer(true);
        
        try{
            
            //Server settings
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'sandbox.smtp.mailtrap.io';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'f9278cf9864807';                     //SMTP username
            $mail->Password   = '0c78a827b2a3f6';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;           //Enable implicit TLS encryption
            $mail->Port       = 2525;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            
            //Recipients
            $mail->setFrom('admin@correo.com', 'UpTask');
            $mail->addAddress('admin@correo.com', 'UpTask');     //Add a recipient
            
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->CharSet = "UTF-8"; //Mensajes con acentos
            $mail->Subject = 'Restablecer cuenta de UpTask';
            
            $contenido = "
                            <html>
                                <head>
                                    <style>
                                        .container {
                                            padding: 20px;
                                            background-color: #f9f9f9;
                                            font-family: Arial, sans-serif;
                                        }
                                        .content {
                                            padding: 20px;
                                        }
                                        .content p {
                                            margin-bottom: 15px;
                                        }
                                        .content strong {
                                            color: #0da6f3;
                                        }
                                        .btn {
                                            display: inline-block;
                                            padding: 8px 16px;
                                            background-color: #0da6f3;
                                            color: #fff;
                                            text-decoration: none;
                                            border-radius: 4px;
                                        }
                                        .btn:hover {
                                            background-color: #0c95db;
                                        }
                                    </style>
                                </head>
                                <body>
                                    <div class='container'>
                                        <div class='content'>
                                        <p><strong>Hola:</strong> " . htmlspecialchars($this->nombre) . " " . htmlspecialchars($this->apellidos) .  "</p>
                                        <p>Has solicitado restablecer tu contraseña. Por favor, haz clic en el siguiente enlace para proceder:</p>
                                        <p><a class='btn' href='http://localhost:3000/reset_password?token=".urlencode($this->token)."'>Restablecer contraseña</a></p>
                                        <p>Si no realizaste esta solicitud, puedes ignorar este mensaje.</p>
                                    </div>
                                </body>
                            </html>
                            ";
            
            $mail->Body    = $contenido;
            
            $mail->send();

            return true;
            
        } catch (Exception $e) {
            
            //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";

            return false;
            
        }
        
    }
    
}