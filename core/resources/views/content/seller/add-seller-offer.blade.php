	<link rel="stylesheet" href="{{ asset('assets/examples/css/pages/profile.css') }}">
	<div class="page">
	    <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Offer</li>
                <li class="breadcrumb-item active">{{ $path_name }}</li>
                <li class="breadcrumb-item active">Add</li>
            </ol>
        </div>
      	<div class="page-content container-fluid">
        	<div class="row">
	          	<div class="col-lg-12">
	            	<div class="panel">
	              		<div class="panel-body">
	              			<form autocomplete="off">
	              			    @if($param == 'seller-off')
	              			    <div class="row">
			                        <div class="form-group form-material col-md-6">
			                          	<label class="form-control-label" for="grade_code">Price</label>
			                          	<input type="number" class="form-control" id="harga" />
			                        </div>
			                        <div class="form-group form-material col-md-6">
			                          <label class="form-control-label" for="grade_desc">Down Payment</label>
			                          <input type="number" class="form-control" id="dp"/>
			                        </div>
		                      	</div>
	              			    <div class="row">
			                        <div class="form-group form-material col-md-12">
			                          	<label class="form-control-label" for="grade_code">Notes</label>
			                          	<input type="text" class="form-control" id="notes" />
			                        </div>
		                      	</div>
	              			    @endif
		                      	<div class="form-group form-material">
		                      	    @if($param == 'seller-off')
		                      	        <a href="{{ route('seller-off') }}" class="btn btn-icon btn-danger">Cancel</a>
		                        	    <button type="button" id="edit_data" class="btn btn-primary">Add Offer</button>
		                      	    @endif
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
            document.getElementById("edit_data").disabled = true;
    		$.post("{{ route('add-offers') }}", {
                harga   : $('#harga').val(),
                dp      : $('#dp').val(),
                notes  	: $('#notes').val(),
                param   : "{{ $param }}",
                _token  : '{{ csrf_token() }}'
            },
            function(data, status){
                if(data) {
                    var datanotif = JSON.parse(data);
                    if(datanotif.rc == '00'){  
                		swal("Success!", datanotif.rcdesc, "success");
                		window.location.replace(datanotif.route);
              		} else {
                		swal("Error!", datanotif.rcdesc, "error");
                        document.getElementById("edit_data").disabled = false;
              		}
                }
            });
    	});
    </script>