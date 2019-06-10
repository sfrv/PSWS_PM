@extends('layouts.admin')
@section('contenido')
<div class="panel">
	<div class="panel-body container-fluid">
		<div class="row row-lg">
			<div class="col-lg-12">
			    <div class="example-wrap">
			      	<h4>Editar Cartera de Servicio {{$cartera_servicio->mes}} / {{$cartera_servicio->anio}}</h4>
			      	<br>
			      	{!! Form::model($cartera_servicio->id,['method'=>'PATCH','autocomplete'=>'off','route'=>['update-cartera-servicio',$cartera_servicio->id,$id_centro]])!!}
					{{Form::token()}} 
		              	<div class="row">
		              		<div class="col-lg-4 col-xs-12">
		                  		<div class="form-group form-material floating" data-plugin="formMaterial">
				                	<input required type="text" class="form-control" value="{{$cartera_servicio->titulo}}" name="titulo"/>
				                    <label class="floating-label">Titulo</label>
				                </div>
			              	</div>
			              	<div class="col-lg-4 col-xs-12">
		                  		<div class="form-group" data-plugin="formMaterial">
				                	<label class="floating-label">Mes</label>
				                	<select name="mes" class="form-control">
					                    @foreach($meses as $var)
							                @if($var == $cartera_servicio->mes)
							                  <option value="{{$var}}" selected>{{$var}}</option>
							                @else
							                  <option value="{{$var}}">{{$var}}</option>
							                @endif
							            @endforeach
				              		</select>
				                </div>
				            </div>
				            <div class="col-lg-4 col-xs-12">
		                  		<div class="form-group" data-plugin="formMaterial">
				                	<label class="floating-label">Anio</label>
				                	<select name="anio" class="form-control">
					                    @foreach($anios as $var)
							                @if($var == $cartera_servicio->anio)
							                  <option value="{{$var}}" selected>{{$var}}</option>
							                @else
							                  <option value="{{$var}}">{{$var}}</option>
							                @endif
							            @endforeach
				              		</select>
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
					                  	<th>Opcion 1</th>
					                  	<th>Opcion 2</th>
			      					</tr>
			          			</thead>
			          			<tbody>
			          				@foreach($especialidades as $var)
				                      	<tr id="fila_datos{{$var -> id}}">
					                        <td class="text-center">{{$var -> nombre}}</td>
					                        <td class="text-center" id="especialidad_servicio{{$var -> id}}"></td>
					                        <td class="text-center" id="especialidad_dia{{$var -> id}}"></td>
					                        <td class="text-center" id="especialidad_hora{{$var -> id}}"></td>
					                        <td class="text-center" id="especialidad_observacion{{$var -> id}}"></td>
					                        <td class="text-center" id="especialidad_opcion{{$var -> id}}"></td>
					                        <td class="text-center"><button type="button" class="btn btn-icon btn-primary" onclick="agregar({{$var -> id}});"><i class="icon md-plus"></i></button></td>
				                      	</tr>
				                  	@endforeach
				                </tbody>
			          			</table>
		      				</div>
		              	</div>
		              	
		              	<div class="col-sm-8 col-sm-offset-2" id="guardar">
		              		<button type="submit" class="btn btn-primary btn-block btn-round" data-style="slide-right" data-plugin="ladda">
		              			<span class="ladda-label">Editar Cartera de Servicio<i class="icon md-long-arrow-right ml-10" aria-hidden="true"></i></span>
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
var servicios = {!! $servicios_json !!};
setTimeout(clickb,1500);
function clickb() {
	var x = document.getElementById("mynav");
	if (x.className != "animsition site-menubar-hide site-menubar-unfold")
		x.className = "animsition site-menubar-fold";
}

var servicios = {!! $servicios_json !!};
var nombres_servicios = {!! $nombres_servicios_json !!};
var cont = 0;
var filas = [];
var datos_filas = [];
var datos_filas_delete = [];
var datos_filas_new = [];
console.log(servicios);

for(i=0;i<servicios.length;i++){
	var fila_servicio = '<div id="fila_s'+cont+'" style="padding-bottom: 7px;">'+
          '<select name="nombre_servicio_'+servicios[i]['id']+'" class="form-control selectpicker">';
          for (var j = 0; j < nombres_servicios.length; j++) {
            if (nombres_servicios[j] == servicios[i]['nombre']) {
              fila_servicio = fila_servicio + '<option value="'+nombres_servicios[j]+'" selected>'+nombres_servicios[j]+'</option>';
            }else{
              fila_servicio = fila_servicio + '<option value="'+nombres_servicios[j]+'">'+nombres_servicios[j]+'</option>';
            }
          }
    fila_servicio = fila_servicio + '</select></div>';
	var fila_dia = '<div id="fila_d'+cont+'" style="padding-bottom: 7px;">'+
		'<input name="dias_'+servicios[i]['id']+'" class="autosize form-control" type="text" value="'+servicios[i]['dias']+'">'+
		'<input type="hidden" name="id_detalle_servicios_editar[]" value="'+servicios[i]['id']+'">'+
	'</div>';
	var fila_hora = '<div id="fila_h'+cont+'" style="padding-bottom: 7px;">'+
		'<input name="hora_'+servicios[i]['id']+'" class="autosize form-control" type="text" value="'+servicios[i]['hora']+'">'+
	'</div>';
	var fila_observacion = '<div id="fila_ob'+cont+'" style="padding-bottom: 7px;">'+
		'<input name="observacion_'+servicios[i]['id']+'" class="autosize form-control" type="text" value="'+servicios[i]['observacion']+'">'+
	'</div>';
	var fila_opcion = '<div id="fila_op'+cont+'"><button style="margin-bottom: 5px;" type="button" class="btn btn-icon btn-danger" onclick="eliminar('+cont+','+servicios[i]['id']+');"><i class="icon md-close"></i></button></div>';

	$('#especialidad_servicio'+servicios[i]['id_detalle_centro_especialidad']).append(fila_servicio);
	$('#especialidad_dia'+servicios[i]['id_detalle_centro_especialidad']).append(fila_dia);
	$('#especialidad_hora'+servicios[i]['id_detalle_centro_especialidad']).append(fila_hora);
	$('#especialidad_observacion'+servicios[i]['id_detalle_centro_especialidad']).append(fila_observacion);
	$('#especialidad_opcion'+servicios[i]['id_detalle_centro_especialidad']).append(fila_opcion);
	cont++;
}

function agregar(id)
{
  	var fila_servicio = '<div id="fila_s'+cont+'" style="padding-bottom: 7px;">'+
    	'<select name="nuevo_nombre_servicio_'+cont+'" class="form-control selectpicker">'+
      		'@foreach($nombres_servicios as $var)'+
      			' <option value="{{$var}}">{{$var}}</option> '+
      		'@endforeach'+
    	'</select> '+
  	'</div>';

  	var fila_dia = '<div id="fila_d'+cont+'" style="padding-bottom: 7px;">'+
  		'<input class="autosize form-control" name="nuevo_dias_'+cont+'" type="text" step="any">'+
  		'<input type="hidden" name="id_detalle_servicios_nuevos[]" value="'+cont+'">'+
  		'<input type="hidden" name="nuevo_id_especialidad_'+cont+'" value="'+id+'">'+
  	'</div>';
  	var fila_hora ='<div id="fila_h'+cont+'" style="padding-bottom: 7px;">'+
  		'<input class="autosize form-control" name="nuevo_hora_'+cont+'" type="text" step="any">'+
  	'</div>';
  	var fila_observacion = '<div id="fila_ob'+cont+'" style="padding-bottom: 7px;">'+
  		'<input class="autosize form-control" name="nuevo_observacion_'+cont+'" type="text" step="any">'+
  	'</div>';
  	var fila_opcion = '<div id="fila_op'+cont+'" style="padding-bottom: 5px;">'+
  		'<button type="button" class="btn btn-icon btn-danger" onclick="eliminar('+cont+',-1'+');"><i class="icon md-close"></i></button>'+
  	'</div>';
  	cont++;
  	$('#especialidad_servicio'+id).append(fila_servicio);
  	$('#especialidad_dia'+id).append(fila_dia);
  	$('#especialidad_hora'+id).append(fila_hora);
  	$('#especialidad_observacion'+id).append(fila_observacion);
  	$('#especialidad_opcion'+id).append(fila_opcion);
}

function eliminar(cont,id_servicio)
{
    $('#fila_s'+cont).remove();
    $('#fila_d'+cont).remove();
    $('#fila_h'+cont).remove();
    $('#fila_ob'+cont).remove();
    $('#fila_op'+cont).remove();
    if(id_servicio == -1)
    	return;
    var fila='<tr hidden id="servi_eli'+id_servicio+'">'+
      		'<td><input type="hidden" name="id_servicios_eliminar[]" value="'+id_servicio+'"></td>'+
    		'</tr>';
  	$('#detalles').append(fila);
}

</script>
@endpush
@endsection