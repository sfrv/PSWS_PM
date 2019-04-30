@extends('layouts.admin')
@section('contenido')
<div class="panel">
	<div class="panel-body container-fluid">
		<div class="row row-lg">
			<div class="col-lg-12">
			    <div class="example-wrap">
			      	<div class="row">
			      		<div class="col-lg-10 col-xs-12">
			      			<h4>Editar Especialidades del Centro Medico: {{$centro->nombre}}</h4>	
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
		                    <label>Especialidades Disponibles: </label>
		                    <select name="pidespecialidad_e" id="pidespecialidad_e" class="form-control">
		                        @foreach($especialidades as $var)
		                          <option value="{{$var -> id}}">{{$var -> nombre}}</option>
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
			      	{!! Form::model($centro,['method'=>'PATCH','route'=>['update-especialidades',$centro->id]])!!}
            		{{Form::token()}}
					<h4>Especialidades Registradas</h4>
      			  	<div class="example table-responsive">
	          			<table id="detalles" class="table table-striped">
	          			<thead>
	      					<tr>
	      						<th class="text-center">Opciones</th>
				                <th class="text-center">Nombre</th>
				                <th class="text-center">Emergencia</th>
				                <th class="text-center">Consulta Ext.</th>
				                <th class="text-center">Hospitalizacion</th>
				                <th>Estado</th>
	      					</tr>
	          			</thead>
	          			<tbody>
		                 	@foreach($detalle as $var)
		                      	<tr class="text-center">
		                          	<td>
	                          		@if($var -> estado == 1)
		                        		<button id="btn_el_{{$var -> id}}" type="button" class="btn btn-icon btn-danger" onclick="eliminar_esp({{$var -> id_especialidad}},{{$var -> id}});"><i class="icon md-close"></i></button>
                              			<button disabled id="btn_hab_{{$var -> id}}" type="button" class="btn btn-icon btn-primary" onclick="hab_esp({{$var -> id_especialidad}},{{$var -> id}});"><i class="icon md-check"></i></button>
		                        	@else
		                        		<button disabled id="btn_el_{{$var -> id}}" type="button" class="btn btn-icon btn-danger" onclick="eliminar_esp({{$var -> id_especialidad}},{{$var -> id}});"><i class="icon md-close"></i></button>
                              			<button id="btn_hab_{{$var -> id}}" type="button" class="btn btn-icon btn-primary" onclick="hab_esp({{$var -> id_especialidad}},{{$var -> id}});"><i class="icon md-check"></i></button>
		                        	@endif
		                          	</td>
		                          	<td>
		                          		<input type="hidden" name="idespecialidad_edit[]" value="{{$var -> id}}">{{$var -> nombre}}
		                          	</td>
		                          	<td>
			                          	<div class="checkbox-custom checkbox-primary">
			                          	@if($var -> etapa_emergencia == 1)
			                            	@if($var -> estado == 1)
			                              		<input name="{{$var -> id}}_ef" id="{{$var -> id}}_ef" type="checkbox" checked>
			                            	@else
			                              		<input disabled name="{{$var -> id}}_ef"  id="{{$var -> id}}_ef" type="checkbox" checked>
			                            	@endif
			                          	@else
			                            	@if($var -> estado == 1)
			                              		<input name="{{$var -> id}}_ef"  id="{{$var -> id}}_ef" type="checkbox">
			                            	@else
			                              		<input disabled name="{{$var -> id}}_ef"  id="{{$var -> id}}_ef" type="checkbox">
			                            	@endif
			                          	@endif
			                          	<label for="inputSchedule">
					                    </label>
			                          	</div>
			                        </td>
			                        <td>
			                        	<div class="checkbox-custom checkbox-primary">
			                          	@if($var -> etapa_consulta == 1)
			                            	@if($var -> estado == 1)
			                              		<input name="{{$var -> id}}_cf" id="{{$var -> id}}_cf" type="checkbox" checked>
			                            	@else
			                              		<input disabled name="{{$var -> id}}_cf" id="{{$var -> id}}_cf" type="checkbox" checked>
			                            	@endif
			                          	@else
			                            	@if($var -> estado == 1)
			                              		<input name="{{$var -> id}}_cf" id="{{$var -> id}}_cf" type="checkbox">
			                            	@else
			                              		<input disabled name="{{$var -> id}}_cf" id="{{$var -> id}}_cf" type="checkbox">
			                            	@endif
			                          	@endif
			                          	<label for="inputSchedule">
					                    </label>
			                          	</div>
			                        </td>
			                        <td>
			                        	<div class="checkbox-custom checkbox-primary">
			                          	@if($var -> etapa_hospitalizacion == 1)
			                            	@if($var -> estado == 1)
			                              		<input name="{{$var -> id}}_hf" id="{{$var -> id}}_hf" type="checkbox" checked>
			                            	@else
			                              		<input disabled name="{{$var -> id}}_hf" id="{{$var -> id}}_hf" type="checkbox" checked>
			                            	@endif
			                          	@else
			                            	@if($var -> estado == 1)
			                              		<input name="{{$var -> id}}_hf" id="{{$var -> id}}_hf" type="checkbox">
			                            	@else
			                              		<input disabled name="{{$var -> id}}_hf" id="{{$var -> id}}_hf" type="checkbox">
			                            	@endif
			                          	@endif
			                          	<label for="inputSchedule">
					                    </label>
			                          	</div>
			                        </td>
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
	              			<span class="ladda-label">Editar Especialidades<i class="icon md-long-arrow-right ml-10" aria-hidden="true"></i></span>
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
var array_especialidades_id = [];
var array_valores_especialidades = [];
var detalle_json = {!! $detalle_json !!};

for (var i = 0; i < detalle_json.length; i++) {
  $("#pidespecialidad_e option[value='"+detalle_json[i]['id_especialidad']+"']").remove();
  array_especialidades_id.push( "" + detalle_json[i]['id_especialidad']);
}

function comenzar(){
  $('#bt_add_e').click(function(){
   agregar_e();
  });
}

function agregar_e()
{
  idespecialidad=$("#pidespecialidad_e").val();
  especialidad=$("#pidespecialidad_e option:selected").text();

  if (idespecialidad == "" || especialidad == ""){
    alert("Error al Agregar, Por Favor Seleccione Una Especialidad.");
    return;
  }

  if (array_especialidades_id.includes(idespecialidad)) {
    alert("Error al Agregar, Especialidad Ya Agregada.");
    return;
  }

  $("#pidespecialidad_e option[value='"+idespecialidad+"']").remove();
  var aux_array = [];
  aux_array.push(cont,idespecialidad,especialidad);
  array_valores_especialidades.push(aux_array);
  // console.log(array_valores_especialidades);

  // console.log(idespecialidad);
  // console.log(especialidad);

					                    
			                          	
  array_especialidades_id.push(idespecialidad);
  var fila='<tr class="text-center" class="selected" id="fila'+cont+'">'+
      '<td><button type="button" class="btn btn-icon btn-danger" onclick="eliminar('+cont+','+idespecialidad+');"><i class="icon md-close"></i></button></td>'+
      '<td><input type="hidden" name="idespecialidad_e[]" value="'+idespecialidad+'">'+especialidad+'</td>'+
      '<td><div class="checkbox-custom checkbox-primary"><input name="'+idespecialidad+'_e" type="checkbox" value="yes"><label for="inputSchedule"></label></div></td>'+
      '<td><div class="checkbox-custom checkbox-primary"><input name="'+idespecialidad+'_c" type="checkbox" value="yes"><label for="inputSchedule"></label></div></td>'+
      '<td><div class="checkbox-custom checkbox-primary"><input name="'+idespecialidad+'_h" type="checkbox" value="yes"><label for="inputSchedule"></label></div></td>'+
      '<td><span class="badge badge-pill badge-primary float-left">Nuevo</span></td>' +
    '</tr>';
  cont++;
  // $("#pidespecialidad_e").val("");
  $('#detalles').append(fila);
  // console.log(array_especialidades_id);
}

function eliminar(index,id_e)
{
  var n_i = getIndDato(id_e);
  if (n_i != -1) {
    array_especialidades_id.splice(n_i,1);
  }

  var n_i = getIndDato2(index,array_valores_especialidades);
    if (n_i != -1) {
      var idespecialidad = array_valores_especialidades[n_i][1];
      var especialidad = array_valores_especialidades[n_i][2];
      $('#pidespecialidad_e').append('<option value="'+idespecialidad+'" >'+especialidad+'</option>');
      // console.log(datos_medico);
      array_valores_especialidades.splice(n_i,1);
  }

  $('#fila'+index).remove();
  // console.log(array_especialidades_id);
  // console.log(array_valores_especialidades);
}

function eliminar_esp(idesp,id) {
  // var n_i = getIndDato(idesp);
  // if (n_i != -1) {
  //   array_especialidades_id.splice(n_i,1);
  // }
  // var x = document.getElementById("mynav");
  // x.className += " sidebar-collapse";
  // $('#fila_hab'+id).remove();
  // document.getElementById("btn_el_"+id).style.display = "none";//mostrar
  // document.getElementById("btn_hab_"+id).style.display = "block";//ocultar

  // var fila='<tr hidden id="fila_eli'+id+'">'+
  //     '<td><input type="hidden" name="idespecialidad_delete[]" value="'+id+'"></td>'+
  //   '</tr>';
  // $('#detalles').append(fila);
  // $('#fila'+idesp).remove();
  document.getElementById("btn_el_"+id).disabled = true;
  document.getElementById("btn_hab_"+id).disabled = false;

  document.getElementById(id+"_ef").disabled = true;
  document.getElementById(id+"_cf").disabled = true;
  document.getElementById(id+"_hf").disabled = true;
  // console.log(array_especialidades_id);

  	var span = document.getElementById(id+"text");
  	span.textContent = "Inactivo";
  	span.className = "badge badge-pill badge-danger float-left";
}

function hab_esp(idesp,id) {
  // $('#fila_eli'+id).remove();
  // document.getElementById("btn_el_"+id).style.display = "block";//mostrar
  // document.getElementById("btn_hab_"+id).style.display = "none";//ocultar

  // var fila='<tr hidden id="fila_hab'+id+'">'+
  //     '<td><input type="hidden" name="idespecialidad_habilitar[]" value="'+id+'"></td>'+
  //   '</tr>';
  // $('#detalles').append(fila);
  document.getElementById("btn_el_"+id).disabled = false;
  document.getElementById("btn_hab_"+id).disabled = true;

  document.getElementById(id+"_ef").disabled = false;
  document.getElementById(id+"_cf").disabled = false;
  document.getElementById(id+"_hf").disabled = false;
  console.log(array_especialidades_id);

  var span = document.getElementById(id+"text");
  	span.textContent = "Activo";
  	span.className = "badge badge-pill badge-success float-left";
}

function getIndDato(ind) {
  var c = 0;
  for (var i = 0; i < array_especialidades_id.length; i++) {
    if (array_especialidades_id[i] == ind) {
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

window.addEventListener("load",comenzar, false);
</script>
@endpush
@endsection