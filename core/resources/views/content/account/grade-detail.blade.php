	<link rel="stylesheet" href="{{ asset('assets/examples/css/pages/profile.css') }}">
	<div class="page">
	    <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Account</li>
                <li class="breadcrumb-item active">Grade Detail</li>
            </ol>
        </div>
      	<div class="page-content container-fluid">
        	<div class="row">
	          	<div class="col-lg-12">
	            	<div class="panel">
	              		<div class="panel-body">
	              			<form autocomplete="off">
		                      	<div class="row">
			                        <div class="form-group form-material col-md-6">
			                          	<label class="form-control-label" for="name">Grade Code</label>
			                          	<input type="text" class="form-control" id="grade_code" name="grade_code" value="{{ $detail_data->grade_code }}" />
			                          	<input type="hidden" class="form-control" id="id_grade" name="id_grade" value="{{ $detail_data->id }}" />
			                        </div>
			                        <div class="form-group form-material col-md-6">
			                          <label class="form-control-label" for="email">Detail Grade</label>
			                          <input type="text" class="form-control" id="grade_desc" name="grade_desc" value="{{ $detail_data->grade_desc }}" />
			                        </div>
		                      	</div>
		                      	<div class="form-group form-material">
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
    		$.post("{{ route('api-update-data-grade') }}", {
                grade_code  		: $('#grade_code').val(),
                id_grade  		: $('#id_grade').val(),
                grade_desc  	: $('#grade_desc').val(),
                _token    	: '{{ Session::token() }}'
            },
            function(data, status){
                if(data) {
                    var datanotif = JSON.parse(data);
                    if(datanotif.rc == '00'){  
                        swal("Success!", datanotif.rcdesc, "success");
                  		window.location.replace("{{ route('user-grade') }}");
              		} else {
                		swal("Error!", datanotif.rcdesc, "error");
              		}
                }
            });
    	});
    </script>