@extends('layouts.admin')
@section('contenido')
<div class="panel">
	<div class="panel-body container-fluid">
		<div class="row row-lg">
			<div class="col-lg-12">
			    <div class="example-wrap">
			      	<div class="row">
			      		<div class="col-lg-10 col-xs-12">
			      			<h4>Editar Centro Medico: {{$centro->nombre}}</h4>	
			      		</div>
			      		<div class="col-lg-2 col-xs-12">
			      			<ol class="breadcrumb">
						     	<li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
						     	<li><a href="{{url('adm/centro')}}">index</a></li>
						  	</ol>
			      		</div>
			      	</div>
			      	<br>
			      	{!! Form::model($centro,['method'=>'PATCH','route'=>['centro.update',$centro->id],'files'=>'true'])!!}
          			{{Form::token()}} 
		              	<div class="row">
		              		<div class="col-lg-4 col-xs-12">
		                  		<div class="form-group form-material floating" data-plugin="formMaterial">
				                	<input onkeypress='return validaNumericos(event)' onkeyup="calcular()" required name="camas_total" id="camas_total" class="form-control" type="number" step="any" value="{{$centro->camas_total}}">
				                    <label class="floating-label">Camas Total</label>
				                </div>

			              	</div>
			              	<div class="col-lg-4 col-xs-12">
		                  		<div class="form-group form-material floating" data-plugin="formMaterial">
				                	<input onkeypress='return validaNumericos(event)' onkeyup="calcular()" required name="camas_ocupadas" id="camas_ocupadas" class="form-control" type="number" step="any" value="{{$centro->camas_ocupadas}}">
				                    <label class="floating-label">Camas Ocupadas</label>
				                </div>
			              	</div>
			              	<div class="col-lg-4 col-xs-12">
		                  		<div class="form-group form-material floating" data-plugin="formMaterial">
				                	<input disabled min="0" onkeypress='return validaNumericos(event)' required name="camas_libres" id="camas_libres" class="form-control" type="number" step="any" value="{{$centro->camas_total - $centro->camas_ocupadas}}">
				                    <label class="floating-label" id="letra_camas_libres">Camas Libres</label>
				                </div>
			              	</div>
			              	<div class="col-lg-6 col-xs-12">
				                <div class="card card-block p-30">
				                  	<div class="counter counter-md text-left">
				                    	<div class="row">
				                    		<div class="col-lg-9 col-xs-5 counter counter-md counter text-left">
					                      		<span class="counter-icon mr-10 blue-600">
						                    	<i class="icon md-account-add" style="font-size: 1.73em;"></i>
						                  		</span>
					                    	</div>
					                    	<div class="col-lg-3 col-xs-7 counter counter-md counter text-left">
					                      		<span class="counter-number">{{count($detalle_medicos)}}</span>
					                      		<span class="counter-number-related text-capitalize">Medicos</span>
					                    	</div>
				                    	</div>
				                    	<div class="counter-label">
				                      		<div class="progress progress-xs mb-10">
				                        		<div class="progress-bar progress-bar-info bg-blue-600" aria-valuenow="70.3" aria-valuemin="0"
				                          aria-valuemax="100" style="width: 100%" role="progressbar">
				                        		</div>
				                      		</div>
				                      		<div class="counter counter-sm text-left">
				                        		<div class="counter-number-group">
				                          			<span class="counter-icon blue-600 mr-5"><a href="{{ route('edit-medicos', $centro->id) }}" class="small-box-footer">Gestionar Medicos <i class="md-edit"></i></a></span>
				                        		</div>
				                      		</div>
				                    	</div>
				                  	</div>
				                </div>
			                </div>
			                <div class="col-lg-6 col-xs-12">
				                <div class="card card-block p-30">
				                  	<div class="counter counter-md text-left">
				                    	<div class="row">
				                    		<div class="col-lg-8 col-xs-5 counter counter-md counter text-left">
					                      		<span class="counter-icon mr-10 blue-600">
						                    	<i class="icon md-plus-circle-o" style="font-size: 1.73em;"></i>
						                  		</span>
					                    	</div>
					                    	<div class="col-lg-4 col-xs-7 counter counter-md counter text-left">
					                      		<span class="counter-number">{{count($detalle)}}</span>
					                      		<span class="counter-number-related text-capitalize">Especialidades</span>
					                    	</div>
				                    	</div>
				                    	<div class="counter-label">
				                      		<div class="progress progress-xs mb-10">
				                        		<div class="progress-bar progress-bar-info bg-blue-600" aria-valuenow="70.3" aria-valuemin="0"
				                          aria-valuemax="100" style="width: 100%" role="progressbar">
				                        		</div>
				                      		</div>
				                      		<div class="counter counter-sm text-left">
				                        		<div class="counter-number-group">
				                          			<span class="counter-icon blue-600 mr-5"><a href="{{ route('edit-especialidades', $centro->id) }}" class="small-box-footer">Gest. Especialidades <i class="md-edit"></i></a></span>
				                        		</div>
				                      		</div>
				                    	</div>
				                  	</div>
				                </div>
			                </div>
			                <div class="col-lg-6 col-xs-12">
		                  		<div class="form-group form-material floating" data-plugin="formMaterial">
				                	<input required type="text" class="form-control" name="nombre" value="{{$centro->nombre}}" />
				                    <label class="floating-label">Nombre del Centro</label>
				                </div>
			              	</div>
			              	<div class="col-lg-6 col-xs-12">
		                  		<div class="form-group form-material floating" data-plugin="formMaterial">
				                	<input required type="text" class="form-control" name="direccion" value="{{$centro->direccion}}"/>
				                    <label class="floating-label">Direccion del Centro</label>
				                </div>
			              	</div>
			              	<div class="col-lg-6 col-xs-12">
		                  		<div class="form-group" data-plugin="formMaterial">
				                	<label class="floating-label">Red</label>
				                	<select name="id_red" class="form-control">
					                    @foreach($redes as $var)
						                    @if($var->nombre == $centro->nombreRed)
						                      <option value="{{$var->id}}" selected>{{$var->nombre}}</option>
						                    @else
						                      <option value="{{$var->id}}">{{$var->nombre}}</option>
						                    @endif
						                @endforeach
				              		</select>
				                </div>
			              	</div>
			              	<div class="col-lg-6 col-xs-12">
		                  		<div class="form-group" data-plugin="formMaterial">
				                	<label class="floating-label">Tipo Servicio</label>
				                	<select name="id_tipo_servicio" class="form-control">
					                    @foreach($tiposervicios as $var)
						                    @if($var->nombre == $centro->nombreServicio)
						                      <option value="{{$var->id}}" selected>{{$var->nombre}}</option>
						                    @else
						                      <option value="{{$var->id}}">{{$var->nombre}}</option>
						                    @endif
						                @endforeach
				              		</select>
				                </div>
			              	</div>
			              	<div class="col-lg-6 col-xs-12">
		                  		<div class="form-group" data-plugin="formMaterial">
				                	<label class="floating-label">Zona</label>
				                	<select name="id_zona" class="form-control">
					                    @foreach($zonas as $var)
						                    @if($var->nombre == $centro->nombreZona)
						                      <option value="{{$var->id}}" selected>{{$var->nombre}}</option>
						                    @else
						                      <option value="{{$var->id}}">{{$var->nombre}}</option>
						                    @endif
						                @endforeach
				              		</select>
				                </div>
			              	</div>
			              	<div class="col-lg-6 col-xs-12">
		                  		<div class="form-group" data-plugin="formMaterial">
				                	<label class="floating-label">Nivel</label>
				                	<select name="id_nivel" class="form-control">
					                    @foreach($niveles as $var)
						                    @if($var->nombre == $centro->nombreNivel)
						                      <option value="{{$var->id}}" selected>{{$var->nombre}}</option>
						                    @else
						                      <option value="{{$var->id}}">{{$var->nombre}}</option>
						                    @endif
						                @endforeach
				              		</select>
				                </div>
			              	</div>
			              	<div class="col-lg-6 col-xs-12">
		                  		<div class="form-group form-material floating" data-plugin="formMaterial">
				                	<input required value="{{$centro->latitud}}" name="latitud" type="number" class="form-control">
				                    <label class="floating-label">Latitud</label>
				                </div>
			              	</div>
			              	<div class="col-lg-6 col-xs-12">
		                  		<div class="form-group form-material floating" data-plugin="formMaterial">
				                	<input required value="{{$centro->longitud}}" name="longitud" type="number" class="form-control">
				                    <label class="floating-label">Longitud</label>
				                </div>
			              	</div>
			              	<div class="col-lg-6 col-xs-12">
		                  		<div class="form-group form-material floating" data-plugin="formMaterial">
				                	<input required value="{{$centro->distrito}}" name="distrito" type="text" class="form-control">
				                    <label class="floating-label">Distrito</label>
				                </div>
			              	</div>
			              	<div class="col-lg-6 col-xs-12">
		                  		<div class="form-group form-material floating" data-plugin="formMaterial">
				                	<input required value="{{$centro->uv}}" name="uv" type="text" class="form-control">
				                    <label class="floating-label">UV</label>
				                </div>
			              	</div>
			              	<div class="col-lg-4 col-xs-12">
		                  		<div class="form-group form-material floating" data-plugin="formMaterial">
				                	<input required value="{{$centro->manzano}}" name="manzano" type="text" class="form-control">
				                    <label class="floating-label">Manzano</label>
				                </div>
			              	</div>
			              	<div class="col-lg-4 col-xs-12">
		                  		<div class="form-group form-material floating" data-plugin="formMaterial">
				                	<input required value="{{$centro->horas_atencion}}" name="horas_atencion" type="text" class="form-control">
				                    <label class="floating-label">Horas Atencion</label>
				                </div>
			              	</div>
			              	<div class="col-lg-4 col-xs-12">
		                  		<div class="form-group form-material floating" data-plugin="formMaterial">
				                	<input required value="{{$centro->telefono}}" name="telefono" type="number" class="form-control">
				                    <label class="floating-label">telefono</label>
				                </div>
			              	</div>
			              	<div class="col-sm-8 col-sm-offset-2">
		                  		<div class="example-wrap">
				                  	<div class="example">
				                  		<label class="floating-label">Imagen</label>
				                    	<input type="file" name="imagen" data-plugin="dropify" data-default-file="{{asset('images/Centros/'.$centro->imagen)}}"
				                    />
				                  	</div>
				                </div>
			              	</div>
		              	</div>
		              	<br>
		              	<div class="col-sm-8 col-sm-offset-2" id="guardar">
		              		<button type="submit" class="btn btn-primary btn-block btn-round" data-style="slide-right" data-plugin="ladda">
		              			<span class="ladda-label">Editar Centro Medico<i class="icon md-long-arrow-right ml-10" aria-hidden="true"></i></span>
		              		</button>
		              	</div>
		            {!! Form::close() !!}
			    </div>
			</div>
		</div>
	</div>
</div>
@include('admCentros.alertas.logrado')
@push ('scripts')
<script src="{{asset('global/vendor/jquery-ui/jquery-ui.js')}}"></script>
<script src="{{asset('global/vendor/blueimp-tmpl/tmpl.js')}}"></script>
<script src="{{asset('global/vendor/blueimp-canvas-to-blob/canvas-to-blob.js')}}"></script>
<script src="{{asset('global/vendor/blueimp-load-image/load-image.all.min.js')}}"></script>
<script src="{{asset('global/vendor/blueimp-file-upload/jquery.fileupload.js')}}"></script>
<script src="{{asset('global/vendor/blueimp-file-upload/jquery.fileupload-process.js')}}"></script>
<script src="{{asset('global/vendor/blueimp-file-upload/jquery.fileupload-image.js')}}"></script>
<script src="{{asset('global/vendor/blueimp-file-upload/jquery.fileupload-audio.js')}}"></script>
<script src="{{asset('global/vendor/blueimp-file-upload/jquery.fileupload-video.js')}}"></script>
<script src="{{asset('global/vendor/blueimp-file-upload/jquery.fileupload-validate.js')}}"></script>
<script src="{{asset('global/vendor/blueimp-file-upload/jquery.fileupload-ui.js')}}"></script>
<script src="{{asset('global/vendor/dropify/dropify.min.js')}}"></script>
<script src="{{asset('global/js/Plugin/dropify.js')}}"></script>
<script src="{{asset('base/assets/examples/js/forms/uploads.js')}}"></script>
<script>
function validaNumericos(event) {
    if(event.charCode >= 48 && event.charCode <= 57){
      return true;
     }
     return false;        
}

function calcular() {
  var camas_total = document.getElementById('camas_total').value;
  var camas_ocupadas = document.getElementById('camas_ocupadas').value;

  var camas_libres = camas_total - camas_ocupadas;
  if (camas_libres < 0) {
    document.getElementById("camas_libres").value = 0;
    document.getElementById('letra_camas_libres').innerText = 'CAMAS LIBRES: (' + camas_libres +')';
  }else{
    document.getElementById('letra_camas_libres').innerText = 'CAMAS LIBRES:';
    document.getElementById("camas_libres").value = camas_libres;
  }
  
  console.log(camas_total);
}
</script>
@endpush
@endsection