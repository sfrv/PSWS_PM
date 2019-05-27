{!! Form::open(array('url'=>'adm/centro','method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}
<div class="row">
	<div class="col-lg-3 col-xs-12">
		<h4>Centros Medicos Registrados</h4>
	</div>
	<div class="col-lg-6 col-xs-12">
		Buscar Por: 
		<select name="filtro" id="filtro" style="border-radius: 5px;width: 150px">
          	<option value="1" selected>Centro Medico</option>
          	<option value="2">Especialidad</option>
      	</select>
	</div>
</div>
<br>
<div class="input-search input-search-dark">
	<i class="input-search-icon md-search" aria-hidden="true" ></i>
	<input type="text" class="form-control" name="searchText" placeholder="Nombre del Medico..." values="{{$searchText}}">
	
</div>

{{Form::close()}}