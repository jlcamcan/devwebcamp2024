<h2 class="dashboard__heading"><?php echo $titulo;?> </h2>
<!--Mostrar la lista de  ponentes-->
<div class="dashboard__contenedor">
 

    <?php if (!empty($registros)){?> 
        <table class="tabla">
            <thead class="tabla__thead">
                <tr>
                   <th scope="col" class="tabla__th">Nombre</th> 
                   <th scope="col" class="tabla__th">Plan</th> 
                   <th scope="col" class="tabla__th">Regalo</th> 
                   <th scope="col" class="tabla__th">Email</th> 
                   <th scope="col" class="tabla__th">Id. Pago</th> 
                   <th scope="col" class="tabla__th">Núm Ticket</th> 
                </tr>
            </thead>
            <tbody class="tabla__tbody">
                <?php foreach ($registros as $registro){?>
                    <tr class="tabla__tr">
                        <td class="tabla__td">
                            <?php echo $registro->usuario->nombre . " ". $registro->usuario->apellido;?>
                        </td>
                        <td class="tabla__td">
                            <?php echo $registro->paquete->nombre;?>
                        </td>
                        <td class="tabla__td">
                            <?php echo $registro->regalo->nombre;?>
                        </td>
                        <td class="tabla__td">
                            <?php echo $registro->usuario->email;?>
                        </td>
                        <td class="tabla__td">
                            <?php echo $registro->pago_id;?>
                        </td>
                        <td class="tabla__td">
                            <?php echo $registro->token;?>
                        </td>
                       
                    </tr>
                <?php }?> 
            </tbody>
        </table>
    <?php } else {?> 
        <p class="text-center">No hay Registros Aún</p>
    <?php }?> 
</div>

<?php echo $paginacion;?> 
