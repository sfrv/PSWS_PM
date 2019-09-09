@if(Session::has('msj'))
  <div class="toast-example" id="exampleToastrInfoShadow" aria-live="assertive" data-plugin="toastr"
  data-message="&lt;strong&gt;{{Session::get('msj')}}&lt;/strong&gt;!"
  data-container-id="toast-top-right" data-position-class="toast-top-right"
  data-icon-class="toast-just-text toast-success" role="alert">
  <div hidden id="iniciar" class="toast toast-just-text toast-success">
  </div>
</div>

<script>
	setTimeout(clickb,300);
	function clickb() {
		var obj=document.getElementById('iniciar');
		obj.click();
	}
</script>
@endif

@if(Session::has('msj_e'))
  <div class="toast-example" id="exampleToastrInfoShadow" aria-live="assertive" data-plugin="toastr"
  data-message="&lt;strong&gt;{{Session::get('msj_e')}}&lt;/strong&gt;!"
  data-container-id="toast-top-right" data-position-class="toast-top-right"
  data-icon-class="toast-just-text toast-error" role="alert">
  <div hidden id="iniciar2" class="toast toast-just-text toast-error">
  </div>
</div>

<script>
	setTimeout(clickb,300);
	function clickb() {
		var obj=document.getElementById('iniciar2');
		obj.click();
	}
</script>
@endif