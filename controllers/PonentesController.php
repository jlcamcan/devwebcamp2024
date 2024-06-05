<?php
namespace Controllers;
use MVC\Router;
use Model\Ponente;
use Classes\Paginacion;
use Intervention\Image\ImageManagerStatic as Image;

class PonentesController {

    public static function index(Router $router){
        if(!es_admin()){
            header('Location: /login');
            return;
        }
        $pagina_actual = $_GET['pagina'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);
        if(!$pagina_actual || $pagina_actual <1){
            header('Location: /admin/ponentes?pagina=1');
        }
        //Registros por página
        $registros_por_pagina = 6;
        //Calcula el número total de registros
        $total_registros = Ponente::total();
        //Instancia de la clase Paginacion
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total_registros);
        
        if($paginacion->total_paginas() < $pagina_actual && $pagina_actual != 1){
            header('Location: /admin/ponentes?pagina=1');
        }
        $ponentes = Ponente::paginar($registros_por_pagina, $paginacion->offset());
     
       
     
        $router->render('admin/ponentes/index', [
            'titulo'=>'Ponentes / Conferenciantes',
            'ponentes'=> $ponentes,
            'paginacion' => $paginacion->paginacion()
        ]);
    }

    public static function crear(Router $router){
        if(!es_admin()){
            header('Location: /login');
        }
        $alertas = [];
        $ponente = new Ponente;
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(!es_admin()){
                header('Location: /login');
            }
            //Leer imagen
            if(!empty($_FILES['imagen']['tmp_name'])){
                $carpeta_imagenes = '../public/img/speakers';
                //Crear la carpeta si no existe
                if (!is_dir($carpeta_imagenes)){
                    mkdir($carpeta_imagenes, 0777,true);
                }
                $imagen_png = Image::make($_FILES['imagen']['tmp_name'])->fit(800,800)->encode('png',80);
                $imagen_webp = Image::make($_FILES['imagen']['tmp_name'])->fit(800,800)->encode('webp',80);
                //Generamos una nombre hasheado de la imagen
                $nombre_imagen = md5(uniqid(rand(),true));
                //Añadimos el nombre al POST
                $_POST['imagen'] = $nombre_imagen;
            }
            //Convertir array redes a string
            $_POST['redes'] = json_encode($_POST['redes'], JSON_UNESCAPED_SLASHES);
           
            $ponente->sincronizar($_POST);
          
            //Validar alertas
            $alertas = $ponente->validar();
            //Guardar el registro
            if (empty($alertas)){
                //Guardar imagenes en la carpeta
                $imagen_png->save($carpeta_imagenes . '/' . $nombre_imagen. ".png");
                $imagen_webp->save($carpeta_imagenes . '/' . $nombre_imagen. ".webp");
                
                //Guardar en la Base de Datos
                $resultado = $ponente->guardar();
                if ($resultado){
                    header('Location: /admin/ponentes');
                }
            }
        }
        $redes = json_decode($ponente->redes);
        $router->render('admin/ponentes/crear', [
            'titulo'=>'Registrar Ponentes',
            'alertas' => $alertas,
            'ponente' => $ponente,
            'redes'=>$redes
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
            header('Location: /admin/ponentes');
        }
        //Obtener el ponente a editar
        $ponente= Ponente::find($id);
        //Si no existe un ponente
        if(!$ponente){
            header('Location: /admin/ponentes');
        }
        $ponente->imagen_actual = $ponente->imagen;

        //Obtener redes sociales
        $redes = json_decode($ponente->redes);

        //Guardar la actualizacion
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(!es_admin()){
                header('Location: /login');
            }
            //Comprobar imagen
            if(!empty($_FILES['imagen']['tmp_name'])){
                $carpeta_imagenes = '../public/img/speakers';
                //Crear la carpeta si no existe
                if (!is_dir($carpeta_imagenes)){
                    mkdir($carpeta_imagenes, 0777,true);
                }
                $imagen_png = Image::make($_FILES['imagen']['tmp_name'])->fit(800,800)->encode('png',80);
                $imagen_webp = Image::make($_FILES['imagen']['tmp_name'])->fit(800,800)->encode('webp',80);
                //Generamos una nombre hasheado de la imagen
                $nombre_imagen = md5(uniqid(rand(),true));
                //Añadimos el nombre al POST
                $_POST['imagen'] = $nombre_imagen;
            }else{
               $_POST['imagen'] = $ponente->imagen_actual; 
            }
             //Convertir array redes a string
            $_POST['redes'] = json_encode($_POST['redes'], JSON_UNESCAPED_SLASHES);
            
            $ponente->sincronizar($_POST);
            $alertas = $ponente->validar();
            if(empty($alertas)){
                if(isset($nombre_imagen)){
                    //Guardar imagenes en la carpeta
                    $imagen_png->save($carpeta_imagenes . '/' . $nombre_imagen. ".png");
                    $imagen_webp->save($carpeta_imagenes . '/' . $nombre_imagen. ".webp");
                }
                $resultado = $ponente->guardar();
                if($resultado){
                    header('Location: /admin/ponentes');
                }
            }

        }
        $router->render('admin/ponentes/editar', [
            'titulo'=>'Actualizar Ponente',
            'alertas'=>$alertas,
            'ponente'=> $ponente,
            'redes'=> $redes
        ]);

       
    }
    public static function eliminar(){
        if(!es_admin()){
            header('Location: /login');
        }
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(!es_admin()){
                header('Location: /login');
            }
            $id = $_POST['id'];
            $ponente = Ponente::find($id);
            if(!isset($ponente)){
                header('Location: /admin/ponentes');
            }
            $resultado = $ponente->eliminar();
            if($resultado){
                header('Location: /admin/ponentes');
            }
        }
    }
}

