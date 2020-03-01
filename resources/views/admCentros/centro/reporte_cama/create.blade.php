@extends('layouts.admin')
@section('contenido')
<div class="panel">
	<div class="panel-body container-fluid">
		<div class="row row-lg">
			<div class="col-lg-12">
			    <div class="example-wrap">
			      	<h4>Registrar Reporte de Cama</h4>
			      	<br>
			      	{!! Form::open(array('route'=>['store-reporte-cama',$id_centro],'method'=>'POST','autocomplete'=>'off'))!!}
        			{{Form::token()}}
		              	<div class="row">
		              		<div class="col-lg-6 col-xs-12">
		                  		<div class="form-group form-material floating" data-plugin="formMaterial">
				                	<input required type="text" class="form-control" name="titulo"/>
				                    <label class="floating-label">Titulo</label>
				                </div>
			              	</div>
			              	<div class="col-lg-6 col-xs-12">
		                  		<div class="form-group form-material floating" data-plugin="formMaterial">
				                	<input required type="date" value="{{$fecha_actual}}" class="form-control" name="fecha"/>
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
			          				@foreach($areas as $var)
				                      	<tr id="fila_datos{{$var -> id}}">
					                        <td class="text-center">{{$var -> nombre}}
					                        	<input type="hidden" name="id_areas[]" value="{{$var->id}}">
					                        </td>
					                        <td class="text-center">
					                        	<input class="autosize form-control" value="0" name="cocm_{{$var->id}}" type="number" step="any">
					                        </td>
					                        <td class="text-center">
					                        	<input class="autosize form-control" value="0" name="cofm_{{$var->id}}" type="number" step="any">
					                        </td>
					                        <td class="text-center">
					                        	<input class="autosize form-control" value="0" name="cdim_{{$var->id}}" type="number" step="any">
					                        </td>
					                        <td class="text-center">
					                        	<input class="autosize form-control" value="0" name="coct_{{$var->id}}" type="number" step="any">
					                        </td>
					                        <td class="text-center">
					                        	<input class="autosize form-control" value="0" name="coft_{{$var->id}}" type="number" step="any">
					                        </td>
					                        <td class="text-center">
					                        	<input class="autosize form-control" value="0" name="cdit_{{$var->id}}" type="number" step="any">
					                        </td>
					                        <td class="text-center">
					                        	<input class="autosize form-control" value="0" name="cocn_{{$var->id}}" type="number" step="any">
					                        </td>
					                        <td class="text-center">
					                        	<input class="autosize form-control" value="0" name="cofn_{{$var->id}}" type="number" step="any">
					                        </td>
					                        <td class="text-center">
					                        	<input class="autosize form-control" value="0" name="cdin_{{$var->id}}" type="number" step="any">
					                        </td>
				                      	</tr>
				                  	@endforeach
				                </tbody>
			          			</table>
		      				</div>
		              	</div>
		              	
		              	<div class="col-sm-8 col-sm-offset-2" id="guardar">
		              		<button type="submit" class="btn btn-primary btn-block btn-round" data-style="slide-right" data-plugin="ladda">
		              			<span class="ladda-label">Registrar Reporte de Cama<i class="icon md-long-arrow-right ml-10" aria-hidden="true"></i></span>
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




</script>
@endpush
@endsection