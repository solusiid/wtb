	<link rel="stylesheet" href="{{ asset('assets/examples/css/pages/profile.css') }}">
	<div class="page">
      	<div class="page-content container-fluid">
        	<div class="row">
	          	<div class="col-lg-6">
	            	<div class="panel">
	              		<div class="panel-body">
	              			<form autocomplete="off">
		                      	<div class="row">
			                        <div class="form-group form-material col-md-6">
			                          	<label class="form-control-label" for="name">Name</label>
			                          	<input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name }}" />
			                        </div>
			                        <div class="form-group form-material col-md-6">
			                          <label class="form-control-label" for="email">Email</label>
			                          <input type="text" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}" readonly />
			                        </div>
		                      	</div>
		                      	<div class="row">
			                        <div class="form-group form-material col-md-6">
			                          	<label class="form-control-label" for="phoneno">Phone No</label>
			                          	<input type="text" class="form-control" id="phoneno" name="phoneno" value="{{ Auth::user()->phone_no }}" readonly />
			                        </div>
			                        <div class="form-group form-material col-md-6">
			                          <label class="form-control-label" for="password">Password</label>
			                          <input type="password" class="form-control" id="password" name="password" placeholder="Password" />
			                        </div>
		                      	</div>
		                      	<div class="form-group form-material">
		                        	<label class="form-control-label" for="alamat">Address</label>
		                        	<textarea class="form-control" id="alamat" name="alamat">{{ Auth::user()->address }}</textarea>
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
	          	<div class="col-lg-6">
	            	<div class="panel">
	              		<div class="panel-body">
	              			<form autocomplete="off">
		                      	<div class="row">
			                        <div class="form-group form-material col-md-6">
			                          	<label class="form-control-label" for="name">Name</label>
			                          	<input type="text" class="form-control" id="name1" name="name" />
			                        </div>
			                        <div class="form-group form-material col-md-6">
			                          <label class="form-control-label" for="email">Email</label>
			                          <input type="text" class="form-control" id="email1" name="email"/>
			                        </div>
		                      	</div>
		                      	<div class="row">
			                        <div class="form-group form-material col-md-6">
			                          	<label class="form-control-label" for="phoneno">Phone No</label>
			                          	<input type="text" class="form-control" id="phoneno1" name="phoneno" />
			                        </div>
			                        <div class="form-group form-material col-md-6">
			                          <label class="form-control-label" for="password">Password</label>
			                          <input type="password" class="form-control" id="password1" name="password" placeholder="Password" />
			                        </div>
		                      	</div>
		                      	<div class="form-group form-material">
		                        	<label class="form-control-label" for="alamat">Address</label>
		                        	<textarea class="form-control" id="alamat1" name="alamat1"></textarea>
		                      	</div>
		                      	<div class="form-group form-material">
		                        	<button type="button" id="add_seller" class="btn btn-primary">Add New Seller</button>
		                      	</div>
		                    </form>
	              		</div>
	            	</div>
	          	</div>
        	</div>
            <div class="panel">
                <header class="panel-heading">
                    <div class="panel-actions"></div>
                    <h3 class="panel-title">Seller WTB</h3>
                </header>
                <div class="panel-body">
                    <table class="table table-hover dataTable table-striped w-full" id="datalist">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Join Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
      	</div>
    </div>
	<script src="{{ asset('global/js/Plugin/responsive-tabs.js') }}"></script>
    <script src="{{ asset('global/js/Plugin/tabs.js') }}"></script>
    <script>
    	$('#edit_data').click(function(){
    		$.post("{{ route('api-update-data') }}", {
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
                    	swal("Success!", datanotif.rcdesc	, "uccess");
              		} else {
                		swal("Error!", datanotif.messages, "error");
              		}
                }
            });
    	});

    	$('#add_seller').click(function(){
    		$.post("{{ route('api-add-seller') }}", {
                name  		: $('#name1').val(),
                email  		: $('#email1').val(),
                password  	: $('#password1').val(),
                alamat  	: $('#alamat1').val(),
                phoneno 	: $('#phoneno1').val(),
                _token    	: '{{ Session::token() }}'
            },
            function(data, status){
                if(data) {
                    var datanotif = JSON.parse(data);
                    if(datanotif.rc == '00'){        
                		swal("Success!", datanotif.rcdesc, "success");
                    	objTable.data.ajax.reload();
              		} else {
                		swal("Error!", datanotif.rcdesc, "error");
              		}
                }
            });
    	});

    	var objTable = {};
        $(document).ready(function () {
            objTable.data = $('#datalist').DataTable({
                "dom": 'frtip',
                "pageLength" : 10,
                "scrollX" : true,
                "ajax": {
                    "url": "{{ route('api-list-seller-by') }}",
                    "dataSrc": ""
                },
                "columns": [
                    { "data" : "id"},
                    { "data" : "name"},
                    { "data" : "email"},
                    { "data" : "create_at"},
                    {
                        mRender: function (data, type, row) {
                            return '<button class="btn btn-icon btn-light btn-xs" onclick="editIt(' +row.id+ ')">View</button>' +
                            '<button class="btn btn-icon btn-light btn-xs" onclick="deleteIt(' +row.id+ ')">Delete</button>'; 
                        }
                    }
                ]
            });
        });
        
        function editIt(id) {
            var link = "{{ route('account-detail', [':param', ':id']) }}";
	        link = link.replace(':id', id);
	        link = link.replace(':param', 'seller');
            window.location.replace(link);
        }

        function deleteIt(id) {
            $.post("{{ route('api-delete-user') }}", {
                id      : id,
                _token  : '{{ Session::token() }}'
            },
            function(data, status){
                if(data) {
                    var datanotif = JSON.parse(data);
                    if(datanotif.rc == '00'){        
                        swal("Success!", datanotif.rcdesc, "success");
                        objTable.data.ajax.reload();
                        $("#payment").val("");
                    } else {
                        swal("Error!", datanotif.rcdesc, "error");
                    }
                }
            });
        }
    </script>