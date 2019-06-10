@extends('layouts.admin')
@section('contenido')
<div class="panel">
	<div class="panel-body container-fluid">
		<div class="row row-lg">
			<div class="col-lg-12">
			    <div class="example-wrap">
			      	<div class="row">
			      		<div class="col-lg-9 col-xs-12">
			      			<h4>Vizualizar Rol de Turno - Consulta Externa</h4>
			      		</div>
			      		<div class="col-lg-3 col-xs-12">
			      			<ol class="breadcrumb">
						     	<li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
						     	<li><a href="{{url('adm/centro')}}">Centros</a></li>
						     	<li><a href="{{ route('index-rol-turno', $id_centro) }}">Index Rol de Turno</a></li>
						  	</ol>
			      		</div>
			      	</div>
			      	<br>
	              	<div>
	              		<h4>Consulta Externa</h4>
	      			  	<div class="example table-responsive">
	      			  		<div id="table-scroll" class="table-scroll">
      							<div class="table-wrap">
				          			<table class="table table-striped">
				          				@foreach($especialidades_etapa_consulta as $var)
	          							<thead style="background-color:#A9D0F5">
	          								<tr>
	          									<th class="text-center" scope="col">{{$var -> nombre}}</th>
						          				<th class="text-center" scope="col">Turno</th>
						          				<th class="text-center" scope="col">Lunes</th>
						          				<th class="text-center" scope="col">Martes</th>
						          				<th class="text-center" scope="col">Miercoles</th>
						          				<th class="text-center" scope="col">Jueves</th>
						          				<th class="text-center" scope="col">Viernes</th>
						          				<th class="text-center" scope="col">Sabado</th>
						          				<th class="text-center" scope="col">Domingo</th>
						          				<th class="text-center" scope="col">Observacion</th>
	          								</tr>
	          							</thead>
	          							
	          							<tbody id="fila_datos{{$var -> id}}">
	          								
	          							</tbody>
	          							@endforeach
				          			</table>
				          		</div>
				          	</div>
	      				</div>
	              	</div>
	              	
	              	<div class="col-sm-8 col-sm-offset-2">
	              		<a href="{{url('adm/centro/show_rol_turno/'.$rol_turno->id.'/'.$id_centro)}}">
		              		<button class="btn btn-primary btn-block btn-round" data-style="slide-left" data-plugin="ladda">
		              			<span class="ladda-label"><i class="icon md-long-arrow-left ml-10" aria-hidden="true"></i> Atras</span>
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
window.parent.document.body.style.zoom="70%";//solo para chrome
document.getElementById("mynav").style.zoom = "70%";

setTimeout(clickb,1500);
function clickb() {
	var obj=document.getElementById('linkmn');
	obj.click();
}

var conth = 0;
var cont = 0;
var turnos = {!! $turnos_json !!};
var detalle_turnos = {!! $detalle_turnos_json !!};
var rol_dias = {!! $rol_dias_json !!};
var medicos_j = {!! $medicos_json !!};
var array_auxa = [];

for (var i = 0; i < turnos.length; i++) {
	var fila_hora ='<tr  class="text-center" id="fila_h'+conth+'">'+
			'<td id="dias'+conth+'">'+
			'</td>'+
			'<td>'+
				'<input style="width:110px;" value="'+turnos[i]['nombre']+'" class="autosize form-control" disabled type="text">'+
				'<input style="width:110px;" class="autosize form-control" disabled type="text" value="'+turnos[i]['hora_inicio']+'">'+
				'<input style="width:110px;" value="'+turnos[i]['hora_fin']+'" class="autosize form-control" disabled type="text">'+
			'</td>'+
			'<td id="lunes'+conth+'"></td>'+ //lunes
			'<td id="martes'+conth+'"></td>'+ //martes
			'<td id="miercoles'+conth+'"></td>'+ //miercoles
			'<td id="jueves'+conth+'"></td>'+ //jueves
			'<td id="viernes'+conth+'"></td>'+ //viernes
			'<td id="sabado'+conth+'"></td>'+ //sabado
			'<td id="domingo'+conth+'"></td>'+ //domingo
			'<td id="observacion'+conth+'"></td>'+ //observacion
		'</tr>';
	$('#fila_datos'+turnos[i]['id_detalle_centro_especialidad']).append(fila_hora);

	var c = 0;
	while ( c < rol_dias.length ){
		if (turnos[i]['id'] == rol_dias[c]['id_turno']) {
			var fila_lunes = '<div id="fila_d_l'+cont+'" style="padding-bottom: 10px;">'+
					'<select style="width:155px;" class="form-control selectpicker">'+
					'<option value="-1" selected >Ninguno</option>';
					for (var j = 0; j < medicos_j.length; j++) {
						if (medicos_j[j]['id'] == rol_dias[c]['id_medico']) {
							fila_lunes = fila_lunes + '<option value="'+medicos_j[j]['id']+'" selected>'+medicos_j[j]['apellido']+' ' + medicos_j[j]['telefono'] +'</option>';
						}
					}
			fila_lunes = fila_lunes + '</select></div>';
			c++;
			var fila_martes = '<div id="fila_d_m'+cont+'" style="padding-bottom: 10px;">'+
					'<select style="width:155px;" class="form-control selectpicker">'+
					'<option value="-1" selected >Ninguno</option>';
					for (var j = 0; j < medicos_j.length; j++) {
						if (medicos_j[j]['id'] == rol_dias[c]['id_medico']) {
							fila_martes = fila_martes + '<option value="'+medicos_j[j]['id']+'" selected>'+medicos_j[j]['apellido']+' ' + medicos_j[j]['telefono'] +'</option>';
						}
					}
			fila_martes = fila_martes + '</select></div>';
			c++;
			var fila_miercoles = '<div id="fila_d_mi'+cont+'" style="padding-bottom: 10px;">'+
					'<select style="width:155px;" class="form-control selectpicker">'+
					'<option value="-1" selected >Ninguno</option>';
					for (var j = 0; j < medicos_j.length; j++) {
						if (medicos_j[j]['id'] == rol_dias[c]['id_medico']) {
							fila_miercoles = fila_miercoles + '<option value="'+medicos_j[j]['id']+'" selected>'+medicos_j[j]['apellido']+' ' + medicos_j[j]['telefono'] +'</option>';
						}
					}
			fila_miercoles = fila_miercoles + '</select></div>';
			c++;
			var fila_jueves = '<div id="fila_d_j'+cont+'" style="padding-bottom: 10px;">'+
					'<select style="width:155px;" class="form-control selectpicker">'+
					'<option value="-1" selected >Ninguno</option>';
					for (var j = 0; j < medicos_j.length; j++) {
						if (medicos_j[j]['id'] == rol_dias[c]['id_medico']) {
							fila_jueves = fila_jueves + '<option value="'+medicos_j[j]['id']+'" selected>'+medicos_j[j]['apellido']+' ' + medicos_j[j]['telefono'] +'</option>';
						}
					}
			fila_jueves = fila_jueves + '</select></div>';
			c++;
			var fila_viernes = '<div id="fila_d_v'+cont+'" style="padding-bottom: 10px;">'+
					'<select style="width:155px;" class="form-control selectpicker">'+
					'<option value="-1" selected >Ninguno</option>';
					for (var j = 0; j < medicos_j.length; j++) {
						if (medicos_j[j]['id'] == rol_dias[c]['id_medico']) {
							fila_viernes = fila_viernes + '<option value="'+medicos_j[j]['id']+'" selected>'+medicos_j[j]['apellido']+' ' + medicos_j[j]['telefono'] +'</option>';
						}
					}
			fila_viernes = fila_viernes + '</select></div>';
			c++;
			var fila_sabado = '<div id="fila_d_s'+cont+'" style="padding-bottom: 10px;">'+
					'<select style="width:155px;" class="form-control selectpicker">'+
					'<option value="-1" selected >Ninguno</option>';
					for (var j = 0; j < medicos_j.length; j++) {
						if (medicos_j[j]['id'] == rol_dias[c]['id_medico']) {
							fila_sabado = fila_sabado + '<option value="'+medicos_j[j]['id']+'" selected>'+medicos_j[j]['apellido']+' ' + medicos_j[j]['telefono'] +'</option>';
						}
					}
			fila_sabado = fila_sabado + '</select></div>';
			c++;
			var fila_domingo = '<div id="fila_d_d'+cont+'" style="padding-bottom: 10px;">'+
					'<select style="width:155px;" class="form-control selectpicker">'+
					'<option value="-1" selected >Ninguno</option>';
					for (var j = 0; j < medicos_j.length; j++) {
						if (medicos_j[j]['id'] == rol_dias[c]['id_medico']) {
							fila_domingo = fila_domingo + '<option value="'+medicos_j[j]['id']+'" selected>'+medicos_j[j]['apellido']+' ' + medicos_j[j]['telefono'] +'</option>';
						}
					}
			fila_domingo = fila_domingo + '</select></div>';
			c++;

			var fila_observacion = '<div id="fila_observacion'+cont+'" style="padding-bottom: 10px;">'+
					'<input disabled style="width:200px;" value="'+detalle_turnos[(c / 7)-1]['observacion']+'" class="autosize form-control" type="text">'+
				'</div>';
			cont++;

			$('#lunes'+conth).append(fila_lunes);
			$('#martes'+conth).append(fila_martes);
			$('#miercoles'+conth).append(fila_miercoles);
			$('#jueves'+conth).append(fila_jueves);
			$('#viernes'+conth).append(fila_viernes);
			$('#sabado'+conth).append(fila_sabado);
			$('#domingo'+conth).append(fila_domingo);
			$('#observacion'+conth).append(fila_observacion);
		}else{
			c++;
		}

	}
	conth++;
}


</script>
@endpush
@endsection