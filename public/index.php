<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\DashboardController;
use Controllers\LoginController;
use Controllers\TareaController;
use MVC\Router;
$router = new Router();

//Login
$router->get("/",[LoginController::class,"login"]);
$router->post("/",[LoginController::class,"login"]);

//Logout
$router->get("/logout",[LoginController::class,"logout"]);

//Create account
$router->get("/create_account",[LoginController::class,"create_account"]);
$router->post("/create_account",[LoginController::class,"create_account"]);

//Forget password
$router->get("/forget_password",[LoginController::class,"forget_password"]);
$router->post("/forget_password",[LoginController::class,"forget_password"]);

//Reset password
$router->get("/reset_password",[LoginController::class,"reset_password"]);
$router->post("/reset_password",[LoginController::class,"reset_password"]);

//Confirm
$router->get("/confirm_message",[LoginController::class,"confirm_message"]);
$router->get("/confirm_account",[LoginController::class,"confirm_account"]);

//Dashboard
$router->get("/dashboard",[DashboardController::class,"dashboard"]);
$router->post("/dashboard",[DashboardController::class,"dashboard"]);

//Create_project
$router->get("/create_project",[DashboardController::class,"create_project"]);
$router->post("/create_project",[DashboardController::class,"create_project"]);

//Perfil
$router->get("/profile",[DashboardController::class,"profile"]);
$router->post("/profile",[DashboardController::class,"profile"]);
//Change password
$router->get("/change_password",[DashboardController::class,"change_password"]);
$router->post("/change_password",[DashboardController::class,"change_password"]);

//project
$router->get("/project",[DashboardController::class,"project"]);
//$router->post("/project",[DashboardController::class,"project"]);

//API para las tareas
$router->get("/api/tareas",[TareaController::class,"index"]);
$router->post("/api/tarea",[TareaController::class,"crear"]);
$router->post("/api/tarea/actualizar",[TareaController::class,"actualizar"]);
$router->post("/api/tarea/eliminar",[TareaController::class,"eliminar"]);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();