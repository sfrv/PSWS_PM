@extends('layouts.admin')
@section('contenido')
<div class="panel">
	<div class="panel-body container-fluid">
		<div class="row row-lg">
			<div class="col-lg-12">
			    <div class="example-wrap">
			      	<h4>Reporte de Cama</h4>
			      	<br>
		              	<div class="row">
		              		<div class="col-lg-6 col-xs-12">
		                  		<div class="form-group form-material floating" data-plugin="formMaterial">
				                	<input disabled required type="text" class="form-control" value="{{$reporte_cama->titulo}}" name="titulo"/>
				                    <label class="floating-label">Titulo</label>
				                </div>
			              	</div>
			              	<div class="col-lg-6 col-xs-12">
		                  		<div class="form-group form-material floating" data-plugin="formMaterial">
				                	<input disabled required type="date" value="{{$reporte_cama->fecha}}" class="form-control" name="fecha"/>
				                    <label class="floating-label">Fecha</label>
				                </div>
			              	</div>
		              	</div>

		              	<div>
		              		<h4>Areas de Camas</h4>
		      			  	<div class="example table-responsive">
			          			<table id="detalles" class="table table-striped">
			          			<thead>
			      					<tr>
			      						<th class="text-center">Area</th>
			      						<th class="text-center">COC-M</th>
					                  	<th class="text-center">COF-M</th>
					                  	<th class="text-center">CDI-M</th>
					                  	<th class="text-center">COC-T</th>
					                  	<th class="text-center">COF-T</th>
					                  	<th class="text-center">CDI-T</th>
					                  	<th class="text-center">COC-N</th>
					                  	<th class="text-center">COF-N</th>
					                  	<th class="text-center">CDI-N</th>
			      					</tr>
			          			</thead>
			          			<tbody>
			          				@foreach($detalle_reporte_cama as $var)
				                      	<tr id="fila_datos{{$var -> id}}">
					                        <td class="text-center">{{$var -> nombre_area}}
					                        	<input type="hidden" name="id_detalle_areas_editar[]" value="{{$var->id}}">
					                        </td>
					                        <td class="text-center">
					                        	<input disabled class="autosize form-control" name="cocm_{{$var->id}}" type="number" step="any" value="{{$var->coc_m}}">
					                        </td>
					                        <td class="text-center">
					                        	<input disabled class="autosize form-control" name="cofm_{{$var->id}}" type="number" step="any" value="{{$var->cof_m}}">
					                        </td>
					                        <td class="text-center">
					                        	<input disabled class="autosize form-control" name="cdim_{{$var->id}}" type="number" step="any" value="{{$var->cdi_m}}">
					                        </td>
					                        <td class="text-center">
					                        	<input disabled class="autosize form-control" name="coct_{{$var->id}}" type="number" step="any" value="{{$var->coc_t}}">
					                        </td>
					                        <td class="text-center">
					                        	<input disabled class="autosize form-control" name="coft_{{$var->id}}" type="number" step="any" value="{{$var->cof_t}}">
					                        </td>
					                        <td class="text-center">
					                        	<input disabled class="autosize form-control" name="cdit_{{$var->id}}" type="number" step="any" value="{{$var->cdi_t}}">
					                        </td>
					                        <td class="text-center">
					                        	<input disabled class="autosize form-control" name="cocn_{{$var->id}}" type="number" step="any" value="{{$var->coc_n}}">
					                        </td>
					                        <td class="text-center">
					                        	<input disabled class="autosize form-control" name="cofn_{{$var->id}}" type="number" step="any" value="{{$var->cof_n}}">
					                        </td>
					                        <td class="text-center">
					                        	<input disabled class="autosize form-control" name="cdin_{{$var->id}}" type="number" step="any" value="{{$var->cdi_n}}">
					                        </td>
				                      	</tr>
				                  	@endforeach
				                </tbody>
			          			</table>
		      				</div>
		              	</div>
		              	
		              	<div class="col-sm-8 col-sm-offset-2">
		              		<a href="{{ route('index-reporte-cama', $id_centro) }}">
			              		<button class="btn btn-primary btn-block btn-round" data-style="slide-left" data-plugin="ladda">
			              			<span class="ladda-label"><i class="icon md-long-arrow-left ml-10" aria-hidden="true"></i> Volver Inicio</span>
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

setTimeout(clickb,1500);
function clickb() {
	var x = document.getElementById("mynav");
	if (x.className != "animsition site-menubar-hide site-menubar-unfold")
		x.className = "animsition site-menubar-fold";
}


</script>
@endpush
@endsection