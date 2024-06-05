<main class="devwebcamp">
    <h2 class="devwebcamp__heading"><?php echo $titulo;?></h2>
    <p class="devwebcamp__descripcion">Conoce sobre la conferencia más importantes de Europa</p>
    <div class="devwebcamp__grid">
        <div <?php aos_animacion();?> class="devwebcamp__imagen">
            <picture>
                <source srcset="build/img/sobre_devwebcamp.avif" type="image/avif">
                <source srcset="build/img/sobre_devwebcamp.webp" type="image/webp">
                <img loading="lazy" witdh="200" height="300" src="build/img/sobre_devwebcamp.jpg" alt="Imagen DevWebCAmp">
            </picture>
        </div>
        <div class="devwebcamp__contenido">
            <p <?php aos_animacion();?> class="devwebcamp__texto">Hay muchas variaciones de los pasajes de Lorem Ipsum disponibles, pero la mayoría sufrió al teraciones en alguna manera, ya sea porque se le agregó humor, o palabras aleatorias que no parecen ni un poco creíbles. Si vas a utilizar un pasaje de Lorem Ipsum, necesitás estar seguro de que no hay nada avergonzante escondido en el medio del texto. 
            </p>

            <p <?php aos_animacion();?> class="devwebcamp__texto">Hay muchas variaciones de los pasajes de Lorem Ipsum disponibles, pero la mayoría sufrió alteraciones en alguna manera, ya sea porque se le agregó humor, o palabras aleatorias que no parecen ni un poco creíbles. 
            </p>
        </div>
    </div>
</main>

