<?php

namespace Controllers;

use Model\Cita;
use Model\CitaServicio;
use Model\Servicio;

class APIController{
    public static function index(){
        $servicios = Servicio::all();
        echo json_encode($servicios, JSON_ERROR_UTF8);
        debuguear(json_encode($servicios, JSON_ERROR_UTF8));
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