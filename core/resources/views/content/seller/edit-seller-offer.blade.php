	<link rel="stylesheet" href="{{ asset('assets/examples/css/pages/profile.css') }}">
	<div class="page">
	    <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Offer</li>
                <li class="breadcrumb-item active">{{ $path_name }}</li>
                <li class="breadcrumb-item active">Detail</li>
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
			                          	<input type="number" class="form-control" id="harga"  value="{{ $offer_data->price }}"/>
			                        </div>
			                        <div class="form-group form-material col-md-6">
			                          <label class="form-control-label" for="grade_desc">Down Payment</label>
			                          <input type="number" class="form-control" id="dp" value="{{ $offer_data->downpayment }}"/>
			                        </div>
		                      	</div>
	              			    <div class="row">
			                        <div class="form-group form-material col-md-6">
			                          	<label class="form-control-label" for="grade_code">Notes</label>
			                          	<input type="text" class="form-control" id="notes"  value="{{ $offer_data->detail_sender }}"/>
			                        </div>
			                        <div class="form-group form-material col-md-6">
			                          	<label class="form-control-label" for="grade_code">No Offers</label>
			                          	<input type="text" class="form-control" id="no_offers" value="{{ $offer_data->no_offers }}" readonly/>
			                        </div>
		                      	</div>
	              			    @endif
		                      	<div class="form-group form-material">
		                      	    @if($param == 'seller-off')
		                      	        <a href="{{ route('seller-off') }}" class="btn btn-icon btn-danger">Cancel</a>
		                        	    <button type="button" id="edit_data" class="btn btn-primary">Edit Offer</button>
		                        	    <button type="button" id="delete_data" class="btn btn-primary">Cancel Offer</button>
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
    		$.post("{{ route('edit-offers') }}", {
                harga   : $('#harga').val(),
                dp      : $('#dp').val(),
                notes  	: $('#notes').val(),
                no_offers : $('#no_offers').val(),
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
    	
    	$('#delete_data').click(function(){
    	    document.getElementById("delete_data").disabled = true;
    		$.post("{{ route('del-offers') }}", {
                no_offers   : $('#no_offers').val(),
                _token      : '{{ csrf_token() }}'
            },
            function(data, status){
                if(data) {
                    var datanotif = JSON.parse(data);
                    if(datanotif.rc == '00'){  
                		swal("Success!", datanotif.rcdesc, "success");
                		window.location.replace(datanotif.route);
              		} else {
                		swal("Error!", datanotif.rcdesc, "error");
                        document.getElementById("delete_data").disabled = false;
              		}
                }
            });
    	})
    </script>