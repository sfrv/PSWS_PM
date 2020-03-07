@extends('layouts.admin')
@section('contenido')
<div class="panel">
	<div class="panel-body container-fluid">
		<div class="row row-lg">
			<div class="col-lg-12">
			    <div class="example-wrap">
			      	<div class="row">
			      		<div class="col-lg-10 col-xs-12">
			      			<h4>Editar Medicos del Centro Medico: {{$centro->nombre}}</h4>	
			      		</div>
			      		<div class="col-lg-2 col-xs-12">
			      			<ol class="breadcrumb">
						     	<li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
						     	<li><a href="{{url('adm/centro')}}">index</a></li>
						  	</ol>
			      		</div>
			      	</div>
			      	<div class="row">
		                <div class="col-lg-9 col-md-9 col-dm-9 col-xs-9">
		                  <div>
		                    <label>Medicos Disponibles: </label>
		                    <select name="pidmedico" id="pidmedico" class="form-control">
		                        @foreach($medicos as $var)
		                          <option value="{{$var -> id}}_{{$var -> nombre}}_{{$var -> apellido}}_{{$var -> telefono}}">{{$var -> nombre}} {{$var -> apellido}} {{$var -> telefono}}</option>
		                        @endforeach
		                    </select>
		                  </div>
		                </div>
		                <div class="col-lg-3 col-md-3 col-dm-3 col-xs-3">
		                  <label>Opcion </label>
		                  <div>
		                    <button class="btn btn-primary" type="button"  id="bt_add_e" >Agregar</button>
		                  </div>
		                </div>
		            </div>
			      	<br>
			      	{!! Form::model($centro,['method'=>'PATCH','route'=>['update-medicos',$centro->id]])!!}
            		{{Form::token()}}
					<h4>Medicos Registrados</h4>
      			  	<div class="example table-responsive">
	          			<table id="detalles" class="table table-striped">
	          			<thead>
	      					<tr>
	      						<th class="text-center">Opciones</th>
	      						<th class="text-center">Nombre</th>
			                  	<th class="text-center">Apellido</th>
			                  	<th class="text-center">Telefono</th>
			                  	<th >Estado</th>
	      					</tr>
	          			</thead>
	          			<tbody>
		                 	@foreach($detalle_medicos as $var)
		                      	<tr class="text-center">
		                          	<td>
	                          		@if($var -> estado == 1)
		                        		<button id="btn_el_{{$var -> id}}" type="button" class="btn btn-icon btn-danger" onclick="eliminar_esp({{$var -> id_medico}},{{$var -> id}});"><i class="icon md-close" aria-hidden="true"></i></button>
	                          			<button disabled id="btn_hab_{{$var -> id}}" type="button" class="btn btn-icon btn-primary" onclick="hab_esp({{$var -> id_medico}},{{$var -> id}});"><i class="icon md-check" aria-hidden="true"></i></button>
		                        	@else
		                        		<button disabled id="btn_el_{{$var -> id}}" type="button" class="btn btn-icon btn-danger" onclick="eliminar_esp({{$var -> id_medico}},{{$var -> id}});"><i class="icon md-close" aria-hidden="true"></i></button>
	                          			<button id="btn_hab_{{$var -> id}}" type="button" class="btn btn-icon btn-primary" onclick="hab_esp({{$var -> id_medico}},{{$var -> id}});"><i class="icon md-check" aria-hidden="true"></i></button>
		                        	@endif
		                          	</td>
		                          	<td>{{$var -> nombre}}</td>
		                          	<td>{{$var -> apellido}}</td>
		                          	<td>{{$var -> telefono}}</td>
		                          	<td>
		                            	@if($var -> estado == 1)
		                              		<span id="{{$var -> id}}text" class="badge badge-pill badge-success float-left">Activo</span>
		                            	@else
		                              		<span id="{{$var -> id}}text" class="badge badge-pill badge-danger float-left">Inactivo</span>
		                            	@endif
		                          	</td>
		                      	</tr>
		                  	@endforeach
		                </tbody>
	          			</table>
      				</div>
      				<div class="col-sm-8 col-sm-offset-2" id="guardar">
	              		<button type="submit" class="btn btn-primary btn-block btn-round" data-style="slide-right" data-plugin="ladda">
	              			<span class="ladda-label">Editar Medicos<i class="icon md-long-arrow-right ml-10" aria-hidden="true"></i></span>
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
var cont=0;
var cant_especialidad_e = 0;
var array_medicos_id = [];
var array_medicos_id_habilitar = [];
var array_medicos_id_delete = [];
var array_valores_medicos = [];
var detalle_medicos_json = {!! $detalle_medicos !!};

for (var i = 0; i < detalle_medicos_json.length; i++) {
  $("#pidmedico option[value='"+detalle_medicos_json[i]['id_medico']+'_'+detalle_medicos_json[i]['nombre']+'_'+detalle_medicos_json[i]['apellido']+'_'+detalle_medicos_json[i]['telefono']+"']").remove();
  array_medicos_id.push( "" + detalle_medicos_json[i]['id_medico']);
}

function comenzar(){
  $('#bt_add_e').click(function(){
   agregar_e();
  });
}

function agregar_e()
{
	valor_medico = $("#pidmedico").val();
	if (valor_medico == "" || valor_medico == null){
	  alert("Error al Agregar Medico, Por Favor Seleccione un Medico.");
	  return;
	}
	datos_medico = valor_medico.split('_');
	id_medico = datos_medico[0]
	nombre_medico = datos_medico[1]
	apellido_medico = datos_medico[2]
	telefono_medico = datos_medico[3]

	if (nombre_medico == "" || apellido_medico == ""){
	  alert("Error al Agregar, Por Favor Selecione un Medico.");
	  return;
	}

	if (array_medicos_id.includes(id_medico)) {
	  alert("Error al Agregar, Medico Ya Agregado.");
	  return;
	}

	$("#pidmedico option[value='"+valor_medico+"']").remove();
	var aux_array = [];
	aux_array.push(cont,valor_medico);
	array_valores_medicos.push(aux_array);
	// console.log(array_valores_medicos);

  	array_medicos_id.push(id_medico);
  	var fila='<tr class="text-center" class="selected" id="fila'+cont+'">'+
      '<td><button type="button" class="btn btn-icon btn-danger" onclick="eliminar('+cont+','+id_medico+');"><i class="icon md-close"></i></button></td>'+
      '<td><input type="hidden" name="idmedicos[]" value="'+id_medico+'">'+nombre_medico+'</td>'+
      '<td>'+apellido_medico+'</td>'+
      '<td>'+telefono_medico+'</td>'+
      '<td><span class="badge badge-pill badge-primary float-left">Nuevo</span></td>' +
    '</tr>';
  	cont++;
  	$('#detalles').append(fila);
  	// console.log(array_medicos_id);
}

function eliminar(index,id_e)
{
  	var n_i = getIndDato(id_e,array_medicos_id);
  	if (n_i != -1) {
   		array_medicos_id.splice(n_i,1);
 	}

 	var n_i = getIndDato2(index,array_valores_medicos);
  	if (n_i != -1) {
  		var valor_medico = array_valores_medicos[n_i][1];
  		datos_medico = valor_medico.split('_');
  		$('#pidmedico').append('<option value="'+valor_medico+'" >'+datos_medico[1]+' '+datos_medico[2]+' '+datos_medico[3]+'</option>');
  		// console.log(datos_medico);
   		array_valores_medicos.splice(n_i,1);
 	}

  	$('#fila'+index).remove();
  	// console.log(array_medicos_id);
  	// console.log(array_valores_medicos);
}

function eliminar_esp(idesp,id) {
	if (array_medicos_id_habilitar.includes(id)) {
		var n_i = getIndDato(id,array_medicos_id_habilitar);
	  	if (n_i != -1) {
	   		array_medicos_id_habilitar.splice(n_i,1);
	 	}
		$('#fila_hab'+id).remove();
	}

	if (!array_medicos_id_delete.includes(id)) {
		array_medicos_id_delete.push(id);
	  	var fila='<tr hidden id="fila_eli'+id+'">'+
      		'<td><input type="hidden" name="idmedico_delete[]" value="'+id+'"></td>'+
    		'</tr>';
  		$('#detalles').append(fila);
	}

	document.getElementById("btn_el_"+id).disabled = true;
	document.getElementById("btn_hab_"+id).disabled = false;

	// var fila='<tr hidden id="fila_eli'+id+'">'+
 //      	'<td><input type="hidden" name="idmedico_delete[]" value="'+id+'"></td>'+
 //    	'</tr>';
 //  	$('#detalles').append(fila);
  	// console.log(array_medicos_id);

  	var span = document.getElementById(id+"text");
  	span.textContent = "Inactivo";
  	span.className = "badge badge-pill badge-danger float-left";
}

function hab_esp(idesp,id) {
	if (!array_medicos_id_habilitar.includes(id)) {
		array_medicos_id_habilitar.push(id);
	  	var fila='<tr hidden id="fila_hab'+id+'">'+
      		'<td><input type="hidden" name="idmedico_habilitar[]" value="'+id+'"></td>'+
    		'</tr>';
  		$('#detalles').append(fila);
	}

	if (array_medicos_id_delete.includes(id)) {
		var n_i = getIndDato(id,array_medicos_id_delete);
	  	if (n_i != -1) {
	   		array_medicos_id_delete.splice(n_i,1);
	 	}
		$('#fila_eli'+id).remove();
	}

	document.getElementById("btn_el_"+id).disabled = false;
	document.getElementById("btn_hab_"+id).disabled = true;
  	// console.log(array_medicos_id);

  	var span = document.getElementById(id+"text");
  	span.textContent = "Activo";
  	span.className = "badge badge-pill badge-success float-left";
}

function getIndDato(ind,array_l) {
  var c = 0;
  for (var i = 0; i < array_l.length; i++) {
    if (array_l[i] == ind) {
      return c;
    }
    c++;
  }
  return -1;
}

function getIndDato2(ind,array_l) {
  var c = 0;
  for (var i = 0; i < array_l.length; i++) {
    if (array_l[i][0] == ind) {
      return c;
    }
    c++;
  }
  return -1;
}
//file:///C:/Taller%20de%20Grado%20ll/plantillas/remark-403/remark-403/material/base/html/apps/contacts/contacts.html
//file:///C:/Taller%20de%20Grado%20ll/plantillas/remark-403/remark-403/material/base/html/tables/jsgrid.html
window.addEventListener("load",comenzar, false);
</script>
@endpush
@include('admCentros.alertas.logrado')
@endsection