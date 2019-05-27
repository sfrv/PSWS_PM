{!! Form::open(array('route'=>['index-reporte-cama',$centro->id],'method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}
<div>
	<div class="row">
		<div class="col-lg-12 col-xs-12">
			<h4>Reporte de Camas de {{ $centro->nombre }}</h4>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-lg-5 col-xs-12">
		<div class="form-group form-material floating" data-plugin="formMaterial">
	    	<input required type="date" value="{{$fecha_actual}}" class="form-control" name="fecha_desde"/>
	        <label class="floating-label">Buscar desde:</label>
    	</div>
	</div>
	<div class="col-lg-5 col-xs-12">
		<div class="form-group form-material floating" data-plugin="formMaterial">
	    	<input required type="date" value="{{$fecha_actual}}" class="form-control" name="fecha_hasta"/>
	        <label class="floating-label">hasta:</label>
    	</div>
	</div>
	<div class="col-lg-2 col-xs-12" id="guardar">
		<div class="form-group form-material floating">
			<button type="submit" class="btn btn-primary btn-block btn-round" data-style="slide-right" data-plugin="ladda">
			<span class="ladda-label">Buscar</span>
		</button>
		</div>
	</div>
	</div>
</div>
{{Form::close()}}