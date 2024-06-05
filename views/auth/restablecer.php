<main class="auth">
    <h2 class="auth__heading"><?php echo $titulo;?></h2>
    <p class="auth__texto">Coloca tu nueva contraseña</p>
    <?php 
       require_once  __DIR__ . '/../templates/alertas.php';
    ?> 
    <?php if($token_valido){ ?> 
        <form method="POST" class="formulario">
            <div class="formulario__campo">
                <label for="password" class="formulario__label">Nueva Contraseña</label>
                <input type="password" class="formulario__input" id="password" name="password" placeholder="Tu nueva Contraseña"/>
            </div>
            <input type="submit" class="formulario__submit" value="Guardar Contraseña"/>
        </form>
    <?php }?> 
    <div class="acciones">
        <a href="/login" class="acciones__enlace">¿Ya tienes cuenta? Iniciar Sesión</a>
        <a href="/registro" class="acciones__enlace">¿Aún no tienes cuenta? Crear cuenta</a>
    </div>
</main>