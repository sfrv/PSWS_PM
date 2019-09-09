@extends('layouts.admin')
@section('contenido')
<div class="panel">
	<div class="panel-body container-fluid">
		<div class="row row-lg">
			<div class="col-lg-12">
			    <div class="example-wrap">
			      	<h4>Cartera de Servicio de {{ $centro->nombre }}</h4>
			      	<br>
			      	@include('admCentros.centro.cartera_servicio.search')
			      	<br>
			      	<div class="example table-responsive">
				        <table class="table table-striped">
				          	<thead>
				            	<tr>
					              	<th>Estado</th>
					              	<th>Titulo</th>
					              	<th>Fecha</th>
					              	<th>Id</th>
					              	<th class="text-center">Opciones</th>
				            	</tr>
				          	</thead>
				          	<tbody>
				          		@foreach($cartera_servicios as $var)
					            	<tr>
					              		@if($var->estado == 1)
					                      <td><span class="badge badge-pill badge-success float-left">Activo</span></td>
					                    @else
					                      <td><span class="badge badge-pill badge-danger float-left">Inactivo</span></td>
					                    @endif
					              		<td>{{ $var->titulo }}</td>
						              	<td>{{ $var->mes }} / {{ $var->anio }} </td>
						              	<td>{{ $var->id }}</td>
					              		<td class="text-center">
					              			@if(Auth::user()->id_centro_medico == $centro->id || Auth::user()->tipo == 'Administrador' )
						              			<a href="{{ route('edit-cartera-servicio',[$var->id,$centro->id]) }}" class="panel-action icon md-edit ml-15" data-toggle="tooltip" data-original-title="Editar" data-container="body" title=""></a>
	                            				<a href="{{ route('renovate-cartera-servicio',[$var->id,$centro->id] ) }}" class="panel-action icon md-refresh-alt ml-15" data-toggle="tooltip" data-original-title="Renovar" data-container="body" title=""></a>
	                            				<i class="icon md-delete ml-15" aria-hidden="true"
	                            				data-toggle="tooltip" data-original-title="help" data-container="body"
	                            				title=""></i>
	                            			@endif
                            				<a href="{{ route('show-cartera-servicio',[$var->id,$centro->id]) }}" class="panel-action icon md-eye ml-15" data-toggle="tooltip" data-original-title="Ver Mas" data-container="body" title=""></a>
                            				<a href="{{ route('generar-excel-cartera-servicio',[$var->id,$centro->id] ) }}" class="panel-action icon md-download ml-15" data-toggle="tooltip" data-original-title="Generar Excel" data-container="body" title=""></a>
					              			<!-- <div class="btn-group" role="group">
						                      <button type="button" class="btn btn-info dropdown-toggle" id="exampleIconDropdown{{ $var->id }}"
						                        data-toggle="dropdown" aria-expanded="false">
						                        <i class="icon md-settings" aria-hidden="true"></i>
						                      </button>
						                      <div class="dropdown-menu" aria-labelledby="exampleIconDropdown{{ $var->id }}" role="menu">
						                        <a class="dropdown-item" href="javascript:void(0)" role="menuitem"><i class="icon md-edit" aria-hidden="true"></i> {{ $var->id }}</a>
						                        <a class="dropdown-item"  href="{{ route('generar-excel-cartera-servicio',[$var->id,$centro->id] ) }}" role="menuitem"><i class="icon md-edit" aria-hidden="true"></i> Generar Excel</a>
						                        <a class="dropdown-item" href="{{URL::action('EspecialidadController@edit',$var->id)}}" role="menuitem"><i class="icon md-edit" aria-hidden="true"></i> Editar</a>
						                        <a class="dropdown-item" href="{{URL::action('EspecialidadController@edit',$var->id)}}" role="menuitem"><i class="icon md-edit" aria-hidden="true"></i> Editar</a>
						                        <a class="dropdown-item" href="" data-target="#modal-delete-{{$var->id}}" data-toggle="modal" class="btn btn-danger" data-placement="top" data-original-title="Remove"><i class="icon md-delete" aria-hidden="true"></i> Eliminar</a>
						                      </div>
						                    </div> -->
					              		</td>
					            	</tr>
					            	
				            	@endforeach
				          	</tbody>
				        </table>
			      	</div>
			      	<div>
				      	{{ $cartera_servicios->links('admCentros.custom') }}
				      	@if(Auth::user()->id_centro_medico == $centro->id || Auth::user()->tipo == 'Administrador' )
							<div class="site-action" data-plugin="actionBtn">
								<a href="{{ route('create-cartera-servicio', $centro->id) }}">
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