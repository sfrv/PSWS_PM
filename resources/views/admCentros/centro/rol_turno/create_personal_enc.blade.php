@extends('layouts.admin')
@section('contenido')
<div class="panel">
	<div class="panel-body container-fluid">
		<div class="row row-lg">
			<div class="col-lg-12">
			    <div class="example-wrap">
			      	<h4>Rol de Turno - Personal Encargado</h4>
			      	<br>
			      	{!! Form::open(array('route'=>['store-rol-turno-personal-encargado',$id_centro,$id_rol_turno],'method'=>'POST','autocomplete'=>'off'))!!}
        			{{Form::token()}}
		              	<div>
		              		<div class="panel-heading">
			              		<div class="row">
				              		<div class="col-lg-11 col-md-11 col-dm-11 col-xs-10">
				              			<h4>
				              				Personal Encargado
				              			</h4>
				              		</div>
				              		<div>
				              			<button type="button" class="btn btn-icon btn-primary" onclick="agregarFilaPersonal();"><i class="icon md-plus"></i></button>
				              		</div>
			              		</div>
			              	</div>
		      			  	<div class="example table-responsive">
		      			  		<div id="table-scroll" class="table-scroll">
          							<div class="table-wrap">
					          			<table class="table table-striped" id="table_personal">
					          				
					          			</table>
					          		</div>
					          	</div>
		      				</div>
		              	</div>
		              	
		              	<div class="col-sm-8 col-sm-offset-2" id="guardar">
		              		<button type="submit" class="btn btn-primary btn-block btn-round" data-style="slide-right" data-plugin="ladda">
		              			<span class="ladda-label">Registrar Etapa Personal Enc.<i class="icon md-long-arrow-right ml-10" aria-hidden="true"></i></span>
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
var contp = 0;
var conth = 0;
var cont = 0;

var datos = [];
var filas = [];
var datos_filas = [];

function agregarFilaPersonal() {
	var fila_personal = '<thead style="background-color:#A9D0F5" id="fila_datos_head'+contp+'">'+
			'<tr>'+
				'<th class="text-center" scope="col">'+
					'<input style="width:150px;" placeholder="Nombre de Cargo..." class="autosize form-control" name="text_personal'+contp+'" type="text">'+
					'<input type="hidden" name="idpersonal[]" value="'+contp+'">'+
				'</th>'+
				'<th class="text-center" scope="col">Turno</th>'+
				'<th class="text-center" scope="col">Lunes</th>'+
				'<th class="text-center" scope="col">Martes</th>'+
				'<th class="text-center" scope="col">Miercoles</th>'+
				'<th class="text-center" scope="col">Jueves</th>'+
				'<th class="text-center" scope="col">Viernes</th>'+
				'<th class="text-center" scope="col">Sabado</th>'+
				'<th class="text-center" scope="col">Domingo</th>'+
				'<th class="text-center" scope="col">Observacion</th>'+
				'<th class="text-center" scope="col">Op1</th>'+
				'<th class="text-center" scope="col"><button type="button" class="btn btn-icon btn-primary" onclick="agregarFilaHora('+contp+');"><i class="icon md-plus"></i></button> <button type="button" class="btn btn-icon btn-danger" onclick="eliminarFilaPersonal('+contp+');"><i class="icon md-close"></i></button></th>'+
			'</tr>'+
		'</thead>'+
		'<tbody id="fila_datos_body'+contp+'">'+
		'</tbody>';
	contp++;
	$('#table_personal').append(fila_personal);
}

function agregarFilaHora(id) {//id cargo
	var fila_hora ='<tr id="fila_h'+conth+'">'+
		'<td class="text-center" id="arrays'+conth+'">'+
			'<input type="hidden" name="idturnos'+id+'[]" value="'+conth+'">'+
		'-</td>'+
		'<td class="text-center">'+
			'<input style="width:110px;" placeholder="Titulo..." class="autosize form-control" name="text_turno'+conth+'" type="text">'+
			'<input style="width:110px;" placeholder="Hora Inicio..." class="autosize form-control" name="text_hora_inicio'+conth+'" type="text">'+
			'<input style="width:110px;" placeholder="Hora Fin..." class="autosize form-control" name="text_hora_fin'+conth+'" type="text">'+
		'</td>'+
		'<td class="text-center" id="lunes'+conth+'"></td>'+ //lunes
		'<td class="text-center" id="martes'+conth+'"></td>'+ //martes
		'<td class="text-center" id="miercoles'+conth+'"></td>'+ //miercoles
		'<td class="text-center" id="jueves'+conth+'"></td>'+ //jueves
		'<td class="text-center" id="viernes'+conth+'"></td>'+ //viernes
		'<td class="text-center" id="sabado'+conth+'"></td>'+ //sabado
		'<td class="text-center" id="domingo'+conth+'"></td>'+ //domingo
		'<td class="text-center" id="observacion'+conth+'"></td>'+ //observacion
		'<td class="text-center" id="opcion'+conth+'"></td>'+
		'<td class="text-center"> <button type="button" class="btn btn-icon btn-primary" onclick="agregarFila('+id+','+conth+');"><i class="icon md-plus"></i></button> <button type="button" class="btn btn-icon btn-danger" onclick="eliminarFilaHora('+conth+');"><i class="icon md-close"></i></button> </td>'+
		'</tr>';
	conth++;
	$('#fila_datos_body'+id).append(fila_hora);
}
// id="fila_dias_turno_'+conth_l+'_'+cont+'"
function agregarFila(id_l,conth_l) {
	var my_array = '<div id="fila_d_arr'+cont+'"><input type="hidden" name="id_filas_turno'+conth_l+'[]" value="'+cont+'"></div>';
	var fila_lunes = '<div id="fila_d_l'+cont+'" style="padding-bottom: 10px;">'+
		'<select style="width:155px;" name="selec_dia_lunes'+cont+'" class="form-control selectpicker">'+
			'<option value="-1">Ninguno</option>'+
			'@foreach($medicos as $var)'+
				'<option value="{{$var->id}}">{{$var->apellido}} {{$var->telefono}}</option>'+
			'@endforeach'+
		'</select></div>';
	var fila_martes = '<div id="fila_d_m'+cont+'" style="padding-bottom: 10px;">'+
		'<select style="width:155px;" name="selec_dia_martes'+cont+'" class="form-control selectpicker">'+
			'<option value="-1">Ninguno</option>'+
			'@foreach($medicos as $var)'+
				'<option value="{{$var->id}}">{{$var->apellido}} {{$var->telefono}}</option>'+
			'@endforeach'+
		'</select></div>';
	var fila_miercoles = '<div id="fila_d_mi'+cont+'" style="padding-bottom: 10px;">'+
		'<select style="width:155px;" name="selec_dia_miercoles'+cont+'" class="form-control selectpicker">'+
			'<option value="-1">Ninguno</option>'+
			'@foreach($medicos as $var)'+
				'<option value="{{$var->id}}">{{$var->apellido}} {{$var->telefono}}</option>'+
			'@endforeach'+
		'</select></div>';
	var fila_jueves = '<div id="fila_d_j'+cont+'" style="padding-bottom: 10px;">'+
		'<select style="width:155px;" name="selec_dia_jueves'+cont+'" class="form-control selectpicker">'+
			'<option value="-1">Ninguno</option>'+
			'@foreach($medicos as $var)'+
				'<option value="{{$var->id}}">{{$var->apellido}} {{$var->telefono}}</option>'+
			'@endforeach'+
		'</select></div>';
	var fila_viernes = '<div id="fila_d_v'+cont+'" style="padding-bottom: 10px;">'+
		'<select style="width:155px;" name="selec_dia_viernes'+cont+'" class="form-control selectpicker">'+
			'<option value="-1">Ninguno</option>'+
			'@foreach($medicos as $var)'+
				'<option value="{{$var->id}}">{{$var->apellido}} {{$var->telefono}}</option>'+
			'@endforeach'+
		'</select></div>';
	var fila_sabado = '<div id="fila_d_s'+cont+'" style="padding-bottom: 10px;">'+
		'<select style="width:155px;" name="selec_dia_sabado'+cont+'" class="form-control selectpicker">'+
			'<option value="-1">Ninguno</option>'+
			'@foreach($medicos as $var)'+
				'<option value="{{$var->id}}">{{$var->apellido}} {{$var->telefono}}</option>'+
			'@endforeach'+
		'</select></div>';
	var fila_domingo = '<div id="fila_d_d'+cont+'" style="padding-bottom: 10px;">'+
		'<select style="width:155px;" name="selec_dia_domingo'+cont+'" class="form-control selectpicker">'+
			'<option value="-1">Ninguno</option>'+
			'@foreach($medicos as $var)'+
				'<option value="{{$var->id}}">{{$var->apellido}} {{$var->telefono}}</option>'+
			'@endforeach'+
		'</select></div>';
	var fila_observacion = '<div id="fila_observacion'+cont+'" style="padding-bottom: 10px;">'+
		'<input style="width:200px;" placeholder="OBSERVACION..." class="autosize form-control" name="text_observacion'+cont+'" type="text">'+
		'</div>';
	var fila_opcion = '<div style="margin-bottom: 8px;" id="fila_op'+cont+'"><button type="button" class="btn btn-icon btn-danger" onclick="eliminarFila('+cont+','+conth+');"><i class="icon md-close"></i></button></div>';
	cont++;
	$('#arrays'+conth_l).append(my_array);
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

function eliminarFila(cont_l,conth_l) {
	$('#fila_d_arr'+cont_l).remove();
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

function eliminarFilaHora(conth_l)
{
	$('#fila_h'+conth_l).remove();
}

function eliminarFilaPersonal(contp_l)
{
	$('#fila_datos_body'+contp_l).remove();
	$('#fila_datos_head'+contp_l).remove();
}

</script>
@endpush
@include('admCentros.alertas.logrado')
@endsection