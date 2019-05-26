<?php 
$has_permiso=false;
$has_sesion_valida=false;
if ($has_sesion_valida=Session::valid_session()) {
  $has_permiso=Session::tiene_permiso($_SESSION['id']);
}

 ?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand p-0 m-0" href="<?php echo BASE_URL ?>"><img src="img/logo1.png" width="" height="50" class="d-inline-block align-top p-0 mr-5" alt="Neuropediatria" min-width="175px" id="hlogoi"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSVA" aria-controls="navbarSVA" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSVA">
    
    
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="<?php echo BASE_URL ?>">Inicio</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo BASE_URL ?>medico/">Ver Pacientes</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo BASE_URL ?>medico/">Ver Medicos</a>
      </li>
      <?php if ($has_permiso): ?>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo BASE_URL ?>estadisticas/">Estadisticas</a>
        </li>
      <?php endif ?>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <?php if ($has_sesion_valida): ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="ddmlPerfil" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-laugh-beam"></i> <?php echo $_SESSION['apodo']; ?>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="ddmlPerfil">
            <a class="dropdown-item" href="#">Cambiar Contraseña</a>
            <a class="dropdown-item" href="<?php echo BASE_URL; ?>login/logout">Cerrar Sesion</a>
          </div>
        </li>
      <?php else: ?>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo BASE_URL; ?>login">Iniciar Sesion</a>
        </li>
      <?php endif ?>
      
    </ul>
    
  </div>
</nav>
<span class="d-block bg-sv divu"></span>

<?php  
    
 ?>


