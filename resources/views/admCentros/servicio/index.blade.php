@extends('layouts.admin')
@section('contenido')
<div class="panel">
	<div class="panel-body container-fluid">
		<div class="row row-lg">
			<div class="col-lg-12">
			    <div class="example-wrap">
			      	<h4>Tipos de Servicios Registradas</h4>
			      	<br>
			      	@include('admCentros.servicio.search')
			      	<br>
			      	<div class="example table-responsive">
				        <table class="table table-striped">
				          	<thead>
				            	<tr>
					              	<th>Estado</th>
					              	<th>Nombre</th>
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
					              		<td>{{ $var->nombre }}</td>
						              	<td>{{ $var->descripcion }}</td>
						              	@if(Auth::user()->tipo == 'Administrador')
							             	<td class="text-center">
						              			<a href="{{URL::action('TipoServicioController@edit',$var->id)}}" class="panel-action icon md-edit ml-15" data-toggle="tooltip" data-original-title="Editar" data-container="body" title=""></a>
						              			<a href="" data-target="#modal-delete-{{$var->id}}" class="panel-action icon md-delete ml-15" data-toggle="modal" data-original-title="Eliminar" data-placement="top" title="Eliminar"></a>
						              		</td>
						                @endif
					            	</tr>
					            	@include('admCentros.servicio.modal')
				            	@endforeach
				          	</tbody>
				        </table>
			      	</div>
			      	<div>
				      	{{ $servicios->links('admCentros.custom') }}
				      	@if(Auth::user()->tipo == 'Administrador')
					      	<div class="site-action" data-plugin="actionBtn">
								<a href="servicio/create">
									<button type="button" class="site-action-toggle btn-raised btn btn-primary btn-floating">
										<i class="front-icon md-plus animation-scale-up" aria-hidden="true"></i>
						        		<i class="back-icon md-close animation-scale-up" aria-hidden="true"></i>
									</button>
								</a>
						    </div>
					    @endif
			      	</div>
			    </div>
			</div>
		</div>
	</div>
</div>
@include('admCentros.alertas.logrado')
@endsection