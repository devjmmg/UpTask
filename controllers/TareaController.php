<?php

namespace Controllers;

use Model\Proyecto;
use Model\Tarea;
use MVC\Router;

class TareaController {
    
    public static function index() {
        
        $url = $_GET["id"];
        
        if(!$url) {
            header("Location: /dashboard");
            exit();
        }
        
        $proyecto = Proyecto::where("url",$url);
        
        session_start();
        
        if(!$proyecto || $proyecto->usuario_id !== $_SESSION["id"]) {
            header("Location: /dashboard");
            exit();
        }
        
        $tareas = Tarea::belongsTo("proyecto_id",$proyecto->id);
        
        echo json_encode($tareas);
        
    }
    
    public static function crear() {
        
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            
            session_start();
            
            $url = $_POST["proyecto_id"];
            $proyecto = Proyecto::where("url",$url);
            
            if(!$proyecto || $proyecto->usuario_id !== $_SESSION["id"]) {
                
                $respuesta = [
                    "tipo" => "error",
                    "mensaje" => "Hubo un error al agregar la tarea"
                ];
                
                echo json_encode($respuesta);
                return;
                
            }
            
            $tarea = new Tarea($_POST);
            $tarea->proyecto_id = $proyecto->id;
            $resultado = $tarea->guardar();
            
            $respuesta = [
                "id" => $resultado["id"],
                "proyecto_id" => $proyecto->id,
                "tipo" => "exito",
                "mensaje" => "Tarea agregada correctamente"
            ];
            
            echo json_encode($respuesta);
            
        }
        
    }
    
    public static function actualizar() {
        
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            
            $proyecto = Proyecto::where("url",$_POST["proyecto_id"]);
            
            session_start();
            
            if(!$proyecto || $proyecto->usuario_id !== $_SESSION["id"]) {
                
                $respuesta = [
                    "tipo" => "error",
                    "mensaje" => "Hubo un error al actualizar la tarea"
                ];
                
                echo json_encode($respuesta);
                return;
                
            }
            
            $tarea = new Tarea($_POST);
            $tarea->proyecto_id = $proyecto->id;
            $resultado = $tarea->guardar();
            
            if($resultado) {
                $respuesta = [
                    "id" => $tarea->id,
                    "proyecto_id" => $proyecto->id,
                    "tipo" => "exito",
                    "mensaje" => "Actualizado correctamente"
                ];
            }
            
            echo json_encode(["respuesta" => $respuesta]);
            
        }
        
    }
    
    public static function eliminar() {
        
        if($_SERVER["REQUEST_METHOD"] === "POST") {

            $proyecto = Proyecto::where("url",$_POST["proyecto_id"]);
            
            session_start();
            
            if(!$proyecto || $proyecto->usuario_id !== $_SESSION["id"]) {
                
                $respuesta = [
                    "tipo" => "error",
                    "mensaje" => "Hubo un error al actualizar la tarea"
                ];
                
                echo json_encode($respuesta);
                return;
                
            }

            $tarea = new Tarea($_POST);
            $resultado = $tarea->eliminar();

            $respuesta = [
                "tipo" => "exito",
                "mensaje" => "Eliminado correctamente",
                "resultado" => $resultado
            ];

            echo json_encode($respuesta);
            
        }
        
    }
    
    
}