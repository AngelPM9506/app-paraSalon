<?php

namespace Controllers;

use Model\Cita;
use Model\CitaServicio;
use Model\Servicio;

class APIController{
    public static function index(){
        $servicios = Servicio::all();
        $json = json_encode( (object) $servicios, JSON_PRESERVE_ZERO_FRACTION+JSON_UNESCAPED_UNICODE);
        if ($json) {
            echo $json;
        }else{
            echo 'Sin resultados';
        }
    }
    public static function registrar(){
        /**Almacena la cita y debualve el Id**/
        $cita = new Cita($_POST);
        $resultado = $cita->guardar() ;
        $id = $resultado['id'];
        /**Almacena los servicios elegidos para la cita previamente almacenada**/
        $idServicios = explode(',',$_POST['servicios']);
        foreach ($idServicios as $idServicio) {
            $args = [
                'citaId' => $id,
                'servicioId'=> $idServicio
            ];
            $citaServicio = new CitaServicio($args);
            $citaServicio->guardar();
        }
        /**Retornamos una respuesta**/
        echo json_encode(['resultado' => $resultado]);
    }
    public static function eliminar(){
        if ($_SERVER['REQUEST_METHOD']=== 'POST') {
            $id = $_POST['id'];
            $cita = Cita::find($id);
            $cita->eliminar();
            header('Location:'.$_SERVER['HTTP_REFERER']);
        }
    }
}