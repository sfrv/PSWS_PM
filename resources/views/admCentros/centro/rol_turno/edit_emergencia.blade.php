@extends('layouts.admin')
@section('contenido')
<div class="panel">
	<div class="panel-body container-fluid">
		<div class="row row-lg">
			<div class="col-lg-12">
			    <div class="example-wrap">
			      	<h4>Editar Rol de Turno - Etapa Emeguencia</h4>
			      	<br>
			      	{!! Form::model($id_rol_turno,['method'=>'PATCH','autocomplete'=>'off','route'=>['update-rol-turno-emergencia',$id_rol_turno,$id_centro]])!!}
					{{Form::token()}} 
		              	<div>
		              		<h4>Etapa Emergencia</h4>
		      			  	<div class="example table-responsive">
		      			  		<div id="table-scroll" class="table-scroll">
          							<div class="table-wrap">
					          			<table class="table table-striped">
					          				@foreach($especialidades_etapa_emergencia as $var)
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
							          				<th class="text-center" scope="col">Op1</th>
							          				<th class="text-center" scope="col"><button type="button" class="btn btn-icon btn-primary" onclick="agregarFilaHora({{$var -> id}});"><i class="icon md-plus"></i></button></th>
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
		              	
		              	<div class="col-sm-8 col-sm-offset-2" id="guardar">
		              		<button type="submit" class="btn btn-primary btn-block btn-round" data-style="slide-right" data-plugin="ladda">
		              			<span class="ladda-label">Editar Etapa<i class="icon md-long-arrow-right ml-10" aria-hidden="true"></i></span>
		              		</button>
		              	</div>
		            {!! Form::close() !!}
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
// console.log(rol_dias);
var medicos_j = {!! $medicos_json !!};
var array_auxa = [];
console.log(detalle_turnos);

for (var i = 0; i < turnos.length; i++) {
	var fila_hora ='<tr  class="text-center" id="fila_h'+conth+'">'+
			'<td id="dias'+conth+'">'+
				'<input type="hidden" name="id_turnos_actualizar[]" value="'+turnos[i]['id']+'">-'+
			'</td>'+
			'<td>'+
				'<input style="width:110px;" value="'+turnos[i]['nombre']+'" class="autosize form-control" name="text_turno_actualizar'+turnos[i]['id']+'" type="text">'+
				'<input style="width:110px;" class="autosize form-control" name="text_hora_inicio_actualizar'+turnos[i]['id']+'" type="text" value="'+turnos[i]['hora_inicio']+'">'+
				'<input style="width:110px;" value="'+turnos[i]['hora_fin']+'" class="autosize form-control" name="text_hora_fin_actualizar'+turnos[i]['id']+'" type="text">'+
			'</td>'+
			'<td id="lunes'+conth+'"></td>'+ //lunes
			'<td id="martes'+conth+'"></td>'+ //martes
			'<td id="miercoles'+conth+'"></td>'+ //miercoles
			'<td id="jueves'+conth+'"></td>'+ //jueves
			'<td id="viernes'+conth+'"></td>'+ //viernes
			'<td id="sabado'+conth+'"></td>'+ //sabado
			'<td id="domingo'+conth+'"></td>'+ //domingo
			'<td id="observacion'+conth+'"></td>'+ //observacion
			'<td id="opcion'+conth+'"></td>'+
			'<td>'+
				'<button type="button" class="btn btn-icon btn-primary" onclick="agregarFila('+turnos[i]['id_detalle_centro_especialidad']+','+conth+','+turnos[i]['id']+');"><i class="icon md-plus"></i></button> '+
				'<button type="button" class="btn btn-icon btn-danger" onclick="eliminarFilaHora('+conth+','+turnos[i]['id']+','+turnos[i]['id_detalle_centro_especialidad']+');"><i class="icon md-close"></i></button>'+
			'</td>'+
		'</tr>';
	$('#fila_datos'+turnos[i]['id_detalle_centro_especialidad']).append(fila_hora);

	var c = 0;
	while ( c < rol_dias.length ){
		// var array_dias_id_anterior = [];
		if (turnos[i]['id'] == rol_dias[c]['id_turno']) {
			//0 1 2 3 4 5 6
			// console.log(c);
			var my_array = '<div id="fila_dias'+cont+'">'+
				'<input type="hidden" name="observaciones_actualizar[]" value="'+detalle_turnos[(c / 7)]['id']+'">'+
		 		'<input type="hidden" name="id_rol_dias_actualizar[]" value="'+rol_dias[c]['id']+'">'+
		 		'<input type="hidden" name="id_rol_dias_actualizar[]" value="'+rol_dias[c+1]['id']+'">'+
		 		'<input type="hidden" name="id_rol_dias_actualizar[]" value="'+rol_dias[c+2]['id']+'">'+
		 		'<input type="hidden" name="id_rol_dias_actualizar[]" value="'+rol_dias[c+3]['id']+'">'+
		 		'<input type="hidden" name="id_rol_dias_actualizar[]" value="'+rol_dias[c+4]['id']+'">'+
		 		'<input type="hidden" name="id_rol_dias_actualizar[]" value="'+rol_dias[c+5]['id']+'">'+
		 		'<input type="hidden" name="id_rol_dias_actualizar[]" value="'+rol_dias[c+6]['id']+'">'+
		 	'</div>';
		  	$('#dias'+conth).append(my_array);

			var fila_lunes = '<div id="fila_d_l'+cont+'" style="padding-bottom: 10px;">'+
					'<select style="width:155px;" name="select_dia_lunes_actualizar_'+rol_dias[c]['id']+'" class="form-control selectpicker">'+
					'<option value="-1" selected >Ninguno</option>';
					for (var j = 0; j < medicos_j.length; j++) {
						if (medicos_j[j]['id'] == rol_dias[c]['id_medico']) {
							fila_lunes = fila_lunes + '<option value="'+medicos_j[j]['id']+'" selected>'+medicos_j[j]['apellido']+' ' + medicos_j[j]['telefono'] +'</option>';
						}else{
							fila_lunes = fila_lunes + '<option value="'+medicos_j[j]['id']+'">'+medicos_j[j]['apellido']+' ' + medicos_j[j]['telefono'] +'</option>';
						}
					}
			fila_lunes = fila_lunes + '</select></div>';
			var array_auxb = [];
			array_auxb.push(rol_dias[c]['id'],turnos[i]['id'],cont);//new
			array_auxa.push(array_auxb);
			c++;
			var fila_martes = '<div id="fila_d_m'+cont+'" style="padding-bottom: 10px;">'+
					'<select style="width:155px;"name="select_dia_martes_actualizar_'+rol_dias[c]['id']+'" class="form-control selectpicker">'+
					'<option value="-1" selected >Ninguno</option>';
					for (var j = 0; j < medicos_j.length; j++) {
						if (medicos_j[j]['id'] == rol_dias[c]['id_medico']) {
							fila_martes = fila_martes + '<option value="'+medicos_j[j]['id']+'" selected>'+medicos_j[j]['apellido']+' ' + medicos_j[j]['telefono'] +'</option>';
						}else{
							fila_martes = fila_martes + '<option value="'+medicos_j[j]['id']+'">'+medicos_j[j]['apellido']+' ' + medicos_j[j]['telefono'] +'</option>';
						}
					}
			fila_martes = fila_martes + '</select></div>';
			var array_auxb = [];
			array_auxb.push(rol_dias[c]['id'],turnos[i]['id'],cont);//new
			array_auxa.push(array_auxb);
			c++;
			var fila_miercoles = '<div id="fila_d_mi'+cont+'" style="padding-bottom: 10px;">'+
					'<select style="width:155px;" name="select_dia_miercoles_actualizar_'+rol_dias[c]['id']+'" class="form-control selectpicker">'+
					'<option value="-1" selected >Ninguno</option>';
					for (var j = 0; j < medicos_j.length; j++) {
						if (medicos_j[j]['id'] == rol_dias[c]['id_medico']) {
							fila_miercoles = fila_miercoles + '<option value="'+medicos_j[j]['id']+'" selected>'+medicos_j[j]['apellido']+' ' + medicos_j[j]['telefono'] +'</option>';
						}else{
							fila_miercoles = fila_miercoles + '<option value="'+medicos_j[j]['id']+'">'+medicos_j[j]['apellido']+' ' + medicos_j[j]['telefono'] +'</option>';
						}
					}
			fila_miercoles = fila_miercoles + '</select></div>';
			var array_auxb = [];
			array_auxb.push(rol_dias[c]['id'],turnos[i]['id'],cont);//new
			array_auxa.push(array_auxb);
			c++;
			var fila_jueves = '<div id="fila_d_j'+cont+'" style="padding-bottom: 10px;">'+
					'<select style="width:155px;" name="select_dia_jueves_actualizar_'+rol_dias[c]['id']+'" class="form-control selectpicker">'+
					'<option value="-1" selected >Ninguno</option>';
					for (var j = 0; j < medicos_j.length; j++) {
						if (medicos_j[j]['id'] == rol_dias[c]['id_medico']) {
							fila_jueves = fila_jueves + '<option value="'+medicos_j[j]['id']+'" selected>'+medicos_j[j]['apellido']+' ' + medicos_j[j]['telefono'] +'</option>';
						}else{
							fila_jueves = fila_jueves + '<option value="'+medicos_j[j]['id']+'">'+medicos_j[j]['apellido']+' ' + medicos_j[j]['telefono'] +'</option>';
						}
					}
			fila_jueves = fila_jueves + '</select></div>';
			var array_auxb = [];
			array_auxb.push(rol_dias[c]['id'],turnos[i]['id'],cont);//new
			array_auxa.push(array_auxb);
			c++;
			var fila_viernes = '<div id="fila_d_v'+cont+'" style="padding-bottom: 10px;">'+
					'<select style="width:155px;" name="select_dia_viernes_actualizar_'+rol_dias[c]['id']+'" class="form-control selectpicker">'+
					'<option value="-1" selected >Ninguno</option>';
					for (var j = 0; j < medicos_j.length; j++) {
						if (medicos_j[j]['id'] == rol_dias[c]['id_medico']) {
							fila_viernes = fila_viernes + '<option value="'+medicos_j[j]['id']+'" selected>'+medicos_j[j]['apellido']+' ' + medicos_j[j]['telefono'] +'</option>';
						}else{
							fila_viernes = fila_viernes + '<option value="'+medicos_j[j]['id']+'">'+medicos_j[j]['apellido']+' ' + medicos_j[j]['telefono'] +'</option>';
						}
					}
			fila_viernes = fila_viernes + '</select></div>';
			var array_auxb = [];
			array_auxb.push(rol_dias[c]['id'],turnos[i]['id'],cont);//new
			array_auxa.push(array_auxb);
			c++;
			var fila_sabado = '<div id="fila_d_s'+cont+'" style="padding-bottom: 10px;">'+
					'<select style="width:155px;" name="select_dia_sabado_actualizar_'+rol_dias[c]['id']+'" class="form-control selectpicker">'+
					'<option value="-1" selected >Ninguno</option>';
					for (var j = 0; j < medicos_j.length; j++) {
						if (medicos_j[j]['id'] == rol_dias[c]['id_medico']) {
							fila_sabado = fila_sabado + '<option value="'+medicos_j[j]['id']+'" selected>'+medicos_j[j]['apellido']+' ' + medicos_j[j]['telefono'] +'</option>';
						}else{
							fila_sabado = fila_sabado + '<option value="'+medicos_j[j]['id']+'">'+medicos_j[j]['apellido']+' ' + medicos_j[j]['telefono'] +'</option>';
						}
					}
			fila_sabado = fila_sabado + '</select></div>';
			var array_auxb = [];
			array_auxb.push(rol_dias[c]['id'],turnos[i]['id'],cont);//new
			array_auxa.push(array_auxb);
			c++;
			var fila_domingo = '<div id="fila_d_d'+cont+'" style="padding-bottom: 10px;">'+
					'<select style="width:155px;" name="select_dia_domingo_actualizar_'+rol_dias[c]['id']+'" class="form-control selectpicker">'+
					'<option value="-1" selected >Ninguno</option>';
					for (var j = 0; j < medicos_j.length; j++) {
						if (medicos_j[j]['id'] == rol_dias[c]['id_medico']) {
							fila_domingo = fila_domingo + '<option value="'+medicos_j[j]['id']+'" selected>'+medicos_j[j]['apellido']+' ' + medicos_j[j]['telefono'] +'</option>';
						}else{
							fila_domingo = fila_domingo + '<option value="'+medicos_j[j]['id']+'">'+medicos_j[j]['apellido']+' ' + medicos_j[j]['telefono'] +'</option>';
						}
					}
			fila_domingo = fila_domingo + '</select></div>';
			var array_auxb = [];
			array_auxb.push(rol_dias[c]['id'],turnos[i]['id'],cont);//new
			array_auxa.push(array_auxb);
			c++;

			var fila_observacion = '<div id="fila_observacion'+cont+'" style="padding-bottom: 10px;">'+
					'<input style="width:200px;" value="'+detalle_turnos[(c / 7)-1]['observacion']+'" class="autosize form-control" name="observacion_actualizar_'+detalle_turnos[(c / 7)-1]['id']+'" type="text">'+
				'</div>';
				// console.log(c);
			var fila_opcion = '<div style="margin-bottom: 8px;" id="fila_op'+cont+'"><button type="button" class="btn btn-icon btn-danger" onclick="eliminarFila('+cont+','+turnos[i]['id']+','+turnos[i]['id_detalle_centro_especialidad']+','+detalle_turnos[(c / 7)-1]['id']+');"><i class="icon md-close"></i></button><br></div>';

			cont++;

			$('#lunes'+conth).append(fila_lunes);
			$('#martes'+conth).append(fila_martes);
			$('#miercoles'+conth).append(fila_miercoles);
			$('#jueves'+conth).append(fila_jueves);
			$('#viernes'+conth).append(fila_viernes);
			$('#sabado'+conth).append(fila_sabado);
			$('#domingo'+conth).append(fila_domingo);
			$('#observacion'+conth).append(fila_observacion);
			$('#opcion'+conth).append(fila_opcion);
			// c = c + 7;
		}else{
			c++;
		}

	}
	conth++;
}
// console.log(array_auxa);

function agregarFila(id_especialidad_l,conth_l,id_turno_l) {
	// console.log(id_turno_l);
	if (id_turno_l == -1) {
		var my_array = '<div id="fila_d_arr'+cont+'"><input type="hidden" name="id_filas_turno'+conth_l+'[]" value="'+cont+'"></div>';
		// console.log("ss");
		$('#dias'+conth_l).append(my_array);
	}else{
		var my_array = '<div id="fila_d_arr'+cont+'"><input type="hidden" name="id_filas_nuevos_turno'+id_turno_l+'[]" value="'+cont+'"></div>';	
		$('#dias'+conth_l).append(my_array);
	}

	var fila_lunes = '<div id="fila_d_l'+cont+'" style="padding-bottom: 10px;">'+
		'<select style="width:155px;" name="selec_dia_lunes_nuevo'+cont+'" class="form-control selectpicker">'+
			'<option value="-1">Ninguno</option>'+
			'@foreach($medicos as $var)'+
				'<option value="{{$var->id}}">{{$var->apellido}} {{$var->telefono}}</option>'+
			'@endforeach'+
		'</select></div>';
	var fila_martes = '<div id="fila_d_m'+cont+'" style="padding-bottom: 10px;">'+
	'<select style="width:155px;" name="selec_dia_martes_nuevo'+cont+'" class="form-control selectpicker">'+
		'<option value="-1">Ninguno</option>'+
		'@foreach($medicos as $var)'+
			'<option value="{{$var->id}}">{{$var->apellido}} {{$var->telefono}}</option>'+
		'@endforeach'+
	'</select></div>';
	var fila_miercoles = '<div id="fila_d_mi'+cont+'" style="padding-bottom: 10px;">'+
	'<select style="width:155px;" name="selec_dia_miercoles_nuevo'+cont+'" class="form-control selectpicker">'+
		'<option value="-1">Ninguno</option>'+
		'@foreach($medicos as $var)'+
			'<option value="{{$var->id}}">{{$var->apellido}} {{$var->telefono}}</option>'+
		'@endforeach'+
	'</select></div>';
	var fila_jueves = '<div id="fila_d_j'+cont+'" style="padding-bottom: 10px;">'+
	'<select style="width:155px;" name="selec_dia_jueves_nuevo'+cont+'" class="form-control selectpicker">'+
		'<option value="-1">Ninguno</option>'+
		'@foreach($medicos as $var)'+
			'<option value="{{$var->id}}">{{$var->apellido}} {{$var->telefono}}</option>'+
		'@endforeach'+
	'</select></div>';
	var fila_viernes = '<div id="fila_d_v'+cont+'" style="padding-bottom: 10px;">'+
	'<select style="width:155px;" name="selec_dia_viernes_nuevo'+cont+'" class="form-control selectpicker">'+
		'<option value="-1">Ninguno</option>'+
		'@foreach($medicos as $var)'+
			'<option value="{{$var->id}}">{{$var->apellido}} {{$var->telefono}}</option>'+
		'@endforeach'+
	'</select></div>';
	var fila_sabado = '<div id="fila_d_s'+cont+'" style="padding-bottom: 10px;">'+
	'<select style="width:155px;" name="selec_dia_sabado_nuevo'+cont+'" class="form-control selectpicker">'+
		'<option value="-1">Ninguno</option>'+
		'@foreach($medicos as $var)'+
			'<option value="{{$var->id}}">{{$var->apellido}} {{$var->telefono}}</option>'+
		'@endforeach'+
	'</select></div>';
	var fila_domingo = '<div id="fila_d_d'+cont+'" style="padding-bottom: 10px;">'+
	'<select style="width:155px;" name="selec_dia_domingo_nuevo'+cont+'" class="form-control selectpicker">'+
		'<option value="-1">Ninguno</option>'+
		'@foreach($medicos as $var)'+
			'<option value="{{$var->id}}">{{$var->apellido}} {{$var->telefono}}</option>'+
		'@endforeach'+
	'</select></div>';

	var fila_observacion = '<div id="fila_observacion'+cont+'" style="padding-bottom: 10px;">'+
		'<input style="width:200px;" placeholder="OBSERVACION..." class="autosize form-control" name="text_observacion_nuevo'+cont+'" type="text">'+
		'</div>';

	var fila_opcion = '<div style="margin-bottom: 8px;" id="fila_op'+cont+'"><button type="button" class="btn btn btn-icon btn-danger" onclick="eliminarFila('+cont+');"><i class="icon md-close"></i></button><br></div>';
	
	cont++;
	
	$('#lunes'+conth_l).append(fila_lunes);
	$('#martes'+conth_l).append(fila_martes);
	$('#miercoles'+conth_l).append(fila_miercoles);
	$('#jueves'+conth_l).append(fila_jueves);
	$('#viernes'+conth_l).append(fila_viernes);
	$('#sabado'+conth_l).append(fila_sabado);
	$('#domingo'+conth_l).append(fila_domingo);
	$('#observacion'+conth_l).append(fila_observacion);
	$('#opcion'+conth_l).append(fila_opcion);
	
}

function agregarFilaHora(id) {//id especialidad
	// console.log(id);
	
	var fila_hora ='<tr id="fila_h'+conth+'">'+
		'<td id="dias'+conth+'">'+
			'<input type="hidden" name="id_turnos_nuevos[]" value="'+conth+'">-'+
			'<input type="hidden" name="idespecialidad[]" value="'+id+'">'+
		'</td>'+
		'<td>'+
			'<input style="width:110px;" placeholder="Titulo..." class="autosize form-control" name="text_turno'+conth+'" type="text">'+
			'<input style="width:110px;" placeholder="Hora Inicio..." class="autosize form-control" name="text_hora_inicio'+conth+'" type="text">'+
			'<input style="width:110px;" placeholder="Hora Fin..." class="autosize form-control" name="text_hora_fin'+conth+'" type="text">'+
		'</td>'+
		'<td id="lunes'+conth+'"></td>'+ //lunes
		'<td id="martes'+conth+'"></td>'+ //martes
		'<td id="miercoles'+conth+'"></td>'+ //miercoles
		'<td id="jueves'+conth+'"></td>'+ //jueves
		'<td id="viernes'+conth+'"></td>'+ //viernes
		'<td id="sabado'+conth+'"></td>'+ //sabado
		'<td id="domingo'+conth+'"></td>'+ //domingo
		'<td id="observacion'+conth+'"></td>'+ //observacion
		'<td id="opcion'+conth+'"></td>'+
		'<td>'+
			'<button type="button" class="btn btn-icon btn-primary" onclick="agregarFila('+id+','+conth+',-1'+');"><i class="icon md-plus"></i></button> '+
			'<button type="button" class="btn btn-icon btn-danger" onclick="eliminarFilaHora('+conth+',-1'+',-1'+');"><i class="icon md-close"></i></button> </td>'+
		'</tr>';
	conth++;
	$('#fila_datos'+id).append(fila_hora);
}

function eliminarFila(cont_l,id_turno_l,id_especialidad_l,id_detalle_turno_l) {

	var n_i = getIndDato(cont_l,array_auxa,2);
	while( n_i != -1 ){
		var fila='<tr hidden>'+
	      '<td><input type="hidden" name="id_rol_dias_delete[]" value="'+array_auxa[n_i][0]+'"></td>'+
	    '</tr>';
	  	$('#fila_datos'+id_especialidad_l).append(fila);
	  	array_auxa.splice(n_i,1);
		n_i = getIndDato(cont_l,array_auxa,2);
	}
	
	var fila='<tr hidden>'+
	      '<td><input type="hidden" name="id_detalle_turno_delete[]" value="'+id_detalle_turno_l+'"></td>'+
	    '</tr>';
	  	$('#fila_datos'+id_especialidad_l).append(fila);
	console.log(array_auxa);

	$('#fila_d_l'+cont_l).remove();
	$('#fila_d_m'+cont_l).remove();
	$('#fila_d_mi'+cont_l).remove();
	$('#fila_d_j'+cont_l).remove();
	$('#fila_d_v'+cont_l).remove();
	$('#fila_d_s'+cont_l).remove();
	$('#fila_d_d'+cont_l).remove();
	$('#fila_observacion'+cont_l).remove();
	$('#fila_op'+cont_l).remove();

}

function eliminarFilaHora(conth_l,id_turno_l,id_especialidad_l)
{
	
	if (id_turno_l == -1 && id_especialidad_l == -1) {
		$('#fila_h'+conth_l).remove();
		return
	}

	// var n_i = getIndDato(id_turno_l,array_auxa,1);
	// while( n_i != -1 ){
	// 	var fila='<tr hidden>'+
	//       '<td><input type="hidden" name="id_rol_dias_delete[]" value="'+array_auxa[n_i][0]+'"></td>'+
	//     '</tr>';
	//   	$('#fila_datos'+id_especialidad_l).append(fila);
	//   	array_auxa.splice(n_i,1);
	// 	n_i = getIndDato(id_turno_l,array_auxa,1);
	// }
	// console.log(array_auxa);

	var fila='<tr hidden>'+
      '<td><input type="hidden" name="id_turnos_delete[]" value="'+id_turno_l+'"></td>'+
    '</tr>';
  	$('#fila_datos'+id_especialidad_l).append(fila);

  	$('#fila_h'+conth_l).remove();
}


function getIndDato(ind, array_l, indr) {
  var c = 0;
  for (var i = 0; i < array_l.length; i++) {
    if (array_l[i][indr] == ind) {
      return c;
    }
    c++;
  }
  return -1;
}

</script>
@endpush
@endsection