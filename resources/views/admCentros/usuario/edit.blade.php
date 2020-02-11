@extends('layouts.admin')
@section('contenido')
<div class="panel">
	<div class="panel-body container-fluid">
		<div class="row row-lg">
			<div class="col-lg-12">
			    <div class="example-wrap">
			      	<h4>Editar Usuario: {{$usuario->nombre}} {{$usuario->apellido}}</h4>
			      	<br>
			      	{!!Form::model($usuario,['method'=>'PATCH','route'=>['usuario.update',$usuario->id]])!!}
            		{{Form::token()}}
		              	<div class="row">
		              		<div class="col-lg-6 col-xs-12">
		                  		<div class="form-group form-material floating" data-plugin="formMaterial">
				                	<input value="{{$usuario->nombre}}" required type="text" class="form-control" name="nombre"/>
				                    <label class="floating-label">Nombre</label>
				                </div>
			              	</div>
			              	<div class="col-lg-6 col-xs-12">
		                  		<div class="form-group form-material floating" data-plugin="formMaterial">
				                	<input value="{{$usuario->apellido}}" required type="text" class="form-control" name="apellido"/>
				                    <label class="floating-label">Apellido</label>
				                </div>
			              	</div>
			              	<div class="col-lg-6 col-xs-12">
		                  		<div class="form-group form-material floating" data-plugin="formMaterial">
				                	<input value="{{$usuario->email}}" required type="email" class="form-control" name="email"/>
				                    <label class="floating-label">Email</label>
				                </div>
			              	</div>
			              	<div class="col-lg-6 col-xs-12">
		                  		<div class="form-group form-material floating" data-plugin="formMaterial">
				                	<input value="{{$usuario->name}}" required type="text" class="form-control" name="name"/>
				                    <label class="floating-label">Name</label>
				                </div>
			              	</div>
			              	<div class="col-lg-6 col-xs-12">
		                  		<div class="form-group" data-plugin="formMaterial">
				                	<label class="floating-label">Centro Medico</label>
				                	<select name="id_centro_medico" class="form-control">
					                    @foreach($centros as $var)
					                    	@if($var->id == $usuario->id_centro_medico)
					                      		<option value="{{$var->id}}" selected>{{$var->nombre}}</option>
					                    	@else
					                      		<option value="{{$var->id}}">{{$var->nombre}}</option>
					                    	@endif
					                  	@endforeach
				              		</select>
				                </div>
			              	</div>
			              	<div class="col-lg-6 col-xs-12">
		                  		<div class="form-group" data-plugin="formMaterial">
				                	<label class="floating-label">Tipo Usuario</label>
				                	<select name="tipo" id="tipo" class="form-control selectpicker">
						                @foreach($tipos_usuario as $var)
					                    	@if($var->nombre == $usuario->tipo)
					                      		<option value="{{$var->id}}" selected>{{$var->nombre}}</option>
					                    	@else
					                      		<option value="{{$var->id}}">{{$var->nombre}}</option>
					                    	@endif
					                  	@endforeach
						            </select>
				                </div>
			              	</div>
			              	<div class="col-lg-6 col-xs-12">
		                  		<div class="form-group form-material floating" data-plugin="formMaterial">
				                	<input type="password" class="form-control" name="password"/>
				                    <label class="floating-label">Password</label>
				                </div>
			              	</div>
			              	<div class="col-lg-6 col-xs-12">
		                  		<div class="form-group form-material floating" data-plugin="formMaterial">
				                	<input type="password" class="form-control" name="password_"/>
				                    <label class="floating-label">Confirmar Password</label>
				                </div>
			              	</div>
		              	</div>
		              	<br>
		              	<div class="col-sm-8 col-sm-offset-2" id="guardar">
		              		<button type="submit" class="btn btn-primary btn-block btn-round" data-style="slide-right" data-plugin="ladda">
		              			<span class="ladda-label">Editar Usuario<i class="icon md-long-arrow-right ml-10" aria-hidden="true"></i></span>
		              		</button>
		              	</div>
		            {!! Form::close() !!}
			    </div>
			</div>
		</div>
	</div>
</div>
@endsection