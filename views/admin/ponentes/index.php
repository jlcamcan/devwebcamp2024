<h2 class="dashboard__heading"><?php echo $titulo;?> </h2>
<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton" href="/admin/ponentes/crear">
        <i class="fa-solid fa-circle-plus"></i>
        Añadir Ponente
    </a>
</div>

<!--Mostrar la lista de  ponentes-->
<div class="dashboard__contenedor">
    <?php if (!empty($ponentes)){?> 
        <table class="tabla">
            <thead class="tabla__thead">
                <tr>
                   <th scope="col" class="tabla__th">Nombre</th> 
                   <th scope="col" class="tabla__th">Ubicación</th> 
                   <th scope="col" class="tabla__th"></th> 
                </tr>
            </thead>
            <tbody class="tabla__tbody">
                <?php foreach ($ponentes as $ponente){?>
                    <tr class="tabla__tr">
                        <td class="tabla__td">
                            <?php echo $ponente->nombre . " ". $ponente->apellido;?>
                        </td>
                        <td class="tabla__td">
                            <?php echo $ponente->ciudad . ", ". $ponente->pais;?>
                        </td>
                        <td class="tabla__td--acciones">
                           <a class="tabla__accion tabla__accion--editar" href="/admin/ponentes/editar?id=<?php echo $ponente->id;?>">
                                <i class="fa-solid fa-user-pen"></i>
                                Editar
                            </a>
                            <form method="POST" action="/admin/ponentes/eliminar" class="tabla__formulario">
                                <input type="hidden" name="id" value="<?php echo $ponente->id;?>">
                                <button class="tabla__accion tabla__accion--eliminar"type="submit">
                                    <i class="fa-solid fa-circle-xmark"></i>
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php }?> 
            </tbody>
        </table>
    <?php } else {?> 
        <p class="text-center">No hay ningún Ponente Aún</p>
    <?php }?> 
</div>

<?php echo $paginacion;?> 


