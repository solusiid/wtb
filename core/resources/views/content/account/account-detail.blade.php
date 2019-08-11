	<link rel="stylesheet" href="{{ asset('assets/examples/css/pages/profile.css') }}">
	<div class="page">
	    <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Account</li>
                <li class="breadcrumb-item active">{{ $path_name }}</li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </div>
      	<div class="page-content container-fluid">
        	<div class="row">
	          	<div class="col-lg-12">
	            	<div class="panel">
	              		<div class="panel-body">
	              			<form autocomplete="off">
	              			    @if($param == 'user-account')
		                      	<div class="row">
			                        <div class="form-group form-material col-md-6">
			                          	<label class="form-control-label" for="name">Name</label>
			                          	<input type="text" class="form-control" id="name" name="name" value="{{ $data_user->name }}" />
			                        </div>
			                        <div class="form-group form-material col-md-6">
			                          <label class="form-control-label" for="email">Email</label>
			                          <input type="text" class="form-control" id="email" name="email" value="{{ $data_user->email }}" readonly />
			                        </div>
		                      	</div>
		                      	<div class="row">
			                        <div class="form-group form-material col-md-6">
			                          	<label class="form-control-label" for="phoneno">Phone No</label>
			                          	<input type="text" class="form-control" id="phoneno" name="phoneno" value="{{ $data_user->phone_no }}" readonly />
			                        </div>
			                        <div class="form-group form-material col-md-6">
			                          <label class="form-control-label" for="password">Password</label>
			                          <input type="password" class="form-control" id="password" name="password" placeholder="Password" />
			                        </div>
		                      	</div>
		                      	<div class="row">
			                        <div class="form-group form-material col-md-6">
			                          	<label class="form-control-label" for="alamat">Address (optional)</label>
		                        	    <textarea class="form-control" id="alamat" name="alamat">{{ $data_user->address }}</textarea>
			                        </div>
			                        <div class="form-group form-material col-md-6">
			                          <label class="form-control-label" for="grade_desc">User Level</label>
			                          <select class="form-control" id="user_level_id" data-plugin="select2">
				                      		@foreach($user_level as $value)
				                      		    @if($value->id == $data_user->access_grade)
				                      		    <option value="{{ $value->id }}" selected> {{ $value->grade_desc }} </option>
				                      		    @else
				                      		    <option value="{{ $value->id }}"> {{ $value->grade_desc }} </option>
				                      		    @endif
				                      		@endforeach
				                      	</select>
			                        </div>
		                      	</div>
		                      	@elseif($param == 'user-grade')
	              			    <div class="row">
			                        <div class="form-group form-material col-md-6">
			                          	<label class="form-control-label" for="grade_code">Code User Level</label>
			                          	<input type="text" class="form-control" id="grade_code" value="{{ $data_user_level->grade_code }}" />
			                        </div>
			                        <div class="form-group form-material col-md-6">
			                          <label class="form-control-label" for="grade_desc">User Level</label>
			                          <input type="text" class="form-control" id="grade_desc" value="{{ $data_user_level->grade_desc }}"/>
			                        </div>
		                      	</div>
		                      	<div class="row">
		                      	    <div class="form-group form-material col-md-3">
		                      	        <label class="form-control-label" for="alamat">Access Menu Master</label><br>
    		                      	    @foreach($user_level as $value)
    		                      	    <input type="checkbox" name="scripts" id="scripts" value="{{ $value->id }}"> {{ $value->menu_param }}<br>
    		                      	    @endforeach
		                      	    </div>
		                      	    <div class="form-group form-material col-md-3">
		                      	        <label class="form-control-label" for="alamat">Access Menu Account</label><br>
    		                      	    @foreach($user_level1 as $value)
    		                      	    <input type="checkbox" name="scripts1" id="scripts1" value="{{ $value->id }}"> {{ $value->menu_param }}<br>
    		                      	    @endforeach
		                      	    </div>
		                      	    <div class="form-group form-material col-md-3">
		                      	        <label class="form-control-label" for="alamat">Access Menu Request</label><br>
    		                      	    @foreach($user_level2 as $value)
    		                      	    <input type="checkbox" name="scripts2" id="scripts2" value="{{ $value->id }}"> {{ $value->menu_param }}<br>
    		                      	    @endforeach
		                      	    </div>
		                      	    <div class="form-group form-material col-md-3">
		                      	        <label class="form-control-label" for="alamat">Access Menu System</label><br>
    		                      	    @foreach($user_level3 as $value)
    		                      	    <input type="checkbox" name="scripts3" id="scripts3" value="{{ $value->id }}"> {{ $value->menu_param }}<br>
    		                      	    @endforeach
		                      	    </div>
		                      	</div>
		                      	@elseif($param == 'cutomer')
		                      	<div class="row">
			                        <div class="form-group form-material col-md-6">
			                          	<label class="form-control-label" for="name">Name</label>
			                          	<input type="text" class="form-control" id="name" name="name" value="{{ $data_user->name }}" />
			                        </div>
			                        <div class="form-group form-material col-md-6">
			                          <label class="form-control-label" for="email">Email</label>
			                          <input type="text" class="form-control" id="email" name="email" value="{{ $data_user->email }}" readonly />
			                        </div>
		                      	</div>
		                      	<div class="row">
			                        <div class="form-group form-material col-md-6">
			                          	<label class="form-control-label" for="phoneno">Phone No</label>
			                          	<input type="text" class="form-control" id="phoneno" name="phoneno" value="{{ $data_user->phone_no }}" readonly />
			                        </div>
			                        <div class="form-group form-material col-md-6">
			                          <label class="form-control-label" for="password">Password</label>
			                          <input type="password" class="form-control" id="password" name="password" placeholder="Password" />
			                        </div>
		                      	</div>
		                      	<div class="row">
			                        <div class="form-group form-material col-md-6">
			                          	<label class="form-control-label" for="alamat">Address (optional)</label>
		                        	    <textarea class="form-control" id="alamat" name="alamat">{{ $data_user->address }}</textarea>
			                        </div>
			                        <div class="form-group form-material col-md-6">
			                            <label class="form-control-label" for="inputBasicPassword">Allow Email Notification ?</label>
    		                            <select class="form-control" id="notif_email">
    				                      	<option value="1" {{ ( $data_user->notif_email == '1') ? 'selected' : '' }}>Allow</option>
    				                      	<option value="0" {{ ( $data_user->notif_email == '0') ? 'selected' : '' }}>Not Allow</option>
    				                    </select>
			                        </div>
		                      	</div>
		                      	@elseif($param == 'seller-adm')
		                      	<div class="row">
			                        <div class="form-group form-material col-md-6">
			                          	<label class="form-control-label" for="name">Name</label>
			                          	<input type="text" class="form-control" id="name" name="name" value="{{ $data_user->name }}" />
			                        </div>
			                        <div class="form-group form-material col-md-6">
			                          <label class="form-control-label" for="email">Email</label>
			                          <input type="text" class="form-control" id="email" name="email" value="{{ $data_user->email }}" readonly />
			                        </div>
		                      	</div>
		                      	<div class="row">
			                        <div class="form-group form-material col-md-6">
			                          	<label class="form-control-label" for="phoneno">Phone No</label>
			                          	<input type="text" class="form-control" id="phoneno" name="phoneno" value="{{ $data_user->phone_no }}" readonly />
			                        </div>
			                        <div class="form-group form-material col-md-6">
			                          <label class="form-control-label" for="password">Password</label>
			                          <input type="password" class="form-control" id="password" name="password" placeholder="Password" />
			                        </div>
		                      	</div>
		                      	<div class="row">
			                        <div class="form-group form-material col-md-6">
			                          	<label class="form-control-label" for="alamat">Address (optional)</label>
		                        	    <textarea class="form-control" id="alamat" name="alamat">{{ $data_user->address }}</textarea>
			                        </div>
		                      	</div>
		                      	@elseif($param == 'seller')
		                      	<div class="row">
			                        <div class="form-group form-material col-md-6">
			                          	<label class="form-control-label" for="name">Name</label>
			                          	<input type="text" class="form-control" id="name" name="name" value="{{ $data_user->name }}" />
			                        </div>
			                        <div class="form-group form-material col-md-6">
			                          <label class="form-control-label" for="email">Email</label>
			                          <input type="text" class="form-control" id="email" name="email" value="{{ $data_user->email }}" readonly />
			                        </div>
		                      	</div>
		                      	<div class="row">
			                        <div class="form-group form-material col-md-6">
			                          	<label class="form-control-label" for="phoneno">Phone No</label>
			                          	<input type="text" class="form-control" id="phoneno" name="phoneno" value="{{ $data_user->phone_no }}" readonly />
			                        </div>
			                        <div class="form-group form-material col-md-6">
			                          <label class="form-control-label" for="password">Password</label>
			                          <input type="password" class="form-control" id="password" name="password" placeholder="Password" />
			                        </div>
		                      	</div>
		                      	<div class="row">
			                        <div class="form-group form-material col-md-6">
			                          	<label class="form-control-label" for="alamat">Address (optional)</label>
		                        	    <textarea class="form-control" id="alamat" name="alamat">{{ $data_user->address }}</textarea>
			                        </div>
			                        <div class="form-group form-material col-md-6">
			                          <label class="form-control-label" for="grade_desc">Seller Admin</label>
			                          <select class="form-control" id="seller_adm_id" data-plugin="select2">
				                      		@foreach($seller_adm as $value)
				                      		@if($value->id == $data_user->id_seller_adm)
				                      		<option value="{{ $value->id }}" selected> {{ $value->name }} </option>
				                      		@else
				                      		<option value="{{ $value->id }}"> {{ $value->name }} </option>
				                      		@endif
				                      		@endforeach
				                      	</select>
			                        </div>
		                      	</div>
		                      	@endif
		                      	<div class="form-group form-material">
		                      	    @if($param == 'user-grade')
		                      	        <a href="{{ route('user-grade') }}" class="btn btn-icon btn-danger">Cancel</a>
		                        	    <button type="button" id="edit_data" class="btn btn-primary">Edit User Level</button>
		                      	    @elseif($param == 'user-account')
		                      	        <a href="{{ route('user-account') }}" class="btn btn-icon btn-danger">Cancel</a>
		                        	    <button type="button" id="edit_data" class="btn btn-primary">Edit User Account</button>
		                      	    @elseif($param == 'cutomer')
		                      	        <a href="{{ route('cutomer') }}" class="btn btn-icon btn-danger">Cancel</a>
		                        	    <button type="button" id="edit_data" class="btn btn-primary">Edit Customer</button>
		                      	    @elseif($param == 'seller-adm')
		                      	        <a href="{{ route('seller-adm') }}" class="btn btn-icon btn-danger">Cancel</a>
		                        	    <button type="button" id="edit_data" class="btn btn-primary">Edit Seller Admin</button>
		                      	    @elseif($param == 'seller')
		                      	        <a href="{{ route('seller') }}" class="btn btn-icon btn-danger">Cancel</a>
		                        	    <button type="button" id="edit_data" class="btn btn-primary">Edit Seller</button>
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
        function get_menu_master(){ 
            var ch_list=Array(); 
            $("input:checkbox[name=scripts]:checked").each(function(){
                ch_list.push($(this).val());
            }); 
            return ch_list; 
        }
        function get_menu_account(){ 
            var ch_list=Array(); 
            $("input:checkbox[name=scripts1]:checked").each(function(){
                ch_list.push($(this).val());
            }); 
            return ch_list; 
        }
        function get_menu_request(){ 
            var ch_list=Array(); 
            $("input:checkbox[name=scripts2]:checked").each(function(){
                ch_list.push($(this).val());
            }); 
            return ch_list; 
        }
        function get_menu_system(){ 
            var ch_list=Array(); 
            $("input:checkbox[name=scripts3]:checked").each(function(){
                ch_list.push($(this).val());
            }); 
            return ch_list; 
        }
    	$('#edit_data').click(function(){
    	    var menu = get_menu_master();
            var menu1 = get_menu_account();
            var menu2 = get_menu_request();
            var menu3 = get_menu_system();
            document.getElementById("edit_data").disabled = true;
    		$.post("{{ route('api-update-data') }}", {
    		    grade_code      : $('#grade_code').val(),
                grade_desc      : $('#grade_desc').val(),
                menu_master  	: menu,
                menu_account  	: menu1,
                menu_request  	: menu2,
                menu_system  	: menu3,
    		    id_user         : '{{ $id_user }}',
                name            : $('#name').val(),
                email           : $('#email').val(),
                password        : $('#password').val(),
                phoneno         : $('#phoneno').val(),
                alamat          : $('#alamat').val(),
                user_level_id   : $('#user_level_id').val(),
                notif_email     : $('#notif_email').val(),
                seller_adm_id   : $('#seller_adm_id').val(),
                param           : "{{ $param }}",
                _token    	: '{{ Session::token() }}'
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