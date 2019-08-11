	<link rel="stylesheet" href="{{ asset('assets/examples/css/pages/profile.css') }}">
	<div class="page">
      	<div class="page-content container-fluid">
        	<div class="row">
	          	<div class="col-lg-12">
	            	<div class="panel">
	              		<div class="panel-body">
	              			<form autocomplete="off">
		                      	<div class="row">
			                        <div class="form-group form-material col-md-6">
			                          	<label class="form-control-label" for="name">Invoice No</label>
			                          	<input type="text" class="form-control" id="invoice_no" name="invoice_no"/>
			                        </div>
			                        <div class="form-group form-material col-md-6">
			                          <label class="form-control-label" for="email">Amount</label>
			                          <input type="text" class="form-control" id="amount" name="amount" />
			                        </div>
		                      	</div>
		                      	<div class="row">
			                        <div class="form-group form-material col-md-6">
			                          	<label class="form-control-label" for="phoneno">Sender Name</label>
			                          	<input type="text" class="form-control" id="sender_name" name="sender_name" placeholder="eg. Budi Santoso"  />
			                        </div>
			                        <div class="form-group form-material col-md-6">
			                          <label class="form-control-label" for="password">Sender Bank</label>
			                          <input type="text" class="form-control" id="sender_bank" name="sender_bank" placeholder="eg. Bank BCA" />
			                        </div>
		                      	</div>
		                      	<div class="form-group form-material">
		                        	<button type="button" id="edit_data" class="btn btn-primary">Send Confirmation DP</button>
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
    		$.post("{{ route('api-confirm-dp') }}", {
                invoice_no		: $('#invoice_no').val(),
                amount  		: $('#amount').val(),
                sender_name  	: $('#sender_name').val(),
                sender_bank  	: $('#sender_bank').val(),
                _token    		: '{{ Session::token() }}'
            },
            function(data, status){
                if(data) {
                    var datanotif = JSON.parse(data);
                    if(datanotif.rc == '00'){        
                  		window.location.replace("{{ route('customer-off') }}");
              		} else {
                		swal("Error!", datanotif.messages, "error");
              		}
                }
            });
    	});
    </script>