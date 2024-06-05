<h2 class="dashboard__heading"><?php echo $titulo;?> </h2>

<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton" href="/admin/eventos/crear">
        <i class="fa-solid fa-circle-plus"></i>
        Añadir Evento
    </a>
</div>
<!--Mostrar la lista de eventos -->
<div class="dashboard__contenedor">

   
    <?php if (!empty($eventos)){?> 
        <table class="tabla">
            <thead class="tabla__thead">
                <tr>
                   <th scope="col" class="tabla__th">Evento</th> 
                   <th scope="col" class="tabla__th">Categoría</th> 
                   <th scope="col" class="tabla__th">Día y Hora</th> 
                   <th scope="col" class="tabla__th">Ponente</th> 
                   <th scope="col" class="tabla__th"></th> 
                </tr>
            </thead>
            <tbody class="tabla__tbody">
                <?php foreach ($eventos as $evento){?>
                    <tr class="tabla__tr">
                        <td class="tabla__td">
                            <?php echo $evento->nombre;?>
                        </td>
                        <td class="tabla__td">
                            <?php echo $evento->categoria->nombre?>
                        </td>
                        <td class="tabla__td">
                            <?php echo $evento->dia->nombre .', '. $evento->hora->hora;?>
                        </td>
                        <td class="tabla__td">
                            <?php echo $evento->ponente->nombre .' '. $evento->ponente->apellido;?>
                        </td>
                        <td class="tabla__td--acciones">
                           <a class="tabla__accion tabla__accion--editar" href="/admin/eventos/editar?id=<?php echo $evento->id;?>">
                                <i class="fa-solid fa-pencil"></i>
                                Editar
                            </a>
                            <form method="POST" action="/admin/eventos/eliminar" class="tabla__formulario">
                                <input type="hidden" name="id" value="<?php echo $evento->id;?>">
                                <button class="tabla__accion tabla__accion--eliminar"type="submit">
                                    <i class="fa-solid fa-circle-xmark"></i>
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php } ?> 
            </tbody>
        </table>
    <?php } else { ?> 
        <p class="text-center">No hay ningún Evento Aún</p>
    <?php }?> 
</div>

<?php echo $paginacion;?> 

