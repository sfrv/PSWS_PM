@extends('layouts.admin')
@section('contenido')
<div class="panel">
	<div class="panel-body container-fluid">
		<div class="row row-lg">
			<div class="col-lg-12">
			    <div class="example-wrap">
			      	<div class="row">
			      		<div class="col-lg-10 col-xs-12">
			      			<h4>Editar Areas de Cama del Centro Medico: {{$centro->nombre}}</h4>	
			      		</div>
			      		<div class="col-lg-2 col-xs-12">
			      			<ol class="breadcrumb">
						     	<li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
						     	<li><a href="{{url('adm/centro')}}">index</a></li>
						  	</ol>
			      		</div>
			      	</div>
			      	<br>
			      	{!! Form::model($centro,['method'=>'PATCH','route'=>['update-areas',$centro->id]])!!}
            		{{Form::token()}}
					<h4>Areas de Camas Registrados</h4>
      			  	<div class="example table-responsive">
	          			<table id="detalles" class="table table-striped">
	          			<thead>
	      					<tr>
	      						<th class="text-center">Opciones</th>
	      						<th class="text-center">Nombre</th>
			                  	<th class="text-center">Descripcion</th>
			                  	<th >Estado</th>
	      					</tr>
	          			</thead>
	          			<tbody>
	          				<tr></tr>
	          				<tr>
	          					<td class="text-center">
	          						-
	          					</td>
	          					<td>
	          						<input style="border-color: blue" type="text" class="form-control" id="pnombre" placeholder="Nombre..." />
	          					</td>
	          					<td>
	          						<input style="border-color: blue" type="text" class="form-control" id="pdescripcion" placeholder="Descripcion..." />
	          					</td>
	          					<td>
	          						<button id="bt_add" onclick="agregar()" type="button" class="btn btn-icon btn-primary"><i class="icon md-plus"></i></button>
	          					</td>
	          				</tr>
		                 	@foreach($areas_camas as $var)
		                      	<tr class="text-center">
		                          	<td>
	                          		@if($var -> estado == 1)
		                        		<button id="btn_el_{{$var -> id}}" type="button" class="btn btn-icon btn-danger" onclick="eliminar({{$var -> id}});"><i class="icon md-close" aria-hidden="true"></i></button>
	                          			<button disabled id="btn_hab_{{$var -> id}}" type="button" class="btn btn-icon btn-primary" onclick="habi({{$var -> id}});"><i class="icon md-check" aria-hidden="true"></i></button>
		                        	@else
		                        		<button disabled id="btn_el_{{$var -> id}}" type="button" class="btn btn-icon btn-danger" onclick="eliminar({{$var -> id}});"><i class="icon md-close" aria-hidden="true"></i></button>
	                          			<button id="btn_hab_{{$var -> id}}" type="button" class="btn btn btn-icon btn-primary" onclick="habi({{$var -> id}});"><i class="icon md-check" aria-hidden="true"></i></button>
		                        	@endif
		                          	</td>
		                          	<td>
		                          		@if($var -> estado == 1)
		                          			<input id="nombre{{$var->id}}_v" required type="text" class="form-control" name="nombres_editar[]" value="{{$var -> nombre}}" />
		                          		@else
		                          			<input disabled id="nombre{{$var->id}}_v" required type="text" class="form-control" name="nombres_editar[]" value="{{$var -> nombre}}" />
		                          		@endif
		                          	</td>
		                          	<td>
		                          		@if($var -> estado == 1)
		                          			<input id="descripcion{{$var->id}}_v" required type="text" class="form-control" name="descripciones_editar[]" value="{{$var -> descripcion}}" />
		                          		@else
		                          			<input disabled id="descripcion{{$var->id}}_v" required type="text" class="form-control" name="descripciones_editar[]" value="{{$var -> descripcion}}" />
		                          		@endif
		                          	</td>
		                          	<td>
		                          		<input type="hidden" name="id_areas[]" value="{{$var -> id}}">
		                            	@if($var -> estado == 1)
		                            		<input id="id{{$var->id}}_v" type="hidden" name="id_areas_editar[]" value="{{$var -> id}}">
		                              		<span id="{{$var -> id}}text" class="badge badge-pill badge-success float-left">Activo</span>
		                            	@else
		                            		<input disabled id="id{{$var->id}}_v" type="hidden" name="id_areas_editar[]" value="{{$var -> id}}">
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
	              			<span class="ladda-label">Editar Areas de Camas<i class="icon md-long-arrow-right ml-10" aria-hidden="true"></i></span>
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

var areas_json = {!! $areas_camas_json !!};
var cont=0;
var array_areas_id_eliminar = [];

function agregar()
{
	nombre = $("#pnombre").val();
	descripcion = $("#pdescripcion").val();

	if (nombre == "" || descripcion == ""){
	  alert("Por Favor rellene los campos.");
	  return;
	}

  	var fila='<tr class="text-center" id="fila'+cont+'">'+
      '<td><button type="button" class="btn btn-icon btn-danger" onclick="eliminar_nuevos('+cont+');"><i class="icon md-close"></i></button>'+
      '</td>'+
      '<td>'+
      	'<input class="form-control" name="nombres_nuevos[]" value="'+nombre+'">'+
      '</td>'+
      '<td>'+
      	'<input class="form-control" name="descripciones_nuevos[]" value="'+descripcion+'">'+
      '</td>'+
      '<td><span class="badge badge-pill badge-primary float-left">Nuevo</span></td>' +
    '</tr>';
  	cont++;
  	$('#detalles').append(fila);
  	document.getElementById("pnombre").value = "";
	document.getElementById("pdescripcion").value = "";
}

function eliminar_nuevos(cont)
{
    $('#fila'+cont).remove();
}

function eliminar(id) { 
	if (!array_areas_id_eliminar.includes(id)) {
		array_areas_id_eliminar.push(id);
	  	var fila='<tr hidden id="fila_hab'+id+'">'+
      		'<td><input type="hidden" name="id_area_eliminar[]" value="'+id+'"></td>'+
    		'</tr>';
  		$('#detalles').append(fila);
	}

  	document.getElementById("btn_el_"+id).disabled = true;
  	document.getElementById("btn_hab_"+id).disabled = false;

  	document.getElementById("nombre"+id+"_v").disabled = true;
  	document.getElementById("descripcion"+id+"_v").disabled = true;
  	document.getElementById("id"+id+"_v").disabled = true;

  	var span = document.getElementById(id+"text");
  	span.textContent = "Inactivo";
  	span.className = "badge badge-pill badge-danger float-left";
}

function habi(id) {
	if (array_areas_id_eliminar.includes(id)) {
		var n_i = getIndDato(id,array_areas_id_eliminar);
	  	if (n_i != -1) {
	   		array_areas_id_eliminar.splice(n_i,1);
	 	}
		$('#fila_hab'+id).remove();
	}

  	document.getElementById("btn_el_"+id).disabled = false;
  	document.getElementById("btn_hab_"+id).disabled = true;

  	document.getElementById("nombre"+id+"_v").disabled = false;
  	document.getElementById("descripcion"+id+"_v").disabled = false;
  	document.getElementById("id"+id+"_v").disabled = false;

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
</script>
@endpush
@include('admCentros.alertas.logrado')
@endsection