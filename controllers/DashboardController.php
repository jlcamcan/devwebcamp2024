<?php
namespace Controllers;
use MVC\Router;
use Model\Evento;
use Model\Usuario;
use Model\Registro;

class DashboardController {
    public static function index(Router $router){
        if(!es_admin()) {
            header('Location: /login');
        }

        //Obtener los últimos 5 registros
        $registros = Registro::get(5);
        foreach($registros as $registro){
            $registro->usuario = Usuario::find($registro->usuario_id);
        }

        //Calcular los ingresos
        $pases_presenciales = Registro::total('paquete_id', 1);
        $pases_virtuales = Registro::total('paquete_id', 2);
        $ingresos = ($pases_presenciales*199.00) + ($pases_virtuales*49.00);
        

        //Obtener eventos con más y menos lugar disponibles
        $menos_disponibles = Evento::ordenarLimite('disponibles', 'ASC', 5);
        $mas_disponibles = Evento::ordenarLimite('disponibles', 'DESC', 3);
               
        $router->render('admin/dashboard/index', [
            'titulo'=>'Panel de Administración',
            'registros' => $registros,
            'ingresos' => $ingresos,
            'mas_disponibles' => $mas_disponibles,
            'menos_disponibles' => $menos_disponibles
        ]);
    }
}

?>
