@extends('layouts.admin')
@section('contenido')
<div class="panel">
	<div class="panel-body container-fluid">
		<div class="row row-lg">
			<div class="col-lg-12">
			    <div class="example-wrap">
			      	<h4>Registrar Nueva Cartera de Servicio</h4>
			      	<br>
			      	{!! Form::open(array('route'=>['store-cartera-servicio',$id_centro],'method'=>'POST','autocomplete'=>'off'))!!}
        			{{Form::token()}}
		              	<div class="row">
		              		<div class="col-lg-4 col-xs-12">
		                  		<div class="form-group form-material floating" data-plugin="formMaterial">
				                	<input required type="text" class="form-control" name="titulo"/>
				                    <label class="floating-label">Titulo</label>
				                </div>
			              	</div>
			              	<div class="col-lg-4 col-xs-12">
		                  		<div class="form-group" data-plugin="formMaterial">
				                	<label class="floating-label">Mes</label>
				                	<select name="mes" class="form-control">
					                    @foreach($meses as $var)
							                @if($var == $mes_actual)
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
							                @if($var == $anio_actual)
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
			          				@foreach($detalle as $var)
				                      	<tr id="fila_datos{{$var -> id}}">
					                        <td class="text-center">{{$var -> nombre}} </td>
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
		              			<span class="ladda-label">Registrar Cartera de Servicio<i class="icon md-long-arrow-right ml-10" aria-hidden="true"></i></span>
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
setTimeout(clickb,1500);
function clickb() {
	// console.log("s");
	// var obj=document.getElementById('linkmn');
	// obj.click();
	// console.log("s");
	var x = document.getElementById("mynav");
	//animsition site-menubar-changing site-menubar-hide site-menubar-unfold proceso de cambio
	if (x.className != "animsition site-menubar-hide site-menubar-unfold")
		x.className = "animsition site-menubar-fold";
}

// var x = document.getElementById("mynav");
// x.className = "animsition site-menubar-changing site-menubar-fold";

// var x = document.getElementById("mynav");
// x.className = "animsition site-menubar-fold";

var cont = 0;

function agregar(id)
{
  	var fila_servicio = '<div id="fila_s'+cont+'" style="padding-bottom: 7px;">'+
    	'<input type="hidden" name="idservicios[]" value="'+cont+'">'+
    	'<input type="hidden" name="idespecialidad[]" value="'+id+'">'+
    	'<select name="text_s'+cont+'" class="form-control selectpicker">'+
      		'@foreach($nombres_servicios as $var)'+
      			' <option value="{{$var}}">{{$var}}</option> '+
      		'@endforeach'+
    	'</select> '+
  	'</div>';

	var fila_dia = '<div id="fila_d'+cont+'" style="padding-bottom: 7px;">'+
        '<input class="autosize form-control" name="text_d'+cont+'" type="text" step="any">'+
    '</div>';
	var fila_hora ='<div id="fila_h'+cont+'" style="padding-bottom: 7px;">'+
        '<input class="autosize form-control" name="text_h'+cont+'" type="text" step="any">'+
    '</div>';
	var fila_observacion = '<div id="fila_ob'+cont+'" style="padding-bottom: 7px;">'+
        '<input class="autosize form-control" name="text_o'+cont+'" type="text" step="any">'+
    '</div>';
	var fila_opcion = '<div id="fila_op'+cont+'" style="padding-bottom: 5px;">'+
        '<button type="button" class="btn btn-icon btn-danger" onclick="eliminar('+cont+');"><i class="icon md-close"></i></button>'+
    '</div>';
	cont++;
	$('#especialidad_servicio'+id).append(fila_servicio);
	$('#especialidad_dia'+id).append(fila_dia);
	$('#especialidad_hora'+id).append(fila_hora);
	$('#especialidad_observacion'+id).append(fila_observacion);
	$('#especialidad_opcion'+id).append(fila_opcion);
}

function eliminar(cont)
{
	$('#fila_s'+cont).remove();
	$('#fila_d'+cont).remove();
	$('#fila_h'+cont).remove();
	$('#fila_ob'+cont).remove();
	$('#fila_op'+cont).remove();
}


</script>
@endpush
@endsection