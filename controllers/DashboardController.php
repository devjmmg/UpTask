<?php 

namespace Controllers;

use Model\Proyecto;
use Model\Usuario;
use MVC\Router;

class DashboardController {
    
    public static function dashboard(Router $router) {
        
        session_start();
        
        isAuth();
        
        $proyectos = Proyecto::belongsTo("usuario_id",$_SESSION["id"]);
        
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            
        }
        
        $router->render("dashboard/index",[
            "title" => "Proyectos",
            "proyectos" => $proyectos
        ]);
        
    }
    
    public static function create_project(Router $router) {
        
        session_start();
        
        isAuth();
        
        $alertas = [];
        
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            
            $proyecto = new Proyecto($_POST);
            
            $alertas = $proyecto->validarProyecto();
            
            if(empty($alertas)) {
                
                $proyecto->url = md5(uniqid());
                $proyecto->usuario_id = $_SESSION["id"];
                
                $proyecto->guardar();
                
                header("Location: /project?id=".$proyecto->url);
                
            }
            
        }
        
        $router->render("dashboard/create_project",[
            "alertas" => $alertas,
            "title" => "Crear proyecto"
        ]);
        
    }
    
    public static function profile(Router $router) {
        
        session_start();
        
        isAuth();
        
        $alertas = [];
        $usuario = Usuario::find($_SESSION["id"]);
        
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            
            $usuario->sincronizar($_POST);
            
            $alertas = $usuario->validarPerfil();
            
            if(empty($alertas)) {
                
                $existe = Usuario::where("email",$usuario->email);
                
                if($existe && $existe->id !== $usuario->id) {
                    
                    Usuario::setAlerta("error","El correo electrónico ya pertenece a otra cuenta, elija otro");
                    
                }else{
                    
                    $_SESSION["nombre"] = $usuario->nombre;
                    $_SESSION["apellido"] = $usuario->apellidos;
                    $_SESSION["email"] = $usuario->email;
                    
                    $usuario->guardar();
                    
                    Usuario::setAlerta("exito","Guardado con exito");
                    
                    
                }
                
                $alertas = $usuario->getAlertas();
                
            }
            
        }
        
        $router->render("dashboard/profile",[
            "title" => "Perfil",
            "usuario" => $usuario,
            "alertas" => $alertas
        ]);
        
    }

    public static function change_password(Router $router) {

        session_start();

        isAuth();

        $alertas = [];

        if($_SERVER["REQUEST_METHOD"] === "POST") {

            $usuario = Usuario::find($_SESSION["id"]);

            $usuario->sincronizar($_POST);

            $alertas = $usuario->change_password();

            if(empty($alertas)) {

                if($usuario->verificarPassword($usuario->current_password)) {

                    $usuario->password = $usuario->new_password;
                    
                    unset($usuario->current_password);
                    unset($usuario->new_password);
                    unset($usuario->confirmar);

                    $usuario->hashPassword();
                    $resultado = $usuario->guardar();

                    if($resultado) {
                        Usuario::setAlerta("exito","La contraseña se cambio correctamente");
                    }

                }else{

                    Usuario::setAlerta("error","La contraseña actual es incorrecta");
                    

                }

                $alertas = $usuario->getAlertas();

            }

        }

        $router->render("dashboard/change_password",[
            "title" => "Cambiar contraseña",
            "alertas" => $alertas
        ]);

    }
    
    public static function project(Router $router) {
        
        session_start();
        
        isAuth();
        
        $url = $_GET["id"];
        if(!$url) {
            header("Location: /dashboard");
        }
        
        $proyecto = Proyecto::where("url",$url);
        
        if($proyecto->usuario_id !== $_SESSION["id"]) {
            header("Location: /dashboard");
        }
        
        $router->render("dashboard/project",[
            "title" => $proyecto->proyecto
        ]);
        
    }
    
}