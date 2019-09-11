@extends('layouts.admin')
@section('contenido')
<div class="panel">
	<div class="panel-body container-fluid">
		<div class="row row-lg">
			<div class="col-lg-12">
			    <div class="example-wrap">
			      	<h4>Editar Previlegios de: {{$usuario->email}}</h4>
			      	<br>
			      	{!!Form::model($usuario,['method'=>'PATCH','route'=>['previlegio.update',$usuario->id]])!!}
            		{{Form::token()}}
            		<h4>Previlegios Registrados</h4>
      			  	<div class="example table-responsive">
	          			<table id="detalles" class="table table-striped">
	          			<thead>
	      					<tr>
				                <th class="text-center">Modulo</th>
				                <th class="text-center">Opcion</th>
				                <th class="text-center">Estado</th>
	      					</tr>
	          			</thead>
	          			<tbody>
	          				@foreach($previlegios as $var)
		                      	<tr class="text-center">
		                          	<td>{{$var -> nombre_modulo}}</td>
		                          	<td><input type="hidden" name="id_previlegios[]" value="{{$var -> id}}">{{$var -> nombre_caso_uso}}</td>
		                          	<td>
			                          	<div class="checkbox-custom checkbox-primary">
		                            	@if($var -> estado == 1)
		                              		<input name="{{$var -> id}}_cu" type="checkbox" checked>
		                            	@else
		                              		<input name="{{$var -> id}}_cu" type="checkbox" >
		                            	@endif
			                          	<label for="inputSchedule">
					                    </label>
			                          	</div>
			                        </td>
		                      	</tr>
		                  	@endforeach
		                </tbody>
	          			</table>
      				</div>	
	              	<div class="col-sm-8 col-sm-offset-2" id="guardar">
	              		<button type="submit" class="btn btn-primary btn-block btn-round" data-style="slide-right" data-plugin="ladda">
	              			<span class="ladda-label">Editar Previlegios<i class="icon md-long-arrow-right ml-10" aria-hidden="true"></i></span>
	              		</button>
	              	</div>
		            {!! Form::close() !!}
			    </div>
			</div>
		</div>
	</div>
</div>
@endsection