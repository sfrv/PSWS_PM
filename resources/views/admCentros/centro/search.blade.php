{!! Form::open(array('url'=>'adm/medico','method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}

<div class="input-search input-search-dark">
	<i class="input-search-icon md-search" aria-hidden="true" ></i>
	<input type="text" class="form-control" name="searchText" placeholder="Nombre del Medico..." values="{{$searchText}}">
	
</div>

{{Form::close()}}