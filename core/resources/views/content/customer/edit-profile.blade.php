	<link rel="stylesheet" href="{{ asset('assets/examples/css/pages/profile.css') }}">
	<div class="page">
	    <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Account</li>
                <li class="breadcrumb-item active">Account Detail</li>
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
			                          	<label class="form-control-label" for="name">Name</label>
			                          	<input type="text" class="form-control" id="name" name="name" value="{{ $detail_data->name }}" />
			                        </div>
			                        <div class="form-group form-material col-md-6">
			                          <label class="form-control-label" for="email">Email</label>
			                          <input type="text" class="form-control" id="email" name="email" value="{{ $detail_data->email }}" readonly />
			                        </div>
		                      	</div>
		                      	<div class="row">
			                        <div class="form-group form-material col-md-6">
			                          	<label class="form-control-label" for="phoneno">Phone No</label>
			                          	<input type="text" class="form-control" id="phoneno" name="phoneno" value="{{ $detail_data->phone_no }}" readonly />
			                        </div>
			                        <div class="form-group form-material col-md-6">
			                          <label class="form-control-label" for="password">Password</label>
			                          <input type="password" class="form-control" id="password" name="password" placeholder="Password" />
			                        </div>
		                      	</div>
		                      	<div class="form-group form-material">
		                        	<label class="form-control-label" for="alamat">Address</label>
		                        	<textarea class="form-control" id="alamat" name="alamat">{{ $detail_data->address }}</textarea>
		                      	</div>
		                      	@if(Auth::user()->id_grade == 5 || Auth::user()->id_grade == 7)
		                      	<div class="form-group form-material">
		                        	<label class="form-control-label" for="inputBasicPassword">Allow Email Notification ?</label>
		                        	<select class="form-control" id="notif_email">
				                      	<option value="1" {{ ( Auth::user()->notif_email == '1') ? 'selected' : '' }}>Allow</option>
				                      	<option value="0" {{ ( Auth::user()->notif_email == '0') ? 'selected' : '' }}>Not Allow</option>
				                    </select>

		                      	</div>
		                      	@endif
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
    		$.post("{{ route('api-update-data') }}", {
    		    id_user     : '{{ $id_user }}',
                name  		: $('#name').val(),
                email  		: $('#email').val(),
                password  	: $('#password').val(),
                alamat  	: $('#alamat').val(),
                notif_email	: $('#notif_email').val(),
                _token    	: '{{ Session::token() }}'
            },
            function(data, status){
                if(data) {
                    var datanotif = JSON.parse(data);
                    if(datanotif.rc == '00'){        
                		swal("Success!", datanotif.rcdesc, "success");
                  		window.location.replace("{{ route('account-seller', ['id' => Auth::user()->id]) }}");
              		} else {
                		swal("Error!", datanotif.rcdesc, "error");
              		}
                }
            });
    	});
    </script>