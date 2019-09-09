@extends('layouts.admin')
@section('contenido')
<div class="panel">
	<div class="panel-body container-fluid">
		<div class="row row-lg">
			<div class="col-lg-12">
			    <div class="example-wrap">
			    	<h4>Usuarios Registradas</h4>
			    	<br>
			      	@include('admCentros.usuario.search')
			      	<br>
			      	<div class="example table-responsive">
				        <table class="table table-striped">
				          	<thead>
				            	<tr>
					              	<th>Estado</th>
					              	<th>Nombre</th>
					              	<th>Apellido</th>
					              	<th>Email</th>
					              	<th>Name</th>
					              	<th>Tipo</th>
					              	<th>Centro Medico</th>
					              	@if(Auth::user()->tipo == 'Administrador')
						             	<th class="text-center">Opciones</th>
						            @endif
				            	</tr>
				          	</thead>
				          	<tbody>
				          		@foreach($usuarios as $var)
					            	<tr>
					              		@if($var->estado == 1)
					                      <td><span class="badge badge-pill badge-success float-left">Activo</span></td>
					                    @else
					                      <td><span class="badge badge-pill badge-danger float-left">Inactivo</span></td>
					                    @endif
					              		<td>{{ $var->nombre }}</td>
					                    <td>{{ $var->apellido }}</td>
					                    <td>{{ $var->email }}</td>
					                    <td>{{ $var->name }}</td>
					                    <td>{{ $var->tipo }}</td>
					                    <td>{{ $var->id_centro_medico }}</td>
					                    @if(Auth::user()->tipo == 'Administrador')
							             	<td class="text-center">
						              			<a href="{{URL::action('UsuarioController@edit',$var->id)}}" class="panel-action icon md-edit ml-15" data-toggle="tooltip" data-original-title="Editar" data-container="body" title=""></a>
						              			<a href="" data-target="#modal-delete-{{$var->id}}" class="panel-action icon md-delete ml-15" data-toggle="modal" data-original-title="Eliminar" data-placement="top" title="Eliminar"></a>
						              		</td>
						                @endif
					            	</tr>
					            	@include('admCentros.usuario.modal')
				            	@endforeach
				          	</tbody>
				        </table>
			      	</div>
			      	<div>
				      	{{ $usuarios->links('admCentros.custom') }}
				      	@if(Auth::user()->tipo == 'Administrador')
							<div class="site-action" data-plugin="actionBtn">
								<a href="usuario/create">
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
