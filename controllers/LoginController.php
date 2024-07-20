<?php

namespace Controllers;

use Clases\Email;
use Model\Usuario;
use MVC\Router;

class LoginController {
    
    public static function login(Router $router) {
        
        $usuario = new Usuario;
        
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarInicioSesion();
            
            if(empty($alertas)) {
                
                $auth = Usuario::where("email",$usuario->email);
                
                if($auth) {
                    
                    if($auth->confirmado) {
                        
                        if($auth->verificarPassword($usuario->password)) {

                            session_start();

                            $_SESSION["id"] = $auth->id;
                            $_SESSION["nombre"] = $auth->nombre;
                            $_SESSION["apellido"] = $auth->apellidos;
                            $_SESSION["email"] = $auth->email;
                            $_SESSION["login"] = true;

                            header("Location: /dashboard");
                            
                        }else{
                            
                            $alertas = Usuario::setAlerta("error","El correo electrónico o la contraseña son incorrectas");
                            
                        }
                        
                    }else{
                        
                        $alertas = Usuario::setAlerta("error","El usuario aún no ha confirmado su cuenta");
                        
                    }
                    
                }else{
                    
                    $alertas = Usuario::setAlerta("error","El correo electrónico o la contraseña son incorrectas");
                    
                }
                
            }
        }
        
        $alertas = Usuario::getAlertas();
        
        $router->render("auth/login",[
            "title" => "Iniciar sesión",
            "alertas" => $alertas,
            "usuario" => $usuario
        ]);
        
    }
    
    public static function logout() {
        
        session_start();
        
        $_SESSION = [];
        
        header("Location: /");
        exit();
        
    }
    
    public static function create_account(Router $router) {
        
        $usuario = new Usuario;
        $alertas = Usuario::getAlertas();
        
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            
            $usuario->sincronizar($_POST);
            
            $alertas = $usuario->validarNuevaCuenta();
            
            if(empty($alertas)) {
                
                $existeUsuario = Usuario::where("email",$usuario->email);
                
                if($existeUsuario) {
                    Usuario::setAlerta("error","El usuario ya se encuentra registrado");
                    $alertas = Usuario::getAlertas();
                }else{
                    
                    //Hashear el password
                    $usuario->hashPassword();
                    
                    //Eliminar confirmar password
                    unset($usuario->confirmar);
                    
                    //Generar el token
                    $usuario->generarToken();
                    
                    //Enviar Email
                    $email = new Email($usuario->nombre,$usuario->apellidos,$usuario->email,$usuario->token);
                    $email->enviarEmailRegistro();
                    
                    //Confirmado
                    $resultado = $usuario->guardar();
                    
                    if($resultado) {
                        header("Location: /confirm_message");
                        exit();
                    }
                    
                }
                
            }
            
        }
        
        $router->render("auth/create_account",[
            "title" => "Crear cuenta nueva",
            "usuario" => $usuario,
            "alertas" => $alertas
        ]);
        
    }
    
    public static function forget_password(Router $router) {
        
        $alertas = [];
        
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            
            $usuario = new Usuario($_POST);
            
            $alertas = $usuario->validarEmail();
            
            if(empty($alertas)) {
                
                $usuario = Usuario::where("email",$usuario->email);
                if($usuario && $usuario->confirmado) {
                    
                    //Generar un nuevo token
                    $usuario->token = uniqid();
                    
                    //Quitar el password de confirmación
                    unset($usuario->confirmar);
                    
                    //Actualizar el usuario
                    $usuario->guardar();
                    
                    //Enviar el email
                    $email = new Email($usuario->nombre,$usuario->apellidos,$usuario->email,$usuario->token);
                    $email->enviarEmailRestablecer();
                    
                    //Mostrar alerta
                    Usuario::setAlerta("exito","Hemos enviado las instrucciones a tu email");
                    
                }else{
                    
                    Usuario::setAlerta("error","El usuario no existe o no esta confirmado");
                    
                    
                }
                
            }
            
        }
        
        $alertas = Usuario::getAlertas();
        
        $router->render("auth/forget_password",[
            "title" => "Olvide mi contraseña",
            "alertas" => $alertas
        ]);
        
    }
    
    public static function reset_password(Router $router) {
        
        $alertas = [];
        $mostrar = true;
        
        $token = s($_GET["token"]);
        
        if(!$token) {
            header("Location: /");
            exit();
        }
        
        $usuario = Usuario::where("token",$token);
        
        if(empty($usuario)) {
            
            Usuario::setAlerta("error","Token no valido");
            $mostrar = false;
            
        }
        
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            
            $usuario->sincronizar($_POST);
            
            $alertas = $usuario->validarRestablecerCuenta();
            
            if(empty($alertas)) {
                
                $usuario->hashPassword();
                unset($usuario->confirmar);
                
                $usuario->token = NULL;
                
                if($usuario->guardar()) {
                    
                    header("Location: /");
                    
                }
                
            }
            
        }
        
        $alertas = Usuario::getAlertas();
        $router->render("auth/reset_password",[
            "title" => "Restablecer contraseña",
            "alertas" => $alertas,
            "mostrar" => $mostrar
        ]);
        
    }
    
    public static function confirm_message(Router $router) {
        
        $router->render("auth/confirm_message",[
            "title" => "Confirmación"
        ]);
        
    }
    
    public static function confirm_account(Router $router) {
        
        $alertas = [];
        
        $token = $_GET["token"];
        
        if(!$token) {
            header("Location: /");
            exit();
        }
        
        $usuario = Usuario::where("token",$token);
        
        if(empty($usuario)) {
            
            //No se encontro el usuario con ese token
            Usuario::setAlerta("error","Token no valido");
            
        }else{
            
            //Confirmar la cuenta
            $usuario->confirmado = 1;
            $usuario->token = null;
            unset($usuario->confirmar);
            $usuario->guardar();
            Usuario::setAlerta("exito","Cuenta confirmada correctamente");
            
        }
        
        $alertas = Usuario::getAlertas();
        
        $router->render("auth/confirm_account",[
            "title" => "Confirmación",
            "alertas" => $alertas
        ]);
        
    }
    
}