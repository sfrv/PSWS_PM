@extends('layouts.admin')
@section('contenido')
<div class="panel">
	<div class="panel-body container-fluid">
		<div class="row row-lg">
			<div class="col-lg-12">
			    <div class="example-wrap">
			      	<h4>Servicios-Metodos Registradas</h4>
			      	<br>
			      	@include('admCentros.servicio_metodo.search')
			      	<br>
			      	<div class="example table-responsive">
				        <table class="table table-striped">
				          	<thead>
				            	<tr>
					              	<th>Estado</th>
					              	<th>Nro</th>
					              	<th>Seccion</th>
					              	<th>Controlador</th>
					              	<th>Nombre</th>
					              	<th>Tipo</th>
					              	<th>Descripcion</th>
					              	@if(Auth::user()->tipo == 'Administrador')
						             	<th class="text-center">Opciones</th>
						            @endif
				            	</tr>
				          	</thead>
				          	<tbody>
				          		@foreach($servicios as $var)
					            	<tr>
					              		@if($var->estado == 1)
					                      <td><span class="badge badge-pill badge-success float-left">Activo</span></td>
					                    @else
					                      <td><span class="badge badge-pill badge-danger float-left">Inactivo</span></td>
					                    @endif
					              		<td>{{ $var->id }}</td>
					              		<td>{{ $var->seccion }}</td>
					              		<td>{{ $var->controlador }}</td>
					              		<td>{{ $var->nombre }}</td>
					              		@if($var->tipo == 1)
						              		<td>Movil</td>
						              	@else
						              		<td>Web</td>
						              	@endif
						              	<td>{{ $var->descripcion }}</td>
						              	@if(Auth::user()->tipo == 'Administrador')
							             	<td class="text-center">
						              			<a href="{{URL::action('ServicioMetodoController@edit',$var->id)}}" class="panel-action icon md-edit ml-15" data-toggle="tooltip" data-original-title="Editar" data-container="body" title=""></a>
						              			@if($var->estado == 1)
							                    	<a href="" data-target="#modal-delete-{{$var->id}}" class="panel-action icon md-delete ml-15" data-toggle="modal" data-original-title="Eliminar" data-placement="top" title="Eliminar"></a>  
							                    @else
							                      	<a href="" data-target="#modal-delete-{{$var->id}}" class="panel-action icon md-check ml-15"  data-toggle="modal" data-original-title="Habilitar" data-placement="top" title="Habilitar"></a>
							                    @endif
						              		</td>
						                @endif
					            	</tr>
					            	@include('admCentros.servicio_metodo.modal')
				            	@endforeach
				          	</tbody>
				        </table>
			      	</div>
			      	<div>
				      	{{ $servicios->links('admCentros.custom') }}
			      	</div>
			    </div>
			</div>
		</div>
	</div>
</div>
@include('admCentros.alertas.logrado')
@endsection