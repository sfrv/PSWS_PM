@extends('layouts.admin')
@section('contenido')
<div class="panel">
	<div class="panel-body container-fluid">
		<div class="row row-lg">
			<div class="col-lg-12">
			    <div class="example-wrap">
			    	<h4>Previlegios Registrados</h4>
			    	<br>
			      	@include('admCentros.previlegio.search')
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
						              			<a href="{{URL::action('PrevilegioController@edit',$var->id)}}" class="panel-action icon md-edit ml-15" data-toggle="tooltip" data-original-title="Editar" data-container="body" title=""></a>
						              		</td>
						                @endif
					            	</tr>
					            	@include('admCentros.previlegio.modal')
				            	@endforeach
				          	</tbody>
				        </table>
			      	</div>
			      	<div>
				      	{{ $usuarios->links('admCentros.custom') }}
			      	</div>
			    </div>
			</div>
		</div>
	</div>
</div>
@include('admCentros.alertas.logrado')	
@endsection
