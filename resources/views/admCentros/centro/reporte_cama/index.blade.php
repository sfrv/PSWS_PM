@extends('layouts.admin')
@section('contenido')
<div class="panel">
	<div class="panel-body container-fluid">
		<div class="row row-lg">
			<div class="col-lg-12">
			    <div class="example-wrap">
			      	@include('admCentros.centro.reporte_cama.search')
			      	<div class="example table-responsive">
				        <table class="table table-striped">
				          	<thead>
				            	<tr>
					              	<th>Estado</th>
					              	<th>Titulo</th>
					              	<th>Fecha</th>
					              	<th class="text-center">Opciones</th>
				            	</tr>
				          	</thead>
				          	<tbody>
				          		@foreach($reporte_camas as $var)
					            	<tr>
					              		@if($var->estado == 1)
					                      <td><span class="badge badge-pill badge-success float-left">Activo</span></td>
					                    @else
					                      <td><span class="badge badge-pill badge-danger float-left">Inactivo</span></td>
					                    @endif
					              		<td>{{ $var->titulo }}</td>
						              	<td>{{ $var->fecha }}</td>
					              		<td class="text-center">
					              			<a href="{{ route('edit-reporte-cama', [$var->id,$centro->id]) }}" class="panel-action icon md-edit ml-15" data-toggle="tooltip" data-original-title="Editar" data-container="body" title=""></a>
                            				<i class="icon md-delete ml-15" aria-hidden="true"
                            				data-toggle="tooltip" data-original-title="help" data-container="body"
                            				title=""></i>
                            				<a href="{{ route('show-reporte-cama',[$var->id,$centro->id]) }}" class="panel-action icon md-eye ml-15" data-toggle="tooltip" data-original-title="Ver Mas" data-container="body" title=""></a>
                            				<a href="{{ route('generar-excel-reporte-cama',[$var->id,$centro->id] ) }}" class="panel-action icon md-download ml-15" data-toggle="tooltip" data-original-title="Generar Excel" data-container="body" title=""></a>
					              		</td>
					            	</tr>
					            	
				            	@endforeach
				          	</tbody>
				        </table>
			      	</div>
			      	<div>
				      	{{ $reporte_camas->links('admCentros.custom') }}
						<div class="site-action" data-plugin="actionBtn">
							<a href="{{ route('create-reporte-cama', $centro->id) }}">
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