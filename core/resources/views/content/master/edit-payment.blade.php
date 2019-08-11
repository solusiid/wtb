	<link rel="stylesheet" href="{{ asset('assets/examples/css/pages/profile.css') }}">
	<div class="page">
	    <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Master</li>
                <li class="breadcrumb-item active">{{ $page_name }}</li>
            </ol>
        </div>
      	<div class="page-content container-fluid">
        	<div class="row">
	          	<div class="col-lg-12">
	            	<div class="panel">
	              		<div class="panel-body">
	              			<form autocomplete="off">
		                      	<div class="row">
			                        <div class="form-group form-material col-md-6" style="display: none">
			                          	<label class="form-control-label" for="name">Parent</label>
			                          	<input type="text" class="form-control" id="id" name="id" value="{{ $data_tenor->id }}" readonly/>
			                        </div>
			                        <div class="form-group form-material col-md-12">
			                          <label class="form-control-label" for="email">Payment</label>
			                          <input type="text" class="form-control" id="payment_name" name="payment_name" value="{{ $data_tenor->payment_name }}"  />
			                        </div>
		                      	</div>
		                      	<div class="form-group form-material">
		                        	<a href="{{ route('tenor-item') }}" type="button" class="btn btn-danger">BACK</a>
		                        	<button type="button" id="edit_data" class="btn btn-primary">Edit Data</button>
		                      	</div>
		                    </form>
	              		</div>
	            	</div>
	          	</div>
        	</div>
      	</div>
    </div>
	<script src="{{ asset('global/js/Plugin/responsive-tabs.js') }}"></script>
    <script src="{{ asset('global/js/Plugin/tabs.js') }}"></script>
    <script>
    	$('#edit_data').click(function(){
    		$.post("{{ route('updatepayment') }}", {
                id  		: $('#id').val(),
                payment_name  		: $('#payment_name').val(),
                _token    	: '{{ Session::token() }}'
            },
            function(data, status){
                if(data) {
                    var datanotif = JSON.parse(data);
                    if(datanotif.rc == '00'){      
                		swal("Success!", datanotif.rcdesc, "success");  
                  		window.location.replace(datanotif.url);
              		} else {
                		swal("Error!", datanotif.rcdesc, "error");
              		}
                }
            });
    	});
    </script>