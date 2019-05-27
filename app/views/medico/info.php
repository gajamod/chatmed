<link rel="stylesheet" type="text/css" href="css/Calificacion.css">
<link rel="stylesheet" type="text/css" href="css/testimonial.css">
<?php 

$inf=$this->params['medico'];
switch ($inf['num_area']) {
 	case 1:
 		$borde='info';
 		break;
 	case 2:
 		$borde='danger';
 		break;
 	case 3:
 		$borde='primary';
 		break;
 	case 1:
 		$borde='secondary';
 		break;
 	case 1:
 		$borde='dark';
 		break;
 	default:
 		$borde='default';
 		break;
 } 


 switch ($inf['estatus']) {
 	case 1:
 		$estat='success';
 		$estatT="Activo";
 		break;
 	
 	default:
 		$estat='warning';
 		$estatT="Inactivo";
 		break;
 } 
 ?>
<div class="row mt-4">
	<div class="col-md-4 px-5">
		<?php if ($inf['num_area']==1): ?>
			<img src="img/avatardr.png" height="250px">
		<?php else: ?>
			<img src="img/avatardr.jpg" height="250px">
		<?php endif ?>
	</div>
  	<div class="col-md-6 p-4">
	 	<div class="table-responsive">
		  <table class="table">
		    <tr>
		    	<th>ID</th>
		    	<td><?php echo $inf['id'] ?></td>
		    </tr>
		    <tr>
		    	<th>Nombre</th>
		    	<td><?php echo $inf['nombre'] ?></td>
		    </tr>
		    <tr>
		    	<th>Area</th>
		    	<td><a><i class="fas fa-ambulance text-<?php echo $borde; ?>"></i>   <?php echo $inf['nombre_area']; ?></a></td>
		    </tr>
		    <tr>
		    	<th>Estado</th>
		    	<td><a class="  btn btn-<?php echo $estat; ?> disabled text-white"><?php echo $estatT; ?></a></td>
		    </tr>
		    <tr>
		    	<th>Calificacion</th>
		    	<td>
		    		<form id="calificar">
					  <p class="clasificacion">
					    <input id="radio1" type="radio" name="estrellas" value="5" checked="checked"><!--
					    --><label for="radio1">★</label><!--
					    --><input id="radio2" type="radio" name="estrellas" value="4"><!--
					    --><label for="radio2">★</label><!--
					    --><input id="radio3" type="radio" name="estrellas" value="3"><!--
					    --><label for="radio3">★</label><!--
					    --><input id="radio4" type="radio" name="estrellas" value="2"><!--
					    --><label for="radio4">★</label><!--
					    --><input id="radio5" type="radio" name="estrellas" value="1"><!--
					    --><label for="radio5">★</label>
					  </p>
					</form>
		    	</td>
		    </tr>
			    
		    
		    
		  </table>
		</div>
	</div>
</div>
<div class="row">
	<div class="table-responsive col-md-6">
		  <table class="table">
		    <tr>
		    	<th>Universidad</th>
		    	<td>UAQ</td>
		    	<th>Correo</th>
		    	<td><?php echo $inf['correo'] ?></td>
		    </tr>
		    <tr>
		    	<th>Cedula</th>
		    	<td><?php echo $inf['cedula'] ?></td>
		    	<th>Fecha Registro</th>
		    	<td><?php echo $inf['fecha'] ?></td>
		    </tr>
		  </table>
	</div>
	<div class="col-md-6">
		<h4 class=" text-center bg-success mb-0 p-2 text-white">Testimonios</h4>
		<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
		  <ol class="carousel-indicators">
		    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
		    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
		    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
		  </ol>
		  <div class="carousel-inner">
		    <div class="carousel-item active">
		      <img class="d-block w-100" src="https://via.placeholder.com/600x150/8AC007?text=%20" alt="First slide">
		      <div class="carousel-caption d-none d-md-block">
			    <h5>Excelente</h5>
			    <p>Acerto a la primera! Ya habia consultado a muchos doctores y simplemente no me sanaba</p>
			  </div>
		    </div>
		    <div class="carousel-item">
		      <img class="d-block w-100" src="https://via.placeholder.com/600x150/8AC007?text=%20" alt="Second slide">
		      <div class="carousel-caption d-none d-md-block">
			    <h5>Me Cure</h5>
			    <p>Ahorre el tiempo que hubiera perdido en otros servicios</p>
			  </div>
		    </div>
		    <div class="carousel-item">
		      <img class="d-block w-100" src="https://via.placeholder.com/600x150/8AC007?text=%20" alt="Third slide">
		      <div class="carousel-caption d-none d-md-block">
			    <h5>Ya puedo salir de casa</h5>
			    <p>Me sentia tan mal que no tenia fuerza ni para ir a un consultorio</p>
			  </div>
		    </div>
		  </div>
		  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
		    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
		    <span class="sr-only">Previous</span>
		  </a>
		  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
		    <span class="carousel-control-next-icon" aria-hidden="true"></span>
		    <span class="sr-only">Next</span>
		  </a>
		</div>
	</div>
</div>

		



