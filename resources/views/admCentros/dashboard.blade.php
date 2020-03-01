@extends('layouts.admin')
@section('contenido')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="{{asset('global/vendor/slick-carousel/slick.css')}}">
<link rel="stylesheet" href="{{asset('base/assets/examples/css/pages/profile-v2.css')}}">
<div class="panel">
	<div class="panel-body container-fluid">
		<div class="row row-lg">
			<div class="col-lg-12">
			    <div class="example-wrap">
			    	<div class="row">
			    		<div class="col-lg-12 col-xs-12">
							<h4>Centros Medicos <i class="site-menu-icon md-balance" aria-hidden="true"></i></h4>
							<br>
						</div>
						<hr>
			    	</div>
					<div id="myCarousel" class="carousel slide" data-ride="carousel">
						<!-- Indicators -->
					    <ol class="carousel-indicators">
						    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
						    <li data-target="#myCarousel" data-slide-to="1"></li>
						    <li data-target="#myCarousel" data-slide-to="2"></li>
						    <li data-target="#myCarousel" data-slide-to="3"></li>
						    <li data-target="#myCarousel" data-slide-to="4"></li>
						</ol>

					  <!-- Wrapper for slides -->
					  <div class="carousel-inner">
					    <div class="item active">
					      <img src="{{asset('images/Centros/carrrusel_01.jpg')}}" style="width:100%;height: 350px;opacity: 0.8;" alt="Los Angeles">
					    </div>

					    <div class="item">
					      <img src="{{asset('images/Centros/carrrusel_02.jpg')}}" style="width:100%;height: 350px;opacity: 0.8;" alt="Chicago">
					    </div>

					    <div class="item">
					      <img src="{{asset('images/Centros/carrrusel_03.jpg')}}" style="width:100%;height: 350px;opacity: 0.8;" alt="New York">
					    </div>

					    <div class="item">
					      <img src="{{asset('images/Centros/carrrusel_04.jpg')}}" style="width:100%;height: 350px;opacity: 0.8;" alt="Chicago">
					    </div>

					    <div class="item">
					      <img src="{{asset('images/Centros/carrrusel_05.jpg')}}" style="width:100%;height: 350px;opacity: 0.8;" alt="New York">
					    </div>
					  </div>

					  <!-- Left and right controls -->
					  <a class="left carousel-control" href="#myCarousel" data-slide="prev">
					    <span class="glyphicon glyphicon-chevron-left"></span>
					    <span class="sr-only">Previous</span>
					  </a>
					  <a class="right carousel-control" href="#myCarousel" data-slide="next">
					    <span class="glyphicon glyphicon-chevron-right"></span>
					    <span class="sr-only">Next</span>
					  </a>
					</div>
					<br>
					<hr>
					<div class="row">
			    		<div class="col-lg-6 col-xs-12">
				            <div class="user-info card card-shadow text-center">
				              <div class="user-base card-block">
				                <a class="avatar img-bordered avatar-100" style="width: 40%" href="javascript:void(0)">
				                  <img style="opacity: 0.8" src="{{asset('images/Centros/crued.PNG')}}">
				                </a>
				                <br>
				                <br>
				                <h4 class="user-name">CRUED</h4>
				                <p class="user-job">Centro Regulador de Urgencias y Emergencia Departamental</p>
				              </div>
				              <div class="user-socials list-group list-group-full">
				                <a class="list-group-item justify-content-center" href="javascript:void(0)">
				                  <i class="site-menu-icon md-pin-drop"></i>Direccion: 4to Anillo Avenida Alemania, esquina derecha de la rotonda yendo al 5to anillo, Santa Cruz de la Sierra
				                </a>
				                    <a class="list-group-item justify-content-center" href="javascript:void(0)">
				                  <i class="site-menu-icon md-phone"></i> Telefono: 3 3636584
				                </a>
				                    <a class="list-group-item justify-content-center" href="javascript:void(0)">
				                  <i class="site-menu-icon md-time"></i> Horario: 08:00 a 12:00 - 14:00 a 18:00 
				                </a>
				              </div>
				              <div class="card-footer">
				                <a href="https://www.google.com/maps/place/Secretaria+Departamental+de+Seguridad+Ciudadana/@-17.7508902,-63.1661924,16z/data=!4m12!1m6!3m5!1s0x93f1e93d6a375b53:0x36246515e3d5fed9!2sServicio+Departamental+de+Salud+(SEDES)+Santa+Cruz!8m2!3d-17.796961!4d-63.1860309!3m4!1s0x0:0x919f3d63b3bac578!8m2!3d-17.7516537!4d-63.1632512">
					                <i class="site-menu-icon md-google-maps"></i> Ubicacion
					            </a>
				              </div>
				            </div>
			            </div>
						<div class="col-lg-6 col-xs-12">
				            <div class="user-info card card-shadow text-center">
				              <div class="user-base card-block">
				                <a class="avatar img-bordered avatar-100" style="width: 40%" href="javascript:void(0)">
				                  <img style="opacity: 0.8" src="{{asset('images/Centros/sedes.jpeg')}}">
				                </a>
				                <h4 class="user-name">SEDES</h4>
				                <p class="user-job">Servicio Departamental de Salud</p>
				              </div>
				              <div class="user-socials list-group list-group-full">
				                <a class="list-group-item justify-content-center" href="javascript:void(0)">
				                  <i class="site-menu-icon md-pin-drop"></i>Direccion: Primer Piso, Av. Omar Chavez Ortiz, Esq. Pozo Edifico de la Gobernacion de Santa Cruz BLoque "B, Santa Cruz de la Sierra
				                </a>
				                    <a class="list-group-item justify-content-center" href="javascript:void(0)">
				                  <i class="site-menu-icon md-phone"></i> Telefono: 3 3636606
				                </a>
				                    <a class="list-group-item justify-content-center" href="javascript:void(0)">
				                  <i class="site-menu-icon md-time"></i> Horario: 08:00 a 12:00 - 14:00 a 18:00 
				                </a>
				              </div>
				              <div class="card-footer">
				                <a href="https://www.google.com/maps/place/Servicio+Departamental+de+Salud+(SEDES)+Santa+Cruz/@-17.8034885,-63.1893029,13z/data=!4m5!3m4!1s0x93f1e93d6a375b53:0x36246515e3d5fed9!8m2!3d-17.796961!4d-63.1860309">
					                <i class="site-menu-icon md-google-maps"></i> Ubicacion
					            </a>
				              </div>
				            </div>
			            </div>
			    	</div>
			    	<hr>
				</div>
			</div>
		</div>
	</div>
</div>
@include('admCentros.alertas.servicio_metodo_eliminado')
@endsection