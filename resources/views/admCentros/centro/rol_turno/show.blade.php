@extends('layouts.admin')
@section('contenido')
<div class="panel">
	<div class="panel-body container-fluid">
		<div class="row row-lg">
			<div class="col-lg-12">
			    <div class="example-wrap">
			      	<div class="row">
			      		<div class="col-lg-9 col-xs-12">
			      			<h4>Vizualizar Rold de Turno: {{$rol_turno->mes}} {{$rol_turno->anio}}</h4>	
			      		</div>
			      		<div class="col-lg-3 col-xs-12">
			      			<ol class="breadcrumb">
						     	<li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
						     	<li><a href="{{url('adm/centro')}}">Centros</a></li>
						     	<li><a href="{{ route('index-rol-turno', $id_centro) }}">Index de Rol Turno</a></li>
						  	</ol>
			      		</div>
			      	</div>
			      	<br>
		              	<div class="row">
		              		<div class="col-lg-4 col-xs-12">
		                  		<div class="form-group form-material floating" data-plugin="formMaterial">
				                	<input disabled type="text" class="form-control" value="{{$rol_turno->titulo}}" name="titulo"/>
				                    <label class="floating-label">Titulo</label>
				                </div>
			              	</div>
			              	<div class="col-lg-4 col-xs-12">
		                  		<div class="form-group form-material floating" data-plugin="formMaterial">
				                	<input disabled required type="text" class="form-control" value="{{$rol_turno->mes}}" name="titulo"/>
				                    <label class="floating-label">Mes</label>
				                </div>
			              	</div>
				            <div class="col-lg-4 col-xs-12">
		                  		<div class="form-group form-material floating" data-plugin="formMaterial">
				                	<input disabled type="text" class="form-control" value="{{$rol_turno->anio}}"/>
				                    <label class="floating-label">Anio</label>
				                </div>
			              	</div>
				            <div class="col-lg-3 col-xs-12">
				                <div class="card card-block p-30">
				                  	<div class="counter counter-md text-left">
				                    	<div class="row">
				                    		<div class="col-lg-8 col-xs-5 counter counter-md counter text-left">
					                      		<span class="counter-icon mr-10 blue-600">
						                    	<i class="site-menu-icon md-favorite-outline" style="font-size: 1.53em;"></i>
						                  		</span>
					                    	</div>
					                    	<div class="col-lg-4 col-xs-7 counter counter-md counter text-left">
					                      		<span class="counter-number">E.E</span>
					                      		<span class="counter-number-related text-capitalize">Emerguencia</span>
					                    	</div>
				                    	</div>
				                    	<div class="counter-label">
				                      		<div class="progress progress-xs mb-10">
				                        		<div class="progress-bar progress-bar-info bg-blue-600" aria-valuenow="70.3" aria-valuemin="0"
				                          aria-valuemax="100" style="width: 100%" role="progressbar">
				                        		</div>
				                      		</div>
				                      		<div class="counter counter-sm text-left">
				                        		<div class="counter-number-group">
				                          			<span class="counter-icon blue-600 mr-5"><a href="{{ route('show-rol-turno-emergencia', [$rol_turno->id,$id_centro]) }}" class="small-box-footer">Ver Etapa <i class="md-eye"></i></a></span>
				                        		</div>
				                      		</div>
				                    	</div>
				                  	</div>
				                </div>
			                </div>
			                <div class="col-lg-3 col-xs-12">
				                <div class="card card-block p-30">
				                  	<div class="counter counter-md text-left">
				                    	<div class="row">
				                    		<div class="col-lg-7 col-xs-5 counter counter-md counter text-left">
					                      		<span class="counter-icon mr-10 blue-600">
						                    	<i class="icon md-hospital" style="font-size: 1.73em;"></i>
						                  		</span>
					                    	</div>
					                    	<div class="col-lg-5 col-xs-7 counter counter-md counter text-left">
					                      		<span class="counter-number">E.C.E.</span>
					                      		<span class="counter-number-related text-capitalize">Consulta_Externa</span>
					                    	</div>
				                    	</div>
				                    	<div class="counter-label">
				                      		<div class="progress progress-xs mb-10">
				                        		<div class="progress-bar progress-bar-info bg-blue-600" aria-valuenow="70.3" aria-valuemin="0"
				                          aria-valuemax="100" style="width: 100%" role="progressbar">
				                        		</div>
				                      		</div>
				                      		<div class="counter counter-sm text-left">
				                        		<div class="counter-number-group">
				                          			<span class="counter-icon blue-600 mr-5"><a href="{{ route('show-rol-turno-consulta', [$rol_turno->id,$id_centro]) }}" class="small-box-footer">Ver Etapa <i class="md-eye"></i></a></span>
				                        		</div>
				                      		</div>
				                    	</div>
				                  	</div>
				                </div>
			                </div>
			                <div class="col-lg-3 col-xs-12">
				                <div class="card card-block p-30">
				                  	<div class="counter counter-md text-left">
				                    	<div class="row">
				                    		<div class="col-lg-7 col-xs-5 counter counter-md counter text-left">
					                      		<span class="counter-icon mr-10 blue-600">
						                    	<i class="icon md-store-24" style="font-size: 1.73em;"></i>
						                  		</span>
					                    	</div>
					                    	<div class="col-lg-5 col-xs-7 counter counter-md counter text-left">
					                      		<span class="counter-number">E.H</span>
					                      		<span class="counter-number-related text-capitalize">Hospitalizacion</span>
					                    	</div>
				                    	</div>
				                    	<div class="counter-label">
				                      		<div class="progress progress-xs mb-10">
				                        		<div class="progress-bar progress-bar-info bg-blue-600" aria-valuenow="70.3" aria-valuemin="0"
				                          aria-valuemax="100" style="width: 100%" role="progressbar">
				                        		</div>
				                      		</div>
				                      		<div class="counter counter-sm text-left">
				                        		<div class="counter-number-group">
				                          			<span class="counter-icon blue-600 mr-5"><a href="{{ route('show-rol-turno-hospitalizacion', [$rol_turno->id,$id_centro]) }}" class="small-box-footer">Ver Etapa <i class="md-eye"></i></a></span>
				                        		</div>
				                      		</div>
				                    	</div>
				                  	</div>
				                </div>
			                </div>
			                <div class="col-lg-3 col-xs-12">
				                <div class="card card-block p-30">
				                  	<div class="counter counter-md text-left">
				                    	<div class="row">
				                    		<div class="col-lg-7 col-xs-5 counter counter-md counter text-left">
					                      		<span class="counter-icon mr-10 blue-600">
						                    	<i class="icon md-account-add" style="font-size: 1.73em;"></i>
						                  		</span>
					                    	</div>
					                    	<div class="col-lg-5 col-xs-7 counter counter-md counter text-left">
					                      		<span class="counter-number">E.P.E.</span>
					                      		<span class="counter-number-related text-capitalize">Personal_Encargado</span>
					                    	</div>
				                    	</div>
				                    	<div class="counter-label">
				                      		<div class="progress progress-xs mb-10">
				                        		<div class="progress-bar progress-bar-info bg-blue-600" aria-valuenow="70.3" aria-valuemin="0"
				                          aria-valuemax="100" style="width: 100%" role="progressbar">
				                        		</div>
				                      		</div>
				                      		<div class="counter counter-sm text-left">
				                        		<div class="counter-number-group">
				                          			<span class="counter-icon blue-600 mr-5"><a href="{{ route('show-rol-turno-personal-encargado', [$rol_turno->id,$id_centro]) }}" class="small-box-footer">Ver Etapa <i class="md-eye"></i></a></span>
				                        		</div>
				                      		</div>
				                    	</div>
				                  	</div>
				                </div>
			                </div>
		              	</div>
		              	<br>
		              	<div class="col-sm-8 col-sm-offset-2">
		              		<a href="{{url('adm/centro/index_rol_turno/'.$id_centro)}}">
			              		<button class="btn btn-primary btn-block btn-round" data-style="slide-left" data-plugin="ladda">
			              			<span class="ladda-label"><i class="icon md-long-arrow-left ml-10" aria-hidden="true"></i> Volver Inicio</span>
			              		</button>
			              	</a>
		              	</div>
			    </div>
			</div>
		</div>
	</div>
</div>
@include('admCentros.alertas.logrado')
@push ('scripts')
<script>
setTimeout(clickb,1500);
function clickb() {
	var obj=document.getElementById('linkmn');
	obj.click();
}

</script>
@endpush
@endsection