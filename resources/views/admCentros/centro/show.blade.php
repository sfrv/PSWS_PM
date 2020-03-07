@extends('layouts.admin')
@section('contenido')
<div class="panel">
	<div class="panel-body container-fluid">
		<div class="row row-lg">
			<div class="col-lg-12">
			    <div class="example-wrap">
			      	<h4>Centro de Salud: {{$centro->nombre}}</h4>
			      	<br>
			      	<div class="row">
	              		<div class="col-lg-6 col-xs-12">
	                  		<div class="form-group form-material floating" data-plugin="formMaterial">
			                	<input disabled type="text" class="form-control" value="{{$centro->nombre}}" />
			                    <label class="floating-label">Nombre Centro</label>
			                </div>
		              	</div>
		              	<div class="col-lg-6 col-xs-12">
	                  		<div class="form-group form-material floating" data-plugin="formMaterial">
			                	<input disabled type="text" class="form-control" value="{{$centro->direccion}}" />
			                    <label class="floating-label">Direccion Centro</label>
			                </div>
		              	</div>
		              	<div class="col-lg-6 col-xs-12">
	                  		<div class="form-group form-material floating" data-plugin="formMaterial">
			                	<input disabled type="text" class="form-control" value="{{$centro->nombreRed}}" />
			                    <label class="floating-label">Red</label>
			                </div>
		              	</div>
		              	<div class="col-lg-6 col-xs-12">
	                  		<div class="form-group form-material floating" data-plugin="formMaterial">
			                	<input disabled type="text" class="form-control" value="{{$centro->nombreServicio}}" />
			                    <label class="floating-label">Servicio</label>
			                </div>
		              	</div>
		              	<div class="col-lg-6 col-xs-12">
	                  		<div class="form-group form-material floating" data-plugin="formMaterial">
			                	<input disabled type="text" class="form-control" value="{{$centro->nombreZona}}" />
			                    <label class="floating-label">Zona</label>
			                </div>
		              	</div>
		              	<div class="col-lg-6 col-xs-12">
	                  		<div class="form-group form-material floating" data-plugin="formMaterial">
			                	<input disabled type="text" class="form-control" value="{{$centro->nombreNivel}}" />
			                    <label class="floating-label">Nivel</label>
			                </div>
		              	</div>
		              	<div class="col-lg-6 col-xs-12">
	                  		<div class="form-group form-material floating" data-plugin="formMaterial">
			                	<input disabled type="text" class="form-control" value="{{$centro->latitud}}" />
			                    <label class="floating-label">Latitud</label>
			                </div>
		              	</div>
		              	<div class="col-lg-6 col-xs-12">
	                  		<div class="form-group form-material floating" data-plugin="formMaterial">
			                	<input disabled type="text" class="form-control" value="{{$centro->longitud}}" />
			                    <label class="floating-label">Longitud</label>
			                </div>
		              	</div>
		              	<div class="col-lg-4 col-xs-12">
	                  		<div class="form-group form-material floating" data-plugin="formMaterial">
			                	<input disabled type="text" class="form-control" value="{{$centro->distrito}}" />
			                    <label class="floating-label">Distrito</label>
			                </div>
		              	</div>
		              	<div class="col-lg-4 col-xs-12">
	                  		<div class="form-group form-material floating" data-plugin="formMaterial">
			                	<input disabled type="text" class="form-control" value="{{$centro->uv}}" />
			                    <label class="floating-label">UV</label>
			                </div>
		              	</div>
		              	<div class="col-lg-4 col-xs-12">
	                  		<div class="form-group form-material floating" data-plugin="formMaterial">
			                	<input disabled type="text" class="form-control" value="{{$centro->camas_total}}" />
			                    <label class="floating-label">Total Camas</label>
			                </div>
		              	</div>
		              	<div class="col-lg-4 col-xs-12">
	                  		<div class="form-group form-material floating" data-plugin="formMaterial">
			                	<input disabled type="text" class="form-control" value="{{$centro->manzano}}" />
			                    <label class="floating-label">Manzano</label>
			                </div>
		              	</div>
		              	<div class="col-lg-4 col-xs-12">
	                  		<div class="form-group form-material floating" data-plugin="formMaterial">
			                	<input disabled type="text" class="form-control" value="{{$centro->horas_atencion}}" />
			                    <label class="floating-label">Horas Atencion</label>
			                </div>
		              	</div>
		              	<div class="col-lg-4 col-xs-12">
	                  		<div class="form-group form-material floating" data-plugin="formMaterial">
			                	<input disabled type="text" class="form-control" value="{{$centro->telefono}}" />
			                    <label class="floating-label">Telefono</label>
			                </div>
		              	</div>
		              	<div class="col-lg-6 col-md-12 col-dm-12 col-xs-12 col-sm-offset-3">
			                <div class="form-group">               
			                  <label for="form-field-24">
			                    IMAGEN DEL CENTRO:
			                  </label>
			                  <br>
			                  <img style="opacity: 0.8;" src="{{asset('images/Centros/'.$centro->imagen)}}" height="100%" width="100%" class="img-thumbnail">
			                </div>
			            </div>
		              	<br>
	              	</div>
	              	<br>

	              	<h4>Especiliadades Registradas</h4>
      			  	<div class="example table-responsive">
	          			<table class="table table-striped">
	          			<thead>
	      					<tr>
	      						<th class="text-center">Nombre</th>
			                  	<th class="text-center">Emergencia</th>
			                  	<th class="text-center">Consulta Externa</th>
			                  	<th class="text-center">Hospitalizacion</th>
			                  	<th >Estado</th>
	      					</tr>
	          			</thead>
	          			<tbody>
		                 	@foreach($detalle as $var)
		                      	<tr class="text-center">
		                          	<td>{{$var -> nombre}}</td>
		                          	<td>
		                          		<div class="checkbox-custom checkbox-primary">
		                            	@if($var -> etapa_emergencia == 1)
					                        <input disabled type="checkbox" id="inputSchedule" name="inputCheckboxesSchedule" checked>
					                        <label for="inputSchedule">
					                        </label>
		                            	@else
					                        <input disabled type="checkbox" id="inputSchedule" name="inputCheckboxesSchedule">
					                        <label for="inputSchedule">
					                        </label>
		                            	@endif
		                            	</div>
		                          	</td>
		                          	<td>
		                            	<div class="checkbox-custom checkbox-primary">
		                            	@if($var -> etapa_consulta == 1)
					                        <input disabled type="checkbox" id="inputSchedule" name="inputCheckboxesSchedule" checked>
					                        <label for="inputSchedule">
					                        </label>
		                            	@else
					                        <input disabled type="checkbox" id="inputSchedule" name="inputCheckboxesSchedule">
					                        <label for="inputSchedule">
					                        </label>
		                            	@endif
		                            	</div>
		                          	</td>
		                          	<td>
		                            	<div class="checkbox-custom checkbox-primary">
		                            	@if($var -> etapa_hospitalizacion == 1)
					                        <input disabled type="checkbox" id="inputSchedule" name="inputCheckboxesSchedule" checked>
					                        <label for="inputSchedule">
					                        </label>
		                            	@else
					                        <input disabled type="checkbox" id="inputSchedule" name="inputCheckboxesSchedule">
					                        <label for="inputSchedule">
					                        </label>
		                            	@endif
		                            	</div>
		                          	</td>
		                          	<td>
		                            	@if($var -> estado == 1)
		                              		<span class="badge badge-pill badge-success float-left">Activo</span>
		                            	@else
		                              		<span class="badge badge-pill badge-danger float-left">Inactivo</span>
		                            	@endif
		                          	</td>
		                      	</tr>
		                  	@endforeach
		                </tbody>
	          			</table>
      				</div>
             		<br>

             		<h4>Medicos Registrados</h4>
      			  	<div class="example table-responsive">
	          			<table class="table table-striped">
	          			<thead>
	      					<tr>
	      						<th class="text-center">Nombre</th>
			                  	<th class="text-center">Apellido</th>
			                  	<th class="text-center">Telefono</th>
			                  	<th >Estado</th>
	      					</tr>
	          			</thead>
	          			<tbody>
		                 	@foreach($detalle_medicos as $var)
		                      	<tr class="text-center">
		                          	<td>{{$var -> nombre}}</td>
		                          	<td>{{$var -> apellido}}</td>
		                          	<td>{{$var -> telefono}}</td>
		                          	<td>
		                            	@if($var -> estado == 1)
		                              		<span class="badge badge-pill badge-success float-left">Activo</span>
		                            	@else
		                              		<span class="badge badge-pill badge-danger float-left">Inactivo</span>
		                            	@endif
		                          	</td>
		                      	</tr>
		                  	@endforeach
		                </tbody>
	          			</table>
      				</div>
      				<br>
	              	<div class="col-sm-8 col-sm-offset-2">
	              		<a href="{{URL::action('CentroMedicoController@index')}}">
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
@endsection