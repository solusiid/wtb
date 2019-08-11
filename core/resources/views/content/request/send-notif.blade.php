	<link rel="stylesheet" href="{{ asset('assets/examples/css/pages/profile.css') }}">
	<div class="page">
	    <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Request</li>
                <li class="breadcrumb-item active">Send Notification</li>
            </ol>
        </div>
      	<div class="page-content container-fluid">
        	<div class="row">
	          	<div class="col-lg-12">
	            	<div class="panel">
	              		<div class="panel-body">
	              			<form autocomplete="off">
		                      	<div class="row">
			                        <div class="form-group form-material col-md-12">
			                          	<label class="form-control-label" for="grade_code">Title</label>
			                          	<input type="text" class="form-control" id="title" />
			                        </div>
		                      	</div>
	              			    <div class="row">
			                        <div class="form-group form-material col-md-12">
			                          <label class="form-control-label" for="grade_desc">Receiver</label>
			                          <select class="form-control" id="receiver" data-plugin="select2">
				                      		<option value="0"> All </option>
				                      		<option value="2"> Customer </option>
				                      		<option value="4"> Seller </option>
				                      	</select>
			                        </div>
		                      	</div>
	              			    <div class="row">
			                        <div class="form-group form-material col-md-12">
			                          	<label class="form-control-label" for="grade_code">Body</label>
			                          	<textarea class="form-control" id="body"></textarea>
			                        </div>
		                      	</div>
		                      	<div class="form-group form-material">
		                            <button type="button" id="edit_data" class="btn btn-primary">Send Notification</button>
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
    		$.post("{{ route('send-notif-now') }}", {
                title      : $('#title').val(),
                receiver      : $('#receiver').val(),
                body      : $('#body').val(),
                _token    	: '{{ csrf_token() }}'
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