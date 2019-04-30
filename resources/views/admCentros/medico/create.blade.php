@extends('layouts.admin')
@section('contenido')
<div class="panel">
	<div class="panel-body container-fluid">
		<div class="row row-lg">
			<div class="col-lg-12">
			    <div class="example-wrap">
			      	<h4>Registrar Nuevo Medico</h4>
			      	<br>
			      	{!!Form::open(array('url'=>'adm/medico','method'=>'POST','autocomplete'=>'off'))!!}
  			    	{{Form::token()}}
		              	<div class="row">
		              		<div class="col-lg-6 col-xs-12">
			                	<div class="row">
			                  		<div class="col-lg-12 col-md-9 form-group form-material">
			                    		<input type="text" class="form-control is-valid" name="nombre" placeholder="Nombre del Medico..." required>
			                  		</div>
			                	</div>
			              	</div>
			              	<br>
			              	<div class="col-lg-6 col-xs-12">
			                	<div class="row">
			                  		<div class="col-lg-12 col-md-9 form-group form-material">
			                    	<input type="text" class="form-control is-invalid" name="apellido" placeholder="Apellido del Medico..."
			                      required>
			                  	</div>
			                	</div>
			              	</div>
			              	<br>
			              	<div class="col-lg-6 col-xs-12">
			                	<div class="row">
			                  		<div class="col-lg-12 col-md-9 form-group form-material">
			                    		<input type="email" class="form-control is-valid" name="correo" placeholder="Email..." required>
			                  		</div>
			                	</div>
			              	</div>
			              	<br>
			              	<div class="col-lg-6 col-xs-12">
			                	<div class="row">
			                  		<div class="col-lg-12 col-md-9 form-group form-material">
			                    	<input type="number" class="form-control is-invalid" name="telefono" placeholder="Telefono..."
			                      required>
			                  	</div>
			                	</div>
			              	</div>
			              	<br>
			              	<div class="col-lg-12 col-xs-12">
			                	<div class="row">
			                  		<div class="col-lg-12 col-md-9 form-group form-material">
			                    		<input type="text" class="form-control is-valid" name="direccion" placeholder="Direccion Domicilio..." required>
			                  		</div>
			                	</div>
			              	</div>
			              	<br>
		              	</div>
		              	<br>
		              	<div class="col-sm-8 col-sm-offset-2" id="guardar">
		              		<button type="submit" class="btn btn-primary btn-block btn-round" data-style="slide-right" data-plugin="ladda">
		              			<span class="ladda-label">Registrar Medico<i class="icon md-long-arrow-right ml-10" aria-hidden="true"></i></span>
		              		</button>
		              	</div>
		            {!! Form::close() !!}
			    </div>
			</div>
		</div>
	</div>
</div>
@endsection