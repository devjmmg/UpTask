<?php

namespace Model;

class Usuario extends ActiveRecord {
    
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ["id","nombre","apellidos","email","password","token","confirmado"];
    
    public $id;
    public $nombre;
    public $apellidos;
    public $email;
    public $password;
    public $current_password;
    public $new_password;
    public $confirmar;
    public $token;
    public $confirmado;
    
    public function __construct($args = [])
    {
        $this->id = $args["id"] ?? NULL;
        $this->nombre = $args["nombre"] ?? "";
        $this->apellidos = $args["apellidos"] ?? "";
        $this->email = $args["email"] ?? "";
        $this->password = $args["password"] ?? "";
        $this->current_password = $args["current_password"] ?? "";
        $this->new_password = $args["new_password"] ?? "";
        $this->confirmar = $args["confirmar"] ?? "";
        $this->token = $args["token"] ?? "";
        $this->confirmado = $args["confirmado"] ?? 0;
    }
    
    public function validarNuevaCuenta() {
        
        if(!$this->nombre) {
            
            self::$alertas["error"][] = "El nombre es obligatorio";
            
        }
        
        if(!$this->apellidos) {
            
            self::$alertas["error"][] = "El apellido es obligatorio";
            
        }
        
        if(!$this->email) {
            self::$alertas["error"][] = "El correo electrónico es obligatorio";
        }else{
            if(!filter_var($this->email,FILTER_VALIDATE_EMAIL)){
                self::$alertas["error"][] = "El correo electrónico no es valido";
            }
        }
        
        if(!$this->password || !$this->confirmar) {
            
            self::$alertas["error"][] = "La contraseña y la confirmación es obligatorio";
            
        }else{
            
            if(strlen($this->password) < 6) {
                
                self::$alertas["error"][] = "La contraseña debe tener al menos 6 caractéres";
                
            }else {
                
                if($this->password !== $this->confirmar) {
                    
                    self::$alertas["error"][] = "Las contraseñas no coinciden";
                    
                }
                
            }
            
        }
        
        return self::$alertas;
        
    }
    
    public function hashPassword() {
        
        $this->password = password_hash($this->password,PASSWORD_BCRYPT);
        
    }
    
    public function generarToken() {
        
        $this->token = uniqid();
        
    }
    
    public function validarEmail() {
        
        if(!$this->email) {
            self::$alertas["error"][] = "El correo electrónico es obligatorio";
        }else{
            
            if(!filter_var($this->email,FILTER_VALIDATE_EMAIL)){
                self::$alertas["error"][] = "El correo electrónico no es valido";
            }
            
        }
        return self::$alertas;
    }
    
    public function validarRestablecerCuenta() {
        
        if(!$this->password || !$this->confirmar) {
            
            self::$alertas["error"][] = "La contraseña y la confirmación es obligatorio";
            
        }else{
            
            if(strlen($this->password) < 6) {
                
                self::$alertas["error"][] = "La contraseña debe tener al menos 6 caractéres";
                
            }else {
                
                if($this->password !== $this->confirmar) {
                    
                    self::$alertas["error"][] = "Las contraseñas no coinciden";
                    
                }
                
            }
            
        }
        
        return self::$alertas;
        
    }
    
    public function validarInicioSesion() {
        
        if(!$this->email) {
            self::$alertas["error"][] = "El correo electrónico es obligatorio";
        }else{
            
            if(!filter_var($this->email,FILTER_VALIDATE_EMAIL)){
                self::$alertas["error"][] = "El correo electrónico no es valido";
            }
            
        }
        
        if(!$this->password) {
            
            self::$alertas["error"][] = "La contraseña es obligatorio";
            
        }
        
        return self::$alertas;
        
    }
    
    public function verificarPassword($password) {
        
        if(password_verify($password,$this->password)) {
            return true;
        }
        
        return false;
        
    }
    
    public function validarPerfil() {
        
        if(!$this->nombre) {
            
            self::$alertas["error"][] = "El nombre es obligatorio";
            
        }
        
        if(!$this->apellidos) {
            
            self::$alertas["error"][] = "El apellido es obligatorio";
            
        }
        
        if(!$this->email) {
            self::$alertas["error"][] = "El correo electrónico es obligatorio";
        }else{
            if(!filter_var($this->email,FILTER_VALIDATE_EMAIL)){
                self::$alertas["error"][] = "El correo electrónico no es valido";
            }
        }
        
        return self::$alertas;
        
    }
    
    public function change_password() {
        
        if(!$this->current_password) {
            
            self::$alertas["error"][] = "La contraseña actual es obligatoria";
            
        }
        
        if(!$this->new_password || !$this->confirmar) {
            
            self::$alertas["error"][] = "La nueva contraseña y la confirmación son obligatorias";
            
        }else{
            
            if(strlen($this->new_password) < 6) {
                
                self::$alertas["error"][] = "La nueva contraseña debe tener al menos 6 caractéres";
                
            }else {
                
                if($this->new_password !== $this->confirmar) {
                    
                    self::$alertas["error"][] = "La nueva contraseña y la confirmación no coinciden";
                    
                }
                
            }
            
        }
        
        return self::$alertas;
        
    }
    
}