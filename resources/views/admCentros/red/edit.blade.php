@extends('layouts.admin')
@section('contenido')
<div class="panel">
	<div class="panel-body container-fluid">
		<div class="row row-lg">
			<div class="col-lg-12">
			    <div class="example-wrap">
			      	<h4>Editar Red: "{{$red->id}} - {{$red->nombre}}"</h4>
			      	<br>
			      	{!!Form::model($red,['method'=>'PATCH','route'=>['red.update',$red->id]])!!}
            		{{Form::token()}}
		              	<div class="row">
		              		<div class="col-lg-12">
			                	<div class="row">
			                  		<div class="col-lg-12 col-md-9 form-group form-material">
			                    		<input type="text" class="form-control is-valid" name="nombre" value="{{$red->nombre}}" required>
			                  		</div>
			                	</div>
			              	</div>
			              	<br>
			              	<div class="col-lg-12">
			                	<div class="row">
			                  		<div class="col-lg-12 col-md-9 form-group form-material">
			                    	<input type="text" class="form-control is-invalid" name="descripcion" value="{{$red->descripcion}}" required>
			                  	</div>
			                	</div>
			              	</div>
		              	</div>
		              	<br>
		              	<div class="col-sm-8 col-sm-offset-2" id="guardar">
		              		<button type="submit" class="btn btn-primary btn-block btn-round" data-style="slide-right" data-plugin="ladda">
		              			<span class="ladda-label">Editar Red<i class="icon md-long-arrow-right ml-10" aria-hidden="true"></i></span>
		              		</button>
		              	</div>
		            {!! Form::close() !!}
			    </div>
			</div>
		</div>
	</div>
</div>
@endsection