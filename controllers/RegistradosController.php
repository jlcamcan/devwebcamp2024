<?php
namespace Controllers;
use MVC\Router;
use Model\Regalo;
use Model\Paquete;
use Model\Usuario;
use Model\Registro;
use Classes\Paginacion;

class RegistradosController {
    public static function index(Router $router){
        if(!es_admin()){
            header('Location: /login');
            return;
        }
        $pagina_actual = $_GET['pagina'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);
        if(!$pagina_actual || $pagina_actual <1){
            header('Location: /admin/registrados?pagina=1');
        }
        //Registros por página
        $registros_por_pagina = 6;
        //Calcula el número total de registros
        $total_registros = Registro::total();
        //Instancia de la clase Paginacion
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total_registros);
        
        if($paginacion->total_paginas() < $pagina_actual && $pagina_actual != 1){
            header('Location: /admin/registrados?pagina=1');
        }
        $registros = Registro::paginar($registros_por_pagina, $paginacion->offset());
        foreach($registros as $registro){
            $registro->usuario = Usuario::find($registro->usuario_id);
            $registro->paquete = Paquete::find($registro->paquete_id);
            $registro->regalo = Regalo::find($registro->regalo_id);
        }
          
        $router->render('admin/registrados/index', [
            'titulo'=>'Usuarios Registrados',
            'registros' => $registros,
            'paginacion' => $paginacion->paginacion()
        ]);
    }
}

