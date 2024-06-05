<?php
namespace Controllers;

use Model\Dia;
use Model\Hora;
use MVC\Router;
use Model\Evento;
use Model\Regalo;
use Model\Paquete;
use Model\Ponente;
use Model\Usuario;
use Model\Registro;
use Model\Categoria;
use Model\EventosRegistros;

class RegistroController {

    public static function crear(Router $router){
        if (!is_auth()){
            header('Location: /');
            return;
        }
        //Verificar si el usuario a tiene un registro
        $registro = Registro::where('usuario_id', $_SESSION['id']);
       
        if(isset($registro) && ($registro->paquete_id === "3" || $registro->paquete_id === "2")){
            header('Location: /ticket?id=' . urlencode($registro->token));
            return;
        }
        
        if(isset($registro) && $registro->paquete_id === "1"){
            header('Location: /finalizar-registro/conferencias');
            return;
        }
        $router->render('registro/crear', [
            'titulo' => 'Finalizar Registro'
        ]);
    }



    public static function gratis(Router $router){
       if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(!is_auth()){
                header('Location: /login');
                return;
            }
            //Verificar si el usuario tiene un registro
            $registro = Registro::where('usuario_id', $_SESSION['id']);
            if(isset($registro) && $registro->paquete_id === "3"){
                header('Location: /ticket?id=' . urlencode($registro->token));
                return;
            }
            $token = substr(md5(uniqid(rand())), 0, 8);
            //Crear el registro
            $datos = [
                'paquete_id' => 3,
                'pago_id' => '',
                'token' => $token,
                'usuario_id' => $_SESSION['id']
            ];
            //Instanciar el registro
            $registro = new Registro($datos);
            $resultado = $registro->guardar();
            if($resultado){
                header('Location: /ticket?id=' . urlencode($registro->token));
                return;
            }
       }
    }
    public static function ticket (Router $router){
        //Validar la url
        $id = $_GET['id'];
        if(!$id || !strlen($id) === 8){
            header('Location: /');
            return;
        }
        //Buscarlo en la tabla
        $registro = Registro::where('token', $id);
        if(!$registro){
            header('Location: /');
            return;
        }
        //Llenar las tablas de referencia
        $registro->usuario = Usuario::find($registro->usuario_id);
        $registro->paquete = Paquete::find($registro->paquete_id);
       
        $router->render('/registro/ticket', [
            'titulo'=> 'Asistencia a DevWebCamp',
            'registro' => $registro
        ]);
    }

    
    public static function pagar(Router $router) {

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!is_auth()) {
                header('Location: /login');
                return;
            }
            
            // Validar que Post no venga vacio
            if(empty($_POST)) {
                echo json_encode([]);
                return;
            }
          
            // Crear el registro
            $datos = $_POST;
          
            $datos['token'] = substr( md5(uniqid( rand(), true )), 0, 8);
            $datos['usuario_id'] = $_SESSION['id'];
            $datos['regalo_id'] = 1;
          
            try {
                $registro = new Registro($datos);
                $resultado = $registro->guardar();
                echo json_encode($resultado);
            } catch (\Throwable $th) {
                    echo json_encode([
                    'resultado' => 'error'
                ]);
            }

        }
    }
    public static function conferencias (Router $router){
      
        if (!is_auth()){
            header('Location: /login');
            return;
        }
        //Validar que el usuario este inscrito y con pase presencial
        $usuario_id = $_SESSION['id'];
        $registro = Registro::where('usuario_id', $usuario_id);
      
        //Comprobamos que este inscrito como virtual
        if (isset($registro) && ($registro->paquete_id === "2")) {
            header('Location: /ticket?id=' . urlencode($registro->token));
            return;
        }
       
        //comprobamos que este inscrito como presencial
        if ($registro->paquete_id !== "1") {
            header('Location: /');
            return;
        }


        //Redireccionar al ticket si el usuario ya se ha realizado el registro
    //    if(isset($registro->regalo_id) && $registro->paquete_id === "1"){
    //        header('Location: /ticket?id=' . urlencode($registro->token));
    //        return;
    //    }
   
        //Comprobar que el usuario no tenga el registro completado
        $registroCompleto = EventosRegistros::where('registro_id', $registro->id);
        if ($registroCompleto){
            header('Location: /ticket?id=' . urlencode($registro->token));
        }
        
        $eventos = Evento::ordenar('hora_id', 'ASC');
        $eventos_formateados = [];
        foreach($eventos as $evento){
           $evento->categoria = Categoria::find($evento->categoria_id);
           $evento->dia = Dia::find($evento->dia_id);
           $evento->hora = Hora::find($evento->hora_id);
           $evento->ponente = Ponente::find($evento->ponente_id);
           if($evento->dia_id === "1" && $evento->categoria_id === "1"){
              $eventos_formateados['conferencias_v'][] = $evento;
           }
           if($evento->dia_id === "2" && $evento->categoria_id === "1"){
              $eventos_formateados['conferencias_s'][] = $evento;
           }
           if($evento->dia_id === "1" && $evento->categoria_id === "2"){
              $eventos_formateados['workshops_v'][] = $evento;
           }
           if($evento->dia_id === "2" && $evento->categoria_id === "2"){
              $eventos_formateados['workshops_s'][] = $evento;
           }
        }
        //Añadimos todos los regalos a la vista
        $regalos = Regalo::all('ASC');

        //Manejando el registro mediante $_POST
        if($_SERVER['REQUEST_METHOD' ]=== 'POST'){
            if(!is_auth()){
                header('Location: /');
                return;
            }
            $eventos = explode(',', $_POST['eventos']);
            //Validamos que el array de eventos venga vacío
            if(empty($eventos)){
                echo json_encode(['resultado' => false]);
                return;
            }
            //Obtener el registro del usuario
            $registro = Registro::where('usuario_id', $_SESSION['id']);
            if(!isset($registro) || $registro->paquete_id !== "1"){
                echo json_encode(['resultado' => false]);
                return;
            }
            $eventos_array =[];
            //Validar la disponibilidad de los evntos seleccionados.
            foreach($eventos as $evento_id){
                $evento = Evento::find($evento_id);
                //Comprobar que el evento exista y que tenga plazas
                if(!isset($evento) || $evento->disponibles === "0"){
                    echo json_encode(['resultado' => false]);
                    return;
                }
                $eventos_array[] = $evento;
            }
            foreach($eventos_array as $evento){
                $evento->disponibles -= 1;
                $evento->guardar();
                //Almacenamos en EventosRegistros
                $datos = [
                   'evento_id' => (int) $evento->id,
                   'registro_id' => (int) $registro->id
                ];
               $registro_usuario = new EventosRegistros($datos);
               $registro_usuario->guardar();
            }

            //Almacenar el regalo en registro
            $registro->sincronizar(['regalo_id' => $_POST['regalo_id']]);
            $resultado = $registro->guardar();
            if($resultado){
                echo json_encode([
                    'resultado' => $resultado, 
                    'token' => $registro->token]);
            }else{
                echo json_encode(['resultado' => false]);
            }
            return;
        }//fin metodo POST

        $router->render('/registro/conferencias', [
            'titulo'=> 'Selecciona Workshops y Conferencias',
            'eventos' => $eventos_formateados,
            'regalos' => $regalos
        ]);
    }

}






