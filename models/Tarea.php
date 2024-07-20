<?php 

namespace Model;

class Tarea extends ActiveRecord{

    protected static $tabla = "tareas";
    protected static $columnasDB = ["id","tarea","estado","proyecto_id"];

    public $id;
    public $tarea;
    public $estado;
    public $proyecto_id;

    public function __construct( $args = [] )
    {
        $this->id = $args["id"] ?? NULL;
        $this->tarea = $args["tarea"] ?? "";
        $this->estado = $args["estado"] ?? 0;
        $this->proyecto_id = $args["proyecto_id"] ?? "";
    }


}