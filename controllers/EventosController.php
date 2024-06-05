<?php
namespace Controllers;
use Model\Dia;
use Model\Hora;
use MVC\Router;
use Model\Evento;
use Model\Ponente;
use Model\Categoria;
use Classes\Paginacion;

class EventosController {

    public static function index(Router $router){
        if(!es_admin()) {
            header('Location: /login');
        }
      
        $pagina_actual = $_GET['pagina'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);
        if(!$pagina_actual || $pagina_actual <1){
            header('Location: /admin/eventos?pagina=1');
        }
       //Registros por página
        $registros_por_pagina = 6;
        //Calcula el número total de registros
        $total_registros = Evento::total();
        //Instancia de la clase Paginacion
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total_registros);
        
        if($paginacion->total_paginas() < $pagina_actual && $pagina_actual != 1){
            header('Location: /admin/eventos?pagina=1');
        }
        $eventos = Evento::paginar($registros_por_pagina, $paginacion->offset());

        //Añadir la llave categoria, dia, hora y ponente al objeto
        foreach($eventos as $evento){
            $evento->categoria = Categoria::find($evento->categoria_id);
            $evento->dia = Dia::find($evento->dia_id);
            $evento->hora = Hora::find($evento->hora_id);
            $evento->ponente = Ponente::find($evento->ponente_id);
        }
               
        $router->render('admin/eventos/index', [
            'titulo'=>'Conferencias y Workshops',
            'eventos' => $eventos,
            'paginacion' => $paginacion->paginacion()
        ]);
    }

    public static function crear(Router $router){
        $alertas = [];
        $categorias = Categoria::all('ASC');
        $dias = Dia::all('ASC');
        $horas = Hora::all('ASC');
        //Instanciamos un evento
        $evento = new Evento;

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
              if(!es_admin()){
                header('Location: /login');
            }
            $evento->sincronizar($_POST);
            $alertas = $evento->validar();
            if(empty($alertas)){
                $resultado = $evento->guardar();
                if ($resultado){
                    header('Location: /admin/eventos');
                }
            }
        }
        $router->render('admin/eventos/crear', [
            'titulo'=>'Registrar Evento',
            'alertas'=> $alertas,
            'categorias'=> $categorias,
            'dias'=> $dias,
            'horas' => $horas,
            'evento' => $evento
        ]);
    }

    public static function editar(Router $router){
        if(!es_admin()){
            header('Location: /login');
        }
        $alertas = [];
        //Validar el ID
        $id = $_GET['id'];
        //Comprobar si es entero
        $id = filter_var($id, FILTER_VALIDATE_INT);
        //Si no es un entero
        if(!$id){
            header('Location: /admin/eventos');
        }
        $categorias = Categoria::all('ASC');
        $dias = Dia::all('ASC');
        $horas = Hora::all('ASC');
        //Obtener el ponente a editar
        $evento= Evento::find($id);
        //Si no existe un ponente
        if(!$evento){
            header('Location: /admin/eventos');
        }    
        //Guardar la actualizacion
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(!es_admin()){
                header('Location: /login');
            }
            $evento->sincronizar($_POST);
            $alertas = $evento->validar();
            if(empty($alertas)){
                $resultado = $evento->guardar();
                if($resultado){
                    header('Location: /admin/eventos');
                }
            }

        }
        $router->render('admin/eventos/editar', [
            'titulo'=>'Editar Evento',
            'alertas'=>$alertas,
            'categorias' => $categorias,
            'dias' => $dias,
            'horas' => $horas,
            'evento'=> $evento
        ]);
    }

    public static function eliminar(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(!es_admin()){
                header('Location: /login');
            }
            $id = $_POST['id'];
            $evento = Evento::find($id);
            if(!isset($evento)){
                header('Location: /admin/eventos');
            }
            $resultado = $evento->eliminar();
            if($resultado){
                header('Location: /admin/eventos');
            }
        } 
    }
}