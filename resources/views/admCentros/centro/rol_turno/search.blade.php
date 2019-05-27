{!! Form::open(array('route'=>['index-rol-turno',$centro->id],'method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}

<div class="input-search input-search-dark">
	<i class="input-search-icon md-search" aria-hidden="true" ></i>
	<input type="text" class="form-control" name="searchText" placeholder="Buscar Por Titulo o Mes..." values="{{$searchText}}">
	
</div>

{{Form::close()}}