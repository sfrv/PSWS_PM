@extends('layouts.admin')
@section('contenido')
<div class="panel">
	<div class="panel-body container-fluid">
		<div class="row row-lg">
			<div class="col-lg-12">
			    <div class="example-wrap">
			      	<h4>Cartera de Servicio {{$cartera_servicio->mes}} / {{$cartera_servicio->anio}}</h4>
			      	<br>
	              	<div class="row">
	              		<div class="col-lg-4 col-xs-12">
	                  		<div class="form-group form-material floating" data-plugin="formMaterial">
			                	<input disabled required type="text" class="form-control" value="{{$cartera_servicio->titulo}}"/>
			                    <label class="floating-label">Titulo</label>
			                </div>
		              	</div>
		              	<div class="col-lg-4 col-xs-12">
	                  		<div class="form-group form-material floating" data-plugin="formMaterial">
			                	<input disabled required type="text" class="form-control" value="{{$cartera_servicio->mes}}"/>
			                    <label class="floating-label">Mes</label>
			                </div>
		              	</div>
		              	<div class="col-lg-4 col-xs-12">
	                  		<div class="form-group form-material floating" data-plugin="formMaterial">
			                	<input disabled required type="text" class="form-control" value="{{$cartera_servicio->anio}}"/>
			                    <label class="floating-label">Anio</label>
			                </div>
		              	</div>
	              	</div>

	              	<div>
	              		<h4>Cartera de Servicio</h4>
	      			  	<div class="example table-responsive">
		          			<table id="detalles" class="table table-striped">
		          			<thead>
		      					<tr>
		      						<th class="text-center">Especialidad</th>
				                  	<th class="text-center">Servicios</th>
				                  	<th class="text-center">Dias</th>
				                  	<th class="text-center">Horas</th>
				                  	<th class="text-center">Observaciones</th>
		      					</tr>
		          			</thead>
		          			<tbody>
		          				@foreach($especialidades as $var)
			                      	<tr id="fila_datos{{$var -> id}}">
				                        <td class="text-center">{{$var -> nombre}} </td>
				                        <td class="text-center" id="especialidad_servicio{{$var -> id}}"></td>
				                        <td class="text-center" id="especialidad_dia{{$var -> id}}"></td>
				                        <td class="text-center" id="especialidad_hora{{$var -> id}}"></td>
				                        <td class="text-center" id="especialidad_observacion{{$var -> id}}"></td>
			                      	</tr>
			                  	@endforeach
			                </tbody>
		          			</table>
	      				</div>
	              	</div>
	              	
	              	<div class="col-sm-8 col-sm-offset-2" id="guardar">
	              		<a href="javascript:history.back(1)">
	              			<button type="submit" class="btn btn-primary btn-block btn-round" data-style="slide-right" data-plugin="ladda">
	              			<span class="ladda-label">Volver Atras<i class="icon md-long-arrow-right ml-10" aria-hidden="true"></i></span>
	              		</button>
	              		</a>
	              	</div>
			    </div>
			</div>
		</div>
	</div>
</div>
@push ('scripts')
<script>
var servicios = {!! $servicios_json !!};
setTimeout(clickb,1500);
function clickb() {
	var x = document.getElementById("mynav");
	if (x.className != "animsition site-menubar-hide site-menubar-unfold")
		x.className = "animsition site-menubar-fold";
}

for(i=0;i<servicios.length;i++){
	var fila_servicio = '<div style="padding-bottom: 7px;">'+
		'<input class="autosize form-control" disabled="true" type="text" value="'+servicios[i]['nombre']+'">'+
	'</div>';
	var fila_dia = '<div style="padding-bottom: 7px;">'+
		'<input class="autosize form-control" disabled="true" type="text" value="'+servicios[i]['dias']+'">'+
	'</div>';
	var fila_hora = '<div style="padding-bottom: 7px;">'+
		'<input class="autosize form-control" disabled="true" type="text" value="'+servicios[i]['hora']+'">'+
	'</div>';
	var fila_observacion = '<div style="padding-bottom: 7px;">'+
		'<input class="autosize form-control" disabled="true" type="text" value="'+servicios[i]['observacion']+'">'+
	'</div>';
	$('#especialidad_servicio'+servicios[i]['id_detalle_centro_especialidad']).append(fila_servicio);
	$('#especialidad_dia'+servicios[i]['id_detalle_centro_especialidad']).append(fila_dia);
	$('#especialidad_hora'+servicios[i]['id_detalle_centro_especialidad']).append(fila_hora);
	$('#especialidad_observacion'+servicios[i]['id_detalle_centro_especialidad']).append(fila_observacion);
}

</script>
@endpush
@endsection