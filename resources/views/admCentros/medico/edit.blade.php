@extends('layouts.admin')
@section('contenido')
<div class="panel">
	<div class="panel-body container-fluid">
		<div class="row row-lg">
			<div class="col-lg-12">
			    <div class="example-wrap">
			      	<h4>Editar Medico: "{{$medico->nombre}} {{$medico->apellido}}"</h4>
			      	<br>
			      	{!!Form::model($medico,['method'=>'PATCH','route'=>['medico.update',$medico->id]])!!}
            		{{Form::token()}}
		              	<div class="row">
		              		<div class="col-lg-6 col-xs-12">
			                	<div class="row">
			                  		<div class="col-lg-12 col-md-9 form-group form-material">
			                    		<input type="text" class="form-control is-valid" name="nombre" value="{{$medico->nombre}}" required>
			                  		</div>
			                	</div>
			              	</div>
			              	<br>
			              	<div class="col-lg-6 col-xs-12">
			                	<div class="row">
			                  		<div class="col-lg-12 col-md-9 form-group form-material">
			                    	<input type="text" class="form-control is-invalid" name="apellido" value="{{$medico->apellido}}"
			                      required>
			                  	</div>
			                	</div>
			              	</div>
			              	<br>
			              	<div class="col-lg-6 col-xs-12">
			                	<div class="row">
			                  		<div class="col-lg-12 col-md-9 form-group form-material">
			                    		<input type="email" class="form-control is-valid" name="correo" value="{{$medico->correo}}" required>
			                  		</div>
			                	</div>
			              	</div>
			              	<br>
			              	<div class="col-lg-6 col-xs-12">
			                	<div class="row">
			                  		<div class="col-lg-12 col-md-9 form-group form-material">
			                    	<input type="number" class="form-control is-invalid" name="telefono" value="{{$medico->telefono}}"
			                      required>
			                  	</div>
			                	</div>
			              	</div>
			              	<br>
			              	<div class="col-lg-12 col-xs-12">
			                	<div class="row">
			                  		<div class="col-lg-12 col-md-9 form-group form-material">
			                    		<input type="text" class="form-control is-valid" name="direccion" value="{{$medico->direccion}}" required>
			                  		</div>
			                	</div>
			              	</div>
			              	<br>
		              	</div>
		              	<br>
		              	<div class="col-sm-8 col-sm-offset-2" id="guardar">
		              		<button type="submit" class="btn btn-primary btn-block btn-round" data-style="slide-right" data-plugin="ladda">
		              			<span class="ladda-label">Editar Medico<i class="icon md-long-arrow-right ml-10" aria-hidden="true"></i></span>
		              		</button>
		              	</div>
		            {!! Form::close() !!}
			    </div>
			</div>
		</div>
	</div>
</div>
@endsection