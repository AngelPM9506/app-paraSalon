<?php

/**SELECT citas.id, citas.hora, CONCAT(usuarios.nombre,' ',usuarios.apellido) as cliente, CONCAT(usuarios.correo,' ',usuarios.telefono) as datos, servicios.nombre as servicio, servicios.precio FROM citas LEFT OUTER JOIN usuarios ON citas.usuarioId=usuarios.id LEFT OUTER JOIN citasServicios ON citasServicios.citaId=citas.id LEFT OUTER JOIN servicios ON servicios.id = citasServicios.servicioId WHERE fecha = "2022-02-18"; 
+----+----------+------------------------------+--------------------------------+-------------------------+--------+
| id | hora     | cliente                      | datos                          | servicio                | precio |
+----+----------+------------------------------+--------------------------------+-------------------------+--------+
| 19 | 12:30:00 | Miguel Angel Parra Mondragon | correo5@correo3.com 5511223344 | Corte de Cabello Mujer  |  90.00 |
| 19 | 12:30:00 | Miguel Angel Parra Mondragon | correo5@correo3.com 5511223344 | Peinado Hombre          |  60.00 |
| 19 | 12:30:00 | Miguel Angel Parra Mondragon | correo5@correo3.com 5511223344 | Tinte Mujer             | 300.00 |
| 19 | 12:30:00 | Miguel Angel Parra Mondragon | correo5@correo3.com 5511223344 | Corte de Cabello Hombre |  80.00 |
+----+----------+------------------------------+--------------------------------+-------------------------+--------+
 **/

namespace Model;

class AdminCita extends ActiveRecord{
    protected static $tabla = 'citasServicios';    
    protected static $columnasDB = ['id','hora','cliente','datos','servicio','precio'];
    public $id;
    public $hora;
    public $cliente;
    public $datos;
    public $servicio;
    public $precio;
    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->hora = $args['hora'] ?? '';
        $this->cliente = $args['cliente'] ?? '';
        $this->datos = $args['datos'] ?? '';
        $this->servicio = $args['servicio'] ?? '';
        $this->precio = $args['precio'] ?? '';
        
    }
}