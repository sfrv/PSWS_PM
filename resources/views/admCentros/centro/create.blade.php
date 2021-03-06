@extends('layouts.admin')
@section('contenido')
<div class="panel">
	<div class="panel-body container-fluid">
		<div class="row row-lg">
			<div class="col-lg-12">
			    <div class="example-wrap">
			      	<h4>Registrar Nuevo Centro Medico</h4>
			      	<br>
			      	{!!Form::open(array('url'=>'adm/centro','method'=>'POST','autocomplete'=>'off','files' => true))!!}
  			    	{{Form::token()}}
		              	<div class="row">
			              	<div class="col-lg-6 col-xs-12">
		                  		<div class="form-group form-material floating" data-plugin="formMaterial">
				                	<input required type="text" class="form-control" name="nombre"/>
				                    <label class="floating-label">Nombre del Centro</label>
				                </div>
			              	</div>
			              	<div class="col-lg-6 col-xs-12">
		                  		<div class="form-group form-material floating" data-plugin="formMaterial">
				                	<input required type="text" class="form-control" name="direccion" />
				                    <label class="floating-label">Direccion del Centro</label>
				                </div>
			              	</div>
			              	<div class="col-lg-6 col-xs-12">
		                  		<div class="form-group" data-plugin="formMaterial">
				                	<label class="floating-label">Red</label>
				                	<select name="id_red" class="form-control">
					                    @foreach($redes as $var)
					    	               <option value="{{$var->id}}">{{$var->nombre}}</option>
					    	            @endforeach
				              		</select>
				                </div>
			              	</div>
			              	<div class="col-lg-6 col-xs-12">
		                  		<div class="form-group" data-plugin="formMaterial">
				                	<label class="floating-label">Tipo Servicio</label>
				                	<select name="id_tipo_servicio" class="form-control">
					                    @foreach($tiposervicios as $var)
					    	               <option value="{{$var->id}}">{{$var->nombre}}</option>
					    	            @endforeach
				              		</select>
				                </div>
			              	</div>
			              	<div class="col-lg-6 col-xs-12">
		                  		<div class="form-group" data-plugin="formMaterial">
				                	<label class="floating-label">Zona</label>
				                	<select name="id_zona" class="form-control">
					                    @foreach($zonas as $var)
					    	               <option value="{{$var->id}}">{{$var->nombre}}</option>
					    	            @endforeach
				              		</select>
				                </div>
			              	</div>
			              	<div class="col-lg-6 col-xs-12">
		                  		<div class="form-group" data-plugin="formMaterial">
				                	<label class="floating-label">Nivel</label>
				                	<select name="id_nivel" class="form-control">
					                    @foreach($niveles as $var)
					    	               <option value="{{$var->id}}">{{$var->nombre}}</option>
					    	            @endforeach
				              		</select>
				                </div>
			              	</div>
			              	<div hidden class="col-lg-6 col-xs-12">
		                  		<div class="form-group form-material floating" data-plugin="formMaterial">
				                	<input id="latitud" name="latitud" type="number" step="any" class="form-control">
				                    <label class="floating-label">Latitud</label>
				                </div>
			              	</div>
			              	<div hidden class="col-lg-6 col-xs-12">
		                  		<div class="form-group form-material floating" data-plugin="formMaterial">
				                	<input id="longitud" name="longitud" type="number" step="any" class="form-control">
				                    <label class="floating-label">Longitud</label>
				                </div>
			              	</div>
			              	<div class="col-lg-6 col-xs-12">
		                  		<div class="form-group form-material floating" data-plugin="formMaterial">
				                	<input required name="distrito" type="text" class="form-control">
				                    <label class="floating-label">Distrito</label>
				                </div>
			              	</div>
			              	<div class="col-lg-6 col-xs-12">
		                  		<div class="form-group form-material floating" data-plugin="formMaterial">
				                	<input required name="uv" type="text" class="form-control">
				                    <label class="floating-label">UV</label>
				                </div>
			              	</div>
			              	<div class="col-lg-4 col-xs-12">
		                  		<div class="form-group form-material floating" data-plugin="formMaterial">
				                	<input required name="manzano" type="text" class="form-control">
				                    <label class="floating-label">Manzano</label>
				                </div>
			              	</div>
			              	<div class="col-lg-4 col-xs-12">
		                  		<div class="form-group form-material floating" data-plugin="formMaterial">
				                	<input required name="horas_atencion" type="text" class="form-control">
				                    <label class="floating-label">Horas Atencion</label>
				                </div>
			              	</div>
			              	<div class="col-lg-4 col-xs-12">
		                  		<div class="form-group form-material floating" data-plugin="formMaterial">
				                	<input required name="telefono" type="number" class="form-control">
				                    <label class="floating-label">telefono</label>
				                </div>
			              	</div>
			              	<div class="col-sm-8 col-sm-offset-2">
		                  		<div class="example-wrap">
				                  	<div class="example">
				                  		<label class="floating-label">Imagen</label>
				                    	<input type="file" name="imagen" data-plugin="dropify" data-default-file=""
				                    />
				                  	</div>
				                </div>
			              	</div>
			              	<div class="col-sm-8 col-sm-offset-2">
		                  		<div class="example-wrap">
				                  	<div class="example">
				                  		<label class="floating-label">Ubicacion</label>
				                    	<div id="map" style="height: 250px;width: 100%"></div>
				                  	</div>
				                </div>
			              	</div>
			              	<br>
		              	</div>
		              	<br><br>
		              	<div class="col-sm-8 col-sm-offset-2" id="guardar">
		              		<button type="submit" class="btn btn-primary btn-block btn-round" data-style="slide-right" data-plugin="ladda">
		              			<span class="ladda-label">Registrar Centro Medico<i class="icon md-long-arrow-right ml-10" aria-hidden="true"></i></span>
		              		</button>
		              	</div>
		            {!! Form::close() !!}
			    </div>
			</div>
		</div>
	</div>
</div>
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

//AIzaSyCdA-O4tdOrCC7z0zb_1ifNpcx3l237VIY 01
//AIzaSyCdA-O4tdOrCC7z0zb_1ifNpcx3l237VIY
//AIzaSyCw7M5nqepqivSaf7HPEexb9sHB414GY3c
var infoWindow = null;
var map = null;
var marker = null;

function openInfoWindow(marker_l) {
    var markerLatLng = marker_l.getPosition();
    infoWindow.setContent([
        'La posicion del marcador es:',
        markerLatLng.lat(),
        ', ',
        markerLatLng.lng(),
        ' Arrastra y haz click para actualizar la posicion.'
    ].join(''));
    infoWindow.open(map, marker_l);
}

function iniciarMap(){
    var coord = {lat:-17.783297555038317
    	        ,lng:-63.18029759765625};
    map = new google.maps.Map(document.getElementById('map'),{
      zoom: 13,
      center: coord,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    marker = new google.maps.Marker({
      position: coord,
      draggable: true,
      map: map
    });

    infoWindow = new google.maps.InfoWindow();

    google.maps.event.addListener(marker, 'click', function(){
        openInfoWindow(marker);
    });

    google.maps.event.addListener(marker, "mouseup", function (e) { 
    	document.getElementById('latitud').value = marker.getPosition().lat();
        document.getElementById('longitud').value = marker.getPosition().lng();
    });
}



function validaNumericos(event) {
    if(event.charCode >= 48 && event.charCode <= 57){
      return true;
     }
     return false;        
}

// function calcular() {
//   var camas_total = document.getElementById('camas_total').value;
//   var camas_ocupadas = document.getElementById('camas_ocupadas').value;

//   var camas_libres = camas_total - camas_ocupadas;
//   if (camas_libres < 0) {
//     document.getElementById("camas_libres").value = 0;
//     document.getElementById('letra_camas_libres').innerText = 'CAMAS LIBRES: (' + camas_libres +')';
//   }else{
//     document.getElementById('letra_camas_libres').innerText = 'Camas Libres:';
//     document.getElementById("camas_libres").value = camas_libres;
//   }
  
//   // console.log(camas_total);
// }
</script>
<!-- <script src="https://maps.googleapis.com/maps/api/js?sensor=false&callback=iniciarMap"></script> -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBFVmAfeLqztTq_UehyrHBZYxMWliHzRq4&callback=iniciarMap"></script>
<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDr-cw-CFg8Gq4wJ1d-XRwZplIs9mBeRQA&callback=iniciarMap"></script> -->
@endpush
@endsection