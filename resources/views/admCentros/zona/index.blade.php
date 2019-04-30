@extends('layouts.admin')
@section('contenido')
<div class="panel">
	<div class="panel-body container-fluid">
		<div class="row row-lg">
			<div class="col-lg-12">
			    <div class="example-wrap">
			      	<h4>Zonas Registradas</h4>
			      	<br>
			      	@include('admCentros.zona.search')
			      	<br>
			      	<div class="example table-responsive">
				        <table class="table table-striped">
				          	<thead>
				            	<tr>
					              	<th>Estado</th>
					              	<th>Nombre</th>
					              	<th>Descripcion</th>
					              	<th>Id</th>
					              	<th>Opciones</th>
				            	</tr>
				          	</thead>
				          	<tbody>
				          		@foreach($zonas as $var)
					            	<tr>
					              		@if($var->estado == 1)
					                      <td><span class="badge badge-pill badge-success float-left">Activo</span></td>
					                    @else
					                      <td><span class="badge badge-pill badge-danger float-left">Inactivo</span></td>
					                    @endif
					              		<td>{{ $var->nombre }}</td>
						              	<td>{{ $var->descripcion }}</td>
						              	<td>{{ $var->id }}</td>
					              		<td>
					              			<div class="btn-group" role="group">
						                      <button type="button" class="btn btn-info dropdown-toggle" id="exampleIconDropdown{{ $var->id }}"
						                        data-toggle="dropdown" aria-expanded="false">
						                        <i class="icon md-settings" aria-hidden="true"></i>
						                      </button>
						                      <div class="dropdown-menu" aria-labelledby="exampleIconDropdown{{ $var->id }}" role="menu">
						                        <a class="dropdown-item" href="javascript:void(0)" role="menuitem"><i class="icon md-edit" aria-hidden="true"></i> {{ $var->id }}</a>
						                        <a class="dropdown-item" href="{{URL::action('ZonaController@edit',$var->id)}}" role="menuitem"><i class="icon md-edit" aria-hidden="true"></i> Editar</a>
						                        <a class="dropdown-item" href="" data-target="#modal-delete-{{$var->id}}" data-toggle="modal" class="btn btn-danger" data-placement="top" data-original-title="Remove"><i class="icon md-delete" aria-hidden="true"></i> Eliminar</a>
						                      </div>
						                    </div>
					              		</td>
					            	</tr>
					            	@include('admCentros.zona.modal')
				            	@endforeach
				          	</tbody>
				        </table>
			      	</div>
			      	<div>
				      	{{ $zonas->links('admCentros.custom') }}
				      	<div class="site-action" data-plugin="actionBtn">
							<a href="zona/create">
								<button type="button" class="site-action-toggle btn-raised btn btn-primary btn-floating">
									<i class="front-icon md-plus animation-scale-up" aria-hidden="true"></i>
					        		<i class="back-icon md-close animation-scale-up" aria-hidden="true"></i>
								</button>
							</a>
					    </div>
			      	</div>
			    </div>
			</div>
		</div>
	</div>
</div>
@include('admCentros.alertas.logrado')
@endsection