<main class="agenda">
    <h2 class="agenda__heading"><?php echo $titulo;?></h2>
    <p class="agenda__descripcion">Conferencias y Talleres impartidos por expertos de Desarrollo Web</p>
    <div class="eventos">
        <h3 class="eventos__heading">&lt;Conferencias /></h3>
        <!--Conferencias Viernes-->
        <p class="eventos__fecha">Viernes 1 de Noviembre</p>
        <div class="eventos_listado slider swiper">
            <div class="swiper-wrapper">
                <!--Listado Conferencias Viernes-->
                <?php foreach($eventos['conferencias_v'] as $evento ){?> 
                  <?php include __DIR__ . '../../templates/evento.php'; ?> 
                <?php }?> 
            </div><!--fin .swiper-wrapper -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
        </div><!--. eventos_listado-->
        <!--Conferencias Sábado-->
        <p class="eventos__fecha">Sábado 2 de Noviembre</p>
        <div class="eventos_listado slider swiper">
            <div class="swiper-wrapper">
                <!--Listado Conferencias Sábado-->
                <?php foreach($eventos['conferencias_s'] as $evento ){?> 
                  <?php include __DIR__ . '../../templates/evento.php'; ?> 
                <?php }?> 
            </div><!--fin .swiper-wrapper -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
        </div><!--. eventos_listado-->
    </div>
    
    <div class="eventos eventos--workshops">
        <h3 class="eventos__heading">&lt;Workshops /></h3>
        <!--Workshops Viernes-->
        <p class="eventos__fecha">Viernes 1 de Noviembre</p>
        <div class="eventos_listado slider swiper">
            <div class="swiper-wrapper">
                <!--Listado Workshops-Viernes-->
                <?php foreach($eventos['workshops_v'] as $evento ){?> 
                  <?php include __DIR__ . '../../templates/evento.php'; ?> 
                <?php }?> 
            </div><!--fin .swiper-wrapper -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
        </div><!--. eventos_listado-->
       
        <!--Workshops Sábado-->
        <p class="eventos__fecha">Sábado 2 de Noviembre</p>
        <div class="eventos_listado slider swiper">
            <div class="swiper-wrapper">
                <!--Listado Workshops Sábado-->
                <?php foreach($eventos['workshops_s'] as $evento ){?> 
                  <?php include __DIR__ . '../../templates/evento.php'; ?> 
                <?php }?> 
            </div><!--fin .swiper-wrapper -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
        </div><!--. eventos_listado-->
       
    </div>
   
</main>


